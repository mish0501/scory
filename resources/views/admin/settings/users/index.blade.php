@extends('layouts.default')

@section('title')
  <i class="icon-cogs"></i>
  Всички потребители
@endsection

@section('content')
<div class='box-content'>
  <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
    <thead>
      <tr>
        <th>
          Име на потребителя
        </th>
        <th>
          E-mail
        </th>
        <th>
          Роля
        </th>
        </th>
        <th>
          Опции
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->role->display_name }}</td>
          <td>
            <div class='text-right'>
              <a class='btn btn-success btn-xs' href='/admin/settings/users/{{$user->id}}/edit'>
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
@endsection

@section('javascript')
  <script src="../assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="../assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
@endsection
