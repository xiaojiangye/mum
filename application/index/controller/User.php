<?php
namespace app\index\controller;
use think\Controller; 
use think\Db;
use ucpaas\Ucpaas;
use think\Session;
use app\index\model\User as UserModel;
use app\admin\model\Big;
use app\index\model\Seller;

class User extends Controller
{
    protected $user;
    protected $small;
    protected $big;
    protected $seller;
    
    public function _initialize()
    {
      $this->user =  new UserModel();
      $this->big = new Big();
      $this->seller = new Seller();
    }


    /*注册时查询用户名是否存在的判断*/
    public function selectUser()
    {
      $data = $this->request->post();
      $name = $data['name'];
      if($data['style'] == '买家')
      {
        if(!empty($this->user->getName($name)))
          {
            return 0;
          }
      }
      else if($data['style'] == '卖家')
      {
         if(!empty($this->seller->getByType('name' , $name)))
         {
           return 0;
         }
      }
      return 1;
    }


    /*渲染注册页面*/
    public function regist()
    {
       $res = $this->big->selectBig();
      $this->assign('res' , $res);
      return $this->fetch();
    }


    /*添加注册时的个人信息*/
    public function addUserInfo()
    {
      $data = $this->request->post();
      $res = $this->user->add($data);
      if($res)
      {
        return 1;
      }else{
        return 0;
      }
    }

      // 登录时渲染页面
    public function login()
    {      
      return $this->fetch();
    }

    //退出登录
    public function exit()
    {
       session(null);
      $this->redirect('index/index');
    }


    //发送短信验证码




  //判断登录的条件
    public function dologin()
    {   
      $uname = input('post.uname');
      $pwd = input('post.pwd');
      $result =  Db::table('mumma_user')->where('uname',"$uname")->find();
       //查询结果
      if ($result) 
      {
        if ($pwd !== $result['pwd']) {
          return 0;
        }else{
          $id = $result['id'];
          //echo "$id";
         // dump($id);die;
          //添加登录的时间
          Session::set('uname',"$uname");
         // dump($id);die;
          Session::set('id',"$id");
          Session::set('type',0);

          //dump(Session::get('id'));   
          //dump(Session::get('uname'));die;   
          return 1;
        } 
      }
      else 
      {
          return 2;
      }  
    }
   

    //发送短信验证码
  /*  public function sendYzm()
    {
      $request = Request::instance();
       $to = $request->parm()['name'];
       $param="1234";
       $options['accountsid']='43fab68019f837bb6835460d13310a52';
       $options['token']='93c07db4fa07055cb6a9ee40642228e8';
       //初始化 $options必填
       $ucpass = new Ucpaas($options);
      //开发者账号信息查询默认为json或xml
      header("Content-Type:text/html;charset=utf-8");
    //短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
    $appId = "73e13615718e48b0b73a4051e3cad024";
    $templateId = "159108";

    $result = $ucpass->templateSMS($appId,$to,$templateId,$param);
    $result = json_encode($result)->resp->respCode;
    if ($result == "000000") {
      return json_encode('2');
    }else {
      return json_encode('1');
    }
    }*/


    /*我的现金*/
    public function memberCash()
    {   
        return $this->fetch();
    }

    /*我的收藏*/
    public function memberCollect()
    {   
        return $this->fetch();
    }

    /*我的信息*/
    public function memberUser()
    {  
      $user = new UserModel();
      $res = $user->where('id',session::get('id'))->select()[0]; 
      //dump($res);die;
      //dump($res['grade']);

      $this->assign('res',$res);

      return $this->fetch();
    }

    /*修改个人信息*/
    public function editUser()
    {
       $data = $this->request->post();
      //dump($data);
       $res = $this->user->ajaxUser($data);
      //dump($res);die;
       if($res) 
       {
         return $res;
         //dump($result);die;
       }
       else 
       {
         return 0;
       } 
    }

    //上传头像
    public function image(){
  //?获取表单上传文件?例如上传了001.jpg
     $file = $this->request->file("image");
      dump($file);
        //?移动到框架应用根目录/public/uploads/?目录下
      if($file)
      {
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
         //dump($info);die;
        if($info)
        {
          //?成功上传后?获取上传信息
          //?输出?jpg
          //echo $info->getExtension();
          //?输出?20160820/42a79759f284b767dfcb2a0197904287.jpg
          echo $info->getSaveName();
          //?输出?42a79759f284b767dfcb2a0197904287.jpg
             echo $info->getFilename();
        }
        else
        {
          //?上传失败获取错误信息
          echo $file->getError();
        }
      }
    }

    /*我的留言*/
    public function memberMsg()
    {   
        return $this->fetch();
    }


    /*我的评价*/
      public function memberResults()
    {  
        return $this->fetch();
    }


    public function memberOrder()
    {  
        return $this->fetch();
    }
    
    /*账户安全*/
    public function memberSafe()
    {
      return $this->fetch();
    }
    //积分
    public function memberGrade()
    {
      return $this->fetch();
    }

    //账户安全验证 电话修改
    public function editPhone()
    {
      $data = $this->request->post();
      $result = $this->user->ajaxPhone($data);
      if ($result == 0) {
        return 0;//原手机号码不正确
      }else if($result) {
          return 1;//修改成功
        }else{
          return 2; //修改失败
        }

    }

    //账户安全验证 邮箱修改
    public function editEmail()
    {
      $data = $this->request->post();
      //dump($data);die;
      $result = $this->user->ajaxEmail($data);
      if ($result == 0) {
        return 0;//原邮箱不正确
      }else if($result) {
          return 1;//修改成功
        }else{
          return 2; //修改失败
        }
    }

     //账户安全验证 密码修改
    public function editPwd()
    {
      $data = $this->request->post();
      //dump($data);die;
      $result = $this->user->ajaxPwd($data);
     if($result) {
          return 1;//修改成功
        }else{
          return 2; //修改失败
        }
      }
    /*资金管理*/
    public function memberMoney()
    {
      return $this->fetch();
    }
}

