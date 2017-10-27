<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Collect as CollectModel;
class Collect extends Controller
{
	public function collect()
	{
		return $this->fetch();
	}
}