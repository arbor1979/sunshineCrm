<?php
require_once( "include.inc.php" );
//$GLOBAL_SESSION = returnsession( );
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/

function element_input( $showtext, $showpic, $name, $value, $ischecked )
{
				if ( $ischecked )
				{
								print "<input type=\"checkbox\" name=\"{$name}\" value=\"{$value}\" checked><img src=\"images/menu/{$showpic}\" width=17 height=17>&nbsp;&nbsp;{$showtext}\n";
				}
				else
				{
								print "<input type=\"checkbox\" name=\"{$name}\" value=\"{$value}\"><img src=\"images/menu/{$showpic}\" width=17 height=17>&nbsp;&nbsp;{$showtext}\n";
				}
}

function element_title( $showtext, $showpic, $name, $value, $ischecked, $showtext_add = "" )
{
				print "<tr title=\"{$showtext}\">\n";
				print "<td class=\"TableData\" nowrap>\n";
				element_input( $showtext, $showpic, $name, $value, $ischecked );
				print $showtext_add;
				print "</td>\n";
				print "</tr>\n";
}

function element_changeline( )
{
				print "<br>&nbsp;&nbsp;&nbsp;&nbsp;\n";
}

function element_tr( $showtext, $showpic, $name, $value, $ischecked, $showtext_add = "" )
{
				print "<tr title=\"{$showtext}\">\n";
				print "<td class=\"TableData\" nowrap>\n";
				print $showtext_add;
				print "　　";
				element_input( $showtext, $showpic, $name, $value, $ischecked );
				print "</td>\n";
				print "</tr>\n";
}

function element_header( $showtext, $showpic, $name, $value )
{
				print "<tr title=\"{$showtext}\" class=\"TableHeader\">\n";
				print "<td nowrap>\n";
				print "<img src=\"images/menu/{$showpic}\" width=17 height=17>&nbsp;&nbsp;{$showtext}\n";
				print $showtext_add;
				print "</td>\n";
				print "</tr>\n";
}

function parent_table_1( $showtext = "我的办公桌", $pic = "mytable.gif", $parent_id = "MENU_10", $id = "10" )
{
				print "<table border=\"0\" cellspacing=\"1\" class=\"small\" bgcolor=\"#000000\" cellpadding=\"3\" align=\"center\">\n";
				print "<tr class=\"TableHeader\" title=\"{$showtext}\"> \n";
				print "<td nowrap> <input type=\"checkbox\" name=\"{$parent_id}\" onClick=\"check_all(this,'{$id}');\">\n";
				print "<img src=\"images/menu/{$pic}\" width=17 height=17>&nbsp;&nbsp;<b>{$showtext}</b>\n";
				print "</td>\n";
				print "</tr>\n";
}

function parent_table_end( )
{
				print "</table></td><td valign=\"top\"></td><td valign=\"top\">";
}


