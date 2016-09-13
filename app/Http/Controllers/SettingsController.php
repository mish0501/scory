<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subject;
use App\Partition;
use App\Invite;
use App\Question;
use App\Answer;
use App\User;
use App\Role;
use App\Permission;

class SettingsController extends Controller
{
  public function users()
  {
    $users = User::all();

    foreach ($users as $key => $user) {
      $role = $user->roles()->get()[0];
      $users[$key]['role'] = $role;
    }

    return view('admin.settings.users.index', ['users' => $users]);
  }

  public function editUsers($id)
  {
    $user = User::find($id);
    $role = $user->roles()->get()[0];
    $user['role'] = $role;

    $roles = Role::all();

    return view('admin.settings.users.edit', ['user' => $user, 'roles' => $roles]);
  }

  public function updateUsers(Request $request, $id)
  {
    $this->validate($request,[
      'name' => 'required|exists:users,name',
      'email' => 'required|exists:users,email',
      'role' => 'required'
    ]);

    $name = $request->get('name');
    $email = $request->get('email');
    $role = $request->get('role');

    $user = User::find($id);

    $user->roles()->sync([$role]);

    \Session::flash('flash_message', 'Ролята на потребителя беше успешно зададена!');

    return redirect()->route('admin.settings.users.index');
  }

  public function permissions()
  {
    $permissions = Permission::all();

    return view('admin.settings.permissions.index', ['permissions' => $permissions]);
  }

  public function createPermissions()
  {
    return view('admin.settings.permissions.create');
  }

  public function storePermissions(Request $request)
  {
    $this->validate($request,[
      'display_name' => 'required|min:5',
      'name' => 'required|min:5',
      'description' => 'required|min:15',
    ]);

    $permission = new Permission();
    $permission->name = $request->get('name');
    $permission->display_name = $request->get('display_name');
    $permission->description  = $request->get('description');
    $permission->save();

    \Session::flash('flash_message', 'Правото беше успешно създадено!');

    return redirect()->route('admin.settings.permissions.index');
  }

  public function editPermissions($id)
  {
    $permission = Permission::find($id);

    return view('admin.settings.permissions.edit', ['permission' => $permission]);
  }

  public function updatePermissions(Request $request, $id)
  {
    $permission = Permission::find($id);

    $this->validate($request,[
      'display_name' => 'required',
      'name' => 'required',
      'description' => 'required'
    ]);

    $input['name'] = $request->get('name');
    $input['display_name'] = $request->get('display_name');
    $input['description'] = $request->get('description');

    $permission->fill($input)->save();

    \Session::flash('flash_message', 'Правото беше успешно редактирано!');

    return redirect()->route('admin.settings.permissions.index');
  }

  public function roles()
  {
    $roles = Role::all();

    return view('admin.settings.roles.index', ['roles' => $roles]);
  }

  public function createRoles()
  {
    $permissions = Permission::all();
    return view('admin.settings.roles.create', ['permissions' => $permissions]);
  }

  public function storeRoles(Request $request)
  {
    $this->validate($request,[
      'display_name' => 'required|min:5',
      'name' => 'required|min:5',
      'description' => 'required|min:15',
    ]);

    $permission = new Permission();
    $permission->name = $request->get('name');
    $permission->display_name = $request->get('display_name');
    $permission->description  = $request->get('description');
    $permission->save();

    \Session::flash('flash_message', 'Правото беше успешно създадено!');

    return redirect()->route('admin.settings.partitions.index');
  }

  public function editRoles($id)
  {
    $role = Role::find($id);
    $permissions = Permission::all();
    $rolePerms = $role->perms()->get();

    return view('admin.settings.roles.edit', ['role' => $role, 'permissions' => $permissions, 'rolePerms' => $rolePerms]);
  }

  public function updateRoles(Request $request, $id)
  {
    $role = Role::find($id);

    $this->validate($request,[
      'display_name' => 'required',
      'name' => 'required',
      'description' => 'required',
      'permissions' => 'required'
    ]);

    $input['name'] = $request->get('name');
    $input['display_name'] = $request->get('display_name');
    $input['description'] = $request->get('description');

    $role->fill($input)->save();

    $role->perms()->sync([]);
    $role->attachPermissions($request->get("permissions"));

    \Session::flash('flash_message', 'Ролята беше успешно редактирана!');

    return redirect()->route('admin.settings.roles.index');
  }
}
