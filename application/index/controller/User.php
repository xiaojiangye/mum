<?php
namespace app\index\controller;
use think\Controller; 
use think\index\View;
use think\Db;

class User  extends Controller
{
    public function regist()
    {
        return $this->fetch();
    }
    public function login()
    {    
        //$this->assign('data', $data);
        return $this->fetch();
    }
    public function dologin()
    { 
        $name = input('post.name');
        $pwd = input('post.pwd');
       $result = Db::query('select * from mumma_user where name="$name"');
        if ($result) {
            if ($pwd !== $result['pwd']) {
            return json_encode(['status'=>0,'msg'=>'密码错误']);
            }else {
                return json_encode(['status'=>1,'msg'=>'恭喜你登录成功！']);
            }
           
        }else {
            return json_encode(['status'=>2,'msg'=>'用户名错误']);
        }
       
    }


   
}