<?php
namespace Admin\Controller;
use Admin\Controller\GlobalController;
class TikuController extends GlobalController {
	var $parent_id;
	/**
	 * 初始化
	 */
	function _initialize()
	{
		$course_data = parent::getCourse();
		$this->assign('course_data',$course_data);
	}
	
    public function index(){
    	
        $this->display();
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
		$Model = M('tiku_feature');
		$data = $Model->where("id=$feature_id")->find();
		if(trim($data['feature_name'])=='名校模拟题'){
			$Model = M('tiku_feature_type');
			$data = $Model->where("feature_id=$feature_id")->select();
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
			}
			$this->getAllChildrenPointId($val['id']);
		}else{
			return false;
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