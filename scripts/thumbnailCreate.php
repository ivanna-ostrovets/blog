<?php
function thumbnailCreate($url) {
  $image = imagecreatefromstring(file_get_contents($url));

  $thumb_width = 140;
  $thumb_height = 140;

  $width = imagesx($image);
  $height = imagesy($image);

  $original_aspect = $width / $height;
  $thumb_aspect = $thumb_width / $thumb_height;

  if ($original_aspect >= $thumb_aspect) {
    $new_height = $thumb_height;
    $new_width = $width / ($height / $thumb_height);
  }
  else {
    $new_width = $thumb_width;
    $new_height = $height / ($width / $thumb_width);
  }

  $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

  imagecopyresampled(
    $thumb,
    $image,
    0 - ($new_width - $thumb_width) / 2,
    0 - ($new_height - $thumb_height) / 2,
    0, 0,
    $new_width, $new_height,
    $width, $height);
  imagejpeg($thumb, $url, 80);
}