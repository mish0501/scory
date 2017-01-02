<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
  protected $table = 'invite';

  protected $fillable = ['invite', 'email'];

  public $timestamps = false;
}
