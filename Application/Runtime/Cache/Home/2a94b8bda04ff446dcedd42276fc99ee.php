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


<!--main-->
	<div class="index_banner">
		<div class="bd">
			<ul>
				<li style="background:url(/Public/images/index_bg.gif) #CCE1F3 center 0 no-repeat;"><a target="_blank" href="#"></a></li>
				<li style="background:url(/Public/images/index_bg.gif) #BCE0FF center 0 no-repeat;"><a target="_blank" href="#"></a></li>
				<li style="background:url(/Public/images/3.jpg) #C4CFEB center 0 no-repeat;"><a target="_blank" href="#"></a></li>
				<li style="background:url(/Public/images/4.jpg) #C5EDFD center 0 no-repeat;"><a target="_blank" href="#"></a></li>
			</ul>
		</div>
		<div class="hd"><ul></ul></div>
        
        <div class="width">
            <!--第一屏-->
            <div class="login">
                <div class="login_wz">
                <form>
                    <input type="text" class="ip" size="40" value="账号：" onfocus="if(this.value==defaultValue)this.value=''" onblur="if(this.value=='')this.value=defaultValue"/><br />
                    <input type="text" class="ip" size="40" value="密码：" onfocus="if(this.value==defaultValue)this.value=''" onblur="if(this.value=='')this.value=defaultValue"/><br />
                    <input type="checkbox" />下次自动登录
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="">忘记密码</a><br />
                    <input type="submit" class="btn" value="登录" size="40"/><br />
                    <input type="submit" class="btn" value="注册" size="40"/><br />
                    
                </form>
                </div>
            </div>
         </div>
        
	</div>

	<script type="text/javascript">
		jQuery(".index_banner").slide({ titCell:".hd ul", mainCell:".bd ul", effect:"fade",  autoPlay:true, autoPage:true, trigger:"click" });
	</script>


<div class="width">
    
    <!--第二屏-->
    <div class="mt20">
    	<div class="w440 left">
        	<div class="subject"><span><a href=""></a></span>高中试卷汇总<i>Self Q&A </i> </div>
            
         <div class="notice" style="margin:0 auto">
		<div class="tab-hd">
				<ul class="tab-nav">
				  <li><a href="#" target="_blank">语文 </a></li>
				  <li><a href="#" target="_blank">数学</a></li>
				  <li><a href="#" target="_blank">英语</a></li>
				  <li><a href="#" target="_blank">化学</a></li>
				  <li><a href="#" target="_blank">物理</a></li>
                  <li><a href="#" target="_blank">生物</a></li>
                  <li><a href="#" target="_blank">物理</a></li>
                  <li><a href="#" target="_blank">历史</a></li>
                  <li><a href="#" target="_blank">地理</a></li>
                  <li><a href="#" target="_blank">政治</a></li>
				</ul>
		</div>
		<div class="tab-bd">
			<div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
			
            <div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真5454题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
            
			<div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真545题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
            

			<div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真343题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>

			<div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真333题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
            
            <div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真111题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
            
            <div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真2222题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
		</div>
	</div>
          <script type="text/javascript">jQuery(".notice").slide({ titCell:".tab-hd li", mainCell:".tab-bd",delayTime:0 });</script>                  
        </div>
        
        <div class="w500 left">

        	<div class="subject"><span><a href=""></a></span>初中试卷汇总<i>Self Q&A </i> </div>
            
         <div class="notice" style="margin:0 auto">
		<div class="tab-hd">
				<ul class="tab-nav">
				  <li><a href="#" target="_blank">语文 </a></li>
				  <li><a href="#" target="_blank">数学</a></li>
				  <li><a href="#" target="_blank">英语</a></li>
				  <li><a href="#" target="_blank">化学</a></li>
				  <li><a href="#" target="_blank">物理</a></li>
                  <li><a href="#" target="_blank">生物</a></li>
                  <li><a href="#" target="_blank">物理</a></li>
                  <li><a href="#" target="_blank">历史</a></li>
                  <li><a href="#" target="_blank">地理</a></li>
                  <li><a href="#" target="_blank">政治</a></li>
				</ul>
		</div>
		<div class="tab-bd">
			<div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
			
            <div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真5454题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
            
			<div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真545题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
            

			<div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真343题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>

			<div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真333题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
            
            <div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真111题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
            
            <div class="tab-pal">
					<ul>
						<li><span>2015-07-22</span><a href="#">·[真2222题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
						<li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
                        <li><span>2015-07-22</span><a href="#">·[真题]2015年高考上海市语文（带分析）</a></li>
					</ul>
			</div>
		</div>
	</div>
          <script type="text/javascript">jQuery(".notice").slide({ titCell:".tab-hd li", mainCell:".tab-bd",delayTime:0 });</script>
            
        </div>
    </div>
    
</div>

<div class="width">
	<div class="mt20">
    <div class="subject"><span><a href=""></a></span>最新资讯<i>Self Q&A </i> </div>
    <ul class="n_news">
    	<li> <div class="pic"><a href=""><img src="images/add.gif" /></a></div>
        	<div class="text">
            	<div class="tt"><a href="">让历史说话   用史实发言</a></div>
            	<div class="inf">初中女生休学一年写23万字谍战小说</div>
            </div>
        </li>
        
        <li> <div class="pic"><a href=""><img src="images/add.gif" /></a></div>
        	<div class="text">
            	<div class="tt"><a href="">让历史说话   用史实发言</a></div>
            	<div class="inf">初中女生休学一年写23万字谍战小说</div>
            </div>
        </li>
        
         <li> <div class="pic"><a href=""><img src="images/add.gif" /></a></div>
        	<div class="text">
            	<div class="tt"><a href="">让历史说话   用史实发言</a></div>
            	<div class="inf">初中女生休学一年写23万字谍战小说</div>
            </div>
        </li>
        
         <li> <div class="pic"><a href=""><img src="/Public/images/add.gif" /></a></div>
        	<div class="text">
            	<div class="tt"><a href="">让历史说话   用史实发言</a></div>
            	<div class="inf">初中女生休学一年写23万字谍战小说</div>
            </div>
        </li>
        
         <li> <div class="pic"><a href=""><img src="images/add.gif" /></a></div>
        	<div class="text">
            	<div class="tt"><a href="">让历史说话   用史实发言</a></div>
            	<div class="inf">初中女生休学一年写23万字谍战小说</div>
            </div>
        </li>
        
         <li> <div class="pic"><a href=""><img src="images/add.gif" /></a></div>
        	<div class="text">
            	<div class="tt"><a href="">让历史说话   用史实发言</a></div>
            	<div class="inf">初中女生休学一年写23万字谍战小说</div>
            </div>
        </li>
     </ul>
        
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