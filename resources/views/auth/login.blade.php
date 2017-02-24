@extends('layouts.user')

@section('title')
  Вход
@endsection

@section('content')
      <div class='login-container'>
        <div class='container'>
          <div class='row'>
            <div class='col-sm-4 col-sm-offset-4'>
              <h1 class='text-center title'>Вход</h1>
              @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif

              <form class="form-horizontal" role="form" method="POST" action="/login">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class='form-group'>
                  <div class='controls with-icon-over-input'>
                    <input value="{{ old('email') }}" placeholder="E-mail" class="form-control" data-rule-required="true" name="email" type="text" />
                    <i class='fa fa-user text-muted'></i>
                  </div>
                </div>
                <div class='form-group'>
                  <div class='controls with-icon-over-input'>
                    <input placeholder="Парола" class="form-control" data-rule-required="true" name="password" type="password" />
                    <i class='fa fa-lock text-muted'></i>
                  </div>
                </div>
                <div class="form-group">
                  <div class='checkbox'>
                    <label for='remember_me'>
                      <input id='remember_me' name='remember' type='checkbox' >
                      Запомни ме
                    </label>
                  </div>
                </div>
                <button class='btn btn-block'>Вход</button>
              </form>
              <div class='text-center'>
                <hr class='hr-normal'>
                <a href='/password/email'>Забравил си си паролата?</a>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
