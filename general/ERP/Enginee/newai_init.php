<?php
//2007-4-12 15:17	����ROW_ELEMENT����Ϊ��ֵ��������Ӧ�ӵڶ��������л���ı���ֵ����Ϊ��

function newaiinit($fields,$mode)	{
global $common_html,$html_etc;
global $return_sql_line,$db;
global $action_add,$action_model;
global $_POST,$_GET,$ROWS_PAGE,$mark;
global $merge,$childnums,$childsums,$child_filter;
global $SYSTEM_ADD_SQL;

$fields=newaiinit_value($fields);

if($merge)
$fields=newai_merge($fields,$merge);
if($childnums)
$fields=newai_childnums($fields,$childnums);
if($childsums)
$fields=newai_childsums($fields,$childsums);
global $tablewidth;
$tablewidth=$tablewidth!=""?$tablewidth:450;



table_begin($tablewidth);
show_search_element($mark);
newaiinit_view($fields);
UserDefineFunction();
UserSumFunction($fields);
//print_R($_REQUEST);
if($_GET['action']=="")	$_GET['action'] = "init_default";
if($_REQUEST['action']!="")	$_GET['action'] = $_REQUEST['action'];
//print_R($_GET);
newaiinit_bottommemo();
newaiinit_bottom($fields['other']['rc'],$fields['other']['pageid'],$fields['other']['pagenums'],$ROWS_PAGE,$add='action',$add_var=$_GET['action']);

table_end();
}

