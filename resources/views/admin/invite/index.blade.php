@extends('layouts.default')

@section('title')
  <i class="icon-envelope"></i>
  Всички покани
@endsection

@if(Entrust::can('create-invitation') && Entrust::hasRole('admin'))
  @section('create-button')
  <div class='pull-right'>
    <div class='btn-group'>
      <a class="btn btn-success" href="{{ route('admin.invite.create') }}">
        <i class='icon-plus'></i>
        Създай покана
      </a>
    </div>
  </div>
  @endsection
@endif

@section('content')
<div class='box-content'>
  <div class='responsive-table'>
    <div class='scrollable-area'>
      <table class='table table-bordered table-hover table-striped' style='margin-bottom:0;'>
        <thead>
          <tr>
            <th>
              Поканата
            </th>
            <th>
              E-mail
            </th>
            @if(Entrust::can('delete-invitation'))
              <th>
                Опции
              </th>
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach ($invites as $invite)
            <tr>
              <td>@if ($invite->invite != NULL) {{$invite->invite}} @else Няма изпратена покана @endif</td>
              <td>{{ $invite->email }}</td>
              @if(Entrust::can('delete-invitation'))
                <td>
                  <div class='text-right'>
                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['admin.invite.destroy', $invite->id]
                    ]) !!}
                        <button type="submit" class='btn btn-danger btn-xs'>
                          <i class='icon-remove'></i>
                          <span>Изтрий</span>
                        </button>
                    {!! Form::close() !!}
                    @if ($invite->invite == NULL)
                      <br>
                      <a class='btn btn-success btn-xs' href='/admin/invite/create/{{ $invite->email }}'>
                        <i class='icon-mail-forward'></i>
                        <span>Изпрати покана</span>
                      </a>
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
</div>
@endsection
