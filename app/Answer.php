<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
  protected $table = 'answers';

  protected $fillable = ['name', 'question_id', 'correct', 'trash'];

  public $timestamps = false;

  public function questions()
  {
      return $this->belongsTo('App\Question', 'question_id');
  }
}
