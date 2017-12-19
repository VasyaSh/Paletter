<?php

/*
 * (c)2017
 * www.vasya.pro
 */

namespace Vs\Paletter;

class Paletter {

  protected $image, $base, $scores = [];

  public function loadImage($path) {
    $this->cleanScores();
    $this->image = new RealImage($path);
  }
  
  /**
   * 
   * @return \Vs\Paletter\PseudoImage
   */
  public function makePseudoImage() {
    $this->cleanScores();
    $this->image = new PseudoImage();
    return $this->image;
  }

  public function getScores() {
    if (empty($this->scores)) {
      if ($this->image instanceof Image) {
        $this->calcScores();
      }
    }
    return $this->scores;
  }

  public function setBase(Base $base) {
    return $this->base = $base;
  }
  
  /**
   * 
   * @return \Vs\Paletter\Base
   */
  public function getBase() {
    $this->initBase();
    return $this->base;
  }

  public function cleanScores() {
    $this->scores = [];
  }

  protected function initBase() {
    $base = $this->base;
    if (!($base instanceof Base)) {
      $base = new Base;
      $base->build();
      $this->setBase($base);
    }
    return true;
  }

  protected function calcScores() {
    $this->cleanScores();
    $this->initBase();
    $base = $this->base;
    $image = $this->image;
    foreach ($image->walkColors() as $ic) {
      $distance = PHP_INT_MAX;
      foreach ($base->walk() as $bc) {
        $dist = sqrt(pow($ic->r - $bc->r, 2) + pow($ic->g - $bc->g, 2) + pow($ic->b - $bc->b, 2));
        if ($dist < $distance) {
          $distance = $dist;
          $color = $bc;
        }
      }
      if (!isset($this->scores[$color->int])) {
        $this->scores[$color->int] = 0;
      }
      $this->scores[$color->int]++;
    }
    arsort($this->scores);
  }

}
