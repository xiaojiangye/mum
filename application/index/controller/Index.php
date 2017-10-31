<?php
namespace app\index\controller;

use think\Controller; 
use think\View;
use think\Requst;
use app\admin\model\Big;
use app\index\model\Goods;
use app\index\controller\SendEmail;
use think\Session;
use think\Validate;

class Index  extends Controller
{   
    protected $goods;
    protected $big;
    public function _initialize()
    {
      $this->goods = new Goods(); 
      $this->big = new Big();
    }
    //首页展示
    public function index()
    {
      //大商品的种类 big
        $res1 = $this->big->referBig();
        $goods = model('goods');
        $goods_res = $goods->select();
        $this->assign('res1',$res1);
        $this->assign('goods_res',$goods_res);
        return $this->fetch();
    }

     /*发送邮件 并返回验证码*/
    public function getEmailCode()
    {
    	$address = $this->request->post()['email'];
    	$emailCode = new SendEmail(); 
    	$code = $emailCode->getEmailCode($address);
      Session::set('emailCode' , $code);
      return 1;
      //return Session::get('emailCode');
    }

    /*检查邮箱验证码*/
    public function checkEmailCode()
    {
      $code = $this->request->post()['code'];
      if($code == Session::get('emailCode'))
      {
        return 1;
      }
      return null;
    }

    /*检查图片验证码*/
    public function checkImageCode()
    {
      $imageCode = $this->request->post('imageCode');   
     // return $imageCode;

      $validate = new Validate([
      'captcha|验证码'=>'require|captcha'
      ]);
    
      $data = [
        'captcha' => $imageCode
      ];

      if(!$validate->check($data)){
        return 0;
      }
      return 1;
      
    }

    //类型商品类型
    public function brandList()
    { 
     $big = input('param.');
    // dump($big);
     //根据传过来的big得到
     $res = $this->goods->selectList($big);
    //dump($res);die;
     $this->assign('res',$res);
    	return $this->fetch();
    }
    
  //商品的具体详情
    public function details()
   	{ 
      $good = input('param.');
      $res = $this->goods->goodsDetails($good);
      $big_style = $this->big->getByField( 'id' , $res[0]['big_id'])[0]['style'];
      $res[0]['big_style'] = $big_style;
      //dump($res[0]['stock']);die;
      //同一产品的图片
      $res1 = $this->goods->samePhoto($res[0]['number']);
      //用户还喜欢 like
      $res_like = $this->goods->likeGood();
      $this->assign('res',$res);
      $this->assign('res1',$res1);
      $this->assign('res_like',$res_like);
   		return $this->fetch();
   	}

    
   	public function sellDetails()
   	{
   		return $this->fetch();
   	}
    
   	public function orderDetails()
   	{
   		return $this->fetch();
   	}


}
