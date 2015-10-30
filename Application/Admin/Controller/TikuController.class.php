<?php
namespace Admin\Controller;
use Admin\Controller\GlobalController;
class TikuController extends GlobalController {
	var $parent_id;
	var $points ;
	/**
	 * 初始化
	 */
	function _initialize()
	{
		$course_data = parent::getCourse();
		$this->getAllTypes();
		$this->assign('course_data',$course_data);
	}
	
    public function index(){
    	
		$course_id = $_REQUEST['course_id'];
		$type_id = $_REQUEST['type_id'];;//题型id
		$source_name = $_REQUEST['source_name'];
		$content = $_REQUEST['content'];
		$status = $_REQUEST['status'];
		
		$this->assign('course_id',$course_id);
		$this->assign('type_id',$type_id);
		$this->assign('source_name',$source_name);
		$this->assign('content',$content);
		$this->assign('status',$status);
		$where = '1=1';
		if($course_id){
			$where = "tiku.course_id=$course_id ";
		}
		if($type_id){
			$where .= " && tiku.type_id=$type_id ";
		}
		if($status){
			$where .= " && tiku.status=$status ";
		}
		if($content){
			$where .= " && tiku.content like '%".$content."%'";
		}
		if($source_name){
			$where .= " && tiku_source.source_name like '%".$source_name."%'";
		}
			
	
		//获取题库数据
		$Model = M('tiku');
		$count = $Model->join("tiku_source on tiku.source_id = tiku_source.id")->where($where)->count();
		//echo $Model->getLastSql();exit;
		$Page = new \Think\Page($count,5);
		$Page->parameter['course_id'] = $course_id;
		$Page->parameter['type_id'] = $type_id;
		$Page->parameter['content'] = $content;
		$Page->parameter['source_name'] = $source_name;
		$Page->setConfig('first','第一页');
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$page_show = $Page->show();
		$this->assign('page_show',$page_show);
		$tiku_data = $Model->field(" tiku.`id`,tiku.`content`,tiku.`clicks`,tiku.`status`,tiku.`create_time`,tiku_source.`source_name`")
		->join("tiku_source on tiku.`source_id`=tiku_source.id")
		->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		//var_dump($tiku_data);
		$this->assign('tiku_data',$tiku_data);
		$this->display();
		
        
	}
	public function edit(){
		if($_POST){
			var_dump($_POST);
		}else{
			$tiku_id = $_GET['id'];
			$Model = M('tiku');
			$tiku_data = $Model->field(" tiku.`id`,tiku.`content`,tiku.`course_id`,tiku.`clicks`,tiku.`status`,tiku.`answer`,tiku.`analysis`,tiku.`create_time`,tiku_source.`source_name`")
			->join("tiku_source on tiku.`source_id`=tiku_source.id")
			->where("tiku.id=$tiku_id")->find();
			//var_dump($tiku_data['course_id']);exit;
			$point_html = $this->getAllChildrenPointId(0,$tiku_data['course_id']);
			$this->assign('point_html',$point_html);
			$this->assign('tiku_data',$tiku_data);
		}
		$difficulty_data = $this->getTikuDifficulty();
		$this->assign('difficulty_data',$difficulty_data);
		
		$this->display();
	}
	/**
	 * 获取题型
	 * 单选题、多选题。。。
	 */
	public function getTikuType(){
		$course_id = $_GET['course_id'];
		$Model = M('tiku_type');
		if($course_id==0){
			$data = $Model->field("tiku_type.`type_name`,tiku_type.`id`")->select();
		}else{
			$data = $Model->field("tiku_type.`type_name`,tiku_type.`id`")->join("course_to_type on tiku_type.id=course_to_type.type_id")->where("course_to_type.course_id=$course_id")->select();
		}

		$this->ajaxReturn($data);
	}
	/**
	 * 获取所有题型
	 */
	public function getAllTypes(){
		$Model = M('tiku_type');
		$data = $Model->select();
		$this->assign('tiku_type',$data);
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
	 * 获取子节点ID
	 */
	public function getAllChildrenPointId($parent_point_id,$course_id){
		$Model = M('tiku_point');
		$child_data = $Model->where("parent_id=$parent_point_id AND course_id=$course_id")->select();
		if($child_data){//如果存在子节点
			foreach($child_data as $val){
				$GLOBALS['str'] .= '<option value="'.$val['id'].'">'.$val['point_name'].'</option>';
				$this->getAllChildrenPointId($val['id'],$course_id);
				
			}
			
		}else{
			return false;
		}
		return $GLOBALS['str'];
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