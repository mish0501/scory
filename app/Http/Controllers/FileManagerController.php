<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;
use App\FileManager;


class FileManagerController extends Controller
{
  public function upload(Request $request)
  {

    $folder_name = Uuid::generate(4);

    $file_name = $request->file('file')->getClientOriginalName();

    $path = Storage::putFileAs(
      'public/uploads/'.$folder_name,
      $request->file('file'),
      $file_name
    );

    $url = route('file', $folder_name.'/'.$file_name);

    $file = new FileManager();
    $file->url = $url;
    $file->path = $path;

    if (strpos($request->file('file')->getMimeType(), 'image/') === 0) {
      $file->type = 'image';
    } else if (strpos($request->file('file')->getMimeType(), 'video/') === 0) {
      $file->type = 'video';
    } else if (strpos($request->file('file')->getMimeType(), 'audio/') === 0) {
      $file->type = 'audio';
    } else {
      $file->type = 'download';
    }

    $request->user()->files()->save($file);

    return $file;
  }

  public function getFile($filename)
  {
    $path = storage_path() . '/app/public/uploads/' . $filename;

    if (!File::exists($path)) {
      abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = \Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
  }

  public function getFiles()
  {
    return Auth::user()->files()->get();
  }

  public function delete($id)
  {
    $file = Auth::user()->files()->find($id)->delete();

    return;
  }
}
