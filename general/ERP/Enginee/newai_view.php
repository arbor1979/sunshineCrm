<?php
ini_set('date.timezone','Asia/Shanghai');
/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：主要实现了输入部分的实现，含：
 　　　　　　ADD ACTION 的实现
			 EDIT ACTION 的实现
			 VIEW ACTION 的实现
 *@函数作者：王纪云
 *@建立日期：2004-12-19
 *@更新日期：2005-10-26
 *@状态说明：注释未完成
 */
function newaiadd($mode)		{
global $fields;
global $html_etc,$common_html,$custom_type;
global $db,$return_sql_line,$columns;
global $_POST,$_GET,$returnmodel;
global $action_submit,$merge,$form_attribute;
global $primary_key,$primarykey_index;
global $_SESSION,$SUNSHINE_USER_NAME_VAR;
$fields['other']['title']=$common_html['common_html'][$mode];
//print_R($html_etc);
//如果为编辑和查看模型，则进行数据的初始化操作
global $ADDINIT;
if($mode!='add')		{
$SQL=$return_sql_line['select_sql']; //print_R($columns);exit;
//print_R($html_etc['application']);
//检测是否进行外来SQL语言执行
global $NEWAIADD_VALUE_SYSTEM;
if(strlen($NEWAIADD_VALUE_SYSTEM)>10)			{
	$SQL=$NEWAIADD_VALUE_SYSTEM;
}
//print $SQL;
$result=$db->Execute($SQL);
$rs_array=$result->GetArray();
if(count($rs_array)==0)
{
	print_infor("找不到记录，可能已删除",'trip',"close","",0);
	exit;
}
$fields['value']=$rs_array[0];

}
else					{
	$fields['value']=$ADDINIT;
}


global $departprivte;
//用户角色级别权限判断，如果是用户自身的记录则可以修改，
//如果不是，那么沿用PRIVATE的权限进行管理
//此区域部分在NEWAI_SQL部分有所复制
if($departprivte!="")		{
$departprivteSQLArray = array();
$departprivteArray = explode('::',$departprivte);
//print_R($departprivteArray);
for($i=0;$i<sizeof($departprivteArray);$i++)	{
	$privText = $departprivteArray[$i];
	$privTextArray = explode(':',$privText);
	switch($privTextArray[0])		{
		case 'user':
			$ColumnIndex1 = $privTextArray[1];
			$USER_NAME = $_SESSION[$SUNSHINE_USER_NAME_VAR];
			$ColumnName1 = $columns[$ColumnIndex1];
			if($ColumnName1!=""&&$fields['value'][$ColumnName1]!="")	{
				if($USER_NAME==$fields['value'][$ColumnName1])		{
					$SYSTEM_PRIVATE_USER_DEFINE_CONTROL = 0 ;
				}
				else	{
					$SYSTEM_PRIVATE_USER_DEFINE_CONTROL = 1;
				}
			}
			else	{
				$SYSTEM_PRIVATE_USER_DEFINE_CONTROL = 0;
			}
			break;
	}//end swtich
}//end for
}//exit;
//print $SYSTEM_PRIVATE_USER_DEFINE_CONTROL;
//print $fields['value'][$ColumnName1];
//print_R($fields['USER_PRIVATE']);
//-------------------------------------------------------------------


//附加的EMAIL控制部分，可以删除
switch($_GET['action'])				{
	case 'edit_reply':
		$fields['form']['action']='action=add_outbox_data';
		break;
	case 'edit_forward':
		$fields['form']['action']='action=add_outbox_data';
		break;
}

//加载JS的条件判断代码，主要用于数据新增和编辑时较验数据的格式是否合格
$tablename=$fields['table']['name'];
$realtablename=$fields['realtable'];
if($form_attribute!='hidden')		{
	if(is_file("../../Enginee/lib/CheckValue.js"))	{
		print "<script language = \"JavaScript\"> ";
		print join('',file("../../Enginee/lib/CheckValue.js"));
		print "</script>";
	}
	else		{
		print "<script language = \"JavaScript\"> ";
		print join('',file("../Enginee/lib/CheckValue.js"));
		print "</script>";
	}
	form_begin($fields['form']['name'],$fields['form']['action'],'post',$fields['null']);
}


global $tablewidth;
$tablewidth=$tablewidth!=""?$tablewidth:450;
table_begin($tablewidth);
switch($_GET['action'])		{
	case 'edit_reply':
		$fields['other']['title']=$common_html['common_html']['reply']." ".$common_html['common_html'][$tablename];
		break;
	case 'edit_forward':
		$fields['other']['title']=$common_html['common_html']['reply']." ".$common_html['common_html'][$tablename];
		break;
	default:
		$fields['other']['title']=$fields['other']['title']." ".$common_html['common_html'][$tablename];
}

global $tabletitle;
switch($db->databaseType)		{
		case 'mysql':
		case 'mssql':
		default:
			break;
		case 'oracle':
			$tabletitle=strtoupper($tabletitle);
			break;
	}
global $print_title;
$print_title=$tabletitle!=""?$html_etc[$tablename][$tabletitle]:$fields['other']['title'];
print_title($print_title,6);

//操作按钮提交
switch($mode)	{
	case 'add':
	case 'edit':
		show_submit_element($action_submit,'left');
		break;
	case 'view':
		show_submit_element($action_submit,'left');
		break;
}

//数据的下载及合并,用途：FILE操作部分，可以删除
//merge -- begin
if($merge!='')									{
$merge_array=explode(':',$merge);//print $merge;
$index_array_temp=explode(',',$merge_array[1]);
$id=$columns[''.$index_array_temp[0].''];
$name=$columns[''.$index_array_temp[1].''];
$array_pop=array_pop($fields['name']);
$fields['value'][$id]=returnfileurl($fields['value'][$id],$fields['value'][$name]);
}
//merge --  end


	//此部分设计为权限部分设计：事业部总监和营销专员的的权限设计
	$SYSTEM_FILTER_ARRAY = returnPrivateTwoInit();
	$USER_PRIV_ID = $_SESSION['SUNSHINE_USER_PRIV'];
	$DEPT_INFOR = $_SESSION['SUNSHINE_USER_DEPT'];
	$USER_INFOR = $_SESSION['SUNSHINE_USER_NAME'];
	$RecordDEPT = $SYSTEM_FILTER_ARRAY['CheckFieldNameDEPT'];
	$RecordDEPT = $columns[$RecordDEPT];
	$RecordUser = $SYSTEM_FILTER_ARRAY['CheckFieldNameUSER'];
	$RecordUser = $columns[$RecordUser];
	//$USER_PRIV = returntablefield("user_priv","USER_PRIV",$USER_PRIV_ID,"PRIV_NO");
	//print $USER_PRIV=5;
	//print_R($fields['USER_PRIVATE']);
	//############################################################
//是否引入图片放大
$ifincludemaginfier=false;
global $colflag;
//print_R($fields['USER_PRIVATE']);
//数据显示区域部分，用于整个数据的主体部分
$colflag=0;

for($i=0;$i<sizeof($fields['name']);$i++)		{
	$fieldname=trim($fields['name'][$i]);
	$fieldfilter=trim($fields['filter'][$i]);
	$notnull=trim($fields['null'][$i]['inputtype']);
	$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
	$colflag=$colflag+1;
	if($colflag>2)
		$colflag=1;
	
	//上一行是单元格
	if($colflag==2 && $i>0 && ($fields['filter'][$i-1]=="htmlarea" || $fields['filter'][$i-1]=="textarea"))
		$colflag=1;
		
	//处在最后一行左边
	if($colflag==1 && $i==sizeof($fields['name'])-1)
		$colflag=0;
	//下一行是宽单元格
	if($colflag==1 && $i<sizeof($fields['name'])-1 && ($fields['filter'][$i+1]=="htmlarea" || $fields['filter'][$i+1]=="textarea"))
		$colflag=0;
	
	$fieldfilter_array=explode(':',$fieldfilter);
	$fieldfilter=trim($fieldfilter_array[0]);

	//用户定义角色权限，是否为只读(可写)选项
	//如用用户定义可写，那么重新调整为可写， 如果非自身记录，则沿用系统设定
	if($ColumnName1!="")		{//判断是否要对用户验证进行操作
		$SYSTEM_PRIVATE_USER_DEFINE_CONTROL == 0 ?
		$fields['USER_PRIVATE'][$fieldname] = '' : '';
	}

	//数据过滤行为
	//$ShowElement = returnPrivateTwoArray($SYSTEM_FILTER_ARRAY,$USER_PRIV,$fieldname,$fields['value'][$fieldname],$fields['value'][$RecordDEPT],$fields['value'][$RecordUser]);
	//if($ShowElement!="***")					{
	if(1)										{	//2010-6-14 11:20替换以前旧的判断方式
	
	switch(TRIM($fieldfilter))		{
		case 'email':
			switch($mode)	{
				case 'add':

				case 'edit':
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1,"email");
					
					break;
				case 'view':
					$linkman='';
					$fromsrc='';
					
					if($fields['tablename'] == 'linkman'){
						$fromsrc = 'customer';
						$linkman = gettablefield($fields['tablename'],'email','rowid',$fields['value'][$fieldname]);
					}else if($fields['tablename'] == 'supplylinkman'){
						$fromsrc = 'supply';
						$linkman = gettablefield($fields['tablename'],'email','rowid',$fields['value'][$fieldname]);
					}	
					else 
					{
						$linkman=$fields['value'][$fieldname];
						$fromsrc='';
					}
					$addicon="<img src='".ROOT_DIR."general/ERP/Framework/images/menu/gif-0037.gif' title='点击链接发送邮件'>";
					if($fields['value'][$fieldname]!='')
						$fields['value'][$fieldname] = "<a href='../CRM/email_newai.php?".base64_encode("action=add_default&sendlist=".$linkman."&fromsrc=".$fromsrc)."' target='_blank' >".$addicon.$fields['value'][$fieldname]."</a>";		
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan,$system_picture_line,$notnulltext);
					break;
			}
			break;		
		case 'mobile':
			switch($mode)	{
				case 'add':

				case 'edit':
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1,"mobile");
					
					break;
				case 'view':
					$addicon="<img  src='".ROOT_DIR."general/ERP/Framework/images/menu/gif-0348.gif' title='点击号码发送短信'>";
					if($fields['value'][$fieldname]!='')
						$fields['value'][$fieldname] = "<a href='../JXC/sms_sendlist_newai.php?".base64_encode("action=add_default&sendlist=".$fields['value'][$fieldname])."' target='_blank'>".$addicon.$fields['value'][$fieldname]."</a>";		
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan,$system_picture_line,$notnulltext);
					break;
			}
			break;
		case 'barcode':
			switch($mode)	{
				case 'add':
					
				case 'edit':
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1,"barcode");
					
					break;
				case 'view':
					$addicon="<img  src='".ROOT_DIR."general/ERP/Framework/images/menu/gif-0348.gif' title='点击号码发送短信'>";
					if($fields['value'][$fieldname]!='')
						$fields['value'][$fieldname] = "<a href='../JXC/sms_sendlist_newai.php?".base64_encode("action=add_default&sendlist=".$fields['value'][$fieldname])."' target='_blank'>".$addicon.$fields['value'][$fieldname]."</a>";		
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan,$system_picture_line,$notnulltext);
					break;
			}
			break;
			
		case 'qq':
			switch($mode)	{
				case 'add':

				case 'edit':
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1,"qq");
					
					break;
				case 'view':
					$fields['value'][$fieldname] = (!empty($fields['value'][$fieldname])?"<a target=\"_blank\" href=\"http://wpa.qq.com/msgrd?v=3&amp;uin=".$fields['value'][$fieldname]."&amp;site=qq&amp;menu=yes\"><img border=\"0\" src=\"http://wpa.qq.com/pa?p=2:".$fields['value'][$fieldname].":45\" onerror=\"this.src='".ROOT_DIR."general/ERP/Framework/images/help3.gif';this.title='此QQ号码可能不存在'\" title=\"点击这里发消息\">".$fields['value'][$fieldname]."</a>":'');
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan,$system_picture_line,$notnulltext);
					break;
			}
			break;		
		case 'url':
			switch($mode)	{
				case 'add':

				case 'edit':
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1,"url");
					
					break;
				case 'view':
					
					$urlwangzhi=$fields['value'][$fieldname];
					$flag=stripos($fields['value'][$fieldname], "http://");
					if($flag===false)
						$urlwangzhi="http://".$urlwangzhi;
					$addicon="<img  src='".ROOT_DIR."general/ERP/Framework/images/menu/gif-0668.gif' title='点击链接打开网址'>";
					if($fields['value'][$fieldname]!='')
						$fields['value'][$fieldname] = "<a href='".$urlwangzhi."' target='_blank'>".$addicon.$fields['value'][$fieldname]."</a>";
						
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan,$system_picture_line,$notnulltext);
					break;
			}
			break;	
		case 'city':
			switch($mode)	{
				case 'add':

				case 'edit':
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_city($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]));

					break;
				case 'view':
					;
					print_text_tr($html_etc[$tablename][$fieldname].":",getShengShiXian($fields['value'][$fieldname]));
					break;
			}
			break;	
		
			
		case 'account':
			switch($mode)	{
				case 'add':
				case 'edit':
					$ifshoukuan=$fields['INPUT_TEXT'][$fieldname];
					$ifshowyuchu=$fields['inputsize'][$fieldname];
					print_account($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$ifshoukuan,$ifshowyuchu);
					break;
		
			}
			break;	
		case '':
		case 'input':
			switch($mode)	{
				case 'add':
				case 'edit':
					$pattern=$fields['INPUT_TEXT'][$fieldname];
					
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1,$pattern);
					//exit;
					break;
				case 'view':
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan,$system_picture_line,$notnulltext);
					break;
			}
			break;
		case 'hidden':
			switch($mode)	{
				case 'add':
				case 'edit':
					//print_R($fields['inputsize']);exit;
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_notshow($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1);
					//exit;
					break;
				case 'view':
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan,$system_picture_line,$notnulltext);
					break;
			}
			break;
		case 'nowshow':
		case 'notshow':
			break;

		case 'bigrmb':
			switch($mode)	{
				case 'add':
				case 'edit':
					break;
				case 'view':
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					$MoneyValue = trim($fields['value'][$fieldname]);
					if($MoneyValue==0)
						$FieldValueTemp = "<font color=green>0</font>";
					else
						$FieldValueTemp = "<font color=red>".$MoneyValue."</font> (".num2rmb($MoneyValue).")";
					print_text_tr($html_etc[$tablename][$fieldname].":",$FieldValueTemp,$colspan);
					break;
			}
			break;
		case 'number':
			switch($mode)	{
				case 'add':
					
					$_GET[$fieldname]=$fields['INPUT_TEXT'][$fieldname];
				case 'edit':
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1,"Number");
					$custom_type = "";
					break;
				case 'view':
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan);
					break;
			}
			break;
		case 'money':
			switch($mode)	{
				case 'add':
				
					$_GET[$fieldname]=$fields['INPUT_TEXT'][$fieldname];
				case 'edit':
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1,"Money");
					$custom_type = "";
					break;
				case 'view':
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan);
					break;
			}
			break;
		case 'autoincrement':
			switch($mode)	{
				case 'add':
				case 'edit':
					print_tr_auto_increment($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputcols']);
					break;
				case 'view':
				
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]));
					break;
			}
			break;
		case 'autoincrementdate':
			switch($mode)	{
				case 'add':
					print_tr_auto_incrementdate($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputcols'],$fields['INPUT_TEXT'][$fieldname]);
					break;
				case 'edit':
					
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]));
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan);
					break;
			}
			break;
		case 'readonly':
			switch($mode)	{
				case 'add':
				case 'edit':
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputsize'],$fields['other']['inputcols'],'SmallStatic',"",'text','readonly');
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$colspan);
					break;
			}
			break;
		
		case 'readonlytextarea':
			switch($mode)	{
				case 'add':
				case 'edit':
					//print_R($fields['other']['textarea']);
					//print $notnulltext;
					print_textarea_readonly($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['textarea'][$fieldname]['rows'],$fields['other']['textarea'][$fieldname]['cols'],$fields['other']['inputcols'],$notnulltext);
					break;
				case 'view':
					print_text_text($html_etc[$tablename][$fieldname].":",nl2br(stripslashes(trim($fields['value'][$fieldname]))));
					break;
			}
			break;
		case 'readonlymulti':
			switch($mode)	{
				case 'edit':
					//print_R($fields['other']['textarea']);
					//print $notnulltext;
					print_textarea_mluti_readonly($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['textarea'][$fieldname]['rows'],$fields['other']['textarea'][$fieldname]['cols'],$fields['other']['inputcols'],$notnulltext);
					break;
			}
			break;
		case 'password':
		case 'password_simple':
			switch($mode)	{
				case 'add':
				case 'edit':
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputsize']+4,$fields['other']['inputcols'],$fields['other']['class'],"",'password');
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":","******",$colspan);
					break;
			}
			break;
		case 'textarea':
			switch($mode)	{
				case 'add':
				case 'edit':
					//print_R($fields['other']['textarea']);
					print_textarea($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['textarea'][$fieldname]['rows'],$fields['other']['textarea'][$fieldname]['cols'],$fields['other']['inputcols'],$notnulltext,$fields['other']['textarea'][$fieldname]['other']);
					break;
				case 'view':
					print_text_text($html_etc[$tablename][$fieldname].":",nl2br(stripslashes(trim($fields['value'][$fieldname]))));
					break;
			}
			break;
		case 'spacetime':
			switch($mode)	{
				case 'add':
				case 'edit':
					print_select_spacetime($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]));
					break;
				case 'view':
					print_select_spacetime($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]));
					break;
			}
			break;
		case 'htmlarea':
			switch($mode)	{
				case 'add':
				case 'edit':

					print_htmlarea($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['textarea']['rows'],$fields['other']['textarea']['cols'],$fields['other']['inputcols']);
					break;
				case 'view':
					print_text_html($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]));
					break;
			}
			break;
		case 'idtoname_user':
			switch($mode)	{
				case 'add':
				case 'edit':
					break;
				case 'view':
					$filtervalue=idtoname(trim($fields['value'][$fieldname]),'user');
					print_text_tr($html_etc[$tablename][$fieldname].":",$filtervalue,$colspan);
					break;
			}
			break;
		case 'purview':
			switch($mode)	{
				case 'add':
				case 'edit':
					print_purview($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['textarea']['rows'],$fields['other']['textarea']['cols'],$fields['other']['inputcols']);
					break;
				case 'view':
					break;
			}
			break;
		case 'avatar':
			switch($mode)	{
				case 'add':
				case 'edit':
					print_avatar($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputsize'],$fields['other']['inputcols'],$fields['other']['class'],"");
					break;
				case 'view':
					print_text_avatar($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),2);
					break;
			}
			break;
		case 'file':
			switch($mode)	{
				case 'add':
					print_file($html_etc[$tablename][$fieldname].":",$fieldname);
					break;
				case 'edit':
					//print_file($html_etc[$tablename][$fieldname].":",$fieldname);
					break;
				case 'view':
					break;
			}
			break;
		case 'singlefile':
			switch($mode)	{
				case 'add':
					print_singlefile($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputsize'],$fields['other']['inputcols']);
					break;
				case 'edit':
					print_singlefile($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputsize'],$fields['other']['inputcols']);
					break;
				case 'view':
					$var_value = trim($fields['value'][$fieldname]);
					if($var_value!="")				{
						$var_value = ereg_replace ("&amp;", "&", $var_value);
						//print $var_value;
						$parse_url = parse_url($var_value);
						$query = $parse_url['query'];
						parse_str($query,$output);
						$attachmentid = $output['attachmentid'];
						$attachmentname = $output['attachmentname'];
						//$attachmentid = $output['attachmentname'];
						//print_R($parse_url);
						$filename_newfile = "../../attachment/$attachmentid/$attachmentname";
						if(is_file($filename_newfile))		{
							$filtervalue=trim($fields['value'][$fieldname]);
							$filtervalue_file = explode('=',$filtervalue);
							$filtervalue_sizeof = sizeof($filtervalue_file)-1;
							$filename = $filtervalue_file[$filtervalue_sizeof];
							$filtervalue = "<a href='".$filtervalue."'>$filename</a>";
						}
					}
					//print $downloadfile = trim($fields['value'][$fieldname]);
					//if(is_file($downloadfile))		{
						//print $file_path="<img src=\"../../Framework/images/downloads.gif\" border=0 width=172>\n";
						//print "<a href='$downloadfile'>下载文件</a>";
						//$nopicture_path="<img src=\"images/logo_sndg.gif\" border=0 width=172>\n";
						//is_file(trim($fields['value'][$fieldname]))?$system_picture_line=$file_path:$system_picture_line=$nopicture_path;
					//}
					print_text_tr($html_etc[$tablename][$fieldname].":",$filtervalue);
					break;
			}//idnumfile
			break;
		case 'picturefile':
			switch($mode)	{
				case 'add':
					print_picturefile($html_etc[$tablename][$fieldname].":",$fieldname,'',$fields['other']['inputsize']);
					break;
				case 'edit':
					print_picturefile($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputsize'],$fields['other']['inputcols']);
					break;
				case 'view':

					$PicturePath=$fields['value'][$fieldname];
					if($PicturePath!=""&&strlen($PicturePath)>10)
					{
						if(!$ifincludemaginfier)
						{
							print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
							print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.magnifier.js\"></script>";
							$ifincludemaginfier=true;
						}
						$file_path = "<img src='".$PicturePath."' width=32  class=\"magnify\"  data-magnifyto=\"500\" onmouseover=\"this.style.cursor='pointer';this.style.cursor='hand'\" onmouseout=\"this.style.cursor='default'\">";

						//$file_path="<a href='$PicturePath'><img src='".$PicturePath."' border=0 width=120></a>";
					}
					else
						$file_path="";
					print_image_view($html_etc[$tablename][$fieldname],$file_path,$width='120');
					break;
			}//idnumfile
			break;

		case 'tdoafile':
			require_once('lib/utility_file.php');
			//print $fields['other']['inputcols'];
			switch($mode)	{
				case 'add':
					print_tdoafile($html_etc[$tablename][$fieldname].":",$fieldname,'',$fields['other']['inputsize'],$fields['other']['inputcols']);
					break;
				case 'edit':
					print_tdoafile($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputsize'],$fields['other']['inputcols']);
					break;
				case 'view':
					//形成通达OA下载文件所需要的变量格式
					$var_value_array = explode('||',$fields['value'][$fieldname]);
					$ATTACHMENT_ID = $var_value_array[1];
					$ATTACHMENT_NAME = $var_value_array[0];
					if(strlen($fields['value'][$fieldname])<3)
					   $file_path =  "无附件";
					else
					   $file_path = attach_link($ATTACHMENT_ID,$ATTACHMENT_NAME,1,1,1,0,0,1,1,0);
					//print_R($ATTACHMENT_NAME);exit;
					print "<script src=\"../../Enginee/lib/attach.js\"></script>";
					print "
					<input type=\"hidden\" name=\"ATTACHMENT_ID_OLD\" value=\"$ATTACHMENT_ID\">
					<input type=\"hidden\" name=\"ATTACHMENT_NAME_OLD\" value=\"$ATTACHMENT_NAME\">";
					print_image_view($html_etc[$tablename][$fieldname],$file_path,$width='120',$fields['other']['inputcols']);
					break;
			}//idnumfile
			break;

		case 'binaryfile':
			switch($mode)	{
				case 'add':
					print_binaryfile($html_etc[$tablename][$fieldname].":",$fieldname,$fields['other']['inputsize'],$fields['other']['inputcols']);
					break;
				case 'edit':
					print_binaryfile($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['other']['inputsize'],$fields['other']['inputcols']);
					break;
				case 'view':
					global $sessionkey;
					$filepath=trim($fields['value'][$fieldname]);
					if(is_file($filepath))		{
					$file_path="<img src=\"$filepath\" border=0 width=172>\n";
					}else	{
					$file_path="<img src=\"images/logo_sndg.gif\" border=0 width=172>\n";
					}
					print_text_tr($html_etc[$tablename][$fieldname].":",$file_path,$colspan);
					break;
			}//idnumfile
			break;
		case 'idnumfile':
			switch($mode)	{
				case 'view':
					$file_path="<img src=\"idnumimage/".trim($fields['value'][$fieldname]).".jpg\" border=0 width=172>\n";
					$nopicture_path="<img src=\"images/logo_sndg.gif\" border=0 width=172>\n";
					is_file("idnumimage/".trim($fields['value'][$fieldname]).".jpg")?$system_picture_line=$file_path:$system_picture_line=$nopicture_path;
					break;
			}
			break;
		case 'colorselect':
			switch($mode)
			{
				case 'add':
				case 'edit':
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					print_colorselect($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$notnulltext);

					break;
				case 'view':
					print "<div  style=\"border:1px double #000000;width:16px;height:16px;background-color:".$fields['value'][$fieldname].";overflow:hidden;\"></div>";
					break;
			}
			break;
		case 'date0':
			switch($mode)	{
				case 'add':
					
				case 'edit':
					print_date_js();
					print_date($html_etc[$tablename][$fieldname].":",$fieldname,"./sms_index/calendar_begin.php?datetime=$fieldname",trim($fields['value'][$fieldname]),$fields['other']['inputcols'],$notnulltext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returndate(trim($fields['value'][$fieldname]),1));
					break;
			}
			break;
		case 'date':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=date("Y-m-d");
				case 'edit':
					print_date_js();
					print_date($html_etc[$tablename][$fieldname].":",$fieldname,"./sms_index/calendar_begin.php?datetime=$fieldname",trim($fields['value'][$fieldname]),$fields['other']['inputcols'],$notnulltext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returndate(trim($fields['value'][$fieldname]),1));
					break;
			}
			break;
		case 'date1':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=date("Y-m-d",mktime(0,0,0,date(m)+1,date(d),date(Y)));
				case 'edit':
					print_date_js();
					print_date($html_etc[$tablename][$fieldname].":",$fieldname,"./sms_index/calendar_begin.php?datetime=$fieldname",trim($fields['value'][$fieldname]),$fields['other']['inputcols'],$notnulltext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returndate(trim($fields['value'][$fieldname]),1));
					break;
			}
			break;
		case 'datetime':
			switch($mode)	{
				case 'add':
					if($fields['value'][$fieldname]=='')
						$fields['value'][$fieldname]=date("Y-m-d H:i:s");
				case 'edit':
					$pattern=$fields['INPUT_TEXT'][$fieldname];
					
					print_datetime($html_etc[$tablename][$fieldname].":",$fieldname,"./sms_index/calendar_begin.php?datetime=$fieldname",trim($fields['value'][$fieldname]),$fields['other']['inputcols'],$notnulltext,$pattern);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returndate(trim($fields['value'][$fieldname]),1));
					break;
			}
			break;
		case 'datetime0':
			switch($mode)	{
				case 'add':
					
				case 'edit':
					print_date_js();
					print_datetime($html_etc[$tablename][$fieldname].":",$fieldname,"./sms_index/calendar_begin.php?datetime=$fieldname",trim($fields['value'][$fieldname]),$fields['other']['inputcols'],$notnulltext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returndate(trim($fields['value'][$fieldname]),1));
					break;
			}
			break;
		case 'datetimecheckbox':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=date("Y-m-d H:i:s");
				case 'edit':
					print_date_js();
					print_datetimecheckbox($html_etc[$tablename][$fieldname].":",$fieldname,"./sms_index/calendar_begin.php?datetime=$fieldname",trim($fields['value'][$fieldname]),$fields['other']['inputcols'],$notnulltext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returndate(trim($fields['value'][$fieldname]),1));
					break;
			}
			break;
		case 'boolean':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname] = $fields['boolean'][$i]['value'];
				case 'edit':
					//$fields['value'][$fieldname]=1;
					print_boolean($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$size="25",$colspan=2,"SmallSelect",$addtext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returnboolean(trim($fields['value'][$fieldname])));
					break;
			}
			break;
		case 'select_sex':
		case 'sex':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=1;
				case 'edit':
					print_sex($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),"SmallSelect",$addtext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returnsex(trim($fields['value'][$fieldname])));
					break;
			}
			break;
		case 'checkbox':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname] = $fields['select'][$i]['initvalue'];
				case 'edit':
					print_checkbox($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]));
					break;
				case 'view':
					print_checkbox($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]));
					break;
			}
			break;
		case 'mulcheckbox':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname] = $fields['select'][$i]['initvalue'];
					
				case 'edit':
					$subtablename=$fields['INPUT_TEXT'][$fieldname];
					$subkey=$fields['inputsize'][$fieldname];
					$subval=$fields['inputother'][$fieldname];
					print_mulcheckbox($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$subtablename,$subkey,$subval);
					break;
				case 'view':
					
					$subtablename=$fields['INPUT_TEXT'][$fieldname];
					$subkey=$fields['inputsize'][$fieldname];
					$subval=$fields['inputother'][$fieldname];
					$subcolums=returntablecolumn($subtablename);
					$subkey=$subcolums[$subkey];
					$subval=$subcolums[$subval];
					
					$fieldValueArray = explode(",",$fields['value'][$fieldname]);
					array_pop($fieldValueArray);
					$fieldValueArrayTEXT = join("','",$fieldValueArray);
					$sql   = "select $subval from $subtablename where $subkey in ('$fieldValueArrayTEXT')";
					$rsxx  = $db->CacheExecute(5,$sql);
					$rsxxA = $rsxx->GetArray();
					$fieldValueNameText = '';
					for($iD=0;$iD<sizeof($rsxxA);$iD++)			{
						$fieldValueNameText .= $rsxxA[$iD][$subval].",";
						
					}
					print_text_tr($html_etc[$tablename][$fieldname].":",$fieldValueNameText);
					break;
				
			}
			break;
		case 'radio':
			switch($mode)	{
				case 'add':
					if($fields['value'][$fieldname]=='')
						$fields['value'][$fieldname] = $fields['select'][$i]['initvalue'];
				case 'edit':
					print_radio($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['select'][$i]['tablename'],$fields['select'][$i]['value'],$fields['select'][$i]['field'],2,$fields['select'][$i]['initvalue']);
					break;
				case 'view':
					print_select_text($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$fieldname,$fields['select'][$i]['tablename'],$fields['select'][$i]['value'],$fields['select'][$i]['field']);
					break;
			}
			break;
		case 'radiogroup':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname] = $fields['select'][$i]['initvalue'];
				case 'edit':
					print_radio($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['select'][$i]['tablename'],$fields['select'][$i]['value'],$fields['select'][$i]['field'],1,$fields['select'][$i]['initvalue'],$fields['select'][$i]['groupfield'],$fields['select'][$i]['groupvalue']);
					break;
				case 'view':
					print_select_text($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$fieldname,$fields['select'][$i]['tablename'],$fields['select'][$i]['value'],$fields['select'][$i]['field'],$fields['select'][$i]['groupfield'],$fields['select'][$i]['groupvalue']);
					break;
			}
			break;
		//JUMPUSERINFOR,弹出窗口的用户名和用户ID
		case 'usertoid':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext	= $html_etc[$tablename][$fieldname];
					//$colspan = $fields['other']['inputcols'];
					$fieldnameID = $fieldname."_ID";
					$fieldValueName = returntablefield("user","USER_ID",$fieldValue,"USER_NAME");
					$PRIV_OP=$fields['INPUT_TEXT'][$fieldname];
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValueName\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectTeacherSingle('$PRIV_OP','$fieldname', '$fieldnameID')\">选择</a>\n";
					print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldname', '$fieldnameID')\" title=\"清空\">清空</a>";

					print "&nbsp;&nbsp;$notnulltext</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returntablefield("user","USER_ID",$fields['value'][$fieldname],"USER_NAME"),$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//JUMPUSERINFOR,弹出窗口的用户名和用户ID
		case 'usertoname':
			$colspan = 2;
			//print_R($_GET);;
			switch($mode)	{
				case 'add':
					$fieldValue = $_GET[$fieldname];
					$showtext	= $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					$fieldValueName = returntablefield("user","USER_NAME",$fieldValue,"USER_ID");
					$PRIV_OP=$fields['INPUT_TEXT'][$fieldname];
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValueName\">\n";
					print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectTeacherSingle('$PRIV_OP','$fieldnameID', '$fieldname')\">选择</a>\n";
					print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldnameID', '$fieldname')\" title=\"清空\">清空</a>";
					//print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext	= $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					$fieldValueName = returntablefield("user","USER_NAME",$fieldValue,"USER_ID");
					$PRIV_OP=$fields['INPUT_TEXT'][$fieldname];
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValueName\">\n";
					print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectTeacherSingle('$PRIV_OP','$fieldnameID', '$fieldname','$PRIV_OP')\">选择</a>\n";
					print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldnameID', '$fieldname')\" title=\"清空\">清空</a>";
					//print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//JUMPUSERLISTINFOR,弹出窗口的用户名和用户ID,多用户模式
		case 'usertonamelist':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					
					$fieldValue = $fields['value'][$fieldname];
					$showtext	= $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					$fieldValueArray = explode(",",$fieldValue);
					for($idddd=0;$idddd<sizeof($fieldValueArray);$idddd++)			{
						$fieldValueArrayValue = $fieldValueArray[$idddd];
						if($fieldValueArrayValue!="")$fieldValueNameText .= returntablefield("user","USER_ID",$fieldValueArrayValue,"USER_NAME").",";
					}
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					//print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValueName\" readonly class=\"SmallStatic\" size=\"40\">\n";
					print "<textarea style=\"width:380px;\" name=\"$fieldnameID\" id=\"$fieldnameID\" rows=\"3\" style=\"overflow-y:auto;\" class=\"BigStatic\" wrap=\"yes\" readonly>$fieldValueNameText</textarea>";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectUser('".$fields['INPUT_TEXT']['zhixingren']."','$fieldname', '$fieldnameID');\">选择</a>\n";
					print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldname', '$fieldnameID')\" title=\"清空\">清空</a>&nbsp;";
					print "&nbsp;$notnulltext";
					print "</TD></TR>\n";
					break;
				case 'view':
					$fieldValueArray = explode(",",$fields['value'][$fieldname]);
					$fields['value'][$fieldname] = '';
					for($idddd=0;$idddd<sizeof($fieldValueArray);$idddd++)			{
						$fieldValueArrayValue = $fieldValueArray[$idddd];
						if($fieldValueArrayValue!="")
						{
							$userInfo=returntablefield("user","USER_ID",$fieldValueArrayValue,"UID,USER_NAME");
							$fields['value'][$fieldname] .="<a target='_blank' href='../Framework/user_newai.php?action=view_default&UID=".$userInfo['UID']."'>".$userInfo['USER_NAME']."</a>,";
						} 
					}
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//JUMPDEPTINFOR,弹出窗口的部门名和部门ID
		case 'depttoid':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext	= $html_etc[$tablename][$fieldname];
					//$colspan = $fields['other']['inputcols'];
					$fieldnameID = $fieldname."_ID";
					$fieldValueName = returntablefield("department","DEPT_ID",$fieldValue,"DEPT_NAME");
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValueName\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectDeptSingle('','$fieldname', '$fieldnameID')\">选择</a>\n";
					print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldname', '$fieldnameID')\" title=\"清空\">清空</a>";
					print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",returntablefield("department","DEPT_ID",$fields['value'][$fieldname],"DEPT_NAME"),$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//JUMPDEPTINFOR,弹出窗口的部门名和部门ID
		case 'depttoname':
			$colspan = 2;
			switch($mode)	{
				case 'add':
					//print_R($_GET);
					$fieldValue			= $_GET[$fieldname];
					$fieldValueName		= returntablefield("department","DEPT_NAME",$fieldValue,"DEPT_ID");
					$fieldnameID		= $fieldname."_ID";
					$showtext			= $html_etc[$tablename][$fieldname];
					$PRIV_OP=$fields['INPUT_TEXT'][$fieldname];
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValueName\">\n";
					print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectDeptSingle('','$fieldnameID', '$fieldname','$PRIV_OP')\">选择</a>\n";
					print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldnameID', '$fieldname')\" title=\"清空\">清空</a>";
					//print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext	= $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					$fieldValueName = returntablefield("department","DEPT_NAME",$fieldValue,"DEPT_ID");
					$PRIV_OP=$fields['INPUT_TEXT'][$fieldname];
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValueName\">\n";
					print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectDeptSingle('','$fieldnameID', '$fieldname','$PRIV_OP')\">选择</a>\n";
					print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldnameID', '$fieldname')\" title=\"清空\">清空</a>";
					//print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出课程的窗口
		case 'jumpcourse':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext  = $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectCourseSingle('','$fieldnameID', '$fieldname')\">选择</a>\n";
					print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出教材的窗口
		case 'jumpjiaocai':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext  = $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"25\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectAllInforSingle('../../Enginee/Module/jiaocai_admin_select_single/index.php','','$fieldnameID', '$fieldname')\">选择</a>\n";
					print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出客户的窗口
		case 'jumpkehu':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext   = $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					$fieldValueNAME = returntablefield("customer","ROWID",$fieldValue,"supplyname");
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValueNAME\" readonly class=\"SmallStatic\" size=\"30\">\n";
					print "<input type=\"button\" title='' value=\"选择\" class=\"SmallButton\"  onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','$fieldnameID', '$fieldname')\">\n";
					print "&nbsp;".$notnulltext;
					print "</TD></TR>\n";
					break;
				case 'view':
					$fieldValueNAME = returntablefield("customer","ROWID",$fields['value'][$fieldname],"supplyname");
					print_text_tr($html_etc[$tablename][$fieldname].":",$fieldValueNAME,$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出客户的多选窗口
		case 'jumpkehumulti':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext   = $html_etc[$tablename][$fieldname];
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					$fieldnameID = $fieldname."_ID";
					$fieldnameArray=explode(",", $fieldValue);
					$fieldValueNAME="";
					for($j=0;$j<count($fieldnameArray);$j++)
					{
						if($fieldnameArray[$j]!='')
							$fieldValueNAME = $fieldValueNAME.returntablefield("customer","ROWID",$fieldnameArray[$j],"supplyname").",";
					}
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<textarea name='$fieldnameID' class=\"SmallInput\" rows=".$fields['other']['textarea'][$fieldname]["rows"]." cols=".$fields['other']['textarea'][$fieldname]["cols"]." readonly>$fieldValueNAME</textarea>";
					print "&nbsp;&nbsp;".$notnulltext."<br>";
					print "<a href='#' onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_multi/index.php','','$fieldnameID', '$fieldname')\"><u>选择客户</u></a>\n";
					print "</TD></TR>\n";
					break;
				case 'view':
					$fieldValueNAME = returntablefield("customer","ROWID",$fields['value'][$fieldname],"supplyname");
					print_text_tr($html_etc[$tablename][$fieldname].":",$fieldValueNAME,$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出客户联系人的多选窗口
		case 'jumplinkmanmulti':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext   = $html_etc[$tablename][$fieldname];
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					$fieldnameID = $fieldname."_ID";
					$fieldnameArray=explode(",", $fieldValue);
					$other=$fields['other']['textarea'][$fieldname]['other'];
					for($i=0;$i<count($fieldnameArray);$i++)
					{
						if($fieldnameArray[$i]!='')
							$fieldValueNAME = $fieldValueNAME.returntablefield("linkman","ROWID",$fieldnameArray[$i],"$other").",";
					}
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<textarea name='$fieldnameID' class=\"SmallInput\" rows=".$fields['other']['textarea'][$fieldname]["rows"]." cols=".$fields['other']['textarea'][$fieldname]["cols"]." readonly>$fieldValueNAME</textarea>";
					print "&nbsp;&nbsp;".$notnulltext."<br>";
					print "<a href='#' onClick=\"SelectAllInforSingle('../../Enginee/Module/linkman_select_multi/index.php','','$fieldnameID', '$fieldname','$other')\"><u>选择客户联系人</u></a>\n";
					print "</TD></TR>\n";
					break;
				case 'view':
					$other=$fields['other']['textarea'][$FieldNameIndex]['other'];
					$fieldValueNAME = returntablefield("linkman","ROWID",$fields['value'][$fieldname],"$other");
					print_text_tr($html_etc[$tablename][$fieldname].":",$fieldValueNAME,$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出供应商联系人的多选窗口
		case 'jumpsupplylinkmanmulti':
			$colspan = 2;
			$hasPriv=false;
			$menuid=returntablefield("sys_function", "unimenu","供应商","func_Id");
			$menuStr=explode(",",$_SESSION['LOGIN_FUNC_ID_STR']);
			if(in_array($menuid,$menuStr))
			{
				$hasPriv=true;
			}
			if(!$hasPriv)
				continue;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];

					$showtext   = $html_etc[$tablename][$fieldname];
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					$fieldnameID = $fieldname."_ID";
					$fieldnameArray=explode(",", $fieldValue);
					$other=$fields['other']['textarea'][$fieldname]['other'];

					for($j=0;$j<count($fieldnameArray);$j++)
					{
						if($fieldnameArray[$j]!='')
							$fieldValueNAME = $fieldValueNAME.returntablefield("supplylinkman","ROWID",$fieldnameArray[$j],"$other").",";
					}
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<textarea name='$fieldnameID' class=\"SmallInput\" rows=".$fields['other']['textarea'][$fieldname]["rows"]." cols=".$fields['other']['textarea'][$fieldname]["cols"]." readonly>$fieldValueNAME</textarea>";
					print "&nbsp;&nbsp;".$notnulltext."<br>";
					print "<a href='#' onClick=\"SelectAllInforSingle('../../Enginee/Module/supplylinkman_select_multi/index.php','','$fieldnameID', '$fieldname','$other')\"><u>选择供应商联系人</u></a>\n";
					print "</TD></TR>\n";

					break;
				case 'view':
					$other=$fields['other']['textarea'][$FieldNameIndex]['other'];
					$fieldValueNAME = returntablefield("supplylinkman","ROWID",$fields['value'][$fieldname],"$other");
					print_text_tr($html_etc[$tablename][$fieldname].":",$fieldValueNAME,$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出仓库的多选窗口
		case 'jumpstoremulti':
			$colspan = 2;

			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];

					$showtext   = $html_etc[$tablename][$fieldname];
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					$fieldnameID = $fieldname."_ID";
					$fieldnameArray=explode(",", $fieldValue);
					
					for($j=0;$j<count($fieldnameArray);$j++)
					{
						if($fieldnameArray[$j]!='')
							$fieldValueNAME = $fieldValueNAME.returntablefield("stock","ROWID",$fieldnameArray[$j],"name").",";
					}
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<input type=text name='$fieldnameID' size=30 class=\"SmallStatic\"  readonly value='$fieldValueNAME'</input>";
					
					print "&nbsp;<input type=button  class=SmallButton value='选择' onClick=\"SelectAllInforSingle('../../Enginee/Module/store_select_multi/index.php','','$fieldnameID', '$fieldname','')\">\n";
					print "&nbsp;".$notnulltext;
					print "</TD></TR>\n";

					break;
				case 'view':
					$other=$fields['other']['textarea'][$FieldNameIndex]['other'];
					$fieldValueNAME = returntablefield("supplylinkman","ROWID",$fields['value'][$fieldname],"$other");
					print_text_tr($html_etc[$tablename][$fieldname].":",$fieldValueNAME,$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出供应商的单选窗口
		case 'jumpsupply':
			$colspan = 2;
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname] = $_GET[$fieldname];
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext   = $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					$fieldValueNAME= returntablefield("supply","ROWID",$fieldValue,"supplyname");
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValueNAME\" readonly class=\"SmallStatic\" size=\"30\">\n";
					print "<input type=\"button\" title='' value=\"选择\" class=\"SmallButton\"  onClick=\"SelectAllInforSingle('../../Enginee/Module/supply_select_single/index.php','','$fieldnameID', '$fieldname')\">\n";
					print "&nbsp;".$notnulltext."</TD></TR>\n";
					break;
				case 'view':
					$fieldValueNAME = returntablefield("supply","ROWID",$fields['value'][$fieldname],"supplyname");
					print_text_tr($html_etc[$tablename][$fieldname].":",$fieldValueNAME,$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出产品类别的窗口
		case 'jumpproducttype':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					//if($fields['INPUT_TEXT'][$fieldname]=='1')
					
					$showfoldorsub=$fields['inputsize'][$fieldname];//空=全部，1=仅显示文件夹，2=只能选择子类
					$fieldValue = $fields['value'][$fieldname];
					$showtext  = $html_etc[$tablename][$fieldname];
					$fieldValueName = returntablefield("producttype","ROWID",$fieldValue,"name");
					$fieldnameID = $fieldname."_ID";
					$notnull=trim($fields['null'][$i]['inputtype']);
					$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext.":</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValueName\" readonly class=\"SmallStatic\" size=\"25\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectAllInforSingle('../../Enginee/Module/prodtype_select_single/index.php','$fieldValue','$fieldname', '$fieldnameID','$showfoldorsub')\">选择</a>\n";
					print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldnameID', '$fieldname')\" title=\"清空\">清空</a>";
					print "&nbsp;".$notnulltext."</TD></TR>\n";
					print "</TD></TR>\n";
					break;
				case 'view':
					
					$val=returntablefield("producttype", "rowid", $fields['value'][$fieldname], "name");
					print_text_tr($html_etc[$tablename][$fieldname].":",$val,$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
			//弹出产品窗口
		case 'jumpproduct':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext  = $html_etc[$tablename][$fieldname];
					$fieldValueName = returntablefield("product","productid",$fieldValue,"productname");
					$fieldnameID = $fieldname."_ID";
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext.":</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValueName\" readonly class=\"SmallStatic\" size=\"30\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectAllInforSingle('../../Enginee/Module/product_select_single/index.php','$fieldValue','$fieldname', '$fieldnameID','$showfoldorsub')\">选择</a>\n";
					print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "<a href=\"#\" class=\"orgClear\" onClick=\"ClearUser('$fieldnameID', '$fieldname')\" title=\"清空\">清空</a>";
					print "</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出宿舍的窗口
		case 'jumpdorm':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$床位号 = $fields['value']['床位号'];
					$性别 = $fields['value']['性别'];
					$fieldValue = $fields['value'][$fieldname]." ".$床位号."号床位";
					$showtext  = $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"30\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectAllInforSingle('../../Enginee/Module/dorm_room_admin_select_single/index.php','','$fieldname', '$fieldnameID','$性别')\">选择</a>\n";
					print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出班级的窗口
		case 'jumpbanji':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext  = $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectBanJiSingle('','$fieldnameID', '$fieldname')\">选择</a>\n";
					print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出教室的窗口
		case 'jumpclassroom':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext  = $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."_ID";
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldname\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldnameID\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectClassroomSingle('','$fieldname', '$fieldnameID')\">选择</a>\n";
					print $addtext = FilterFieldAddText($addtext,$fieldname);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		//弹出所有学生的窗口
		case 'jumpstudentall':
			$colspan = 2;
			switch($mode)	{
				case 'add':
				case 'edit':
					$fieldValue = $fields['value'][$fieldname];
					$showtext  = $html_etc[$tablename][$fieldname];
					$fieldnameID = $fieldname."ID";
					print "<TR>";
					print "<TD class=TableData noWrap>".$showtext."</TD>\n";
					print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
					print "<input type=\"hidden\" name=\"$fieldnameID\" value=\"$fieldValue\">\n";
					print "<input type=\"text\" name=\"$fieldname\" value=\"$fieldValue\" readonly class=\"SmallStatic\" size=\"20\">\n";
					print "<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectAllStudentSingle('','$fieldnameID', '$fieldname')\">选择</a>\n";
					print $addtext = FilterFieldAddText($addtext,$fieldname);
					print "</TD></TR>\n";
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",$fields['value'][$fieldname],$colspan,$system_picture_line,$notnulltext);
					break;
			}//idnumfile
			break;
		case 'select':
		case 'selectcolor':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=$fields['select'][$i]['initvalue'];
				case 'edit':
					print_select(
						$html_etc[$tablename][$fieldname].":",
						$fieldname,
						trim($fields['value'][$fieldname]),
						$fields['select'][$i]['tablename'],
						$fields['select'][$i]['value'],
						$fields['select'][$i]['field'],
						$fields['other']['inputcols'],
						$fields['select'][$i]['setfieldname'],
						$fields['select'][$i]['setfieldvalue'],
						$fields['select'][$i]['setfieldboolean'],
						$fields['select'][$i]['initvalue']
					);
					break;
				case 'view':
					if($tablename==$fields['select'][$i]['tablename'])
						$showText=$html_etc[$tablename][$fields['select'][$i]['field']];
					else 
						$showText=$html_etc[$tablename][$fieldname];
					print_select_text($showText.":",trim($fields['value'][$fieldname]),$fieldname,$fields['select'][$i]['tablename'],$fields['select'][$i]['value'],$fields['select'][$i]['field'],$fieldfilter);
					break;
			}
			break;
		case 'selectstock':
			switch ($mode){
				case 'add':
				case 'edit':
					
					print_select_Stock($html_etc[$tablename][$fieldname], $fieldname, $fields['value'][$fieldname]);
			}
			break;
		case 'selectpriv':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=$fields['select'][$i]['initvalue'];
				case 'edit':
					print_selectpriv($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]));
					break;
				case 'view':
					print_select_text($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$fieldname,"user_priv","USER_PRIV","PRIV_NAME");
					break;
			}
			break;
		case 'select2':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=$fields['select'][$i]['initvalue'];
				case 'edit':
					$lastFieldName = $fields['name'][$i-1];
					print_select2($html_etc[$tablename][$lastFieldName].":",$fieldname,$fields['name'][$i-1],trim($fields['value'][$fieldname]),$fields['select'][$i]['tablename'],$fields['select'][$i]['value'],$fields['select'][$i]['field']);
					break;
				case 'view':
					print_select_text($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]),$fieldname,$fields['select'][$i]['tablename'],$fields['select'][$i]['value'],$fields['select'][$i]['field']);
					break;
			}
			break;
		case 'tablefilter6':
			switch($mode)	{
				case 'add':
					print_select_four_address('',$tablename);
					break;
				case 'edit':
					print_select_four_address($fields['value'],$tablename);
					break;
			}
			break;
		case 'tablefilter3':
			switch($mode)	{
				case 'add':
					if(file_exists("../../Framework/system_config.ini"))	{
						$iniFile = parse_ini_file("../../Framework/system_config.ini");
					}
					else	if(file_exists("../Framework/system_config.ini"))	{
						$iniFile = parse_ini_file("../Framework/system_config.ini");
					}
					else	if(file_exists("Framework/system_config.ini"))	{
						$iniFile = parse_ini_file("Framework/system_config.ini");
					}
					print_select_countryCode($iniFile['provinces'],$fields);
					break;
				case 'edit':
					$fieldname = $fields['name'][$i+2];
					print_select_countryCode($fields['value'][$fieldname],$fields);
					break;
			}
			break;
		case 'select_two':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=$fields['select'][$i]['initvalue'];
				case 'edit':
					$fieldname2=$fields['name'][$i+1];
					print_select_two($html_etc[$tablename][$fieldname].":",$fieldname,$html_etc[$tablename][$fieldname2].":",$fieldname2,trim($fields['value'][$fieldname]),$fields['select'][$i]['tablename'],$fields['select'][$i]['value'],$fields['select'][$i]['field'],$fields['select'][$i]['where'],$fields['select'][$i]['where_value'],$fields['select'][$i]['where_table'],$fields['select'][$i]['where_table_value'],$fields['select'][$i]['where_table_name'],1,trim($fields['value'][$fieldname2]),$notnulltext);
					break;
				case 'view':
					break;
			}
			break;
		case 'select_select_input':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=$fields['select'][$i]['initvalue'];
				case 'edit':
					$fieldname2=$fields['name'][$i+1];
					//print_select_menu_product($showtext,$showFieldName,$showFieldID,$showtext2,$showFieldName2,$showFieldValue,$tableName,$colspan=1)
					print_select_menu_product($html_etc[$tablename][$fieldname].":",$fields['select'][$i]['field'],$fields['select'][$i]['value'],$html_etc[$tablename][$fieldname2].":",$fields['select'][$i]['secondIndexName'],trim($fields['value'][$fieldname]),$fields['select'][$i]['tablename'],$fieldname,$fieldname2,2);
					break;
				case 'view':
					break;
			}
			break;
		case 'select_input':
			switch($mode)	{
				case 'add':
					$filtervalue_name_backup_id=isset($_GET[$fieldname])?$_GET[$fieldname]:'';
					$filtervalue_name_backup_name=isset($_GET[$fieldname."name"])?$_GET[$fieldname."name"]:'';
				case 'edit':
					$filtervalue_name=gettablefield($fields['select'][$i]['tablename'],$fields['select'][$i]['value'],$fields['select'][$i]['field'],trim($fields['value'][$fieldname]));
					$filename="frame_depart_notify.php?title=".$common_html['common_html']['select_record']."&tablename=".$fields['select'][$i]['tablename']."&fieldid=".$fields['select'][$i]['value']."&fieldname=".$fields['select'][$i]['field']."&field=$fieldname&AddUserField=".$fields['select'][$i]['userField']."";
					//print $fields['select'][$i]['userField'];
					$temp_id_name=trim($fields['value'][$fieldname]);
					$filtervalue_id=isset($temp_id_name)?$temp_id_name:$filtervalue_name_backup_id;
					$filtervalue_name=isset($filtervalue_name)?$filtervalue_name:$filtervalue_name_backup_name;
					global $systemlang;
					if($filtervalue_name==''&&$tablename=='notify')		{
						$filtervalue_name=$common_html['common_html']['AllDepartment'];
						$filtervalue_id='0';
					}
					select_form('input',$html_etc[$tablename][$fieldname].":",$fieldname,$fieldname."name",$filename,$filtervalue_id,$filtervalue_name,$_GET['fixed']);
					unset($filename);
					break;
				case 'view':
					break;
			}
			break;
		case 'select_textarea':
			switch($mode)	{
				case 'add':
					if($fields['select'][$i]['tablename']!=""&&$fields['select'][$i]['field']!=""&&$fields['select'][$i]['value']!="")
					{
						$filtervalue_name=idtoname(trim($fields['value'][$fieldname]),$mode='dept');
						$filename="frame_depart_notify.php?title=".$common_html['common_html']['select_record']."&tablename=".$fields['select'][$i]['tablename']."&type=1&fieldid=".$fields['select'][$i]['value']."&fieldname=".$fields['select'][$i]['field']."&field=$fieldname";
					}
					else
					{
						$filtervalue_name=isset($filtervalue_name)?$filtervalue_name:trim($fields['value'][$fieldname]);
						$filename="frame_user.php?title=".$common_html['common_html']['select_record']."&TO_ID=".$fieldname."&TO_NAME=".$fieldname."name";
					}
					//print $fieldname;
					$filtervalue_id=isset($_GET[$fieldname])?$_GET[$fieldname].",":'';
					$filtervalue_name=isset($_GET[$fieldname."name"])?$_GET[$fieldname."name"].",":'';
					select_form('textarea',$html_etc[$tablename][$fieldname].":",$fieldname,$fieldname."name",$filename,$filtervalue_id,$filtervalue_name);
					unset($filename);
					break;
				case 'edit':

					switch($_GET['action'])				{
						case 'edit_reply':
							$fields['value'][$fieldname]=$global_hidden_field;
							break;
						case 'edit_forward':
							$fields['value'][$fieldname]='';
							break;
					}

					if($fields['select'][$i]['tablename']!=""&&$fields['select'][$i]['field']!=""&&$fields['select'][$i]['value']!="")
					{
						$filtervalue_name=idtoname(trim($fields['value'][$fieldname]),$mode='dept');
						$filename="frame_depart_notify.php?title=".$common_html['common_html']['select_record']."&tablename=".$fields['select'][$i]['tablename']."&type=1&fieldid=".$fields['select'][$i]['value']."&fieldname=".$fields['select'][$i]['field']."&field=$fieldname";
					}
					else
					{
						$filtervalue_name=isset($filtervalue_name)?$filtervalue_name:trim($fields['value'][$fieldname]);
						$filename="frame_user.php?title=".$common_html['common_html']['select_record']."&TO_ID=".$fieldname."&TO_NAME=".$fieldname."name";
					}
					$temp_id_name=trim($fields['value'][$fieldname]);
					$filtervalue_id=isset($temp_id_name)?$temp_id_name:$filtervalue_name_backup_id;
					$filtervalue_name=isset($filtervalue_name)?$filtervalue_name:$filtervalue_name_backup_name;

					select_form('textarea',$html_etc[$tablename][$fieldname].":",$fieldname,$fieldname."name",$filename,$filtervalue_id,$filtervalue_name);
					unset($filename);
					break;
				case 'view':
					break;
			}
			break;
		case 'select_sms':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=1;
				case 'edit':
					//$fields['value'][$fieldname]=1;
					print_select_single($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),'select_sms',$addtext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",return_select_filter('select_sms',trim($fields['value'][$fieldname])));
					break;
			}
			break;
		
		case 'select_education':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=5;
				case 'edit':
					//$fields['value'][$fieldname]=5;
					print_select_single($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),'select_education',$addtext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",return_select_filter('select_education',trim($fields['value'][$fieldname])));
					break;
			}
			break;
		case 'select_marriage':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=0;
				case 'edit':
					print_select_single($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),'select_marriage',$addtext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",return_select_filter('select_marriage',trim($fields['value'][$fieldname])));
					break;
			}
			break;
		case 'select_politics':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=1;
				case 'edit':
					print_select_single($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),'select_politics',$addtext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",return_select_filter('select_politics',trim($fields['value'][$fieldname])));
					break;
			}
			break;
		case 'select_worklog':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]=1;
				case 'edit':
					print_select_single($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),'select_worklog',$addtext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",return_select_filter('select_worklog',trim($fields['value'][$fieldname])));
					break;
			}
			break;
		case 'userlang':
			switch($mode)	{
				case 'add':
					$fields['value'][$fieldname]='zh';
				case 'edit':
					print_select_single($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),'userlang',$addtext);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",return_select_filter('userlang',trim($fields['value'][$fieldname])));
					break;
			}
			break;
		case 'edit_move':
			switch($mode)	{
				case 'add':
					select_return_navigation($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),1);
				case 'edit':
					select_return_navigation($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),1);
					break;
				case 'view':
					break;
			}
			break;
		case 'mobile':
			switch($mode)	{
				case 'add':

				case 'edit':
					$inputsize = $fields['inputsize'][$fieldname];
					if($inputsize==""||$inputsize==0)	$inputsize = $fields['other']['inputsize'];
					print_tr($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$inputsize,$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1,"mobile");
					$custom_type = "";
					break;
				case 'view':
					$i<5?$colspan=2:$colspan=2;
					$i==1?'':$system_picture_line='';
					$var=trim($fields['value'][$fieldname]);
					$var="<a href='../JXC/sms_sendlist_newai.php?action=add_default&sendlist=".$var."' target='_blank'>$var</a>";
					print_text_tr($html_etc[$tablename][$fieldname].":",$var,$colspan);
					break;
			}
			break;
		case 'multiselect':
			switch($mode)	{
				case 'add':
					print_select_classtable($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['multiselect'][$i]);
					break;
				case 'edit':
					print_select_classtable($html_etc[$tablename][$fieldname].":",$fieldname,trim($fields['value'][$fieldname]),$fields['multiselect'][$i]);
					break;
				case 'view':
					$filtervalue=idtoname($fields['value'][$fieldname],$mode='course');
					print_text_tr($html_etc[$tablename][$fieldname].":",$filtervalue);
					break;
			}
			break;
		case 'hidden_field':
			$hiddenid=$fields['hidden_field'][$i]['hiddenid'];
			$hiddenname=$fieldname;
			global $SUNSHINE_USER_NAME_VAR,$SUNSHINE_USER_DEPT_VAR,$SUNSHINE_USER_DEPT_VAR,$SUNSHINE_USER_ID_VAR,$_SESSION,$SUNSHINE_USER_DEPT_VAR;
			switch($fields['hidden_field'][$i]['hiddentype'])		{
				case 'dept':
					$fields['value'][$fieldname]=$_SESSION['USER_DEPT'];
					break;
				case 'name':
					$fields['value'][$fieldname]=$_SESSION['LOGIN_USER_ID'];
					break;
				case 'realname':
					$fields['value'][$fieldname]=$_SESSION['LOGIN_USER_NAME'];
					break;
				case 'id':
					$fields['value'][$fieldname]=$_SESSION['LOGIN_USER_ID'];
					break;
				case 'value':
					$fields['value'][$fieldname]=$hiddenid;
					break;
				case 'get':
					$fields['value'][$fieldname]=$_GET[$fieldname];
					break;
				case 'post':
					$fields['value'][$fieldname]=$_POST[$fieldname];
					break;
				case 'field':
					//$fields['value'][$fieldname]=$fields['value'][$fieldname];
					break;
			}
			//print $SUNSHINE_USER_NAME_VAR;
			//print $fields['value'][$fieldname];
			switch($mode)	{
				case 'add':
				case 'edit':
					switch($_GET['action'])		{
						case 'edit_reply':
							print_hidden($_SESSION[$SUNSHINE_USER_NAME_VAR],$hiddenname);
							break;
						case 'edit_forward':
							print_hidden($fields['value'][$hiddenname],$hiddenname);
							break;
						default:
							print_hidden($fields['value'][$hiddenname],$hiddenname);
						}
					break;
				case 'view':
					break;
			}
			$global_hidden_field=$fields['value'][$hiddenname];
			break;
		case 'system_datetime':
			switch($mode)	{
				case 'add':
				case 'edit':
					print_hidden(date("Y-m-d H:i:s"),$fieldname);
					break;
				case 'view':
					print_text_tr($html_etc[$tablename][$fieldname].":",trim($fields['value'][$fieldname]));
					break;
			}
			break;
		case 'attchmentid':
			switch($mode)	{
				case 'add':
					print_file($html_etc[$tablename][$fieldname].":",$fieldname);
					break;
				case 'edit':
					$attachmentid_merge=trim($fields['value'][$fieldname]);
					print_hidden($attachmentid_merge,$fieldname);
					//print_file($html_etc[$tablename][$fieldname].":",$fieldname);
					break;
				case 'view':
					break;
			}
			break;
		case 'attchmentname':
			switch($mode)	{
				case 'add':
					print_hidden('',$fieldname);
					break;
				case 'edit':
					//判断文件所在路径
					$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
					$IndexNumber = sizeof($PHP_SELF_ARRAY)-2;
					$DirNameSelf = $PHP_SELF_ARRAY[$IndexNumber];
					if($DirNameSelf!="Framework")		{
						$DirFilePath="../../Framework/";
					}
					else			{
						$DirFilePath="./";
					}
					//判断结束
					$attachmentname_merge=trim($fields['value'][$fieldname]);
					$fileurl=returnfileurl($attachmentid_merge,$attachmentname_merge);
					$span="<SPAN id=new_file></SPAN><BR>\n";
					$index_html=$span."<iframe name=uploadfile frameborder=0 width=100% height=40 scrolling=no src=".$DirFilePath."uploadfile.php></iframe>\n";
					print_text_tr($html_etc[$tablename][$fieldname].":",$index_html);
					print_hidden($attachmentname_merge,$fieldname);
					print "<script>\n";
					print "new_file.innerHTML+=\"$fileurl\";\n";
					print "</script>\n";
					break;
				case 'view':
					break;
			}
			break;
		case 'userdefine':
			switch($mode)	{
				case 'add':
				case 'edit':
					$functionName = trim($fields['userdefine'][$i]);

					$fileName = $functionName.".php";
					$fileName0 = "userdefine/$fileName";
					$fileName = "../../Enginee/userdefine/$fileName";

					if(file_exists($fileName0))		{
						require_once($fileName0);
						$functionName = $functionName."_add";
						if(function_exists($functionName))	{
							$filtervalue = $functionName($fields,$i);
							print $filtervalue;
						}
					}
					else if(file_exists($fileName))		{
						require_once($fileName);
						$functionName = $functionName."_add";
						if(function_exists($functionName))	{

							$filtervalue = $functionName($fields,$i);
							print $filtervalue;
						}
						else	{
							print "函数名称[$functionName]不存在！";
						}
					}
					else	{
						print "没有相应文件,文件名：$fileName";
					}
				break;
				case 'view':

					 if($colflag==0)
					 	$colspan=5;
					 if($colflag==1 || $colflag==0)
					 	print "<tr>\n";
					$functionName = trim($fields['userdefine'][$i]);

					$fileName = $functionName.".php";
					$fileName0 = "userdefine/$fileName";
					$fileName = "../../Enginee/userdefine/$fileName";
					if(file_exists($fileName0))		{
						require_once($fileName0);
						$functionName = $functionName."_view";

						if(function_exists($functionName))	{
							$filtervalue = $functionName($fields,$i);
							print $filtervalue;

						}
					}
					else if(file_exists($fileName))		{
						require_once($fileName);
						$functionName = $functionName."_view";
						if(function_exists($functionName))	{
							$filtervalue = $functionName($fields,$i);
							print $filtervalue;
						}
						else	{
							print "函数名称[$functionName]不存在！";
						}
					}
					else	{
						print "没有相应文件,文件名：$fileName";
					}
					if($colflag==2 || $colflag==0)
	 					print "</tr>\n";
				break;
		}//end userdefine
	}//end switch
	}//end 数据特殊过滤 权限二过滤部分
	else	{
	}
}

