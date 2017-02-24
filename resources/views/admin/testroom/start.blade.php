@extends('layouts.default')

@section('title')
  <i class="fa fa-group"></i>
  Всички готови ученици в стая {{ $code }}
@endsection

@section('create-button')
<div class='pull-right'>
  <div class='btn-group'>
    <a class="btn btn-success" href="/admin/testroom/{{ $code }}/end">
      <i class='fa fa-stop'></i>
      Стоп на теста
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
        @if($students != NULL)
          @foreach($students as $student)
            <tr>
              <td>{{$student->number}}</td>
              <td>{{$student->name}}</td>
              <td>{{$student->lastname}}</td>
              <td>{{$student->correct}}</td>
              <td>
                <div class="text-right">
                  <a class='btn btn-success btn-xs' href='/admin/testroom/{{$code}}/student/{{$student->number}}'>
                    <i class='fa fa-question'></i>
                    <span>Покажи отговорите на ученика</span>
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
</div>
@endsection


@section('javascript')
  <script type="text/javascript">
    var dataTable;
    $(document).ready(function(){
      dataTable = $('.data-table').dataTable();
    });
  </script>

  <script src="{{ url('/admin')}}/assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="{{ url('/admin')}}/assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
  <script src="//js.pusher.com/3.0/pusher.min.js"></script>
  <script>
    var table = $('tbody');
    var row = '';
    var pusher = new Pusher("{{env("PUSHER_KEY")}}", {
      cluster: 'eu'
    })
    var channel = pusher.subscribe('TestRoomChanel');
    channel.bind('FinishTest', function(data) {
      // $(".dataTables_empty").parent().remove();
      // row = '<tr><td>'+ data.number +'</td><td>'+ data.name +'</td><td>'+ data.lastname +'</td><td>'+data.correct+'</td><td><div class="text-right"><a class="btn btn-success btn-xs" href="/admin/testroom/'+data.code+'/student/'+data.number+'"><i class="fa fa-question"></i><span>Покажи отговорите на ученика</span></a></div></td></tr>';
      // table.append(row);
      dataTable.fnAddData([
        data.number,
        data.name,
        data.lastname,
        data.correct,
        '<div class="text-right"><a class="btn btn-success btn-xs" href="/admin/testroom/'+data.code+'/student/'+data.number+'"><i class="fa fa-question"></i><span>Покажи отговорите на ученика</span></a></div>'
      ]);
    });
  </script>
@endsection
