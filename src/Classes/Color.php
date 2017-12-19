<?php

/*
 * (c)2017
 * www.vasya.pro
 */

namespace Vs\Paletter;

class Color {

  public $int, $r, $g, $b;

  /**
   * 
   * @param int $rgb index was return by imagecolorat()
   */
  public function __construct($rgb = 0) {
    $this->int = (int) $rgb;
    $this->fromInt();
  }

  public function __call($name, $args) {
    if (in_array($name, ['int', 'r', 'g', 'b'])) {
      $this->$name = (int) $args[0];
    }
    switch ($name) {
      case 'int':
        $this->fromInt();
        break;
      default:
        $this->fromRGB();
    }
  }

  /**
   * Fill R, G, B from integer value
   */
  protected function fromInt() {
    $rgb = $this->int;
    $this->r = ($rgb >> 16) & 0xFF;
    $this->g = ($rgb >> 8) & 0xFF;
    $this->b = $rgb & 0xFF;
  }

  /**
   * Calc integer value from R, G, B prop-s.
   */
  protected function fromRGB() {
    $rgb = ($this->r << 16) + ($this->g << 8) + ($this->b);
    $this->int = $rgb;
  }

}
