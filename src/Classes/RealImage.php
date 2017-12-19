<?php

/*
 * (c)2017
 * www.vasya.pro
 */

namespace Vs\Paletter;

class RealImage extends Image {

  protected $colorsInt = [];

  public function __construct($path) {
    if (!is_file($path) || !is_readable($path)) {
      throw new \ErrorException('The path is not readable.');
    }
    $data = file_get_contents($path);
    $image = imagecreatefromstring($data);
    unset($data);
    if (!is_resource($image)) {
      throw new \ErrorException('Invalid image.');
    }
    $small = $this->fit200pix($image);
    $this->fillColors($small);
  }

  public function walkColors() {
    foreach ($this->colorsInt as $int) {
      yield new Color($int);
    }
  }

  protected function fit200pix($image) {
    /**
     * Effective resize image to smallest
     * https://php.ru/forum/threads/kruzhok-ljubopytnyx-izvraschencev.19244/page-7#post-205590
     * 
     * Fit image to 100 pixels by side
     */
    $x = imagesx($image);
    $y = imagesy($image);
    if ($x <= 200 && $y <= 200) {
      return $image;
    }

    if ($x > 400 || $y > 400) {
      $qr = ($x > $y ? $x : $y) / 400;
      $nx = round($x / $qr);
      $ny = round($y / $qr);
      $simage = imagecreatetruecolor($nx, $ny);
      imagecopyresized($simage, $image, 0, 0, 0, 0, $nx, $ny, $x, $y);
      imagedestroy($image);
      $image = $simage;
    }
    $x = imagesx($image);
    $y = imagesy($image);
    $qr = ($x > $y ? $x : $y) / 200;
    $nx = round($x / $qr);
    $ny = round($y / $qr);
    $simage = imagecreatetruecolor($nx, $ny);
    imagecopyresampled($simage, $image, 0, 0, 0, 0, $nx, $ny, $x, $y);
    imagedestroy($image);
    return $simage;
  }

  protected function fillColors($image) {
    $x = imagesx($image);
    $y = imagesy($image);
    for ($iy = 0; $iy < $y; $iy++) {
      for ($ix = 0; $ix < $x; $ix++) {
        $this->colorsInt[] = imagecolorat($image, $ix, $iy);
      }
    }
  }

}
