How to Install FFmpeg on Ubuntu 18.04 & 16.04


Step 1 – Setup FFmpeg PPA 

FFmpeg 4 is the latest available version for installation on Ubuntu. To install the latest version, you need to configure PPA on your system. Execute below command to add FFmpeg PPA on Ubuntu system.

		sudo add-apt-repository ppa:jonathonf/ffmpeg-4

This PPA contains packages for Ubuntu 18.04 (Bionic) and 16.04 LTS (Xenial) only.


		sudo apt-get update
		sudo apt-get install ffmpeg


Step 2 – Install FFmpeg on Ubuntu

After enabling the PPA, Lets exec below commands to install ffmpeg on Ubuntu system. This will also install many packages for the dependencies.


		sudo apt-get update
		sudo apt-get install ffmpeg

Step 3 – Check FFmpeg Version

		ffmpeg -version


		version 4.3-2~18.04.york0 Copyright (c) 2000-2020 the FFmpeg developers
		built with gcc 7 (Ubuntu 7.5.0-3ubuntu1~18.04)
		configuration: --prefix=/usr --extra-version='2~18.04.york0' --toolchain=hardened --libdir=/usr/lib/x86_64-linux-gnu --incdir=/usr/include/x86_64-linux-gnu --arch=amd64 --enable-gpl --disable-stripping --enable-avresample --disable-filter=resample --enable-gnutls --enable-ladspa --enable-libaom --enable-libass --enable-libbluray --enable-libbs2b --enable-libcaca --enable-libcdio --enable-libcodec2 --enable-libflite --enable-libfontconfig --enable-libfreetype --enable-libfribidi --enable-libgme --enable-libgsm --enable-libjack --enable-libmp3lame --enable-libmysofa --enable-libopenjpeg --enable-libopenmpt --enable-libopus --enable-libpulse --enable-librabbitmq --enable-librsvg --enable-librubberband --enable-libshine --enable-libsnappy --enable-libsoxr --enable-libspeex --enable-libsrt --enable-libssh --enable-libtheora --enable-libtwolame --enable-libvidstab --enable-libvorbis --enable-libvpx --enable-libwavpack --enable-libwebp --enable-libx265 --enable-libxml2 --enable-libxvid --enable-libzmq --enable-libzvbi --enable-lv2 --enable-omx --enable-openal --enable-opencl --enable-opengl --enable-sdl2 --enable-pocketsphinx --enable-libdc1394 --enable-libdrm --enable-libiec61883 --enable-chromaprint --enable-frei0r --enable-libx264 --enable-shared
		libavutil      56. 51.100 / 56. 51.100
		libavcodec     58. 91.100 / 58. 91.100
		libavformat    58. 45.100 / 58. 45.100
		libavdevice    58. 10.100 / 58. 10.100
		libavfilter     7. 85.100 /  7. 85.100
		libavresample   4.  0.  0 /  4.  0.  0
		libswscale      5.  7.100 /  5.  7.100
		libswresample   3.  7.100 /  3.  7.100
		libpostproc    55.  7.100 / 55.  7.100



How to install package for generating  thumbnail using  "lakshmaji Thumbnail pacckage"
 link : -https://github.com/lakshmaji/Thumbnail

step -1  instal package 

		composer require lakshmaji/thumbnail

step -2 Add the Service Provider to providers array in config/app.php

		Lakshmaji\Thumbnail\ThumbnailServiceProvider::class,

step -3 Add the Facade to aliases array

		'Thumbnail' => Lakshmaji\Thumbnail\Facade\Thumbnail::class,

step -4 Publish the configuration file , this will publish thumbnail.php file to your application config directory.

		php artisan vendor:publish

		after this command ,press a number of line which contain this text 

		[8 ] Provider: Lakshmaji\Thumbnail\ThumbnailServiceProvider

		like 8 , this line  contain 8 number



step - 4 to create  controller ThumbnailController


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



Step -5 Upate ffmpeg of your linux server

		
		<?php

		/*
		|--------------------------------------------------------------------------
		| File which returns array of constants containing the thumbnail 
		| integration configurations. 
		|--------------------------------------------------------------------------
		|
		*/

		return array(

		    /*
		    |--------------------------------------------------------------------------
		    | FFMPEG BINARIES CONFIGURATIONS
		    |--------------------------------------------------------------------------
		    |
		    | If you want to give binary paths explicitly, you can configure the FFMPEG 
		    | binary paths set to the below 'env' varibales.
		    |
		    | NOTE: FFMpeg will autodetect ffmpeg and ffprobe binaries.
		    |
		    */

		    'binaries' => [
		        'enabled' => env('FFMPEG_BINARIES',true),
		        'path'    => [
		            'ffmpeg'  => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),
		            'ffprobe' => env('FFPROBE_PATH', '/usr/bin/ffprobe'),
		            'timeout' => env('FFMPEG_TIMEOUT', 3600), // The timeout for the underlying process
		            'threads' => env('FFMPEG_THREADS', 12), // The number of threads that FFMpeg should use
		        ],

		    ],

		    /*
		    |--------------------------------------------------------------------------
		    | Thumbnail image dimensions
		    |--------------------------------------------------------------------------
		    |
		    | Specify the dimensions for thumbnail image
		    |
		    */

		    'dimensions' => [
		        'width'  => env('THUMBNAIL_IMAGE_WIDTH', 50),
		        'height' => env('THUMBNAIL_IMAGE_HEIGHT', 50),
		    ],

		    /*
		    |--------------------------------------------------------------------------
		    | Thumbnail watermark alpha
		    |--------------------------------------------------------------------------
		    |
		    | Specify the secret THUMBNAIL_X
		    |
		    */

		    'watermark' => [
		        'image' => [
		            'enabled' => env('WATERMARK_IMAGE', false),
		            'path'    => env('WATERMARK_PATH', 'http://voluntarydba.com/pics/YouTube%20Play%20Button%20Overlay.png'),
		        ],
		        'video' => [
		            'enabled' => env('WATERMARK_VIDEO', false),
		            'path'    => env('WATERMARK_PATH', ''),
		        ],
		    ],

		    /*
		    |--------------------------------------------------------------------------
		    | Thumbnail some x
		    |--------------------------------------------------------------------------
		    |
		    | Specify the secret THUMBNAIL_X
		    |
		    */

		    'THUMBNAIL_X' => '<YOUR_THUMBNAIL_X>',

		);

		// php artisan vendor:publish

		// end of file thumbnail.php


step -6  To check ffmpeg path in linux server

		which ffmpeg

		and 

		which ffprobe

step -7 To give storage permission use this command

		sudo chmod 777 storage/images