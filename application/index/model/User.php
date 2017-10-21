<?php
namespace app\index\model;

use think\Model;

class User  extends Model
{
	/*把用户信息添加到数据库中!*/
	public function add($data)
	{
		foreach ($data as $key => $value) 
		{
			$data[$key] = trim($value);
		}
		$this->data($data);
		$this->allowField(true)->save();
		return $this->id;
	}

	public function getName($name)
	{
		dump($name);
		return $this->where('name', $name)->select();
	}
}















