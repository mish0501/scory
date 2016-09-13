@extends('layouts.test')

@section('title')
  @if(isset($class))
    Избери си клас
  @elseif(isset($subjects))
    Избери си предмет
  @elseif(isset($partitions))
    Избери си раздел
  @endif
@endsection

@section('content')
  @if(isset($class))
    {!! Form::open([
      'route' => ['subject'],
      'class' => 'form',
      'autocomplete' => 'off'
      ]) !!}
    <div class="form-group">
      <select class="form-control tabs input-lg" name="class">
        @for($i=5; $i < 13; $i++)
          <option name='class' value="{{$i}}">{{$i}}. Клас</option>
          @endfor
        </select>
    </div>
  @elseif(isset($subjects))
    {!! Form::open([
      'route' => ['partition'],
      'class' => 'form',
      'autocomplete' => 'off'
      ]) !!}
    <div class="form-group">
      <input type="hidden" name="class" value="{{ $selectedClass }}">
      <select class="form-control tabs input-lg" name="subject_id">
        @foreach($subjects as $subject)
          <option value="{{ $subject->id }}">{{ $subject->name }}</option>
        @endforeach
      </select>
    </div>
  @elseif(isset($partitions))
    {!! Form::open([
      'route' => ['selectQuestion'],
      'class' => 'form',
      'autocomplete' => 'off'
    ]) !!}
    <div class="form-group">
      <input type="text" name="class" value="{{$selectedClass}}" hidden>
      <input type="text" name="subject_id" value="{{$subject}}" hidden>
      <select class="form-control tabs input-lg" name="partition_id">
        @foreach($partitions as $partition)
            <option value="{{ $partition->id }}">{{ $partition->name }}</option>
        @endforeach
      </select>
    </div>
  @endif

    <button type="submit" class="btn btn-primary btn-lg btn-block">Продължи напред</button>
  </form>
@endsection
