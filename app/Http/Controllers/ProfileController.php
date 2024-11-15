<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Appearance;
use App\Models\Listing;
use App\Models\SocialIcon;
use App\Models\UserDetail;
use App\Models\PremiumUser;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Rules\MaxProfileRule;

class ProfileController extends Controller
{
    
    //Display all users
    public function userList()
    {
        $users = User::all();
        return view('pages.users', ['users' => $users]);
    }
    
    public function allowUser(Request $request){
        // Validate the request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'user_type' => 'required|in:free,pro,premium',
        ]);
    
        // Update or create a record in the user_details table
        UserDetail::updateOrCreate(
            ['user_id' => $request->user_id],
            ['user_type' => $request->user_type]
        );
    
        return redirect()->back()->with('success', 'User detail created/updated successfully.');
    }
    
    public function storeProfile(Request $request) {
        $user = auth()->user();
        if( $user->userDetail->user_type != 'premium' ){
            return redirect()->back()->with('error', 'Not a premium user');
        }
        $validated = $request->validate([
            'url_slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[^\s\/]+$/',
                Rule::unique('appearances'),
                Rule::notIn(config('reserved_keywords.url_slug')),
                new MaxProfileRule($user->id),
            ],
            'profile_title' => 'nullable|string',
        ],['url_slug.regex' => 'Spaces and slash are not allowed.']);
        
        try{
            
            $url_slug = strtolower($validated['url_slug']);
            
            $appearance = new Appearance([
                'url_slug' => $url_slug,
                'profile_title' => $validated['profile_title'],
            ]);
            $listing = new Listing([
                'url_slug' => $url_slug
            ]);
            $socialIcon = new SocialIcon([
                'url_slug' => $url_slug
            ]);
        
            // Associate the appearance with the authenticated user
            auth()->user()->appearances()->save($appearance);
            auth()->user()->listings()->save($listing);
            auth()->user()->socialIcons()->save($socialIcon);
    
            // return redirect()->route('profilelists')->with('success', 'Profile created successfully!');
            
            session(['current_profile_id' => $request->input('profileId')]);
            $url_slug = Appearance::find($request->profileId)->url_slug;
            $id = Listing::where('url_slug', $url_slug)->first()->id;
            
            return redirect()->route('edit.listing', $id);
        }  catch(\Exception $e){
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
    
    //Switch Profile
    public function changeProfile(Request $request) {
        $request->validate([
            'profileId' => 'required|exists:appearances,id,user_id,' . auth()->id(),
        ]);
        session(['current_profile_id' => $request->input('profileId')]);
        $url_slug = Appearance::find($request->profileId)->url_slug;
        $id = Listing::where('url_slug', $url_slug)->first()->id;
        return redirect()->route('edit.listing', $id);
    }
    
    /**
     * Display the dashboard page.
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        $id = $user->listings()->first()->id;
        return redirect()->route('edit.listing', $id);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    
    // Generate qr code using url slug
    public function generateQrCode(Request $request)
    {
        $user = auth()->user();
        $current_profile_id = session('current_profile_id');
        $appearance = Appearance::where('user_id', $user->id)->findOrFail($current_profile_id);
        
        $url_slug = $appearance->url_slug;
        $url = config('app.url') . $url_slug;

        // delete .png as well as .svg
        if($appearance && $appearance->qr_image){
            Storage::delete('public/'.$appearance->qr_image);
        }
        
        $logoUrl = Storage::get('public/'.$appearance->logo);
        if($appearance && $appearance->logo){
            $qrCodePNG = QrCode::size(350)
                ->style('square')
                ->eye('square')
                ->eyeColor(0, 217, 40, 39, 217, 40, 39)
                ->eyeColor(1, 217, 40, 39, 217, 40, 39)
                ->eyeColor(2, 217, 40, 39, 217, 40, 39)
                ->color(0, 0, 0)
                ->margin(1)
                ->mergeString($logoUrl, .2, true)
                ->errorCorrection('H')
                ->format('png')
                ->generate($url);
        } else{
            $qrCodePNG = QrCode::size(350)
                ->style('square')
                ->eye('square')
                ->eyeColor(0, 217, 40, 39, 217, 40, 39)
                ->eyeColor(1, 217, 40, 39, 217, 40, 39)
                ->eyeColor(2, 217, 40, 39, 217, 40, 39)
                ->color(0, 0, 0)
                ->margin(1)
                ->format('png')
                ->generate($url);
        }

        $pngImagePath = 'qr_codes/' . uniqid($url_slug.'_') . '.png';
        // $pngImagePath = 'qr_codes/' . $url_slug . '_QR_Code' . '.png';
        Storage::disk('public')->put($pngImagePath, $qrCodePNG);
        
        $appearance->qr_image = $pngImagePath;
        $appearance->save();

        return response()->json([
            'pathPNG' => 'storage/'.$pngImagePath,
            'profile_url' => $url,
            'url_slug' => $url_slug
        ]);
    }
    
}
