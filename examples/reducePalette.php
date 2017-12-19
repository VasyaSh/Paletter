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

echo '<pre>';
echo '<img src="flags.jpeg" width="400"><br><br>';

/* Our all */
$paletter = new Vs\Paletter\Paletter();
$paletter->loadImage('flags.jpeg');
$scores = $paletter->getScores();

/* Make the Pseudo Image.
   Painting "image" in colors of default palette,
   in amount as such in the Scores. */

$pseudoImage = $paletter->makePseudoImage();
foreach ($scores as $color => $score) {
  $pseudoImage->addPixels($color, $score);
}

/* Clean the base and use top-10 colors as palette */
$base = $paletter->getBase();
$base->Clean();
$top10 = array_slice($scores, 0, 10, true);
foreach ($top10 as $color => $score) {
  $base->addColor(new Vs\Paletter\Color($color));
}
$paletter->cleanScores();
$scores = $paletter->getScores();

/* Calc percents and show pretty result */
$scores_sum = array_sum($scores);
foreach ($scores as $color => $score) {
  $c = new Vs\Paletter\Color($color);
  $percent = (100 / $scores_sum) * $score;
  echo '<div style="'
  . 'background-color:rgb(' . ($c->r) . ',' . ($c->g) . ',' . ($c->b) . ');'
  . 'width: ' . (round($percent * 16)) . 'px;">' . round($percent, 2) . '%</div>';
}

echo '<style>div {float: left; clear: left; height: 16px; margin: 2px;border: 1px black dotted;min-width:8px!important;}</style>';