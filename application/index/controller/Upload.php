<?php
namespace app\index\controller;

use think\Controller;

class Upload extends Controller
{
	public function upload()
	{
		return $this->fetch();
	}

	public function uploadPicture()
	{
		$rdate=date("Y-m-d",time()); 	//文件名
		if(!file_exists('./uppicture/' . $rdate))
		{
			mkdir('./uppicture/' . $rdate);  //创建目录
		}

		$uploaddir = './uppicture/' . $rdate . '/';
		

		$uploadfile = $uploaddir. $_FILES['file']['name'];

		//var_dump($uploadfile);
		/* print "<pre>"; */
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . time() . $_FILES['file']['name'])) {
		    print "上传成功!:\n";
		   // print_r($_FILES);
		} else {
		    print "上传失败!:\n";
		   // print_r($_FILES);
		}
		/* print "</pre>"; */
	}
}
