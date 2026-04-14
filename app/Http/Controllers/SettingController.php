<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
   public function updateSettings(Request $request)
   {
    // 1. Handle text settings first
        $textData =$request->only(['app_name', 'primary_color' , 'owner_name', 'owner_email' , 'password']);

    foreach($textData as $key => $value){

    if($key === 'password' && !empty($value)){
        $value = Hash::make($value);
    }
       Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    //2. Handle Image with upload logic

    if($request->hasFile('app_logo')){
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
}
