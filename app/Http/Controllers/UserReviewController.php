<?php

namespace App\Http\Controllers;

use App\Models\UserReview;
use App\Http\Requests\StoreUserReviewRequest;
use App\Http\Requests\UpdateUserReviewRequest;
use Illuminate\Support\Facades\Request;

class UserReviewController extends Controller
{

    public function userReview(Request $request, $user_id)
    {
        try {
            // Step 1: Validate the user ID (optional)
            if (!is_numeric($user_id)) {
                return response()->json(['error' => 'Invalid user ID'], 400);
            }

            // Step 2: Fetch the user's reviews
            $reviews = UserReview::where('user_id', $user_id)->get();

            // Step 3: Check if reviews exist
            if ($reviews->isEmpty()) {
                return response()->json(['message' => 'No reviews found for this user'], 404);
            }

            // Step 4: Return the reviews as JSON
            return response()->json([
                'success' => true,
                'user_id' => $user_id,
                'reviews' => $reviews
            ], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching reviews',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
