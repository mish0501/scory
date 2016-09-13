<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partition extends Model
{
    protected $table = 'partitions';

    protected $fillable = ['name', 'subject_id', 'class', 'trash'];

    public $timestamps = false;

    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
