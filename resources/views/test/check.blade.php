@extends('layouts.test')

@section('content')
  @foreach($questions as $key => $question)
    @if($question->correct == 1)
      <div class="true">
        <div class="row">
          <div class="col-md-12">
            <h1 class="tabs name">{{ $question->name }}</h1>
          </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-8 col-md-offset-2">
          @foreach($answers[$key] as $answer)
            <?php
              $typeAnswer = "";
              if($answer->checked == 1){
                if($answer->correct == 1){
                  $typeAnswer = "true-answer";
                }elseif($answer->correct == 0){
                    $typeAnswer = "false-answer";
                }
              }
            ?>
            <h4 class="tabs {{ $typeAnswer }}">{{ $answer->name }}</h4>
          @endforeach
          </div>
        </div>
      </div>
    @elseif($question->correct == 0)
      <div class="false">
        <div class="row">
          <div class="col-md-12">
            <h1 class="tabs name">{{ $question->name }}</h1>
          </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-8 col-md-offset-2">
          @foreach($answers[$key] as $answer)
            <?php
              $typeAnswer = "";
              if($answer->checked == 1){
                if($answer->correct == 1){
                  $typeAnswer = "true-answer";
                }elseif($answer->correct == 0){
                    $typeAnswer = "false-answer";
                }
              }elseif(!isset($answer->checked)){
                if($answer->correct == 1){
                  $typeAnswer = "true-answer";
                }
              }
            ?>
            <h4 class="tabs {{ $typeAnswer }}">{{ $answer->name }}</h4>
          @endforeach
          </div>
        </div>
      </div>
    @endif
  @endforeach
@endsection
