<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\index\modle\Car as CarModle;

class Car extends Controller
{	
	protected $car;
	public function _initialize()
	{
		$this->car = new CarModle();
	}
	public function car()
	{	
		return $this->fetch();
	}
	// public function addcar()
	// {
	// 	/*$good = $_POST['good'];
	// 	dump($good);die;*/
	// 	// if (empty(Session::get('id')){
	// 	// 	$good = Session::set('good_id',$good);
	// 	// 	$this->car->save(['good_id'=>$good]);
	// 	// }else {
	// 	// 	$good = Session::set('good_id',$good);
	// 	// 	$this->car->save(['good_id'=>$good],['user_id'=>Session::get('id')]);
	// 	// }
		


	// }
	
}