<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
   public function updateSettings(Request $request)
   {
    // we ;pp[ through the data sent from React

    foreach($request->all() as $key => $value){
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    return response()->json([
        'message' => 'Settings updated successfully'
    ]);
   }
}
