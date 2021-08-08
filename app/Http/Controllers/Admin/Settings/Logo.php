<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\LogoRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Option;
use App\Models\Role;
use Inertia\Inertia;

class Logo extends Controller
{
    public function index()
    {
        $logo = Option::select('id', 'value')->firstWhere('key','logo');
        $roles = Role::where('id', Auth::user()->role_id)->with('manages', function ($query) {
            $query->where('menu', 'logo');
        })->first();

        return Inertia::render('Settings/Logo', [
            'logo' => $logo,
            'roles' => Auth::user()->role_id == 0 ? $this->administratorManage() : $roles,
            'asset' => asset('storage'),
        ]);
    }

    public function update(LogoRequest $request)
    {
        $validated = $request->validated();
        $option = Option::find(request()->id ?? 0);

        if ($option) {
            $option->fill([
                'value' => $validated
            ])->save();
        } else {
            Option::create([
                'key' => 'logo',
                'value' => $validated
            ]);
        }

        return $this->comeback('Logo changed successfully');
    }
}
