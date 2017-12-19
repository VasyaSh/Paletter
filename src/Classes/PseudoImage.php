<?php

/*
 * (c)2017
 * www.vasya.pro
 */

namespace Vs\Paletter;

class PseudoImage extends Image {

  private $color2counts = [];
  
  /**
   * 
   * @param int $intColor
   * @param int $count
   */
  public function addPixels($intColor, $count) {
    if (!isset($this->color2counts[$intColor])) {
      $this->color2counts[$intColor] = 0;
    }
    $this->color2counts[$intColor] += $count;
  }
  
  public function walkColors() {
    foreach ($this->color2counts as $color => $count) {
      for ($i = 0; $i < $count; $i++) {
        yield new Color($color);
      }
    }
  }

}
