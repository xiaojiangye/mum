<?php
namespace app\index\controller;
use think\Controller;
class common 
{	//用户左侧
	 public function mpleft()
      return $this->fetch();
    }
    //用户尾部
     public function mpfooter()
    {
      return $this->fetch();
    }
    //用户的头部
      public function mpheader()
    {
      return $this->fetch();
    }

    //首页的头部
    public function indexHeader()
    {
    	return $this->fetch();
    }
    public function indexFooter()
    {
    	return $this->fetch();
    }




}