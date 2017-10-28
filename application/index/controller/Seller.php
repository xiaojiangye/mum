<?php
namespace app\index\controller;

use think\Controller; 
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\index\model\Seller as SellerModel;
use app\admin\model\Big;

class Seller extends Controller
{
	protected $seller ;
	protected $big;
	

	public function _initialize()
	{
		$this->seller = new SellerModel();
		$this->big = new Big();
	}

	/*添加商家信息  先查出可以注册成哪种商家*/
	public function addSellerInfo()
	{	
		$post = $this->request->post();
		$style = $post['style'];
		$res = $this->big->getByType($style);
		$post['big_id'] = $res[0]['id'];
		$post['name'] = $post['uname'];
		$res = $this->seller->add($post);
		return json_encode($res);
		if($res)
		{
			return 1;
		}else{
			return 0;
		}
	}
	//登录页面
	public function sellogin()
	{
		return $this->fetch();
	}
	
	//验证登录的条件
	 public function dologin()
    {  
      $name = input('post.name');
      $pwd = input('post.pwd');
     // return $pwd;
      $result =  Db::table('mumma_seller')->where('name',"$name")->find();

      if ($result){
        if ($pwd !== $result['pwd']){
          return 0;
        }else{

          $id = $result['id'];
           
          //添加登录的时间
          //$time = time();
          ///$this->selle->
          Session::set('name',"$name");
         
          Session::set('id',"$id");
          Session::set('type',1); //存值判断商家  
          return 1;
        } 
      }else{
          return 2;
      }  
    }

    //退出登录
    public function exit()
    {
    	session(null);
    	$this->fetch('index/index');
    }

	/*渲染商家中心的页面  小店信息*/
	public function selInfo()
	{
		/*这里需要登录之后进行改值*/
		$Info = $this->seller->getByType('id' , 1)[0];

		$Info['big_id'] = $this->big->getByField('id' , $Info['big_id'])[0]['style'];
		
		$this->assign('Info' , $Info);
		return  $this->fetch();
	}

}