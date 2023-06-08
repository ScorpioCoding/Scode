<?php

namespace App\Core;

class Translation
{

  public function __construct($module = '', $lang = '')
  {
    echo ('test within the class not static');
  }

  public static function getTranslation($args = array()): array
  {
    $controller = array();
    $template = array();

    $controller = self::getControllerTranslation($args);
    $template = self::getTemplateTranslation($args);

    $data = array();
    $data = array_merge_recursive($controller, $template);
    //print_r($data);
    return $data;
  }

  protected static function getControllerTranslation($args = array()): array
  {
    $data = array();
    try {
      $transFile = self::getControllerFile($args);

      if ($transFile) {
        $contents = file_get_contents($transFile);
        $data = json_decode($contents, TRUE);
      } else {
        throw new NewException("Translation.php : translate : No translation file found.");
      }
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }

    return $data;
  }

  protected static function getControllerFile($args = array())
  {
    $transFile = PATH_MOD;
    $transFile .= ucfirst($args['module']) . DS . 'Translations' . DS;
    $transFile .= strtolower($args['controller']) . '.';
    $transFile .= strtolower($args['lang']);
    $transFile .= '.json';

    try {
      self::checkFile($transFile);
      return $transFile;
    } catch (NewException $e) {
      echo $e->getErrorMsg();
      return false;
    }
  }

  protected static function getTemplateTranslation($args = array()): array
  {
    $data = array();
    try {
      $transFile = self::getTemplateFile($args);

      if ($transFile) {
        $contents = file_get_contents($transFile);
        $data = json_decode($contents, TRUE);
      } else {
        throw new NewException("Translation.php : translate : No translation file found.");
      }
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }

    return $data;
  }
  protected static function getTemplateFile($args = array())
  {
    $transFile = PATH_APP;
    $transFile .= 'Translations' . DS;
    $transFile .=  strtolower($args['template']) . '.';
    $transFile .= strtolower($args['lang']);
    $transFile .= '.json';

    try {
      self::checkFile($transFile);
      return $transFile;
    } catch (NewException $e) {
      echo $e->getErrorMsg();
      return false;
    }
  }

  /*
    * Path checking at View base level - View.php
    * @params   array   $file
    */
  protected static function checkFile($file)
  {
    if (!is_readable($file)) {
      throw new NewException("Translation.php : checkFile : File doesn't exist. : $file <br>");
      return false;
    } else {
      return true;
    }
  } //END checkFile




  //
  //END CLASS
}
