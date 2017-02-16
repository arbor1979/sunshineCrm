<?php
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/


require_once( "lib.inc.php" );
$GLOBAL_SESSION = returnsession( );
$file_ini = parse_ini_file( "../Interface/Framework/system_config.ini" );
$BANNER_TEXT = $file_ini['CompanyName'];
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $IE_TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<script language="JavaScript">
<!--  将当前窗口缩小为0  -->
self.moveTo(0,0);
<!--  将当前窗口设置为屏幕大小  -->
self.resizeTo(screen.availWidth,screen.availHeight);
<!--   -->
self.focus();   

// 状态栏显示文字
window.defaultStatus="<?php echo $IE_TITLE?>"; 
</script>
</head>

<frameset rows="51,27,*,20" cols="*" frameborder="NO" border="0" framespacing="0" id="frame1">    <!-- 上下方式分割为3块 -->
  <frame src="index_top.php" name="topFrame" scrolling="NO" noresize >                         <!--//顶部页面  -->
  <frame src="index_head.php" name="headFrame" scrolling="NO" noresize >                         <!--//顶部下页面  -->
  <frameset rows="*" cols="7,190,5,9,*,0" framespacing="0" frameborder="NO" border="0" id="frame2"><!--//中部再分为几块,左右方式分割 -->
        <frame src="menu_leftbar.php" name="menu_leftbar" scrolling="NO" noresize>                 <!--  //菜单左边条 -->
	<frame src="function_panel_index.php" name="function_panel_index" scrolling="NO" noresize>   <!--//左边的菜单页 -->
        <frame src="menu_rightbar.php" name="menu_rightbar" scrolling="NO" noresize>  <!-- //菜单右边条 -->
	<frame src="controlmenu.php" name="controlmenu" scrolling="no" frameborder="0" noresize>   <!--//中间页，控制左边菜单的显隐 --> 
	<frame src="table_index.php" name="table_index"  scrolling="no" frameborder="0" noresize>   <!--//右边的内容页面，显示菜单点击页面 -->
	 <frame src="table_right.php" name="table_right" scrolling="no" frameborder="0" noresize>  <!-- //右边条 -->        
  </frameset>
  
  <frame src="status_bar.php" name="status_bar" scrolling="NO" noresize >                      <!--//底部的状态页面 -->
</frameset>

<noframes>您的浏览器不支持框架页面，请使用IE6.0以上的浏览器！</noframes>

</html>
