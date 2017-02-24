@extends('layouts.default')

@section('title')
  <i class="fa fa-folder-open"></i>
  Добавяне на раздел
@endsection

@section('content')
<div class='box-content'>
  {!! Form::open([
    'route' => ['admin.partition.store'],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на раздела</label>
      <div class='col-md-5'>
        <input class='form-control' name='name' id="name" placeholder='Името на раздела' type='text' value="{{ (Request::old('name')) ? Request::old('name') : ''}}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Клас</label>
      <div class='col-md-5'>
        <select class="form-control" name='class' id="class">
          <option selected disabled>Избери клас</option>
          @for ($i = 5; $i < 13; $i++)
            <option value="{{ $i }}">{{$i}}. Клас</option>
          @endfor
        </select>
      </div>
    </div>
    <div class='form-group hide'>
      <label class='col-md-2 control-label' for='name'>Предмет</label>
      <div class='col-md-5'>
        <select class="form-control" name='subject_id' id="subject_id"></select>
      </div>
    </div>
    <div class='form-actions form-actions-padding-sm'>
      <div class='row'>
        <div class='col-md-10 col-md-offset-2'>
          <button class='btn btn-primary' type='submit'>
            <i class='fa fa-save'></i>
            Запази
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $(document).ready(function() {
    var selectClass = $('select#class'),
        selectSubject = $('select#subject_id'),
        token = $('input[name=token]');

    selectClass.on('change', function() {
      var getSubjects = $.ajax({
        method: 'POST',
        url: '{{ route("getSubjects") }}',
        data: {
          class: this.value,
          _token: '{{ csrf_token() }}'
        }
      }).done(function(data) {
        var selectOptions = '<option selected disabled>Избери предмет</option>';
        for (var i = 0, len = data.length; i < len; i += 1) {
          selectOptions += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
        }
        console.log(selectOptions);
        selectSubject.html(selectOptions);
        selectSubject.parent().parent().removeClass('hide');
        token.attr('value', data[0].token);
      });
    });
  });
</script>
@endsection
