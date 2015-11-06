<?php
namespace Home\Controller;
use Home\Controller\GlobalController;
class ShijuanController extends GlobalController {
	var $parent_id;
	/**
	 * 初始化
	 */
	function _initialize()
	{
		parent::_initialize();
		$Tiku = A('Tiku');
		$tiku_cart = $Tiku->_getTikuCart();
		$this->assign('tiku_cart',$tiku_cart);
		$this->assign('tikus_in_cart',json_encode($_SESSION['cart']));
	}
	
    public function index(){
    	if(empty($_SESSION['cart'])){
    		redirect('/');
    	}
    	$shijuan_type = !empty($_SESSION['shijuan']['shijuan_type'])?$_SESSION['shijuan']['shijuan_type']:1;//默认的试卷类型：随堂练习
    	$shijuantypeModel = M('shijuan_type');
		$shijuantype_data = $shijuantypeModel->where("id=$shijuan_type")->find();
    	$courseModel = M('tiku_course');
    	$course_data = $courseModel->where("id=".$_SESSION['course_id'])->find();
		$grade = $course_data['course_type']==1?'高中':'初中';
    	$_SESSION['shijuan']['title'] = $grade.$course_data['course_name'].$shijuantype_data['name'].'-'.date('Ymd');
		foreach ($_SESSION['cart'] as $key => $val) {
			if(!in_array($val['type_name'],$arr)){
				$arr[] = $val['type_name'];
			}
		
		}
		
		foreach($arr as $k=>$v){
			$count = 0;
			foreach($_SESSION['cart'] as $key=>$val){
				
				if($v==$val['type_name']){
					$new_arr[$k]['type_name'] = $val['type_name'];
					$new_arr[$k]['ids'] = $new_arr[$k]['ids'].','.$val['id'];
				}
				
			}
		}
		//var_dump($new_arr);
		//区分第一卷和第二卷
		foreach($new_arr as $k=>$v){
			if($v['type_name']=='单选题' || $v['type_name']=='多选题'){
				$data[1][] = $new_arr[$k];
			}else{
				$data[2][] = $new_arr[$k];
			}
		}
		foreach($data as $k=>$v){
			
		}
		var_dump($data);
        $this->display();
	}
	
}