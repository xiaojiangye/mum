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
	//电话号码修改
	public function ajaxPhone($data)
	{
		//dump($data);
		$result = $this->where('phone',$data['phone'])->select();
		//dump($result);
		if ($result) {
			return   $this->where('id',session::get('id'))->update(['phone'=>$data['rephone']]);
			 //dump($res);
			 
		}else {
			return  0;
		}

	}
	//邮箱修改
	public function ajaxEmail($data)
	{
		//dump($data);
		$result = $this->where('email',$data['email'])->select();
		//dump($result);
		if ($result) {
			return   $this->where('id',session::get('id'))->update(['email'=>$data['reemail']]);
			 //dump($res); 
		}else {
			return  0;
		}

	}
	//密码修改
	public function ajaxPwd($data)
	{
		//dump($data);
		$result = $this->where('id',session::get('id'))->select()[0];
		//dump($result);
		if ($result['pwd'] == $data['pwd']) {
			return   $this->where('id',session::get('id'))->update(['pwd'=>$data['npwd']]);
			 //dump($res); 

		}

	}
	
}















