<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Appearance;
use App\Models\Listing;
use App\Models\SocialIcon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class ThemeController extends Controller
{
    //Display appearance page
    public function addEditAppearance($id) {
        $user = auth()->user();
        $appearance = Appearance::where('user_id', $user->id)->findOrFail($id);
        // Check if appearance data exists
        if (!$appearance->exists || $appearance->custom === null) {
            $defaultCustomData = [
                'backgroundColor' => '#2abfe5',
                'backgroundType' => 'flat',
                'buttonColor' => '#EAF08E',
                'fontColor' => '#000000',
                'lastBackgroundColor' => '#2abfe5',
                'font' => 'Arial',
                'gradientDirection' => 'to right'
            ];

            // Set the default custom data for a new appearance record
            $appearance->custom = json_encode($defaultCustomData);
            $appearance->save();
        }

        // Check if appearance data exists
        if ($appearance) {
            $appearanceData = [
                'url_slug' => $appearance->url_slug ?? null,
                'image' => $appearance->image ?? null,
                'profile_title' => $appearance->profile_title ?? null,
                'bio' => $appearance->bio ?? null,
                'theme' => $appearance->theme ?? null,
                'custom' => ($appearance->theme === 'custom') ? json_decode($appearance->custom, true) : null,
            ];
        } else {
            $appearanceData = [
                'url_slug' => null,
                'image' => null,
                'profile_title' => null,
                'bio' => null,
                'theme' => null,
                'custom' => null,
            ];
        }
        
        return view('pages.appearance', compact('user','appearance', 'appearanceData'));
    }

    //Update profile appearance
    public function updateAppearance(Request $request)
    {
        $user = auth()->user();
        $appearanceId = $request->appearanceId;
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[^\s\/]+$/',
                Rule::unique('appearances')->ignore($appearanceId),
                Rule::notIn(config('reserved_keywords.url_slug')),
            ],
            'profile_title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ],['url_slug.regex' => 'Spaces and slash are not allowed.']);
        
        
        $appearance = Appearance::where('user_id', $user->id)->findOrFail($appearanceId);
        // Handle image upload and save the file path to the 'image' field
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile-images', 'public');
            $appearance->image = $imagePath;
        }
        
        // Assign values directly from the request, if present
        $appearance->url_slug = $request->input('url_slug', $appearance->url_slug);
        $appearance->profile_title = $request->input('profile_title', $appearance->profile_title);
        $appearance->bio = $request->input('bio', $appearance->bio);
    
        $appearance->save();
        
        $listing = Listing::where('user_id', $user->id)->findOrFail($appearanceId);
        $listing->url_slug = $request->input('url_slug', $appearance->url_slug);
        $listing->save(); 
        $socialIcon = SocialIcon::where('user_id', $user->id)->findOrFail($appearanceId);
        $socialIcon->url_slug = $request->input('url_slug', $appearance->url_slug);
        $socialIcon->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'image' => $appearance->image,
            'url_slug' => $appearance->url_slug,
            'profile_title' => $appearance->profile_title,
            'bio' => $appearance->bio,
        ]);
    }

    public function removeProfileImage(Request $request)
    {
        $user = auth()->user();
        $appearanceId = $request->appearanceId;
        $appearance = Appearance::where('user_id', $user->id)->findOrFail($appearanceId);

        // Remove the image file if it exists
        if ($appearance && $appearance->image) {
            Storage::delete('public/' . $appearance->image);

            $appearance->image = null;
            $appearance->save();
        }

        return response()->json([
            'message' => 'Profile image removed successfully',
            'profile_title' => $appearance->profile_title,
            'bio' => $appearance->bio,
            'url_slug' => $appearance->url_slug,
        ]);
    }

    //Profile sharing page
    public function index($urlSlug = null)
    {
        // If $urlSlug is provided, attempt to find the user by the given url_slug
        if ($urlSlug) {
            $user = User::whereHas('appearances', function ($query) use ($urlSlug) {
                $query->where('url_slug', $urlSlug);
            })->first();

            if ($user) {
                $appearance = $user->appearances->where('url_slug', $urlSlug)->first();
                $customColor = json_decode($appearance->custom);
                $theme = $appearance->theme;
                
                $profile_image = $appearance->image;
                $title = $appearance->profile_title;
                $bio = $appearance->bio;
                $listing = $user->listings->where('url_slug', $urlSlug)->first();
                $socialIcons = $user->socialIcons()->where('url_slug', $urlSlug)->first();
                if($socialIcons){
                    $socialIcons = json_decode($socialIcons->icon, true);
                }
                
                if ($listing) {
                    // $data = json_decode($listing->list);
                    $decodedData = json_decode($listing->list, true);
                    if ($decodedData) {
                        uasort($decodedData, function ($a, $b) {
                            return $a['priority'] <=> $b['priority'];
                        });
                        // dd($decodedData);
                        $decodedData = json_encode($decodedData);
                        $data = json_decode($decodedData);
                    }
                    else{
                        $data = null;
                    }
                } else {
                    $data = null;
                }
                return view('themes.index', compact('theme', 'data', 'socialIcons', 'profile_image', 'title', 'bio', 'urlSlug', 'customColor'));
            }
        }

        // If $urlSlug is not provided or the user is not found, use the default theme
        $defaultTheme = 'default';
        return view('themes.notFound', compact('defaultTheme'));
    }

    //Update theme
    public function setTheme(Request $request)
    {
        try {
            $user = auth()->user();
            $theme = $request->input('theme');
            $appearanceId = $request->appearanceId;
            $appearance = Appearance::where('user_id', $user->id)->findOrFail($appearanceId);

            // Update the user's appearance theme
            $appearance->update(['theme' => $theme]);
            $existingCustomData = json_decode($appearance->custom, true);
            $customJson = json_encode($existingCustomData);
            
            // Update appearance record
            $appearance->update(['custom' => $customJson]);
            $url_slug = $appearance->url_slug;

            // Return a JSON response indicating success
            return response()->json(['status' => 'success', 'theme' => $theme, 'url_slug' => $url_slug, 'existingCustomData' => $existingCustomData]);
        } catch (\Exception $e) {
            // Return a JSON response indicating failure in case of an exception
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    //Update theme data
    public function setCustomTheme(Request $request){
        try {
            $user = auth()->user();
            $appearanceId = $request->appearanceId;
            $appearance = Appearance::where('user_id', $user->id)->findOrFail($appearanceId);
            $url_slug = $appearance->url_slug;
            
            // Get existing custom data or create an empty array
            $existingCustomData = json_decode($appearance->custom, true);

            // Get color values from the request
            $backgroundColor = $request->input('backgroundColor');
            $buttonColor = $request->input('buttonColor');
            $fontColor = $request->input('fontColor');
            $backgroundType = $request->input('backgroundType');
            $lastBackgroundColor = $request->input('backgroundColor');
            $gradientDirection = $request->input('gradientDirection') ?? 'to right';
            $selectedFont = $request->input('font');

            function hexToRgb($hex)
            {
                // Remove the hash sign if it's present
                $hex = str_replace("#", "", $hex);

                // Convert each component to decimal
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));

                // Return an array with RGB values
                return array($r, $g, $b);
            }

            if ($backgroundType === 'gradient') {
                $rgbColor = hexToRgb($backgroundColor);

                // Calculate a lighter version of the color (adjust the factor based on your preference)
                $lightnessFactor = 0.8; // You can adjust this value
                $lighterR = $rgbColor[0] + ($lightnessFactor * (255 - $rgbColor[0]));
                $lighterG = $rgbColor[1] + ($lightnessFactor * (255 - $rgbColor[1]));
                $lighterB = $rgbColor[2] + ($lightnessFactor * (255 - $rgbColor[2]));

                // Ensure values are in the valid range (0-255)
                $lighterR = min(255, $lighterR);
                $lighterG = min(255, $lighterG);
                $lighterB = min(255, $lighterB);

                // Create the lighter background color
                $lighterBackgroundColor = "rgba($lighterR, $lighterG, $lighterB, 1)";
                $backgroundColor = "linear-gradient($gradientDirection, $backgroundColor, $lighterBackgroundColor)";
            }

            // Update the existing custom data with the new values
            $existingCustomData['backgroundColor'] = $backgroundColor ?? '';
            $existingCustomData['backgroundType'] = $backgroundType ?? '';
            $existingCustomData['buttonColor'] = $buttonColor ?? '';
            $existingCustomData['fontColor'] = $fontColor ?? '';
            $existingCustomData['lastBackgroundColor'] = $lastBackgroundColor ?? '';
            $existingCustomData['gradientDirection'] = $gradientDirection ?? '';
            $existingCustomData['font'] = $selectedFont ?? '';

            // Convert updated custom data into JSON format
            $customJson = json_encode($existingCustomData);
            // Update appearance record
            $appearance->update(['custom' => $customJson]);
            
            // Return a JSON response indicating success
            return response()->json(['status' => 'success', 'url_slug' => $url_slug, 'existingCustomData' => $existingCustomData]);
        } catch (\Exception $e) {
            // Return a JSON response indicating failure in case of an exception
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
}