//光标定位

//print_R($fields['filter']);
for($i=0;$i<sizeof($fields['filter']);$i++)		{
	if($fields['filter'][$i]=='')		{
		$index=$i;
		break;
	}
}
$focusname=$fields['name'][$index];
switch($mode)			{
	case 'add':
	case 'edit':
		if($focusname!="")				{
		print "<script>
		function Object_focus(Object)
		{
		 var strFloat=Object.legth;
		 Object.focus();
		}
		Object_focus(".$fields['form']['name'].".".$focusname.");
		</script>";
		}
		break;
	case 'view':
		break;
}
//记录子表选项列表模块
global $subtableArray;
//Foreign Key Value
$parent_value = $_GET[$primarykey_index];


if($mode=="view")		{
	for($i=0;$i<sizeof($subtableArray);$i++)
	{
		$mainkey2=$subtableArray[$i]['maintable_key'];
		if($mainkey2!='')
			$parent_valueX=returntablefield($tablename, $primarykey_index, $parent_value, $mainkey2);
		else 
			$parent_valueX=$parent_value;
		ViewChildTableList($subtableArray[$i],$parent_valueX);
	}
}

//表单提交按钮部分模块
switch($mode)	{
	case 'add':
	case 'edit':
		show_submit_element($action_submit,'left');
		break;
	case 'view':
		show_submit_element($action_submit,'left');
		break;
}
table_end();
if($form_attribute!='hidden')
form_end();


