<?php
namespace app\index\controller;

use think\Controller; 
use think\View;
use app\index\controller\SendEmail;

class Index  extends Controller
{
    public function index()
    {
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
