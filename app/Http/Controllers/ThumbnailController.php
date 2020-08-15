<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Thumbnail;
use Illuminate\Http\Request;

class ThumbnailController extends Controller
{
      public function testThumbnail(Request $request)
  {

  //	dd($request->all());
    // get file from input data
    $file             = $request->file('file');

    // get file type
    $extension_type   = $file->getClientMimeType();
    
    // set storage path to store the file (actual video)
    $destination_path = storage_path().'/uploads';

    // get file extension
    $extension        = $file->getClientOriginalExtension();


    $timestamp        = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
    $file_name        = $timestamp;
    
    $upload_status    = $file->move($destination_path, $file_name);         

    if($upload_status)
    {
      // file type is video
      // set storage path to store the file (image generated for a given video)
       $thumbnail_path   = storage_path().'/images';

       $video_path       = $destination_path.'/'.$file_name;

      // set thumbnail image name
       $thumbnail_image  = "efrfrff".".".$timestamp.".jpg";
      
      // set the thumbnail image "palyback" video button
    //  $water_mark       = storage_path().'/watermark/p.png';

      // get video length and process it
      // assign the value to time_to_image (which will get screenshot of video at that specified seconds)
      //$data['video_length'] = 0.19;
      // $time_to_image    = floor(($data['video_length'])/2);
      // time of image to create thumbnail
       $time_to_image    = 2;


      $thumbnail_status = Thumbnail::getThumbnail($video_path,$thumbnail_path,$thumbnail_image,$time_to_image);
      if($thumbnail_status)
      {
        echo "Thumbnail generated";
      }
      else
      {
        echo "thumbnail generation has failed";
      }
    }
  }
}
