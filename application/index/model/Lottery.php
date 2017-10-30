<?php

namespace app\index\model;

use think\Model;
use app\index\model\User;
use think\Db;
use think\Session;

class Lottery	extends Model
{
	public function add($data)
	{
		$user = new User();
		/*登录之后进行用户id的修改Session::get('id')*/
		$res = $user->getByType('id' , Session::get('id'))[0];
		if($res['grade'] < 10)
		{
			return null;
		}
		else
		{
			/*这里也需要改id*/
			$data = $data - 10;
			return Db::table('mumma_user')->where('id', Session::get('id'))->setInc('grade' , $data);
		}
	}

}



















