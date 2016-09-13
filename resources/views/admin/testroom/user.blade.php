@extends('layouts.default')

@section('title')
  <i class="icon-group"></i>
  Резултати на ученикът/чката {{$student->name}} {{$student->lastname}}
@endsection

@section('content')
  @if(is_array($questions))
    <div class="alert alert-info alert-dismissable">
      <a class="close" data-dismiss="alert" href="#">×</a>
      <h4>
        <i class="icon-info-sign"></i>
        Информация
      </h4>
      Натиснете върху въпроса, за да видите какви са отговорите на ученикът/чката.<br>
      Отговорите оцветени с зелено са верните отговори към въпроса, тези оцветени в червено са грешно посочените от ученикът/чката, а тези в синьо-зелено са вярно посочените от ученикът/чката.
    </div>
  @else
    <div class="alert alert-danger alert-dismissable">
      <a class="close" data-dismiss="alert" href="#">×</a>
      <h4>
        <i class="icon-remove-sign"></i>
        Информация
      </h4>
      Няма данни за отговорите на този ученик/чка.
    </div>
  @endif

  <div class='accordion accordion-green panel-group' id='questions' style='margin-bottom:0;'>
    @if(is_array($questions))
      @foreach($questions as $question)
        <div class="panel panel-default">
          <div class="panel-heading">
            <a class="accordion-toggle" data-parent="#questions" data-toggle="collapse" href="#{{$question->id}}">
              {{$question->name}}
            </a>
          </div>
          <div class="panel-collapse collapse" id="{{$question->id}}">
            <div class="panel-body">
              @foreach($question->answers as $answer)
                <?php
                  $style = '';

                    if($answer->correct == true){
                      $style = "style=background-color:green;color:whitesmoke;";
                    }

                    if($answer->correct == true && $answer->checked){
                      $style = "style=background-color:aquamarine;";
                    }

                    if($answer->correct == false && $answer->checked){
                      $style = "style=background-color:red;color:whitesmoke;";
                    }
                ?>
                <div class="well" {{$style}}>{{$answer->name}}</div>
              @endforeach
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
@endsection
