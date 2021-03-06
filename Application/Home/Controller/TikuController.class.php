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
		parent::_initialize();
		$course_data = parent::getCourse();
		$this->assign('course_data',$course_data);
		$tiku_cart = $this->_getTikuCart();
		$this->assign('tiku_cart',$tiku_cart);
		$this->assign('tikus_in_cart',json_encode($_SESSION['cart']));
	}
	
    public function index(){
    	$params = I('get.param');
		$result1 = preg_split("/[0-9]/", $params,0,PREG_SPLIT_NO_EMPTY);
		$result2 = preg_split("/[a-z]/", $params,0,PREG_SPLIT_NO_EMPTY );
		$new_params = array_combine($result1, $result2);
		
    	$course_id = $new_params['c'];
		$feature_id = $new_params['f'];//试卷类型ID
		$difficulty_id = $new_params['d'];
		$type_id = $new_params['t'];//题型id
		$point_id = $new_params['p'];//知识点ID
		$wenli_id = $new_params['w'];//知识点ID
		$year = $new_params['y'];//年份
		$province_id = $new_params['a'];//省份
		$this->parent_id = $point_id;
		
		$this->assign('type_id',$type_id);
		$this->assign('difficulty_id',$difficulty_id);
		$this->assign('feature_id',$feature_id);//试卷类型
		$this->assign('wenli_id',$wenli_id);
		$this->assign('year',$year);
		$this->assign('point_id',$point_id);
		$this->assign('province_id',$province_id);
		//var_dump($feature_id);exit;

		if(!$course_id){//错误跳转
			
		}
    	//获取题库类型
    	$_SESSION['course_id'] = $course_id;
		$this->assign('course_id',$course_id);
    	$tiku_type = $this->getTikuType($course_id);
		$this->assign('tiku_type',$tiku_type);
		//获取题库难度系数
		$tiku_difficulty = $this->getTikuDifficulty();
		$this->assign('tiku_difficulty',$tiku_difficulty);
		//获取科目类型，高中或初中
		$course_type = $this->getCourseType($course_id);
		//获取试卷类型
		$source_type = $this->getSourceType($course_type);
		$this->assign('source_type',$source_type);
		//获取知识点
		$points = $this->getPointsByCourseId($course_id);
		$this->assign('points',$points);
		
		$where = "tiku_source.course_id=$course_id ";
		$join ="tiku_source on tiku_source.id=tiku.source_id";
		if($type_id){
			$where .= " && tiku.type_id=$type_id ";
		}
		if($difficulty_id){
			$where .= " && tiku.difficulty_id=$difficulty_id ";
		}
		if($feature_id){
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
		//获取题库数据
		$result = $Model->field("COUNT(DISTINCT tiku.id) AS tp_count")->join($join)->join($join2)->where($where)->find();
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
		$tiku_data = $Model->field("DISTINCT tiku.`id`,tiku.options,tiku.`content`,tiku.`clicks`,tiku_source.`source_name`,tiku_difficulty.section")
		->join($join)
		->join($join2)
		->join("tiku_difficulty on tiku.difficulty_id=tiku_difficulty.id")->where($where)->limit($Page->firstRow.','.$Page->listRows)->order("tiku.id ASC")->select();
		//echo $Model->getLastSql();
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
		//获取推荐试题
		$recommend = $this->_getRecommendTiku($data['course_id']);
		
		$this->assign('recommend',$recommend);
		$this->assign('tiku_data',$data);
		$this->display();
	}
	public function _getTikuCart(){
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
	 * 获取试卷类型
	 * 历年高考真题、名校模拟题。。。
	 */
	public function getSourceType($course_type){
		$data = S('source_type');
		if(!$data){
			$Model = M('source_type');
			$data = $Model->where("course_type=$course_type")->select();
			S('source_type',$data,array('type'=>'file','expire'=>FILE_CACHE_TIME));
		}
		return $data;
	}
	public function getCourseType($course_id){
		$course_type = S('course_type');
		if(!$data){
			$Model = M('tiku_course');
			$data = $Model->field('course_type')->where("id=$course_id")->find();
			$course_type = $data['course_type'];
			S('course_type',$course_type,array('type'=>'file','expire'=>FILE_CACHE_TIME));
		}
		return $course_type;
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