<?php
namespace Home\Controller;
use Home\Controller\GlobalController;
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
    	$params = I('get.param');
		$result1 = preg_split("/[0-9]/", $params,0,PREG_SPLIT_NO_EMPTY);
		$result2 = preg_split("/[a-z]/", $params,0,PREG_SPLIT_NO_EMPTY );
		$new_params = array_combine($result1, $result2);
		
    	$course_id = $new_params['c'];
		$feature_id = $new_params['f'];
		$difficulty_id = $new_params['d'];
		$feature_type_id = $new_params['r'];//试卷类型ID
		$type_id = $new_params['t'];//题型id
		$point_id = $new_params['p'];//知识点ID
		$wenli_id = $new_params['w'];//知识点ID
		$year = $new_params['y'];//年份
		$province_id = $new_params['a'];//年份
		$this->parent_id = $point_id;
		
		$this->assign('type_id',$type_id);
		$this->assign('difficulty_id',$difficulty_id);
		$this->assign('feature_id',$feature_id);
		$this->assign('feature_type_id',$feature_type_id);
		$this->assign('wenli_id',$wenli_id);
		$this->assign('year',$year);
		$this->assign('province_id',$province_id);
		//var_dump($feature_id);exit;

		if(!$course_id){//错误跳转
			
		}
		if($feature_id){
			$result = $this->isShuxue($course_id, $feature_id);
			$this->assign('wenli',$result);
			if($tiku_feature_type = $this->isMingXiao($feature_id)){//如果是名校模拟题，获取试卷类型（feature_type）
				$this->assign('tiku_feature_type',$tiku_feature_type);
			}
		}
    	//获取题库类型
    	$tiku_type = $this->getTikuType($course_id);
		$this->assign('tiku_type',$tiku_type);
		//获取题库难度系数
		$tiku_difficulty = $this->getTikuDifficulty();
		$this->assign('tiku_difficulty',$tiku_difficulty);
		//获取题库特点,参数1表示高中
		$tiku_feature = $this->getTikuFeature(1);
		$this->assign('tiku_feature',$tiku_feature);
		
		$where = "tiku.course_id=$course_id ";
		if($type_id){
			$where .= " && tiku.type_id=$type_id ";
		}
		if($difficulty_id){
			$where .= " && tiku.difficulty_id=$difficulty_id ";
		}
		if($feature_id){
			$where .= " && tiku.feature_id=$feature_id";
		}
		if($wenli_id){
			$where .= " && tiku.wenli_id=wenli_id";
		}
		if($point_id){
			$child_ids = $this->getAllChildrenPointId($point_id);
			$join .= "tiku_to_point ON tiku_to_point.`tiku_id`=tiku.`id`";
			$where .= " && tiku_to_point.point_id IN ($child_ids)";
		}
		$Model = M('tiku');
		//获取年份数据 地区数据
		if($feature_id){
			$year_data = S('tiku_year_'.$where);
			if(!$year_data){
				$year_data = $Model->field("distinct tiku_source.year")->join("tiku_source on tiku.source_id=tiku_source.id ")->join($join)->where($where)->order("tiku_source.year desc")->select();
				S('tiku_year_'.$where,$year_data,array('type'=>'file','expire'=>FILE_CACHE_TIME));
			}
			
			$this->assign('year_data',$year_data);
			
			$province_data = S('province_data_'.$where);
			if(!$province_data){
				$province_data = $Model->field("distinct province.id,province.province_name")->join("tiku_source on tiku.source_id=tiku_source.id")->join("province on tiku_source.province_id=province.id")->join($join)->where($where)->order("tiku_source.year desc")->select();
				//var_dump($province_data);exit;
				S('province_data_'.$where,$province_data,array('type'=>'file','expire'=>FILE_CACHE_TIME));
			}
			
			$this->assign('province_data',$province_data);
		}
		//获取题库数据
		$result = $Model->field("COUNT(DISTINCT tiku.id) AS tp_count")->join($join)->where($where)->find();
		$count = $result['tp_count'];
		$Page = new \Think\Page($count,20);
		$page_show = $Page->show();
		$this->assign('page_show',$page_show);
		$tiku_data = $Model->field("DISTINCT tiku.`id`,tiku.`content`,tiku.`clicks`,tiku_source.`source_name`,tiku_difficulty.section")
		->join($join)->join("tiku_source on tiku.`source_id`=tiku_source.id")
		->join("tiku_difficulty on tiku.difficulty_id=tiku_difficulty.id")->where($where)->limit($page->firstRow.','.$Page->listRows)->select();
		//echo $Model->getLastSql();
		//var_dump($tiku_data);
		$this->assign('tiku_data',$tiku_data);
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