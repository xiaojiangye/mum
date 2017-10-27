<?php
namespace app\index\model;
use think\Db;
use think\Model;
use think\Session;

class Address extends Model
{
	// public function add($data)
	// {	
	// 	$time = time();
	// 	//dump($time);
	// 	$addr = $data['s_province'] . $data['s_city'] . $data['s_county'];
	// 	//dump($addr);
	// 	$id = Session::get('id');
	// 	//dump($id);die;
	// 	$list=[
	// 			'addr_name'  => $data['consignee'],
	// 			'addr_phone' => $data['cphone'],
	// 			'addr_addr'  => $addr,
	// 			'addr_email' => $data['cmeail'],
	// 			'addr_detail' => $data['deaddr'],
	// 			'addr_code'  => $data['code'],
	// 			'addr_bulid'     => $data['cbulid'],
	// 			'create_time' => $time,
	// 			'user_id'     => $id

	// 	];

	// 	$res = $this->save($list);
	// 	return $res;

	// }

	public function select()
	{

		$res =$this->where('user_id',Session::get('id'))->select();
		return $res;
		//dump($res);
	}
	//是否设置为默认
	/*public function mo()
	{	$id = $data['id'];
		$res = $this->where('id',$id)->update(['is_default'=>])
	}
*/



}