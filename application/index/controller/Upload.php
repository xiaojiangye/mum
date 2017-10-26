<?php
namespace app\index\controller;

use think\Controller;
use think\Session;

class Upload extends Controller
{
	protected $goods ;
	public function _initialize()
	{
		$this->goods = new Addgoods();
	}

	public function uploader()
	{
		return $this->fetch();
	}

	/*得到个人信息 存入session中*/
	public function getInfo()
	{
		$data = $this->request->post();
		if(empty($data))
		{
			die;
		}
		foreach ($data as  $key => $value) 
		{
			Session::set( $key, $value);
		}
		return 1;
	}

	/*得到图片并进行上传*/
	public function uploadPicture()
	{
		//dump(Session::get('name'));
		$rdate=date("Y-m-d",time()); 	//文件名
		if(!file_exists('./uppicture/' . $rdate))
		{
			mkdir('./uppicture/' . $rdate);  //创建目录
		}

		$uploaddir = './uppicture/' . $rdate . '/';
		
		$uploadfile = $uploaddir . time() . $_FILES['file']['name'];
		Session::set( 'picture', $uploadfile );
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
		{
			echo '已在您的小店首页展示了哦!';
		} else {
		    print "上传失败!:\n";
		    die;
		}

		/*调用函数 把信息存入到数据库中*/
		$this->goods->addInfo();

	}
}
