<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show user details

    public function show(Request $request):JsonResponse {
        return response()->json([$request->user()], 200);
    }

    public function update(Request $request):JsonResponse{

        $user = $request->user();
        logger()->info('Updating profile for user', ['user' => $user]);

        $validatedData = $request->validate(
            [
                'name'=> 'required|string|max:256',
                'phone'=>'nullable|string|max:12',
                'address' => 'nullable|string|max:255'
            ]);

            $user->update($validatedData);

            return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    }

    public function changePassword(Request $request): JsonResponse{
        $Data = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed|min:8',
        ]);

        $user = $request->user();

        if (!Hash::check($Data['current_password'], $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 403);
        }

        $user->update(['password' => Hash::make($Data['new_password'])]);

        return response()->json(['message => Password updated successfuly!!']);
    }
}
