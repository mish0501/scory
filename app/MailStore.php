<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailStore extends Model
{
  protected $table = 'mail_store';

  protected $fillable = ['name', 'email', 'subject', 'message', 'read', 'trash'];
}
