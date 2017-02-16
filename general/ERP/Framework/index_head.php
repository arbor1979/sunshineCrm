<?php


function index_head( )
{
				global $smarty;
				global $LOGIN_THEME;
				global $IE_TITLE;
				global $_SESSION;
				global $db;
				global $_SESSION;
				global $SUNSHINE_USER_UNIT_ID;
				
				
}

require_once( "lib.inc.php" );
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );

$SUNSHINE_USER_UNIT_ID = $_SESSION['SUNSHINE_USER_UNIT_ID'];
$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";

$USER_ID = $_SESSION['LOGIN_UID'];
$sql = "select FUNC_ID_STR from user where UID='".$USER_ID."'";
$rs = $db->cacheexecute( 15, $sql );
$FUNC_ID_STR_SYS = $rs->fields['FUNC_ID_STR'];
if(strlen($FUNC_ID_STR_SYS)>2 && substr($FUNC_ID_STR_SYS,-1)==",")
{
	$FUNC_ID_STR_SYS=substr($FUNC_ID_STR_SYS,0,-1);
}
if($FUNC_ID_STR_SYS==""){
   $MENU_LIST = array();
   $USER_NAME = $_SESSION['LOGIN_USER_NAME'];
   $PRIV_NAME = " [".$_SESSION['SUNSHINE_USER_PRIV_NAME']."--未分配权限"."]";
   $lang = $_SESSION['SUNSHINE_USER_LANG'];
}else{
$sql = "select * from sys_menu where MENU_ID in (select distinct left(MENU_ID,2) from sys_function where FUNC_ID in ($FUNC_ID_STR_SYS)) order by MENU_ID";
				$rs_menu = $db->execute( $sql );
				$MENU_LIST = $rs_menu->getarray( );
				$USER_NAME = $_SESSION['LOGIN_USER_NAME'];
				$PRIV_NAME = " [".$_SESSION['SUNSHINE_USER_PRIV_NAME']."]";
				$lang = $_SESSION['SUNSHINE_USER_LANG'];
}
?>
<html>
<head>
<title>菜单左边条</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="stylesheet" type="text/css" href="../theme/3/images/style.css">
<SCRIPT type=text/javascript src="../Enginee/jquery/jquery.js"></SCRIPT>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-size:12px;
}
#welcome {
		float: left;
		width: 210px;
		padding-left:8px; 
		font-size: 12px;
		text-align: center;
		height:27px;
		line-height:27px;
		background:#D8F9FF;
	}
	#welcome span {
		color:#E94200;
		font-weight:bold;
	}
#ico1 {
	width: 50px;
	float: right;
	display: inline;
}
	#ico1 a {
		display: block;
		float: left;
		height: 20px;
		width: 20px;
		margin: 2px 2px 0 2px;
		padding: 1px;
	}
	
	#ico1 a:hover,#ico1 a:active {
		border-top: 1px solid #97CCD4;
		border-left:1px solid #97CCD4;
		border-bottom: 1px solid #F7FEFF;
		border-right: 1px solid #F7FEFF;
		background: #CFF7FE;
	}
-->

</style>

<script language="JavaScript">

// 显示服务器的当前时间

function timeview()
{
  
  timestr=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());
  time_area.innerHTML = timestr;
  //OA_TIME.setSeconds(OA_TIME.getSeconds()+1);
  window.setTimeout( "timeview()", 1000 );
}

// 跳转菜单部分
function GoMenu(ID)
{
  //parent.parent.function_panel_index.menu_main.location="menu.php?FF=DD&MENU_ID="+ID+"";
  parent.parent.function_panel_index.menu_main.location="menu.php?FF=DD&MENU_ID="+ID+"";
	var url = "../Interface/JXC/flowgraph.php?LOGIN_USER_ID=<?php echo $USER_NAME?>&flowid=";
	
	/*
	switch (ID) {
		case '65':url += "2";
			break;
		case '66':url += "4";
			break;
		case '67':url += "3";
			break;
		case '70':url += "5";
			break;
		case '75':url += "6";
			break;
		case '71':url += "8";
			break;
		case '80':url += "7";
			break;
		default:  url = "../Interface/CRM/erp_mytable/crm_mytable.php";
			break;
	}
	*/
	url = "../Interface/CRM/erp_mytable/crm_mytable.php";
	parent.parent.table_index.table_main.location=url
}

$(function() {
		var button = $('#popButton');
		var main=window.parent.frames["table_index"];
		while(main.document.getElementById('loginBox')=="undefine")
			sleep(100);
    	button.click(function() {
    	var box = main.document.getElementById("loginBox");	
        if(box.style.display == "" || box.style.display == "none")
        {
    		box.style.display = "block";
    		button.toggleClass('active');
        }
        else
        {
        	box.style.display = "none";
        	button.removeClass('active');
        }
    });
   
   
});

</script>
</head>
<body bgcolor="#D6F6FF" onload="timeview();">
<div style="height:27px;background: url(../theme/3/images/head-right-bg.jpg) top right repeat-x;)">
	<div style="height:27px;background: url(../theme/3/images/head-bg.jpg) top right no-repeat;">
		<div id="welcome">
		欢迎您，<span><?php echo $USER_NAME?></span><?php echo $PRIV_NAME?>
		</div>
		<div id="ico">
		<?php 
		for ($i=0;$i<sizeof($MENU_LIST);$i++)
		{
			print "<a href=\"#\" onClick=\"javascript:GoMenu('".$MENU_LIST[$i]['MENU_ID']."')\" class=\"togo\"><img title='".$MENU_LIST[$i]['MENU_NAME']."' src='images/menu/".$MENU_LIST[$i]['IMAGE'].".gif' width=17 border=0 /></a>";
		}
		?>
		
		</div>
		 <div id="ico1">
                <a href="#" id="popButton"><img title='弹出便签' src='images/menu/gif-0032.gif' ></a>
         </div>
	
		<div>
			<a class="goBack" href="javascript:history.back()" ><img src="../theme/3/images/back.gif" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.forward()" ><img src="../theme/3/images/forward.gif" align="absmiddle"></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span id="time_area" class=timer> </span>
			
			
		</div>
	</div>
</div>

</body>
</html>
