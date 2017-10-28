<?php
namespace app\index\controller;

use think\Controller; 
use think\View;
use app\admin\model\Big;
use app\index\model\Goods;
use app\index\controller\SendEmail;

class Index  extends Controller
{   

    protected $goods;
    protected $big;
    public function _initialize()
    {
      $this->goods = new Goods(); 
      $this->big = new Big();
    }


    public function index()
    {

      //大商品的种类 big
      $res1 = $this->big->referBig();
      foreach ($res1 as $vo ) {
       // $vo['id']
       $res = $this->goods->selectGood($vo['id']);
       //foreach ($res2 as $res) {
        
        foreach($res as $val){
          dump($val);
        }
      }
        //dump($res['name']);
    //     }
    //   }
    //   //die;
    //   //查询商品
     
    //   //dump($res);
    //   //$this->assign('res',$res);
    //   //$this->assign('res1',$res1);
     	return $this->fetch();
    }

     /*发送邮件 并返回验证码*/
    public function getEmailCode()
    {
    	$address = $this->request->post();
    	$address = $address['email'];
    	$emailCode = new SendEmail();
    	$code = $emailCode->getEmailCode($address);
    	$data = ['code' => $code];
    	return json_encode($data);
    }
    
    public function brandList()
    {
    	return $this->fetch();
    }
    public function details()
   	{
   		return $this->fetch();
   	}
   	public function sellDetails()
   	{
   		return $this->fetch();
   	}
   	public function orderDetails()
   	{
   		return $this->fetch();
   	}
   

}
