@extends('layouts.user')

@section('title')
  Регистрация
@endsection

@section('content')
<div class='login-container'>
  <div class='container'>
    <div class='row'>
      <div class='col-sm-4 col-sm-offset-4'>
        <h1 class='text-center title'>Регистрация</h1>
        @if (count($errors) > 0)
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="/register">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class='form-group'>
            <div class='controls with-icon-over-input'>
              <input value="{{ old('name') }}" placeholder="Име" class="form-control" name="name" type="text" />
              <i class='icon-user text-muted'></i>
            </div>
          </div>
          <div class='form-group'>
            <div class='controls with-icon-over-input'>
              <input value="{{ old('email') }}" placeholder="E-mail" class="form-control" name="email" type="text" />
              <i class='icon-envelope text-muted'></i>
            </div>
          </div>
          <div class='form-group'>
            <div class='controls with-icon-over-input'>
              <input placeholder="Парола" class="form-control" name="password" type="password" />
              <i class='icon-lock text-muted'></i>
            </div>
          </div>
          <div class='form-group'>
            <div class='controls with-icon-over-input'>
              <input placeholder="Повтори паролата" class="form-control" name="password_confirmation" type="password" />
              <i class='icon-lock text-muted'></i>
            </div>
          </div>
          <?php if (isset($invite)): ?>
            <input type="hidden" name="invite" value="{{ $invite }}">
          <?php else: ?>
            <div class="form-group">
              <div class='controls with-icon-over-input'>
                <input placeholder="Покана" class="form-control" name="invite" />
                <i class='icon-envelope text-muted'></i>
              </div>
            </div>
          <?php endif; ?>
          <div class="form-group">
            <div class='checkbox'>
              <label for='agreement'>
                <input id='agreement' name='agreement' type='checkbox' value='1'>
                Приемам
                <a class='text-contrast' href='#'>потребителските условия</a>
              </label>
            </div>
          </div>
          <button class='btn btn-block'>Регистрирай се</button>
        </form>
        <div class='text-center'>
          <hr class='hr-normal'>
          <a href='/login'>
            <i class='icon-chevron-left'></i>
            Обратно към вход
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
