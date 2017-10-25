<?php

namespace app\admin\model;

use think\Model;
use app\admin\model\Big;

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
	  return $this->Field('id , big_id')->where($key , $value)->select();
	}
	
}

















