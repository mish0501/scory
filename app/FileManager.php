<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'files';

  protected $appends = ['data'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['url', 'user_id', 'type'];

  public static function boot()
  {
    parent::boot();

    static::deleting(function($file){
      $path = storage_path() . '/app/public/uploads' .$file->data['folder'];

      \File::deleteDirectory($path);
    });

  }

  public function user()
  {
    return $this->belongsTo('App\User', 'id');
  }

  public function getDataAttribute()
  {
    $url = $this->attributes['url'];

    $filename = str_replace(route('file'), '', $url);
    $path = storage_path() . '/app/public/uploads' . $filename;

    if (!\File::exists($path)) {
      return '';
    }

    $file = new \SplFileInfo($path);

    $data = [
      'name' => $file->getFilename(),
      'size' => $file->getSize(),
      'type' => mime_content_type($path),
      'folder' => str_replace('/'.$file->getFilename(), '', $filename)
    ];

    return $data;
  }
}
