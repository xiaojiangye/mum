<?php
namespace app\admin\Model;
use think\Model;
use traits\model\SoftDelete;

class User extends Model
{	
	use SoftDelete;
	public function select() 
	{
		return $this->field('id,uname,phone,email,sex,create_time')->select();
		//dump($res);die;

	}
	//搜索
	public function searchUser($data)
	{	
		$uname = $data['uname'];
		//dump($uname);
		//dump($data);
		$res = $this->fetchSql(true)->where(['uname'=>'like','%$uname%'])->field('id,uname,sex,phone,email,create_time')->select();
		//dump($res);die;
	}
	//查看状态
	public function getStatusAttr($value)
	{
		$status = [0=>'禁用',1=>'正常'];
		return $status[$value];
	}

}