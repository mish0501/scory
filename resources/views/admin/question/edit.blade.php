@extends('layouts.default')

@section('title')
  <i class="icon-question"></i>
  Редактиране на въпрос
@endsection

@section('content')

<div class="alert alert-danger hide"></div>
<div class='box-content'>
  {!! Form::model($question, [
    'method' => 'PATCH',
    'route' => ['admin.question.update', $question->id],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
  <input type="hidden" name="removedIds" id="removedIds" value="">
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на въпроса</label>
      <div class='col-md-5'>
        <input class='form-control' name='name' id="name" placeholder='Името на раздела' type='text' value="{{ (Request::old('name')) ? Request::old('name') : $question['name'] }}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Клас</label>
      <div class='col-md-5'>
        <select class="form-control" name='class' id="class">
          @for ($i = 5; $i < 13; $i++)
            <?php
              $selected = '';

              if (Request::old('class')) {
                if (Request::old('class') == $i) {
                  $selected= 'selected="selected"';
                }
              } else {
                if ($question->class == $i) {
                  $selected= 'selected="selected"';
                }
              }
            ?>
            <option {{ $selected }} value="{{ $i }}">{{$i}}. Клас</option>
          @endfor
        </select>
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Предмет</label>
      <div class='col-md-5'>
        <select class="form-control" name='subject_id' id="subject">
          @foreach($subjects as $subject)
            <?php
              $selected = '';

              if (Request::old('subject_id')) {
                if (Request::old('subject_id') == $subject->id) {
                  $selected= 'selected="selected"';
                }
              } else {
                if ($question->subject_id == $subject->id) {
                  $selected= 'selected="selected"';
                }
              }
            ?>
            <option {{ $subject }} value="{{ $subject->id }}">{{ $subject->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class='form-group '>
      <label class='col-md-2 control-label' for='name'>Раздел</label>
      <div class='col-md-5'>
        <select class="form-control" name='partition_id' id="partition">
          @foreach($partitions as $partition)
            <?php
              $selected = '';
              if (Request::old('partition_id')) {
                if (Request::old('partition_id') == $partition->id) {
                  $selected= 'selected="selected"';
                }
              } else {
                if ($question->partition_id == $partition->id) {
                  $selected= 'selected="selected"';
                }
              }
            ?>
            <option {{ $selected }} value="{{ $partition->id }}">{{ $partition->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Тип въпрос</label>
      <div class='col-md-5'>
        <select class="form-control" name='type' id="type">
          <option @if($question->type == 'one') selected=selected @endif value="one">С един верен отговор</option>
          <option @if($question->type == 'multiple') selected=selected @endif value="multiple">С повече от един верен отговор</option>
        </select>
      </div>
    </div>
    <?php $i = 0; ?>
    @foreach($answers as $answer)
      <?php
        $checked='';

        if (Request::old('correct') != NULL) {
          if (Request::old('correct') == $i) {
            $checked= 'checked="checked"';
          }
        } else {
          if ($answer->correct == 1) {
            $checked= 'checked="checked"';
          }
        }
       ?>


        <div class='form-group'>
          @if($i <= 0)
            <label class='col-md-2 control-label' for='class'>Отговори</label>
            <div class='col-md-5'>
          @else
            <div class='col-md-5 col-md-offset-2'>
          @endif
            <input class='form-control' name="answers[{{ $i }}][id]" type="hidden" id="answer_id" value="{{ $answer->id }}">
            <input class='form-control' name="answers[{{ $i }}][name]" id="answers" placeholder='Името на отговора' type='text' value="{{ (Request::old('answers.'.$i.'.name')) ? Request::old('answers.'.$i.'.name') : $answer->name }}">
          </div>
          <div class='col-md-5'>
            <div class="radio">
              <label>
                <input @if($question->type == 'one') type="radio" name='correct' @elseif($question->type = 'multiple') type="checkbox" name='correct[]' @endif value="{{ $i }}" {{ $checked }}>
                Верен отговор
              </label>
            </div>
          </div>
        </div>
      <?php $i++; ?>
    @endforeach
    <div class='form-group'>
      <div class='col-md-5 col-md-offset-2'>
        <button class='btn btn-success add-answer'>
          <i class='icon-plus'></i>
          Добави още един отговор
        </button>
        <button class='btn btn-danger remove-answer' disabled>
          <i class='icon-remove'></i>
          Изтрий последния въпрос
        </button>
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
          selectSubject = $('select#subject'),
          selectPartition = $('select#partition'),
          selectType = $('select#type'),
          addAnswer = $('button.add-answer'),
          removeAnswer = $('button.remove-answer'),
          token = $('input[name=_token]'),
          removedIds = $('input#removedIds');

      var startFormGroup = document.querySelectorAll('div.form-group');
      var startBeforeLast = startFormGroup[startFormGroup.length - 2];

      if(selectType.attr('value') === 'one'){
        var startNumber = startBeforeLast.querySelector('input[type=radio]').value;
      }else if(selectType.attr('value') === 'multiple'){
        var startNumber = startBeforeLast.querySelector('input[type=checkbox]').value;
      }

      if (startNumber >= 4) {
        removeAnswer.attr('disabled', false);
      }

      if (startNumber === 7) {
        addAnswer.attr('disabled', true);
      }

      $("form").submit(function(e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax({
          url : formURL,
          type: "POST",
          data : postData,
          success:function(data, textStatus, jqXHR) {
            if (data.type === 'redirect') {
              window.location.replace(data.url);
            }
            var data = JSON.parse(data);
            var errs = '';

            for (var prop in data) {
              errs += '<p>' + data[prop] + '</p>';
            }

            $('.alert').removeClass('hide').html(errs);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              $('.alert').removeClass('hide').html('Server error');
          }
        });
        e.preventDefault();
      });

      removeAnswer.on('click', function(e) {
        e.preventDefault();
        var formGroup = document.querySelectorAll('div.form-group');
        var len = formGroup.length - 1;
        var beforeLast = formGroup[len - 1];

        if(selectType.attr('value') === 'one'){
          var number = beforeLast.querySelector('input[type=radio]').value;
        }else if(selectType.attr('value') === 'multiple'){
          var number = beforeLast.querySelector('input[type=checkbox]').value;
        }

        var answerId = beforeLast.querySelector('input[type=hidden]#answer_id');

        if (number == 4) {
          removeAnswer.attr('disabled', true);
        }

        if (number == 7) {
          addAnswer.attr('disabled', false);
        }

        if(answerId !== null){
          var valueRemovedIds = removedIds.attr('value');
          if (valueRemovedIds === ''){
            removedIds.attr('value', answerId.value);
          }else{
            removedIds.attr('value', valueRemovedIds + ', ' + answerId.value);
          }
        }

        beforeLast.remove();
      });

      addAnswer.on('click', function(e) {
        e.preventDefault();
        var formGroup = document.querySelectorAll('div.form-group');
        var len = formGroup.length - 1;
        var beforeLast = formGroup[len - 1];

        if(selectType.attr('value') === 'one'){
            var newRadioN = parseInt(beforeLast.querySelector('input[type=radio]').value) + 1;
        }else if(selectType.attr('value') === 'multiple'){
          var newRadioN = parseInt(beforeLast.querySelector('input[type=checkbox]').value) + 1;
        }

        if (newRadioN == 7) {
          addAnswer.attr("disabled", true);
        }

        if(selectType.attr('value') === 'one'){
          var newFGroup = "<div class='form-group'>"
            +"<div class='col-md-5 col-md-offset-2'>"
              +"<input class='form-control' name='answers["+ newRadioN +"]' id='answers' placeholder='Името на отговора' type='text'>"
            +"</div>"
            +"<div class='col-md-5'>"
              +'<div class="radio">'
                +"<label>"
                  +"<input type='radio' value="+ newRadioN +" name='correct'>"
                  +"Верен отговор"
                +"</label>"
              +"</div>"
            +"</div>"
          +"</div>";
        }else if(selectType.attr('value') === 'multiple'){
          var newFGroup = "<div class='form-group'>"
            +"<div class='col-md-5 col-md-offset-2'>"
              +"<input class='form-control' name='answers["+ newRadioN +"]' id='answers' placeholder='Името на отговора' type='text'>"
            +"</div>"
            +"<div class='col-md-5'>"
              +'<div class="checkbox">'
                +"<label>"
                  +"<input type='checkbox' value="+ newRadioN +" name='correct[]'>"
                  +"Верен отговор"
                +"</label>"
              +"</div>"
            +"</div>"
          +"</div>";
        }

        $(newFGroup).insertAfter(beforeLast);
        removeAnswer.attr('disabled', false);
      });

      selectType.on('change', function() {
        var val = this.value;
        if(val == 'one'){
          var checkboxContainer = $('div.checkbox'),
              checkboxInput = $('input[type=checkbox]');

          for (var i = 0; i < checkboxContainer.length; i+= 1) {
            checkboxContainer.eq(i).addClass('radio').removeClass('radiocheckbox');
          }

          checkboxInput.each(function() {
             $("<input type='radio' />").attr({ name: this.name, value: this.value }).insertBefore(this);
          }).remove();

          $('input[type=radio]').eq(0).prop("checked", true);
        }else if(val == 'multiple'){
          var radioContainer = $('div.radio'),
              radioInput = $('input[type=radio]');

          for (var i = 0; i < radioContainer.length; i+= 1) {
            radioContainer.eq(i).addClass('checkbox').removeClass('radio');
          }

          radioInput.each(function() {
             $("<input type='checkbox' />").attr({ name: this.name + '[]', value: this.value }).insertBefore(this);
          }).remove();

          $('input[type=checkbox]').eq(0).prop("checked", true);
        }
      });

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
          selectSubject.html(selectOptions);
          selectSubject.parent().parent().removeClass('hide');
          selectPartition.parent().parent().addClass('hide');
          token.attr('value', data[0].token);
        });
      });

      selectSubject.on('change', function() {
        var getSubjects = $.ajax({
          method: 'POST',
          url: '{{ route("getPartitions") }}',
          data: {
            subject: this.value,
            _token: '{{ csrf_token() }}'
          }
        }).done(function(data) {
          var selectOptions = '<option selected disabled>Избери раздел</option>';
          for (var i = 0, len = data.length; i < len; i += 1) {
            selectOptions += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
          }
          selectPartition.html(selectOptions);
          selectPartition.parent().parent().removeClass('hide');
          token.attr('value', data[0].token);
        });
      });
    });
  </script>
@endsection
