<?php
namespace app\index\controller;
use think\Controller; 
use think\Request;
use think\index\View;
use think\Db;
use think\Session;
use app\index\model\User as UserModel;

class User extends Controller
{

protected $user;
  public function _initialize()
  {
    $this->user = new UserModel();
  }
    public function regist()
    {
        return $this->fetch();
    }
    public function login()
    {    
        
        return $this->fetch();
    }
    public function dologin()
    {   

        $name = input('post.name');
        $pwd = input('post.pwd');
        $result =  Db::table('mumma_user')->where('name',"$name")->find();
       //查询结果
        if ($result) {
            if ($pwd !== $result['pwd']) {
            return 0;
            }else {
                $id = $result['id'];
                //echo "$id";
                //添加登录的时间
              Session::set('name',"$name");
               Session::set('id',"$id");   
                 return 1;
            } 
        }else {
            return 2;
        }  
    }
   
     //我的地址
    public function memberAddress()
    {  //
      //$user=ModelUser::get(1);
      // $user = new UserModel();
      // $res = $user->refre();
      // $this->assign('res',$res);
      return $this->fetch();
    }
    //我的现金
     public function memberCash()
    {   
        return $this->fetch();
    }
    //我的收藏
     public function memberCollect()
    {   
        return $this->fetch();
    }
    //我的信息
     public function memberUser()
    {  
      // 
     


        $user = new UserModel();
        $res = $user->select()[0]; 
        //dump($res['grade']);

        $this->assign('res',$res);

        return $this->fetch();
    }

    //修改个人信息
    public function editUser()
    {
       $data = $this->request->post();
      //dump($data);
       $res = $this->user->ajaxUser($data);

      
      //dump($res);die;
       if($res) {
        return $res;
        //dump($result);die;
       }else {
        return 0;
       }
       
    }
    //上传头像
    public function upload(){
  //?获取表单上传文件?例如上传了001.jpg
     $file = $this->request->file("image");
      //dump($file);
        //?移动到框架应用根目录/public/uploads/?目录下
        if($file){
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        //dump($info);die;
        if($info){
        //?成功上传后?获取上传信息
        //?输出?jpg
        echo $info->getExtension();
        //?输出?20160820/42a79759f284b767dfcb2a0197904287.jpg
        echo $info->getSaveName();
        //?输出?42a79759f284b767dfcb2a0197904287.jpg
        echo $info->getFilename();
        }else{
        //?上传失败获取错误信息
        echo $file->getError();
        }
      }
    }
    //我的留言
     public function memberMsg()
    {   
        return $this->fetch();
    }
    //我的评价
      public function memberResults()
    {  
        return $this->fetch();
    }
    public function memberOrder()
    {  
        return $this->fetch();
    }
    
    //账户安全
     public function memberSafe()
    {
      return $this->fetch();
    }
    //账户安全验证 电话修改
    public function pedit()
    {
      $data = $this->request->post();
      return 1;
     /* 
      $result = $this->user->ajaxPhone($data);
      if ($result == 0) {
        return 0;//原手机号码不正确
      }else {
        if($reult) {
          return 1;//修改成功
        }else {
          return 2; //修改失败
        }
      }*/

    }




    //资金管理
     public function memberMoney()
    {
      return $this->fetch();
    }
   




   
}