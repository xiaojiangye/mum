<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User;
use app\admin\model\Administor as AdministorModel;

class Administor  extends Controller
{
	protected $admin;
	//自动触发的初始化函数
	public function _initialize()
	{				
		//$this->request = Request::instance();
		$this->admin = new AdministorModel();
		
	}
	public function login()
	{
		return $this->fetch('');
	}
	//登录的判断条件 管理员
	 public function dologin()
    {   
      $uname = input('post.uname');
      //dump($uname);die;
      $pwd = input('post.pwd');
      $result =  Db::table('mumma_user')->where('uname',"$uname")->find();
       //查询结果
    // dump($result);die;
      if ($result) {
        if ($pwd !== $result['pwd']) 
        {
          return 0;
        } else {

          $id = $result['id'];
          //echo "$id";
         // dump($id);die;
          //添加登录的时间
          Session::set('uname',"$uname");
         // dump($id);die;
          Session::set('id',"$id");
          return 1;
        } 
      }
      else 
      {
          return 2;
      }  
    }
	

	public function administor()
	{	//所有的管理员
		$res = $this->admin->adminAll();
		//所有的管理员的信息
		$this->assign('res',$res);
		return $this->fetch();
	}
	//管理员个人信息
	public function selfInfo()
	{	
		$res = $this->admin->selectAdmin()[0];
		//dump($res);die;
		$this->assign('res',$res);
		return $this->fetch();
	}
}















