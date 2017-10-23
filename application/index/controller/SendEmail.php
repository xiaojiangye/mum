<?php

namespace app\index\controller;

/*require_once './SMTP.php';
require_once './PHPMailer.php';*/

use app\index\controller\SMTP;
use app\index\controller\PHPMailer;
use think\controller;

class SendEmail extends Controller
{
	function getEmailCode($address)
	{
		$mail = new PHPMailer();
		//$mail = new PHPMailer();
		$mail->isSMTP();// 使用SMTP服务
		$mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
		$mail->Host = "smtp.163.com";// 发送方的SMTP服务器地址
		$mail->SMTPAuth = true;// 是否使用身份验证
		$mail->Username = "hsy1763485417@163.com";// 发送方的163邮箱用户名
		$mail->Password = "hsy199659";// 发送方的邮箱密码，注意用163邮箱这里填写的是“客户端授权密码”而不是邮箱的登录密码！
		$mail->SMTPSecure = "ssl";// 使用ssl协议方式
		$mail->Port = 994;// 163邮箱的ssl协议方式端口号是465/994

		$mail->setFrom("hsy1763485417@163.com","RoronoaZoro");// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示
		$mail->addAddress($address,'小馋猫');
		/*$mail->addAddress("2721423445@qq.com",'小馋猫');*/// 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)
		//$mail->addReplyTo("zzzz@163.com","Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
		//$mail->addCC("aaaa@inspur.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址
		//$mail->addBCC("bbbb@163.com");// 设置秘密抄送人
		//$mail->addAttachment("bug0.jpg");// 添加附件

		$code = $this->createCode();

		$mail->Subject = "小馋猫商城验证";// 邮件标题
		$mail->Body = "欢迎来到小馋猫,馋小喵一定会为您提供最好的服务!您的验证码是 $code , 不要告诉别人哦!";// 邮件正文
		//$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用

		if(!$mail->send()){// 发送邮件
		    echo "Message could not be sent.";
		    echo "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
		}else{
		    echo 'Message has been sent.';
		}

		return $code;
	}

	public function createCode()
	{
		$code = null;
		for($i =0 ; $i < 6 ; $i++ )
		{
			$code .= mt_rand(0,9);
		}
		return $code;
	}
}
