<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
   public function updateSettings(Request $request)
   {
    // 1. Handle text settings first
        $textData =$request->only(['app_name', 'primary_color' ]);

        foreach($textData as $key => $value){

        if($key === 'password' && !empty($value)){
            $value = Hash::make($value);
        }
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);



    }

    //2. Handle Image with upload logic

    if($request->hasFile('app_logo')){
        //get list

        $file = $request->file('app_logo');
        /* Using a helper or library logic:
           We store it in a 'logos' folder.
           'public' is used for local development.
        */

           $path = $file->storage('logos', 'public');

           // 3. save the path to your key-value table
           Setting::updateOrCreate(
            ['key' => 'app_logo' ],
            ['value' => $path]
           );

    }
    return response()->json([
        'message' => 'Settings updated successfully'
    ]);
   }

   public function updateProfileSetting(Request $request)
   {

        // Get the current logged-in user
        $user = Auth::user();

            
        // Check if user exists (to avoid 'save' on null error)
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $request->validate([
            'owner_name' =>'required|string',
            'owner_email' =>'required|email|unique:user,email,' .$user->id,
            'password' =>'required|string|min:6',
        ]);

        // Update the user

        $user->name = $request->owner_name;
        $user->email = $request->owner_email;

        // only update password if a new one is provided

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        $user->save();

       return response()->json([
        'message' => 'Profile updated successfully!',
        'user' => $user
    ]);
   }
}
