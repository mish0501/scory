@extends('layouts.default')

@section('title')
  <i class="icon-cogs"></i>
  Всички права
@endsection

@if(Entrust::can('create-permissions'))
  @section('create-button')
  <div class='pull-right'>
    <div class='btn-group'>
      <a class="btn btn-success" href="{{ route('admin.settings.permissions.create') }}">
        <i class='icon-plus'></i>
        Добави право
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
            Име на правото
          </th>
          <th>
            Име на правото в системата
          </th>
          <th>
            Описание
          </th>
          </th>
          <th>
            Опции
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($permissions as $permission)
          <tr>
            <td>{{ $permission->display_name }}</td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->description }}</td>
            <td>
              <div class='text-right'>
                <a class='btn btn-success btn-xs' href='/admin/settings/permissions/{{$permission->id}}/edit'>
                  <i class='icon-edit'></i>
                  <span>Редактирай</span>
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
  <script src="../assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="../assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
@endsection
