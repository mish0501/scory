@extends('layouts.default')

@section('title')
  <i class="fa fa-book"></i>
  Всички предмети
@endsection

@if(Entrust::can('create-subject'))
  @section('create-button')
  <div class='pull-right'>
    <div class='btn-group'>
      <a class="btn btn-success" href="{{ route('admin.subject.create') }}">
        <i class='fa fa-plus'></i>
        Добави предмет
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
            Име на предмета
          </th>
          <th>
            Клас
          </th>
          @if(Entrust::can('edit-subject') || Entrust::can('delete-subject'))
            <th>
              Опции
            </th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach ($subjects as $data)
          <tr>
            <td>{{ str_limit($data['name'], 55) }}</td>
            <td class="class-col">{{ $data['class'] }}. Клас</td>
            @if(Entrust::can('edit-subject') || Entrust::can('delete-subject'))
              <td>
                <div class='text-right'>
                  @if(Entrust::can('edit-subject') && Entrust::can('delete-subject'))
                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['admin.subject.destroy', $data->id]
                    ]) !!}
                        <a class='btn btn-success btn-xs' href='/admin/subject/{{$data["id"]}}/edit'>
                          <i class='fa fa-edit'></i>
                          <span>Редактирай</span>
                        </a>
                        <button type="submit" class='btn btn-danger btn-xs'>
                          <i class='fa fa-remove'></i>
                          <span>Изтрий</span>
                        </button>
                    {!! Form::close() !!}
                  @else
                    @if(Entrust::can('edit-subject'))
                      <a class='btn btn-success btn-xs' href='/admin/subject/{{$data["id"]}}/edit'>
                        <i class='fa fa-edit'></i>
                        <span>Редактирай</span>
                      </a>
                    @endif

                    @if(Entrust::can('delete-subject'))
                      {!! Form::open([
                          'method' => 'DELETE',
                          'route' => ['admin.subject.destroy', $data->id]
                      ]) !!}
                          <button type="submit" class='btn btn-danger btn-xs'>
                            <i class='fa fa-remove'></i>
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
