<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function show($id){
        // send the listing from database
        $user = auth()->user();
        
        $listing = Listing::where('user_id', $user->id)->findOrFail($id);
        if($listing){
            $url_slug = $listing->url_slug;
            $decodedData = json_decode($listing->list, true);
            if ($decodedData) {
                uasort($decodedData, function ($a, $b) {
                    return $a['priority'] <=> $b['priority'];
                });
                // dd($decodedData);
                $decodedData = json_encode($decodedData);
                $decodedData = json_decode($decodedData);
            }
        }
        else{
            $decodedData = null;
        }
        
        $userDetails = $user->userDetail;

        return view('pages.listings', compact('user', 'userDetails', 'decodedData', 'url_slug', 'id'));
    }

    public function create(Request $request){
        // $user_id = auth()->user()->id;
        $listing = Listing::find($request->id);

        if( $listing && $listing->list != null ){
            $decodedData = json_decode($listing->list, true);
            $title = $request->title;
            $url = $request->url;
            $uniqueId = Str::random(7);
            $count = count($decodedData);
            $decodedData[$uniqueId] = ["title"=> $title, "url" => $url, "visibility" => "true" , "thumbnail" => null, "priority"=> $count+1 ];
            $listing->update(['list' => $decodedData]);
        }
        elseif($listing->list == null){
            $title = $request->title;
            $url = $request->url;
            $uniqueId = Str::random(7);
            $decodedData[$uniqueId] = ["title"=> $title, "url" => $url, "visibility" => "true" , "thumbnail" => null, "priority"=>1];
            $listing->update(['list' => $decodedData]);
        }
        else{
            $listing = new Listing();
            $listing->user_id = auth()->user()->id;
            $title = $request->title;
            $url = $request->url;
            $uniqueId = Str::random(7);
            $data = [
                $uniqueId => ["title"=> $title, "url" => $url, "visibility" => "true" , "thumbnail" => null, "priority"=>1]
            ];
        
            $listing->list =json_encode($data);
            $listing->save();

        }
        
        return redirect()->back();
    }

    public function update(Request $request){
        // $user = auth()->user();

        // $appearance = $user->appearance()->firstOrNew();
        // $url_slug = $appearance->url_slug;

        $list = json_encode($request->list);
        $listing = Listing::find($request->id);
        $url_slug = $listing->url_slug;
        
        if ($listing) {
            $listing->update(['list' => $list]);
            return response()->json(['message' => 'List updated successfully', 'url_slug' => $url_slug], 200);
        }
        return response()->json(['message' => 'Error in updating list', 'url_slug' => $url_slug], 400);
    }

    public function delete(Request $request){
        // $user = auth()->user();
        $listing = Listing::find($request->id);
        $data = json_decode($listing->list, true);
        $key = $request->key;
        // $appearance = $user->appearance()->firstOrNew();
        // $url_slug = $appearance->url_slug;
        $url_slug = $listing->url_slug;

        if (isset($data[$key])) {
            $key_priority = $data[$key]['priority'];
            
            for($i = $key_priority; $i < count($data); $i++){
                $searchedItems = array_filter($data, function ($item) use ($i) {
                                    return $item['priority'] == $i+1;
                                });
                                
                $keys = array_keys($searchedItems);
                $firstKey = $keys[0];
                $data[$firstKey]['priority'] = $i;
            }
            
            unset($data[$key]);    
            $listing->list = json_encode($data);
            $listing->save();
            return response()->json(['message' => "List deleted successfully", 'url_slug' => $url_slug], 200);
        }

        return response()->json(['error' => 'Key not found'], 404);
    }
    // Hide and show links
    public function linksVisibility(Request $request){
        // $user = auth()->user();
        // $listing = Listing::where('user_id', $user->id)->first();
        $listing = Listing::find($request->id);
        $data = json_decode($listing->list);
        $key = $request->key;
        $url_slug = $listing->url_slug;
        // $appearance = $user->appearance()->firstOrNew();
        // $url_slug = $appearance->url_slug;
        if (isset($data-> $key)) {
            if (isset($data->$key->visibility)){
                if($data->$key->visibility == "true"){
                    $data->$key->visibility = "false";
                }
                else{
                    $data->$key->visibility = "true";
                }
            }
            else{
                $data->$key->visibility = "false";
            }
            $listing->list = json_encode($data);
            $listing->save();
            return response()->json(['message' => "Visibility updated successfully", 'url_slug' => $url_slug], 200);
        }
        return response()->json(['error' => 'key not found'], 404);
    }
    
    public function uploadThumbnail(Request $request){
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'key' => 'nullable|string|max:255'
        ]);
        if( $request->has('key') ){
            // $user = auth()->user();
            // $listing = Listing::where('user_id', $user->id)->first();
            $listing = Listing::find($request->id);
            $data = json_decode($listing->list);
            $key = $request->key;
            // $appearance = $user->appearance()->firstOrNew();
            // $url_slug = $appearance->url_slug;
            $url_slug = $listing->url_slug;
            if ($request->hasFile('thumbnail')) {
                $imagePath = $request->file('thumbnail')->store('thumbnail-images', 'public');
                $data->$key->thumbnail = $imagePath;
            }
            $listing->list = json_encode($data);
            $listing->save();
            return response()->json(['message' => "Image uploaded successfully", 'url_slug' => $url_slug, 'thumbnailUrl' => $data->$key->thumbnail], 200);
        }
        return response()->json(['error' => 'key not found'], 404);
    }
    
    public function removeThumbnail(Request $request){
        $request->validate([
            'key' => 'nullable|string|max:255'
        ]);
        if( $request->has('key') ){
            // $user = auth()->user();
            // $listing = Listing::where('user_id', $user->id)->first();
            $listing = Listing::find($request->id);
            $data = json_decode($listing->list);
            $key = $request->key;
            // $appearance = $user->appearance()->firstOrNew();
            // $url_slug = $appearance->url_slug;
            $url_slug = $listing->url_slug;

            if ( $data->$key && $data->$key->thumbnail ) {
                Storage::delete('public/' . $data->$key->thumbnail);
    
                $data->$key->thumbnail = null;
            }
            $listing->list = json_encode($data);
            $listing->save();

            return response()->json(['message' => "Image uploaded successfully", 'url_slug' => $url_slug, 'thumbnailUrl' => $data->$key->thumbnail], 200);
        }
        return response()->json(['error' => 'key not found'], 404);
    }
}
