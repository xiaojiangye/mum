<?php
namespace app\index\model;
use think\Model;
class Order extends Model
{
	public function order($gather)
	{	
		foreach ($gather as $key => $value) 
		{
			//var_dump($value);
			$this->data($value);
			 $this->save();


		}

	    //dump($data);
	    /*foreach ($info as $key => $value) 
		{
			
			$this->allowField(true)->data[$value];
			$this->save();
			
		}*/
//var_dump($value);
		/*foreach ($info as $vo) {
		$data[] = [
					'user_id'=>session::get('id'),
					'good_id'=>$vo['id'],
					'number'=>$vo['count'],
					'is_pay'=>0,
					'num_id'=>$number,
					'payable'=>$amount
			   ];
		}
*/
	}

}
