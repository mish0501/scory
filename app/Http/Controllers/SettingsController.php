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

    return $users;
  }

  public function editUsers($id)
  {
    $user = User::find($id);
    $role = $user->roles()->get()[0];
    $user['role'] = $role;

    $roles = Role::all();

    return ['user' => $user, 'roles' => $roles];
  }

  public function updateUsers(Request $request, $id)
  {
    $validator = \Validator::make($request->all(), [
      'name' => 'required|exists:users,name',
      'email' => 'required|exists:users,email',
      'role' => 'required'
    ], [
      'role.required' => 'Полето с ролята е задължително.'
    ]);

    if ($validator->fails()) {
      return ['error' => $validator->errors()];
    }

    $name = $request->get('name');
    $email = $request->get('email');
    $role = $request->get('role');

    $user = User::find($id);

    $user->roles()->sync([$role]);


    return ['success' => 'Ролята на потребителя беше успешно зададена!'];
  }

  public function permissions()
  {
    $permissions = Permission::all();

    return $permissions;
  }

  public function storePermissions(Request $request)
  {
    $validator = \Validator::make($request->all(), [
      'display_name' => 'required|min:5',
      'name' => 'required|min:5',
      'description' => 'required|min:15',
    ], [
      'display_name.required' => 'Полето Името на правото е задължително.',
      'display_name.min' => 'Полето Името на правото трябва да бъде минимум 5 знака.',
      'name.required' => 'Полето Името на правото в системата е задължително.',
      'name.min' => 'Полето Името на правото в системата трябва да бъде минимум 5 знака.',
    ]);

    if ($validator->fails()) {
      return ['error' => $validator->errors()];
    }

    $permission = new Permission();
    $permission->name = $request->get('name');
    $permission->display_name = $request->get('display_name');
    $permission->description  = $request->get('description');
    $permission->save();

    return ['success' => 'Правото беше успешно създадено!'];
  }

  public function editPermissions($id)
  {
    $permission = Permission::find($id);

    return $permission;
  }

  public function updatePermissions(Request $request, $id)
  {
    $permission = Permission::find($id);

    $validator = \Validator::make($request->all(), [
      'display_name' => 'required',
      'name' => 'required',
      'description' => 'required'
    ], [
      'display_name.required' => 'Полето Името на правото е задължително.',
      'display_name.min' => 'Полето Името на правото трябва да бъде минимум 5 знака.',
      'name.required' => 'Полето Името на правото в системата е задължително.',
      'name.min' => 'Полето Името на правото в системата трябва да бъде минимум 5 знака.',
    ]);

    if ($validator->fails()) {
      return ['error' => $validator->errors()];
    }

    $input['name'] = $request->get('name');
    $input['display_name'] = $request->get('display_name');
    $input['description'] = $request->get('description');

    $permission->fill($input)->save();

    return ['success' => 'Правото беше успешно редактирано!'];
  }

  public function roles()
  {
    $roles = Role::all();

    return $roles;
  }

  public function createRoles()
  {
    $permissions = Permission::all();
    return $permissions;
  }

  public function storeRoles(Request $request)
  {
    $validator = \Validator::make($request->all(), [
      'display_name' => 'required|min:5',
      'name' => 'required|min:5',
      'description' => 'required|min:15',
      'permissions' => 'required'
    ], [
      'display_name.required' => 'Полето Името на ролята е задължително.',
      'display_name.min' => 'Полето Името на ролята трябва да бъде минимум 5 знака.',
      'name.required' => 'Полето Името на правото в системата е задължително.',
      'name.min' => 'Полето Името на правото в системата трябва да бъде минимум 5 знака.',
      'permissions.required' => 'Полето Права е задължително.',
    ]);

    if ($validator->fails()) {
      return ['error' => $validator->errors()];
    }

    $role = new Role();
    $role->name = $request->get('name');
    $role->display_name = $request->get('display_name');
    $role->description  = $request->get('description');
    $role->save();


    $role->perms()->sync($request->get("permissions"));

    return ['success' => 'Правото беше успешно създадено!'];
  }

  public function editRoles($id)
  {
    $role = Role::find($id);
    $permissions = Permission::all();
    $rolePerms = $role->perms()->get();

    return ['role' => $role, 'permissions' => $permissions, 'rolePerms' => $rolePerms];
  }

  public function updateRoles(Request $request, $id)
  {
    $role = Role::find($id);

    $validator = \Validator::make($request->all(), [
      'display_name' => 'required',
      'name' => 'required',
      'description' => 'required',
      'permissions' => 'required'
    ], [
      'display_name.required' => 'Полето Името на ролята е задължително.',
      'display_name.min' => 'Полето Името на ролята трябва да бъде минимум 5 знака.',
      'name.required' => 'Полето Името на правото в системата е задължително.',
      'name.min' => 'Полето Името на правото в системата трябва да бъде минимум 5 знака.',
    ]);

    if ($validator->fails()) {
      return ['error' => $validator->errors()];
    }

    $input['name'] = $request->get('name');
    $input['display_name'] = $request->get('display_name');
    $input['description'] = $request->get('description');

    $role->fill($input)->save();

    $role->perms()->sync($request->get("permissions"));

    return ['success' => 'Ролята беше успешно редактирана!'];
  }
}
