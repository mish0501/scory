@extends('layouts.test')

@section('content')
  {!! Form::open([
    'url' => '/nextQuestion',
    'class' => 'form',
    'autocomplete' => 'off'
    ]) !!}
    <div class="row">
      <div class="col-md-12">
        <h1 class="tabs">{{ $question->name }}</h1>
        <input type="hidden" name="key" value="{{ $key }}">
        @if(isset($testroomcode))
          <input type="hidden" name="code" value="{{ $testroomcode }}">
        @endif
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-md-12">
      @foreach($answers as $answer)
        <div @if($type=='one') class="radio" @elseif($type=='multiple') class='checkbox' @endif>
          <label class="tabs">
            <input @if($type=='one') type="radio" class="radio-input" name="correct" @elseif($type=='multiple') type='checkbox' class="checkbox-input" name="correct[]" @endif value="{{ $answer->id }}" > <h4>{{ $answer->name }}</h4>
          </label>
        </div>
      @endforeach
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 submit">
          <button type="submit" disabled class="btn btn-success btn-lg btn-block">Продължи напред</button>
      </div>
    </div>
@endsection
