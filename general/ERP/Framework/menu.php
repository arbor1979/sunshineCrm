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
function menu_table_3( $showtext, $url, $MEMO, $pic, $tree_pic = "tree_blank.gif", $tree_pic2 = "tree_line.gif", $tree_pic3 = "tree_line.gif" )
{
				$MEMO == "" ? ( $MEMO = $showtext ) : "";
				print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
				print "<TBODY>\n";
				print "<TR>\n";
				print "<TD><IMG src=\"images/menu/{$tree_pic2}\"></TD>\n";
				print "<TD><IMG src=\"images/menu/{$tree_pic3}\" border=0></TD>\n";
				print "<TD><IMG src=\"images/menu/{$tree_pic}\"></TD>\n";
				print "<TD><A title = '{$MEMO}' href=\"javascript:openURL('{$url}')\"><IMG height=17 alt={$showtext} src=\"images/menu/{$pic}\" \n";
				print "width=17 border=0></a></TD>\n";
				print "<TD colSpan=2  nowrap title = '{$MEMO}'><A title = '{$MEMO}' href=\"javascript:openURL('{$url}')\">&nbsp;{$showtext}</A>\n";
				print "</TD></TR></TBODY></TABLE>\n";
}

function menu_table_2( $showtext, $url, $MEMO, $pic, $tree_pic = "tree_blank.gif", $tree_pic2 = "tree_line.gif" )
{
				$MEMO == "" ? ( $MEMO = $showtext ) : "";
				print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
				print "<TBODY>\n";
				print "<TR>\n";
				print "<TD><IMG src=\"images/menu/{$tree_pic2}\"></TD>\n";
				print "<TD><IMG src=\"images/menu/{$tree_pic}\"></TD>\n";
				print "<TD><A title = '{$MEMO}' href=\"javascript:openURL('{$url}')\"><IMG height=17 alt={$showtext} src=\"images/menu/{$pic}\" \n";
				print "width=17 border=0></a></TD>\n";
				print "<TD colSpan=2 nowrap title = '{$MEMO}'><A title = '{$MEMO}' href=\"javascript:openURL('{$url}')\">&nbsp;{$showtext}</A>\n";
				print "</TD></TR></TBODY></TABLE>\n";
}

function parent_table_1( $showtext = "我的办公桌", $pic = "mytable.gif", $id = "01", $image = "tree_plus.gif" )
{
				global $menu_mark;
				if ( $_GET['MENU_ID'] != "" && $_GET['MENU_ID'] != "00" )
				{
								$image = "tree_minusl.gif";
				}
				print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
				print "<TBODY>\n";
				print "<TR>\n";
				print "<TD><A href=\"javascript:myclick(".$menu_mark.$id.")\"><IMG class=outline id=".$menu_mark.$id." style=\"CURSOR: hand\" src=\"images/menu/{$image}\" border=0></a></TD>\n";
				print "<TD nowrap><A href=\"javascript:myclick(".$menu_mark.$id.")\"><IMG height=17 alt={$showtext} src=\"images/menu/{$pic}\" width=17 border=0></a></TD>\n";
				print "<TD colSpan=3 nowrap><A href=\"javascript:myclick(".$menu_mark.$id.")\">&nbsp;{$showtext}</A>\n";
				print "</TD></TR></TBODY></TABLE>\n";
}

function parent_table_2( $showtext = "电子邮件", $MEMO, $pic = "@mail.gif", $id = "01", $tree_plus = "tree_plus.gif", $tree_pic2 = "tree_line.gif" )
{
				global $menu_mark;
				global $_GET;
				$MEMO == "" ? ( $MEMO = $showtext ) : "";
				print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
				print "<TBODY>\n";
				print "<TR>\n";
				print "<TD><IMG src=\"images/menu/{$tree_pic2}\" border=0></TD>\n";
				print "<TD><A title = '{$MEMO}'  href=\"javascript:myclick(".$menu_mark.$id.")\"><IMG class=outline id=".$menu_mark.$id." style=\"CURSOR: hand\" src=\"images/menu/{$tree_plus}\" border=0></a></TD>\n";
				print "<TD><A title = '{$MEMO}'  href=\"javascript:myclick(".$menu_mark.$id.")\"><IMG height=17 alt={$showtext} src=\"images/menu/{$pic}\" width=17 border=0></a></TD>\n";
				print "<TD colSpan=2 nowrap title = '{$MEMO}'><A title = '{$MEMO}'  href=\"javascript:myclick(".$menu_mark.$id.")\">&nbsp;{$showtext}</A>\n";
				print "</TD></TR></TBODY></TABLE>\n";
}

