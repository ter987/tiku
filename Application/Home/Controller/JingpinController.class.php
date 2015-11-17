<?php
namespace Home\Controller;
use Home\Controller\GlobalController;
class JingpinController extends GlobalController {
	/**
	 * 初始化
	 */
	function _initialize()
	{
		parent::_initialize();
		$course_data = parent::getCourse();
		$this->assign('course_data',$course_data);
	}
	
    public function index(){
    	if(!isset($_SESSION['course_id'])){
    		//404跳转
    	}
		$this->assign('course_id',$_SESSION['course_id']);
    	$params = I('get.param');
		$result1 = preg_split("/[0-9]/", $params,0,PREG_SPLIT_NO_EMPTY);
		$result2 = preg_split("/[a-z]/", $params,0,PREG_SPLIT_NO_EMPTY );
		$new_params = array_combine($result1, $result2);
		
		$feature_id = $new_params['f'];
		$grade = $new_params['g'];//年级
		$year = $new_params['y'];//年份
		$province_id = $new_params['a'];//省份
		
		$this->assign('feature_id',$feature_id);
		$this->assign('year',$year);
		$this->assign('province_id',$province_id);
		$this->assign('grade',$grade);
		//var_dump($feature_id);exit;

		//获取题库特点,参数1表示高中
		//$tiku_feature = $this->getTikuFeature(1);
		$this->assign('tiku_feature',$tiku_feature);

		$where = "tiku_source.course_id=$course_id ";
		$join ="tiku_source on tiku_source.id=tiku.source_id";
		if($type_id){
			$where .= " && tiku.type_id=$type_id ";
		}
		if($difficulty_id){
			$where .= " && tiku.difficulty_id=$difficulty_id ";
		}
		if($feature_type_id){
			$where .= " && tiku_source.source_type_id=$feature_type_id";
		}elseif($feature_id){
			$where .= " && tiku_source.source_type_id=$feature_id";
		}
		if($province_id){
			$where .= " && tiku_source.province_id=$province_id";
		}
		if($wenli_id){
			$where .= " && tiku_source.wen_li=$wenli_id";
		}
		if($point_id){
			$_points = $this->getAllChildrenPointId($point_id);
			$join2= "tiku_to_point ON tiku_to_point.`tiku_id`=tiku.`id`";
			$where .= " && tiku_to_point.point_id IN ($_points)";
		}
		//echo $join;exit;
		$Model = M('tiku');
		//获取年份数据 地区数据
		if($feature_id){
			$year_data = S('tiku_year_'.$where);
			if(!$year_data){
				$year_data = $Model->field("distinct tiku_source.year")->join($join)->join($join2)->where($where)->order("tiku_source.year desc")->select();
				S('tiku_year_'.$where,$year_data,array('type'=>'file','expire'=>FILE_CACHE_TIME));
			}
			
			$this->assign('year_data',$year_data);
			
			$province_data = S('province_data_'.$where);
			if(!$province_data){
				$province_data = $Model->field("distinct province.id,province.province_name")->join($join)->join($join2)->join("province on tiku_source.province_id=province.id")->where($where)->order("tiku_source.year desc")->select();
				//var_dump($province_data);exit;
				S('province_data_'.$where,$province_data,array('type'=>'file','expire'=>FILE_CACHE_TIME));
			}
			
			$this->assign('province_data',$province_data);
		}
		//获取题库数据
		//$result = $Model->field("COUNT(DISTINCT tiku.id) AS tp_count")->join($join)->join($join2)->where($where)->find();
		$count = $result['tp_count'];
		//echo $count;
		//echo $Model->getLastSql();exit;
		$Page = new \Think\Page($count,10);
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$Page->setConfig('first','首页');
		$Page->setConfig('last','末页');
		$page_show = $Page->_show($params);
		$this->assign('page_show',$page_show);
		
		//var_dump($tiku_data);
		$this->assign('tiku_data',$tiku_data);
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
		$this->assign('tiku_data',$data);
		$this->display();
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
	
	
}