<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $setting = Setting::first();
        return view('settings',compact('setting'));
    }

    public function update(Request $request){
        $setting = Setting::find(1);
        $setting->isUtility = isset($request->utility) ? $request->utility : 0;
        $setting->isCooker = isset($request->cook) ? $request->cook : 0;
        $setting->save();
        return redirect()->back()->with(['message' => 'Setting Updated Successfully']);
        dd($request->all());
    }
}
