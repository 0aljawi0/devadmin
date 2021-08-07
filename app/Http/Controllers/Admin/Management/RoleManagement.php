<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Models\Manage;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleManagement extends Controller
{
    public function index()
    {
        $sort = request()->sort ?? 'created_at';
        $sortBy = request()->sort_by ?? 'desc';

        $roles = Role::orderBy($sort, $sortBy)
                    ->with('manages')
                    ->paginate('10');

        return Inertia::render('Management/RoleManagement', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:30'
        ]);

        $id = Role::create($request->all())->id;
        $this->attachManage($id);

        return $this->comeback('Role added successfully');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'title' => 'required|string|max:30'
        ]);

        $role->fill($request->all())->save();
        return $this->comeback('Role changed successfully');
    }

    public function destroy(Role $role)
    {
        if (sizeof($role->users) > 0) {
            return $this->comeback('Role cannot be deleted, because it is being used', false);
        } else {
            $role->manages()->detach();
            $role->delete();
            return $this->comeback('Role deleted successfully');
        }
    }

    public function destroy_bulk(Request $request)
    {
        $count = 0;

        foreach ($request->check as $item) {
            $data = Role::find($item);

            if (sizeof($data->users) == 0) {
                $data->manages()->detach();
                $data->delete();
                $count++;
            }
        }

        return $this->comeback($count.' Role deleted successfully');
    }

    public function attachManage($role_id)
    {
        $role = Role::find($role_id);
        $manages = Manage::all();

        foreach($manages as $item) {
            $role->manages()->attach($item->id);
        }
    }

    public function update_manage(Request $request, Manage $manage)
    {
        $manage->roles()->updateExistingPivot($request->role_id, [
            'read' => $request->read,
            'add' => $request->add,
            'update' => $request->update,
            'delete' => $request->delete,
        ]);
        return $this->comeback('Manage changed successfully');
    }

}
