<?php
namespace Home\Controller;
use Home\Controller\GlobalController;
class MemberController extends GlobalController {
	/**
	 * 初始化
	 */
	function _initialize()
	{
		parent::_initialize();
	}
    public function index(){
        $this->display();
	}
	public function register(){
		if($_POST){
			$type = I('post.type');
			$email = I('post.email');
			$nick_name = I('post.nick_name');
			$password = I('post.password');
			
			$data['create_time'] = time();
			$data['last_login'] = time();
			$data['login_ip'] = get_client_ip();
			$data['type'] = $type;
			$data['nick_name'] = $nick_name;
			$data['email'] = $email;
			$data['password'] = md5($password);
			//var_dump($_POST);exit;
			$Model = M('User');
			if($Model->add($data)){
				$_SESSION['nick_name'] = $nick_name;
				redirect("/member/",'页面跳转中');
			}
		}else{
			$this->display();
		}
		
	}
	public function login(){
		if($_POST){
			$user = I('post.username');
			$password = I('post.password');
			$Model = M('User');
			$result = $Model->where("(email='$user' OR telphone='$user') AND password='".md5($password)."'")->find();
			//echo $Model->getLastSql();exit;
			//var_dump($result);exit;
			if($result){
				$_SESSION['nick_name'] = $result['nick_name'];
				redirect("/member/");
			}else{
				$error_msg = "登录邮箱/手机号或者密码错误!";
				$this->assign('error_msg',$error_msg);
			}
		}
		$this->display();
		
	}
	public function logout(){
		session_destroy();
		redirect('/');
	}
	public function ajaxCheckUser(){
		$user = trim($_POST['param']);
		$Model = M('User');
		$resutl = $Model->where("email='$user' OR telphone='$user'")->find();
		if(!$resutl){
			$this->ajaxReturn(array('status'=>'n','info'=>'该用户还未注册'));
		}else{
			$this->ajaxReturn(array('status'=>'y','info'=>'验证通过'));
		}
	}
	public function ajaxCheckEmail(){
		$email = trim($_POST['param']);
		$Model = M('User');
		$resutl = $Model->where("email='$email'")->find();
		if(!$resutl){
			$this->ajaxReturn(array('status'=>'y','info'=>'通过验证'));
		}else{
			$this->ajaxReturn(array('status'=>'n','info'=>'该邮箱已存在！'));
		}
	}
	public function ajaxCheckNickname(){
		$nickname = trim($_POST['param']);
		$Model = M('User');
		$resutl = $Model->where("nick_name='$nickname'")->find();
		if(!$resutl){
			$this->ajaxReturn(array('status'=>'y','info'=>'通过验证'));
		}else{
			$this->ajaxReturn(array('status'=>'n','info'=>'该昵称已存在！'));
		}
	}
}