$action = $HTTP_GET_VARS[action];
$userprivid = $HTTP_GET_VARS[userprivid];
global $db;
$GLOBALS['_GET']['USER_PRIV'] = isset( $_GET['USER_PRIV'] ) ? $_GET['USER_PRIV'] : 2;
$sql = "select * from user_priv where USER_PRIV='".$_GET['USER_PRIV']."'";
$rs = $db->execute( $sql );
$FUNC_ID_STR_SYS = $rs->fields['FUNC_ID_STR'];
$FUNC_ID_STR_ARRAY = explode( ",", $FUNC_ID_STR_SYS );
$ExecTimeBegin = getmicrotime( );
global $db;
$sql = "select * from sys_function order by MENU_ID,FUNC_ID";
$rs = $db->cacheexecute( 1, $sql );
$rs_array = $rs->getarray( );
$menu_mark = "MENU_";
$sql = "select * from sys_menu order by MENU_ID";
$rs_menu = $db->execute( $sql );
$rs_array_menu = $rs_menu->getarray( );
$i_menu = 0;
foreach ( $rs_array as $list )
{
				$strlen = strlen( $list['MENU_ID'] );
				switch ( $strlen )
				{
				case 2 :
								print $list['MENU_ID']."<BR>";
								break;
				case 4 :
								$menu['index'][substr( $list['MENU_ID'], 0, 2 )][substr( $list['MENU_ID'], 2, 2 )] = $list['MENU_ID'];
								$menu['index_name']['FUNC_NAME']["".$list['MENU_ID'].""] = $list['FUNC_NAME'];
								$menu['index_name']['FUNC_CODE']["".$list['MENU_ID'].""] = $list['FUNC_CODE'];
								$menu['index_name']['FUNC_LINK']["".$list['MENU_ID'].""] = $list['FUNC_LINK'];
								$menu['index_name']['FUNC_ID']["".$list['MENU_ID'].""] = $list['FUNC_ID'];
								break;
				case 6 :
								$menu['index'][substr( $list['MENU_ID'], 0, 4 )][substr( $list['MENU_ID'], 4, 2 )] = $list['MENU_ID'];
								$menu['index_name']['FUNC_NAME']["".$list['MENU_ID'].""] = $list['FUNC_NAME'];
								$menu['index_name']['FUNC_CODE']["".$list['MENU_ID'].""] = $list['FUNC_CODE'];
								$menu['index_name']['FUNC_LINK']["".$list['MENU_ID'].""] = $list['FUNC_LINK'];
								$menu['index_name']['FUNC_ID']["".$list['MENU_ID'].""] = $list['FUNC_ID'];
				}
}
echo "<s";
echo "cript>\r\nvar MENU_ID_ARRAY = new Array();\r\n";
$i = 0;
foreach ( $rs_array_menu as $list )
{
				print "MENU_ID_ARRAY[{$i}]=\"".$list['MENU_ID']."\";\n";
				++$i;
}
echo "\r\nfunction check_all(menu_all,MENU_ID)\r\n{\r\n\r\n var MENU_ID_Array=getElementsByName(MENU_ID);\r\n for (i=0;i<MENU_ID_Array.length;i++)\r\n {\r\n   if(menu_all.checked)\r\n      MENU_ID_Array[i].checked=true;\r\n   else\r\n      MENU_ID_Array[i].checked=false;\r\n }\r\n\r\n \r\n\r\nfunction mysubmit";
echo "()\r\n{\r\n  func_id_str=\"\";\r\n  \r\n  for(j=0;j";
echo "<";
echo sizeof( $rs_array_menu );
echo ";j++)\r\n  {\r\n    MENU_ID=MENU_ID_ARRAY[j];\r\n\r\n    for(i=0;i<document.all(MENU_ID).length;i++)\r\n    {\r\n        el=document.all(MENU_ID).item(i);\r\n        if(el.checked)\r\n        {  val=el.value;\r\n           func_id_str+=val + \",\";\r\n        }\r\n    }\r\n    \r\n    if(i==0)\r\n    {\r\n        el=document.all(MENU_ID);\r\n        if(el.checked)\r\n        {  val=el.value;\r\n           func_id_str+=val + \",\";\r\n     ";
echo "   }\r\n    }\r\n  }\r\n  //document.";
echo $var;
echo ".value = func_id_str ;\r\n  \r\n";
print "location=\"?action=edit_purview_data&FUNC_ID_STR=\"+ func_id_str +\"&USER_PRIV=".$_GET['USER_PRIV']."\";\n";
print "}\n";
echo "</script>\r\n</head>\r\n<table border=\"0\" cellspacing=\"2\" class=\"small\" cellpadding=\"3\" align=\"center\">\r\n<tr class=\"TableContent\">\r\n<td valign=\"top\">\r\n";
foreach ( $rs_array_menu as $list_menu )
{
				parent_table_1( $list_menu['MENU_NAME'], $list_menu['IMAGE'].".gif", $menu_mark.$list_menu['MENU_ID'], $list_menu['MENU_ID'] );
				element_header( $list_menu['MENU_NAME'], $list_menu['IMAGE'].".gif", $list_menu['MENU_ID'], $list_menu['MENU_ID'] );
				sort( $menu['index']["".$list_menu['MENU_ID'].""] );
				$i = 0;
				foreach ( $menu['index']["".$list_menu['MENU_ID'].""] as $menu_list )
				{
								$menu_2 = $menu['index'][$menu_list];
								++$i;
								$pic_array = explode( "/", $menu['index_name']['FUNC_CODE'][$menu_list] );
								$pic = $pic_array[0].".gif";
								if ( is_array( $menu_2 ) )
								{
												$systemfuncid = $menu['index_name']['FUNC_ID'][( boolean )$menu_list];
												$ischecked = in_array( $systemfuncid, $FUNC_ID_STR_ARRAY );
												element_title( $menu['index_name']['FUNC_NAME'][$menu_list], $pic, $list_menu['MENU_ID'], $menu['index_name']['FUNC_ID'][( boolean )$menu_list], $ischecked );
												unset( $ischecked );
												foreach ( $menu_2 as $list )
												{
																$systemfuncid = $menu['index_name']['FUNC_ID'][( boolean )$list];
																$ischecked = in_array( $systemfuncid, $FUNC_ID_STR_ARRAY );
																$pic_array = explode( "/", $menu['index_name']['FUNC_CODE'][$list] );
																$pic = $pic_array[0].".gif";
																element_tr( $menu['index_name']['FUNC_NAME'][$list], $pic, $list_menu['MENU_ID'], $menu['index_name']['FUNC_ID'][( boolean )$list], $ischecked );
																unset( $ischecked );
												}
								}
								else
								{
												$systemfuncid = $menu['index_name']['FUNC_ID'][( boolean )$menu_list];
												$ischecked = in_array( $systemfuncid, $FUNC_ID_STR_ARRAY );
												element_title( $menu['index_name']['FUNC_NAME'][$menu_list], $pic, $list_menu['MENU_ID'], $systemfuncid, $ischecked );
												unset( $ischecked );
								}
				}
				parent_table_end( );
}
echo "</td>\r\n</tr>\r\n</table>";
?>
