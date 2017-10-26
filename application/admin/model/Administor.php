<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use app\admin\model\User;
use app\admin\model\Administor;


class Administor  extends  Model
{
	public function adminAll()
	{
		/*$result = Db::table('mumma_user,mumma_administor')->fetchSql(true)->field('mumma_user.uname')->where(['mumma_user.id' => 'mumma_administor.user_id'])->select();*/
		/*$result = Db::table('mumma_user')->where('id' , '=' , function($query){
			$query->table('mumma_administor')->field('user_id');
		})->select();
*/
		$res = Db::field('user.uname,user.phone,user.email,user.id,admin.status,user.create_time')
				->table('mumma_user user,mumma_administor admin')
				->where('user.id = admin.user_id')
				->select();
		//dump($res);die;
		return $res;

	}
	
	//查询管理员的个人信息
	public function selectAdmin()
	{
		$res = Db::field('user.uname,user.phone,user.email,user.money,user.id,admin.status,user.create_time,user.sex')
				->table('mumma_user user,mumma_administor admin')
				->where('user.id = 2')
				->select();
				//dump($res);die;
				return $res;
		

	}
	//管理员的用户信息





}