function newaiinit_value($fields)			{
global $common_html,$html_etc;
global $return_sql_line,$db;
global $_POST,$_GET,$ROWS_PAGE;
global $action_add,$action_model,$mark;
global $read_type,$email_filter,$returnmodel;
global $sms_filter,$nullshow,$columns;
global $primarykey_index;
global $systemorder;
global $tablename;

//print $systemorder;

$systemorderArray = explode(',',$systemorder);
for($xx=0;$xx<sizeof($systemorderArray);$xx++)		{
	$KeyOrderSqlIndexArray = explode(':',$systemorderArray[$xx]);
	$KeyOrderSqlIndexName = $KeyOrderSqlIndexArray[0];
	$KeyOrderSqlIndexOrderDesc = $KeyOrderSqlIndexArray[1];
	$OrderSQLARRAY[$xx] = $columns[$KeyOrderSqlIndexName]." ".$KeyOrderSqlIndexOrderDesc;
}

$OrderSQLText = join(' , ',$OrderSQLARRAY);
if(TRIM($OrderSQLARRAY[0])!="")					{
	$systemorderText = $OrderSQLText;
}
else			{
	/*
	if($systemorder!="")			{
		$systemorder1 = "asc";
	}
	else	{
		$systemorder1 = "desc";
	}
	$systemorderText = $primarykey_index ." $systemorder1";
	*/
}

//print $systemorderText;


switch($db->databaseType)				{
	case 'mssql':
		if(isset($_GET[ordername])&&in_array($_GET[ordername],$columns))	{
			if($_GET[doubletime]%2==0)
				$addsql="order by [".$_GET[ordername]."] asc";
			else
				$addsql="order by [".$_GET[ordername]."] desc";
		}
		else		{
			$addsql="order by [".$primarykey_index ."] $systemorder1";
		}
		break;
	case 'mysql':
	default:
		if(isset($_GET[ordername])&&in_array($_GET[ordername],$columns))	{
			if($_GET[doubletime]%2==0)
				$addsql="order by ".$_GET[ordername]." asc";
			else
				$addsql="order by ".$_GET[ordername]." desc";
		}
		else		{
			if($systemorderText!='')
				$addsql="order by $systemorderText";
		}
		break;
}//end switch
//�ж��Ƿ���������趨
if($action_add=='search')		{
	$SQL=$return_sql_line['uniquekey_sql_search']." ".$addsql;
	$SQL_NUM=$return_sql_line['uniquekey_sql_num_search'];
	$SQL_SUM=$return_sql_line['uniquekey_sql_sum_search'];
}
else	{
	$SQL=$return_sql_line['uniquekey_sql']." ".$addsql;
	$SQL_NUM=$return_sql_line['uniquekey_sql_num_get'];
	$SQL_SUM=$return_sql_line['uniquekey_sql_sum_get'];
}

global $NEWAIINIT_VALUE_SYSTEM;
global $NEWAIINIT_VALUE_SYSTEM_NUM;
global $NEWAIINIT_VALUE_SYSTEM_SUM;

if(strlen($NEWAIINIT_VALUE_SYSTEM)>10)			{
	$SQL		=	$NEWAIINIT_VALUE_SYSTEM;
	$SQL_NUM	=	$NEWAIINIT_VALUE_SYSTEM_NUM;
	$SQL_SUM	=	$NEWAIINIT_VALUE_SYSTEM_SUM;
}
global $SYSTEM_MODE,$SYSTEM_PRINT_SQL;
//print_R($SYSTEM_MODE);
//print_R($return_sql_line);exit;
//print_R($return_sql_line);

if($SYSTEM_PRINT_SQL)				{
	$SYSTEM_PRINT_SQL = $SQL;
	print_R($SQL);
	print "<HR>";
	print_R($_GET);
	print "<HR>";
	//print_R($_SESSION);
	//print "<HR>";
}

//print_R($SQL_NUM);EXIT;
global $rc;
/*
$rs = &$db->CacheExecute(5,$SQL_NUM);
$rs_a = $rs->GetArray();
$rc=$rs_a[0]['num'];
if($rc=='')		{
  $rc=$rs_a[0]['NUM'];
}
*/
//��Ϳ�ʼ 2011-01-31��֧������
global $UserSumFunction;//print $UserSumFunction;exit;
$UserSumFunctionArray = explode(',',$UserSumFunction);
$SQL_SUM_ԭʼ = $SQL_SUM;
$tmpstr='count(*) as allcount';
for($ixx=0;$ixx<sizeof($UserSumFunctionArray);$ixx++)			{
	$UserSumFunctionTEMP = $UserSumFunctionArray[$ixx];
	if($UserSumFunctionTEMP!="")		{
		$UserSumFunctionTEMP = $columns[$UserSumFunctionTEMP];
		
		//��Щ�ֶ�ְԱ����������
		
		if($fields['INPUT_TEXT'][$UserSumFunctionTEMP]=="private")
		{
			$grade=str_split($fields['inputsize'][$UserSumFunctionTEMP]);
			if(!in_array($_SESSION['LOGIN_USER_PRIV'], $grade))
				continue;
		}
		$tmpstr.=",SUM($UserSumFunctionTEMP) as $UserSumFunctionTEMP";
				
	}
}

$SQL_SUM =str_ireplace("sum(___) as sum",$tmpstr,$SQL_SUM_ԭʼ);

//		print $SQL_SUM;exit;
		$rs_sum = &$db->CacheExecute(15,$SQL_SUM);
		$rc=$rs_sum->fields['allcount'];
for($ixx=0;$ixx<sizeof($UserSumFunctionArray);$ixx++)			{
	$UserSumFunctionTEMP = $UserSumFunctionArray[$ixx];
	if($UserSumFunctionTEMP!="")		{
		$UserSumFunctionTEMP = $columns[$UserSumFunctionTEMP];
		$sum_number = $rs_sum->fields[$UserSumFunctionTEMP];
		$UserSumFunctionTEMP=$html_etc[$fields['tablename']][$UserSumFunctionTEMP];
		$fields['other']['sum_number'][$UserSumFunctionTEMP] = (is_float($sum_number+0)?number_format($sum_number,2,'.',','):$sum_number);
	}
}
		
		
		

//��ͽ���
if($rc==0&&$nullshow!=1)		{
	$return="location='?action=init_".$mark."'";
	$showtext=$common_html['common_html']['norecord'];
	$location_title='sunshine_inside';
	$action_array_temp=explode('_',$_GET['action']);
	if($action_array_temp[1]=='customer')	{
	}
	else if($email_filter!='')	{
		$return=isset($returnmodel)?"location='?action=".$returnmodel."'":"history.back();";
		$showtext=$common_html['common_html']["nomail".$mark];
	}
	else if($sms_filter!='')	{
		$return=isset($returnmodel)?"location='?action=".$returnmodel."'":"history.back();";
		$showtext=$common_html['common_html']["nosms".$mark];
	}
	else	{
		//page_css('system');
		//$action_model='add_default:new:n';
		//show_new_element($action_model);
	}
	print_infor($showtext,'trip',"$return");
	exit;
}
if($ROWS_PAGE<=0)		{
	$pagenums = 0;
}
else	{
	$pagenums=ceil($rc/$ROWS_PAGE);
	$pageid=$_GET['pageid'];
}
if($pageid==""||empty($pageid)){$pageid=1;}
if($pageid>$pagenums){$pageid=$pagenums;}
$from=($pageid-1)*$ROWS_PAGE;
//print $SQL;print $SQL_NUM;
global $SYSTEM_SQL;
$SYSTEM_SQL = $SQL;
//print_r($SQL);
$rsl=$db->SelectLimit($SQL,$ROWS_PAGE,$from);
$rsa=$rsl->GetArray();
//print_R($rsa[0]);
@$fields['header']=array_keys($rsa[0]);
$fields['sql']['SQL']=$SQL;
$fields['sql']['SQL_NUM']=$SQL_NUM;
$fields['value']=$rsa;
//print_R(array_keys($rsa[0]));
//print_R($fields['value']);
$counter=0;//��������
//�Ƿ�����ͼƬ�Ŵ�ű�
$ifincludemaginfier=false;
//2011-06-21��ʼ���༭��ɾ��Ȩ�޵�ֵ
$fields['view_priv'][$counter] = 0;
$fields['edit_priv'][$counter] = 0;
$fields['delete_priv'][$counter] = 0;
$fields['value2'] = $fields['value'];
foreach($fields['value'] as $list)							{
	//print_R($list);exit;
	//print $tablename;
	$i=0;
	//
	global $showlistfieldstopedit;
	$showlistfieldstopeditArray = explode(',',$showlistfieldstopedit);
	global $showlistfieldstopdelete;
	$showlistfieldstopdeleteArray = explode(',',$showlistfieldstopdelete);
	
	foreach($fields['name'] as $list_index)				{
		$mode=$fields['filter'][$i];
		//�ڴ��ж��Ƿ���רҵ�ƿƳ�Ȩ��,�����,����ʾUSER_DEFINE�ֶ�
		if($_SESSION['SUNSHINE_BANJI_LIST']!="")		{
			if($mode=='userdefine')					{
				$mode = 'input';//����ΪINPUT�򲻻���ʾ���Ӳ���������
			}
		}
		
		//2011-06-20 ��������еı༭��ɾ����ť�Ľ���Ȩ�޴���,�����û��Զ��岿�ֵ�Ȩ�޿���
		//�û�Ȩ�޶��岿��
		//�õ�X��Y�е�ֵ
		$filtervalue = $fields['value'][$counter][$list_index];
		$showlistfieldstopeditArrayCheckArray = explode(':',$showlistfieldstopeditArray[$i]);
		//print_R($showlistfieldstopeditArrayCheckArray);
		if(in_array($filtervalue,$showlistfieldstopeditArrayCheckArray)&&$filtervalue!="")		{
			$fields['edit_priv'][$counter] = 1;
		}
		else	{
			//���ݾɵķ��ؽ��
			//$fields['edit_priv'][$counter] = 0;
		}
		$filtervalue = $fields['value'][$counter][$list_index];
		$showlistfieldstopdeleteArrayCheckArray = explode(':',$showlistfieldstopdeleteArray[$i]);
		if(in_array($filtervalue,$showlistfieldstopdeleteArrayCheckArray)&&$filtervalue!="")		{
			$fields['delete_priv'][$counter] = 1;
		}
		else	{
			//���ݾɵķ��ؽ��
			//$fields['delete_priv'][$counter] = 0;
		}

		$i++;//��������
		//exit($mode);
		if(stristr($mode, 'color'))
			$hascolor=true;
		else 
			$hascolor=false;
		switch($mode)		{
			case '':
			case 'input':
			case 'autoincrement':
			case 'autoincrementdate':
				$filtervalue=$fields['value'][$counter][$list_index];
				break;
			case 'number':
				$filtervalue="<div align=right>".$fields['value'][$counter][$list_index]."</div>";
				break;
			case 'money':
				$filtervalue="<div align=right>".number_format(floatval($fields['value'][$counter][$list_index]),2)."</div>";
				break;
			case 'password':
				$filtervalue="******";
				break;
			case 'password_simple':
				$filtervalue="******";
				break;
			case 'ajaxinput':
				global $sessionkey;
				$INPUT_TEXT = $fields['INPUT_TEXT'][$list_index];
				if($INPUT_TEXT=="")		$INPUT_SIZE = 15;
				else					$INPUT_SIZE = $INPUT_TEXT;
				//print $sessionkey;
				$filtervalue=$fields['value'][$counter][$list_index];
				$AjaxID = $fields['value'][$counter][$primarykey_index];
				$openDir = "sessionkey=$sessionkey&action=jiyun512&tablename=$tablename&primarykey=$primarykey_index&IDValue=$AjaxID&FieldName=$list_index";
				if(is_file("newai_ajax.php"))	 $TempDirPath = "./";
				else if(is_file("../../Framework/newai_ajax.php"))	 $TempDirPath = "../../Framework/";
				else $TempDirPath = '';

				$openDir = $TempDirPath."newai_ajax.php?".base64_encode($openDir);
				$filtervalue="<input type=\"text\" class=\"SmallInput\" size=\"$INPUT_SIZE\"  value=\"".$filtervalue."\"
				onBlur=\"GetResult('".$openDir."&FieldValue='+this.value);\"
				onkeypress=\"GetResult('".$openDir."&FieldValue='+this.value);\"
				onchange=\"GetResult('".$openDir."&FieldValue='+this.value);\"
				>";
				$filtervalue = $filtervalue;
				break;
			case 'ajaxinputhidden':
				global $sessionkey;
				$INPUT_TEXT = $fields['INPUT_TEXT'][$list_index];
				if($INPUT_TEXT=="")		$INPUT_SIZE = 15;
				else					$INPUT_SIZE = $INPUT_TEXT;
				//print $sessionkey;
				$filtervalue=$fields['value'][$counter][$list_index];
				$AjaxID = $fields['value'][$counter][$primarykey_index];
				$openDir = "sessionkey=$sessionkey&action=jiyun512&tablename=$tablename&primarykey=$primarykey_index&IDValue=$AjaxID&FieldName=$list_index";
				if(is_file("newai_ajax.php"))	 $TempDirPath = "./";
				else if(is_file("../../Framework/newai_ajax.php"))	 $TempDirPath = "../../Framework/";
				else $TempDirPath = '';

				$openDir = $TempDirPath."newai_ajax.php?".base64_encode($openDir);

				//$filtervalue="<input type=\"text\" class=\"SmallInput\" size=\"$INPUT_SIZE\"  value=\"".$filtervalue."\" onkeyup=\"GetResult('".$openDir."&FieldValue='+this.value);\">";

				if(TRIM($filtervalue)!="")		{
					$SpanInputText="";
				}
				else	{
					$SpanInputText="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}

				$filtervalue = "<SPAN onclick=\"listTable_edit(this,'$list_index',$AjaxID,'$sessionkey','$tablename','$primarykey_index','$AjaxID','$list_index','$openDir')\">".$filtervalue.$SpanInputText."</SPAN>";
				break;
			case 'ajaxboolean':
				global $sessionkey;
				$INPUT_TEXT = $fields['INPUT_TEXT'][$list_index];
				if($INPUT_TEXT=="")		$INPUT_SIZE = 15;
				else					$INPUT_SIZE = $INPUT_TEXT;
				//print $sessionkey;
				$filtervalue=$fields['value'][$counter][$list_index];
				$AjaxID = $fields['value'][$counter][$primarykey_index];
				$openDir = "action=jiyun512&tablename=$tablename&primarykey=$primarykey_index&IDValue=$AjaxID&sessionkey=$sessionkey&FieldName=$list_index";
				if(is_file("newai_ajax.php"))			{
					$TempDirPath = "./";
				}
				else if(is_file("../../newai_ajax.php"))	 {
					$TempDirPath = "../../Framework/";
				}
				else	{
					$TempDirPath = '';
				}

				if(is_file("images/error.gif"))			{
					$PicDirPath = "./";
				}
				else	{
					$PicDirPath = "../../Framework/";
				}



				$openDir = $TempDirPath."newai_ajax.php?".base64_encode($openDir);

				//$filtervalue="<input type=\"text\" class=\"SmallInput\" size=\"$INPUT_SIZE\"  value=\"".$filtervalue."\" onkeyup=\"GetResult('".$openDir."&FieldValue='+this.value);\">";
				if($filtervalue=="1")		{
					$filtervalue = "<img onclick=\"listTable_boolean(this,'$list_index',$AjaxID,'$sessionkey','$tablename','$primarykey_index','$AjaxID','$list_index','$openDir')\" src=\"".$PicDirPath."images/right.gif\" border=0>";
				}
				else	{
					$filtervalue = "<img onclick=\"listTable_boolean(this,'$list_index',$AjaxID,'$sessionkey','$tablename','$primarykey_index','$AjaxID','$list_index','$openDir')\" src=\"".$PicDirPath."images/error.gif\" border=0>";
				}



				break;
			case 'avatar':
				$filtervalue=$fields['value'][$counter][$list_index];
				$filepath="images/avatar/$filtervalue.gif";
				if(is_file($filepath))
					$filtervalue="<img src=\"$filepath\" border=0>";
				else
					$filtervalue="<img src=\"images/avatar/9.gif\" border=0>";
				break;
			case 'textarea':
				$filtervalue		=	$fields['value'][$counter][$list_index];
				$filtervalue =strip_tags(htmlspecialchars_decode($filtervalue));
				
				if(cutStr($filtervalue,25)!=$filtervalue)
					$filtervalue="<font title='$filtervalue'>".cutStr($filtervalue,25)."</font>"."...";
				break;
			case 'textareabr':
				$filtervalue=$fields['value'][$counter][$list_index];
				$filtervaluetext	=	addslashes($filtervalue);
				if(cutStr($filtervalue,25)!=$filtervalue)
					$filtervalue="<font title='$filtervaluetext'>".cutStr($filtervalue,25)."</font>"."...";
				//if(strlen($filtervalue)>50)	$filtervalue=substr($filtervalue,0,50)."...";
				break;
			case 'readonlytextarea':
				$filtervalue=$fields['value'][$counter][$list_index];
				$filtervaluetext	=	addslashes($filtervalue);
				if(cutStr($filtervalue,25)!=$filtervalue)
					$filtervalue="<font title='$filtervaluetext'>".cutStr($filtervalue,25)."</font>"."...";
				break;
			case 'idtoname_user':
				$filtervalue=idtoname($fields['value'][$counter][$list_index],$mode='user');
				break;
			case 'idtoname_course':
				$filtervalue=idtoname($fields['value'][$counter][$list_index],$mode='course');
				break;
			case 'idtoname_YuanXi':
				$filtervalue=idtoname($fields['value'][$counter][$list_index],$mode='YuanXi');
				break;
			case 'idtoname_dept':
				$filtervalue=idtoname($fields['value'][$counter][$list_index],$mode='dept');
				//$filtervalue=$fields['value'][$counter][$list_index];
				break;
			case 'colorselect':
				$filtervalue="<div  style=\"border:1px double #000000;width:16px;height:16px;background-color:$filtervalue;overflow:hidden;\"></div>";
				break;
			case 'date':
			case 'date1':
				$filtervalue=$fields['value'][$counter][$list_index];
				break;
			case 'dateonly':
				$filtervalue_Array	= explode(' ',$fields['value'][$counter][$list_index]);
				$filtervalue		= $filtervalue_Array[0];
				break;
			case 'timeonly':
				$filtervalue_Array	= explode(' ',$fields['value'][$counter][$list_index]);
				$filtervalue		= $filtervalue_Array[1];
				break;
			case 'datetime':
				$filtervalue=$fields['value'][$counter][$list_index];
				break;
			case 'url':
				$filtervalue=$fields['value'][$counter][$list_index];
				$urlfield=$fields['INPUT_TEXT'][$list_index];
				$urlid=$fields['inputsize'][$list_index];
				if($filtervalue!='' && $urlid!='')
					$filtervalue=$filtervalue."-".$fields['value'][$counter][$urlid];
				$url=$fields['value'][$counter][$urlfield];
				$urlarray=explode("?",$url);
				$urlarray[1]=str_ireplace("&amp;","&", $urlarray[1]);
				$url=$urlarray[0]."?".base64_encode($urlarray[1]);
				$filtervalue="<a href=\"$url\" target=_blank >$filtervalue</a>";
				break;
			case 'mulcheckbox':
				
				$filtervalue=$fields['value'][$counter][$list_index];
				$subtablename=$fields['INPUT_TEXT'][$list_index];
				$subkey=$fields['inputsize'][$list_index];
				$subval=$fields['inputother'][$list_index];
				$subcolums=returntablecolumn($subtablename);
				$subkey=$subcolums[$subkey];
				$subval=$subcolums[$subval];
				
				$fieldValueArray = explode(",",$filtervalue);
				array_pop($fieldValueArray);
				$fieldValueArrayTEXT = join("','",$fieldValueArray);
				$sql   = "select $subval from $subtablename where $subkey in ('$fieldValueArrayTEXT')";
				$rsxx  = $db->CacheExecute(5,$sql);
				$rsxxA = $rsxx->GetArray();
				$fieldValueNameText = '';
				for($iD=0;$iD<sizeof($rsxxA);$iD++)			{
					$fieldValueNameText .= $rsxxA[$iD][$subval].",";
					
				}
				//for($iD=0;$iD<sizeof($fieldValueArray);$iD++)			{
				//	$fieldValueArrayValue = $fieldValueArray[$iD];
				//	if($fieldValueArrayValue!="")
				//		$fieldValueNameText .= returntablefield("user","USER_ID",$fieldValueArrayValue,"USER_NAME").",";
				//}
				$filtervalue	=	$fieldValueNameText;
				
				break;
			case 'file':
				$filtervalue=$fields['value'][$counter][$list_index];
				$filtervalue_file = explode('=',$filtervalue);
				$filtervalue_sizeof = sizeof($filtervalue_file)-1;
				$filename = $filtervalue_file[$filtervalue_sizeof];
				$filtervalue = "<a href=\"$filtervalue\">$filename</a>";
				break;
			case 'singlefile':
			case 'picturefile':
				$filtervalue=$fields['value'][$counter][$list_index];
				
				$var_value = ereg_replace ("&amp;", "&", $filtervalue);
				//print $filtervalue;
				$parse_url = parse_url($var_value);
				$query = $parse_url['query'];
				parse_str($query,$output);
				//print_R($output);
				$attachmentid = $output['attachmentid'];
				$attachmentname = $output['attachmentname'];
				$filtervalue_file = explode('=',$filtervalue);
				$filtervalue_sizeof = sizeof($filtervalue_file)-1;
				$filename = $filtervalue_file[$filtervalue_sizeof];
				$filename_newfile = "../../attachment/$attachmentid/$attachmentname";
				$filename_newfile2 = "../../Framework/attachment/$attachmentid/$attachmentname";
				//print $filename_newfile;
				//print_R(is_file($filename_newfile));
				if(is_file($filename_newfile)||is_file($filename_newfile2) || strtolower(substr($filtervalue,0,4))=='http')		{
						$filtervalue=trim($fields['value'][$counter][$list_index]);
						$filtervalue_file = explode('=',$filtervalue);
						$filtervalue_sizeof = sizeof($filtervalue_file)-1;
						$filename = $filtervalue_file[$filtervalue_sizeof];
						//$filtervalue = "<a href='".$filtervalue."'>$filename</a>";
						if(!$ifincludemaginfier)
						{
							print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
							print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.magnifier.js\"></script>";
							$ifincludemaginfier=true;
						}
						$image = "<img src='".$filtervalue."' height=25  class=\"magnify\"  data-magnifyto=\"500\" onmouseover=\"this.style.cursor='pointer';this.style.cursor='hand'\" onmouseout=\"this.style.cursor='default'\">";
						//$filtervalue = "<a href='".$filtervalue."'>$image</a>";
						$filtervalue=$image;
				}
				else	{
					$filtervalue = "";
				}
				break;
			case 'tdoafile':
					$filtervalue=$fields['value'][$counter][$list_index];
					$var_value_array = explode('||',$filtervalue);
					$ATTACHMENT_ID = $var_value_array[1];
					$ATTACHMENT_NAME = $var_value_array[0];
					$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID );
					$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME );
					$ATTACH_LINK = '';
					require_once('lib/utility_file.php');
					$MODULE = attach_sub_dir( );
					
					for ($IX=0;$IX<count($ATTACHMENT_ID_ARRAY);$IX++)
					{
						if ($ATTACHMENT_ID_ARRAY[$IX]!="")
						{
								$ATTACH_IMAGE = image_mimetype( $ATTACHMENT_NAME_ARRAY[$IX] );
								//print $ATTACH_IMAGE;
								$ATTACHMENT_ID = $ATTACHMENT_ID_ARRAY[$IX];
								//print_R($ATTACHMENT_ID);
								$ATTACHMENT_ID_ARRAY2 = explode('_',$ATTACHMENT_ID);
								$YM				= $ATTACHMENT_ID_ARRAY2[0];
								$ATTACHMENT_ID	= $ATTACHMENT_ID_ARRAY2[1];
								$SIGN_KEY = "";
								//$SIGN_KEY = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "." ) + 1 );
								//$ATTACHMENT_ID = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "." ) );
								//print_R($ATTACHMENT_ID);
								$ATTACHMENT_ID_ENCODED = attach_id_encode( $ATTACHMENT_ID,$ATTACHMENT_NAME_ARRAY[$IX] );
								$ATTACH_SIZE = attach_size( $ATTACHMENT_ID_ARRAY[$IX], $ATTACHMENT_NAME_ARRAY[$IX], $MODULE );
								if ( 0 < floor( $ATTACH_SIZE / 1024 / 1024 ) )
								{
												$ATTACH_SIZE = round( $ATTACH_SIZE / 1024 / 1024, 2 )."MB";
								}
								else if ( 0 < floor( $ATTACH_SIZE / 1024 ) )
								{
												$ATTACH_SIZE = round( $ATTACH_SIZE / 1024, 2 )."KB";
								}
								else
								{
												$ATTACH_SIZE .= "�ֽ�";
								}
							$ATTACH_LINK .= "<img src=\"../../Framework/images/attach/".$ATTACH_IMAGE."\" align=\"absmiddle\"
							title='".urldecode( $ATTACHMENT_NAME_ARRAY[$IX] )." ��С:$ATTACH_SIZE'><a href=\"../../Enginee/lib/attach.php?MODULE=".$MODULE."&YM=".$YM."&ATTACHMENT_ID=".$ATTACHMENT_ID_ENCODED."&ATTACHMENT_NAME=".urlencode( $ATTACHMENT_NAME_ARRAY[$IX] )."\" ".( $ATTACH_OFFICE_OPEN_IN_IE ? " target=\"_blank\"" : "" )."
							title='".urldecode( $ATTACHMENT_NAME_ARRAY[$IX] )." ��С:$ATTACH_SIZE'
							>".urldecode( $ATTACHMENT_NAME_ARRAY[$IX] )."</a>\n";

						}
					}
					$filtervalue = $ATTACH_LINK;

				break;
			case 'binaryfile':
				$filtervalue=$fields['value'][$counter][$list_index];
				$filtervalue_file = explode('=',$filtervalue);
				$filtervalue_sizeof = sizeof($filtervalue_file)-1;
				$filename = $filtervalue_file[$filtervalue_sizeof];
				$filtervalue = "<a href=\"$filtervalue\">$filename</a>";
				break;
			case 'sex':
				$filtervalue=returnsexcolor($fields['value'][$counter][$list_index]);
				break;
			case 'select_sex':
				
				$filtervalue=returnsexcolor($fields['value'][$counter][$list_index]);
				break;
			case 'boolean':
				$filtervalue=returnboolean_gif($fields['value'][$counter][$list_index]);
				break;
			case 'checkbox':
				$filtervalue=returncheckbox($fields['value'][$counter][$list_index]);
				break;
			case 'select_sms':
				$filtervalue=return_select_filter('select_sms',$fields['value'][$counter][$list_index]);
				break;
			case 'select_education':
				$filtervalue=return_select_filter('select_education',$fields['value'][$counter][$list_index]);
				break;
			case 'select_marriage':
				$filtervalue=return_select_filter('select_marriage',$fields['value'][$counter][$list_index]);
				break;
			case 'select_politics':
				$filtervalue=return_select_filter('select_politics',$fields['value'][$counter][$list_index]);
				break;
			case 'sms_self_status':
				$filtervalue=return_select_filter('sms_self_status',$fields['value'][$counter][$list_index]);
				break;
			case 'sms_delete_status':
				$filtervalue=return_select_filter('sms_delete_status',$fields['value'][$counter][$list_index]);
				break;
			case 'select_worklog':
				$filtervalue=return_select_filter('select_worklog',$fields['value'][$counter][$list_index]);
				break;
			case 'email_read_status_inbox':
				$filtervalue=return_select_filter('email_read_status_inbox',$fields['value'][$counter][$list_index]);
				break;
			case 'email_read_status_outbox':
				$filtervalue=return_select_filter('email_read_status_outbox',$fields['value'][$counter][$list_index]);
				break;
			case 'email_delete_status_outbox':
				$filtervalue=return_select_filter('email_delete_status_outbox',$fields['value'][$counter][$list_index]);
				break;
			case 'ajax':
				$filtervalue=ajaxtablefield($fields['select'][$i-1]['tablename'],$fields['select'][$i-1]['value'],$fields['value'][$counter][$list_index],$fields['select'][$i-1]['field'],$counter,$fields['tablename'],$fields['name'][$i-1],$primarykey_index,$fields['value'][$counter][$primarykey_index]);
				break;
			case 'select':
				$filtervalue=returntablefield($fields['select'][$i-1]['tablename'],$fields['select'][$i-1]['value'],$fields['value'][$counter][$list_index],$fields['select'][$i-1]['field']);
				break;
			case 'radio':
				$filtervalue=returntablefield($fields['select'][$i-1]['tablename'],$fields['select'][$i-1]['value'],$fields['value'][$counter][$list_index],$fields['select'][$i-1]['field']);
				//print_R($fields['select'][$i-1]);;
				break;
			case 'radiogroup':
				$filtervalue=returntablefieldColorFilterGray($fields['select'][$i-1]['tablename'],$fields['select'][$i-1]['value'],$fields['value'][$counter][$list_index],$fields['select'][$i-1]['field'],$fields['select'][$i-1]['groupfield'],$fields['select'][$i-1]['groupvalue'],'','','',$hascolor);
				break;
			case 'selectcolor':
				
				$filtervalue=returntablefieldColorFilterGray($fields['select'][$i-1]['tablename'],$fields['select'][$i-1]['value'],$fields['value'][$counter][$list_index],$fields['select'][$i-1]['field'],'','','',$hascolor);
				break;
			case 'select_input':
				$value=$fields['value'][$counter][$list_index];
				$filtervalue=returntablefield($fields['select'][$i-1]['tablename'],$fields['select'][$i-1]['value'],$fields['value'][$counter][$list_index],$fields['select'][$i-1]['field']);
				break;
			case 'select_textarea':
				$value=$fields['value'][$counter][$list_index];
				$filtervalue=idtoname($value,$mode='dept');//returntablefield($fields['select'][$i-1]['tablename'],$fields['select'][$i-1]['value'],$fields['value'][$counter][$list_index],$fields['select'][$i-1]['field']);
				break;
			case 'checkread':
				$index_key=$fields['table']['primarykeyindex'];
				$index_key=$fields['value'][$counter][$index_key];
				$in_array=checkread_username('checkread',$fields['checkread'][$i-1]['field'],$index_key);
				$in_array=$in_array==1?1:0;
				$filtervalue=return_select_filter('notify_read_status',$in_array);
				break;
			case 'usertonamelist':
				$filtervalue=$fields['value'][$counter][$list_index];
				$fieldValueArray = explode(",",$filtervalue);
				array_pop($fieldValueArray);
				$fieldValueArrayTEXT = join("','",$fieldValueArray);
				$sql   = "select UID,USER_NAME from user where USER_ID in ('$fieldValueArrayTEXT') order by USER_NAME";
				$rsxx  = $db->CacheExecute(5,$sql);
				$rsxxA = $rsxx->GetArray();
				$fieldValueNameText = '';
				for($iD=0;$iD<sizeof($rsxxA);$iD++)			{
					$fieldValueNameText .= "<a target='_blank' href='../Framework/user_newai.php?action=view_default&UID=".$rsxxA[$iD]['UID']."'>".$rsxxA[$iD]['USER_NAME']."</a>,";
					
				}
				//for($iD=0;$iD<sizeof($fieldValueArray);$iD++)			{
				//	$fieldValueArrayValue = $fieldValueArray[$iD];
				//	if($fieldValueArrayValue!="")
				//		$fieldValueNameText .= returntablefield("user","USER_ID",$fieldValueArrayValue,"USER_NAME").",";
				//}
				$filtervalue	=	$fieldValueNameText;
				//$filtervalue="<font title='$fieldValueNameText'>".$fieldValueNameText."</font>"."...";
				break;
			case 'link':
				$filtervalue=$fields['value'][$counter][$list_index];
				$url=$fields['link'][$i-1]['url'];
				$target=$fields['link'][$i-1]['target'];
				$filename=$fields['link'][$i-1]['filename'];
				$index_key=$fields['table']['primarykeyindex'];
				$filtervalue="<a href='$filename?".base64_encode("action=$url&$index_key=".$fields['value'][$counter][$index_key])."' target=$target>$filtervalue</a>";
				//$filtervalue="<a href='$filename?action=$url&$list_index=$filtervalue&$index_key=".$fields['value'][$counter][$index_key]."' target=$target>$filtervalue</a>";
				break;
			case 'mobile':
				$filtervalue=$fields['value'][$counter][$list_index];
				$regex="/1[34568]+\\d{9}/";
				preg_match_all($regex,$filtervalue, $phones);
				
				if(strlen($phones[0][0])==11)
					$filtervalue="<a href='../JXC/sms_sendlist_newai.php?".base64_encode("action=add_default&sendlist=".$phones[0][0])."' target='_blank'>$filtervalue</a>";
				
				break;
			case 'qq':
				$filtervalue=$fields['value'][$counter][$list_index];
				$filtervalue=(!empty($filtervalue)?"<a target=\"_blank\" href=\"http://wpa.qq.com/msgrd?v=3&amp;uin=".$filtervalue."&amp;site=qq&amp;menu=yes\"><img border=\"0\" src=\"http://wpa.qq.com/pa?p=2:".$filtervalue.":45\" title=\"������﷢��Ϣ\" onerror=\"this.src='".ROOT_DIR."general/ERP/Framework/images/help3.gif';this.title='��QQ������ܲ�����'\">".$filtervalue."</a>":'');
				break;
		
			case 'email':
				$filtervalue=$fields['value'][$counter][$list_index];
				if($fields['tablename'] == 'linkman'){
					$fromsrc = 'customer';
					$linkman = gettablefield($fields['tablename'],'email','rowid',$filtervalue);
				}else if($fields['tablename'] == 'supplylinkman'){
					$fromsrc = 'supply';
					$linkman = gettablefield($fields['tablename'],'email','rowid',$filtervalue);
				}	
				else 
				{
					$linkman=$filtervalue;
					$fromsrc='';
				}
				$filtervalue="<a href='../CRM/email_newai.php?".base64_encode("action=add_default&sendlist=".$linkman."&fromsrc=".$fromsrc)."' target='_blank' >".$filtervalue."</a>";
				break;	
			case 'city':
				$filtervalue=$fields['value'][$counter][$list_index];
				$filtervalue=getShengShiXian($filtervalue);
				break;			
			case 'userdefine':
				$filtervalue=$fields['value'][$counter][$list_index];
				$functionName = $fields['userdefine'][$i-1];
				$fileName = $functionName.".php";
				$fileName0 = "userdefine/$fileName";
				$fileName = "../../Enginee/userdefine/$fileName";
				if(file_exists($fileName0))		{
					require_once($fileName0);
					$functionName = $functionName."_Value";
					if(function_exists($functionName))	{
						$filtervalue = $functionName($fields['value'][$counter][$list_index],$fields,$counter);
					}
				}
				else if(file_exists($fileName))		{
					require_once($fileName);
					$functionName = $functionName."_Value";
					if(function_exists($functionName))	{
						$filtervalue = $functionName($fields['value'][$counter][$list_index],$fields,$counter);
					}
					else	{
						print "��������[$functionName]�����ڣ�";
					}
				}
				else	{
					print "û����Ӧ�ļ�,�ļ�����$fileName";
				}
				//�û�Ȩ�޶��岿��
				//print_R($functionName."_PRIV");print_R("<BR>");
				if(function_exists($functionName."_PRIV"))		{
					$NewFunctionNamePriv = $functionName."_PRIV";
					$userdefine_priv_Infor = $NewFunctionNamePriv($fields['value'][$counter][$list_index],$fields,$counter);
					if($userdefine_priv_Infor['view_priv']==1)		{
						$fields['view_priv'][$counter] = 1;
					}
					if($userdefine_priv_Infor['edit_priv']==1)		{
						$fields['edit_priv'][$counter] = 1;
					}

					if($userdefine_priv_Infor['delete_priv']==1)		{
						$fields['delete_priv'][$counter] = 1;
					}
					if($userdefine_priv_Infor['shenhe_priv']==1)		{
						$fields['shenhe_priv'][$counter] = 1;
					}
					if($userdefine_priv_Infor['flow_priv']==1)		{
						$fields['flow_priv'][$counter] = 1;
					}
					if($userdefine_priv_Infor['next_priv']==1)		{
						$fields['next_priv'][$counter] = 1;
					}
					
					if($userdefine_priv_Infor==1)			{
						$fields['view_priv'][$counter]		= 1;
						$fields['edit_priv'][$counter]		= 1;
						$fields['delete_priv'][$counter]	= 1;
						$fields['shenhe_priv'][$counter] = 1;
						$fields['flow_priv'][$counter] = 1;
						$fields['next_priv'][$counter] = 1;
					}
					//print_R($fields['delete_priv']);
				}
				break;
		}
		global $limitEditDelUser;
		global $limitEditDelCust;
		if($limitEditDelUser!='') //�����û��ж�
		{
			//�����ϼ��ı༭��ɾ��Ȩ��
			if($_SESSION['limitEditDel']=='0' && $fields['value2'][$counter][$limitEditDelUser]!=$_SESSION['LOGIN_USER_ID'] && $_SESSION['LOGIN_USER_ID']!='admin' && $fields['value2'][$counter]['datascope']!='1')
			{
				$fields['edit_priv'][$counter]= 1;
				$fields['delete_priv'][$counter]= 1;
			}
			//���ƹ����ͻ��ı༭��ɾ��Ȩ��
			if($fields['value2'][$counter]['datascope']=='1' && !ifHasRoleUser($fields['value2'][$counter][$limitEditDelUser]))
			{
				$fields['edit_priv'][$counter]= 1;
				$fields['delete_priv'][$counter]= 1;
			}
		}
		if($limitEditDelCust!='')//���ݿͻ��ж�
		{
			$guanlianSysuser=returntablefield("customer", "rowid", $fields['value2'][$counter][$limitEditDelCust], "sysuser,datascope");
			////�����ϼ��ı༭��ɾ��Ȩ��
			if($_SESSION['limitEditDel']=='0' && $guanlianSysuser['sysuser']!=$_SESSION['LOGIN_USER_ID'] && $_SESSION['LOGIN_USER_ID']!='admin' && $guanlianSysuser['datascope']!='1')
			{
				$fields['edit_priv'][$counter]= 1;
				$fields['delete_priv'][$counter]= 1;
			}
			//���ƹ����ͻ��ı༭��ɾ��Ȩ��
			if($guanlianSysuser['datascope']=='1' && !ifHasRoleUser($guanlianSysuser['sysuser']))
			{
				$fields['edit_priv'][$counter]= 1;
				$fields['delete_priv'][$counter]= 1;
			}
		}
		
		$fields['elementlink'][$counter][$list_index]=$fields['value'][$counter][$list_index];

		$fields['value'][$counter][$list_index]=$filtervalue;
	}
	$counter++;
}
$fields['other']['pageid']=$pageid;
$fields['other']['pagenums']=$pagenums;
$fields['other']['rc']=$rc;
//print_r($fields['delete_priv']);print_r($fields['edit_priv']);exit;

