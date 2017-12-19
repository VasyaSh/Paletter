<?php

require '../src/Classes/Base.php';
require '../src/Classes/Color.php';

$base = new Vs\Paletter\Base();
$base->build();
$n = 0;
echo '<table cellspacing="0" cellpadding="0"><tr>';
foreach ($base->walk() as $bc) {
  $n++;
  echo '<td style="background-color:rgb(' . ($bc->r) . ',' . ($bc->g) . ',' . ($bc->b) . ');'
      . 'width: 16px; height: 16px;"></td>';
  if ($n == 16) {
    echo '</tr><tr>';
    $n = 0;
  }
}
echo '</table>';