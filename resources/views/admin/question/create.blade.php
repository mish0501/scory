@extends('layouts.default')

@section('title')
  <i class="icon-question"></i>
  Добавяне на въпрос
@endsection

@section('content')
<div class="alert alert-danger hide"></div>
<div class='box-content'>
  {!! Form::open([
    'route' => ['admin.question.store'],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на въпроса</label>
      <div class='col-md-5'>
        <input class='form-control' name='name' id="name" placeholder='Името на въпроса' type='text' value="{{Request::old('name')}}">
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
        <select class="form-control" name='subject_id' id="subject"></select>
      </div>
    </div>
    <div class='form-group hide'>
      <label class='col-md-2 control-label' for='name'>Раздел</label>
      <div class='col-md-5'>
        <select class="form-control" name='partition_id' id="partition"></select>
      </div>
    </div>

    <div class='form-group'>
      <label class='col-md-2 control-label' for='class'>Отговори</label>
      <br class="hidden-md hidden-lg">
      <div class='col-md-5 col-sm-11 col-xs-10'>
        <input class='form-control' name='answers[0]' id="answers" placeholder='Името на отговора' type='text'>
      </div>
      <div class='col-md-5 col-sm-1 col-xs-1'>
        <div class="checkmark">
          <label>
            <i class="icon-ok"></i>
            <input type="checkbox" class="hide" value="0" name='correct[]'>
          </label>
        </div>
      </div>
    </div>
    <div class='form-group'>
      <div class='col-md-5 col-md-offset-2 col-sm-11 col-xs-10'>
        <input class='form-control' name='answers[1]' id="answers" placeholder='Името на отговора' type='text'>
      </div>
      <div class='col-md-5 col-sm-1 col-xs-1'>
        <div class="checkmark">
          <label>
            <i class="icon-ok"></i>
            <input type="checkbox" class="hide" value="1" name='correct[]'>
          </label>
        </div>
      </div>
    </div>
    <div class='form-group'>
      <div class='col-md-5 col-md-offset-2 col-sm-11 col-xs-10'>
        <input class='form-control' name='answers[2]' id="answers" placeholder='Името на отговора' type='text'>
      </div>
      <div class='col-md-5 col-sm-1 col-xs-1'>
        <div class="checkmark">
          <label>
            <i class="icon-ok"></i>
            <input type="checkbox" class="hide" value="2" name='correct[]'>
          </label>
        </div>
      </div>
    </div>
    <div class='form-group'>
      <div class='col-md-5 col-md-offset-2 col-sm-11 col-xs-10'>
        <input class='form-control' name='answers[3]' id="answers" placeholder='Името на отговора' type='text'>
      </div>
      <div class='col-md-5 col-sm-1 col-xs-1'>
        <div class="checkmark">
          <label>
            <i class="icon-ok"></i>
            <input type="checkbox" class="hide" value="3" name='correct[]'>
          </label>
        </div>
      </div>
    </div>
    <div class='form-group'>
      <div class='col-md-5 col-md-offset-2'>
        <button class='btn btn-success add-answer'>
          <i class='icon-plus'></i>
          Добави още един отговор
        </button>
        <br class="hidden-lg hidden-sm">
        <br class="hidden-lg hidden-sm">
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


@section('style')
  <link href="../assets/stylesheets/plugins/common/bootstrap-wysihtml5.css" media="all" rel="stylesheet" type="text/css" />
  <style media="screen">
    .checkmark{
      color: #eee;
      background-color: #ddd;
      border-radius: 50%;
      border: #ddd 5px solid;
      width: 28px;
      height: 28px;
      position: absolute;
      text-align: center;
      line-height: 19px;
      font-size: 14pt;
      margin-left: -20px;
      margin-top: 2px;
      cursor: pointer;
    }

    .checkmark label{
      cursor: pointer;
    }

    .checkmark.checked{
      color: #fff;
      background-color: #5daf2b;
      border: #5daf2b 5px solid;
    }
  </style>
@endsection

@section('javascript')
  <script src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script>
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
          addAnswer = $('button.add-answer'),
          removeAnswer = $('button.remove-answer'),
          checkbox = $('.checkmark'),
          token = $('input[name=_token]');

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

        var number = beforeLast.querySelector('input[type=checkbox]').value;

        if (number == 4) {
          removeAnswer.attr('disabled', true);
        }

        if (number == 7) {
          addAnswer.attr('disabled', false);
        }

        beforeLast.remove();
      });

      addAnswer.on('click', function(e) {
        e.preventDefault();
        var formGroup = document.querySelectorAll('div.form-group');
        var len = formGroup.length - 1;
        var beforeLast = formGroup[len - 1];

        var newRadioN = parseInt(beforeLast.querySelector('input[type=checkbox]').value) + 1;

        if (newRadioN == 7) {
          addAnswer.attr("disabled", true);
        }

        var newFGroup = "<div class='form-group'>"
          +"<div class='col-md-5 col-md-offset-2 col-sm-11 col-xs-10'>"
            +"<input class='form-control' name='answers["+ newRadioN +"]' id='answers' placeholder='Името на отговора' type='text'>"
          +"</div>"
          +"<div class='col-md-5 col-sm-1 col-xs-1'>"
            +'<div class="checkmark">'
              +"<label>"
                +"<i class='icon-ok'></i>"
                +"<input type='checkbox' class='hide' value='"+ newRadioN +"' name='correct[]'>"
              +"</label>"
            +"</div>"
          +"</div>"
        +"</div>";

        $(newFGroup).insertAfter(beforeLast);
        removeAnswer.attr('disabled', false);
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

      $('.checkmark input').live('change', function(){
        $(this).parent().parent().toggleClass('checked');
      });
    });
  </script>
@endsection
