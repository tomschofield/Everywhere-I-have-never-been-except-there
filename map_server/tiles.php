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
  $zoom = intval($reverse[2]);
  $xtile = intval($reverse[1]);
  $ytile = intval($reverse[0]);


  for (end($reverse); key($reverse) !== null; prev($reverse)) {


    $xyz .= "/" . current($reverse);
  }
  return $xyz;
}

function getURLX()
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
  $zoom = intval($reverse[2]);
  $xtile = intval($reverse[1]);
  $ytile = intval($reverse[0]);


  return $xtile;
}
function getURLY()
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
  $zoom = intval($reverse[2]);
  $xtile = intval($reverse[1]);
  $ytile = intval($reverse[0]);


  return $ytile;
}

function getZoom()
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
  $zoom = intval($reverse[2]);


  return $zoom;
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
  $zoom = intval($reverse[2]);
  $xtile = intval($reverse[1]);
  $ytile = intval($reverse[0]);
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
  $zoom = intval($reverse[2]);
  $xtile = intval($reverse[1]);
  $ytile = intval($reverse[0]);
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
function getTileWithStreetView()
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
  $zoom = intval($reverse[2]);
  $xtile = intval($reverse[1]);
  $ytile = intval($reverse[0]);
  $n = pow(2, $zoom);
  $lon_deg = $xtile / $n * 360.0 - 180.0;
  $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * $ytile / $n))));


  $xyz = getXYZ();
  // $nearByXYZ = getNearByXYZ(rand(0.0,3,0),rand(0.0,3,0) );

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";
  $street_view_url = "https://maps.googleapis.com/maps/api/streetview?size=256x256&location=" . strval($lat_deg) . "," . strval($lon_deg) . "&fov=80&heading=70&pitch=0&key=AIzaSyC98XAZXf0h3wwZOtw-8Fmm4KICrGVczwk";
  file_put_contents("url.txt", $street_view_url);

  $src1 = new \Imagick($file . $xyz);
  $src2 = new \Imagick($street_view_url);


  // $src1->compositeImage($src2, Imagick::COMPOSITE_DISPLACE, 0, 0);


  return $src2->getImageBlob();
}
function getRandomOrangeOrPinkTile()
{
  $xyz = getXYZ();
  $oppositeXYZ = getOppositeXYZ();

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile" . $xyz;

  $im = imagecreatefromstring(file_get_contents($file));
  // $im = readfile("$file");
  if ($im == false || $im == null) return;

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
function tile2lon($x, $z)
{
  return ($x / pow(2, $z) * 360 - 180);
}

// function tile2lat($y, $z) {
//    $n = pi() - 2 * pi() * y /pow(2, $z);
//   return (180 / pi() * atan(0.5 * (exp($n) - exp(-$n))));
// }
function tile2lat($y, $z)
{
  $n = pi() - 2 * pi() * $y / pow(2, $z);
  return (180 / pi() * atan(0.5 * (exp($n) - exp(-$n))));
}
function lonTotile($lon, $zoom1)
{
  $tt = floatval($lon);
  return (floor(($tt + 180) / 360 * pow(2, $zoom1)));
}

function latTotile($lat, $zoom)
{
  return (floor((1 - log(tan($lat * pi() / 180) + 1 / cos($lat * pi() / 180)) / pi()) / 2 * pow(2, $zoom)));
}
function circle_distance($lat1, $lon1, $lat2, $lon2)
{
  $rad = M_PI / 180;
  return acos(sin($lat2 * $rad) * sin($lat1 * $rad) + cos($lat2 * $rad) * cos($lat1 * $rad) * cos($lon2 * $rad - $lon1 * $rad)) * 6371; // Kilometers
}
function inBoundingBox($tlfx, $tlfy, $brx, $bry, $px, $py)
{
  if ($tlfx <= $px && $px <= $brx && $tlfy <= $py && $py <= $bry) {
    return true;
  } else return false;
}
function getSingleTileWithMatches()
{
  $xyz = getXYZ();
  $nearByXYZ = getNearByXYZ(rand(0.0, 3, 0), rand(0.0, 3, 0));

  $lat = tile2lat(floatval(getURLX()), floatval(getZoom()));
  $lon = tile2lon(floatval(getURLY()), floatval(getZoom()));

  $bottomLat = tile2lat(floatval(getURLX()) + 1, floatval(getZoom()));
  $bottomLon = tile2lon(floatval(getURLY()) + 1, floatval(getZoom()));

  // echo getURLY().", ".getURLX().", ".getZoom()."<br>";

  //echo $lat.", ".$lon."<br>";
  // ///check if this tile contains a network
  $json = json_decode(file_get_contents("/Users/ntws2/Desktop/probe_requests/python/data.json"), true); //['locations'];
  $locations = $json['locations'];

  $matches = array();
  foreach ($locations as $key => $valuea) {
    $value = json_decode($valuea);
    //$dist = circle_distance($lat, $lon, floatval($value->lat), floatval($value->lon));
    $in_box = false;
    //echo $dist."<br>";
    $zoom = floatval(getZoom());
    if (latTotile(floatval($value->lat), $zoom) == getURLX() && lonTotile(floatval($value->lon), $zoom) == getURLY()) $in_box = true;

    // $in_box = inBoundingBox(floatval($lat),floatval($lon), floatval($bottomLat), floatval($bottomLon), floatval($value->lat), floatval($value->lon));
    // echo $in_box.", ".  $bottomLat .", ". $bottomLon  .", ". $lat.", ".$lon.", ". $value->lat.", ". $value->lon.", ".getZoom()."<br>";
    //  echo getURLX().", ". getURLY() .", ".latTotile(floatval($value->lat),$zoom ).", ". lonTotile(floatval($value->lon),$zoom )."<br>";

    if ($in_box == true) {

      array_push($matches, [$value->lat, $value->lon]);
      //
      //return getCompositeTileFromOtherSite($value->lat,$value->lon,$zoom);
    }
  }
  //get all network tiles up to some max with this 

  if (sizeof($matches) > 0) {
    $index = rand(0, sizeof($matches) - 1);
    return getCompositeTileFromOtherSite($matches[$index][0], $matches[$index][1], $zoom);
  }
  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";
  $src1 = new \Imagick($file . $xyz);

  return $src1->getImageBlob();
}
function getSingleTileWithLayeredMatches()
{
  $xyz = getXYZ();
  $nearByXYZ = getNearByXYZ(rand(0.0, 3, 0), rand(0.0, 3, 0));

  $lat = tile2lat(floatval(getURLX()), floatval(getZoom()));
  $lon = tile2lon(floatval(getURLY()), floatval(getZoom()));

  $bottomLat = tile2lat(floatval(getURLX()) + 1, floatval(getZoom()));
  $bottomLon = tile2lon(floatval(getURLY()) + 1, floatval(getZoom()));

  // echo getURLY().", ".getURLX().", ".getZoom()."<br>";

  //echo $lat.", ".$lon."<br>";
  // ///check if this tile contains a network
  $json = json_decode(file_get_contents("/Users/ntws2/Desktop/probe_requests/python/data.json"), true); //['locations'];
  $locations = $json['locations'];

  $matches = array();
  foreach ($locations as $key => $valuea) {
    $value = json_decode($valuea);
    //$dist = circle_distance($lat, $lon, floatval($value->lat), floatval($value->lon));
    $in_box = false;
    //echo $dist."<br>";
    $zoom = floatval(getZoom());
    if (latTotile(floatval($value->lat), $zoom) == getURLX() && lonTotile(floatval($value->lon), $zoom) == getURLY()) $in_box = true;

    // $in_box = inBoundingBox(floatval($lat),floatval($lon), floatval($bottomLat), floatval($bottomLon), floatval($value->lat), floatval($value->lon));
    // echo $in_box.", ".  $bottomLat .", ". $bottomLon  .", ". $lat.", ".$lon.", ". $value->lat.", ". $value->lon.", ".getZoom()."<br>";
    //  echo getURLX().", ". getURLY() .", ".latTotile(floatval($value->lat),$zoom ).", ". lonTotile(floatval($value->lon),$zoom )."<br>";

    if ($in_box == true) {

      array_push($matches, [$value->lat, $value->lon]);
      //
      //return getCompositeTileFromOtherSite($value->lat,$value->lon,$zoom);
    }
  }
  //get all network tiles up to some max with this 

  if (sizeof($matches) > 0) {

    return getCompositeTileFromOtherSites($matches, $zoom);
  }
  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";
  $src1 = new \Imagick($file . $xyz);

  return $src1->getImageBlob();
}
function getMatchesForThisTile(){
  $json = json_decode(file_get_contents("/Users/ntws2/Desktop/probe_requests/python/data.json"), true); //['locations'];
  $locations = $json['locations'];

  $matches = array();
  $first_ssid ="empty";
  foreach ($locations as $key => $valuea) {
    $value = json_decode($valuea);
    //get the first ssid with a lat lon inside this square.
    $zoom = floatval(getZoom());
    if (latTotile(floatval($value->lat), $zoom) == getURLX() && lonTotile(floatval($value->lon), $zoom) == getURLY()) $in_box = true;
    if( $in_box ){
    if($first_ssid =="empty") {
      $first_ssid = $value->ssid;
    }else{
      if($first_ssid==$value->ssid){
        array_push($matches, [$value->lat, $value->lon]);
      }
    }
  }
  }
  return $matches;
}
function getSingleTileWithThresholdedMatches()
{
  $xyz = getXYZ();
  $nearByXYZ = getNearByXYZ(rand(0.0, 3, 0), rand(0.0, 3, 0));

  $lat = tile2lat(floatval(getURLX()), floatval(getZoom()));
  $lon = tile2lon(floatval(getURLY()), floatval(getZoom()));

  $bottomLat = tile2lat(floatval(getURLX()) + 1, floatval(getZoom()));
  $bottomLon = tile2lon(floatval(getURLY()) + 1, floatval(getZoom()));

  // echo getURLY().", ".getURLX().", ".getZoom()."<br>";

  //echo $lat.", ".$lon."<br>";
  // ///check if this tile contains a network
  $json = json_decode(file_get_contents("/Users/ntws2/Desktop/probe_requests/python/data.json"), true); //['locations'];
  $locations = $json['locations'];
  $zoom = floatval(getZoom());
  $matches = getMatchesForThisTile();
  //get all network tiles up to some max with this 

  if (sizeof($matches) > 0) {

    return getThresholdTileFromOtherSites($matches, $zoom);
  }
  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";
  $src1 = new \Imagick($file . $xyz);

  return $src1->getImageBlob();
}
function distance($lat1, $lon1, $lat2, $lon2, $unit)
{

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
    return ($miles * 0.8684);
  } else {
    return $miles;
  }
}
function getSingleTile()
{
  $xyz = getXYZ();


  //get all network tiles up to some max with this 

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";
  $src1 = new \Imagick($file . $xyz);

  return $src1->getImageBlob();
}

