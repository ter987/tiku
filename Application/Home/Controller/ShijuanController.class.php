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
		$course_data = parent::getCourse();
		$this->assign('course_data',$course_data);
		$tiku_cart = $this->_getTikuCart();
		$this->assign('tiku_cart',$tiku_cart);
		$this->assign('tikus_in_cart',json_encode($_SESSION['cart']));
	}
	
    public function index(){
    	
        $this->display();
	}
	/**
	 * 试题详情页
	 */
	public function detail(){
		$id = I('get.id');
		if(!id){//错误提示页面
			
		}
		$Modle = M('tiku');
		$data = $Modle->field("tiku.id,tiku.analysis,tiku.answer,tiku.content,tiku_source.course_id,tiku_course.id,tiku_course.course_name,tiku_source.source_name,tiku_difficulty.section")
		->join("tiku_source ON tiku_source.id=tiku.source_id")
		->join("tiku_difficulty ON tiku_difficulty.id=tiku.difficulty_id")
		->join("tiku_course ON tiku_course.id=tiku_source.course_id")
		->where("tiku.id=$id")->find();
		if(!$data){//错误提示页面
			
		}
		//获取推荐试题
		$recommend = $this->_getRecommendTiku($data['course_id']);
		
		$this->assign('recommend',$recommend);
		$this->assign('tiku_data',$data);
		$this->display();
	}
	protected function _getTikuCart(){
		if($_SESSION['cart']){
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
						$count ++;
						$new_arr[$k]['num'] = $count;
					}
					
				}
			}
			return $new_arr;
		}else{
			return false;
		}
	}
	public function ajaxAddTiku(){
		$id = I('get.id');
		if($_SESSION['cart'][$id]){//如果已存在试题蓝，则移出
			unset($_SESSION['cart'][$id]);
			//$this->ajaxReturn(array('status'=>'success','data'=>$_SESSION['cart']));
		}else{
			$Model = M('tiku');
			$data = $Model->field("tiku.id,tiku_type.type_name")->join("tiku_type ON tiku_type.id=tiku.type_id")->where("tiku.id=$id")->find();
			if($data){
				$_SESSION['cart'][$data['id']] = array('id'=>$data['id'],'type_name'=>$data['type_name']);
				
			}else{
				$this->ajaxReturn(array('status'=>'error'));
			}
		}
		
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
					$count ++;
					$new_arr[$k]['num'] = $count;
				}
				
			}
			//$new = $new_arr;
		}
		$this->ajaxReturn(array('status'=>'success','data'=>$_SESSION['cart'],'type_data'=>$new_arr));
		
	}
	/**
	 * 获取推荐试题
	 */
	protected function _getRecommendTiku($course_id){
		$Model = M('tiku');
		$result = $Model->field("tiku.id,tiku.content")->where("tiku_source.course_id=$course_id")->join("tiku_source ON tiku_source.id=tiku.source_id")->order("RAND()")->find();
		return $result;
	}
	/**
	 * 根据course_id获取所有知识点
	 */
	public function getPointsByCourseId($course_id){
		$data = S('tiku_points_'.$course_id);
		if(!$data){
			$Model = M('tiku_point');
			$child_data = $Model->where("course_id=$course_id")->select();
			if(!$child_data){
				return false;
			}
		$data = $this->getTree($child_data,0);
		}
		return $data;
		
	}
	/**
	 * 获取题型
	 * 单选题、多选题。。。
	 */
	public function getTikuType($course_id){
		$data = S('tiku_type_'.$course_id);
		if(!$data){
			$Model = M('tiku_type');
			$data = $Model->field("tiku_type.`type_name`,tiku_type.`id`")->join("course_to_type on tiku_type.id=course_to_type.type_id")->where("course_to_type.course_id=$course_id")->select();

			S('tiku_type_'.$course_id,$data,array('type'=>'file','expire'=>FILE_CACHE_TIME));
		}
		return $data;
	}
	/**
	 * 获取题库难度数据
	 */
	public function getTikuDifficulty(){
		$data = S('tiku_difficulty');
		if(!$data){
			$Model = M('tiku_difficulty');
			$data = $Model->order('degreen desc')->select();
			S('tiku_difficulty',$data,array('type'=>'file','expire'=>FILE_CACHE_TIME));
		}
		return $data;
	}
	/**
	 * 获取题目特点
	 * 历年高考真题、名校模拟题。。。
	 */
	public function getTikuFeature($feature_type){
		$data = S('tiku_feature');
		if(!$data){
			$Model = M('tiku_feature');
			$data = $Model->where("feature_type=$feature_type")->select();
			S('tiku_feature',$data,array('type'=>'file','expire'=>FILE_CACHE_TIME));
		}
		return $data;
	}
	/**
	 * 判断是否名校模拟题
	 */
	public function isMingXiao($feature_id){
		if($feature_id==2){
			$data = array(array('type_name'=>'高考模拟','id'=>2),array('type_name'=>'月考试卷','id'=>3),array('type_name'=>'期中试卷','id'=>4),array('type_name'=>'期末试卷','id'=>5));
			
			return $data;
		}else{
			return false;
		}
	}
	/**
	 * 判断选择的课程是否数学并且选择的题目特点是否
	 * 历年高考真题或名校模拟题或原创
	 * 只有高中数学题目有分文理科
	 */
	public function isShuxue($course_id,$feature_id){
		$Model = M('tiku_course');
		$data_1 = $Model->where("id=$course_id")->find();
		
		$Model = M('tiku_feature');
		$data_2 = $Model->where("id=$feature_id")->find();
		
		if($data_1['course_name']=='数学' && $data_2['is_wenli']==1){
			return true;
		}else{
			return false;
		}
		
	}
	/**
	 * 获取子节点ID
	 */
	public function getAllChildrenPointId($parent_point_id){
		$Model = M('tiku_point');
		$child_data = $Model->where("parent_id=$parent_point_id")->select();
		if($child_data){//如果存在子节点
			foreach($child_data as $val){
				$GLOBALS['str'] .= ','.$val['id'];
				$this->getAllChildrenPointId($val['id']);
			}
			
		}
		return $this->parent_id.$GLOBALS['str'];
	}
	/**
	 * 格式化参数
	 */
	public function formatParams(){
		
	}
	public function selectCourse(){
		$this->display();
	}
	
}