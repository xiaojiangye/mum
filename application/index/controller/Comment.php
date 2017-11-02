<?php
namespace app\index\controller;
use think\Controller;
class Comment extends Controller
{
	public function Comment()
	{
		return $this->fetch();
	}
}