@extends('layouts.default')

@section('title')
  <i class="fa fa-book"></i>
  Добавяне на предмет
@endsection

@section('content')
<div class='box-content'>
  {!! Form::open([
    'route' => ['admin.subject.store'],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
  <!-- <form class="form form-horizontal" style="margin-bottom: 0;" method="post" action="/admin/subject" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на предмета</label>
      <div class='col-md-5'>
        <input class='form-control' name='name' id="name" placeholder='Името на предмета' type='text' value="{{Request::old('name')}}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='class'>Клас</label>
      <div class='col-md-5'>
        <select class="form-control" name='class' id="class">
          @for ($i = 5; $i < 13; $i++)
            <option value='{{ $i }}' {{ (Request::old('class') == $i) ? 'selected="selected"' : null }}>{{ $i }}. Клас</option>
          @endfor
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
