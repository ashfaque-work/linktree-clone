<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appearance;
use App\Models\SocialIcon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SocialIconController extends Controller
{
    //Display Icon Create Form
    public function index($id)
    {
        $user = auth()->user();
        $appearance = Appearance::where('user_id', $user->id)->findOrFail($id);
        $socialIcon = SocialIcon::where('user_id', $user->id)->findOrFail($id);
        $url_slug = $socialIcon->url_slug;

        if ($socialIcon) {
            $socialIcons = json_decode($socialIcon->icon, true) ?? [];
        }
        return view('pages.settings', compact('socialIcons', 'appearance', 'url_slug', 'user'));
    }

    //Create Icon
    public function store(Request $request)
    {
        // Validate the request if necessary
        $user = auth()->user();
        $current_profile_id = session('current_profile_id');
        $socialIcon = SocialIcon::where('user_id', $user->id)->findOrFail($current_profile_id);
        $url_slug = $socialIcon->url_slug;
        $socialIconsData = $request->input('socialIconsData');

        // Get the current icon data
        $iconData = json_decode($socialIcon->icon, true) ?? [];

        // Make sure $socialIconsData is an array before merging
        $socialIconsData = is_array($socialIconsData) ? $socialIconsData : [];

        // Merge the received social icons data with the existing icon data
        $iconData = array_merge($iconData, $socialIconsData);

        // Set a default status for new icons (e.g., true for enabled)
        foreach ($iconData as &$icon) {
            if (!isset($icon['status'])) {
                $icon['status'] = true; // Set your default status here
            }
        }

        // Sort the $iconData array based on priorities
        uasort($iconData, function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        // Reassign priorities based on the sorted order
        $index = 1;
        foreach ($iconData as &$icon) {
            $icon['priority'] = $index++;
        }

        // Save the updated icon data back to the socialIcons model
        $socialIcon->icon = json_encode($iconData);

        // Save the socialIcons model to the database
        $user->socialIcons()->save($socialIcon);

        // Sending SocialIcons in response
        $socialIcons = json_decode($socialIcon->icon, true) ?? [];

        return response()->json([
            'status' => 'success',
            'message' => 'Social icon saved successfully',
            'url_slug' => $url_slug,
            'socialIcons' => $socialIcons
        ]);
    }

    //Edit Icon
    public function update(Request $request)
    {
        $user = auth()->user();
        $current_profile_id = session('current_profile_id');
        $socialIcon = SocialIcon::where('user_id', $user->id)->findOrFail($current_profile_id);
        $url_slug = $socialIcon->url_slug;

        $socialType = $request->input('socialType');
        $socialValue = $request->input('socialValue');
        $priority = $request->input('priority');
        $status = $request->input('status');

        $iconData = json_decode($socialIcon->icon, true) ?? [];

        // Update the icon data based on the received values
        $iconData[$socialType] = [
            'value' => $socialValue,
            'priority' => $priority,
            'status' => $status,
        ];

        // Save the updated icon data back to the socialIcons model
        $socialIcon->icon = json_encode($iconData);

        // Save the socialIcons model to the database
        $user->socialIcons()->save($socialIcon);

        // Sending SocialIcons in response
        $socialIcons = json_decode($socialIcon->icon, true) ?? [];

        return response()->json([
            'status' => 'success',
            'message' => 'Social icon updated successfully',
            'url_slug' => $url_slug,
            'socialIcons' => $socialIcons
        ]);
    }

    //Delete Icon
    public function delete(Request $request)
    {
        $user = auth()->user();
        $current_profile_id = session('current_profile_id');
        $socialIcon = SocialIcon::where('user_id', $user->id)->findOrFail($current_profile_id);
        $url_slug = $socialIcon->url_slug;

        $socialType = $request->input('socialType');

        $iconData = json_decode($socialIcon->icon, true) ?? [];

        // Remove the icon data based on the received social type
        unset($iconData[$socialType]);

        // Reassign priorities based on the sorted order
        uasort($iconData, function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        // Reassign priorities based on the sorted order
        $index = 1;
        foreach ($iconData as &$icon) {
            $icon['priority'] = $index++;
        }

        // Save the updated icon data back to the socialIcons model
        $socialIcon->icon = json_encode($iconData);

        // Save the socialIcons model to the database
        $user->socialIcons()->save($socialIcon);

        // Sending SocialIcons in response
        $socialIcons = json_decode($socialIcon->icon, true) ?? [];

        return response()->json([
            'status' => 'success',
            'message' => 'Social icon removed successfully',
            'url_slug' => $url_slug,
            'socialIcons' => $socialIcons
        ]);
    }
    
    // Upload QR code image
    public function uploadQrIcon(Request $request){
        try{
            $request->validate([
                'qrIcon' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $user = auth()->user();
            $current_profile_id = session('current_profile_id');
            $appearance = Appearance::where('user_id', $user->id)->findOrFail($current_profile_id);
            $url_slug = $appearance->url_slug;
            
            // delete qrIcon if exists
            if ($appearance && $appearance->logo) {
                Storage::delete('public/' . $appearance->logo);
    
                $appearance->logo = null;
                $appearance->save();
            }
            // Save request qrIcon
            if ($request->hasFile('qrIcon')) {
                $imagePath = $request->file('qrIcon')->store('qrIcon', 'public');
                $appearance->logo = $imagePath;
                $appearance->save();
            }
            return response()->json(['message'=>"Qr Icon Uploaded successfully", 'qrIcon' => $appearance->logo], 200);
        }
        catch(\Exception $e){
            return response()->json(['message'=>$e], 500);
        }
    }
    
    // Remove QR Icon
    public function deleteQrIcon()
    {
        $user = auth()->user();
        $current_profile_id = session('current_profile_id');
        $appearance = Appearance::where('user_id', $user->id)->findOrFail($current_profile_id);

        // Remove the image file if it exists
        if ($appearance && $appearance->logo) {
            Storage::delete('public/' . $appearance->logo);

            $appearance->logo = null;
            $appearance->save();
        }

        return response()->json([
            'message' => 'QR Icon removed successfully',
            'url_slug' => $appearance->url_slug,
        ]);
    }
}
