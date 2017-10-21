<?php
namespace app\index\controller;

use think\Controller; 
use think\View;

class Index  extends Controller
{

    public function regist()
    {
    	
    	echo 11;
       return $this->fetch('/public/regist');
    }

    public function index()
    {
        return $this->regist();
    }

}
