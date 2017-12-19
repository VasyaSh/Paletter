<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');
set_time_limit(0);
ini_set('memory_limit', '4G');

require '../src/Paletter.php';
require '../src/Abstract/Image.php';
require '../src/Classes/Base.php';
require '../src/Classes/Color.php';
require '../src/Classes/RealImage.php';
require '../src/Classes/PseudoImage.php';

/* Our all */
$paletter = new Vs\Paletter\Paletter();
$paletter->loadImage('flags.jpeg');
$scores = $paletter->getScores();

/* Calc percents and show pretty result */
echo '<pre>';
echo '<img src="flags.jpeg" width="400"><br><br>';
$scores_sum = array_sum($scores);
foreach ($scores as $color => $score) {
  $c = new Vs\Paletter\Color($color);
  $percent = (100 / $scores_sum) * $score;
  echo '<div style="'
  . 'background-color:rgb(' . ($c->r) . ',' . ($c->g) . ',' . ($c->b) . ');'
  . 'width: ' . (round($percent * 16)) . 'px;">' . round($percent, 2) . '%</div>';
}

echo '<style>div {float: left; clear: left; height: 16px; margin: 2px;border: 1px black dotted;min-width:8px!important;}</style>';