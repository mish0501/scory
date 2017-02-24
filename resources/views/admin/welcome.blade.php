@extends('layouts.default')

@section('title')
  <i class="fa fa-dashboard"></i>
  Начало
@endsection

@section('content')
  @if(Entrust::hasRole('admin'))
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-error">{{ $invites }}</h3>
        <small>Покани</small>
        <div class="text-error fa fa-envelope align-right"></div>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-warning">{{ $users }}</h3>
        <small>Потребители</small>
        <div class="text-warning fa fa-user align-right"></div>
      </div>
    </div>
  @endif
  <div class="col-sm-2">
    <div class="box-content box-statistic">
      <h3 class="title text-info">{{ $subjects }}</h3>
      <small>Предмети</small>
      <div class="text-info fa fa-book align-right"></div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="box-content box-statistic">
      <h3 class="title text-primary">{{ $partitions }}</h3>
      <small>Раздели</small>
      <div class="text-primary fa fa-folder-open align-right"></div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="box-content box-statistic">
      <h3 class="title text-success">{{ $questions }}</h3>
      <small>Въпроси</small>
      <div class="text-success fa fa-question align-right"></div>
    </div>
  </div>
  @if(Entrust::hasRole('admin'))
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-muted">{{ $trash }}</h3>
        <small>В кошчето</small>
        <div class="text-muted fa fa-trash align-right"></div>
      </div>
    </div>
  @elseif(Entrust::hasRole('teacher'))
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-muted">{{ $testrooms }}</h3>
        <small>Стаи</small>
        <div class="text-muted fa fa-group align-right"></div>
      </div>
    </div>
  @endif
@endsection
