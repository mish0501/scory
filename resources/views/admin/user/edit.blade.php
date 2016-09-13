@extends('layouts.default')

@section('title')
  Настройки на профила
@endsection

@section('content')
<div class='row'>
  <div class='col-sm-3 col-lg-3 col-lg-offset-1'>
    <div class='box' style="display:inline-block;">
      <div class='box-content' style="display:inherit;">
        {!! Form::open([
            'route' => ['admin.user.update'],
            'files' => true,
            'autocomplete' => 'off'
        ]) !!}
          <img class="img-responsive" src="/admin/assets/images/avatar/{{ $avatar }}" />
      </div>

      {!! Form::file('image', null, array('required', 'class'=>'form-control')) !!}
    </div>
  </div>
  <div class='col-sm-9 col-lg-7'>
    <div class='box'>
      <div class='box-content box-double-padding'>
        <fieldset>
          <div class='col-sm-12'>
            <div class='form-group'>
              <label>Име</label>
              <input class='form-control' name='name' placeholder='Име' type='text' value="{{ $name }}">
            </div>
            <div class='form-group'>
              <label>E-mail</label>
              <input class='form-control' name='email' placeholder='E-mail' type='text' value="{{ $email }}">
            </div>
        </fieldset>
        <!-- <hr class='hr-normal'> -->
        <!-- <fieldset>
          <div class='col-sm-12'>
            <div class='form-group'>
              <label>Учител по</label>
              <input class='form-control' id='firstname' placeholder='Учител по...' type='text'>
            </div>
            <div class='form-group'>
              <label>Учител в</label>
              <input class='form-control' id='lastname' placeholder='Името на учебното заведение' type='text'>
            </div>
            <hr class='hr-normal'>
            <div class='form-group'>
              <label>Биография</label>
              <textarea class='autosize form-control' id='bio' placeholder='Биография'></textarea>
            </div>
          </div>
        </fieldset> -->
        <div class='form-actions form-actions-padding' style='margin-bottom: 0;'>
          <div class='text-right'>
            <button type="submit" class='btn btn-primary btn-lg'>
              <i class='icon-save'></i>
              Запази
            </button>
          </div>
        </div>
      </form>
        <hr class='hr-normal'>
          {!! Form::open([
              'route' => ['admin.user.change']
          ]) !!}
          <fieldset>
            <div class='col-sm-12'>
              <div class='form-group'>
                <div class='controls'>
                  <div class='checkbox'>
                    <label>
                      <input data-target='#change-password' data-toggle='collapse' id='changepasswordcheck' type='checkbox' value='option1'>
                      Смени си паролата?
                    </label>
                  </div>
                </div>
              </div>
              <div class='collapse' id='change-password'>
                <div class='form-group'>
                  <label>Стара парола</label>
                  <input class='form-control' id='old_password' name="old_password" placeholder='Стара парола' type='password'>
                </div>
                <div class='form-group'>
                  <label>Нова парола</label>
                  <input class='form-control' id='password' name="password" placeholder='Нова парола' type='password'>
                </div>
                <div class='form-group'>
                  <label>Потвърди новата парола</label>
                  <input class='form-control' id='password_confirmation' name="password_confirmation" placeholder='Потвърди новата парола' type='password'>
                </div>
                <div class='form-actions form-actions-padding' style='margin-bottom: 0;'>
                  <div class='text-right'>
                    <button type="submit" class='btn btn-primary btn-lg'>
                      <i class='icon-save'></i>
                      Запази
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
