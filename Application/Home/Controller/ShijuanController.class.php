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
    	$shijuan_type = !empty($_SESSION['shijuan']['shijuan_banshi'])?$_SESSION['shijuan']['shijuan_banshi']:1;//默认的试卷类型：随堂练习
    	$shijuantypeModel = M('shijuan_banshi');
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
				if(empty($new_arr[$k]['childs'])) $new_arr[$k]['childs']=array();
				if($v==$val['type_name']){
					$new_arr[$k]['type_name'] = $val['type_name'];
					$new_arr[$k]['childs'] = array_merge($new_arr[$k]['childs'],array($val['id']));
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
		foreach($data as $key=>$val){
			$oc = array(1=>'一',2=>'二');
			$_SESSION['shijuan'][$key]['t_title'] = '';//第N卷标题
			if($key==1){
				$_SESSION['shijuan'][$key]['t_title'] = '第I卷（选择题）';//第1卷标题
			}else{
				$_SESSION['shijuan'][$key]['t_title'] = '第II卷（非选择题）';//第2卷标题
			}
			$_SESSION['shijuan'][$key]['note'] = '';//第N卷注释
			
			$count = 0;
			$shiti_count_per_juan = 0;
			foreach($val as $k=>$v){
				$count ++;
				$shiti_count = count($v['childs']);
				$_SESSION['shijuan'][$key]['shiti'][$count]['t_title'] = $v['type_name'].'(共'.$shiti_count.'小题)';
				$_SESSION['shijuan'][$key]['shiti'][$count]['childs'] = $v['childs'];
				$shiti_count_per_juan += $shiti_count;
			}
			$_SESSION['shijuan'][$key]['note'] = '本试卷第'.$oc[$key].'部分共有'.$shiti_count_per_juan.'道试题。';//第N卷注释
		}
		$oa = array(1=>'一',2=>'二',3=>'三',4=>'四',5=>'五',6=>'六',7=>'七');
		$last = 0;
		$o = 1;
		if($_SESSION['shijuan'][1]){
			$first_juan['t_title'] = $_SESSION['shijuan'][1]['t_title'];
			$first_juan['note'] = $_SESSION['shijuan'][1]['note'];
			foreach($_SESSION['shijuan'][1]['shiti'] as $k=>$v){
				$first_juan['shiti'][$k]['t_title'] = $v['t_title'];
				$first_juan['shiti'][$k]['childs'] = $this->_getTikuInfo($v['childs'],$o);
				$first_juan['shiti'][$k]['order_char']  = $oa[$k];
				$last = $k;
				
			}
		}
		if($_SESSION['shijuan'][2]){
			$second_juan['t_title'] = $_SESSION['shijuan'][2]['t_title'];
			$second_juan['note'] = $_SESSION['shijuan'][2]['note'];
			foreach($_SESSION['shijuan'][2]['shiti'] as $k=>$v){
				$second_juan['shiti'][$k]['t_title'] = $v['t_title'];
				$second_juan['shiti'][$k]['childs'] = $this->_getTikuInfo($v['childs'],$o);
				$second_juan['shiti'][$k]['order_char'] = $oa[$k+$last];
			}
		}
		//var_dump($second_juan);
		$shijuan['title'] = $_SESSION['shijuan']['title'];
		$this->assign('first_juan',$first_juan);
		$this->assign('second_juan',$second_juan);
		$this->assign('shijuan',$shijuan);
        $this->display();
	}
	/**
	 * 生成word文件
	 */
	public function createToWord(){
		Vendor("PHPWord.PHPWord");
		// Create a new PHPWord Object
		$PHPWord = new \Vendor\PHPWord\PHPWord();
		
		// Every element you want to append to the word document is placed in a section. So you need a section:
		$section = $PHPWord->createSection();
		
		// After creating a section, you can append elements:
		$section->addText('Hello world!');
		
		// You can directly style your text by giving the addText function an array:
		$section->addText('Hello world! I am formatted.', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));
		$section->addPageBreak();
		// If you often need the same style again you can create a user defined style to the word document
		// and give the addText function the name of the style:
		$PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
		$section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');
		
		// You can also putthe appended element to local object an call functions like this:
		// $myTextElement = $section->addText('Hello World!');
		// $myTextElement->setBold();
		// $myTextElement->setName('Verdana');
		// $myTextElement->setSize(22);
		
		// At least write the document to webspace:
		//$PHPWord_IOFactory = new \Vendor\PHPWord\PHPWord_IOFactory();
		$objWriter = \Vendor\PHPWord\PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save('helloWorld.docx');
	}
	protected function _getTikuInfo($id_arr,&$o){
		$Model = M('tiku');
		foreach($id_arr as $key=>$val){
			$rs = $Model->field("id,content,answer,analysis")->where("id=$val")->find();
			$rs['order_char'] = $o;
			$tiku[] = $rs;
			$o++;
		}
		return $tiku;
	}
	public function deleteShijuan(){
		unset($_SESSION['shijuan']);
	}
	
}