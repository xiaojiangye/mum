<?php
namespace app\index\controller;

use think\Controller; 
use think\View;

class Index  extends Controller
{

  
    public function index()
    {
        return $this->fetch();
    }

}
