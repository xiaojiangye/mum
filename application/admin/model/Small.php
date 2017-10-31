<?php

namespace app\admin\model;

use think\Model;
use app\admin\model\Big;
use think\Session;
use app\admin\model\small;


class  Small extends Model
{
/*	public function Big()
	{
		return $this->hasOne('big');
	}*/

	/*插入小版块的数据*/
	public function add($data)
	{
		$this->data($data);
		$this->allowField(true)->save();
		$data['create_time'] = date('Y-m-d H:i:s' , time());
		$data['id'] = $this->id;
		return $data;
	}

	/*查询所有的小版块 用来驱动页面的数据*/
	public function selectSmall()
	{
		return $this->Field('id , big_id , name , description , create_time')->order(['create_time' => 'desc' , 'id' => 'desc'])->select();
	} 

	/*根据某种特殊的值得到对应的全部信息*/
	public function getByType($key , $value)
	{
		/*if(!$value)
		{
			return $this->Field($key)->select();
			die;	
		}
		else
		{
			return $this->Field('id , big_id , name')->where($key , $value)->select();
		}*/
		if(!$value)
		{
			return $this->Field($key)->select();
			die;	
		}
		else
		{
			return $this->Field('id , big_id , name')->where($key , $value)->select();
		}
	  
	}

	/*查出商家可以添加的小版块类型*/
	public function addCategory($key , $value)
	{
		$id = Session::get('id');
		$big_id = $this->getByType('id' , $id)[0]['big_id'];
		return $this->Field('id , big_id , name')->where($key , $value)->whereOr('big_id' , $big_id)->select();
		//return 1;
	}
	
}

















