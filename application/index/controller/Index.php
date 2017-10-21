<?php
namespace app\index\controller;
use think\Controller; 
use think\index\View;

class Index  extends Controller
{
    public function index()
    {       
        return $this->fetch();
         
    }
    public function regist()
    {
        return $this->fetch();
    }
    public function login()
    {
        return $this->fetch();
    }


   
}
