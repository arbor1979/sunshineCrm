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

function formnewvar( $file_array, $ereg_replace )
{
				global $_GET;
				global $_POST;
				$showlistfieldlist = $file_array['showlistfieldlist'];
				$showlistfieldlist_array = explode( ",", $showlistfieldlist );
				$showlistfieldlist_flip = array_flip( $showlistfieldlist_array );
				$showlistnull = $file_array['showlistnull'];
				$showlistnull_array = explode( ",", $showlistnull );
				$showlistfieldfilter = $file_array['showlistfieldfilter'];
				$showlistfieldfilter_array = explode( ",", $showlistfieldfilter );
				$ereg_replace_array = explode( ",", $ereg_replace );
				$i = 0;
				for ( ;	$i < sizeof( $ereg_replace_array );	++$i	)
				{
								$index_name = $ereg_replace_array[$i];
								$index_id = $showlistfieldlist_flip[$index_name];
								$fieldfilter_array[$i] = $showlistfieldfilter_array[$index_id];
								$fieldnull_array[$i] = $showlistnull_array[$index_id];
				}
				array_pop( $fieldfilter_array );
				array_pop( $fieldnull_array );
				array_pop( $ereg_replace_array );
				$return['newfieldfilter'] = join( ",", $fieldfilter_array );
				$return['newfieldnull'] = join( ",", $fieldnull_array );
				$return['newfieldlist'] = join( ",", $ereg_replace_array );
				return $return;
}

function updatesystemsetting( $formnewvar )
{
				global $_GET;
				global $_POST;
				global $db;
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $_SESSION;
				$USER_ID = $_SESSION[$SUNSHINE_USER_NAME_VAR];
				$insert_sql = "insert into systemsetting values('','{$USER_ID}','{$_GET['table_name']}','{$_GET['table_action']}','{$formnewvar['newfieldlist']}','{$formnewvar['newfieldnull']}','{$formnewvar['newfieldfilter']}')";
				$update_sql = "update systemsetting set FIELD_LIST='{$formnewvar['newfieldlist']}',FIELD_NULL='{$formnewvar['newfieldnull']}',FIELD_FILTER='{$formnewvar['newfieldfilter']}' where TABLE_NAME='{$_GET['table_name']}' and TABLE_ACTION='{$_GET['table_action']}'";
				$select_sql = "select * from systemsetting where TABLE_NAME='{$_GET['table_name']}' and TABLE_ACTION='{$_GET['table_action']}'";
				$rs_select = $db->execute( $select_sql );
				if ( 1 <= $rs_select->recordcount( ) )
				{
								$rs_update = $db->execute( $update_sql );
				}
				else
				{
								$rs_insert = $db->execute( $insert_sql );
				}
				return $rs_select->getarray( );
}

function usesystemsetting( )
{
				global $_GET;
				global $_POST;
				global $db;
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $_SESSION;
				$USER_ID = $_SESSION[$SUNSHINE_USER_NAME_VAR];
				$delete_sql = "delete from systemsetting where TABLE_NAME='{$_GET['table_name']}' and TABLE_ACTION='{$_GET['table_action']}'";
				$rs_delete = $db->execute( $delete_sql );
}

