<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Session;

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

	/*根居id查询用户的信息*/
	public function refer($data)
	{
		return $this->where('id',session::get('id'))->select();
	}  

	public function ajaxUser($data)
	{
		//return $this->where('id',session::get('id'))->update(['name'=>$data['name'],'phone'=>$data['phone'],'email'=>$data['email']]);*/
		//dump($data['name']);die;
		return $this->where('id',session::get('id'))->update(['name'=>$data['name']]);
	}

	public function ajaxPhone($data)
	{	
		$result = $this->where('phone','$data.phone')->select();
		if ($result) 
		{
		   $res =  $this->where('id',session::get('id'))->update(['phone'=>$data['rephone']]);
		   return $res;
		}
		else
		{
			$res = 0;
			return $res;
		}

	}
	
}















