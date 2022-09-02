<?php

header("Content-type: image/png");

function getOrangeTile($im)
{
  imagefilter($im, IMG_FILTER_GRAYSCALE);
  imagefilter($im, IMG_FILTER_CONTRAST, 255);
  imagefilter($im, IMG_FILTER_NEGATE);
  imagefilter($im, IMG_FILTER_COLORIZE, 2, 118, 219);
  imagefilter($im, IMG_FILTER_NEGATE);
}
function getPinkTile($im)
{
  imagefilter($im, IMG_FILTER_GRAYSCALE);
  imagefilter($im, IMG_FILTER_CONTRAST, 255);
  imagefilter($im, IMG_FILTER_NEGATE);
  imagefilter($im, IMG_FILTER_COLORIZE, 2, 218, 119);
  imagefilter($im, IMG_FILTER_NEGATE);
}

function getXYZ()
{
  $actual_link =  "://$_SERVER[REQUEST_URI]";
  $array = explode("/", $actual_link);
  $xyz = "";
  $count = 0;
  $reverse = array();
  for (end($array); key($array) !== null; prev($array)) {
    if ($count < 3) array_push($reverse, current($array));


    // ...
    $count++;
  }

  //get the latitude and longitutde from the tile number
  $zoom = floatval($reverse[2]);
  $xtile = floatval($reverse[1]);
  $ytile = floatval($reverse[0]);
  $n = pow(2, $zoom);
  $lon_deg = $xtile / $n * 360.0 - 180.0;
  $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * $ytile / $n))));


  //flip them to the other side of the world
  if (rand(0, 10) >= 5) $lon_deg *= -1;
  if (rand(0, 10) >= 5) $lat_deg *= -1;

  $xtile = floor((($lon_deg + 180) / 360) * pow(2, $zoom));
  $ytile = floor((1 - log(tan(deg2rad($lat_deg)) + 1 / cos(deg2rad($lat_deg))) / pi()) / 2 * pow(2, $zoom));

  // $reverse[1]= $xtile ;
  // $reverse[0] = $ytile;

  for (end($reverse); key($reverse) !== null; prev($reverse)) {


    $xyz .= "/" . current($reverse);
  }
  return $xyz;
}
function getOppositeXYZ()
{
  $actual_link =  "://$_SERVER[REQUEST_URI]";
  $array = explode("/", $actual_link);
  $xyz = "";
  $count = 0;
  $reverse = array();
  for (end($array); key($array) !== null; prev($array)) {
    if ($count < 3) array_push($reverse, current($array));


    // ...
    $count++;
  }

  //get the latitude and longitutde from the tile number
  $zoom = floatval($reverse[2]);
  $xtile = floatval($reverse[1]);
  $ytile = floatval($reverse[0]);
  $n = pow(2, $zoom);
  $lon_deg = $xtile / $n * 360.0 - 180.0;
  $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * $ytile / $n))));


  //flip them to the other side of the world
  $lon_deg *= -1;
 $lat_deg *= -1;

  $xtile = floor((($lon_deg + 180) / 360) * pow(2, $zoom));
  $ytile = floor((1 - log(tan(deg2rad($lat_deg)) + 1 / cos(deg2rad($lat_deg))) / pi()) / 2 * pow(2, $zoom));

  $reverse[1] = $xtile;
  $reverse[0] = $ytile;

  for (end($reverse); key($reverse) !== null; prev($reverse)) {


    $xyz .= "/" . current($reverse);
  }
  return $xyz;
}
function getNearByXYZ($lat_shift, $lng_shift)
{
  $actual_link =  "://$_SERVER[REQUEST_URI]";
  $array = explode("/", $actual_link);
  $xyz = "";
  $count = 0;
  $reverse = array();
  for (end($array); key($array) !== null; prev($array)) {
    if ($count < 3) array_push($reverse, current($array));


    // ...
    $count++;
  }

  //get the latitude and longitutde from the tile number
  $zoom = floatval($reverse[2]);
  $xtile = floatval($reverse[1]);
  $ytile = floatval($reverse[0]);
  $n = pow(2, $zoom);
  $lon_deg = $xtile / $n * 360.0 - 180.0;
  $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * $ytile / $n))));


  //flip them to the other side of the world
 $lon_deg += $lng_shift;
 $lat_deg += $lat_shift;

  $xtile = floor((($lon_deg + 180) / 360) * pow(2, $zoom));
  $ytile = floor((1 - log(tan(deg2rad($lat_deg)) + 1 / cos(deg2rad($lat_deg))) / pi()) / 2 * pow(2, $zoom));

  $reverse[1] = $xtile;
  $reverse[0] = $ytile;

  for (end($reverse); key($reverse) !== null; prev($reverse)) {


    $xyz .= "/" . current($reverse);
  }
  return $xyz;
}
function getXYZFromLatLongURL(){
  $actual_link =  "://$_SERVER[REQUEST_URI]";
  $array = explode("/", $actual_link);
  $xyz = "";
  $count = 0;
  $reverse = array();
  for (end($array); key($array) !== null; prev($array)) {
    if ($count < 3) array_push($reverse, current($array));


    // ...
    $count++;
  }

  //get the latitude and longitutde from the tile number
  $zoom = floatval($reverse[2]);
  $lat_deg = floatval($reverse[1]);
  $lon_deg = floatval($reverse[0]);


  $xtile = floor((($lon_deg + 180.0) / 360.0) * pow(2.0, $zoom));
  $ytile = floor((1.0 - log(tan(deg2rad($lat_deg)) + 1.0 / cos(deg2rad($lat_deg))) / pi()) / 2.0 * pow(2.0, $zoom));


 
  $file = 'coords.txt';
$data = $zoom.";".$lat_deg.";".$lon_deg.";".$xtile.";".$ytile."\n";


file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

  return "/". strval($zoom)."/".strval($xtile)."/".strval($ytile);

}
function getTileWithStreetView(){
  $actual_link =  "://$_SERVER[REQUEST_URI]";
  $array = explode("/", $actual_link);
  $xyz = "";
  $count = 0;
  $reverse = array();
  for (end($array); key($array) !== null; prev($array)) {
    if ($count < 3) array_push($reverse, current($array));


    // ...
    $count++;
  }

  //get the latitude and longitutde from the tile number
  $zoom = floatval($reverse[2]);
  $xtile = floatval($reverse[1]);
  $ytile = floatval($reverse[0]);
  $n = pow(2, $zoom);
  $lon_deg = $xtile / $n * 360.0 - 180.0;
  $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * $ytile / $n))));


  $xyz = getXYZ();

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile" ;
  $street_view_url = "https://maps.googleapis.com/maps/api/streetview?size=256x256&location=".strval($lat_deg).",".strval($lon_deg)."&fov=80&heading=70&pitch=0&key=AIzaSyC98XAZXf0h3wwZOtw-8Fmm4KICrGVczwk";
  file_put_contents("url.txt",$street_view_url);
  
  $src1 = new \Imagick(  $file.$xyz);
  $src2 = new \Imagick(  $street_view_url);




  return $src2->getImageBlob();
}
function getRandomOrangeOrPinkTile()
{
  $xyz = getXYZ();
  $oppositeXYZ = getOppositeXYZ();

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile" . $xyz;

  $im = imagecreatefromstring(file_get_contents($file));
  // $im = readfile("$file");
  if($im==false || $im==null) return;

  $text_color = imagecolorallocate($im, 233, 14, 91);

  imagestring($im, 1, 5, 5, $lon_deg . "," . $lat_deg, $text_color);
  if (rand(0, 10) >= 5) {
    if (rand(0, 10) >= 5) {
      getOrangeTile($im);
    } else {
      getPinkTile($im);
    }
  }
  return $im;
}



