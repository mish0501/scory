@extends('layouts.default')

@section('title')
  <i class="icon-dashboard"></i>
  Начало
@endsection

@section('content')
  @if(Entrust::hasRole('admin'))
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-error">{{ $invites }}</h3>
        <small>Покани</small>
        <div class="text-error icon-envelope align-right"></div>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-warning">{{ $users }}</h3>
        <small>Потребители</small>
        <div class="text-warning icon-user align-right"></div>
      </div>
    </div>
  @endif
  <div class="col-sm-2">
    <div class="box-content box-statistic">
      <h3 class="title text-info">{{ $subjects }}</h3>
      <small>Предмети</small>
      <div class="text-info icon-book align-right"></div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="box-content box-statistic">
      <h3 class="title text-primary">{{ $partitions }}</h3>
      <small>Раздели</small>
      <div class="text-primary icon-folder-open align-right"></div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="box-content box-statistic">
      <h3 class="title text-success">{{ $questions }}</h3>
      <small>Въпроси</small>
      <div class="text-success icon-question align-right"></div>
    </div>
  </div>
  @if(Entrust::hasRole('admin'))
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-muted">{{ $trash }}</h3>
        <small>В кошчето</small>
        <div class="text-muted icon-trash align-right"></div>
      </div>
    </div>
  @elseif(Entrust::hasRole('teacher'))
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-muted">{{ $testrooms }}</h3>
        <small>Стаи</small>
        <div class="text-muted icon-group align-right"></div>
      </div>
    </div>
  @endif
@endsection
