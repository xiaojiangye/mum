<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\index\model\Address as AddressModel;
class Address extends Controller
{
	protected $address;
	public function _initialize()
	{
		$this->address = new AddressModel();
	}
	public function address()
	{	
		//查询地址
		$res = $this->address->select();
		$this->assign('res',$res);
		return $this->fetch();
	}
	//添加地址
	public function addAddr()
	{
		$data = $this->request->post();
		//dump($data);die;
		$res = $this->address->add($data);
		//$res1 = $this->count()->where('user_id',Session::get('id'));
		 //dump($res1);die;
		//dump($res);
		if ($res) {
			return 1;
		}else {
			return 0;
		}	
	}
	//是否设为默认
	// public function addrMo()
	// {
	//    $data = $this->request->post();
	//    $res = $this->address->mo($data);

	// }

}