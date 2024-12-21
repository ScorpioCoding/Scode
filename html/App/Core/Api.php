<?php

namespace App\Core;


/** THE API RENDERING
 * 
 */
class Api
{
  public function __construct()
  {
    echo ('test within the class not static');
  }

  public static function setPage($args = array())
  {
    $page = PATH_MOD;
    $page .= ucfirst($args['module']) . DS . 'Apis' . DS;
    $page .= ucfirst($args['api']);
    $page .= '.php';

    try {
      self::checkFile($page);
      return $page;
    } catch (NewException $e) {
      echo $e->getErrorMsg();
      return false;
    }
  }

  public static function setTemplate($args = array())
  {
    $template = PATH_APP;
    $template .= 'Templates' . DS;
    $template .= ucfirst($args['template']);
    $template .= '.php';

    try {
      self::checkFile($template);
      return $template;
    } catch (NewException $e) {
      echo $e->getErrorMsg();
      return false;
    }
  }


  /*
   * rendering the page - Api.php
   * @params   array   $args
   * @params   array   $meta
   */
  public static function render($args = array(), $data = array())
  {
    try {
      $page = self::setPage($args);

      //$template = self::setTemplate($args);

      if ($page) {
        extract($data);
        //require $template;
        require $page;
      } else {
        throw new NewException("Api.php : render : Rendering FAILED");
      }
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }
  } //END render


  /*
   * Path checking at View base level - View.php
   * @params   array   $file
   */
  public static function checkFile($file)
  {
    if (!is_readable($file)) {
      throw new NewException("Api.php : checkFile : File doesn't exist in Apis : $file ");
      return false;
    } else {
      return true;
    }
  } //END checkFile








  //END-Class
}