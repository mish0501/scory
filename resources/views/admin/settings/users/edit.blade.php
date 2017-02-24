@extends('layouts.default')

@section('title')
  <i class="fa fa-cogs"></i>
  Смяна на роля на потребител
@endsection

@section('content')
<div class='box-content'>
  {!! Form::model($user, [
    'route' => ['admin.settings.users.update', $user->id],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на потребителя</label>
      <div class='col-md-5'>
        <input class='form-control' name='name' id="name" disabled='disabled' type='text' value="{{ (Request::old('name')) ? Request::old('name') : $user->name}}">
        <input name='name' type='hidden' value="{{ (Request::old('name')) ? Request::old('name') : $user->name}}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>E-mail на потребителя</label>
      <div class='col-md-5'>
        <input class='form-control' name='email' id="email" disabled='disabled' type='email' value="{{ (Request::old('email')) ? Request::old('email') : $user->email}}">
        <input name='email' type='hidden' value="{{ (Request::old('email')) ? Request::old('email') : $user->email}}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='class'>Роля</label>
      <div class='col-md-5'>
        <select class="form-control" name='role' id="role">
          @foreach ($roles as $key => $role)
            <?php
              $selected='';

              if (Request::old('role')) {
                if (Request::old('role') == $role->id) {
                  $selected= 'selected="selected"';
                }
              } else {
                if ($user->role->id == $role->id ) {
                  $selected= 'selected="selected"';
                }
              }
            ?>
            <option {{ $selected }} value='{{ $role->id }}'>{{ $role->display_name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class='form-actions form-actions-padding-sm'>
      <div class='row'>
        <div class='col-md-10 col-md-offset-2'>
          <button class='btn btn-primary' type='submit'>
            <i class='fa fa-save'></i>
            Запази
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
