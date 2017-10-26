<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\request;
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
		return $this->fetch();
	}
	public function addaddr()
	{
		$data = $this->request->post();
	}

}