<?php
namespace app\index\model;

use think\Model;

class User  extends Model
{
	/*把用户信息添加到数据库中!*/
	public function add($data)
	{
		$this->data($data);
		$this->allowField(true)->save();
		return $this->id;
	}

	/*根据名字去得到某个具体的全部信息*/
	public function getName($name)
	{
		/*dump($name);*/
		return $this->where('name', $name)->select();
	}
}















