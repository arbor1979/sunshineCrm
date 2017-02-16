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
$theme = "1";
$flowid = $_GET['flowid'];
if ( $flowid == "" )
{
				$flowid = 7;
}
$sql = "select * from flow_process where flowID='{$flowid}'";
$rs = $db->execute( $sql );
$rsEA = $rs->getarray( );
$processList = array( );
$hrefList = array( );
$i = 0;
for ( ;	$i < sizeof( $rsEA );	++$i	)
{
				$functionID = $rsEA[$i]['functionID'];
				$selectSql = "select * from sys_function where FUNC_ID='".$functionID."'";
				$rsOA = $db->execute( $selectSql );
				$rsOA_a = $rsOA->getarray( );
				if ( $rsOA_a[0]['MENU_ID'] != 0 )
				{
								$MENU_ID = $rsOA_a[0]['MENU_ID'];
								$processID = $rsEA[$i]['processID'];
								$func_code = $rsOA_a[0]['FUNC_CODE'];
								array_push( $processList, $processID );
								$FUNC_LINK = $rsOA_a[0]['FUNC_LINK'];
								$FUNC_LINK_SHORT = substr( $FUNC_LINK, 0, 2 );
								if ( $FUNC_LINK_SHORT == ".." )
								{
												$FUNC_LINK = "http://jxc.dandian.net/".substr( $FUNC_LINK, 3, strlen( $FUNC_LINK ) );
								}
								else
								{
												$FUNC_LINK = "http://jxc.dandian.net/Framework/".$FUNC_LINK;
								}
								$URL_LINK[$processID] = $FUNC_LINK;
								array_push( $hrefList, $func_code );
				}
}
echo "\r\n<html xmlns:vml=\"urn:schemas-microsoft-com:vml\">\r\n\t<head>\r\n\t\t<title>业务流程图</title>\r\n\t\t";
echo "<s";
echo "cript language=\"javascript\" src=\"../Interface/JXC/flowgraph/flowgraph.js\"></script>\r\n\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"../theme/3/style.css\">\r\n\t\t<OBJECT id=\"vmlRender\" classid=\"CLSID:10072CEC-8CC1-11D1-986E-00A0C955B42E\" VIEWASTEXT></OBJECT>\r\n\t\t";
echo "<s";
echo "tyle>vml\\:* { FONT-SIZE: 15px; BEHAVIOR: url(#VMLRender);} </style>\r\n\t</head>\r\n\t<body  class='bodycolor' topmargin=\"5\" leftmargin=\"5\">\r\n\t\t<form>\r\n\t\t<table>\r\n\t\t<tr>\r\n\t\t<td>\r\n\t\t<vml:group ID=\"FlowVML\"  style=\"left:100;top:50;width:800px;height:500px;position:relative;\" coordsize=\"800,800\">\r\n\t\t";
$i = 0;
for ( ;	$i < sizeof( $rsEA );	++$i	)
{
				$processID = $rsEA[$i]['processID'];
				if ( in_array( $processID, $processList ) )
				{
								$fromX = $rsEA[$i]['locationX'];
								$fromY = $rsEA[$i]['locationY'];
								$processName = $rsEA[$i]['processName'];
								$functionID = $rsEA[$i]['functionID'];
								$toProcess = $rsEA[$i]['toProcess'];
								$text = "'".$rsEA[$i]['processName']."'";
								$hrefLink = $URL_LINK[$processID];
								$hasLink = true;
								echo "\t\t\t\t\t";
								echo "<s";
								echo "cript language=\"javascript\">\r\n\t\t\t\t\t//画流程图步骤地矩形框\r\n\t\t\t\t\tdocument.write(getRectHTML(100, 50, ";
								echo $fromX;
								echo ", ";
								echo $fromY;
								echo ", ";
								echo $text;
								echo ",'";
								echo $hrefLink;
								echo "',true)); \r\n\t\t\t\t\t</script>\r\n\t\t\t\t\t\r\n\t\t\t";
								$startPos = 0;
								$endPos = -1;
								$toProcess = $rsEA[$i]['toProcess'];
								if ( $toProcess != "" )
								{
												$toProcessArray1 = explode( ";", $toProcess );
												$k = 0;
												for ( ;	$k < sizeof( $toProcessArray1 );	++$k	)
												{
																$Element = $toProcessArray1[$k];
																$toProcessArray = explode( "_", $Element );
																$line = $toProcessArray[1];
																print "<script language=\"javascript\">document.write(getLineHTML('{$line}',true));</script>\n";
												}
								}
				}
}
echo "\r\n\t\t</vml:group>\r\n\t\t</td>\r\n\t\t</tr>\r\n\t\t<table>\r\n\t\t</form>\r\n\t</body>\r\n</html>";
?>
