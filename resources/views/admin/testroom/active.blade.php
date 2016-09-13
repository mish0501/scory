@extends('layouts.default')

@section('title')
  <i class="icon-group"></i>
  Всички ученици в стая {{ $code }}
@endsection

@section('create-button')
<div class='pull-right'>
  <div class='btn-group'>
    <a class="btn btn-success" href="/admin/testroom/{{ $code }}/start">
      <i class='icon-play'></i>
      Стартирай теста
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
        </tr>
      </thead>
      <tbody>
        @if($students != NULL)
          @foreach($students as $student)
            <tr>
              <td>{{$student->number}}</td>
              <td>{{$student->name}}</td>
              <td>{{$student->lastname}}</td>
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
    });
    var channel = pusher.subscribe('TestRoomChanel');
    channel.bind('StudentConnected', function(data) {
      if(data.code == '{{$code}}'){
        // $(".dataTables_empty").parent().remove();
        // row = '<tr><td>'+ data.number +'</td><td>'+ data.name +'</td><td>'+ data.lastname +'</td></tr>';
        // table.append(row);
        dataTable.fnAddData([
          data.number,
          data.name,
          data.lastname
        ]);
      }
    });
  </script>
@endsection
