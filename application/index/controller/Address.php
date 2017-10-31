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
	//渲染页面
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
		dump($data);die;
		
	}
	//是否设为默认
	// public function addrMo()
	// {
	//    $data = $this->request->post();
	//    $res = $this->address->mo($data);

	// }

}