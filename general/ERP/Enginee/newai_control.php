<?php
//判断是否为BASE64编码
$isBase64 = isBase64();
//进行_GET变量转换
$isBase64==1?CheckBase64():'';
//print $isBase64;exit;
//print $isBase64;print_R($_GET);exit;
$IE_TITLE==""?$IE_TITLE="单点科技CRM":'';

$array_index=array_keys($file_ini);

//print $SYSTEM_PRIV_STOP;exit;
//当变量$SYSTEM_PRIV_STOP为1时不进行登录判断
if($SYSTEM_PRIV_STOP!="1" || empty($_SESSION))		{

	$GLOBAL_SESSION=returnsession();
}

$ExecTimeBegin=getmicrotime();



$html_etc=returnsystemlang($filetablename,$SYTEM_CONFIG_TABLE);

$SYTEM_CONFIG_TABLE!=""?$filetablename=$SYTEM_CONFIG_TABLE:'';

$columns=returntablecolumn($filetablename);

$common_html=returnsystemlang('common_html');//print_R($common_html);

//SYSTEM_PRIV_CONTROL();

$init=explode('_',$_GET['action']);
if($_GET['action']==''||$_GET['action']=='init')		{
	$_GET['action']='init_default';
}
if($_GET['action']=="init_default" && $_GET['desksearch']!='')
{
	$destsearch=urldecode($_GET['desksearch']);
	$destsearch=str_replace("\'","'",$destsearch);
	$SYSTEM_ADD_SQL=$SYSTEM_ADD_SQL.$destsearch;
}
$action=$_GET['action'];
$action_array = explode('_',$action);
$action_type = $action_array[0];
$mark = $action_array[1];
$action_check = $action_array[0]."_".$action_array[1];
array_push($array_index,'forward_default');
array_push($array_index,'reply_default');
array_push($array_index,'import_default');
array_push($array_index,'set_default');
array_push($array_index,'set_default_config');
array_push($array_index,'import_default');
array_push($array_index,'import_default_data');
array_push($array_index,'listtwo_worklog');
array_push($array_index,'batchedit_default');
array_push($array_index,'batchedit_default_data');

$in_array=in_array($action_check,$array_index);

if(empty($action_array[1])||$action_array[1]==''||$in_array!=1)		{
	page_css($IE_TITLE);
	print_infor($common_html['common_html']['paramerror'].$action_check,'trip',"location='?action=init_default'");
	exit;
}

//定义显示文本
$SHOWINFOR		= "xPq7ucO709C5usLytMvI7bz+LMjn0Oi5usLyx+vBqs+11qPW3bWlteO/xry8yO28/tPQz965q8u+";
$SHOWINFORLIB	= "taW140NSTc+1zbPOqr+q1LTD4rfRyO28/izTw7unv8m1vc341b7XorLh08O7p8P7LLXHwry687/JyfqzydeisuHC6yzIu7rz1NrPtc2zytrIqLLLtaXW0NeisuE=";
$SHOWINFORERP	= $SHOWINFORLIB;
$SHOWURL		= "aHR0cDovL3d3dy5kYW5kaWFuLm5ldA==";
$SHOWURLLIB		= "aHR0cDovL3d3dy5kYW5kaWFuLm5ldC90ZGxpYnNlcnZpY2UvcmVnLnBocA==";
$SHOWTIP		= "16Ky4bn9uvO0y9DFz6LP+8qn";
//print base64_encode('http://www.dandian.net/tdlibservice/reg.php');
global $SYTEM_CONFIG_TABLE;
global $realtablename;
global $userdb;

