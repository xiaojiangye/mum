<?php

namespace app\admin\model;

use think\Model;

class Big  extends  Model
{
	public function getByType($data)
	{
		return  $this->where( 'style' , $data)->select();
	}

	public function add($data)
	{
		$this->style = $data['style'];
		$this->description = $data['description'];
		$this->save();
		$data = ['id' => $this->id , 'style' => $data['style'] , 'description' => $data['description'] , 'create_time' => date('Y-m-n H:i:s',time())];
		return $data;
	}

	public function selectBig()
	{
		return $this->field('id , style , description , create_time')->order('create_time' , 'desc')->select();
	}

}