global $parse_filename,$tablename;

//用户自定义设计部分,此部分允许自己定义某些显示特性
$允许自定义的类型列表 = array("init_default","init_customer","add_default","edit_default","view_default");
if(in_array($_GET['action'],$允许自定义的类型列表)&&$_SESSION['LOGIN_USER_ID']=='admin')			{
	if($parse_filename=="")		$parse_filename = $tablename;
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	//print_R($PHP_SELF_ARRAY);
	$FILE_SELF_NAME = array_pop($PHP_SELF_ARRAY);
	$FileDirName = array_pop($PHP_SELF_ARRAY);
	$是否是接口目录 = array_pop($PHP_SELF_ARRAY);
	if($是否是接口目录=="Interface"&&$FileDirName!="PGSQL")		{
		//print "<BR><div align=center><a href=\"../CONFIG/config.php?XX=XX&action=".$_GET['action']."&Tablename=$tablename&FileIniname=$parse_filename&FileDirName=$FileDirName&actionconfig=config&GOBACKFILENAME=$FILE_SELF_NAME\" title='配置当前页面显示参数 $执行时间TEXT'>配置当前页面显示参数</a>&nbsp;<a href=\"http://www.tongda2000.com/edu/book/index.php?action=add\" target=_blank title='将问题反馈给开发商进行解决'>问题反馈</a></div>";
	}
}




}
/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：主要实现了输入部分的实现，含：
			 视图部分子表列表实现
 *@函数作者：王纪云
 *@建立日期：2006-1-13
 *@更新日期：2006-1-13
 *@状态说明：注释完成
 */
