<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'app_name' => 'nullable|string', 
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'user_name' => 'nullable|string', 
            'email' => 'nullable|email'
        ]);

        $logoPath = null; 

        if($request->hasFile('logo')){
            $logoPath = $request->file('logo')->store('logos', 'public'); 
        }

        $setting = Setting::create([
            'app_name' => $request->app_name, 
            'logo' => $logoPath,
            'user_name' => $request->user_name,
            'email' => $request->email
        ]);

        return response()->json([
            'message' => 'Settings saved successfully',
            'data' => $setting
        ]); 
    }
}
