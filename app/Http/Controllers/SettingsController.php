<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    //
    public function view(Settings $model)
    {
        if ($model->all()->count() > 0)
        {
            $model = Settings::find(1);
        }

        return view('admin.settings.view',compact('model'));
    }

    public function update(Request $request)
    {
        if (Settings::all()->count() > 0)
        {
            Settings::find(1)->update($request->all());
        }else{
            Settings::create($request->all());
        }

        flash()->success('تم الحفظ بنجاح');
        return back();
    }
}
