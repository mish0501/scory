<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestRoom extends Model
{
    protected $table = 'testroom';

    protected $fillable = ['code', 'teacher_id', 'subject_id', 'partition_id', 'class', 'questions_id', 'status', 'duration', 'test_started', 'trash'];

    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }

    public function partition()
    {
        return $this->belongsTo('App\Partition', 'partition_id');
    }

    public function questions()
    {
        return $this->hasMany('App\Question', 'questions_id');
    }
}
