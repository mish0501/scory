<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestRoomStudents extends Model
{
  protected $table = 'testroom_students';

  protected $fillable = ['code', 'name', 'lastname', 'number', 'correct', 'checked_answers', 'trash'];

  public $timestamps = false;
}
