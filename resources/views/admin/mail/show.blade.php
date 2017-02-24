@extends('layouts.default')

@section('title')
  <i class="fa fa-comments"></i>
  Преглед на съобщение
@endsection

@section('content')
<div class='box-content'>

  <div class='col-md-10'>
    <div class="col-md-2">
      <label>Името на подателя</label>
    </div>
    <div class='col-md-3'>
      <span>{{ $message->name }} ({{ $message->email }})</span>
    </div>
  </div>
  <div class="col-md-6">
    <hr style="border-top: 1px solid #ccc">
  </div>
  <div class='col-md-10'>
    <label class='col-md-2'>Относно</label>
    <div class='col-md-5'>
      <span>{{ $message->subject }}</span>
    </div>
  </div>
  <div class="col-md-6">
    <hr style="border-top: 1px solid #ccc">
  </div>
  <div class='col-md-10'>
    <label class='col-md-2'>Съобщение</label>
    <div class='col-md-5'>
      <span>{{ $message->message }}</span>
    </div>
  </div>
</div>
@endsection
