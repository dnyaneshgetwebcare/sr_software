<?php

namespace common\components;

use Yii;

/**
 * Builds public URLs for uploaded item images (optionally through the CDN set in
 * params['imageCdnBase']) and generates thumbnails under uploads/thumbs/.
 */
class ImageHelper
{
  const THUMB_DIR = 'thumbs';
  const THUMB_WIDTH = 400;
  const THUMB_QUALITY = 75;
  const NO_IMAGE = 'img/no-image.jpg';

  public static function uploadsPath()
  {
    return dirname(Yii::getAlias('@common')) . DIRECTORY_SEPARATOR . 'uploads';
  }

  /**
   * Base URL that `uploads/` and `img/` live under, without trailing slash.
   * Uses the CDN when configured; otherwise the current app base URL
   * (absolute when $absolute is true).
   */
  public static function baseUrl($absolute = false)
  {
    $cdn = isset(Yii::$app->params['imageCdnBase']) ? trim(Yii::$app->params['imageCdnBase']) : '';
    if ($cdn !== '') {
      return rtrim($cdn, '/');
    }
    $request = Yii::$app->request;
    if (!($request instanceof \yii\web\Request)) {
      return '';
    }
    $base = rtrim($request->getBaseUrl(), '/');
    return $absolute ? rtrim($request->getHostInfo(), '/') . $base : $base;
  }

  public static function url($name, $absolute = false)
  {
    $path = ($name != '') ? 'uploads/' . ltrim($name, '/') : self::NO_IMAGE;
    return self::baseUrl($absolute) . '/' . $path;
  }

  /**
   * Thumbnail URL if the thumbnail exists, otherwise the full image URL.
   */
  public static function thumbUrl($name, $absolute = false)
  {
    if ($name == '') {
      return self::url('', $absolute);
    }
    $thumb = self::thumbName($name);
    if (is_file(self::uploadsPath() . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $thumb))) {
      return self::baseUrl($absolute) . '/uploads/' . $thumb;
    }
    return self::url($name, $absolute);
  }

  /**
   * Relative thumbnail name inside uploads/, e.g. "4/9491.jpeg" -> "thumbs/4/9491.jpg".
   */
  public static function thumbName($name)
  {
    $name = ltrim(str_replace('\\', '/', $name), '/');
    $dot = strrpos($name, '.');
    $base = ($dot === false) ? $name : substr($name, 0, $dot);
    return self::THUMB_DIR . '/' . $base . '.jpg';
  }

  /**
   * Creates (or replaces) the thumbnail for an image stored in uploads/.
   * Returns true on success; failures are logged and never thrown.
   */
  public static function makeThumb($name, $overwrite = true)
  {
    try {
      if ($name == '' || !function_exists('imagecreatetruecolor')) {
        return false;
      }
      $uploads = self::uploadsPath();
      $source = $uploads . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, ltrim($name, '/'));
      $target = $uploads . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, self::thumbName($name));
      if (!is_file($source)) {
        return false;
      }
      if (!$overwrite && is_file($target)) {
        return true;
      }

      $info = @getimagesize($source);
      if ($info === false) {
        return false;
      }
      switch ($info[2]) {
        case IMAGETYPE_JPEG:
          $src = @imagecreatefromjpeg($source);
          break;
        case IMAGETYPE_PNG:
          $src = @imagecreatefrompng($source);
          break;
        case IMAGETYPE_GIF:
          $src = @imagecreatefromgif($source);
          break;
        case IMAGETYPE_WEBP:
          $src = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($source) : false;
          break;
        default:
          $src = false;
      }
      if (!$src) {
        return false;
      }

      if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
        $exif = @exif_read_data($source);
        $orientation = isset($exif['Orientation']) ? (int)$exif['Orientation'] : 1;
        $angle = [3 => 180, 6 => -90, 8 => 90];
        if (isset($angle[$orientation])) {
          $rotated = imagerotate($src, $angle[$orientation], 0);
          if ($rotated) {
            imagedestroy($src);
            $src = $rotated;
          }
        }
      }

      $w = imagesx($src);
      $h = imagesy($src);
      $newW = min(self::THUMB_WIDTH, $w);
      $newH = max(1, (int)round($h * $newW / $w));

      $dst = imagecreatetruecolor($newW, $newH);
      imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255));
      imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $w, $h);

      $dir = dirname($target);
      if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
      }
      imageinterlace($dst, true);
      $ok = imagejpeg($dst, $target, self::THUMB_QUALITY);
      imagedestroy($src);
      imagedestroy($dst);
      return $ok;
    } catch (\Throwable $e) {
      Yii::error('Thumbnail failed for ' . $name . ': ' . $e->getMessage(), __METHOD__);
      return false;
    }
  }

  /**
   * Deletes an uploaded image and its thumbnail.
   */
  public static function delete($name)
  {
    if ($name == '') {
      return;
    }
    $uploads = self::uploadsPath();
    foreach ([ltrim($name, '/'), self::thumbName($name)] as $rel) {
      $file = $uploads . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
      if (is_file($file)) {
        @unlink($file);
      }
    }
  }
}
