<?php

namespace app\admin\model;

use app\admin\model\Small;
use think\Model;

class Big  extends  Model
{
	/*关联small的数据表  它们之间有一个big_id的联系*/
	public function Small()
	{
		$this->belongsTo('small');
	}

	/*通过某个字段得到数据 也就是在检查某个是否存在*/
	public function getByType($data)
	{
		return  $this->where( 'style' , $data)->select();
	}

	/*根据传入的字段得到信息*/
	public function getByField($field , $val)
	{
		return $this->where($field , $val)->select();
	}

	/*添加大版块的数据*/
	public function add($data)
	{
		$this->style = $data['style'];
		$this->description = $data['description'];
		$this->save();
		$data = ['id' => $this->id , 'style' => $data['style'] , 'description' => $data['description'] , 'create_time' => date('Y-m-n H:i:s',time())];
		return $data;
	}

	/*查询所有的大版块的所有信息*/
	public function selectBig()
	{
		return $this->field('id , style , description , create_time')->order('create_time' , 'desc')->select();
	}

}











