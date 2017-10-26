<?php
namespace app\admin\controller;
use think\Request;
use think\Controller;
use app\admin\model\Article as ArticleModel;

class Article extends Controller
{
	/*protected $acr;
	public function _initialize()
	{
		$this->acr =  new ArticleModel();

	}*/
	public function articleList()
	{
		return $this->fetch();
	}
	public function articleType()
	{
		return $this->fetch();
	}

}