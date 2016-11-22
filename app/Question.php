<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $appends = ['short_name'];

    protected $fillable = ['name', 'subject_id', 'partition_id', 'class', 'trash', 'type', 'user_id'];

    public $timestamps = false;

    public function subject()
    {
      return $this->belongsTo('App\Subject', 'subject_id');
    }

    public function partition()
    {
      return $this->belongsTo('App\Partition', 'partition_id');
    }

    public function answers()
    {
      return $this->hasMany('App\Answer');
    }

    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function getShortNameAttribute()
    {
      $name = $this->attributes['name'];

      $short_name = (strlen($name) > 55) ? str_limit($name, 55) : $name;
      return $short_name;
    }
}
