<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Appearance;

class SetCurrentIds
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !session()->has('current_profile_id')) {
            $user = Auth::user();
            
             // Ensure that the user has at least one appearance
            $appearance = $user->appearances()->firstOrNew();
            $reserved_keywords = config('reserved_keywords.url_slug');
            
            if (!$appearance->exists) {
                $username = strtolower($user->name);
                $proposedUrlSlug = str_replace(' ', '_', $username);
    
                if( in_array($proposedUrlSlug, $reserved_keywords) ){
                    $proposedUrlSlug = $proposedUrlSlug . '_' . rand(1000, 9999);
                }
                // Check if the proposed url_slug already exists
                while (Appearance::where('url_slug', $proposedUrlSlug)->exists()) {
                    // If it exists, append a random number to the user's name
                    $proposedUrlSlug = $proposedUrlSlug . '_' . rand(1000, 9999);
                }
                
                $appearance->url_slug = $proposedUrlSlug;
                $appearance->save();
    
                // Ensure that the user has at least one listing
                $listings = $user->listings()->firstOrNew(['url_slug' => $proposedUrlSlug]);
                $listings->save();
                
                // Ensure that the user has at least one Social Icon
                $socialIcon = $user->socialIcons()->firstOrNew(['url_slug' => $proposedUrlSlug]);
                $socialIcon->save();
                
                $userDetail = $user->userDetail()->firstOrNew(['user_id' => $user->id, 'user_type' => 'free']);
                $userDetail->save();
                
                session(['current_profile_id' => $appearance->id]);
            }
            else{
                session(['current_profile_id' => $user->appearances()->first()->id]);
            }
        }

        return $next($request);
    }
}
