@extends('layouts.default')

@section('title')
  <i class="fa fa-trash"></i>
  Кошче
@endsection

@section('content')
@if(Entrust::can('delete-subject'))
<div class='box bordered-box purple-border {{ ($subjects->isEmpty()) ? "box-collapsed" : "" }}' style='margin-bottom:0;'>
  <div class='box-header purple-background'>
    <div class='title'>
      <i class="fa fa-book"></i>
      @if ($subjects->isEmpty())
       Няма предмети в кошчето
      @else
        Предмети в кошчето
      @endif
   </div>
   <div class='actions'>
     <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
   </div>
  </div>
  <div class='box bordered-box purple-border' style='margin-bottom:0;'>
    <div class='box-content'>
      <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
        <thead>
          <tr>
            <th>
              Име на предмета
            </th>
            </th>
            <th>
              Клас
            </th>
            <th>
              Опции
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($subjects as $subject)
            <tr>
              <td>{{ $subject->name }}</td>
              <td>{{ $subject->class }}. Клас</td>
              <td>
                <div class='text-right'>
                  {!! Form::open([
                      'route' => ['trash.renew.subject'],
                      'style' => "margin-bottom: 5px"
                  ]) !!}
                    <input type="hidden" name="id" value="{{ $subject->id }}">
                      <button type="submit" class='btn btn-success btn-xs'>
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                  {!! Form::close() !!}

                  {!! Form::open([
                      'method' => 'DELETE',
                      'route' => ['trash.delete.subject', $subject->id]
                  ]) !!}
                      <button type="submit" class='btn btn-danger btn-xs'>
                        <i class='fa fa-remove'></i> Изтрий
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
</div>
<br><br>
@endif

@if(Entrust::can('delete-partition'))
<div class='box bordered-box blue-border {{ ($partitions->isEmpty()) ? "box-collapsed" : "" }}' style='margin-bottom:0;'>
  <div class='box-header blue-background'>
    <div class='title'>
      <i class="fa fa-folder-open"></i>
      @if ($partitions->isEmpty())
       Няма раздели в кошчето
      @else
        Раздели в кошчето
      @endif
   </div>
   <div class='actions'>
     <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
   </div>
  </div>
  <div class='box bordered-box blue-border' style='margin-bottom:0;'>
    <div class='box-content'>
      <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
        <thead>
          <tr>
            <th>
              Име на раздела
            </th>
            <th>
              Име на предмета
            </th>
            </th>
            <th>
              Клас
            </th>
            <th>
              Опции
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($partitions as $partition)
            <tr>
              <td>{{ $partition->name }}</td>
              <td>{{ $partition->subject->name }}</td>
              <td>{{ $partition->class }}. Клас</td>
              <td>
                <div class='text-right'>
                  {!! Form::open([
                      'route' => ['trash.renew.partition'],
                      'style' => "margin-bottom: 5px"
                  ]) !!}
                    <input type="hidden" name="id" value="{{ $partition->id }}">
                      <button type="submit" class='btn btn-success btn-xs'>
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                  {!! Form::close() !!}

                  {!! Form::open([
                      'method' => 'DELETE',
                      'route' => ['trash.delete.partition', $partition->id]
                  ]) !!}
                      <button type="submit" class='btn btn-danger btn-xs'>
                        <i class='fa fa-remove'></i> Изтрий
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
</div>
<br><br>
@endif

@if(Entrust::can('delete-question'))
<div class='box bordered-box green-border {{ ($questions->isEmpty()) ? "box-collapsed" : "" }}' style='margin-bottom:0;'>
  <div class='box-header green-background'>
    <div class='title'>
      <i class="fa fa-question"></i>
      @if ($questions->isEmpty())
       Няма въпроси в кошчето
      @else
        Въпроси в кошчето
      @endif
   </div>
   <div class='actions'>
     <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
   </div>
  </div>
  <div class='box bordered-box green-border' style='margin-bottom:0;'>
    <div class='box-content'>
      <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
        <thead>
          <tr>
            <th>
              Име на въпроса
            </th>
            <th>
              Име на раздела
            </th>
            <th>
              Име на предмета
            </th>
            </th>
            <th>
              Клас
            </th>
            <th>
              Опции
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($questions as $question)
            <tr>
              <td>{{ $question->name }}</td>
              <td>{{ $question->partition->name }}</td>
              <td>{{ $question->subject->name }}</td>
              <td>{{ $question->class }}. Клас</td>
              <td>
                <div class='text-right'>
                  {!! Form::open([
                      'route' => ['trash.renew.question'],
                      'style' => "margin-bottom: 5px"
                  ]) !!}
                    <input type="hidden" name="id" value="{{ $question->id }}">
                      <button type="submit" class='btn btn-success btn-xs'>
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                  {!! Form::close() !!}

                  {!! Form::open([
                      'method' => 'DELETE',
                      'route' => ['trash.delete.question', $question->id]
                  ]) !!}
                      <button type="submit" class='btn btn-danger btn-xs'>
                        <i class='fa fa-remove'></i> Изтрий
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
</div>
<br><br>
@endif

@if(Entrust::can('delete-testroom'))
<div class='box bordered-box red-border {{ ($testrooms->isEmpty()) ? "box-collapsed" : "" }}' style='margin-bottom:0;'>
  <div class='box-header red-background'>
    <div class='title'>
      <i class="fa fa-group"></i>
      @if ($testrooms->isEmpty())
       Няма стаи в кошчето
      @else
        Стаи в кошчето
      @endif
   </div>
   <div class='actions'>
     <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
   </div>
  </div>
  <div class='box bordered-box red-border' style='margin-bottom:0;'>
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
              <td>
                <div class='text-right'>
                  {!! Form::open([
                      'route' => ['trash.renew.testroom'],
                      'style' => "margin-bottom: 5px"
                  ]) !!}
                    <input type="hidden" name="code" value="{{ $testroom->code }}">
                      <button type="submit" class='btn btn-success btn-xs'>
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                  {!! Form::close() !!}

                  {!! Form::open([
                      'method' => 'DELETE',
                      'route' => ['trash.delete.testroom', $testroom->code]
                  ]) !!}
                      <button type="submit" class='btn btn-danger btn-xs'>
                        <i class='fa fa-remove'></i> Изтрий
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
</div>
<br><br>
@endif

@if(Entrust::hasRole('admin'))
<div class='box bordered-box orange-border {{ ($mail->isEmpty()) ? "box-collapsed" : "" }}' style='margin-bottom:0;'>
  <div class='box-header orange-background'>
    <div class='title'>
      <i class="fa fa-comments"></i>
      @if ($mail->isEmpty())
       Няма съобщения в кошчето
      @else
        Съобщения в кошчето
      @endif
   </div>
   <div class='actions'>
     <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
   </div>
  </div>
  <div class='box bordered-box red-border' style='margin-bottom:0;'>
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
                      'route' => ['trash.renew.mail'],
                      'style' => "margin-bottom: 5px"
                  ]) !!}
                    <input type="hidden" name="id" value="{{ $message->id }}">
                      <button type="submit" class='btn btn-success btn-xs'>
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                  {!! Form::close() !!}

                  {!! Form::open([
                      'method' => 'DELETE',
                      'route' => ['trash.delete.mail', $message->id]
                  ]) !!}
                      <button type="submit" class='btn btn-danger btn-xs'>
                        <i class='fa fa-remove'></i> Изтрий
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
</div>
@endif
@endsection

@section('javascript')
  <script src="assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
@endsection
