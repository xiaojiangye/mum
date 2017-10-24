<?php

namespace app\admin\model;

use think\Model;
use app\admin\model\Big;

class  Small extends Model
{
	public function Big()
	{
		return $this->hasOne('big');
	}

	public function add($data)
	{
		$this->data($data);
		$this->allowField(true)->save();
		$data['create_time'] = date('Y-m-d H:i:s' , time());
		$data['id'] = $this->id;
		return $data;
	}

	public function selectSmall()
	{
		return $this->Field('id , big_id , name , description , create_time')->order(['create_time' => 'desc' , 'id' => 'desc'])->select();
	} 
	
}

















