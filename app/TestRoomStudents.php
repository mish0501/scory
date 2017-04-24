<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestRoomStudents extends Model
{
  protected $table = 'testroom_students';

  protected $fillable = ['code', 'number', 'correct', 'checked_answers', 'trash'];

  public $timestamps = false;

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