return $fields;
}


function newaiinit_view($fields)	{
	global $common_html,$html_etc;//print_R($html_etc);
	global $return_sql_line,$db;
	global $columns,$mark,$_GET;
	global $read_type,$edit_attribute;
	global $row_userpriv,$_SESSION,$SUNSHINE_USER_NAME_VAR;
	global $export_port_arrribute;
	global $sessionkey,$tabletitle;

	switch($db->databaseType)		{
		case 'mysql':
		case 'mssql':
		default:
			break;
		case 'oracle':
			$tabletitle=strtoupper($tabletitle);
			break;
	}

	//print_R($fields['value']);
	$row_element_counter_array = array("1","2","3","4","5","6","7","8","9","0","!","@","#","$","%","^","&","*","(",")","[","]","{","}",";",":");
	global $departprivte;
	//�û���ɫ����Ȩ���ж�
	print $departprivte;
	if($departprivte!="")		{
	$departprivteSQLArray = array();
	$departprivteArray = explode('::',$departprivte);
	for($i=0;$i<sizeof($departprivteArray);$i++)	{
		$privText = $departprivteArray[$i];
		$privTextArray = explode(':',$privText);
		switch($privTextArray[0])		{
			case 'user':
				$ColumnIndex1 = $privTextArray[1];
				$USER_NAME = $_SESSION[$SUNSHINE_USER_NAME_VAR];
				$ColumnName1 = $columns[$ColumnIndex1];
				break;
		}//end swtich
	}//end for
	}
	//--



	$USER_ID=$_SESSION[$SUNSHINE_USER_NAME_VAR];
	$row_userpriv_array=explode(':',$row_userpriv);
	$tablename=$fields['table']['name'];
	$SQL=$fields['sql']['SQL'];//print $tablename;
	print "<THEAD class=TableHeader>\n";
	print "<TR><TD colspan=".$fields['table']['colspan']." class=TableHeader>&nbsp;".$html_etc[$tablename][$tabletitle]."</TD></TR>";
	print "<TR class=\"TableHeader\">\n";
	global $bottom_element,$row_element;
	$bottom_array=explode(',',$bottom_element);
	$row_array=explode(',',$row_element);
	if($export_port_arrribute!='hidden')		{
		//$linkurl="?action=export_default_data&sessionkey=$sessionkey&method=get&tablename=$tablename";
		//$ondblclick_url="ondblclick=\"location='$linkurl'\"";
		//$linktext="<a href=\"$linkurl\" target=_blank><img alt=\"".$common_html['common_html']['exportdata']."\" src=\"images/arrow_up.gif\"  border=0></a>";
		//$linktext = "<img alt=\"".$common_html['common_html']['exportdata']."\" title = '".$common_html['common_html']['choose'].$common_html['common_html']['record']."' src=\"images/arrow_up.gif\" align=\"absmiddle\"  border=0>";
	}
	else		{
		//$linktext="<img alt=\"".$common_html['common_html']['exportdata']."\" src=\"images/arrow_up.gif\"  border=0>";
	}
	($row_array[0]!=""||sizeof($bottom_array)>1)?print "<TD  class=TableHeader noWrap align=middle $ondblclick_url title = '".$common_html['common_html']['choose'].$common_html['common_html']['record']."'>".$common_html['common_html']['choose']."$linktext</TD>\n":'';
	$i=0;
	$init=$_GET['action'];
	$init_array=explode('_',$init);
	$init=$init_array[0]."_".$init_array[1];

	foreach($fields['name'] as $list)		{
		$fieldname=$fields['name'][$i];
		$fieldfilter=$fields['filter'][$i];
		
		$i++;
		$doubletime=$_GET['doubletime']+1;
		//$_GET['action'] = $init;
		$return=FormPageAction("ordername",$list,"doubletime",$doubletime);
		$ondblclick="ondblclick=\"location='?$return'\"";

		//�ж��Ƿ�Ҫ�����ֶν������� ������ʱ����ʾ˫���¼�
		global $NEWAIINIT_VALUE_SYSTEM;
		if(strlen($NEWAIINIT_VALUE_SYSTEM)>10)			{
			$ondblclick = "";
		}
		//print $ondblclick;
		//print $fieldfilter;
		//�ж��ֶ���������������Ƿ���ʾ˫���¼�
		if($fieldfilter=="ajaxinputhidden")			{
			//$ondblclick = "";
		}
		if($fieldfilter=="nowshow" || $fieldfilter=="notshow")			{
			continue;
		}
		$inputtext=$fields['INPUT_TEXT'][$fieldname];
		$inputsize=$fields['inputsize'][$fieldname];
		if($inputtext=="private")
		{
			$grade=str_split($inputsize);
			if(!in_array($_SESSION['LOGIN_USER_PRIV'], $grade))
				continue;
		}
		print "<TD noWrap class=TableHeader align=middle $ondblclick title=\"".$common_html['common_html']['dbclick']."".$common_html['common_html']['order']." : ".$html_etc[$tablename][$fieldname]."\">".$html_etc[$tablename][$list]."\n";
		//�ж��Ƿ�Ҫ�����ֶν������� ������ʱ����ʾ��ӦͼƬ
		global $NEWAIINIT_VALUE_SYSTEM;
		if(strlen($NEWAIINIT_VALUE_SYSTEM)>10)			{
		}
		else	{
			$ordername = $_GET['ordername'];
			//&&$ordername==$fieldname
			//print_R($_GET);
			if($fieldname==$ordername)
			{
				if($doubletime%2==0&&$doubletime>1)		{
				print "<a href=\"?$return\"><img alt=\"".$common_html['common_html']['order']." : ".$html_etc[$tablename][$fieldname]."\" src=\"images/arrow_down.gif\"  border=0></a>\n";
				}
				else if($doubletime%2==1&&$doubletime>1)		{
				print "<a href=\"?$return\"><img alt=\"".$common_html['common_html']['order']." : ".$html_etc[$tablename][$fieldname]."\" src=\"images/arrow_up.gif\"  border=0></a>\n";
				}
			}

		}
		print "</td>";

	}

	//ѡ�񲿷�HEADER������ʾ�Ŀ���
	if($row_array[0]!="")		{
		print "<TD noWrap class=TableHeader align=middle>".$common_html['common_html']['operation']."</TD>\n";
	}
	print "</TR>";
	print "</THEAD>";

	//-- group begin
	global $group_user;
	isset($group_user)?parent_group():'';
	//-- group end

	if($read_type=='read')	$disabled='disabled';

	$primarykey=$fields['table']['primarykey'];
	$primarykey_index=$columns[$primarykey];//print $primarykey;
	$i=1;

	global $row_element,$_GET;
	$row_array=explode(',',$row_element);

	//############################################################
	//�˲������Ϊ������Ŀ��ģ����ƣ�����ÿ�Ŀ¼���֮�������Ŀ¼
	//��ʽ��ƣ�������������������ӷ�ʽ
	//
	global $child_filter;
	$child_filter_array = explode(":",$child_filter);
	if(sizeof($child_filter_array)==3)			{

	$child_tablename = $child_filter_array[1];
	$child_columns = returntablecolumn($child_tablename);
	$child_filename = $child_tablename."_newai.php";

	$child_primarykey = $child_filter_array[0];
	$child_primarykeyIndex = $columns[$child_primarykey];
	$child_foreignkey = $child_filter_array[2];
	$child_foreignkeyIndex = $child_columns[$child_foreignkey];
	print "<SCRIPT>
		function JumpToDetail(Value)	 	{
		url=\"".$child_filename."?".$child_foreignkeyIndex."=\"+Value;
		parent.Detail.location=url;
		}
		</SCRIPT>
		";
	}
	else			{
	}
	//############################################################
	//�˲������ΪȨ�޲�����ƣ���ҵ���ܼ��Ӫ��רԱ�ĵ�Ȩ�����
	$SYSTEM_FILTER_ARRAY = returnPrivateTwoInit();
	$USER_PRIV_ID = $_SESSION['SUNSHINE_USER_PRIV'];
	$DEPT_INFOR = $_SESSION['SUNSHINE_USER_DEPT'];
	$USER_INFOR = $_SESSION['SUNSHINE_USER_NAME'];
	$RecordDEPT = $SYSTEM_FILTER_ARRAY['CheckFieldNameDEPT'];
	$RecordDEPT = $columns[$RecordDEPT];
	$RecordUser = $SYSTEM_FILTER_ARRAY['CheckFieldNameUSER'];
	$RecordUser = $columns[$RecordUser];
	//$USER_PRIV = returntablefield("user_priv","USER_PRIV",$USER_PRIV_ID,"PRIV_NO");
	//print $USER_PRIV=6;
	//print_R("USER_PRIV:".$USER_PRIV);

	$row_element_counter=0;
	//############################################################

	//############################################################
	//print_R($fields['value']);
	global $ondblclick_config;
	$ondblclick_config_array = explode(':',$ondblclick_config);
	foreach($fields['value'] as $list)		{
		$ondblclick_config = $ondblclick_config_array[0];
		//�õ�ԭʼ�ģ�û�й��˵ĸ����ֶε�ֵ
		$list2 = $fields['value2'][$row_element_counter];
		
		//ԭ���ݴ���ʼ
		$linkvalue=$fields['elementlink'][$i-1][$primarykey_index];

		if($list[$primarykey_index]!='')	$linkvalue=$list2[$primarykey_index];
		//print $linkvalue;
		//�ж��Ƿ�Ҫ����������ʾ�ӱ���ϸ
		$openWindowForChild = 0;
		
		switch($ondblclick_config)		{
			case 'init_view':
			default:
				$ondblclick='init_view';
				$actionValue=explode("_",$_GET['action']);

				//����һ���ӱ����ϸ����
				$child_table_name = $ondblclick_config_array[1];
				$child_table_foreignkey = $ondblclick_config_array[2];
				$child_table_foreignkey_backupfield = $ondblclick_config_array[3];
				
				if($child_table_name!=""&&$child_table_foreignkey!="")	{
					$actionValueText="view".$actionValueText;
					$child_columns_ = returntablecolumn($child_table_name);
					$child_columns_foreignkeyName = $child_columns_[$child_table_foreignkey];
					$child_table_name_file = $child_table_name."_newai.php";
					//�ж��û����Զ����ļ��ͱ�ʱ�Ĳ�������
					if($child_columns_foreignkeyName=="")		{
						$child_columns_foreignkeyName = $child_table_foreignkey_backupfield;
					}
					$return = "action=init_default&$child_columns_foreignkeyName=$linkvalue&action_close=close";
					$return = base64_encode($return);
					$return = str_replace('==','',$return);
					//$return = base64_encode($return);
					$openWindowForChild = 1;
				}
				else	{
					$actionValueText="";
					for($m=1;$m<2;$m++)	{
						$actionValueText.="_".$actionValue[$m];
					}
					$openWindowForChild = 0;
					$child_table_name_file = "";
					
					$actionValueText="view".$actionValueText;
					$return=FormPageAction("action",$actionValueText,$primarykey_index,$linkvalue,'',"selectid",'');
				}
				break;
			case 'init_edit':
				$ondblclick='init_edit';
				$actionValue=explode("_",$_GET['action']);
				$actionValueText="";
				for($m=1;$m<sizeof($actionValue);$m++)	{
					$actionValueText.="_".$actionValue[$m];
				}
				$actionValueText="edit".$actionValueText;
				$return=FormPageAction("action",$actionValueText,$primarykey_index,$linkvalue,'',"selectid",'');
				break;
			case 'init_project':
				$ondblclick='init_project';
				$actionValue=explode("_",$_GET['action']);
				$actionValueText="";
				for($m=1;$m<sizeof($actionValue);$m++)	{
					$actionValueText.="_".$actionValue[$m];
				}
				$actionValueText="project".$actionValueText;
				$return=FormPageAction("action",$actionValueText,$primarykey_index,$linkvalue,'',"selectid",'');
				break;
		}
		
		//$return=returnpageaction($ondblclick,array('index_name'=>$primarykey_index,'index_id'=>$linkvalue,'index_name2'=>'selectid','index_id2'=>''));
		//�ж���˫�����뻹��˫����������
		if($openWindowForChild=="1")			{
			$ondblclick_window = "window.open('".$child_table_name_file."?".$return."','Detail','height=450,width=800,status=yes,toolbar=yes,menubar=no,scrollbars=yes,resizable=yes,location=no')";
			$ondblclick = "title='".$common_html['common_html']['ondblclick']."' ondblclick=\"$ondblclick_window\"";

			//open("Webpage.asp?",Derek,"height=100,width=100,status=yes,toolbar=yes,menubar=no,location=no");
			$ondblclick = $row_array[0]!="" ? $ondblclick : '';
			$ondblclick_config!="" ? '' : $ondblclick='';
		}
		else	{
			$ondblclick = "ondblclick=\"location='$child_table_name_file?$return'\"";
			$ondblclick = $row_array[0]!="" ? $ondblclick : '';
			$ondblclick_config!="" ? '' : $ondblclick='';
		}
		
		//############################################################
		//�˲������Ϊ������Ŀ��ģ����ƣ�����ÿ�Ŀ¼���֮�������Ŀ¼
		
		if(sizeof($child_filter_array)>1)			{
			$onclick=" onClick=\"JumpToDetail(".$list[$child_primarykeyIndex].");\"";
		}
		else	{
			$onclick="";
		}

		//############################################################
		//����$SYSTEM_RECORD_EDIT_PRIV˵��������EDIT��DELETE�м�¼��Ϊ
				
		print_r($ColumnName1);
		if($list2[$ColumnName1]!=""&&$ColumnName1!="")		{
			if($USER_NAME==$list2[$ColumnName1] || $USER_PRIV==1 || $USER_PRIV==2 || $USER_PRIV==3)			{
				// || $USER_PRIV==1 || $USER_PRIV==2 || $USER_PRIV==3
				$SYSTEM_RECORD_VIEW_PRIV = 1 ;
				$SYSTEM_RECORD_EDIT_PRIV = 1 ;
				$SYSTEM_RECORD_DELETE_PRIV = 1;
				$SYSTEM_RECORD_SHENHE_PRIV =1;
				$SYSTEM_RECORD_FLOW_PRIV =1;
				$SYSTEM_RECORD_NEXT_PRIV =1;
				$checkboxname = "selectid";
				$disabled = "";
			}
			else		{
				$SYSTEM_RECORD_VIEW_PRIV = 0 ;
				$SYSTEM_RECORD_EDIT_PRIV = 0 ;
				$SYSTEM_RECORD_DELETE_PRIV = 0;
				$SYSTEM_RECORD_SHENHE_PRIV =0;
				$SYSTEM_RECORD_FLOW_PRIV =0;
				$SYSTEM_RECORD_NEXT_PRIV =0;
				$disabled = "disabled";
				$checkboxname = "selectid";
			}
		}
		else		{
			$SYSTEM_RECORD_VIEW_PRIV = 1 ;
			$SYSTEM_RECORD_EDIT_PRIV = 1 ;
			$SYSTEM_RECORD_DELETE_PRIV = 1;
			$SYSTEM_RECORD_SHENHE_PRIV =1;
			$SYSTEM_RECORD_FLOW_PRIV =1;
			$SYSTEM_RECORD_NEXT_PRIV =1;
			$disabled = "";
			$checkboxname = "selectid";
		}
		
		//����Ȩ������Ϊ�ⲿ��Ȩ��ϵͳ���ã����ⲿ������һ����Ȩ�޵ĵ���
		//һ�������Ϊ�û��Զ����ļ��ж�����ص�Ȩ����Ϣ�����÷���Ϊ:"����_PRIV"�ĸ�ʽ
		//print_R($fields['edit_priv']);
		
		if($fields['view_priv'][$row_element_counter]==1)		{
			$SYSTEM_RECORD_VIEW_PRIV = 0 ;
			$disabled = "disabled";
			$checkboxname = "selectid";
			
		}
		if($fields['edit_priv'][$row_element_counter]==1)		{
			$SYSTEM_RECORD_EDIT_PRIV = 0 ;
			$disabled = "disabled";
			$checkboxname = "selectid";
			
		}
		if($fields['delete_priv'][$row_element_counter]==1)		{
			$disabled = "disabled";
			$checkboxname = "selectid";
			$SYSTEM_RECORD_DELETE_PRIV = 0;
		}
		if($fields['shenhe_priv'][$row_element_counter]==1)		{
			//$disabled = "disabled";
			$checkboxname = "selectid";
			$SYSTEM_RECORD_SHENHE_PRIV = 0;
		}
		if($fields['flow_priv'][$row_element_counter]==1)		{
			//$disabled = "disabled";
			$checkboxname = "selectid";
			$SYSTEM_RECORD_FLOW_PRIV = 0;
		}
		if($fields['next_priv'][$row_element_counter]==1)		{
			//$disabled = "disabled";
			$checkboxname = "selectid";
			$SYSTEM_RECORD_NEXT_PRIV = 0;
		}
		
		//print $list_index;
		//print_R($fields['userdefine']);
		//print $SYSTEM_RECORD_DELETE_PRIV;
		////SYSTEM_RECORD_EDIT_PRIV  Ϊ0ʱ����ʾѡ�Ϊ1ʱ��ʾѡ��
		//############################################################

		//############################################################
		//������ֲ����ԭ�������棬�ֵ�Ϊ����##########################
		//############################################################
		$DataRowOperation = "";
		$row_value_array=explode(',',$row_userpriv_text[$row_element_counter]);

		if(in_array($USER_ID,$row_value_array)||sizeof($row_value_array)<=1)			{
		$DataRowOperationArray=array();
		for($i=0;$i<sizeof($row_array);$i++)		{

			$element_array=explode(':',$row_array[$i]);
		
		switch($element_array[0])			{
			case 'view':
				//$ondblclick='init_view';
				
				if($SYSTEM_RECORD_VIEW_PRIV==1)		
				{
					$actionValueText="";
						//��ʾ������������
						$title1 = $common_html['common_html']['view'];
						$title2 = $element_array[1];
						if($html_etc[$tablename][$title2]=="")			{
							$titleText = $title1;
						}
						else	{
							$titleText = $html_etc[$tablename][$title2];
						}
	
					$actionValue=explode("_",$_GET['action']);
					
					if(sizeof($actionValue)>2)	{
						array_pop($actionValue);
					}
					array_shift($actionValue);
					
					$actionValueText = join("_",$actionValue);
					$actionValueText = $element_array[1];
					
					$return=FormPageAction("action",$actionValueText,$primarykey_index,$linkvalue,"selectid");
					//����������������Ҫ��Ҫ���е���һ����ϸ���ڣ�һ������»���ת�鿴ҳ�档2007-4-24 14:42
					
					if($openWindowForChild=="1")			{
						//$DataRowOperation .= "<a href=\"#\" onClick=\"javascript:$ondblclick_window\" title=\"".$titleText."\">".$titleText."</a>&nbsp&nbsp\n";
						$BooleanViewRow = $ondblclick_window;
					}
					else	{
						
						//$DataRowOperation .= "<a href=\"?$return\" title=\"".$titleText."\">".$titleText."</a>&nbsp&nbsp\n";
						$BooleanViewRow = $return;
					}
				
				}
				else 
				{
					$BooleanViewRow="";
				}
				break;
			case 'edit':
				//$ondblclick='init_edit';
				$actionValueText="";

				$actionValue=explode("_",$_GET['action']);
				
				if(sizeof($actionValue)>2)	{
					array_pop($actionValue);
				}
				array_shift($actionValue);
				$actionValueText = join("_",$actionValue);
				
				//���µ�LINK ACTION�滻�ɵĴ���ҳGET����ֱ�Ӽ̳е�����
				$actionValueText = $element_array[1];
				
				//�����������������ǰ�����ļ�����
				if($actionValueText=="edit")		{
					$actionValueText = "edit_default";
				}

				if($SYSTEM_RECORD_EDIT_PRIV==1)			{
					//��ʾ������������
					$title1 = $common_html['common_html']['edit'];
					$title2 = $element_array[1];
					if($html_etc[$tablename][$title2]=="")			{
						$titleText = $title1;
					}
					else	{
						$titleText = $html_etc[$tablename][$title2];
					}
					
					$return=FormPageAction("action",$actionValueText,$primarykey_index,$linkvalue,"selectid");
					$BooleanEditRow = $return;
					if($actionValueText!='edit_default')
					{
						$DataRowOperation .= "<a href=\"?$return\" title=\"".$titleText."\">".$titleText."</a>&nbsp\n";
						array_push($DataRowOperationArray,array("href"=>"?$return","text"=>$titleText));
					}
				}
				else	{
					$BooleanEditRow = "";
			
				}
				break;
			case 'userdefine':
				//print_R($element_array);
				$actionValueText = $element_array[1];
				$actionValuePage = $element_array[2];
					//��ʾ������������
					$title1 = $common_html['common_html']['edit'];
					$title2 = $element_array[1];
					if($html_etc[$tablename][$title2]=="")			{
						$titleText = $title1;
					}
					else	{
						$titleText = $html_etc[$tablename][$title2];
					}
				$return=FormPageAction("action",$actionValueText,$primarykey_index,$linkvalue,"selectid");
				//$BooleanEditRow = $return;
				$DataRowOperation .= "<a href=\"$actionValuePage?$return\" title=\"".$titleText."\">".$titleText."</a>&nbsp\n";
				array_push($DataRowOperationArray,array("href"=>"?$actionValuePage","text"=>$titleText));
				break;
			case 'shenhe':
				if($SYSTEM_RECORD_SHENHE_PRIV==1)
				{
					$actionValueText = $element_array[1];
					$actionValuePage = $element_array[2];
					$target = $element_array[3];
					//��ʾ������������
					$title1 = $common_html['common_html']['edit'];
					$title2 = $element_array[1];
					if($html_etc[$tablename][$title2]=="")			{
						$titleText = $title1;
					}
					else	{
						$titleText = $html_etc[$tablename][$title2];
					}
				$return=FormPageAction("action",$actionValueText,$primarykey_index,$linkvalue,"selectid");
				//$BooleanEditRow = $return;
					if($target!="")
					{
						$DataRowOperation .= "<a href=\"$actionValuePage?$return\" title=\"".$titleText."\" target=\"$target\">".$titleText."</a>&nbsp\n";
						array_push($DataRowOperationArray,array("href"=>"$actionValuePage?$return","text"=>$titleText,"target"=>$target));
					}
					else 
					{
						$DataRowOperation .= "<a href=\"$actionValuePage?$return\" title=\"".$titleText."\">".$titleText."</a>&nbsp\n";
						array_push($DataRowOperationArray,array("href"=>"$actionValuePage?$return","text"=>$titleText));
					}
				}
				break;
			case 'flow':
				if($SYSTEM_RECORD_FLOW_PRIV==1)
				{
				$actionValueText = $element_array[1];
				$actionValuePage = $element_array[2];
				$target = $element_array[3];
					//��ʾ������������
					$title1 = $common_html['common_html']['edit'];
					$title2 = $element_array[1];
					if($html_etc[$tablename][$title2]=="")			{
						$titleText = $title1;
					}
					else	{
						$titleText = $html_etc[$tablename][$title2];
					}
					$return=FormPageAction("action",$actionValueText,$primarykey_index,$linkvalue,"selectid");
					if($target!="")
					{
						$DataRowOperation .= "<a href=\"$actionValuePage?$return\" title=\"".$titleText."\" target=\"$target\">".$titleText."</a>&nbsp\n";
						array_push($DataRowOperationArray,array("href"=>"$actionValuePage?$return","text"=>$titleText,"target"=>$target));
					}
					else 
					{
						$DataRowOperation .= "<a href=\"$actionValuePage?$return\" title=\"".$titleText."\">".$titleText."</a>&nbsp\n";
						array_push($DataRowOperationArray,array("href"=>"$actionValuePage?$return","text"=>$titleText));
					}
				
				}
				break;
			case 'next':
				if($SYSTEM_RECORD_NEXT_PRIV==1)
				{
					$actionValueText = $element_array[1];
					$actionValuePage = $element_array[2];
					$target = $element_array[3];
			
					//��ʾ������������
					$title1 = $common_html['common_html']['edit'];
					$title2 = $element_array[1];
					if($html_etc[$tablename][$title2]=="")			{
						$titleText = $title1;
					}
					else	{
						$titleText = $html_etc[$tablename][$title2];
					}
					
					$return=FormPageAction("action",$actionValueText,$primarykey_index,$linkvalue,"selectid");
					//$BooleanEditRow = $return;
					
					if($target!="")
					{
						$DataRowOperation .= "<a href=\"$actionValuePage?$return\" title=\"".$titleText."\" target=\"$target\">".$titleText."</a>&nbsp\n";
						array_push($DataRowOperationArray,array("href"=>"$actionValuePage?$return","text"=>$titleText,"target"=>$target));
					}
					else 
					{
						$DataRowOperation .= "<a href=\"$actionValuePage?$return\" title=\"".$titleText."\">".$titleText."</a>&nbsp\n";
						array_push($DataRowOperationArray,array("href"=>"$actionValuePage?$return","text"=>$titleText));
					}
				}
				break;
			case 'delete':
				//2011-11-08��������ж�,���ǲ�����Ҫ�ṩɾ������
				global $ForeignKeyIndex,$columns;
				if($ForeignKeyIndex!='')											{
					$ForeignKeyIndexFORArray = explode(',',$ForeignKeyIndex);
					for($xx=0;$xx<sizeof($ForeignKeyIndexFORArray);$xx++)			{
						$ForeignKeyIndexX			= $ForeignKeyIndexFORArray[$xx];
						$ForeignKeyIndexArray		= explode(':',$ForeignKeyIndexX);
						$ForeignKeyIndexFieldIndex	= $ForeignKeyIndexArray[0];
						$ForeignKeyIndexTableName	= $ForeignKeyIndexArray[1];
						$ForeignKeyIndexTableIndex  = $ForeignKeyIndexArray[2];

						$ForeignKeyIndexFieldName	= $columns[$ForeignKeyIndexFieldIndex];
						$ForeignKeyIndexFieldValue	= $list2[$ForeignKeyIndexFieldName];
						$child_columns_index		= returntablecolumn($ForeignKeyIndexTableName);
						$ForeignKeyIndexTableFieldName = $child_columns_index[$ForeignKeyIndexTableIndex];
						$sql = "select COUNT(*) AS NUMX from $ForeignKeyIndexTableName where $ForeignKeyIndexTableFieldName='$ForeignKeyIndexFieldValue'";
						//print $sql;
						$rs  = $db->CacheExecute(150,$sql);
						$NUMX = $rs->fields['NUMX'];
						if($NUMX>0)		{
							$TEMP_VAR_SHOP_DELETE = 1;	//��������,���������ɾ����ť
							break;
						}
						else	{
							$TEMP_VAR_SHOP_DELETE = 0;	//û������,�����ṩɾ����ť
						}
						//print $ForeignKeyIndexTableFieldName;
						//print_R($child_columns_index);
					}
				}

				$temp_array=explode('_',$element_array[1]);
				sizeof($temp_array)==1?$element_array[1]='delete_array':'';
				$actionValue=$element_array[1];
				$actionValue!=""?'':$actionValue="delete_array";
				if($SYSTEM_RECORD_DELETE_PRIV==1&&$TEMP_VAR_SHOP_DELETE==0)				{
					$return=FormPageAction("action",$actionValue,"selectid",$linkvalue,$primarykey_index);
					$DataRowOperation .= "<a href=\"javascript:if(confirm('".$common_html['common_html']['reallydelete']."'))location='?$return'\" title=\"".$common_html['common_html']['delete']."\">".$common_html['common_html']['delete']."</a>&nbsp\n";
					array_push($DataRowOperationArray,array("href"=>"javascript:if(confirm('".$common_html['common_html']['reallydelete']."'))location='?$return'","text"=>$common_html['common_html']['delete']));
				}
				elseif($SYSTEM_RECORD_DELETE_PRIV==1&&$TEMP_VAR_SHOP_DELETE==1)			{
					$ForeignKeyIndexTableNameMEMO = returntablefield("systemlang","tablename",$ForeignKeyIndexTableName,"chinese","fieldname",$ForeignKeyIndexTableName);
					$return=FormPageAction("action",$actionValue,"selectid",$linkvalue,$primarykey_index);
					$DataRowOperation .= "<font color=gray title='����ɾ���˼�¼,��������֮��ص���ϸ���м�:[".$ForeignKeyIndexTableNameMEMO."]ģ����ɾ���뵱ǰ��¼��ص�����,�漰����:".$NUMX."��.'>".$common_html['common_html']['delete']."</font>&nbsp\n";
				}
				break;

		}//	--end switch
		}//		--end for
		}//			--end row_userpriv
		//############################################################
		//�ײ����ܣ�ԭ�������棬�ּ��뵯���˵���##########################
		//############################################################
		global $bottom_element;
		$bottom_array=explode(',',$bottom_element);
		for($i=0;$i<sizeof($bottom_array);$i++)				
		{
			$element_array=explode(':',$bottom_array[$i]);
			$index_name=$element_array[1]==''?$element_array[0]:$element_array[1];
			if($element_array[0]=='operation')					
			{
				
				$lastactionname="action=operation_".$element_array[1]."&selectid=$linkvalue";
				$lastactionname="?".base64_encode($lastactionname);
				
				if($element_array[1]=='sendsms' && !validateSingleMenuPriv('�ֻ�����'))
 					continue;
 				if($element_array[1]=='sendemail' && !validateSingleMenuPriv('�����ʼ�'))
 					continue;
				if($element_array[3]!="")
					array_push($DataRowOperationArray,array("href"=>$lastactionname,"text"=>$common_html['common_html'][$index_name],"target"=>$element_array[3]));
				else
					array_push($DataRowOperationArray,array("href"=>$lastactionname,"text"=>$common_html['common_html'][$index_name]));
					
			}
		}
		
		//############################################################
		//�����м�¼��������##########################################
		//############################################################
			global $onclick_config;
			if($onclick_config!="")						{
				$functionName = $onclick_config;
				$fileName = $onclick_config.".php";
				$fileName0 = "userdefine/$fileName";
				$fileName = "../../Enginee/userdefine/$fileName";
				if(file_exists($fileName0))		{
					require_once($fileName0);
					$functionName = $functionName."_Value";
					if(function_exists($functionName))	{
						$onclick_text = $functionName($fields['value'][$row_element_counter][$list_index],$fields,$row_element_counter);
					}
				}
				else if(file_exists($fileName))		{
					require_once($fileName);
					$functionName = $functionName."_Value";
					if(function_exists($functionName))	{
						$onclick_text = $functionName($fields['value'][$row_element_counter][$list_index],$fields,$row_element_counter);
					}
					else	{
						print "��������[$functionName]�����ڣ�";
					}
				}
				else	{
					print "û����Ӧ�ļ�,�ļ�����$fileName";
				}
			}
		//print $onclick_text;
		//############################################################
		//��ʼ�ж��Ƿ����[��]��������ʼ##############################
		//############################################################
		if(is_file("images/edit1.gif"))		{
			$EditImagePath1 = "images/edit1.gif";
			$EditImagePath2 = "images/edit2.gif";
			$ViewImagePath = "images/view.gif";
			$DropImagePath = "images/drop.gif";
		}
		else if(is_file("../Framework/images/edit1.gif"))		{
			$EditImagePath1 = "../Framework/images/edit1.gif";
			$EditImagePath2 = "../Framework/images/edit2.gif";
			$ViewImagePath = "../Framework/images/view.gif";
			$DropImagePath = "../Framework/images/drop.gif";
		}
		else if(is_file("../../../Framework/images/edit1.gif"))		{
			$EditImagePath1 = "../../../Framework/images/edit1.gif";
			$EditImagePath2 = "../../../Framework/images/edit2.gif";
			$ViewImagePath = "../../../Framework/images/view.gif";
			$DropImagePath = "../../../Framework/images/drop.gif";
		}
		else	{
			$EditImagePath1 = "../../Framework/images/edit1.gif";
			$EditImagePath2 = "../../Framework/images/edit2.gif";
			$ViewImagePath = "../../Framework/images/view.gif";
			$DropImagePath = "../../Framework/images/drop.gif";
		}
		
		//�༭�����ı���ʾ
		
		if($BooleanEditRow!="")		{
			$CheckboxImage  = " <a href=\"?$BooleanEditRow\"><img src=\"$EditImagePath1\" title=\"".$common_html['common_html']['edit'].$common_html['common_html']['record']."\" border=0></a>";
		}
		else	{
			//$CheckboxImage  = " <img src=\"$EditImagePath2\" title=\"".$common_html['common_html']['edit'].$common_html['common_html']['record']."\" border=0>";
			$CheckboxImage = "";
		}

		//�鿴�����ı���ʾ
		$pathViewShow = "<img src=\"$ViewImagePath\" title=\"".$common_html['common_html']['view'].$common_html['common_html']['record']."\" border=0>";
		
		if($BooleanViewRow!="")	{
			$CheckboxImage .= " <a href=\"?$BooleanViewRow\" title=\"".$common_html['common_html']['view'].$common_html['common_html']['record']."\">".$pathViewShow."</a>\n";
		}
		if($BooleanViewRow=="" && ($ondblclick_config=='init_view'))
			$ondblclick='';
		if($BooleanEditRow=="" && $ondblclick_config=='init_edit')
			$ondblclick='';	
		
		if(sizeof($DataRowOperationArray)>0)
		{
			$CheckboxImage.="<span id='divTest$row_element_counter' style='cursor:pointer;' ><img src='$DropImagePath' border=0 title='�������'></span>\n";
			print "<script type='text/javascript'>
			$(function() {
			$('#divTest$row_element_counter').powerFloat({
					
			    	eventType: \"click\",
					target: [
						";
			foreach ($DataRowOperationArray as $DataRowlist)
			{
				print "{
							href:\"".$DataRowlist['href']."\",
							target:\"".$DataRowlist['target']."\",
							text:\"".$DataRowlist['text']."&nbsp;\"	
						},";
			}
			print"
					],
					targetMode: \"list\"	
				});
			});
			 </script>";
		}
		
		//############################################################
		//��ʼ�ж��Ƿ����[��]����������##############################
		//############################################################

		$just_row_array = explode(":",$row_array[0]);
		//print_R($bottom_array);
		if($row_element_counter%2==1)		{
			$TDBgColor = "#e9f5fa";
			$TDonMouseOut = "#e9f5fa";
			$TDonMouseOver = "#d0ecfa";
			$ClassHeader = "TableLine1";
		}
		else	{
			$TDBgColor = "#FFFFFF";
			$TDonMouseOut = "#FFFFFF";
			$TDonMouseOver = "#d0ecfa";
			$ClassHeader = "TableLine2";
		}
		//onMouseOver=bgColor='".$TDonMouseOver."' onMouseOut=bgColor='".$TDonMouseOut."'  bgColor='".$TDBgColor."'
		print "<TR class=$ClassHeader  $onclick_text name='maindata'>\n";
		//�ж�CHECKBOX���ֵ�ѡ��
		if($row_array[0]!=""||sizeof($bottom_array)>1)		{
			print "<TD noWrap  align=middle>";
		}
		//CHECKBOX���֣��༭ѡ�ȫѡ���ִ�
		//print_R($just_row_array);
		//if(($row_array[0]!=""&&$just_row_array[0]!="view")||$bottom_array[0]!="")				{
		if($bottom_array[0]!="")				{
			print "<input accesskey='".$row_element_counter_array[$row_element_counter]."' $disabled type=\"checkbox\" title=\"".$common_html['common_html']['choose']."".$common_html['common_html']['this']."".$common_html['common_html']['record']." ".$common_html['common_html']['accesskey'].":ALT+".$row_element_counter_array[$row_element_counter]."\" name=\"$checkboxname\" value=\"".Trim($linkvalue)."\">";
		}
		//�༭ѡ��鿴ѡ��
		if($row_array[0]!=""||sizeof($bottom_array)>1)		{
			print $CheckboxImage;
		}
		if($row_array[0]!=""||sizeof($bottom_array)>1)		{
			print "</TD>";
		}
		//print $primarykey_index;

		$xxx = 0;
		foreach($fields['name'] as $list_header)	{

			//print_R($SYSTEM_FILTER_ARRAY);
			//����Ҫ��ʾ������Ԫ�� //������ʾ��
			//$ShowElement = returnPrivateTwoArray($SYSTEM_FILTER_ARRAY,$USER_PRIV,$list_header,$list[$list_header],$list2[$RecordDEPT],$list2[$RecordUser]);
			$inputtext=$fields['INPUT_TEXT'][$list_header];
			$inputsize=$fields['inputsize'][$list_header];
			
			if($inputtext=="private")
			{
				$grade=str_split($inputsize);
				if(!in_array($_SESSION['LOGIN_USER_PRIV'], $grade))
					continue;
			}
			$ShowElement = $list[$list_header];

			//�ж��ֶ���������������Ƿ���ʾ˫���¼�
			$fieldfilter = $fields['filter'][$xxx]; $xxx += 1;
			if($fieldfilter=="notshow" || $fieldfilter=="nowshow")
				continue;
			if($fieldfilter=="ajaxinputhidden")			{
				//$ondblclick_Text2  = "";
			}
			else	{
				//$ondblclick_Text2 = $ondblclick ;
			}

			//�ڴ��ж�TEXTAREABR�����Ƿ����NOWRAP���Խ���
			if($fieldfilter=="textareabr")		{
				$trnowrap = "";
			}
			else	{
				$trnowrap = "noWrap";
			}

			print "<TD $trnowrap  align=left $ondblclick >".$ShowElement."</TD>\n";
			switch($list_header)		{
			case $row_userpriv_array[1]:
				$row_userpriv_text[$row_element_counter]=$row_userpriv_text[$row_element_counter].",".$list[$list_header];
			case $row_userpriv_array[2]:
				$row_userpriv_text[$row_element_counter]=$row_userpriv_text[$row_element_counter].",".$list[$list_header];
				break;
			}
		}



		$i++;

		$row_array[0]!=""?print "<TD  noWrap align=middle>$DataRowOperation</TD>\n":'';
		//������ʾ�����γ����������沿��
		print "</TR>";
		$row_element_counter++;
	}
	return $fields;
}

