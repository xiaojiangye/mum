<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Carousel as CarouselModel;

class Carousel extends Controller
{
	protected $carousel;

	public function  _initialize()
	{
		$this->carousel = new CarouselModel();
	}

	public function carousel()
	{
		return $this->fetch();
	}

	/*
	 * 接收图片上传
	 *  1.通过ajax接收图片。
	 *  2.图片上传验证。
	 *  3.将图片移动到框架应用目录 public/uploads 目录下。
	 *  4.注意：当图片大于2M，由于php.ini配置，会报出一个致命错误。网站上线后需要手动配置。
	 */
	
	/*上传图片*/
	public function upload()
	{
		
	    $file = request()->file('myfile'); 
	    
	    // 验证图片,并移动图片到框架目录下。
	    $info = $file -> validate(['size' => 512000,'ext' => 'jpg,png,jpeg','type' => 'image/jpeg,image/png']) -> move(ROOT_PATH.'public'.DS.'carousel');
	    if(!$info)
	    {
	    	 // 文件上传失败后的错误信息
	        $mes = $file->getError();
	        echo '{"mes":"'.$mes.'"}';   	
	    }

	    $mes = $info->getFilename();  // 文件名

	    /*图片上传成功后再把信息传过去进行添加*/
    	$sort = request()->post('sort');
	    $pictureUrl  =  request()->post('pictureUrl');
	    $res = ['mes' => $mes , 'sort' => $sort , 'pictureUrl' => $pictureUrl ];

	    //此处待登录后替换成管理员的name值
	    $data['administor_name'] = '小馋猫';
	    $data['sort'] = $sort;
	    $data['link'] = $pictureUrl;
	    $data['url'] = './carousel/' . $mes;

	    $res = $this->carousel->add($data);
	    return json_encode($res);
	    if($res)
	    {
	    	return json_encode($res);
	    	// $info->getExtension();         // 文件扩展名 
       		 /*echo '{"mes":"'.$mes.'" , "sort":"'.$sort.'" , "pictureUrl":"'.$pictureUrl.'"  }';*/
	    }
	    else
	    {
	    	return 0;
	    }
	    die; 

	   	
	}

}























