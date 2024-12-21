<?php

namespace Modules\Site\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;
use App\Core\Meta;


/**
 *  Home Controller
 */
class Home extends Controller
{
  protected function before()
  {
  }

  public function indexAction($args = array())
  {
    //Template for rendering
    $args['template'] = 'Frontend';
    //MetaData
    $meta = array();
    $meta = (new Meta($args))->getMeta();
    // Translation
    $trans = array();
    $trans = Translation::translate($args);
    // Extra data
    $data = array();




    //page for rendering default = controller
    //$args['page'] = 'Home';
    View::render($args, $meta, $trans, [
      'data' => $data
    ]);
  }

  protected function after()
  {
  }

  //END-Class
}