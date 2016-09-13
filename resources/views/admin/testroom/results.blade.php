@extends('layouts.default')

@section('title')
  <i class="icon-group"></i>
  Резултати на учениците в стая {{ $code }}
@endsection

@section('content')
<div class='box bordered-box' style='margin-bottom:0;'>
  <div class='box-content'>
    <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
      <thead>
        <tr>
          <th>
            Номер в стаята
          </th>
          <th>
            Име на ученика
          </th>
          <th>
            Фамилия на ученика
          </th>
          <th>
            Брой точки
          </th>
          <th>
            Отговорите на ученика
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach($students as $student)
          <tr>
            <td>{{$student->number}}</td>
            <td>{{$student->name}}</td>
            <td>{{$student->lastname}}</td>
            <td>{{$student->correct}}</td>
            <td>
              <div class="text-right">
                <a class='btn btn-success btn-xs' href='/admin/testroom/{{$code}}/student/{{$student->number}}'>
                  <i class='icon-question'></i>
                  <span>Покажи отговорите на ученика</span>
                </a>
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
  <script src="{{ url('/admin')}}/assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="{{ url('/admin')}}//assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
@endsection
