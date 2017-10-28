<?php
namespace app\index\model;

use think\Model;
use think\Db;
class Seller  extends Model
{
	/*添加信息*/
	public function add($data)
	{
		$this->data($data);
		$this->allowField(true)->save();
		return $this->id;
	}

	public function getByType($key , $value)
	{
		return $this->where($key , $value)->select();
	}

	public function selectSeller()
	{
		return $this->field('id,big_id,name,leader,pnumber,email,description,create_time,checkout')->select();
	}

	public function selectCheckedSeller($key , $value)
	{
		return $this->field('id,big_id,name,description,create_time')->where($key , $value)->select();
	}

	public function check($value1 , $value2)
	{	
		return Db::table('mumma_seller')->where('id', $value1)->update(['checkout' => $value2]);
		//return $user->fetchSql()->where('id', $value1)->update(['checkout' => $value2]);
	}


}
















