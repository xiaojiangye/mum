<?php
namespace app\index\controller;

use think\Controller; 
use think\View;

class Index  extends Controller
{

    public function regist()
    {
    	dump($this->request());
       //return $this->fetch('/public/regist');
    }

    public function index()
    {
        //return $this->regist();
    }

}
