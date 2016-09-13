@extends('layouts.default')

@section('title')
  <i class="icon-question"></i>
  Всички въпроси
@endsection

@if(Entrust::can('create-question'))
  @section('create-button')
  <div class='pull-right'>
    <div class='btn-group'>
      <a class="btn btn-success" href="{{ route('admin.question.create') }}">
        <i class='icon-plus'></i>
        Добави въпрос
      </a>
    </div>
  </div>
  @endsection
@endif

@section('content')
<div class='box bordered-box' style='margin-bottom:0;'>
  <div class='box-content'>
    <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
      <thead>
        <tr>
          <th>
            Име на въпрос
          </th>
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
          @if(Entrust::can('edit-question') || Entrust::can('delete-question'))
            <th>
              Опции
            </th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach ($questions as $data)
          <tr>
            <td>{{ str_limit($data->name, 55) }}</td>
            <td>{{ $data->partition->name }}</td>
            <td>{{ $data->subject->name }}</td>
            <td>{{ $data->class }}. Клас</td>
            @if(Entrust::can('edit-question') || Entrust::can('delete-question'))
              <td>
                <div class='text-right'>
                  @if(Entrust::can('edit-question') && Entrust::can('delete-question'))
                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['admin.question.destroy', $data->id]
                    ]) !!}
                        <a class='btn btn-success btn-xs' href='/admin/question/{{ $data->id }}/edit'>
                          <i class='icon-edit'></i>
                          <span>Редактирай</span>
                        </a>
                        <button type="submit" class='btn btn-danger btn-xs'>
                          <i class='icon-remove'></i>
                          <span>Изтрий</span>
                        </button>
                    {!! Form::close() !!}
                  @else
                    @if(Entrust::can('edit-question'))
                      <a class='btn btn-success btn-xs' href='/admin/question/{{ $data->id }}/edit'>
                        <i class='icon-edit'></i>
                        <span>Редактирай</span>
                      </a>
                    @endif

                    @if(Entrust::can('delete-question'))
                      {!! Form::open([
                          'method' => 'DELETE',
                          'route' => ['admin.question.destroy', $data->id]
                      ]) !!}
                          <button type="submit" class='btn btn-danger btn-xs'>
                            <i class='icon-remove'></i>
                            <span>Изтрий</span>
                          </button>
                      {!! Form::close() !!}
                    @endif
                  @endif
                </div>
              </td>
            @endif
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
