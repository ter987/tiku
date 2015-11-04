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
		$this->checkLogin();
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
		
		
		$this->display();
	}
	public function logout(){
		session_destroy();
		redirect('/');
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