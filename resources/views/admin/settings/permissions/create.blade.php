@extends('layouts.default')

@section('title')
  <i class="icon-cogs"></i>
  Създаване на право
@endsection

@section('content')
<div class='box-content'>
  {!! Form::open([
    'route' => ['admin.settings.permissions.store'],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
    <div class='form-group'>
      <label class='col-md-2 control-label' for='display_name'>Името на правото</label>
      <div class='col-md-5'>
        <input class='form-control' name='display_name' id="display_name" type='text' placeholder="Името на правото" value="{{ (Request::old('display_name')) ? Request::old('display_name') : '' }}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на правото в системата</label>
      <div class='col-md-5'>
        <input class='form-control' name='name' id="name"  type='text' placeholder="Името на правото в системата" value="{{ (Request::old('name')) ? Request::old('name') : '' }}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='description'>Описание</label>
      <div class='col-md-5'>
        <textarea class="form-control" id="description" name="description" placeholder="Описание" rows="3">{{ (Request::old('description')) ? Request::old('description') : '' }}</textarea>
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
