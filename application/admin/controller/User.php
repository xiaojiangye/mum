<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\admin\model\User as UserModel;
class User extends Controller
{	protected $user;
	//自动触发的初始化函数
	public function _initialize()
	{
		$this->user = new UserModel();
	}
	//驱动模板
	public function user()
	{	//返回查询的结果
		$res = $this->user->select();
		//用户状态
		//$res1 = $this->user->getStatusAttr()
		//用户数量
		$count = Db::table('mumma_user')->count('id');
		$this->assign('res',$res);
		//$this->assign('res1',$res1);
		$this->assign('count',$count);
		return $this->fetch();
	}
	//查询
	public function search()
	{
		$data = $this->request->post();
		//dump($data);
		$res = $this->user->searchUser($data);

		if ($res) {
			return 1;
		}else {
			return 0;
		}
	}
	


}
