<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>哈学库（精品试卷）</title>
<link href="/Public/css/public.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/home.css" rel="stylesheet" type="text/css" />
<script src="/Public/js/jquery.js" type="text/javascript"></script>
<script>
$(function(){
	//subnav
	$(".menu li").hover(function(){
		$(".subnav",this).css("display","block");
		$(this).addClass("hover");
	},function(){
		$(".subnav",this).css("display","none");
		$(this).removeClass("hover");
	});
	//
	
		//subnav
	$(".sj_ul li").hover(function(){
		$("dl",this).css("display","block");
		$(this).addClass("hover");
	},function(){
		$("dl",this).css("display","none");
		$(this).removeClass("hover");
	});
	//
	
})
function select_course(id){
	
}
</script>
</head>

<body>
<!--topbar-->
<div id="topbar">
    <div class="width">
        <div class="right">
        	<a href="">设为首页</a> |
            <a href="">收藏网站</a> |
            <a href="">登录</a> |
            <a href="">注册</a>
         </div> 
     </div>
</div>

<!--header-->
<div id="header">
	<div class="width">
    	<div class="left logo"><a href=""></a></div>
        <ul class="left menu">
        		<li class="mid">|</li>
            	<li><a href="/">首页</a></li>
                <li class="mid">|</li>
                <li><a href="">题库</a>
                <div class="subnav">
                	<?php if(is_array($course_data)): $i = 0; $__LIST__ = $course_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="/tiku/c<?php echo ($vo["id"]); ?>/" ><?php echo ($vo["course_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                </li>
                <li class="mid">|</li>
                <li><a href="">组卷</a></li>
                <li class="mid">|</li>
                <li><a href="">在线考试</a></li>
                <li class="mid">|</li>
                <li><a href="">在线练习</a></li>
               	<li class="mid">|</li>
                <li><a href="">产品</a></li>
                <li class="mid">|</li>
                <li><a href="">论坛</a></li>
         </ul>
    </div>
</div>
<script>
	/* 选择题型   **/
	function select_type(c,id){
	    var href = window.location.href;
	    var reg = /tiku\/(\w*)t(\d+)(\w*)(\/)/g;
		
	    if(href.search(reg)!=-1){
	    	if(id==0){
	    		var loc = href.replace(/t\d+/g,'');
	    	}else{
	        	var loc = href.replace(/t\d+/g,c+id);
	       }
	    }else{
	        var loc = href.replace(/tiku\/(\w*)(\/)/g,'tiku/$1'+c+id+'/');
	    }
	    window.location.href = loc;
	}
	/* 选择难度   **/
	function select_difficulty(c,id){
	    var href = window.location.href;
	    var reg = /tiku\/(\w*)d(\d+)(\w*)(\/)/g;
		
	    if(href.search(reg)!=-1){
	    	if(id==0){
	    		var loc = href.replace(/d\d+/g,'');
	    	}else{
	        	var loc = href.replace(/d\d+/g,c+id);
	       }
	    }else{
	        var loc = href.replace(/tiku\/(\w*)(\/)/g,'tiku/$1'+c+id+'/');
	    }
	    window.location.href = loc;
	}
	/* 选择题目特点 **/
	function select_feature(c,id){
	    var href = window.location.href;
	    var reg = /tiku\/(\w*)f(\d+)(\w*)(\/)/g;
		
	    if(href.search(reg)!=-1){
	    	if(id==0){
	    		var loc = href.replace(/f\d+/g,'');
	    	}else{
	        	var loc = href.replace(/f\d+/g,c+id);
	       }
	    }else{
	        var loc = href.replace(/tiku\/(\w*)(\/)/g,'tiku/$1'+c+id+'/');
	    }
	    window.location.href = loc;
	}
	/* 选择试卷类型 **/
	function select_feature_type(c,id){
	    var href = window.location.href;
	    var reg = /tiku\/(\w*)r(\d+)(\w*)(\/)/g;
		
	    if(href.search(reg)!=-1){
	    	if(id==0){
	    		var loc = href.replace(/r\d+/g,'');
	    	}else{
	        	var loc = href.replace(/r\d+/g,c+id);
	       }
	    }else{
	        var loc = href.replace(/tiku\/(\w*)(\/)/g,'tiku/$1'+c+id+'/');
	    }
	    window.location.href = loc;
	}
	/* 选择试卷类型 **/
	function select_wenli(c,id){
	    var href = window.location.href;
	    var reg = /tiku\/(\w*)w(\d+)(\w*)(\/)/g;
		
	    if(href.search(reg)!=-1){
	    	if(id==0){
	    		var loc = href.replace(/w\d+/g,'');
	    	}else{
	        	var loc = href.replace(/w\d+/g,c+id);
	       }
	    }else{
	        var loc = href.replace(/tiku\/(\w*)(\/)/g,'tiku/$1'+c+id+'/');
	    }
	    window.location.href = loc;
	}
	/* 选择试卷类型 **/
	function select_year(c,id){
	    var href = window.location.href;
	    var reg = /tiku\/(\w*)y(\d+)(\w*)(\/)/g;

	    if(href.search(reg)!=-1){
	    	if(id==0){
	    		var loc = href.replace(/y\d+/g,'');
	    	}else{
	        	var loc = href.replace(/y\d+/g,c+id);
	       }
	    }else{
	        var loc = href.replace(/tiku\/(\w*)(\/)/g,'tiku/$1'+c+id+'/');
	    }
	    window.location.href = loc;
	}
	/* 选择地区 **/
	function select_province(c,id){
	    var href = window.location.href;
	    var reg = /tiku\/(\w*)a(\d+)(\w*)(\/)/g;

	    if(href.search(reg)!=-1){
	    	if(id==0){
	    		var loc = href.replace(/a\d+/g,'');
	    	}else{
	        	var loc = href.replace(/a\d+/g,c+id);
	       }
	    }else{
	        var loc = href.replace(/tiku\/(\w*)(\/)/g,'tiku/$1'+c+id+'/');
	    }
	    window.location.href = loc;
	}
</script>
<!--main-->
<div class="width">
	<div class="tk_bg">
		<!--标题-->
        <div class="tit"><a href="">题库</a> 〉<a href="">精品试卷</a> </div>
        
        <!--小标-->
        <ul class="sj_ul">
        	<li style="width:194px;">&nbsp;&nbsp;&nbsp;&nbsp;科目：高中语文<div class="clear"></div>
                <dl class="sub_ul">
                      <dt><a href="">高中数学</a></dt>
                      <dt><a href="">高中数学</a></dt>
                </dl>
            </li>
            <li  class="hover"><a href="">知识点选题</a></li>
            <li><a href="">章节选题</a></li>
            <li><a href="">精品试卷</a></li>
            <li><a href="">我的题库</a></li>
        </ul>
        
        <div class="clear"></div>
        
        <div class="ss"><form><input type="button" class="btn"  value="搜索"/><input type="text" class="text" /></form></div>
        
        <!--快速搜索-->
        <div id="quick_goods" class="mt20">
            <ul>
                <li class="fixed"><strong>题型：</strong></li>
                <li>
                    <dl> 
                        <dt <?php if(($type_id) == ""): ?>class="hover"<?php endif; ?>><a href="javascript:select_type('t',0)">全部</a></dt>
                        <?php if(is_array($tiku_type)): $i = 0; $__LIST__ = $tiku_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dt  <?php if(($type_id) == $vo["id"]): ?>class="hover"<?php endif; ?>><a href="javascript:select_type('t',<?php echo ($vo["id"]); ?>)"><?php echo ($vo["type_name"]); ?></a></dt><?php endforeach; endif; else: echo "" ;endif; ?>
               		 </dl>
                </li>
            </ul>
            <div class="clear"></div>
                           
            <ul>
                <li class="fixed"><strong>难度：</strong></li>
                <li>
                    <dl>
                        <dt <?php if(($difficulty_id) == ""): ?>class="hover"<?php endif; ?>><a href="javascript:select_difficulty('d',0)">全部</a></dt>
                        <?php if(is_array($tiku_difficulty)): $i = 0; $__LIST__ = $tiku_difficulty;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dt <?php if(($difficulty_id) == $vo["id"]): ?>class="hover"<?php endif; ?>><a href="javascript:select_difficulty('d',<?php echo ($vo["id"]); ?>)"><?php echo ($vo["section"]); ?>(<?php echo ($vo["description"]); ?>)</a></dt><?php endforeach; endif; else: echo "" ;endif; ?>

                    </dl>
                </li>
            </ul>
            <div class="clear"></div>
            
            <ul>
                <li class="fixed"><strong>题目特点：</strong></li>
                <li>
                    <dl>                              
                        <dt <?php if(($feature_id) == ""): ?>class="hover"<?php endif; ?>><a href="javascript:select_feature('f',0)">全部</a></dt>
                        <?php if(is_array($tiku_feature)): $i = 0; $__LIST__ = $tiku_feature;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dt <?php if(($feature_id) == $vo["id"]): ?>class="hover"<?php endif; ?>><a href="javascript:select_feature('f',<?php echo ($vo["id"]); ?>)"><?php echo ($vo["feature_name"]); ?></a></dt><?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
            </ul>
            <div class="clear"></div>
            <?php if(!empty($year_data)): ?><ul>
                <li class="fixed"><strong>年份：</strong></li>
                <li>
                    <dl>
                        <dt <?php if(($year) == ""): ?>class="hover"<?php endif; ?>><a href="javascript:select_year('y',0)">全部</a></dt>
                        <?php if(is_array($year_data)): $i = 0; $__LIST__ = $year_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dt <?php if(($year) == $vo["year"]): ?>class="hover"<?php endif; ?>><a href="javascript:select_year('y',<?php echo ($vo["year"]); ?>)"><?php echo ($vo["year"]); ?>年</a></dt><?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
            </ul>
            <div class="clear"></div><?php endif; ?>  
            <?php if(!empty($tiku_feature_type)): ?><ul>
                <li class="fixed"><strong>试卷类型：</strong></li>
                <li>
                    <dl>
                        <dt <?php if(($feature_type_id) == ""): ?>class="hover"<?php endif; ?>><a href="javascript:select_feature_type('r',0)">全部</a></dt>
                        <?php if(is_array($tiku_feature_type)): $i = 0; $__LIST__ = $tiku_feature_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dt <?php if(($feature_type_id) == $vo["id"]): ?>class="hover"<?php endif; ?>><a href="javascript:select_feature_type('r',<?php echo ($vo["id"]); ?>)"><?php echo ($vo["type_name"]); ?></a></dt><?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
            </ul>
            <div class="clear"></div><?php endif; ?>                                                                              
            <?php if(!empty($province_data)): ?><ul>
                <li class="fixed"><strong>地区：</strong></li>
                <li>
                    <dl>
                        <dt <?php if(($province_id) == ""): ?>class="hover"<?php endif; ?>><a href="javascript:select_province('a',0)">全部</a></dt>
                        <?php if(is_array($province_data)): $i = 0; $__LIST__ = $province_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dt <?php if(($province_id) == $vo["id"]): ?>class="hover"<?php endif; ?>><a href="javascript:select_province('a',<?php echo ($vo["id"]); ?>)"><?php echo ($vo["province_name"]); ?></a></dt><?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
            </ul>
            <div class="clear"></div><?php endif; ?>
            <?php if(($wenli) == "1"): ?><ul>
                <li class="fixed"><strong>文理：</strong></li>
                <li>
                    <dl>
                        <dt <?php if(($wenli_id) == ""): ?>class="hover"<?php endif; ?>><a href="javascript:select_wenli('w',0)">全部</a></dt>
                        <dt<?php if(($wenli_id) == "1"): ?>class="hover"<?php endif; ?>><a href="javascript:select_wenli('w',1)">文数</a></dt>
                        <dt <?php if(($wenli_id) == "2"): ?>class="hover"<?php endif; ?>><a href="javascript:select_wenli('w',2)">理数</a></dt>
                        
                    </dl>
                </li>
            </ul>
            <div class="clear"></div><?php endif; ?> 
        </div>
        
    </div>
</div>


<div class="width">
	<div class="b_4">
    	<!--left-->
        <div class="tk_left mr10">
        	
			<h3>知识点</h3>
            <ul class="zsd_ul">
            	<li><a href="">基础知识及语言表达</a></li>
                <li><a href="">诗歌鉴赏</a></li>
                <li><a href="">文言文阅读</a></li>
                <li><a href="">现代文阅读</a></li>
                <li><a href="">作文及写作</a></li>
                <li><a href="">名句默写</a></li>
                <li><a href="">其他</a></li>
            </ul>
        </div>
        
        <!--right-->
        <div class="tk_right">
                <div class="mt10 b_4">
                   <div class="dx left mr10">
                   	<form>
                    	<input type="checkbox" />过滤使用过的题目
                        <input type="checkbox" />收藏的试题
                    </form>
                   </div>
                   
				   <div class="left">
                    <ul class="qs_ul">
                        <li><a href="">排序：</a></li>
                        <li><a href="">最新<img src="/Public/images/ico_down.gif" width="7" height="8"></a></li>
                        <li><a href="">难度<img src="/Public/images/ico_down.gif" width="7" height="8"></a></li>
                        <li><a href="">使用频率<img src="/Public/images/ico_down.gif" width="7" height="8"></a></li>
                        <li><a href="">好评<img src="/Public/images/ico_down.gif" width="7" height="8"></a></li>
                    </ul>
                    <div class="clear"></div>
        	     </div>
               </div>
               
               <div class="clear"></div>
               <ul class="tk_tm_ul">
               <?php if(is_array($tiku_data)): $i = 0; $__LIST__ = $tiku_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                	<p class="c_z"><b>来源：<?php echo ($vo["source_name"]); ?></b></p>
                    <p><?php echo (htmlspecialchars_decode($vo["content"])); ?></p>
                    
                     <div class="jcbtn1">纠错</div>
                            <div class="jc_list_b">
                                <div class="left mr10">
                                    <span class="jc_btn">加入试卷</span>
                                    <span class="jc_btn">查看解析</span>
                                    <span class="jc_btn">下载试题</span>
                                    <span class="jc_btn">收藏</span>
                                    <span class="jc_btn2">点赞</span>
                                    <span class="jc_btn2">分享</span>
                                </div>
                                
                                <div class="right mr10">
                                	<div class="left mr10">
                                        <span style="line-height:30px;">
                                            难道:<font class="c_z"><?php echo ($vo["section"]); ?></font>
                                        </span>
                                    </div>
                                	<div class="left">评分:</div>
                                    <div class="left"><i class="dis score score3"></i></div>
                               </div>
                           </div>
                           
               </li><?php endforeach; endif; else: echo "" ;endif; ?>
               
               </ul>
        </div>
    
    </div>
</div>


<!--footer-->
<div id="footer">
	<div class="footer">
    	<div class="left"><a href="">关于我们</a> 丨 <a href="">隐私保护政策</a>  丨  <a href="">服务条款</a> 丨 <a href="">联系我们</a>   丨  
        <br />
        COPYRIGHT 2015  哈学库  版权所有   www.haxueku.com</div>
        <div class="right"></div>
    </div>
</div>

</body>
</html>