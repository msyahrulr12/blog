<?php

namespace App\Helpers;

use Image, File;

use Carbon\Carbon;

class UploadImg{
  protected $imagePath = 'files/';
  protected $imageDimentions = [
    245, 300, 500
  ];
  protected $img = null;
  protected $filename = null;

  public function __construct($img){
    $this->img = $img;
    $this->makeDir($this->imagePath);
  }

  protected function randFilename(){
    $filename = Carbon::now()->timestamp.'_'.uniqid().'.'.$this->getExt();
    return $filename;
  }

  public function upload($resize = true, $box = true){
    $filename = $this->getFilename();

    $this->makeDir($this->imagePath);
    $img = $this->img;
    Image::make($img)->save($this->imagePath.$filename);
    if($resize){
      $this->resizeImg($filename, $box);
    }
    return $filename;
  }

  protected function makeDir($path){
    if($path != ''){
      if(!File::isDirectory($path)){
        File::makeDirectory($path, 0777, true);
      }
    }
  }

  protected function resizeImg($filename, $box = true){
    $img = $this->img;
    foreach($this->imageDimentions as $r){
      $image = Image::make($img);
      if($box){
        $width  = $r;
        $height = $r;
      }else{
        $w = $image->width();
        $h = $image->height();

        $width  = $r;
        $height = ($h * $width) / $w;
      }

      $canvas      = Image::canvas($width, $height);
      $resizeImage = $image->resize($width, $height, function($constraint){
          $constraint->aspectRatio();
      });
      $this->makeDir($this->imagePath.$r);
      $canvas->insert($resizeImage, 'center');
      $canvas->save($this->imagePath.$r.'/'.$filename);
    }
  }

  public function setPath($location){
    $this->imagePath .= $location;
  }

  public function getPath(){
    return $this->imagePath;
  }

  public function setFilename($filename){
    $this->filename = $filename.'.'.$this->getExt();
  }

  public function getFilename(){
    if(is_null($this->filename)){
      $this->filename = $this->randFilename();
    }
    return $this->filename;
  }

  public function getExt(){
    $img = $this->img;
    return strtolower($img->getClientOriginalExtension());
  }
}