function getCompositeTileFromNearby()
{
  $xyz = getXYZ();
  $nearByXYZ = getNearByXYZ(rand(0.0, 3, 0), rand(0.0, 3, 0));

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";
  $src1 = new \Imagick($file . $xyz);
  $src2 = new \Imagick($file . $nearByXYZ);

  //  $src1->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
  //  $src1->setImageArtifact('compose:args', "1,0,-0.5,0.5");
  // $src1->compositeImage($src2, Imagick::COMPOSITE_COLORDODGE, 0, 0);
  $src1->compositeImage($src2, Imagick::COMPOSITE_DISPLACE, 0, 0);

  // $src1->writeImage("./output.png");
  // $src1->setImageFormat("png");
  return $src1->getImageBlob();
}
function getCompositeTileFromOtherSite($lat, $lon, $zoom)
{
  $xyz = getXYZ();
  $nearByXYZ = "/" . strval($zoom) . "/" . strval(latTotile($lat, $zoom)) . "/" . strval(lonTotile($lon, $zoom));

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";
  $src1 = new \Imagick($file . $xyz);
  $src2 = new \Imagick($file . $nearByXYZ);
  //echo $file.$nearByXYZ."<br>";
  //  $src1->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
  //  $src1->setImageArtifact('compose:args', "1,0,-0.5,0.5");
  // $src1->compositeImage($src2, Imagick::COMPOSITE_COLORDODGE, 0, 0);
  $src1->compositeImage($src2, Imagick::COMPOSITE_DISPLACE, 0, 0);

  // $src1->writeImage("./output.png");
  // $src1->setImageFormat("png");
  return $src1->getImageBlob();
}
function getCompositeTileFromOtherSites($matches, $zoom)
{
  $xyz = getXYZ();
  $num_tiles = intval(rand(1, 10));

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";
  $src1 = new \Imagick($file . $xyz);

  for ($i = 0; $i < $num_tiles; $i++) {
    # code...
    $index = rand(0, sizeof($matches) - 1);


    $nearByXYZ = "/" . strval($zoom) . "/" . strval(latTotile($matches[$index][0], $zoom)) . "/" . strval(lonTotile($matches[$index][1], $zoom));


    $src2 = new \Imagick($file . $nearByXYZ);
    //echo $file.$nearByXYZ."<br>";
    //  $src1->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
    //  $src1->setImageArtifact('compose:args', "1,0,-0.5,0.5");
    // $src1->compositeImage($src2, Imagick::COMPOSITE_COLORDODGE, 0, 0);
    $src1->compositeImage($src2, Imagick::COMPOSITE_DISPLACE, 0, 0);
  }


  // $src1->writeImage("./output.png");
  // $src1->setImageFormat("png");
  return $src1->getImageBlob();
}
function getThresholdTileFromOtherSites($matches, $zoom)
{
  $xyz = getXYZ();
  $num_tiles = intval(rand(1, 10));

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";


  $index = rand(0, sizeof($matches) - 1);
  $nearByXYZ = "/" . strval($zoom) . "/" . strval(latTotile($matches[$index][0], $zoom)) . "/" . strval(lonTotile($matches[$index][1], $zoom));

  $index1 = rand(0, sizeof($matches) - 1);
  $nearByXYZ2 = "/" . strval($zoom) . "/" . strval(latTotile($matches[$index1][0], $zoom)) . "/" . strval(lonTotile($matches[$index1][1], $zoom));

  $src1 = $file . $xyz;
  $src2 = $file . $nearByXYZ;
  $src3 = $file . $nearByXYZ2;
  file_put_contents('url_log.txt', sizeof($matches) . " " .$index." ".$index1." ". $matches[$index][0]." " . $matches[$index][1] . " " . $matches[$index1][0] . " " . $matches[$index1][1] . " " .        $src1 . " " . $src2 . " " . $src3 . "\n ", FILE_APPEND);
  return getThresholdedComposite($src1, $src2, $src3);
}
function getThresholdedComposite($src1, $src2, $src3)
{
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
function getCompositeTileFromOtherSideOfTheWorld()
{
  $xyz = getXYZ();
  $oppositeXYZ = getOppositeXYZ();

  $file = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile";
  $src1 = new \Imagick($file . $xyz);
  $src2 = new \Imagick("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/13/2724/4091"); //$file.$oppositeXYZ);

  //  $src1->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
  //  $src1->setImageArtifact('compose:args', "1,0,-0.5,0.5");
  $src1->compositeImage($src2, Imagick::COMPOSITE_COLORDODGE, 0, 0);
  // $src1->writeImage("./output.png");
  // $src1->setImageFormat("png");
  return $src1->getImageBlob();
}
$im =  getSingleTileWithThresholdedMatches();
echo $im;

exit;
