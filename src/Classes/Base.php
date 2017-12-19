<?php

/*
 * (c)2017
 * www.vasya.pro
 */

namespace Vs\Paletter;

class Base {

  protected $colors = [];

  /**
   * 
   * @param \Vs\Paletter\Color $c
   */
  public function addColor(Color $c) {
    $this->colors[] = $c;
  }

  /**
   * Clean the colors array
   * 
   * @return boolean
   */
  public function Clean() {
    $this->colors = [];
    return true;
  }

  /**
   * Build a default 256 colors palette
   */
  public function build() {
    $this->colors = [];
    // The magic number 6.349604207872798
    for ($ir = 255; $ir >= 0; $ir -= 51) {
      for ($ig = 255; $ig >= 0; $ig -= 51) {
        for ($ib = 255; $ib >= 0; $ib -= 51) {
          if ($ir === $ig && $ig === $ib) {
            continue;
          }
          $c = new Color();
          $c->r($ir);
          $c->g($ig);
          $c->b($ib);
          $this->colors[] = $c;
        }
      }
    }
    for ($i = 0; $i <= 46; $i++) {
      $index = $i * 5.666666666666667;
      $c = new Color();
      $c->r($index);
      $c->g($index);
      $c->b($index);
      $this->colors[] = $c;
    }
  }

  /**
   * Yields all colors of Base
   * 
   * @return \Vs\Paletter\Color
   */
  public function walk() {
    if (empty($this->colors)) {
      return;
    }
    foreach ($this->colors as $c) {
      yield $c;
    }
  }

}
