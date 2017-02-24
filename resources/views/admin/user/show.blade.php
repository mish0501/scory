@extends('layouts.default')

@section('title')
  Настройки на профила
@endsection

@section('content')
<div class='row'>
  <div class='col-sm-3 col-lg-3 col-lg-offset-1'>
    <div class='box' style="display:inline-block;">
      <div class='box-content' style="display:inherit;">
        <img class="img-responsive" src="/admin/assets/images/avatar/{{ $avatar }}" />
      </div>
    </div>
  </div>
  <div class='col-sm-9 col-lg-7'>
    <div class='box'>
      <div class='box-content box-double-padding'>
        <div class='col-sm-12'>
          <div class='form-group'>
            <label>Име:</label><br>
            <span>{{ $name }}</span>
          </div>
          <div class='form-group'>
            <label>E-mail:</label><br>
            <span>{{ $email }}</span>
          </div>
          <div class='form-group'>
            <label>Въпроси в системата:</label><br>
            <span>{{ $questions }}</span>
          </div>
          @if($edit)
          <div class='form-actions form-actions-padding' style='margin-bottom: 0;'>
            <div class='text-right'>
              <a href="/admin/user/edit" class='btn btn-success btn-lg'>
                <i class='fa fa-edit'></i>
                Редактирай
              </a>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