function part_table_begin( $id = "0104" )
{
				global $menu_mark;
				global $_GET;
				if ( $_GET['MENU_ID'] != "" && $_GET['MENU_ID'] != "00" )
				{
								$hand = "hand";
				}
				else
				{
								$hand = "none";
				}
				print "<TABLE class=small id=".$menu_mark.$id."d style=\"DISPLAY: ".$hand."\" cellSpacing=0 cellPadding=0 border=0>\n";
				print "<TBODY>\n";
				print "<TR>\n";
				print "<TD>\n";
}

function part_table_begin_00( $id = "0104" )
{
				global $menu_mark;
				global $_GET;
				if ( $_GET['MENU_ID'] != "" && $_GET['MENU_ID'] != "00" )
				{
								$hand = "none";
				}
				else
				{
								$hand = "hand";
				}
				print "<TABLE class=small id=".$menu_mark.$id."d style=\"DISPLAY: ".$hand."\" cellSpacing=0 cellPadding=0 border=0>\n";
				print "<TBODY>\n";
				print "<TR>\n";
				print "<TD>\n";
}

function part_table_end( )
{
				print "</TD></TR></TBODY></TABLE>\n";
}

require_once( "lib.inc.php" );

require_once( "../Enginee/newai.php" );

$GLOBA_SESSION = returnsession( );
global $SUNSHINE_USER_ID_VAR;
global $_SESSION;
global $SUNSHINE_USER_PRIV_VAR;
$lang = returnsystemlang( );
$USER_PRIV = $_SESSION[$SUNSHINE_USER_PRIV_VAR];
$USER_ID = $_SESSION['LOGIN_UID'];
$USER_PRIV = $USER_PRIV != "" ? $USER_PRIV : returntablefield( "user", "USER_ID", $USER_ID, "USER_PRIV" );
$sql = "select FUNC_ID_STR from user where UID='".$USER_ID."'";
//print_R($_SESSION);
$rs = $db->cacheexecute( 15, $sql );
$FUNC_ID_STR_SYS = $rs->fields['FUNC_ID_STR'];
$FUNC_ID_STR_ARRAY = explode( ",", $FUNC_ID_STR_SYS );
$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\r\n<HTML><HEAD><TITLE></TITLE>\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n<LINK href=\"../theme/";
echo $_SESSION['LOGIN_THEME'];;
echo "/images/style.css\" rel=stylesheet>\r\n";
echo "<S";
echo "TYLE type=text/css>A:link {\r\n\tCOLOR: #000000; TEXT-DECORATION: none\r\n}\r\nA:visited {\r\n\tCOLOR: #000000; TEXT-DECORATION: none\r\n}\r\nA:active {\r\n\tCOLOR: #3333ff; TEXT-DECORATION: none\r\n}\r\nA:hover {\r\n\tCOLOR: #ff0000; TEXT-DECORATION: none\r\n}\r\n</STYLE>\r\n\r\n<META content=\"MSHTML 6.00.2800.1106\" name=GENERATOR></HEAD>\r\n<BODY class=panel ><!-- OA树开始-->\r\n";
$ExecTimeBegin = getmicrotime( );
global $db;
if ( $_GET['MENU_ID'] != "" && $_GET['MENU_ID'] != "00" )
{
				$whereSql = "where MENU_ID = '".$_GET['MENU_ID']."'";
}
else
{
				$whereSql = "";
}
$sql = "select * from sys_function  order by MENU_ID";
$rs = $db->cacheexecute( 1, $sql );
$rs_array = $rs->getarray( );
$menu_mark = "MENU_";
switch ( $systemlang )
{
case "en" :
				$FUNC_NAME_MENU = "ENGLISHNAME";
				break;
case "zh" :
				$FUNC_NAME_MENU = "FUNC_NAME";
				break;
default :
				$FUNC_NAME_MENU = "FUNC_NAME";
}
foreach ( $rs_array as $list )
{
				$FUNC_ID = $list['FUNC_ID'];
				$MEMO = $list['MEMO'];
				$ischecked = in_array( $FUNC_ID, $FUNC_ID_STR_ARRAY );
				if ( $ischecked )
				{
								$strlen = strlen( $list['MENU_ID'] );
								switch ( $strlen )
								{
								case 2 :
												print $list['MENU_ID']."<BR>";
												break;
								case 4 :
												$menu['index'][substr( $list['MENU_ID'], 0, 2 )][substr( $list['MENU_ID'], 2, 2 )] = $list['MENU_ID'];
												$menu['index_name'][$FUNC_NAME_MENU]["".$list['MENU_ID'].""] = $list[$FUNC_NAME_MENU];
												$menu['index_name']['FUNC_CODE']["".$list['MENU_ID'].""] = $list['FUNC_CODE'];
												$menu['index_name']['FUNC_LINK']["".$list['MENU_ID'].""] = $list['FUNC_LINK'];
												$menu['index_name']['FUNC_ID']["".$list['MENU_ID'].""] = $list['FUNC_ID'];
												$menu['index_name']['MEMO']["".$list['MENU_ID'].""] = $list['MEMO'];
												break;
								case 6 :
												$menu['index'][substr( $list['MENU_ID'], 0, 4 )][substr( $list['MENU_ID'], 4, 2 )] = $list['MENU_ID'];
												$menu['index_name'][$FUNC_NAME_MENU]["".$list['MENU_ID'].""] = $list[$FUNC_NAME_MENU];
												$menu['index_name']['FUNC_CODE']["".$list['MENU_ID'].""] = $list['FUNC_CODE'];
												$menu['index_name']['FUNC_LINK']["".$list['MENU_ID'].""] = $list['FUNC_LINK'];
												$menu['index_name']['FUNC_ID']["".$list['MENU_ID'].""] = $list['FUNC_ID'];
												$menu['index_name']['MEMO']["".$list['MENU_ID'].""] = $list['MEMO'];
								}
								isset( $ischecked );
				}
}
$sql = "select * from sys_menu {$whereSql} order by MENU_ID";
$rs_menu = $db->execute( $sql );
$rs_array_menu = $rs_menu->getarray( );
$i_menu = 0;