function getSingleTileFromZoomLatLong()
{
  $xyz = getXYZFromLatLongURL();


  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile" ;
 $src1 = new \Imagick(  $file.$xyz);

  return $src1->getImageBlob();
}

function getSingleTile()
{
  $xyz = getXYZ();
  $nearByXYZ = getNearByXYZ(rand(0.0,3,0),rand(0.0,3,0) );

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile" ;
  $src1 = new \Imagick(  $file.$xyz);
  
  return $src1->getImageBlob();
}

function getCompositeTileFromNearby()
{
  $xyz = getXYZ();
  $nearByXYZ = getNearByXYZ(rand(0.0,3,0),rand(0.0,3,0) );

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile" ;
  $src1 = new \Imagick(  $file.$xyz);
  $src2 = new \Imagick(  $file.$nearByXYZ);

  //  $src1->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
  //  $src1->setImageArtifact('compose:args', "1,0,-0.5,0.5");
  // $src1->compositeImage($src2, Imagick::COMPOSITE_COLORDODGE, 0, 0);
  $src1->compositeImage($src2, Imagick::COMPOSITE_DISPLACE, 0, 0);

  // $src1->writeImage("./output.png");
  // $src1->setImageFormat("png");
  return $src1->getImageBlob();
}

function getCompositeTileFromOtherSideOfTheWorld()
{
  $xyz = getXYZ();
  $oppositeXYZ = getOppositeXYZ();

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile" ;
  $src1 = new \Imagick(  $file.$xyz);
  $src2 = new \Imagick(  "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/13/2724/4091" );//$file.$oppositeXYZ);

  //  $src1->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
  //  $src1->setImageArtifact('compose:args', "1,0,-0.5,0.5");
  $src1->compositeImage($src2, Imagick::COMPOSITE_COLORDODGE, 0, 0);
  // $src1->writeImage("./output.png");
  // $src1->setImageFormat("png");
  return $src1->getImageBlob();
}
  $im =  getSingleTileFromZoomLatLong();
 echo $im;

exit;
