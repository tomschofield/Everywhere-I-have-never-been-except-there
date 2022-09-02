<?php

header("Content-type: image/png");

function getThresholdedComposite($src1, $src2, $src3){
  $base = new Imagick($src1);
$mask = new Imagick($src2);
$threshold  = 0.5;
$mask->thresholdimage($threshold * \Imagick::getQuantum(), 3);
$mask->setImageType(Imagick::IMGTYPE_GRAYSCALEMATTE);
$mask->setImageMatte(false);
$mask1 = new Imagick($src3);
$base->compositeImage($mask, Imagick::COMPOSITE_COPYOPACITY, 0, 0);
$mask1->compositeImage($base, Imagick::COMPOSITE_OVER, 0, 0);
// Display the output image
return $mask1->getImageBlob();

}


exit;
