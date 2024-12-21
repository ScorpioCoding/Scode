<?php

namespace App\Core;

class DataJson
{

  protected string $module = "";
  protected string $file = "";

  public function __construct($module, $file)
  {
    $this->module = $module;
    $this->file = $file;
    $this->setFile();
  }

  public function getData()
  {
    $data = array();
    try {
      $transFile = $this->setFile();

      if ($transFile) {
        $contents = file_get_contents($transFile);
        $data = json_decode($contents, TRUE);
      } else {
        throw new NewException("DataJson.php : translate : No translation file found.");
      }
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }

    return $data;
  }

  protected function setFile()
  {
    try {
      $transFile = PATH_MOD;
      $transFile .= ucfirst($this->module) . DS . "Data" . DS;
      $transFile .= $this->file;
      $transFile .= '.json';

      $this->checkFile($transFile);
      return $transFile;
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }
  }

  /*
   * Path checking at View base level - View.php
   * @params   array   $file
   */
  protected function checkFile($file)
  {
    if (!is_readable($file)) {
      throw new NewException("DataJson.php : checkFile : File doesn't exist in Views : $file ");
    } else {
      return true;
    }
  } //END checkFile

  //END CLASS
}