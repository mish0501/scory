@extends('layouts.default')

@section('title')
  <i class="icon-envelope"></i>
  Добавяне на покана
@endsection

@section('content')
<div class='box-content'>
  {!! Form::open([
    'route' => ['admin.invite.store'],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Покана</label>
      <div class='col-md-5'>
        <input class='form-control' name='invite' placeholder='Покана' type='text' value="{{ (Request::old('invite')) ? Request::old('invite') : $code }}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>E-mail</label>
      <div class='col-md-5'>
        <input class='form-control' name='email' placeholder='E-mail' type='email' value="{{ (Request::old('email')) ? Request::old('email') : (isset($email)) ? $email : '' }}">
      </div>
    </div>
    <div class='form-actions form-actions-padding-sm'>
      <div class='row'>
        <div class='col-md-10 col-md-offset-2'>
          <button class='btn btn-primary' type='submit'>
            <i class='icon-save'></i>
            Запази
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
