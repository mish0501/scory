@extends('layouts.default')

@section('title')
  <i class="icon-folder-open"></i>
  Редактиране на раздел
@endsection

@section('content')
<div class='box-content'>
  {!! Form::model($partition, [
    'method' => 'PATCH',
    'route' => ['admin.partition.update', $partition->id],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на раздела</label>
      <div class='col-md-5'>
        <input class='form-control' name='name' id="name" placeholder='Името на раздела' type='text' value="{{ (Request::old('name')) ? Request::old('name') : $partition['name']}}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='class'>Клас</label>
      <div class='col-md-5'>
        <select class="form-control" name='class' id="class">
          @for ($i = 5; $i < 13; $i++)
            <?php
              $selected='';

              if (Request::old('class')) {
                if (Request::old('class') == $i) {
                  $selected= 'selected="selected"';
                }
              } else {
                if ($partition->class == $i) {
                  $selected= 'selected="selected"';
                }
              }
            ?>
            <option {{ $selected }} value='{{ $i }}'>{{ $i }}. Клас</option>
          @endfor
        </select>
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на предмета</label>
      <div class='col-md-5'>
        <select class="form-control" name='subject_id' id="subject_id" placeholder='Името на предмета'>
          @foreach ($subjects as $subject)
            <?php
              $selected='';

              if (Request::old('subject_id')) {
                if (Request::old('subject_id') == $subject->id) {
                  $selected= 'selected="selected"';
                }
              } else {
                if ($partition->subject_id == $subject->id) {
                  $selected= 'selected="selected"';
                }
              }
            ?>
            <option {{ $selected }} value='{{$subject->id}}'>{{ $subject->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class='form-actions form-actions-padding-sm'>
      <div class='row'>
        <div class='col-md-10 col-md-offset-2'>
          <button class='btn btn-primary' type='submit'>
            <i class='icon-save'></i>
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