$MENU_NAME_MENU = "MENU_NAME";
foreach ( $rs_array_menu as $list_menu )
{
				if ( ++$i_menu == sizeof( $rs_array_menu ) )
				{
								$tree_pic2 = "tree_transp.gif";
								$image = "tree_plusl.gif";
				}
				else
				{
								$tree_pic2 = "tree_line.gif";
								$image = "tree_plus.gif";
				}
				if ( 0 < sizeof( $menu['index']["".$list_menu['MENU_ID'].""] ) )
				{
								parent_table_1( $list_menu[$MENU_NAME_MENU], $list_menu['IMAGE'].".gif", $list_menu['MENU_ID'], $image );
								part_table_begin( $list_menu['MENU_ID'] );
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
																if ( sizeof( $menu['index']["".$list_menu['MENU_ID'].""] ) == $i )
																{
																				$tree_plus = "tree_plusl.gif";
																				$tree_pic3 = "tree_transp.gif";
																}
																else
																{
																				$tree_plus = "tree_plus.gif";
																				$tree_pic3 = "tree_line.gif";
																}
																$sysfunctionid = $menu['index_name']['FUNC_ID'][$menu_list];
																$ischecked = in_array( $sysfunctionid, $FUNC_ID_STR_ARRAY );
																parent_table_2( $menu['index_name'][$FUNC_NAME_MENU][$menu_list], $menu['index_name']['MEMO'][$menu_list], $pic, $menu_list, $tree_plus, $tree_pic2 );
																if ( $_GET['MENU_ID'] != "" && $_GET['MENU_ID'] != "00" )
																{
																				part_table_begin_00( $menu_list );
																}
																else
																{
																				part_table_begin( $menu_list );
																}
																foreach ( $menu_2 as $list )
																{
																				++$ii;
																				if ( sizeof( $menu_2 ) == $ii )
																				{
																								$tree_pic = "tree_blankl.gif";
																								$ii = 0;
																				}
																				else
																				{
																								$tree_pic = "tree_blank.gif";
																				}
																				$ischecked = in_array( $menu['index_name']['FUNC_ID'][$list], $FUNC_ID_STR_ARRAY );
																				$pic_array = explode( "/", $menu['index_name']['FUNC_CODE'][$list] );
																				$pic = $pic_array[0].".gif";
																				menu_table_3( $menu['index_name'][$FUNC_NAME_MENU][$list], $menu['index_name']['FUNC_LINK'][$list], $menu['index_name']['MEMO'][$list], $pic, $tree_pic, $tree_pic2, $tree_pic3 );
																				isset( $ischecked );
																}
																part_table_end( );
												}
												else
												{
																if ( sizeof( $menu['index']["".$list_menu['MENU_ID'].""] ) == $i )
																{
																				$tree_pic = "tree_blankl.gif";
																}
																else
																{
																				$tree_pic = "tree_blank.gif";
																}
																$ischecked = in_array( $menu['index_name']['FUNC_ID'][$menu_list], $FUNC_ID_STR_ARRAY );
																menu_table_2( $menu['index_name'][$FUNC_NAME_MENU][$menu_list], $menu['index_name']['FUNC_LINK'][$menu_list], $menu['index_name']['MEMO'][$menu_list], $pic, $tree_pic, $tree_pic2 );
																isset( $ischecked );
												}
								}
				}
				part_table_end( );
}
echo "\r\n";
echo "<SCRIPT language=JavaScript>\r\nvar openedid;\r\nvar openedid_ft;\r\nvar flag=0,sflag=0;\r\n\r\n//-------- 菜单点击事件 -------\r\nfunction myclick(srcelement)\r\n{\r\n  var targetid,srcelement,targetelement;\r\n  var strbuf;\r\n\r\n  //-------- 如果点击了展开或收缩按钮---------\r\n  if(srcelement.className==\"outline\")\r\n  {\r\n     //if(srcelement.title!=\"\" && srcelement.src.indexOf(\"plus\")>-1)\r\n       // menu_shrink();\r\n\r\n ";
echo "    targetid=srcelement.id+\"d\";\r\n     targetelement=document.getElementById(targetid);\r\n\r\n     if (targetelement.style.display==\"none\")\r\n     {\r\n        targetelement.style.display='';\r\n        strbuf=srcelement.src;\r\n        if(strbuf.indexOf(\"plus.gif\")>-1)\r\n                srcelement.src=\"./images/menu/tree_minus.gif\";\r\n        else\r\n                srcelement.src=\"./images/menu/tree_minusl.gif\";\r\n     }\r";
echo "\n     else\r\n     {\r\n        targetelement.style.display=\"none\";\r\n        strbuf=srcelement.src;\r\n        if(strbuf.indexOf(\"minus.gif\")>-1)\r\n                srcelement.src=\"./images/menu/tree_plus.gif\";\r\n        else\r\n                srcelement.src=\"./images/menu/tree_plusl.gif\";\r\n     }\r\n  }\r\n}\r\n\r\nfunction openURL(URL)\r\n{\r\n   parent.parent.table_index.table_main.location=URL;\r\n}\r\n\r\n</SCRIPT>\r\n</TR";
echo "></TBODY></TABLE></BODY></HTML>\r\n";
?>