function viewChildTableList($subtable,$parent_value)		{
global $db;
$maintable_key=$subtable['maintable_key'];
$table_title=$subtable['subtable_title'];
$tablename2=$subtable['subtable_name'];
$childkey2=$subtable['subtable_key'];
$where2=$subtable['subtable_where'];
$where2=str_replace("（", "(",$where2);
$where2=str_replace("）", ")",$where2);
$showlistfieldlist2=$subtable['subtable_showlistfieldlist'];
$columns2=returntablecolumn($tablename2);
$html_etc2=returnsystemlang($tablename2);
$showlistfieldlistArray2 = explode(",",$showlistfieldlist2);
$iniFilename="Model/".$tablename2."_newai.ini";
if(!file_exists($iniFilename))
	$iniFilename="../JXC/Model/".$tablename2."_newai.ini";;
if(!file_exists($iniFilename))
	$iniFilename="../CRM/Model/".$tablename2."_newai.ini";;
if(!file_exists($iniFilename))
	$iniFilename="../Framework/Model/".$tablename2."_newai.ini";;
$file_ini2=parse_ini_file($iniFilename,true);

$org_showlistfieldlist=explode(",",$file_ini2['view_default']['showlistfieldlist']);
$org_showlistfieldfilter=explode(",",$file_ini2['view_default']['showlistfieldfilter']);
$showlistfieldfilterArray2=array();
for($i=0;$i<sizeof($org_showlistfieldlist);$i++)
{
	if(in_array($org_showlistfieldlist[$i], $showlistfieldlistArray2))
		$showlistfieldfilterArray2[$org_showlistfieldlist[$i]]=$org_showlistfieldfilter[$i];
}

//构建SQL语句
$SQLText = "";
for($i=0;$i<sizeof($showlistfieldlistArray2);$i++)			{
	$listIndex = $showlistfieldlistArray2[$i];
	$listIndexName = $columns2[$listIndex];
	if($SQLText!="")
		$SQLText.=",";
	$SQLText .= $listIndexName;
}

if(is_array($parent_value))
{
	$childkey2Array=explode(",", $childkey2);
	$mainkey2Array=explode(",", $maintable_key);
	$SQL_Select = "select $SQLText from $tablename2 where 1=1 ";
	$i=0;

	foreach ($mainkey2Array as $row)
	{
		$SQL_Select=$SQL_Select."and ".$childkey2Array[$i]."='".$parent_value[$row]."' ";
		$i++;
	}
}
else
	$SQL_Select = "select $SQLText from $tablename2 where $childkey2 = '".$parent_value."'";
if($where2!='')
{
	$where2=str_replace(":", "=", $where2);
	$where2=str_replace("\\", "", $where2);
	$where2=str_replace("‘", "'", $where2);
	$where2=str_replace("’", "'", $where2);
	$SQL_Select.=" and ".$where2;
}
//print_r($SQL_Select);
$rs = $db->Execute($SQL_Select);
$rs_a = $rs->GetArray();
//print_R($rs_a);print_R($showlistfieldlistArray2);
print "<tr ><td colspan=6 nowrap width=100%>\n";
table_begin("100%");
//标题显示部分
if($table_title!="")
{
	/*
	$url_filename=$tablename2."_newai.php";
	if(file_exists("../JXC/".$url_filename))
	{
		$url_filename="../JXC/".$url_filename;
	}
	else if(file_exists("../CRM/".$url_filename))
	{
		$url_filename="../CRM/".$url_filename;
	}
	else 
		$url_filename="";
	if($url_filename!='')
	{
		$table_title="<a href='$url_filename' target='_blank'>$table_title</a>";
	}
	*/
	print "<tr><td class=TableHeader align=center colspan=".sizeof($showlistfieldlistArray2).">$table_title</td></tr>";
}
print "<tr class=TableContent>\n";

for($i=0;$i<sizeof($showlistfieldlistArray2);$i++)			{
	$listIndex = $showlistfieldlistArray2[$i];
	$listIndexName = $columns2[$listIndex];
	$listFilter = $showlistfieldfilterArray2[$listIndex];
	
	$listFilterArray = explode(":",$listFilter);
	
	if(stristr($listFilterArray[0],"tablefilter") && $listFilterArray[1]==$tablename2)
	{
		
		$TempColumns = returntablecolumn($listFilterArray[1]);
		$showText=$html_etc2[$tablename2][$TempColumns[$listFilterArray[3]]];
	}
	else 
		$showText=$html_etc2[$tablename2][$listIndexName];
	print "<td nowrap>".$showText."</td>";
}
print "</tr>";
$allnum=array();
$allmoney=array();
//数据窗口部分
for($j=0;$j<sizeof($rs_a);$j++)								{
	print "<tr class=TableData>\n";
	for($i=0;$i<sizeof($showlistfieldlistArray2);$i++)			{
		$listIndex = $showlistfieldlistArray2[$i];
		$listIndexName = $columns2[$listIndex];
		$listFilter = $showlistfieldfilterArray2[$listIndex];
		
		//数据过滤区
		$listFilterArray = explode(":",$listFilter);
		if(stristr($listFilterArray[0], 'color'))
			$hascolor=true;
		else 
			$hascolor=false;
		$nowrap="";
		if(strlen($rs_a[$j][$listIndexName])<20)
			$nowrap="nowrap";
		switch($listFilterArray[0])				{
			
			case 'tablefilter':
			case 'tablefiltercolor':	
				$TempColumns = returntablecolumn($listFilterArray[1]);
				
				
				
				$DataElement = returntablefieldColorFilterGray($listFilterArray[1],$TempColumns[(string)$listFilterArray[2]],$rs_a[$j][$listIndexName],$TempColumns[(string)$listFilterArray[3]],'','','',$hascolor);
				break;
			case 'radiofilter':
				$TempColumns = returntablecolumn($listFilterArray[1]);
				$DataElement = returntablefield($listFilterArray[1],$TempColumns[(string)$listFilterArray[2]],$rs_a[$j][$listIndexName],$TempColumns[(string)$listFilterArray[3]]);
				break;
			case 'radiofiltergroup':
				$TempColumns = returntablecolumn($listFilterArray[1]);
				$DataElement = returntablefield($listFilterArray[1],$TempColumns[(string)$listFilterArray[2]],$rs_a[$j][$listIndexName],$TempColumns[(string)$listFilterArray[3]]);
				break;
			case 'select_sex':
				$DataElement = returnsex($rs_a[$j][$listIndexName]);
				break;
			case 'boolean':
				$DataElement = returnboolean($rs_a[$j][$listIndexName]);
				break;
			case 'money':
				$DataElement = number_format($rs_a[$j][$listIndexName],2);
				break;
			case 'datetime':
				if($rs_a[$j][$listIndexName]=='0000-00-00 00:00:00')
					$DataElement='';
				else 
					$DataElement = $rs_a[$j][$listIndexName];
				break;
			/*
			case 'input':
				$DataElement=cutStr($rs_a[$j][$listIndexName],15);
				if($DataElement!=$rs_a[$j][$listIndexName])
					$DataElement="<span title='".$rs_a[$j][$listIndexName]."'>".$DataElement."..</span>";
				else
					$DataElement = $rs_a[$j][$listIndexName];
				break;
			case 'textarea':
				if(cutStr($rs_a[$j][$listIndexName],30)!=$rs_a[$j][$listIndexName])
					$DataElement = "<div title='".$rs_a[$j][$listIndexName]."'>".cutStr($rs_a[$j][$listIndexName],30)."...</div>";
				else 
					$DataElement = $rs_a[$j][$listIndexName];
				break;
			*/
			case 'qq':
				$DataElement = (!empty($rs_a[$j][$listIndexName])?"<a target=\"_blank\" href=\"http://wpa.qq.com/msgrd?v=3&amp;uin=".$rs_a[$j][$listIndexName]."&amp;site=qq&amp;menu=yes\"><img border=\"0\" src=\"http://wpa.qq.com/pa?p=2:".$rs_a[$j][$listIndexName].":45\" onerror=\"this.src='".ROOT_DIR."general/ERP/Framework/images/help3.gif';this.title='此QQ号码可能不存在'\" title=\"点击这里发消息\">".$rs_a[$j][$listIndexName]."</a>":'');
				break;	
			case 'mobile':
				$addicon="<img  src='".ROOT_DIR."general/ERP/Framework/images/menu/gif-0348.gif' title='点击号码发送短信'>";
				if($rs_a[$j][$listIndexName]!='')
					$DataElement = "<a href='../JXC/sms_sendlist_newai.php?".base64_encode("action=add_default&sendlist=".$rs_a[$j][$listIndexName])."' target='_blank'>".$addicon.$rs_a[$j][$listIndexName]."</a>";		
				else 
					$DataElement = $rs_a[$j][$listIndexName];
				break;
			case 'email':
				$linkman='';
				$fromsrc='';
				
				if($tablename2 == 'linkman'){
					$fromsrc = 'customer';
					$linkman = gettablefield($tablename2,'email','rowid',$rs_a[$j][$listIndexName]);
				}else if($tablename2 == 'supplylinkman'){
					$fromsrc = 'supply';
					$linkman = gettablefield($tablename2,'email','rowid',$rs_a[$j][$listIndexName]);
				}	
				else 
				{
					$linkman=$rs_a[$j][$listIndexName];
					$fromsrc='';
				}
				$addicon="<img src='".ROOT_DIR."general/ERP/Framework/images/menu/gif-0037.gif' title='点击链接发送邮件'>";
				if($rs_a[$j][$listIndexName]!='')
					$DataElement = "<a href='../CRM/email_newai.php?".base64_encode("action=add_default&sendlist=".$linkman."&fromsrc=".$fromsrc)."' target='_blank' >".$addicon.$rs_a[$j][$listIndexName]."</a>";		
				break;
			case 'picturefile':
				global $ifincludemaginfier;
				$PicturePath=$rs_a[$j][$listIndexName];
				if($PicturePath!=""&&strlen($PicturePath)>10)
				{
					if(!$ifincludemaginfier)
					{
						print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
						print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.magnifier.js\"></script>";
						$ifincludemaginfier=true;
					}
					$DataElement = "<img src='".$PicturePath."' width=32  class=\"magnify\"  data-magnifyto=\"500\" onmouseover=\"this.style.cursor='pointer';this.style.cursor='hand'\" onmouseout=\"this.style.cursor='default'\">";

					//$file_path="<a href='$PicturePath'><img src='".$PicturePath."' border=0 width=120></a>";
				}
				else
					$DataElement="";
				break;
			case 'userdefine':
					$functionName = trim($listFilterArray[1]);

					$fileName = $functionName.".php";
					$fileName0 = "userdefine/$fileName";
					$fileName = "../../Enginee/userdefine/$fileName";
					if(file_exists($fileName0))		{
						require_once($fileName0);
						$functionName = $functionName."_value";
						
						if(function_exists($functionName))	{
							$DataElement = $functionName($rs_a[$j][$listIndexName],$rs_a,$j);
						}
					}
					else
						$DataElement = $rs_a[$j][$listIndexName];
				break;
			case 'tdoafile':
					require_once('lib/utility_file.php');
					//形成通达OA下载文件所需要的变量格式
					$var_value_array = explode('||',$rs_a[$j][$listIndexName]);
					$ATTACHMENT_ID = $var_value_array[1];
					$ATTACHMENT_NAME = $var_value_array[0];
					if(strlen($rs_a[$j][$listIndexName])<3)
					   $file_path =  "无附件";
					else
					   $file_path = attach_link($ATTACHMENT_ID,$ATTACHMENT_NAME,1,1,1,0,0,1,1,0);
					//print_R($ATTACHMENT_NAME);exit;
					print "<script src=\"../../Enginee/lib/attach.js\"></script>";
					print "
					<input type=\"hidden\" name=\"ATTACHMENT_ID_OLD\" value=\"$ATTACHMENT_ID\">
					<input type=\"hidden\" name=\"ATTACHMENT_NAME_OLD\" value=\"$ATTACHMENT_NAME\">";
					$DataElement=$file_path;
					
					break;
	
			default:
				$DataElement = $rs_a[$j][$listIndexName];
				break;
		}
		if($listIndexName=='zhekou')
			$DataElement=($DataElement*100)."%";
		
		$tip='';
		
		if((stristr($tablename2, "detail") || $tablename2=="store_product")  && $listIndexName=='num')
		{
			$tablename3=$tablename2."_color";
			if($tablename2=="store_product")
				$tablename3="store_color";
			$sql="SELECT COUNT(*) as allnum FROM information_schema.TABLES WHERE TABLE_NAME='$tablename3'";
			$rs=$db->Execute($sql);
			if($rs->fields['allnum']>0)
			{
				$sql = "select id,$SQLText from $tablename2 where $childkey2 = '".$parent_value."'";
				$rs=$db->Execute($sql);
				$rs_id=$rs->GetArray();
				
				$id=$rs_id[$j][id];
				
				$sql="select a.num,b.name from $tablename3 a inner join productcolor b on a.color=b.id where a.id=$id";
				$rs=$db->Execute($sql);
				$rs_color=$rs->GetArray();
				
				foreach ($rs_color as $row)
					$tip.=$row[name].":".$row[num]."\r\n";
				
				if($tip!='')
				$tip=" <span title='$tip'><img src='".ROOT_DIR."general/ERP/Framework/images/sepan.gif'></span>";
				
			}
		}
		print "<td $nowrap>".$DataElement.$tip."</td>";
		if(stristr($html_etc2[$tablename2][$listIndexName], "数量"))
			$allnum[$html_etc2[$tablename2][$listIndexName]]=$allnum[$html_etc2[$tablename2][$listIndexName]]+$rs_a[$j][$listIndexName];
		else if(stristr($html_etc2[$tablename2][$listIndexName], "金额"))
			$allmoney[$html_etc2[$tablename2][$listIndexName]]=$allmoney[$html_etc2[$tablename2][$listIndexName]]+$rs_a[$j][$listIndexName];
	}
	print "</tr>";
}
if(sizeof($allnum)>0 || sizeof($allmoney)>0)
{
print "<tr class=TableData><td align=center><b>合计</b></td>";
for($i=1;$i<sizeof($showlistfieldlistArray2);$i++)			{
		$listIndex = $showlistfieldlistArray2[$i];
		$listIndexName = $columns2[$listIndex];
		if(array_key_exists($html_etc2[$tablename2][$listIndexName],$allnum))
			print "<td nowrap>".$allnum[$html_etc2[$tablename2][$listIndexName]]."</td>";
		else if(array_key_exists($html_etc2[$tablename2][$listIndexName],$allmoney))
			print "<td nowrap>".$allmoney[$html_etc2[$tablename2][$listIndexName]]."</td>";
		else
			print "<td nowrap></td>";


}
print "</tr>";

}
if(sizeof($rs_a)==0)
{
	print "<tr class=TableData><td align=center nowrap colspan=".sizeof($showlistfieldlistArray2)."><font color=gray>无此项记录</font></td>";
	print "</tr>";
}
table_end();
print "</td></tr>";
}
?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>