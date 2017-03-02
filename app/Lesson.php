<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
  protected $fillable = [
    'name',
    'class',
    'subject_id',
    'partition_id',
    'text',
    'trash'
  ];

  public function subject()
  {
    return $this->belongsTo('App\Subject', 'subject_id');
  }

  public function partition()
  {
    return $this->belongsTo('App\Partition', 'partition_id');
  }

  public function files() {
    return $this->belongsToMany('App\FileManager', 'file_lesson', 'lesson_id', 'file_id');
  }
}
