<?php

namespace App\Http\Controllers;

use App\Models\Following;
use Illuminate\Http\Request;

class FollowingsController extends Controller
{
    public function followUser(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'following_id' => 'required|integer',
        ]);

        // Get the authenticated user
        $follower = auth()->user();

        // Check if the user is already following the target user
        $following = $follower->followings()->where('following_id', $validatedData['following_id'])->first();

        if ($following) {
            // The user is already following the target user
            return response()->json([
                'error' => 'You are already following this user.',
            ], 400);
        } else {
            // Create a new follow relationship
            $following = new Following([
                'follower_id' => auth()->id(),
                'following_id' => $validatedData['following_id'],
            ]);

            // Save the follow relationship
            $following->save();

            // Return a success response
            return response()->json([
                'message' => 'Successfully followed user.',
            ], 200);
        }
    }
}