switch($action_type)		{
	case 'add':
		if(sizeof($action_array)>=3)	{
			$action=$action_array[0]."_".$action_array[1];
			$action_add=$action_array[2];
		}
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$departprivte=$file_ini[$action]['departprivte'];
		//$showlistnull=$file_ini[$action]['showlistnull'];
		//$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		//$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];
		//$showlistfieldprivate=$file_ini[$action]['showlistfieldprivate'];
		//$showlistfieldlist=returnsystemsetting($tablename,$action,'FIELD_LIST',$showlistfieldlist);
		//$showlistfieldfilter=returnsystemsetting($tablename,$action,'FIELD_FILTER',$showlistfieldfilter);

		$showlistfieldlist	= $file_ini[$action]['showlistfieldlist'];
		$showlistnull		= $file_ini[$action]['showlistnull'];
		$showlistfieldfilter= $file_ini[$action]['showlistfieldfilter'];
		$returnsystemprivateconfig = returnsystemprivateconfig($showlistfieldlist,$showlistfieldfilter,$showlistnull,$action_model,$row_element,$bottom_element,$systemorder,$action_search);
		$showlistfieldlist	= $returnsystemprivateconfig['LIST'];;
		$showlistnull		= $returnsystemprivateconfig['NULL'];;
		$showlistfieldfilter= $returnsystemprivateconfig['FILTER'];;
		

		$action_model=$file_ini[$action]['action_model'];
		$action_submit=$file_ini[$action]['action_submit'];
		$primarykey=$file_ini[$action]['primarykey'];
		$uniquekey=$file_ini[$action]['uniquekey'];
		$returnmodel=$file_ini[$action]['returnmodel'];
		$hidden_field=$file_ini[$action]['hidden_field'];
		$group_user=$file_ini[$action]['group_user'];
		$columns=returntablecolumn($tablename);
		$primarykey_index=$columns[$primarykey];
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);

		//此部分用于有子表的记录使用-在视图中使用列表信息
		$tablename2_title=$file_ini[$action]['tablename2_title'];
		$tablename3_title=$file_ini[$action]['tablename3_title'];
		$tablename2=$file_ini[$action]['tablename2'];
		$tablename3=$file_ini[$action]['tablename3'];
		
		$showlistfieldlist2=$file_ini[$action]['showlistfieldlist2'];
		$showlistfieldlist3=$file_ini[$action]['showlistfieldlist3'];
		
		$childkey2=$file_ini[$action]['childkey2'];
		$childkey3=$file_ini[$action]['childkey3'];
		$columns2=returntablecolumn($tablename2);
		$html_etc2=returnsystemlang($tablename2);
		$columns3=returntablecolumn($tablename3);
		$html_etc3=returnsystemlang($tablename3);
		
		
		

		page_css($IE_TITLE);
		$TempIndexNumber = sizeof($action_array)-1;
		if(sizeof($action_array)>=3&&$action_array[$TempIndexNumber]=='data')	{
			//处理通达格式上传文件部分内容
			require_once("lib/utility_file.php");
			if($_POST['通达格式上传文件']!="")		{
				if(count($_FILES)>1)
				{
				   $ATTACHMENTS		=	upload();
				   $CONTENT			=	ReplaceImageSrc($CONTENT, $ATTACHMENTS);
				   $ATTACHMENT_ID	=	$ATTACHMENT_ID_OLD.$ATTACHMENTS["ID"];
				   $ATTACHMENT_NAME	=	$ATTACHMENT_NAME_OLD.$ATTACHMENTS["NAME"];
				}
				else
				{
				   $ATTACHMENT_ID	=	$ATTACHMENT_ID_OLD;
				   $ATTACHMENT_NAME	=	$ATTACHMENT_NAME_OLD;
				}
				$ATTACHMENT_ID		.=	copy_sel_attach($ATTACH_NAME,$ATTACH_DIR,$DISK_ID);
				$ATTACHMENT_NAME	.=	$ATTACH_NAME;
				$上传附件字段名称 = $_POST['通达格式上传文件'];
				//对附件上传字段重新赋值
				$_POST[$上传附件字段名称] = $ATTACHMENT_NAME."||".$ATTACHMENT_ID;
				//print_R($_POST);print_R($_FILES);print_R($ATTACHMENT_NAME);print_R($ATTACHMENT_ID);exit;
			}
			//通达格式上传文件处理结束
		if($action_add=='data')	{
			
				$comma_parse_type=$file_ini[$action]['comma_parse_type'];
				$returnmodel=$file_ini[$action]['returnmodel'];
				require_once('newai.php');
				
				$temp_textarea=explode(',',$_POST[(string)$_POST['comma_parse']]);
				if(isset($_POST['comma_parse'])&&sizeof($temp_textarea)>=2&&$comma_parse_type!='notify')		{
					for($i=0;$i<sizeof($temp_textarea);$i++)		{
						$var=$temp_textarea[$i];
						$_POST[(string)$_POST['comma_parse']]=$var;
						if(isset($var)&&$var!=''&&strlen($var)>1)		{
							$return_sql_line=return_sql_line($fields);
							create_record_newai();//exit;
						}
					}
				}
				else		{
					$_POST[(string)$_POST['comma_parse']]=$_POST[(string)$_POST['comma_parse']];
					$return_sql_line=return_sql_line($fields);
					create_record_newai();
				}
				//直接调转到另一个页面

				if($fields['tablename']=="sellplanmain")			
				{
					print "<script>location='DataQuery/productFrame.php?tablename=sellplanmain_detail&deelname=订单明细&rowid=".$_POST['AUTO_INCREMENT_billid']."'</script>";
					exit;
				}
				if($fields['tablename']=="v_sellone")			
				{
					print "<script>location='DataQuery/productFrame.php?tablename=v_sellonedetail&deelname=店面销售单明细&rowid=".$_POST['AUTO_INCREMENT_billid']."'</script>";
					exit;
				}
				if($fields['tablename']=="customerproduct")			
				{
					print "<script>location='DataQuery/productFrame.php?tablename=customerproduct_detail&deelname=报价单明细&rowid=".$_POST['AUTO_INCREMENT_ROWID']."'</script>";
					exit;
				}
				if($fields['tablename']=="user")			
				{
					print "<script>location='user_newai.php?pageid=1&action=operation_menubatch&selectid=".$_POST['UID']."'</script>";
					exit;
				}
				//显示新增成功页面
				
				$returnmodelArray = explode(',',$returnmodel);
				$returnmodel = $returnmodelArray[0];
				$returnmodelPage = $returnmodelArray[1];
				$return=FormPageAction("action",$returnmodel);
				print_infor($common_html['common_html']['addsuccess'],'trip',"location='?$return'","$returnmodelPage?$return");
				//同时打开一个新窗口
				if($_GET['addlink']=="1")
				{
					if($fields['tablename']=="customer")
						print "<script language='javascript'>window.open('linkman_newai.php?action=add_default&customerid=".$_POST['AUTO_INCREMENT_ROWID']."');</script>";
					else if($fields['tablename']=="supply")
						print "<script language='javascript'>window.open('supplylinkman_newai.php?action=add_default&supplyid=".$_POST['AUTO_INCREMENT_ROWID']."');</script>";
				}
				exit;
			}
		unset($action_add);
		}

		require_once('newai.php');
		$fields['form']['action']="action=".$_GET['action']."_data";
		//$fields['form']['action']=returnpageaction($mode='add_data',array());
		newaiadd('add');
		break;
	case 'edit':
		if(sizeof($action_array)>=3)	{
			$action=$action_array[0]."_".$action_array[1];
			$action_add=$action_array[2];
		}

		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$departprivte=$file_ini[$action]['departprivte'];
		//$showlistnull=$file_ini[$action]['showlistnull'];
		//$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		//$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];
		//$showlistfieldprivate=$file_ini[$action]['showlistfieldprivate'];
		//$showlistfieldlist=returnsystemsetting($tablename,$action,'FIELD_LIST',$showlistfieldlist);
		//$showlistfieldfilter=returnsystemsetting($tablename,$action,'FIELD_FILTER',$showlistfieldfilter);

		$showlistfieldlist	= $file_ini[$action]['showlistfieldlist'];
		
		$showlistnull		= $file_ini[$action]['showlistnull'];
		$showlistfieldfilter= $file_ini[$action]['showlistfieldfilter'];
		$returnsystemprivateconfig = returnsystemprivateconfig($showlistfieldlist,$showlistfieldfilter,$showlistnull,$action_model,$row_element,$bottom_element,$systemorder,$action_search);
		$showlistfieldlist	= $returnsystemprivateconfig['LIST'];;
		$showlistnull		= $returnsystemprivateconfig['NULL'];;
		$showlistfieldfilter= $returnsystemprivateconfig['FILTER'];;
		//print_R($returnsystemprivateconfig);

		$action_model=$file_ini[$action]['action_model'];
		$action_submit=$file_ini[$action]['action_submit'];
		$primarykey=$file_ini[$action]['primarykey'];
		$uniquekey=$file_ini[$action]['uniquekey'];
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$returnmodel=$file_ini[$action]['returnmodel'];
		$hidden_field=$file_ini[$action]['hidden_field'];
		$form_attribute=$file_ini[$action]['form_attribute'];
		$group_user=$file_ini[$action]['group_user'];
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$primarykey_index=$columns[$primarykey];
		$departprivte=$file_ini[$action]['departprivte'];

		//此部分用于有子表的记录使用-在视图中使用列表信息
		$tablename2_title=$file_ini[$action]['tablename2_title'];
		$tablename3_title=$file_ini[$action]['tablename3_title'];
		$tablename2=$file_ini[$action]['tablename2'];
		$tablename3=$file_ini[$action]['tablename3'];
		
		$showlistfieldlist2=$file_ini[$action]['showlistfieldlist2'];
		$showlistfieldlist3=$file_ini[$action]['showlistfieldlist3'];
		
		$childkey2=$file_ini[$action]['childkey2'];
		$childkey3=$file_ini[$action]['childkey3'];
		$columns2=returntablecolumn($tablename2);
		$html_etc2=returnsystemlang($tablename2);
		$columns3=returntablecolumn($tablename3);
		$html_etc3=returnsystemlang($tablename3);
		
		page_css($IE_TITLE);
		//print_R($_GET);exit;
		//通达格式上传:在编辑状态下面删除附件-开始状态
		if($_GET['actionDeleteFile']=="DeleteFile")				{
			global $db;
			$删除附件字段 = $_GET['DeleteField'];
			$primarykey_index_value = $_GET[$primarykey_index];
			$sql="select $删除附件字段 from $tablename where $primarykey_index='$primarykey_index_value'";
			$rs = $db->Execute($sql);
			$删除附件字段值 = $rs->fields[$删除附件字段];
			$删除附件字段数组 = explode('||',$删除附件字段值);
			$ATTACHMENT_ID_OLD		=	$删除附件字段数组[1];
			$ATTACHMENT_NAME_OLD	=	$删除附件字段数组[0];
			//print_R($_GET);exit;
			$ATTACHMENT_ID = $_GET['ATTACHMENT_ID'];
			$ATTACHMENT_NAME = $_GET['ATTACHMENT_NAME'];

			if($ATTACHMENT_NAME!="")
			{
			   require_once('lib/utility_file.php');
			   
			   delete_attach($ATTACHMENT_ID,$ATTACHMENT_NAME);
			   $ATTACHMENT_ID_ARRAY=explode(",",$ATTACHMENT_ID_OLD);
			   $ATTACHMENT_NAME_ARRAY=explode("*",$ATTACHMENT_NAME_OLD);

			   $ARRAY_COUNT=sizeof($ATTACHMENT_ID_ARRAY);
			   for($I=0;$I<$ARRAY_COUNT;$I++)
			   {
				   if($ATTACHMENT_ID_ARRAY[$I]!=$ATTACHMENT_ID&&$ATTACHMENT_ID_ARRAY[$I]!="")
				   {
					   $ATTACHMENT_ID1.=$ATTACHMENT_ID_ARRAY[$I].",";
					   $ATTACHMENT_NAME1.=$ATTACHMENT_NAME_ARRAY[$I]."*";
				   }
			   }
			   $ATTACHMENT_ID	=	$ATTACHMENT_ID1;
			   $ATTACHMENT_NAME	=	$ATTACHMENT_NAME1;
			   $删除附件字段值	=	$ATTACHMENT_NAME."||".$ATTACHMENT_ID;
			   $sql="update $tablename set $删除附件字段='$删除附件字段值' where $primarykey_index='$primarykey_index_value'";
			   $db->Execute($sql);
			   //print_R($ATTACHMENT_ID_ARRAY);
			   //print $sql."<BR>";
			   //print $sql."<BR>";
			   //print $sql."<BR>";
			   //print $sql."<BR>";
			}
		}
		//通达格式上传:在编辑状态下面删除附件-结束状态

		if($_GET['selectid']!="")	{
			$selectid_array=explode(',',$_GET['selectid']);
			$_GET[$primarykey_index]=$selectid_array[0];
		}
		//print_R($_GET);
		$TempIndexNumber = sizeof($action_array)-1;
		if(sizeof($action_array)>=3&&$action_array[$TempIndexNumber]=='data')	{
			//处理通达格式上传文件部分内容
			require_once("lib/utility_file.php");
			if($_POST['通达格式上传文件']!="")		{

				if(count($_FILES)>1)
				{
				   $ATTACHMENTS		=	upload();
				   $CONTENT			=	ReplaceImageSrc($CONTENT, $ATTACHMENTS);
				   $ATTACHMENT_ID	=	$ATTACHMENT_ID_OLD.$ATTACHMENTS["ID"];
				   $ATTACHMENT_NAME	=	$ATTACHMENT_NAME_OLD.$ATTACHMENTS["NAME"];
				}
				else
				{
				   $ATTACHMENT_ID	=	$ATTACHMENT_ID_OLD;
				   $ATTACHMENT_NAME	=	$ATTACHMENT_NAME_OLD;
				}
				$ATTACHMENT_ID		.=	copy_sel_attach($ATTACH_NAME,$ATTACH_DIR,$DISK_ID);
				$ATTACHMENT_NAME	.=	$ATTACH_NAME;
				$上传附件字段名称 = $_POST['通达格式上传文件'];
				//对附件上传字段重新赋值
				$_POST[$上传附件字段名称] = $ATTACHMENT_NAME."||".$ATTACHMENT_ID;
				//print_R($_POST);print_R($_FILES);print_R($ATTACHMENT_NAME);print_R($ATTACHMENT_ID);exit;
			}
			//通达格式上传文件处理结束

			require_once('newai.php');
			$_POST['FUNC_ID_STR']=isset($_POST['FUNC_ID_STR'])?$_POST['FUNC_ID_STR']:$_GET['FUNC_ID_STR'];
			if(sizeof($selectid_array)>2)		{
				for($i=0;$i<sizeof($selectid_array);$i++)		{
					$var=$selectid_array[$i];
					if(isset($var)&&$var!='')		{
						$_GET[$primarykey_index]=$selectid_array[$i];
						$return_sql_line=return_sql_line($fields);
						edit_record_newai();
						
					}
				}
			}
			else		{
				$_POST[(string)$_POST['comma_parse']]=$_POST[(string)$_POST['comma_parse']];
				
				$return_sql_line=return_sql_line($fields);
				
				edit_record_newai();
			}
			//print_R($_POST);
			//print_R($return_sql_line['update_sql']);
			//print_R($selectid_array);
		
			//返回参数列表
		
			if($_GET['searchfield']!=""&&$_GET['searchvalue']!="")		{
				$returnmodel .= "_search";
			}
			
			$returnmodelArray = explode(',',$returnmodel);
			$returnmodel = $returnmodelArray[0];
			$returnmodelPage = $returnmodelArray[1];
			$return=FormPageAction("action",$returnmodel);
			//print $return;
			//exit;
			//exit($returnmodel);
			print_infor($common_html['common_html']['editsuccess'],'trip',"location='?$return'","$returnmodelPage?$return");
			exit;
			unset($action_add);
		}
		
		$_GET[$primarykey_index]=$_GET[$primarykey_index]!=''?$_GET[$primarykey_index]:$_SESSION['LOGIN_USER_ID'];
		require_once('newai.php');
		$fields['form']['action']=FormPageAction("action",$_GET['action']."_data",$primarykey_index,$_GET[$primarykey_index]);
		newaiadd('edit');
		break;
	case 'view':
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		//$showlistnull=$file_ini[$action]['showlistnull'];
		//$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		//$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];

		$showlistfieldlist	= $file_ini[$action]['showlistfieldlist'];
		$showlistnull		= $file_ini[$action]['showlistnull'];
		$showlistfieldfilter= $file_ini[$action]['showlistfieldfilter'];
		$returnsystemprivateconfig = returnsystemprivateconfig($showlistfieldlist,$showlistfieldfilter,$showlistnull,$action_model,$row_element,$bottom_element,$systemorder,$action_search);
		$showlistfieldlist	= $returnsystemprivateconfig['LIST'];;
		$showlistnull		= $returnsystemprivateconfig['NULL'];;
		$showlistfieldfilter= $returnsystemprivateconfig['FILTER'];;

		//此部分用于有子表的记录使用-在视图中使用列表信息
		$subtablecount=$file_ini[$action]['subtablecount'];
		$subtableArray=array();
		for($i=0;$i<$subtablecount;$i++)
		{
			$subtableArray[$i]['subtable_title']=$file_ini[$action]['subtable_title_'.$i];
			$subtableArray[$i]['subtable_name']=$file_ini[$action]['subtable_name_'.$i];
			$subtableArray[$i]['subtable_key']=$file_ini[$action]['subtable_key_'.$i];
			$subtableArray[$i]['subtable_showlistfieldlist']=$file_ini[$action]['subtable_showlistfieldlist_'.$i];
			$subtableArray[$i]['maintable_key']=$file_ini[$action]['maintable_key_'.$i];
			$subtableArray[$i]['subtable_where']=$file_ini[$action]['subtable_where_'.$i];
		}
		
		$columns2=returntablecolumn($tablename2);
		$html_etc2=returnsystemlang($tablename2);
		$columns3=returntablecolumn($tablename3);
		$html_etc3=returnsystemlang($tablename3);
		$columns4=returntablecolumn($tablename4);
		$html_etc4=returnsystemlang($tablename4);
		
		$departprivte=$file_ini[$action]['departprivte'];

		//系统参数设置部分-由于其使用上容易造成不便，此功能，此不开通
		//$showlistfieldlist=returnsystemsetting($tablename,$action,'FIELD_LIST',$showlistfieldlist);
		//$showlistfieldfilter=returnsystemsetting($tablename,$action,'FIELD_FILTER',$showlistfieldfilter);

		$action_model=$file_ini[$action]['action_model'];
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$action_submit=$file_ini[$action]['action_submit'];
		$primarykey=$file_ini[$action]['primarykey'];
		$uniquekey=$file_ini[$action]['uniquekey'];
		$hidden_field=$file_ini[$action]['hidden_field'];
		$merge=$file_ini[$action]['merge'];
		$returnmodel=$file_ini[$action]['returnmodel'];
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$primarykey_index=$columns[$primarykey];

		page_css($IE_TITLE);

		require_once('newai.php');
		$hidden_field_array=explode(',',$hidden_field);
		for($i=0;$i<sizeof($hidden_field_array);$i++)	{
			$element_array=explode(':',(string)$hidden_field_array[$i]);
			$element[(string)$element_array[0]]=$element_array[1];
			$element[(string)$element_array[2]]=$element_array[3];
		}
		if($element['markread']!='')		{
			switch($element['markreadtype'])	{
				case 'addusername':
					markread_record_newai('addusername',$element);
					break;
				case 'makeread':
					markread_record_newai('makeread');
					break;
				case 'makeadd':
					markread_record_newai('makeadd',$element);
					break;
				default:
					markread_record_newai('makeread');
					break;
			}
		}
		newaiadd('view');

		break;

	case 'batchedit':
		if(sizeof($action_array)>=3)
			$action=$action_array[0]."_".$action_array[1];
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$showlistfieldlist	= $file_ini[$action]['showlistfieldlist'];
		$showlistfieldfilter= $file_ini[$action]['showlistfieldfilter'];
		$action_model=$file_ini[$action]['action_model'];
		$action_submit=$file_ini[$action]['action_submit'];
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$returnmodel=$file_ini[$action]['returnmodel'];
		$hidden_field=$file_ini[$action]['hidden_field'];
		$form_attribute=$file_ini[$action]['form_attribute'];
		$group_user=$file_ini[$action]['group_user'];
		page_css($IE_TITLE);
		require_once('newai.php');
		$TempIndexNumber = sizeof($action_array)-1;
		if(sizeof($action_array)>=3 && $action_array[$TempIndexNumber]=='data')	{
			newai_saveBatchedit($fields);
			$return=FormPageAction("action","init_default_search");
			print_infor("批量修改成功！",'trip',"location='?$return'","?$return");
			exit;
		}
		newai_selectfields($fields);
		break;
	case 'report':
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];
		$child_tablename=$file_ini[$action]['child_tablename'];
		$child_partent=$file_ini[$action]['child_partent'];
		$UserDefineFunction=$file_ini[$action]['UserDefineFunction'];
		$child_showlistfieldlist=$file_ini[$action]['child_showlistfieldlist'];
		$child_showlistfieldfilter=$file_ini[$action]['child_showlistfieldfilter'];
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$primarykey=$file_ini[$action]['primarykey'];
		$primarykey_index=$columns[$primarykey];
		page_css("Report",$IE_TITLE);
		@$ReportHeaderTextArray=parse_ini_file("../../Framework/system_config.ini");
		$ReportHeaderText = $ReportHeaderTextArray['ReportTitle'];
		$ReportHeaderText.= "(".$html_etc[$tablename][$tablename].")";
		ReportHeaderHtml($ReportHeaderText,"80%");
		require_once('newai.php');
		$selectid_array=explode(',',$_GET['selectid']);
		foreach($selectid_array as $list)	{
			if(isset($list)&&$list!=''&&!empty($list))		{
				newaireport($fields,$list,"Single");
			}
		}
		break;

	case 'statistics':
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];
		$showlistfieldtype=$file_ini[$action]['showlistfieldtype'];
		$showlistfieldlist1=$file_ini[$action]['showlistfieldlist1'];
		$showlistfieldlist2=$file_ini[$action]['showlistfieldlist2'];
		$showlistfieldlist3=$file_ini[$action]['showlistfieldlist3'];
		$showlistfieldlist4=$file_ini[$action]['showlistfieldlist4'];
		$showlistfieldlist5=$file_ini[$action]['showlistfieldlist5'];
		$showlistfieldlist6=$file_ini[$action]['showlistfieldlist6'];
		$showlistfieldlist7=$file_ini[$action]['showlistfieldlist7'];
		$showlistfieldlist8=$file_ini[$action]['showlistfieldlist8'];
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$primarykey=$file_ini[$action]['primarykey'];
		$UserSumFunction=$file_ini[$action]['UserSumFunction'];
		$UserUnitFunction=$file_ini[$action]['UserUnitFunction'];
		$UserUnitFunctionIndex = $common_html['common_html'][$UserUnitFunction];
		$sum_index=$columns[$UserSumFunction];
		$primarykey_index=$columns[$primarykey];

		page_css("Report",$IE_TITLE);
		//@$ReportHeaderTextArray=parse_ini_file("../../Framework/system_config.ini");
		$ReportHeaderText = $ReportHeaderTextArray['ReportTitle'];
		//$ReportHeaderText.= "(".$html_etc[$tablename][$tablename].")";
		ReportHeaderHtml($ReportHeaderText,"900");
		require_once('newai.php');
		require_once('newai_statistics.php');
		newaistatistics($fields);
		break;

	case 'reportsearch':
		if(sizeof($action_array)>=3)	{
			$action=$action_array[0]."_".$action_array[1];
			$action_add=$action_array[2];
		}
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];
		$showlistfieldfilter2=$file_ini[$action]['showlistfieldfilter2'];
		$showlistfieldlistSearch=$file_ini[$action]['showlistfieldlistSearch'];
		$showlistfieldfilterSearch=$file_ini[$action]['showlistfieldfilterSearch'];
		$showlistfieldfilter2Search=$file_ini[$action]['showlistfieldfilter2Search'];
		$totalnumber=$file_ini[$action]['totalnumber'];
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$primarykey=$file_ini[$action]['primarykey'];
		$primarykey_index=$columns[$primarykey];
		page_css("Report Search",$IE_TITLE);

		if(sizeof($action_array)>=3)	{
			if($action_add=='data')	{
				$showlistfieldlistSearchArray=explode(',',$showlistfieldlistSearch);
				$showlistfieldfilterSearchArray=explode(',',$showlistfieldfilterSearch);
				@$ReportHeaderTextArray=parse_ini_file("../../Framework/system_config.ini");
				$ReportHeaderText = $ReportHeaderTextArray['ReportTitle'];
				$ReportHeaderText.= "(".$html_etc[$tablename][$tablename].")";
				ReportHeaderHtml($ReportHeaderText,"80%");
				require_once('newai.php');
				//报表搜索 SQL 语句输出部分  --开始
				$SQL_ARRAY = array();
				for($i=0;$i<sizeof($showlistfieldlistSearchArray);$i++)		{
					$fieldIndex = $showlistfieldlistSearchArray[$i];
					$fieldName  = $columns[$fieldIndex];
					$fieldText  = $html_etc[$tablename][$fieldName];
					$mode = $showlistfieldfilterSearchArray[$i];
					switch($mode)		{
					case '':
						$SQL_ARRAY[$i]= $fieldName." like '%".$_GET[$fieldName]."%'";
						break;
					case 'input':
						$SQL_ARRAY[$i]= $fieldName." like '%".$_GET[$fieldName]."%'";
						break;
					case 'date':
						$NewFieldName1 = $fieldName."1";
						$NewFieldName2 = $fieldName."2";
						$SQL_ARRAY[$i]= $fieldName.">'".$_GET[$NewFieldName1]."' and ".$fieldName."<'".$_GET[$NewFieldName2]."'";
						break;
					}
				}
				//报表搜索 SQL 语句输出部分  --结束
				$SQL_Text = join(' and ',$SQL_ARRAY);
				$NEWAI_REPORT_SEARCH_SYSTEM = "select * from $tablename where $SQL_Text";
				newaireport($fields,$list,"Multiple");
			}
			unset($action_add);
			}
		else	{
			$_GET[$primarykey_index]=$_GET[$primarykey_index]!=''?$_GET[$primarykey_index]:$_SESSION['LOGIN_USER_ID'];
			require_once('newai.php');
			$fields['form']['action']=FormPageAction("action",$_GET['action']."_data",$primarykey_index,$_GET[$primarykey_index]);
			newaiReportSearch($fields,'');

		}
		break;

	case 'export':
		if(sizeof($action_array)>=3)	{
			$action=$action_array[0]."_".$action_array[1];
			$action_add=$action_array[2];
		}
		
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$action_model=$file_ini[$action]['action_model'];
		$systemorder=$file_ini[$action]['systemorder'];
		$returnmodel=$file_ini[$action]['returnmodel'];
		$primarykey=$file_ini[$action]['primarykey'];
		$hidden_field=$file_ini[$action]['hidden_field'];
		$group_filter=$file_ini[$action]['group_filter'];
		$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];
		$pagenums_model=10000000;
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$primarykey_index=$columns[$primarykey];

		if(sizeof($action_array)>=3)	{
			if($action_add=='data')	{
				$tablename=$_GET['tablename'];
				
				$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
				//$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
				$merge=$file_ini[$action]['merge'];
				$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
				//$showlistfieldlist=$_GET['exportfield'];
				$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];

				$showlistfieldlist_array=explode(',',$showlistfieldlist);
				$showlistfieldfilter_array=explode(',',$showlistfieldfilter);
				//过滤EXPORT数组值
				$exportfield_array=explode(',',$_GET['exportfield']);
				$exportfield_array2 = array();
				for($i=0;$i<sizeof($exportfield_array);$i++)		{
					if($exportfield_array[$i]!="")	{
						array_push($exportfield_array2,$exportfield_array[$i]);
					}
				}
				if(sizeof($exportfield_array2)==0)
					$exportfield_array2[0] = 0;
				$exportfield_array = $exportfield_array2;
				$exportfield = join(",",$exportfield_array2);
				$_GET['exportfield'] = $exportfield;
				
				$showlistfieldlist2_array = array();
				$showlistfieldfilter2_array = array();
				for($i=0;$i<sizeof($showlistfieldlist_array);$i++)		{
					if(in_array($showlistfieldlist_array[$i],$exportfield_array))
					{
						array_push($showlistfieldlist2_array,$showlistfieldlist_array[$i]);
						array_push($showlistfieldfilter2_array,$showlistfieldfilter_array[$i]);
					}	
						
				}
				$showlistfieldlist_array=$showlistfieldlist2_array;
				$showlistfieldfilter_array=$showlistfieldfilter2_array;
				//形成字段文本数组区
				for($i=0;$i<sizeof($exportfield_array);$i++)		{
					$newFieldTextName = $columns[(String)$exportfield_array[$i]];
					$newFieldTextArray[$i] = $newFieldTextName;
					$newFieldNameArray[$i] = $html_etc[$tablename][$newFieldTextName];
				}
				//构建第一行字段列表区
				$RowData['value'][0] = join(',',$newFieldNameArray);
				//$RowData['value'][1] = join(',',$newFieldTextArray);
				//过滤条件导出区
				global $_SESSION;
				//2008-10-18支持多字段的过滤
				for($k=0;$k<sizeof($columns);$k++)					{
					$KeyElement = $columns[$k];
					if($_GET[$KeyElement]!="")		{
						//2008-11-12支持一字段多值的过滤方式
						$GETValue = $_GET[$KeyElement];
						$GETValueArray = explode(',',$GETValue);
						if(sizeof($GETValueArray)>1)		{	//2008-11-12GET值为数组,进行IN判断
							$NewGetArray[] = $KeyElement." IN ('".implode("','", $GETValueArray)."')";
						}
						else		{	//2008-11-12单一值,进行直接判断
							$NewGetArray[] = $KeyElement." like '%".$_GET[$KeyElement]."%'";
						}
						//$NewGetArrayValue[] = $KeyElement."(".$_GET[$KeyElement].")";
						//$PARA_TEMP = (int)$_GET[$KeyElement];
						$PARA_TEMP = substr_cut($_GET[$KeyElement],8).".";//参数做文件名备注使用
						$NewGetArrayValue[] = $KeyElement."(".$PARA_TEMP.")";//参数做文件名备注使用
						//$NewGetArrayValue[] = "[".$KeyElement."]";
					}
					else	if($_GET[$KeyElement."_最小值"]!=""&&$_GET[$KeyElement."_最大值"]!="")		{
						$TEMP_MIN = $_GET[$KeyElement."_最小值"];
						$TEMP_MAX = $_GET[$KeyElement."_最大值"];
						$TEMP_MIN = $TEMP_MIN - 0.001;
						$TEMP_MAX = $TEMP_MAX + 0.001;
						$NewGetArray[] = " $KeyElement >= '$TEMP_MIN' and $KeyElement <= '$TEMP_MAX'";
					}
					else	if($_GET[$KeyElement."_开始时间"]!=""&&$_GET[$KeyElement."_结束时间"]!="")		{
						$TEMP_MIN = $_GET[$KeyElement."_开始时间"];
						$TEMP_MAX = $_GET[$KeyElement."_结束时间"];
						$NewGetArray[] = " $KeyElement >= '$TEMP_MIN' and $KeyElement <= '$TEMP_MAX'";
					}
				}
				//2009-12-24支持搜索字段过滤
				if($_GET['searchfield']!=""&&$_GET['searchvalue']!="")					{
					
					$key=array_search(trim($_GET['searchfield']), $columns);
					$key=array_search($key, $showlistfieldlist_array);
					$filter_array=explode(":", $showlistfieldfilter_array[$key]);
					if($filter_array[0]=='tablefiltercolor' || $filter_array[0]=='tablefilter')
					{
						global $db;
						$foreigncolumns=returntablecolumn($filter_array[1]);
						$insql="select ".$foreigncolumns[$filter_array[2]]." from ".$filter_array[1]." where ".$foreigncolumns[$filter_array[3]]." like '%".trim($_GET['searchvalue'])."%'";
						$SearchValueSQL = " and ".$_GET['searchfield']." in (".$insql.")";
						$NewGetArrayValue[] = "(".$_GET['searchvalue'].")";
					}
					else 
					{
						$SearchValueSQL = " and ".$_GET['searchfield']." like '%".$_GET['searchvalue']."%'";
						$NewGetArrayValue[] = "(".$_GET['searchvalue'].")";
					}
				}
				else		{
					$SearchValueSQL = '';
				}

				//形成WHERE SQL字段
				if($NewGetArray[0]!="")				{
					$WhereText = "where ".join(' and ',$NewGetArray).$SearchValueSQL;;
				}
				else	{
					$WhereText = "where 1=1".$SearchValueSQL;
				}
				
				//2009-12-9日增加,主要用于客户前台页面SQL语句定制
				global $SYSTEM_ADD_SQL;
				if($SYSTEM_ADD_SQL!="")			{
					$WhereText .= " ".$SYSTEM_ADD_SQL;
				}
				
				//形成排序的字段列表
				if($systemorder!="")						{//如果定义则执行定义的排序字段
					$systemorderArray = explode(',',$systemorder);
					for($xx=0;$xx<sizeof($systemorderArray);$xx++)		{
						$KeyOrderSqlIndexArray = explode(':',$systemorderArray[$xx]);
						$KeyOrderSqlIndexName = $KeyOrderSqlIndexArray[0];
						$KeyOrderSqlIndexOrderDesc = $KeyOrderSqlIndexArray[1];
						$OrderSQLARRAY[$xx] = $columns[$KeyOrderSqlIndexName]." ".$KeyOrderSqlIndexOrderDesc;
					}
					$OrderSQLText = join(',',$OrderSQLARRAY);
				}
				else  {//如果没有定义,则安主KEY的顺序进行排序
					$OrderSQLText = $columns[$primarykey];
				}

				//形成字段文本区,以构建SQL语句
				$newFieldText = join(',',$newFieldTextArray);
				$sql = "select $newFieldText from $tablename $WhereText order by ".$OrderSQLText."";
				//print $sql;exit;
				$rs = $db->CacheExecute(150,$sql);
				$rs_a = $rs->GetArray();
				
				$filterColumnsArray=array();
				$funcColumnsArray=array();
				for($i=0;$i<sizeof($exportfield_array);$i++)	{
					
					$TextFieldIndex = $exportfield_array[$i];
					$TextField = $columns[$TextFieldIndex];
					$getExportKeyFilterArray = explode(':',$showlistfieldfilter_array[(String)$i]);
					switch($getExportKeyFilterArray[0])		
					{
						case 'tablefilter':
						case 'tablefiltercolor':
						case 'radiofilter':	
							$ExportKeycolumns=returntablecolumn($getExportKeyFilterArray[1]);
							$ExportFieldCode = $ExportKeycolumns[(String)$getExportKeyFilterArray[2]];
							$ExportFieldName = $ExportKeycolumns[(String)$getExportKeyFilterArray[3]];
							$filterColumnsArray[$TextField]['tablename']=$getExportKeyFilterArray[1];
							$filterColumnsArray[$TextField]['what']=$ExportFieldCode;
							$filterColumnsArray[$TextField]['return']=$ExportFieldName;
							break;
						case 'userdefine':
							$funcColumnsArray[$TextField]['userdefine']=$getExportKeyFilterArray[1];
							break;
					}
							
				}
				
				
			

				//对已经有的结果集进行过滤运算,主要是tablefilter,boolean两种过滤算法
				for($k=0;$k<sizeof($rs_a);$k++)		
				{
					foreach($filterColumnsArray as $key=>$value)
					{
						$rs_a[$k][$key]=returntablefield($value['tablename'], $value['what'], $rs_a[$k][$key], $value['return']);
					}
					foreach($funcColumnsArray as $key=>$value)
					{
						
						$functionName = $value['userdefine'];
						$fileName = $functionName.".php";
						$fileName = "userdefine/$fileName";
						
						if(file_exists($fileName))		{
							require_once($fileName);
							$functionName = $functionName."_Value";
							if(function_exists($functionName))	{
								
								$fields['value']=$rs_a;
								$rs_a[$k][$key] = strip_tags($functionName($rs_a[$k][$key],$fields,$k));
							}
						}
						
					}
					foreach($rs_a[$k] as $key=>$value)
					{
						if(stristr($value, ","))
						{
							$rs_a[$k][$key] = str_replace(",", "，", $value);
					
						}
						if(stristr($value, "\r"))
						{
							$rs_a[$k][$key] = str_replace("\r", "\\r", $value);
					
						}
						if(stristr($value, "\n"))
						{
							$rs_a[$k][$key] = str_replace("\n", "\\n", $value);
					
						}
					}
				
					//对用户要求的显示的字段进行过滤
					$RowData['value'][] = join(',',$rs_a[$k]);
					
				}
				//print_R($RowData);exit;
				//构建导出文件的名称
				$RowData['tablename'] = $tablename;
				//print_R($NewGetArrayValue);
				$RowData['FileNameAttachment'] = @join('',$NewGetArrayValue);
				$RowData['FileNameAttachment'] = ereg_replace('/','',$RowData['FileNameAttachment']);
				$RowData['FileNameAttachment'] = ereg_replace('\*','',$RowData['FileNameAttachment']);
				$RowData['FileNameAttachment'] = substr($RowData['FileNameAttachment'],0,220);
				$RowData['RowValueLenght'] = $RowValueLenght;
				require_once('newai.php');
				//print_R($RowData);exit;
				//print_R($exportfield_array);
				//print $RowData['FileNameAttachment'];
				//print_R($RowData['value']);
				//exit;
				$总行数 =	sizeof($RowData['value']);
				//print $总行数;exit;
				if($_GET['method']=="CSV")	{
					export_newai_CSV($RowData);
				}
				else	{
					if($总行数>16382)			{
						export_newai_CSV($RowData,'[导出数据超过16382行,强制使用CSV格式导出]');
					}
					else	{
						export_newai_XLS($RowData);//导出EXCEL
					}
				}
				exit;
			}
			unset($action_add);
		}

		page_css($IE_TITLE);
		require_once('newai.php');
		newai_export($fields,'content');
		break;

	case 'import':
		//print_R($action_array);
		if(sizeof($action_array)>=3)	{
			$action=$action_array[0]."_".$action_array[1];
			$action_add=$action_array[2];
		}
		@set_time_limit(0);
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$action_model=$file_ini[$action]['action_model'];
		$returnmodel=$file_ini[$action]['returnmodel'];
		$primarykey=$file_ini[$action]['primarykey'];
		$uniquekey=$file_ini[$action]['uniquekey'];
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$foreignkey=$file_ini[$action]['foreignkey'];
		$hidden_field=$file_ini[$action]['hidden_field'];
		$importgroup=$file_ini[$action]['importgroup'];
		$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];
		$pagenums_model=10000000;
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$primarykey_index=$columns[$primarykey];
		//附加，用于过滤组选择的变量
		$importgroupArray = explode(':',$importgroup);
		$showfieldIndex = $importgroupArray[0];
		$showFieldName = $columns[$showfieldIndex];
		$showfieldTableName = $importgroupArray[1];
		$showfieldColumns = returntablecolumn($showfieldTableName);
		$showfieldIndexValue = $importgroupArray[2];
		$showfieldIndexName = $importgroupArray[3];
		$showfieldIndexValue = $showfieldColumns[$showfieldIndexName];
		$showfieldIndexName = $showfieldColumns[$showfieldIndexName];


		//print_R($action_array);
		//print_R($HTTP_POST_FILES['uploadfile']['tmp_name']);
		//print_R($_POST);
		is_uploaded_file($_FILES['uploadfile']['tmp_name']);
		print $_FILES['uploadfile']['tmp_name'];

		//print_R(file($TempFile));
		//unlink($TempFile);

		if(sizeof($action_array)>=3)	{
			if($action_add=='data')	{
				require_once('newai.php');
				//上传有EXCEL格式文件时调用XLS解析器,否则按CSV格式处理
				if(is_uploaded_file($_FILES['uploadfileXLS']['tmp_name']))			{
					newai_import_XLS($columns);
				}
				else	{
					newai_import_CSV($columns);
				}
				exit;
			}
			unset($action_add);
		}

		page_css($IE_TITLE);

		require_once('newai.php');
		newai_import($fields,'content');
		print_hidden($tablename,'tablename');
		break;
	case 'init':
		
		$_SESSION['SYSTEM_INITVIEW_SEARCH_VALUE_DEFAULT']='';
		if(sizeof($action_array)>=3)	{
			$action=$action_array[0]."_".$action_array[1];
			$action_add=$action_array[2];
		}
		
		$location_title='sunshine_inside';

		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$tablewidth=$file_ini[$action]['tablewidth'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$ondblclick_config=$file_ini[$action]['ondblclick_config'];
		$onclick_config=$file_ini[$action]['onclick_config'];
		$init_type=$file_ini[$action]['init_type'];
		$array_show=$file_ini[$action]['array_show'];
		$returnmodel=$file_ini[$action]['returnmodel'];
		$read_type=$file_ini[$action]['read_type'];
		$nullshow=$file_ini[$action]['nullshow'];
		$systemorder=$file_ini[$action]['systemorder'];
		$row_element=$file_ini[$action]['row_element'];
		$row_userpriv=$file_ini[$action]['row_userpriv'];
		$bottom_element=$file_ini[$action]['bottom_element'];
		$departprivte=$file_ini[$action]['departprivte'];
		$pagenums_model=$file_ini[$action]['pagenums_model'];
		$pagestop_model=$file_ini[$action]['pagestop_model'];
		$export_port_arrribute=$file_ini[$action]['export_port_arrribute'];
		$merge=$file_ini[$action]['merge'];
		$UserUnitFunction=$file_ini[$action]['UserUnitFunction'];
		$ForeignKeyIndex=$file_ini[$action]['ForeignKeyIndex'];
		$UserUnitFunctionIndex = $common_html['common_html'][$UserUnitFunction];

		$action_model=$file_ini[$action]['action_model'];
		$action_search=$file_ini[$action]['action_search'];
		$group_filter=$file_ini[$action]['group_filter'];
		$child_filter=$file_ini[$action]['child_filter'];
		$UserDefineFunction=$file_ini[$action]['UserDefineFunction'];
		$UserSumFunction=$file_ini[$action]['UserSumFunction'];
		$UserSumFunctionList=explode(":", $UserSumFunction);

		$UserSumFunction=$UserSumFunctionList[0];
		$UserUnitFunction=$UserSumFunctionList[1];

		//$UserUnitFunction=$file_ini[$action]['UserUnitFunction'];
		//$UserUnitFunctionIndex = $common_html['common_html'][$UserUnitFunction];

		$email_filter=$file_ini[$action]['email_filter'];
		$sms_filter=$file_ini[$action]['sms_filter'];
		$hidden_field=$file_ini[$action]['hidden_field'];
		$group_user=$file_ini[$action]['group_user'];
		$edit_attribute=$file_ini[$action]['edit_attribute'];
		$primarykey=$file_ini[$action]['primarykey'];
		$uniquekey=$file_ini[$action]['uniquekey'];
		$childnums=$file_ini[$action]['childnums'];

		$showlistfieldlist	= $file_ini[$action]['showlistfieldlist'];
		$showlistnull		= $file_ini[$action]['showlistnull'];
		$showlistfieldfilter= $file_ini[$action]['showlistfieldfilter'];

		$showlistfieldstopedit= $file_ini[$action]['showlistfieldstopedit'];
		$showlistfieldstopdelete= $file_ini[$action]['showlistfieldstopdelete'];

		$returnsystemprivateconfig = returnsystemprivateconfig($showlistfieldlist,$showlistfieldfilter,$showlistnull,$action_model,$row_element,$bottom_element,$systemorder,$action_search);
		$showlistfieldlist	= $returnsystemprivateconfig['LIST'];;
		$showlistnull		= $returnsystemprivateconfig['NULL'];;
		$showlistfieldfilter= $returnsystemprivateconfig['FILTER'];;
		$pagenums_model		= $returnsystemprivateconfig['pagenums_model'];;
		$row_element		= $returnsystemprivateconfig['row_element'];;
		$bottom_element		= $returnsystemprivateconfig['bottom_element'];;
		$action_model		= $returnsystemprivateconfig['action_model'];;
		$action_search		= $returnsystemprivateconfig['action_search'];;
		$systemorder		= $returnsystemprivateconfig['systemorder'];;
		$已配置信息			= $returnsystemprivateconfig['已配置信息'];;



		//专业科科长,以及副科长权限时进行生成,所有系统只能有查看权限
		//2010-4-3加入分管校长的查看权限,并行使用SUNSHINE_BANJI_LIST属性
		//在INI文件由系统进行对action_model row_element bottom_element等几个变量进行重新定义
		if($_SESSION['SUNSHINE_BANJI_LIST']=="N")		{
			$_SESSION['SUNSHINE_BANJI_LIST'] = "";
		}
		if($_SESSION['LOGIN_PHPSESSID']=="N")		{
			$_SESSION['LOGIN_PHPSESSID'] = "";
		}
		if(STRLEN($_SESSION['SUNSHINE_BANJI_LIST'])>4&&$_SESSION['LOGIN_USER_ID']!="admin")		{
			$row_element_array = explode(',',$row_element);
			if(in_array("view:view_default",$row_element_array))			{
				$row_element = 'view:view_default';
			}
			if(in_array("view:view_customer",$row_element_array))			{
				$row_element = 'view:view_customer';
			}
			$action_model = '';
			$bottom_element = '';
			$_GET['系统说明'] = "备注:以下仅是针对".$_SESSION['SUNSHINE_BANJI_LIST']."相关的信息,仅用于综合信息查询模块.";
		}

		//session_register("指定人员");
		//session_register("指定人员_FILENAME");
		$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
		$PHP_SELF_FILE  = array_pop($PHP_SELF_ARRAY);
		if($_GET['指定人员']!="")											{
			$_SESSION['指定人员'] = $_GET['指定人员'];
			$_SESSION['指定人员_FILENAME'] = $PHP_SELF_FILE;
		}
		elseif($_SESSION['指定人员_FILENAME']==$PHP_SELF_FILE)	{
			//$_SESSION['指定人员'] = '';
		}
		else	{
			$_SESSION['指定人员'] = '';
			$_SESSION['指定人员_FILENAME'] = '';
		}
		if($_SESSION['指定人员']!="")		{
			$row_element_array = explode(',',$row_element);
			if(in_array("view:view_default",$row_element_array))			{
				$row_element = 'view:view_default';
			}
			if(in_array("view:view_customer",$row_element_array))			{
				$row_element = 'view:view_customer';
			}
			$action_model = '';
			$bottom_element = '';
			$_GET['系统说明'] = "备注:以下仅是针对 ".returntablefield("user","USER_ID",$_SESSION['指定人员'],"USER_NAME")." 相关的信息,仅用于综合信息查询模块.";

		}

		//session_register("指定班号");
		//session_register("指定班号_FILENAME");
		$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
		$PHP_SELF_FILE  = array_pop($PHP_SELF_ARRAY);
		if($_GET['指定班号']!="")											{
			$_SESSION['指定班号'] = $_GET['指定班号'];
			$_SESSION['指定班号_FILENAME'] = $PHP_SELF_FILE;
		}
		elseif($_SESSION['指定班号_FILENAME']==$PHP_SELF_FILE)	{
			//$_SESSION['指定班号'] = '';
		}
		else	{
			$_SESSION['指定班号'] = '';
			$_SESSION['指定班号_FILENAME'] = '';
		}
		//print_R($_SESSION);
		if($_SESSION['指定班号']!="")		{
			$row_element_array = explode(',',$row_element);
			if(in_array("view:view_default",$row_element_array))			{
				$row_element = 'view:view_default';
			}
			if(in_array("view:view_customer",$row_element_array))			{
				$row_element = 'view:view_customer';
			}
			$action_model = '';
			$bottom_element = '';
			$_GET['系统说明'] = "备注:以下仅是针对 ".$_SESSION['指定班号']." 相关的信息,仅用于综合信息查询模块.";
		}
		//$columns=returntablecolumn($tablename);//print_R($SYTEM_CONFIG_TABLE);
		//$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		//用户自定义SQL语句时的虚拟表字段获取
		global $NEWAIINIT_VALUE_SYSTEM;
		global $NEWAIINIT_VALUE_SYSTEM_NUM;
		global $NEWAIINIT_VALUE_SYSTEM_SUM;

		if(strlen($NEWAIINIT_VALUE_SYSTEM)>10)			{

			$USER_DEFINE_SQL_ARRAY = explode('from',$NEWAIINIT_VALUE_SYSTEM);
			$USER_DEFINE_SQL_ARRAY = explode('select',$USER_DEFINE_SQL_ARRAY[0]);
			$USER_DEFINE_SQL_ARRAY = explode('from',$USER_DEFINE_SQL_ARRAY[1]);
			$USER_DEFINE_SQL_ARRAY = explode(',',$USER_DEFINE_SQL_ARRAY[0]);
			for($sql_array=0;$sql_array<sizeof($USER_DEFINE_SQL_ARRAY);$sql_array++)	{
				$Element = TRIM($USER_DEFINE_SQL_ARRAY[$sql_array]);
				//print "<font color=red>".$Element."</font><BR>";
				//过滤' '
				$Element = explode(' ',$Element);
				$Array_index = sizeof($Element);
				if(TRIM($Element[$Array_index-1])=="")
					$Element = TRIM($Element[0]);
				else
					$Element = TRIM($Element[$Array_index-1]);
				//print $Element."<BR>";
				//过滤'.'
				$Element = explode('.',$Element);
				$Array_index = sizeof($Element);
				if(TRIM($Element[$Array_index-1])=="")
					$Element = TRIM($Element[0]);
				else
					$Element = TRIM($Element[$Array_index-1]);
				//$Element = explode('.',$Element);
				//$Element = $Element[1];
				//print $Element."<BR>";
				$columns[$sql_array] = $Element;
			}
			//print_R($USER_DEFINE_SQL_ARRAY);
		}

		//自开始
		
		$primarykey_index=$columns[$primarykey];
		if(sizeof($action_array)>=3)	{
			//	$action_model=$action_model.",$action";
		}
		
		switch($init_type)			{
			case 'array_show':
				page_css($IE_TITLE);
				require_once('newai.php');
				//showpageheader_new($common_html['common_html']['set']." $tablename","person_info.gif");
				array_show();
				exit;
				break;
		}

		page_css($IE_TITLE);
		
		require_once('newai.php');
		
		newaiinit($fields,$mode);
		//在显示弹出明细窗口时下面出现的关闭按钮
		if($_GET['action_close']=="close")		{
			print "<BR><div align=center><INPUT class=SmallButton onclick=self.close(); type=button value='".$common_html['common_html']['close']."'</div>";
		}
		//用户自定义设计部分,此部分允许自己定义某些显示特性
		$允许自定义的类型列表 = array("init_default","init_customer","add_default","edit_default","view_default");
		if(in_array($_GET['action'],$允许自定义的类型列表)&&$_SESSION['LOGIN_USER_ID']=='admin')			{
			if($parse_filename=="")		$parse_filename = $tablename;
			$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
			//print_R($PHP_SELF_ARRAY);
			$FILE_SELF_NAME = array_pop($PHP_SELF_ARRAY);
			$FileDirName = array_pop($PHP_SELF_ARRAY);
			$是否是接口目录 = array_pop($PHP_SELF_ARRAY);
			$现在时间 = time();
			$执行时间 = ($现在时间-$SYSTEM_EXEC_TIME)*1000/60;
			$执行时间 = number_format($执行时间, 2, '.', '');
			$执行时间TEXT = "执行:".$执行时间."MS";;
			if($是否是接口目录=="Interface"&&$FileDirName!="PGSQL")		{
				//print "<BR><div align=center><a href=\"../CONFIG/config.php?".base64_encode("XX=XX&action=".$_GET['action']."&Tablename=$tablename&FileIniname=$parse_filename&FileDirName=$FileDirName&actionconfig=config&GOBACKFILENAME=$FILE_SELF_NAME")."\" title='配置当前页面显示参数 $执行时间TEXT (此信息只在admin用户下面显示)'>定制当前页面的字段显示及界面布局[".$执行时间TEXT."]".$已配置信息."</a>&nbsp;<a href=\"http://edu.tongda2000.com/book/index.php\" target=_blank title='将问题反馈给开发商进行解决(此信息只在admin用户下面显示)'>反馈问题及提出需求</a></div>";
				//print "<BR><div align=center>$执行时间TEXT</div>";
			}
			else if($是否是接口目录=="Interface"&&$FileDirName=="PGSQL")		{
				//print "<BR><div align=center>$执行时间TEXT</div>";
			}
		}

		//显示系统设计接口
		//print $parse_filename;
		$总角色数组 = explode(',',$_SESSION['LOGIN_USER_PRIV'].",".$_SESSION['LOGIN_USER_PRIV_OTHER']);
		if($SYSTEM_MODE=="1"&&$FileDirName!="PGSQL"&&in_array('1',$总角色数组))			{
			if($parse_filename=="")		{
				$parse_filename = $tablename;
			}
			$SCRIPT_FILENAME = ereg_replace('/','\\',$_SERVER['SCRIPT_FILENAME']);
			$SCRIPT_FILENAME_ARRAY = explode('\\',$SCRIPT_FILENAME);
			$MODULE_ARRAY_NAME = array_pop($SCRIPT_FILENAME_ARRAY);
			$MODULE_ARRAY_NAME = array_pop($SCRIPT_FILENAME_ARRAY);
			print "<BR><div align=center><a href=\"../../Development/main.php?MakeSystemModel=$MODULE_ARRAY_NAME&userdb=$userdb&Tablename=$tablename&FileIniname=$parse_filename\" target=_blank><font color=red>点击配置</font></a><BR>
			<input type=text readonly class=SmallInput value='$SCRIPT_FILENAME' size=95/>
			</div>";
		}

		break;
	case 'delete':
			$action_array=explode('_',$action);
			$tablename=$file_ini[$action]['tablename'];
			$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
			$primarykey=$file_ini[$action]['primarykey'];
			$returnmodel=$file_ini[$action]['returnmodel'];
			$hidden_field=$file_ini[$action]['hidden_field'];
			$passwordcheck=$file_ini[$action]['passwordcheck'];
			$delete_attribute=$file_ini[$action]['delete_attribute'];
			$showlistfieldfilter=$file_ini['init_default']['showlistfieldfilter'];
			$showlistfieldlist=$file_ini['init_default']['showlistfieldlist'];
			
			$columns=returntablecolumn($tablename);
			$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
			$primarykey_index=$columns[$primarykey];
			//print $passwordcheck;
			if($passwordcheck=="1"&&$_GET['actionAdvDelete']!="AdvDelete"&&$_GET['actionAdvDelete']!="InforCheck")				{
				page_css("密码二次验证");
				print "<body onload=\"document.form1.PASSWORD.focus();\">\n";
				//Array ( [action] => delete_array [returnmodel] => init_default [selectid] => 412, [pageid] => 1
				print "<form name=form1 action=\"?XX=XX&actionAdvDelete=InforCheck&action=delete_array&returnmodel=init_default&selectid=".$_GET['selectid']."\" method=post encType=multipart/form-data>";
				table_begin("500");
				print_title("请输入您的用户密码,属于关键性操作,需要进行二次密码验证");
				print "<tr class=TableData><td width=25%>&nbsp;您的密码:</td><td>
						<input type=password name='PASSWORD' class=SmallInput >
						(您当前的登录密码)</td></tr>";
				print_submit("提交");
				table_end();
				form_end();
				//print_R($_GET);
				exit;
			}
			else if($passwordcheck=="1"&&$_GET['actionAdvDelete']=="InforCheck")				{
				page_css("密码二次验证");
				global $db;
				//print_R($_SESSION);
				$LOGIN_USER_ID	= $_SESSION['LOGIN_USER_ID'];
				$返回当前用户的密码 = returntablefield("user","USER_ID",$LOGIN_USER_ID,"PASSWORD");
				//$PASSWORD		= md5(TRIM($_POST['PASSWORD']));
				//$sql			= "select USER_ID from user where USER_ID='$LOGIN_USER_ID' and PASSWORD='$PASSWORD'";
				//print $sql;exit;
				//$rs				= $db->Execute($sql);
				//$USER_ID_STR	= $rs->fields['USER_ID'];
				//if($USER_ID_STR!="")			{
				//兼容CRYPT和MD5两种加密方式
				if(
					crypt(TRIM($_POST['PASSWORD']),$返回当前用户的密码)==$返回当前用户的密码
					||
					MD5(TRIM($_POST['PASSWORD']))==$返回当前用户的密码
					)		{
					//密码较验成功
					$JUMP_URL = "?XX=XX&actionAdvDelete=AdvDelete&action=".$_GET['action']."&selectid=".$_GET['selectid']."&returnmodel=".$_GET['returnmodel']."&pageid=".$_GET['pageid']."";
					print_infor("密码正确,系统将执行你的操作!",'',"location='$JUMP_URL'");
					print "<META HTTP-EQUIV=REFRESH CONTENT='$SYSTEM_SECOND;URL=$JUMP_URL'>\n";
				}
				else		{
					//密码较验失败
					$JUMP_URL = "?XX=XX&action=init_default&pageid=".$_GET['pageid']."";
					print_infor("密码不正确,系统将返回....",'',"location='$JUMP_URL'");
					print "<META HTTP-EQUIV=REFRESH CONTENT='$SYSTEM_SECOND;URL=$JUMP_URL'>\n";
				}
				//print_R($_POST);print_R($_GET);
				exit;
			}

			//print_R($passwordcheck);exit;

			$action=($_GET['action']=='delete_group')?$action:'delete_array';
			switch($_GET['action'])			{
				case 'delete_group':
				case 'delete_inbox':
				case 'delete_outbox':
				case 'delete_array':
					$action=$_GET['action'];
					break;
				default:
					$action='delete_array';
			}
			
			page_css($IE_TITLE);
			require_once('newai.php');

			if($action_array[1]=='array'||$action_array[1]=='inbox'||$action_array[1]=='outbox')	{
				$selectid_array=explode(',',$_GET['selectid']);
				
				//判断外键关联，禁止删除
				$ForeignKeyIndex=($file_ini['init_default']['ForeignKeyIndex']);
				$ForeignKeyIndexArray=explode(',',$ForeignKeyIndex);
				
				foreach($selectid_array as $id)	{
					if(!empty($id))
					{
						foreach((array)$ForeignKeyIndexArray as $item)
						{
							$tempArray=explode(':',$item);
							if(sizeof($tempArray)==3)
							{
								$relatTableName=$tempArray[1];
								$tableColumns=returntablecolumn($tempArray[1]);
								$relatTableField=$tableColumns[$tempArray[2]];
								$tableColumns=returntablecolumn($fields['tablename']);
								$mainField=$tableColumns[$tempArray[0]];
								$sql="select count(*) from $relatTableName where $relatTableField =(select $mainField from ".$fields['tablename']." where ".$fields['table']['primarykeyindex']."=$id)";
								$num=$db->GetOne($sql);
								if(intval($num)>0)
								{
									$ForeignKeyIndexTableNameMEMO = returntablefield("systemlang","tablename",$relatTableName,"chinese","fieldname",$relatTableName);
									echo "<script>alert('在[".$ForeignKeyIndexTableNameMEMO."]模块中有关联数据，不能删除！');history.back(-1);</script>";
									exit;
								}
							}

						}
					}
				}
				foreach($selectid_array as $list)	{
					if(isset($list)&&$list!=''&&!empty($list))		{
						delete_array_newai($list,$fields);
					}
				}//end for
			}
			else if($action_array[1]=='group')	{
				$group_user=$file_ini[$action]['group_user'];
				exist_group_user();
			}
			else if(strlen($action_array[1])>=3)	{
				delete_array_newai($_GET[$primarykey_index],$fields);
			}
			else	{
			}
			$returnmodel=isset($_GET['returnmodel'])?$_GET['returnmodel']:$returnmodel;
			$_GET['returnmodel']=$returnmodel;

			if($_GET['searchfield']!=""&&$_GET['searchvalue']!="")		{
				$_GET['returnmodel'] .= "_search";
			}
			$_GET = array_diff_assoc($_GET,array("actionAdvDelete"=>"AdvDelete"));
			$_GET['selectid'] = '';
			$return=FormPageAction("action",$_GET['returnmodel'],'','','selectid');
			//print_R($_GET);exit;
			print_infor($common_html['common_html']['deletesuccess'],'trip',"location='?$return'","?$return");
			//pageindexo();
		break;

	case 'charts':
		$action_model=$file_ini[$action]['action_model'];
		$tablename=$file_ini[$action]['tablename'];
		$tabletitle=$file_ini[$action]['tabletitle'];
		$tablewidth=$file_ini[$action]['tablewidth'];
		$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];
		$showlistfieldtype=$file_ini[$action]['showlistfieldtype'];
		page_css($IE_TITLE);
		require_once('newai.php');
		require_once('newai_charts.php');
		//print_R($file_ini[$action]);;
		$ReportHeaderText = "图表信息统计与汇总";
		ReportHeaderHtml($ReportHeaderText,"810");
		newaiCharts();
		break;

	case 'set':
		$_GET['table_name']=isset($_GET['table_name'])?$_GET['table_name']:$tablename;
		$_GET['table_action']=isset($_GET['table_action'])?$_GET['table_action']:$_GET['action'];
		$_GET['action']=isset($_GET['action'])?$_GET['action']:'set_default';
		$_GET['field_list']=isset($_GET['field_list'])?$_GET['field_list']:null;
		$action=$_GET['table_action'];

		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$showlistnull=$file_ini[$action]['showlistnull'];
		$showlistfieldlist=$file_ini[$action]['showlistfieldlist'];
		$returnmodel=$file_ini[$action]['returnmodel'];
		if($returnmodel=='')	$returnmodel=$_GET['returnmodel'];
		$showlistfieldfilter=$file_ini[$action]['showlistfieldfilter'];
		$primarykey_index=$columns[$primarykey];
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		page_css($IE_TITLE);
		require_once('systemsetting.php');

		if(sizeof($action_array)>=3&&$action_array[2]!='config')	{

			$formnewvar=formnewvar($file_ini[$action],$_GET['FLD_STR']);
			updatesystemsetting($formnewvar);
			$return=returnpageaction($mode='edit_init',array('index_name'=>'action','index_id'=>$returnmodel));
			print_infor($common_html['common_html']['setsuccess'],'trip',"location='?$return'","?$return");
			exit;
		}
		else if(sizeof($action_array)>=3&&$action_array[2]=='config')		{
			usesystemsetting();
			$return=FormPageAction("action",$returnmodel);
			//$return=returnpageaction($mode='edit_init',array('index_name'=>'action','index_id'=>$returnmodel));
			print_infor($common_html['common_html']['systemconfigsuccess'],'trip',"location='?$return'","?$return");
			exit;
		}

		$showlistfieldlist_array=explode(',',$showlistfieldlist);
		for($i=0;$i<sizeof($showlistfieldlist_array);$i++)			{
			$value['record'][$i]['name']=$html_etc[$tablename][(string)$columns[''.$showlistfieldlist_array[$i].'']];
			$value['record'][$i]['value']=$showlistfieldlist_array[$i];
		}

		//$showlistfieldlist=returnsystemsetting($tablename,$action,'FIELD_LIST',$showlistfieldlist);
		//$showlistfieldlist_array=explode(',',$showlistfieldlist);

		$value['table_name']=$tablename;
		$value['table_action']=$_GET['table_action'];
		$value['titleleft']=$common_html['common_html']['yoursetinfor'];
		$value['titleright']=$common_html['common_html']['originalinfor'];
		systemsetting_view($value);
		break;


	case 'listtwo':
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$tablename_one=$file_ini[$action]['tablename_one'];
		$tablename_two=$file_ini[$action]['tablename_two'];
		$link=$file_ini[$action]['link'];
		page_css($IE_TITLE);
		require_once('newai.php');
		newai_list_two();
		break;
	case 'listone':
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$tablename_one=$file_ini[$action]['tablename_one'];
		$link=$file_ini[$action]['link'];
		page_css($IE_TITLE);
		require_once('newai.php');
		newai_list_one();
		break;
	case 'tree':
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$tablename_one=$file_ini[$action]['tablename_one'];
		$tablename_two=$file_ini[$action]['tablename_two'];
		$tablename_three=$file_ini[$action]['tablename_three'];
		$link=$file_ini[$action]['link'];
		require_once('newai.php');
		newai_tree();
		break;
	case 'framework':
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$menu_top=$file_ini[$action]['menu_top'];
		$primary=$file_ini[$action]['primary'];
		project_framework($mode='project_framework');
		break;
	case 'menutop':
		$tablename=$file_ini[$action]['tablename'];
		$SYTEM_CONFIG_TABLE!="" ? $tablename = $SYTEM_CONFIG_TABLE : '';
		$columns=returntablecolumn($tablename);
		$html_etc=returnsystemlang($tablename,$SYTEM_CONFIG_TABLE);
		$menu_top=$file_ini[$action]['menu_top'];
		$primary=$file_ini[$action]['primary'];
		project_framework($mode='project_fw_menu');
		break;

}
$ExecTimeEnd=getmicrotime();
$ExecTime=$ExecTimeEnd-$ExecTimeBegin;
//print substr($ExecTime,0,8)." S";


