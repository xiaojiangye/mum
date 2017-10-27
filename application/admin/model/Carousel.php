<?php

namespace app\admin\model;

use think\Model;

class Carousel extends Model
{
	public function add($data)
	{
		$this->data($data);
		$this->allowField(true)->save();
		$data['id'] = $this->id;
		$data['create_time'] = time();
		$data['status'] = '启用';
		
		/*改成管理员的名字*/
		$data['administor_name'] = '管理员名';
	 	return $data;
	}

	public function selectCarousel()
	{
		return $this->order('create_time' , 'desc')->select();
	}


}






















