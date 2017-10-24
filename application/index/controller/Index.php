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
