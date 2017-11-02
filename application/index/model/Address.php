<?php
namespace app\index\model;
use think\Db;
use think\Model;
use think\Session;

class Address extends Model
{
	public function add($data)
	{	
		$time = time();

		//dump($time);
		$addr = $data['province'] . $data['city'] . $data['county'];
		//dump($addr);
		//dump($data);die;
		$id = Session::get('id');
		//dump($data['consignee']);die;
		//dump($id);die;
		$list=[
				'addr_name'  => $data['consignee'],
				'addr_phone' => $data['cphone'],
				'addr_addr'  => $addr,
				'addr_email' => $data['cemail'],
				'addr_detail' => $data['deaddr'],
				'create_time' => $time,
				'user_id'     => $id
		];
	
		$this->data($list);
		return $this->save();
		

	}

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