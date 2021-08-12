<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\PagesRequest;
use App\Models\Page;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Pages extends Controller
{
    public function index()
    {
        $pages = Page::latest('updated_at')->paginate(10);
        $roles = Role::where('id', Auth::user()->role_id)->with('manages', function ($query) {
            $query->where('pages', 'logo');
        })->first();

        return Inertia::render('Settings/PagesIndex', [
            'pages' => $pages,
            'roles' => Auth::user()->role_id == 0 ? $this->administratorManage() : $roles,
            'asset' => asset('storage'),
        ]);
    }

    public function action()
    {
        $id = request()->id ?? 0;
        $page = Page::find($id);
        return Inertia::render('Settings/PagesAction', [
            'page' => $page, 
            'asset' => asset('storage')
        ]);
    }

    public function store(PagesRequest $request)    
    {
        Page::create($request->validated());
        return $this->routeback('pages.index', 'Page added successfully');
    }

    public function update(PagesRequest $request, Page $page)
    {
        $page->fill($request->validated())->save();
        return $this->routeback('pages.index', 'Page changed successfully');
    }

    public function update_status()
    {
        $page = Page::findOrFail(request()->id);

        if ($page->status == 'Draft') $page->fill(['status' => 'Publish'])->save();
        else $page->fill(['status' => 'Draft'])->save();
        
        return $this->comeback('Page status changed successfully');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return $this->comeback('Page deleted successfully');
    }

    public function destroy_bulk(Request $request)
    {
        $count = 0;

        foreach ($request->check as $item) {
            $data = Page::find($item);
            $data->delete();
            $count++;
        }

        return $this->comeback($count . ' Page deleted successfully');
    }
}
