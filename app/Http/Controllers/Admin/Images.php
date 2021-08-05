<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Role;
use App\Traits\UploadImage;
use Inertia\Inertia;

class Images extends Controller
{
    public function index()
    {
        $images = Image::latest()->paginate(12);
        $roles = Role::where('id', Auth::user()->role_id)->with('manages', function($query){ $query->where('menu', 'image'); })->first();

        return Inertia::render('Settings/Image', [
            'images' => $images,
            'roles' => Auth::user()->role_id == 0 ? $this->administratorManage() : $roles,
            'asset' => asset('storage')
        ]);
    }

    public function store(Request $request)
    {
        foreach($request->file('image') as $image) {
            $img = UploadImage::upload($image);
            $img['size'] = $this->formatBytes((float)$img['size']);
            Image::create($img);
        }

        return $this->comeback('Image added successfully');
    }

    public function destroy(Image $image)
    {
        UploadImage::delete($image->image);
        $image->delete();
        return $this->comeback('Image deleted successfully');
    }
}