function systemsetting_view( $value )
{
				global $_GET;
				global $_POST;
				global $db;
				global $common_html;
				global $mark;
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $_SESSION;
				$USER_ID = $_SESSION[$SUNSHINE_USER_NAME_VAR];
				echo "\r\n";
				echo "<s";
				echo "cript>\r\n\r\nfunction func_find(select_obj,option_text)\r\n{\r\n pos=option_text.indexOf(\"] \")+1;\r\n option_text=option_text.substr(0,pos);\r\n\r\n for (j=0; j";
				echo "<s";
				echo "elect_obj.options.length; j++)\r\n {\r\n   str=select_obj.options(j).text;\r\n   if(str.indexOf(option_text)>=0)\r\n      return j;\r\n }//for\r\n\r\n return j;\r\n}\r\n\r\nfunction func_color(select_obj)\r\n{\r\n font_color=\"red\";\r\n option_text=\"\";\r\n for (j=0; j";
				echo "<s";
				echo "elect_obj.options.length; j++)\r\n {\r\n   str=select_obj.options(j).text;\r\n   if(str.indexOf(option_text)<0)\r\n   {\r\n      if(font_color==\"red\")\r\n         font_color=\"blue\";\r\n      else\r\n         font_color=\"red\";\r\n   }\r\n   select_obj.options(j).style.color=font_color;\r\n\r\n   pos=str.indexOf(\"] \")+1;\r\n   option_text=str.substr(0,pos);\r\n }//for\r\n\r\n return j;\r\n}\r\n\r\nfunction func_insert()\r\n{\r\n for (i=selec";
				echo "t2.options.length-1; i>=0; i--)\r\n {\r\n   if(select2.options(i).selected)\r\n   {\r\n     option_text=select2.options(i).text;\r\n     option_value=select2.options(i).value;\r\n     option_style_color=select2.options(i).style.color;\r\n\r\n     var my_option = document.createElement(\"OPTION\");\r\n     my_option.text=option_text;\r\n     my_option.value=option_value;\r\n     my_option.style.color=option_style_color;\r\n";
				echo "\r\n     pos=func_find(select1,option_text);\r\n     select1.add(my_option,pos);\r\n     select2.remove(i);\r\n  }\r\n }//for\r\n \r\n func_init();\r\n}\r\n\r\nfunction func_delete()\r\n{\r\n for (i=select1.options.length-1; i>=0; i--)\r\n {\r\n   if(select1.options(i).selected)\r\n   {\r\n     option_text=select1.options(i).text;\r\n     option_value=select1.options(i).value;\r\n\r\n     var my_option = document.createElement(\"OPTION";
				echo "\");\r\n     my_option.text=option_text;\r\n     my_option.value=option_value;\r\n\r\n     pos=func_find(select2,option_text);\r\n     select2.add(my_option,pos);\r\n     select1.remove(i);\r\n  }\r\n }//for\r\n \r\n func_init();\r\n}\r\n\r\nfunction func_select_all1()\r\n{\r\n for (i=select1.options.length-1; i>=0; i--)\r\n   select1.options(i).selected=true;\r\n}\r\n\r\nfunction func_select_all2()\r\n{\r\n for (i=select2.options.length-1";
				echo "; i>=0; i--)\r\n   select2.options(i).selected=true;\r\n}\r\n\r\nfunction func_init()\r\n{\r\n  func_color(select2);\r\n  func_color(select1);\r\n}\r\n\r\nfunction mysubmit(tablename,tableaction,returnmodel)\r\n{\r\n   fld_str=\"\";\r\n   for (i=0; i< select1.options.length; i++)\r\n   {\r\n      options_value=select1.options(i).value;\r\n      fld_str+=options_value+\",\";\r\n    }\r\n\r\n   location=\"?action=set_";
				echo $mark;
				echo "_data&table_name=\"+tablename+\"&table_action=\"+tableaction+\"&returnmodel=\"+returnmodel+\"&FLD_STR=\" + fld_str;\r\n}\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"5\" onload=\"func_init();\">\r\n\r\n\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"small\">\r\n  <tr>\r\n    <td class=\"Big\"><img src=\"images/edit.gif\" WIDTH=\"22\" HEIGHT=\"20\"><b><font color=\"#FFFFFF\"> ";
				echo $common_html['common_html']['setpersonalinfor'];
				echo "</font></b><br>\r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n\r\n<hr width=\"95%\" height=\"1\" align=\"left\" color=\"#FFFFFF\">\r\n<br>\r\n\r\n<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\" align=\"center\" bordercolorlight=\"#000000\" bordercolordark=\"#FFFFFF\" class=\"big\">\r\n  <tr bgcolor=\"#CCCCCC\">\r\n    <td align=\"center\"><b>";
				echo $value['titleleft'];
				echo "</b></td>\r\n    <td align=\"center\">&nbsp;</td>\r\n    <td align=\"center\" valign=\"top\"><b>";
				echo $value['titleright'];
				echo "</b></td>\r\n  </tr>\r\n  <tr>\r\n    <td valign=\"top\" align=\"center\" bgcolor=\"#CCCCCC\">\r\n    ";
				echo "<s";
				echo "elect  name=\"select1\" ondblclick=\"func_delete();\" MULTIPLE style=\"width:200;height:280\" >\r\n\t";
				if ( 0 < sizeof( $value['value'] ) )
				{
								foreach ( $value['value'] as $list )
								{
												print "<option value=\"".$list['value']."\">[".$list['value']."] ".$list['name']."</option>\n";
								}
				}
				echo "           </select>\r\n    <input type=\"button\" value=\" ";
				echo $common_html['common_html']['selectall'];
				echo " \" onclick=\"func_select_all1();\" class=\"SmallInput\">\r\n    </td>\r\n\r\n    <td align=\"center\" bgcolor=\"#999999\">\r\n      <input type=\"button\" class=\"SmallInput\" value=\" ← \" onclick=\"func_insert();\">\r\n      <br><br>\r\n      <input type=\"button\" class=\"SmallInput\" value=\" → \" onclick=\"func_delete();\">\r\n    </td>\r\n\r\n    <td align=\"center\" valign=\"top\" bgcolor=\"#CCCCCC\">\r\n    ";
				echo "<s";
				echo "elect  name=\"select2\" ondblclick=\"func_insert();\" MULTIPLE style=\"width:200;height:280\">\r\n\t";
				foreach ( $value['record'] as $list )
				{
								print "<option value=\"".$list['value']."\">[".$list['value']."] ".$list['name']."</option>\n";
				}
				echo "\r\n           </select>\r\n    <input type=\"button\" value=\" ";
				echo $common_html['common_html']['selectall'];
				echo " \" onclick=\"func_select_all2();\" class=\"SmallInput\">\r\n    </td>\r\n  </tr>\r\n\r\n  <tr bgcolor=\"#CCCCCC\">\r\n    <td align=\"center\" valign=\"top\" colspan=\"3\">\r\n    ";
				echo $common_html['common_html']['choosemultiply'];
				echo "<br>\r\n      <input type=\"button\" class=\"BigButton\" value=\"";
				echo $common_html['common_html']['save'];
				echo "\" onclick=\"mysubmit('";
				echo $value['table_name'];
				echo "','";
				echo $value['table_action'];
				echo "','";
				echo $_GET['returnmodel'];
				echo "');\">&nbsp;&nbsp;&nbsp;&nbsp;\r\n      <input type=\"button\" class=\"BigButton\" value=\"";
				echo $common_html['common_html']['return'];
				echo "\" onclick=\"location='?action=init_";
				echo $mark;
				echo "'\">\r\n\t  &nbsp;&nbsp;&nbsp;&nbsp;\r\n      <input type=\"button\" class=\"BigButton\" value=\"";
				echo $common_html['common_html']['systemconfig'];
				echo "\" onclick=\"location='?action=set_default_config&table_name=";
				echo $value['table_name'];
				echo "&table_action=";
				echo $value['table_action'];
				echo "'\">\r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n</body>\r\n</html>\r\n";
}

require_once( "include.inc.php" );
$GLOBAL_SESSION = returnsession( );
$action_array = explode( "_", $_GET['action'] );
$mark = $action_array[1];
?>