$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
$PHP_SELF_TEXT = array_pop($PHP_SELF_ARRAY);
//print "<a href='StudentFileNew.php?dir=.&editfile=$PHP_SELF_TEXT&n=1' class=OrgAdd target=_blank>$PHP_SELF_TEXT</a>";

//注册提示
@require_once("lib/version.php");

//定义显示文本
$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
array_pop($PHP_SELF_ARRAY);
array_shift($PHP_SELF_ARRAY);
//print_R($PHP_SELF_ARRAY);
if(in_array("TDLIB",$PHP_SELF_ARRAY))		{
	$SHOW1	= base64_decode($SHOWINFORLIB);;
	$SHOW2	= base64_decode($SHOWURLLIB);;
	$SHOW3	= base64_decode($SHOWTIP);;
}
elseif(in_array("ERP",$PHP_SELF_ARRAY))		{
	$SHOW1	= base64_decode($SHOWINFORERP);;
	$SHOW2	= base64_decode($SHOWURLLIB);;
	$SHOW3	= base64_decode($SHOWTIP);;
}
else	{
	$SHOW1	= base64_decode($SHOWINFOR);;
	$SHOW2	= base64_decode($SHOWURL);;
	$SHOW3	= base64_decode($SHOWTIP);;
}


if(!is_file("../../Framework/license.ini"))					{
	if(is_dir("../../Framework")&&(is_dir("../../../EDU")||is_dir("../../../ERP")||is_dir("../../../TDLIB"))&&$FileDirName!="PGSQL")		{
		if($_GET['action']=="init_default"||$_GET['action']=="init_customer")		{
				print "<BR><div align=center><a href=\"$SHOW2\" title='$SHOW3' target=_blank><font color=gray>$SHOW1</font></a></div>";
		}
	}
}


?>