@extends('layouts.default')

@section('title')
  <i class="icon-book"></i>
  Редактиране на предмет
@endsection

@section('content')
<div class='box-content'>
  {!! Form::model($data, [
    'method' => 'PATCH',
    'route' => ['admin.subject.update', $data->id],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на предмета</label>
      <div class='col-md-5'>
        <input class='form-control' name='name' id="name" placeholder='Името на предмета' type='text' value="{{ (Request::old('name')) ? Request::old('name') : $data['name']}}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='class'>Клас</label>
      <div class='col-md-5'>
        <select class="form-control" name='class' id="class">
          @for ($i = 5; $i < 13; $i++)
            <?php
              $selected='';

              if (Request::old('class')) {
                if (Request::old('class') == $i) {
                  $selected= 'selected="selected"';
                }
              } else {
                if ($data->class == $i) {
                  $selected= 'selected="selected"';
                }
              }
            ?>
            <option {{ $selected }} value='{{ $i }}'>{{ $i }}. Клас</option>
          @endfor
        </select>
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
