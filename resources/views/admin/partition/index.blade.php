@extends('layouts.default')

@section('title')
  <i class="fa fa-folder-open"></i>
  Всички раздели
@endsection

@if(Entrust::can('create-partition'))
  @section('create-button')
  <div class='pull-right'>
    <div class='btn-group'>
      <a class="btn btn-success" href="{{ route('admin.partition.create') }}">
        <i class='fa fa-plus'></i>
        Добави раздел
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
            Име на раздела
          </th>
          <th>
            Име на предмета
          </th>
          <th>
            Клас
          </th>
          @if(Entrust::can('edit-partition') || Entrust::can('delete-parttion'))
            <th>
              Опции
            </th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach ($partitions as $data)
          <tr>
            <td>{{ str_limit($data->name, 55) }}</td>
            <td>{{ $data->subject->name }}</td>
            <td class="class-col">{{ $data->class }}. Клас</td>
            @if(Entrust::can('edit-partition') || Entrust::can('delete-parttion'))
              <td>
                <div class='text-right'>
                  @if(Entrust::can('edit-partition') && Entrust::can('delete-partition'))
                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['admin.partition.destroy', $data->id]
                    ]) !!}
                        <a class='btn btn-success btn-xs' href='/admin/partition/{{ $data->id }}/edit'>
                          <i class='fa fa-edit'></i>
                          <span>Редактирай</span>
                        </a>
                        <button type="submit" class='btn btn-danger btn-xs'>
                          <i class='fa fa-remove'></i>
                          <span>Изтрий</span>
                        </button>
                    {!! Form::close() !!}
                  @else
                    @if(Entrust::can('edit-partition'))
                      <a class='btn btn-success btn-xs' href='/admin/partition/{{ $data->id }}/edit'>
                        <i class='fa fa-edit'></i>
                        <span>Редактирай</span>
                      </a>
                    @endif

                    @if(Entrust::can('delete-partition'))
                      {!! Form::open([
                          'method' => 'DELETE',
                          'route' => ['admin.partition.destroy', $data->id]
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
  <script type="text/javascript">
      $(document).ready(function() {
        var selectClass = $('select#class');

        selectClass.on('change', function() {
          $('tbody tr').each(function() {
            if (this.querySelector('td.class-col').innerHTML != selectClass[0].value + '. Клас') {
              this.style.display = 'none';
              return;
            }
            this.style.display = '';
          });
        });
      });
  </script>
@endsection
