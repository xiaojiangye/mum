<?php
namespace app\index\controller;
use think\Controller; 
use think\index\View;

class User  extends Controller
{
    public function regist()
    {
        return $this->fetch();
    }
    public function login()
    {    $data = input('post.name');
         $this->assign('data', $data);
        return $this->fetch();
    }
    public function dologin()
    {
        
       
    }


   
}