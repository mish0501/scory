@extends('layouts.default')

@section('title')
  <i class="fa fa-group"></i>
  Всички стаи
@endsection

@section('create-button')
<div class='pull-right'>
  <div class='btn-group'>
    <a class="btn btn-success" href="/admin/testroom/create">
      <i class='fa fa-plus'></i>
      Нова стая
    </a>
  </div>
</div>
@endsection

@section('content')
<div class='box bordered-box' style='margin-bottom:0;'>
  <div class='box-content'>
    <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
      <thead>
        <tr>
          <th>
            Код на стаята
          </th>
          <th>
            Предмет
          </th>
          <th>
            Раздел
          </th>
          <th>
            Клас
          </th>
          <th>
            Статус
          </th>
          <th>
            Опции
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($testrooms as $testroom)
          <tr>
            <td>{{ $testroom->code }}</td>
            <td>{{ $testroom->subject->name }}</td>
            <td>{{ $testroom->partition->name }}</td>
            <td>{{ $testroom->class }}</td>
            <td>@if($testroom->status == 1) Активна @elseif($testroom->status == 0) Деактивирана @elseif($testroom->status == 2) В процес на решаване на тест @elseif($testroom->status == 3) Решена @endif</td>
            <td>
              <div class='text-right'>
                {!! Form::open([
                    'method' => 'DELETE',
                    'route' => ['admin.testroom.destroy', $testroom->code]
                ]) !!}
                    @if($testroom->status == 0)
                      <a class='btn btn-success btn-xs' href='/admin/testroom/{{ $testroom->code }}/active'>
                        <i class='fa fa-play'></i>
                        <span>Активирай стаята</span>
                      </a>
                    @elseif($testroom->status == 1)
                      <a class='btn btn-success btn-xs' href='/admin/testroom/{{ $testroom->code }}/start'>
                        <i class='fa fa-play'></i>
                        <span>Стартирай тест</span>
                      </a>
                      <a class='btn btn-primary btn-xs' href='/admin/testroom/{{ $testroom->code }}/active'>
                        <i class='fa fa-group'></i>
                        <span>Покажи учениците в стаята</span>
                      </a>
                    @elseif($testroom->status == 2)
                      <a class='btn btn-success btn-xs' href='/admin/testroom/{{ $testroom->code }}/end'>
                        <i class='fa fa-stop'></i>
                        <span>Спри теста</span>
                      </a>
                      <a class='btn btn-primary btn-xs' href='/admin/testroom/{{ $testroom->code }}/start'>
                        <i class='fa fa-group'></i>
                        <span>Покажи резултатите на учениците</span>
                      </a>
                    @elseif($testroom->status == 3)
                      <a class='btn btn-primary btn-xs' href='/admin/testroom/{{ $testroom->code }}/results'>
                        <i class='fa fa-group'></i>
                        <span>Покажи резултатите на учениците</span>
                      </a>
                    @endif
                    <button type="submit" class='btn btn-danger btn-xs'>
                      <i class='fa fa-remove'></i>
                      <span>Изтрий</span>
                    </button>
                {!! Form::close() !!}
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('javascript')
  <script src="assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
@endsection