function UserDefineFunction($list='')		{
	global $UserDefineFunction;
	global $fields;
	if($UserDefineFunction!="")		{
	require_once("UserDefineFunction.php");
	print "<tr>\n";
	print "<td class=TableData noWrap colspan='".$fields['table']['colspan']."'>";
	$UserDefineFunction($list);
	print "&nbsp;</td></tr>";
	}
}

//���ڶ��������ĺ�
function UserSumFunction($fields)						{
	global $UserSumFunction,$UserUnitFunction;
	if($UserSumFunction=="")		return;//��ʾδ����,ֱ�ӷ���
	$�б���ʾ����	= $fields['other']['sum_number'];
	
	$�б���ʾ��		= @array_keys($�б���ʾ����);
	
	print "<tr>\n";
	print "<td class=TableData noWrap colspan='".$fields['table']['colspan']."'>";
	print "�ܼ�¼��:<font color=red>".$fields['other']['rc']." ��</font> ";
	
	
	for($i=0;$i<sizeof($�б���ʾ��);$i++)		{
		$�б����� = $�б���ʾ��[$i];
		$�б��� = num2rmb($�б���ʾ����[$�б�����]);
		
		if($�б��� =="���̫��")		$�б��� = '';
		
	
		
		if($UserUnitFunction=="RMB")			{
			print "".$�б�����."�ϼ�:<font color=red>".$�б���ʾ����[$�б�����]."Ԫ($�б���)</font> ";
		}
		else	{
			print "".$�б�����."�ϼ�:<font color=red>".$�б���ʾ����[$�б�����]." $UserUnitFunction</font>";
		}
	}
	print "&nbsp;</td></tr>";
}


