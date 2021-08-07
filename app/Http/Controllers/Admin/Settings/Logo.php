<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Role;
use Inertia\Inertia;

class Logo extends Controller
{
    public function index()
    {
        $logo = Option::firstWhere('key','logo');
        $roles = Role::where('id', Auth::user()->role_id)->with('manages', function ($query) {
            $query->where('menu', 'logo');
        })->first();

        return Inertia::render('Settings/Logo', [
            'logo' => $logo,
            'roles' => Auth::user()->role_id == 0 ? $this->administratorManage() : $roles,
            'asset' => asset('storage'),
        ]);
    }

    public function update(Request $request, Option $option)
    {
        $request->validate([
            'favicon' => 'required',
            'logo_dark' => 'required',
            'logo_light' => 'required'
        ]);

        if ($option) $option->fill(['value' => json_encode($request->all())])->save();
        else Option::create(['key' => 'logo', 'value' => json_encode($request->all())]);

        return $this->comeback('Logo changed successfully');
    }
}
