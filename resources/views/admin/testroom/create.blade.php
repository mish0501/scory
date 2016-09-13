@extends('layouts.default')

@section('title')
  <i class="icon-group"></i>
    Нова стая
@endsection

@section('content')
<div class='row'>
  <div class='col-sm-12'>
    <div class='box-content'>
      {!! Form::open([
        'route' => ['admin.testroom.store'],
        'class' => 'form form-horizontal',
        'autocomplete' => 'off'
      ]) !!}
        <div class='form-group'>
          <label class='col-md-2 control-label' for='code'>Код на стаята</label>
          <div class='col-md-5'>
            <input class='form-control' disabled id="code" placeholder='Код на стаята' type='text' value="{{(Request::old('code') !== NULL) ? Request::old('code') : $code}}">
            <input name='code' id="code" type='hidden' value="{{(Request::old('code') !== NULL) ? Request::old('code') : $code}}">
          </div>
          <div class='col-md-5'>
            <input class="btn btn-primary codegen" style="margin-bottom:5px" value="Генерирай отново" type="button">
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
        <div class='form-group hide'>
          <label class='col-md-2 control-label' for='name'>Въпроси</label>
          <div class='col-md-10'>
            <select id='questions' name='questions[]' multiple='multiple'></select>
          </div>
          <br>
          <div class="col-md-5 col-md-offset-2" style="margin-top:5px">
            <div class="col-md-5 col-sm-12 random-question input">
              <input type="number" min="5" value="5" step="1" class="form-control" id="random_question" />
            </div>
            <div class="col-md-6 col-sm-12 random-question button">
              <input type="button" id="random_question" class="btn btn-primary btn-block" value="Избери произволни въпроси">
            </div>
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
  </div>
</div>
@endsection

@section('style')
  <link rel="stylesheet" href="/admin/assets/stylesheets/plugins/multi-select/multi-select.css" charset="utf-8">
  <style media="screen">
    @media (max-width : 992px) {
      .random-question{
        padding: 0 !important;
      }

      .btn{
        margin-top: 5px;
      }
    }

    @media (min-width : 992px) {
      .random-question.input{
        padding:0 5px 0 0 !important;
      }

      .random-question.button{
        padding:0 0 0 5px !important;
      }
    }
  </style>
@endsection

@section('javascript')
  <script src="/admin/assets/javascripts/plugins/quicksearch/jquery.quicksearch.js" charset="utf-8"></script>
  <script src="/admin/assets/javascripts/plugins/multi-select/multi-select.js" charset="utf-8"></script>

  <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
      var selectClass = $('select#class');
      var selectSubject = $('select#subject');
      var selectPartition = $('select#partition');
      var questionCount = $('input#questionCount');
      var randomQuestionBtn = $('#random_question[type=button]');
      var randomQuestionInput = $('#random_question[type=number]');
      var codeGenerate = $('input.codegen');
      var questionSelect = $('select#questions');
      var token = $('input[name=_token]');


      questionSelect.multiSelect({
        keepOrder: true,
        selectableHeader: "<input type='text' id='selectableHeader' class='search-input form-control' style='margin-bottom:5px' autocomplete='off' placeholder='Потърси въпрос'>",
        selectionHeader: "<input type='text' id='selectionHeader' class='search-input form-control' style='margin-bottom:5px' autocomplete='off' placeholder='Потърси въпрос'>",
        afterInit: function(ms){
          var that = this,
              $selectableSearch = that.$selectableUl.prev(),
              $selectionSearch = that.$selectionUl.prev(),
              selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
              selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

          that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
          .on('keydown', function(e){
            if (e.which === 40){
              that.$selectableUl.focus();
              return false;
            }
          });

          that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
          .on('keydown', function(e){
            if (e.which == 40){
              that.$selectionUl.focus();
              return false;
            }
          });
        },
        afterSelect: function(){
          this.qs1.cache();
          this.qs2.cache();
        },
        afterDeselect: function(){
          this.qs1.cache();
          this.qs2.cache();
        }
      });

      codeGenerate.on('click', function(){
        var getSubjects = $.ajax({
          method: 'POST',
          url: '{{ route("codeGenerate") }}',
          data: {
            _token: '{{ csrf_token() }}'
          }
        }).done(function(data) {
          $('input#code').attr('value', data.code);
          token.attr('value', data.token);
        });
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

          questionSelect.parent().parent().addClass('hide');
          questionSelect.find('option').remove();

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

          questionSelect.parent().parent().addClass('hide');
          questionSelect.find('option').remove();

          token.attr('value', data[0].token);
        });
      });

      selectPartition.on('change', function() {
        var getSubjects = $.ajax({
          method: 'POST',
          url: '{{ route("questionGenerate") }}',
          data: {
            class: selectClass.attr('value'),
            subject: selectSubject.attr('value'),
            partition: selectPartition.attr('value'),
            _token: '{{ csrf_token() }}'
          }
        }).done(function(data) {
          var options = '';

          for (var i = 0, lenI = data.length; i < lenI; i++) {
            options += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
          }

          questionSelect.html(options);
          questionSelect.multiSelect('refresh');
          randomQuestionInput.attr('max', questionSelect.find('option').length);
          randomQuestionInput.attr('value', 5);
          questionSelect.parent().parent().removeClass('hide');
          token.attr('value', data[0].token);
        });
      });

      randomQuestionBtn.on('click', function () {
        var questionsCount = parseInt(randomQuestionInput.attr('value'), 10);
        var maxQuestionCount = parseInt(randomQuestionInput.attr('max'), 10);
        var options = questionSelect.find('option');
        var optionsCount = options.length;

        if(questionsCount > maxQuestionCount){
          questionsCount = maxQuestionCount;
        }

        var arr = randomArr(optionsCount, questionsCount);

        questionSelect.multiSelect('deselect_all');
        for (var i = 0, length = arr.length; i < length; i += 1) {
          var questionId = options.eq(arr[i]).attr('value');
          questionSelect.multiSelect('select', questionId);
        }
      });

      function randomArr(size, count) {
        var randomArr = []

        while (randomArr.length < count) {
          var randomnumber = Math.floor(Math.random() * size);
          var found = false;

          for (var i = 0; i < randomArr.length; i++) {
            if(randomArr[i] == randomnumber){
              found = true;
              break;
            }
          }

          if (!found) {
            randomArr[randomArr.length] = randomnumber;
          }
        }

        return randomArr;
      }
    });
  </script>
@endsection