function newaiinit_bottommemo()						{
	global $fields;
	//print_R($_GET);
	if($_SESSION['ָ�����']!="")					{
		print "<tr>\n";
		print "<td class=TableData noWrap colspan=".$fields['table']['colspan'].">";
		print $_GET['ϵͳ˵��'];
		print "</td></tr>";
	}
	if($_SESSION['ָ����Ա']!="")					{
		print "<tr>\n";
		print "<td class=TableData noWrap colspan=".$fields['table']['colspan'].">";
		print $_GET['ϵͳ˵��'];
		print "</td></tr>";
	}
}

function newaiinit_bottom($rc,$pageid,$pagenums,$ROWS_PAGE,$add,$add_var,$action_page='action_page',$action_page_value='action_page_value')		{
global $common_html,$html_etc;
global $_GET,$_POST,$read_type;
global $bottom_element;//print $bottom_element;
global $edit_attribute,$group_user,$primarykey_index;
global $row_element,$primarykey,$columns;
global $tablename;
$primarykey_index=$columns[$primarykey];
global $fields;

$row_element_array=explode(',',$bottom_element);
for($i=0;$i<sizeof($row_element_array);$i++)		{
	$row_element_array_element=explode(':',$row_element_array[$i]);
	$row_element_index[(string)$row_element_array_element[0]]=$row_element_array_element[1];//print_R($row_element_index);
	$row_element_index[(string)$row_element_array_element[2]]=$row_element_array_element[3];//print_R($row_element_index);
}

$init=$_GET['action'];
$init_array=explode('_',$init);
$init=$init_array[0]."_".$init_array[1];
//require_once("lib2.inc.php");
print "<tr>\n";
print "<td class=TableData noWrap colspan=".$fields['table']['colspan'].">";
if($rc==0)	$disabled='disabled'; else	$disabled='';
$bottom_array=explode(',',$bottom_element);
for($i=0;$i<sizeof($bottom_array);$i++)				{
$element_array=explode(':',$bottom_array[$i]);
$index_name=$element_array[1]==''?$element_array[0]:$element_array[1];
switch($element_array[0])					{
	case 'chooseall':
		print "<input type=\"checkbox\" name=\"allbox\" id='allbox' $disabled accesskey='c' title=\"".$common_html['common_html']['accesskey'].":ALT+C\" onClick=\"check_all();\">".$common_html['common_html']['chooseall']." &nbsp;&nbsp;\n";
		break;
	case 'delete':
		$row_element_index_delete=$row_element_index['delete'];
		$temp_array=explode('_',$row_element_index_delete);//print_R(sizeof($temp_array));
		sizeof($temp_array)==1?$row_element_index_delete='delete_array':'';
		$row_element_index_delete=$element_array[1];
		$row_element_index_delete!=""?'':$row_element_index_delete="delete_array";
		print "<input type=\"button\"  accesskey='d' value=\"".$common_html['common_html']['delete']."\" class=\"SmallButton\" $disabled onClick=\"delete_element('$init','$row_element_index_delete');\" title=\"".$common_html['common_html']['accesskey'].":ALT+D ".$common_html['common_html']['accesskeyusermethod']."\"> &nbsp;&nbsp;\n";
		break;
	case 'operation':
		$row_element_index_delete=$row_element_index['operation'];
		$temp_array=explode('_',$row_element_index_delete);
		
		sizeof($temp_array)==1?$row_element_index_delete='operation_':$row_element_index_delete='';
 		$lastactionname="action=".$row_element_index_delete.$element_array[1];
 		if($element_array[1]=='sendsms' && !validateSingleMenuPriv('�ֻ�����'))
 			break;
 		if($element_array[1]=='sendemail' && !validateSingleMenuPriv('�����ʼ�'))
 			break;
		print "<input type=\"button\" value=\"".$common_html['common_html'][$index_name]."\" class=\"SmallButton\" $disabled onClick=\"operation_element('$lastactionname','$element_array[3]');\" title=\"".$common_html['common_html'][$index_name]."\"> &nbsp;&nbsp;\n";
		//$return_forward=FormPageAction("action","report_default");
		//print "<input type=\"button\"  accesskey='d' value=\"".$common_html['common_html'][$index_name]."\" class=\"SmallButton\" $disabled onClick=\"operation_element('$return_add');\" title=\"".$common_html['common_html'][$index_name]."\"> &nbsp;&nbsp;\n";
		break;
	case 'edit':
		$actionValueText="";
		if($element_array[1]=="edit")	$element_array[1] = "edit_default";
		$actionValue=explode("_",$element_array[1]);
		for($m=1;$m<sizeof($actionValue);$m++)	{
			$actionValueText.="_".$actionValue[$m];
		}
		$actionValueText="edit".$actionValueText;


		$title1 = $common_html['common_html']['edit'];
		$title2 = $actionValueText;
		if($html_etc[$tablename][$title2]=="")			{
			$titleText = $title1;
		}
		else	{
			$titleText = $html_etc[$tablename][$title2];
		}
		//print_R($tablename);
		$return_add=FormPageAction("action",$actionValueText,'','',"selectid");
		$row_element_index_edit=$row_element_index['edit'];
		print "<input type=\"button\"  accesskey='e' value=\"".$titleText."\" class=\"SmallButton\" $disabled onClick=\"edit_element('$init_array[1]','$return_add');\" title=\" ".$common_html['common_html']['accesskey'].":ALT+E ".$common_html['common_html']['accesskeyusermethod']."\"> &nbsp;&nbsp;\n";
		break;
	case 'move':
		print "<input type=\"button\"  accesskey='m' value=\"".$common_html['common_html']['move']."\" class=\"SmallButton\" $disabled onClick=\"move_element('$init');\" title=\"".$common_html['common_html']['move']."\"> &nbsp;&nbsp;\n";
		break;

}//end switch
}
//print_R($add_var);;
//print $return=returnpageaction($mode='page',array('index_name'=>'pageid','index_id'=>1));
if($add!=""&&$add_var!="")	{
/*
	if($pageid<=1) {echo "".$common_html['common_html']['firstpage']."��";echo "".$common_html['common_html']['prevpage']."��";}
	else {
	$return=FormPageAction("pageid",1);
	echo "<a href=\"?$return\"  accesskey='f' title=\"".$common_html['common_html']['firstpage']."\">".$common_html['common_html']['firstpage']."</a>��";
	$return=FormPageAction("pageid",$pageid-1);
	echo "<a href=\"?$return\"  accesskey='p' title=\"".$common_html['common_html']['prevpage']."\">".$common_html['common_html']['prevpage']."</a>��";
	}//end if
	if($pageid==$pagenums) {echo "".$common_html['common_html']['nextpage']."��";echo "".$common_html['common_html']['lastpage']."";}
	else {
	$return=FormPageAction("pageid",$pageid+1);
	echo "<a href=\"?$return\" accesskey='n' title=\"".$common_html['common_html']['nextpage']."\">".$common_html['common_html']['nextpage']."</a>��";
	$return=FormPageAction("pageid",$pagenums);
	echo "<a href=\"?$return\" accesskey='l' title=\"".$common_html['common_html']['lastpage']."\">".$common_html['common_html']['lastpage']."</a>��";
	}//end if
	*/

if($pagenums<=30)							{
	for($i=1;$i<=$pagenums;$i++)				{
		if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
		$return=FormPageAction("pageid",$i);
		print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
	}
}

$PrevPageNumber = 8;
$LastPageNumber = 4;

$tempNumber = $pagenums-$LastPageNumber;
if($pagenums>30)					{
	if($pageid<=$LastPageNumber)						{
		for($i=1;$i<=$PrevPageNumber;$i++)				{
			if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
			$return=FormPageAction("pageid",$i);
			print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
		}
		print "...&nbsp;&nbsp;";
		$leftNumber = $pagenums-$PrevPageNumber-$LastPageNumber;
		$leftNumber = ceil($leftNumber/2);
		$MiddleNumber = ceil($pagenums/2);
		if($leftNumber>2)$leftNumber = 2;
		$BeginNumber = $MiddleNumber-$leftNumber;
		for($i=$BeginNumber;$i<=$BeginNumber+4;$i++)				{
			if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
			$return=FormPageAction("pageid",$i);
			print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
		}
		print "...&nbsp;&nbsp;";
		for($i=$tempNumber;$i<=$pagenums;$i++)				{
			if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
			$return=FormPageAction("pageid",$i);
			print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
		}
	}
	else if($pageid>8&&$pageid<=$tempNumber)						{
		for($i=1;$i<=5;$i++)				{
			if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
			$return=FormPageAction("pageid",$i);
			print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
		}
		print "...&nbsp;&nbsp;";
		if(($tempNumber-$pageid)>=$LastPageNumber)		{
			$Begin = $pageid-4;
			$End = $pageid+$LastPageNumber;
		}
		else	{
			$Begin = $pageid-6;
			$End = $tempNumber-1;
		}
		//print $tempNumber."||".$pageid."||".$Begin."||".$End;
		for($i=$Begin;$i<=$End;$i++)				{
			if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
			$return=FormPageAction("pageid",$i);
			print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
		}
		print "....&nbsp;&nbsp;";
		if($pageid==$tempNumber)		{
			$�������� = $pagenums-3;
			$��ʼ���� = $tempNumber-3;
		}
		else	{
			$�������� = $pagenums;
			$��ʼ���� = $tempNumber;
		}
		for($i=$��ʼ����;$i<=$��������;$i++)				{
			if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
			$return=FormPageAction("pageid",$i);
			print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
		}
	}
	else														{
		//###########################################################
		if($pageid==$PrevPageNumber)		{
			$�������� = $PrevPageNumber+3;
			$��ʼ���� = 3;
		}
		else	{
			$�������� = $PrevPageNumber;
			$��ʼ���� = 1;
		}
		for($i=$��ʼ����;$i<=$��������;$i++)				{
			if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
			$return=FormPageAction("pageid",$i);
			print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
		}
		print "...&nbsp;&nbsp;";
		$leftNumber = $pagenums-$PrevPageNumber-$LastPageNumber;
		$leftNumber = ceil($leftNumber/2);
		$MiddleNumber = ceil($pagenums/2);
		if($leftNumber>2)$leftNumber = 2;
		$BeginNumber = $MiddleNumber-$leftNumber;
		for($i=$BeginNumber;$i<=$BeginNumber+4;$i++)				{
			if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
			$return=FormPageAction("pageid",$i);
			print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
		}
		print "....&nbsp;&nbsp;";
		for($i=$tempNumber;$i<=$pagenums;$i++)				{
			if($pageid==$i) $IText = "<B>$i</B>"; else	$IText = $i;
			$return=FormPageAction("pageid",$i);
			print "<a href=\"$PHP_SELF?$return\">$IText</a>&nbsp;&nbsp;";
		}
	}

}
//��ҳ����
}
else	{
	if($pageid<=1) {echo "".$common_html['common_html']['firstpage']."��";echo "".$common_html['common_html']['prevpage']."��";}
	else {
	$return=FormPageAction("pageid",1);
	echo "<a href=\"?$return\" accesskey='f' title=\"".$common_html['common_html']['firstpage']."\">".$common_html['common_html']['firstpage']."</a>��";
	$return=FormPageAction("pageid",$pageid-1);
	echo "<a href=\"?$return\" accesskey='p' title=\"".$common_html['common_html']['prevpage']."\">".$common_html['common_html']['prevpage']."</a>��";
	}//end if
	if($pageid==$pagenums) {echo "".$common_html['common_html']['nextpage']."��";echo "".$common_html['common_html']['lastpage']."��";}
	else {
	$return=FormPageAction("pageid",$pageid+1);
	echo "<a href=\"?$return\" accesskey='n' title=\"".$common_html['common_html']['nextpage']."\">".$common_html['common_html']['nextpage']."</a>��";
	$return=FormPageAction("pageid",$pagenums);
	echo "<a href=\"?$return\" accesskey='l' title=\"".$common_html['common_html']['lastpage']."\">".$common_html['common_html']['lastpage']."</a>��";
	}//end if
}
//print $add_var;
print "(".$common_html['common_html']['page']."&nbsp;".$pageid."/".$pagenums."&nbsp;&nbsp;".$common_html['common_html']['allnumbers']."&nbsp;".$rc .")&nbsp;&nbsp;\n";
if($add==''||$add_var=='')	{
	$add='add';
	$add_var='add_var';
}
print "<input type=\"hidden\" name=\"ADD_INPUT\" value=\"$add\">\n";
print "<input type=\"hidden\" name=\"ADD_VAR_INPUT\" value=\"$add_var\">\n";
print "<input type=\"hidden\" name=\"action_page\" value=\"$action_page\">\n";
//$return=returnpageaction($mode='init_delete',array());
$return_array=explode('&',$return);
array_shift($return_array);
array_pop($return_array);
$return=join('&',$return_array);

print "<input type=\"hidden\" name=\"action_page_value\" value=\"$return\">\n";
//print "<input type=\"button\"  accesskey='j' value=\"".$common_html['common_html']['indexto']."\" class=\"SmallButton\" onclick=\"set_page('$init');\" title=\"".$common_html['common_html']['indexto']."\">&nbsp;\n";
print "<input type=\"hidden\" name=\"PAGE_NUM\" value=\"$pageid\" accesskey='m' class=\"SmallInput\">\n";


//����ʲô���������ʾҳ�����ֵ�����,���˱���Ϊ1ʱ����ʾ��û�ж��������ֵʱ��ʾ,Ĭ��Ϊ������˱�������ʾ
global $pagestop_model;
if($pagestop_model!="1")					{

print "<select class=\"SmallSelect\" title=\"".$common_html['common_html']['selectpage']."\" onChange=\"var jmpURL='?' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\" name=\"PageSelect\" >
<option value='1' >".$common_html['common_html']['selectpage']."</option>
";

$_GET['pageid']==''?$_GET['pageid']=1:'';

$MaxPageNum = 200;
if($pagenums>$MaxPageNum)				{
	$BeginPage = $_GET['pageid']-$MaxPageNum;
	$EndPage = $_GET['pageid']+$MaxPageNum;
}
else	{
	$BeginPage = 1;
	$EndPage = $pagenums;
}
$BeginPage<1?$BeginPage=1:'';

for($i=$BeginPage;$i<=$EndPage;$i++)		{
	$PageLinkUrl = FormPageAction("pageid",$i);
	if($_GET['pageid']==$i)	{
		$SelectText = "selected";
	}
	else	{
		$SelectText = "";
	}
	print "<option value='$PageLinkUrl' $SelectText >&nbsp;".$common_html['common_html']['page']." $i</option>\n";
}
print "</select>\n";

}//����ҳ���������н���



//��ʾ������ʾ�ı� 2010-9-16 16:05
global $systemorder;
if($systemorder!="")								{
	$systemorderDESCTEXT = array("desc"=>"����","asc"=>"˳��");
	$systemorderArray = explode(',',$systemorder);
	$systemorderTextArray = array();
	for($iA=0;$iA<sizeof($systemorderArray);$iA++)		{
		$systemorderArray2 = explode(':',$systemorderArray[$iA]);
		$systemorderID = $systemorderArray2[0];
		$systemorderDESC = $systemorderArray2[1];
		$systemorderNAME = $html_etc[$tablename][$columns[$systemorderID]];
		if($systemorderNAME!="")		{
			$systemorderTextArray[] .= $systemorderNAME.",".$systemorderDESCTEXT[$systemorderDESC]."";
		}
	}
	$systemorderText = join(' ',$systemorderTextArray);
	$systemorderText = "<font color=gray>[��ҳ������ʽ:".$systemorderText."]</font>";
}



print "$systemorderText</td></tr>\n";
}
?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>