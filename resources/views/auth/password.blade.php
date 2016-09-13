@extends('layouts.user')

@section('title')
  Забравена парола
@endsection

@section('content')
<div class='login-container'>
  <div class='container'>
    <div class='row'>
      <div class='col-sm-4 col-sm-offset-4'>
        <h1 class='text-center title'>Забравена парола</h1>
        @if (session('status'))
          <div class="alert alert-success">
                 {{ session('status') }}
          </div>
        @endif

        @if (count($errors) > 0)
           <div class="alert alert-danger">
             <strong>Whoops!</strong> There were some problems with your input.<br><br>
             <ul>
               @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
               @endforeach
            </ul>
          </div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="/password/email">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class='form-group'>
          <div class='controls with-icon-over-input'>
            <input value="{{ old('email') }}" placeholder="E-mail" class="form-control" name="email" type="text" />
            <i class='icon-user text-muted'></i>
          </div>
        </div>
        <button class='btn btn-block'>Изпрати ми инструкциите</button>
        </form>
        <div class='text-center'>
          <hr class='hr-normal'>
          <a href='/login'>
            <i class='icon-chevron-left'></i>
            Аз вече знам си паролата
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class='login-container-footer'>
  <div class='container'>
    <div class='row'>
      <div class='col-sm-12'>
        <div class='text-center'>
          <a href='/auth/register'>
            <i class='icon-user'></i>
            Нов за Green Sheet?
            <strong>Регистрирай се</strong>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
