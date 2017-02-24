@extends('layouts.default')

@section('title')
  <i class="fa fa-comments"></i>
  Всички съобщения
@endsection

@section('content')
<div class='box bordered-box' style='margin-bottom:0;'>
  <div class='box-content'>
    <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
      <thead>
        <tr>
          <th>
            Име
          </th>
          <th>
            Относно
          </th>
          <th>
            Съобщение
          </th>
          <th>
            Статус
          </th>
          <th>
            Получено
          </th>
          <th>
            Опции
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($mail as $message)
          <tr>
            <td>{{ $message->name }} ({{ $message->email }})</td>
            <td>{{ $message->subject }}</td>
            <td>{{ str_limit($message->message, 55) }}</td>
            <td>{{ ($message->read == true)? 'Прочетено' : 'Непрочетено' }}</td>
            <td>{{ $message->time }}</td>
            <td>
              <div class='text-right'>
                  {!! Form::open([
                      'method' => 'DELETE',
                      'route' => ['admin.mail.destroy', $message->id]
                  ]) !!}
                      <a class='btn btn-success btn-xs' href='/admin/mail/{{ $message->id }}'>
                        <i class='fa fa-edit'></i>
                        <span>Отвори</span>
                      </a>
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
  <script type="text/javascript">
    var dataTable;
    $(document).ready(function(){
      dataTable = $('.data-table').dataTable();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  </script>

  <script src="assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>

  <script type="text/javascript">
    var channel = pusher.subscribe('MailChanel'),
        token = $('input[name=_token]');

    channel.bind('NewMail', function(data) {
      if(data.new_mail){
        var getMessage = $.ajax({
          method: 'POST',
          url: '{{ route("getMessage") }}',
          data:{
            _token: "{{ csrf_token() }}"
          }
        }).done(function(data) {
          var options = '<div class="text-right"><form method="POST" action="/admin/mail/'+data.id+'" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="'+data.token+'"><a class="btn btn-success btn-xs" href="/admin/mail/'+data.id+'"><i class="fa fa-edit"></i> <span>Отвори</span></a> <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> <span>Изтрий</span></button></form></div>'
          dataTable.fnAddData([
            data.name + ' ('+ data.email +')',
            data.subject,
            data.message,
            "Непрочетено",
            options
          ]);

          token.attr('value', data.token);
        });
      }
    });
  </script>
@endsection
