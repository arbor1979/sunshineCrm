<?php
ini_set('date.timezone','Asia/Shanghai');
/*****************************************************************\
1、本系统为商业软件，受国家著作权法保护，任何人不得在
原作者未同意的基础上进行拷贝，或进行商业用途。
2、本次版本为非开源版，如果你使用，请注意获取许可证。
3、本系统作者保留一切相关的知识产权
\*****************************************************************/

//把数字金额转换成中文大写数字的函数
function num2rmb ($num)					{

	$num = ereg_replace(",","",$num);
	$c1="零壹贰叁肆伍陆柒捌玖";
	$c2="分角元拾佰仟万拾佰仟亿";
	$num=round($num,2);
	$num=$num*100;
	$NewNum = ceil($num);
	if(strlen($NewNum)>10){
		return "金额太大";
	}

	$i=0;
	$c="";

	while (1)			{
		if($i==0){
			$n=substr($num,strlen($num)-1,1);
		}else{
			$n=$num %10;
		}

		$p1=substr($c1,2*$n,2);

		$p2=substr($c2,2*$i,2);
		if($n!='0' || ($n=='0' &&($p2=='亿' || $p2=='万' || $p2=='元' ))){
			$c=$p1.$p2.$c;
		}else{
			$c=$p1.$c;
		}

		$i=$i+1;
		$num=$num/10;
		$num=(int)$num;

		if($num==0){
			break;
		}
	}//end of while| here, we got a chinese string with some useless character

	//we chop out the useless characters to form the correct output
	$j = 0;
	$slen=strlen($c);
	while ($j< $slen) {
		$m = substr($c,$j,4);
		if ($m=='零元' || $m=='零万' || $m=='零亿' || $m=='零零'){
			$left=substr($c,0,$j);
			$right=substr($c,$j+2);
			$c = $left.$right;
			$j = $j-2;
			$slen = $slen-2;
		}
		$j=$j+2;
	}

	if(substr($c,strlen($c)-2,2)=='零'){
		$c=substr($c,0,strlen($c)-2);
	} // if there is a '0' on the end , chop it out

	return $c;
}// end of function


//系统帮助文档说明表格形成部分
function systemhelpContent($title,$width='100%')		{
	global $db,$_GET;
	$sql = "select text from systemhelp where systemhelpname='$title'";
	$rs = $db->cacheExecute(15,$sql);
	$rs_a = $rs->GetArray();
	$Content = html_entity_decode($rs_a[0]['text']);
	if($_GET['action']=="init_default"||$_GET['action']=="init_customer")				{
	print "
		<BR>
		<table width='$width' align=center class=TableBlock>
			<tr class='TableContent'>
				<td  align='left' style='cursor:pointer' title='点击显示或隐藏' onclick='$(\"#helpcontent\").toggle();'>$title-操作说明</td>
			</tr>
			<tr class='TableData'>
				<td  align='left'><div id='helpcontent' style='display:none'>
				".nl2br($Content)."</div>
			 </td>
			</tr>
		</table>
	";
	}//end if
}


function getmicrotime(){
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

function idtoname($id,$mode='dept')		{
	global $common_html,$_SESSION,$SUNSHINE_USER_LANG_VAR;
	$systemlang=$_SESSION[$SUNSHINE_USER_LANG_VAR];
	$id_array=explode(',',$id);
	for($j=0;$j<sizeof($id_array);$j++)	{
		switch($mode)	{
			case 'user':
				$NICK_NAME=returntablefield('user','USER_NAME',$id_array[$j],'NICK_NAME');
				if($NICK_NAME!='')
					$name_array[$j]=$NICK_NAME;
				else
					$name_array[$j]=$id_array[$j];
				break;
			case 'course':
				$NICK_NAME=returntablefield('A_Course0','课程号',$id_array[$j],'课程名');
				if($NICK_NAME!='')
					$name_array[$j]=$NICK_NAME;
				else
					$name_array[$j]=$id_array[$j];
				break;
			case 'YuanXi':
				$NICK_NAME=returntablefield('A_YuanXi','院系号',$id_array[$j],'院系名');
				if($NICK_NAME!='')
					$name_array[$j]=$NICK_NAME;
				else
					$name_array[$j]=$id_array[$j];
				break;
			case 'dept':
				if($systemlang=='en')
					$return='ENGLISHNAME';
				else
					$return='DEPT_NAME';
				if($id_array[$j]==0||$id_array[$j]=='')
					$name_array[$j]=$common_html['common_html']['AllDepartment'];
				else
					$name_array[$j]=returntablefield('department','DEPT_ID',$id_array[$j],$return);
				break;
		}//end switch
	}//end for
	$name=join(',',$name_array);
	//print_R($name_array);
	return $name;
}

function returnpageaction($mode='edittodelete',$array_return=array())	{
	global $_GET,$_POST,$_SERVER;
	global $group_element;
	$QUERY_STRING=$_SERVER['QUERY_STRING'];
	if(empty($QUERY_STRING))	$QUERY_STRING="action=".$_GET['action'];
	$array=explode('&',$QUERY_STRING);
	$i=0;	$return_mark=false;		$return_mark2=false;
	foreach($array as $list)	{
		$temp=explode('=',$list);
		switch($temp[0])		{
			case $array_return['index_name']:
				$temp[1]=$array_return['index_id'];
				$return_mark=true;//print $temp[1];exit;
				break;
			case $array_return['index_name2']:
				$temp[1]=$array_return['index_id2'];
				$return_mark2=true;
				break;
			case 'action':
				$temp_=explode('_',$temp[1]);
				switch($mode)	{
					case 'edittodelete':
						$temp_[0]="delete";
						$temp[1]=join('_',$temp_);
						break;
					case 'group_filter':
						$temp_[0]='init';
						$temp[1]=$temp_[0]."_".$temp_[1];
						break;
					case 'edit_init':
						$temp_[0]='init';
						$temp[1]=$temp_[0]."_".$temp_[1];
						break;
					case 'delete_init':
						$temp[1]=$_GET['returnmodel'];
						break;
					case 'init_edit':
						$temp_[0]='edit';
						$temp[1]=$temp_[0]."_".$temp_[1];
						break;
					case 'init_view':
						$temp_[0]='view';
						$temp[1]=$temp_[0]."_".$temp_[1];
						break;
					case 'init_project':
						$temp[1]='framework_default';
						break;
					case 'init_add':
						$temp_[0]='add';
						$temp[1]=$temp_[0]."_".$temp_[1];
						break;
					case 'init_set':
						$temp_[0]='set';
						$temp[1]='set_default';
						break;
					case 'add_data':
						$temp_[0]='add';
						$temp[1]=$temp_[0]."_".$temp_[1]."_data";
						break;
					case 'init_edit_data':
						$temp_[0]='edit';
						$temp[1]=$temp_[0]."_".$temp_[1]."_data";
						break;
					case 'init_share':
						$temp[1]='edit_share';
						break;
					case 'init_move':
						$temp[1]='edit_move';
						break;
					case 'init_reply':
						$temp[1]='edit_reply';
						break;
					case 'init_forward':
						$temp[1]='edit_forward';
						break;
					case 'init_delete':
						$temp[1]='delete_array';
						break;
					case 'delete_inbox':
						$temp[1]='delete_inbox';
						break;
					case 'delete_outbox':
						$temp[1]='delete_outbox';
						break;
					case 'pageid':
						$temp[1]=$array_return['index_id2'];
						break;
				}
				break;
		}
		$returnstring[$i]=join('=',$temp);
		$i++;
	}
	//print_R($array_return);
	$return=join('&',$returnstring);
	switch($mode)		{
		case 'edittodelete':
			$return=$return."&returnmodel=init_".$temp_[1];
			break;
		case 'group_filter':
			if(!$return_mark)
			$return=$return."&".$array_return['index_name']."=".$array_return['index_id'];
			if(!$return_mark2&&$array_return['index_name2'])
			$return=$return."&".$array_return['index_name2']."=1";
			break;
		case 'init_set':
			$return=$return."&".$array_return['index_name']."=".$array_return['index_id'];
			$return=$return."&".$array_return['index_name2']."=".$array_return['index_id2'];
			$return=$return."&".$array_return['index_name3']."=".$array_return['index_id3'];
			break;
			break;
		case 'page':
		case 'init_edit_data':
		case 'init_delete':
		case 'delete_inbox':
		case 'delete_outbox':
		case 'init_view':
		case 'init_project':
		case 'init_edit':
			if(!$return_mark)
			$return=$return."&".$array_return['index_name']."=".$array_return['index_id'];
			break;
		case 'init_share':
			if(!$return_mark)
			$return=$return."&".$array_return['index_name']."=".$array_return['index_id'];
			break;
		case 'init_move':
			if(!$return_mark)
			$return=$return."&".$array_return['index_name']."=".$array_return['index_id'];
			break;
		case 'edit_init':
			break;
	}
	unset($returnstring);//print $return;
	return $return;
}
//------------------------------------------------------------------------------
//pageindexto
//------------------------------------------------------------------------------
function print_infor($var,$infor='trip',$return="",$indexto='',$SYSTEM_SECOND2=0)			{
	global $common_html;
	global $SYSTEM_SECOND;
	


	if($SYSTEM_SECOND=='')			{
		$SYSTEM_SECOND = $SYSTEM_SECOND2;
	}
	
	if($infor=='trip' || $infor=='')
		$infor='info';
	
	$themeurl=ROOT_DIR."general/ERP/theme/3/images/";
	
	print "
	
	<style>
	.MessageBox td.info{
   background:url('".$themeurl."icon64_info.png') no-repeat top left;
   background-position:10px 10px;
	}
	.MessageBox td.error{
   background:url('".$themeurl."icon64_error.png') no-repeat top left;
   background-position:10px 10px;
	}

.MessageBox td.warning{
   background:url('".$themeurl."icon64_warning.png') no-repeat top left;
   background-position:10px 10px;
}
.MessageBox td.forbidden{
   background:url('".$themeurl."icon64_forbidden.png') no-repeat top left;
   background-position:10px 10px;
}
.MessageBox td.stop{
   background:url('".$themeurl."icon64_stop.png') no-repeat top left;
   background-position:10px 10px;
}
</style>";
	print "<div align=\"center\" title=\"".$common_html['common_html'][$infor]."\">\n";

	print "
		<center><table class='MessageBox' align='center' width='320' height='90'>
	   <tr class='head-no-title'>
		  <td class='left'></td>
		  <td class='center'></td>
		  <td class='right'></td>
	   </tr>
	   <tr class='msg'>
		  <td class='$infor' width=90 height=90>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  <td >
			 <div >
			 &nbsp;&nbsp;$var</div>
		  </td>
		  <td class='right'></td>
	   </tr>
	   <tr class='foot'>
		  <td class='left'></td>
		  <td class='center'></td>
		  <td class='right'></td>
	   </tr>
	</table>
	</center>";

	//兼容UCHOME学生端内容调用所使用的参数信息2011-06-25
	$returnurlcode = returnurlcode();
	if( strlen($return) == strlen("location='?'") )		{
		$return="location='?$returnurlcode'";
	}
	//print $return;

	if($indexto=="?")		{
		$indexto="?$returnurlcode";
	}
	//兼容UCHOME学生端内容调用所使用的参数信息2011-06-25

	
	if($return=='close')		{
		print "<br>\n";
		print "<div align=center>\n";
		print "  <input type=button accesskey='r' value=\"关闭\" class=\"SmallButton\" onclick=\"window.close();\">\n";
		print "</div>\n";
	}
	else if($return!='')		{
		print "<br>\n";
		print "<div align=center>\n";
		print "  <input type=button accesskey='r' value=\"返回\" class=\"SmallButton\" onclick=\"$return\">\n";
		print "</div>\n";
	}
	
	//exit;
	$SYSTEM_SECOND!=""?'':$SYSTEM_SECOND=0;
	
	
	$indexto==''?'':print "<script>setTimeout('autoNavi()',$SYSTEM_SECOND*1000);
	function autoNavi()
	{
			
			if(this.opener)
			{
				this.opener.location.reload();
				window.close();
			}
			else
				location.href='$indexto';
	}
	
	</script>\n";
	if($indexto=='close')
	{
		print "<script>

	window.onunload = function(){
         this.opener.location.reload();         
    }
	</script>\n";
	}
	
}

//兼容UCHOME学生端内容调用所使用的参数信息2011-06-25
function returnurlcode()			{
	global $_GET;
	$PHP_SELF_ARRAY = explode("/",$_SERVER['PHP_SELF']);
	$FILENAME		= array_pop($PHP_SELF_ARRAY);
	if($FILENAME=="space.php")			{
		$URL = "&ffx=ffx&&uid=".$_GET['uid']."&do=".$_GET['do']."&view=".$_GET['view']."&ffx=ffx&";
		return $URL;
	}
	else	{
		return '';
	}
}
function cutStr($str, $length = '') { // $length为字符个数，不是字节
 if ($length != '') { // 如果$length不为空
  $len = strlen($str); //得到字符长度
  $strOk = '';
  $i = 0; //字符长度
  $n = 0; //字符个数
  while ($i < $len && $n < $length) {
   $ascii = ord($str{$i}); //得到当前字节的ASCII码
   if ($ascii > 129) { // 大于129，是2个字节字符
    $strOk .= substr($str, $i, 2);
    $i += 2;
    $n++;
   } else { // 小于等于129，是1个字节字符
    $strOk .= substr($str, $i, 1);
    $i++;
    $n++;
   }
  }
 } else {
  $strOk = $str;
 }
 return $strOk;
}



function print_close()			{
	global $common_html;
	global $SYSTEM_SECOND;
	//$return="history.back();";
	print "<div align=center><input type=button value=\"".$common_html['common_html']['close']."\" class=\"SmallButton\" onclick=\"window.close();\"></div>";
}

function print_nouploadfile($string='你还没有提交上传的文件',$return='history.back();')		{
	global $db;
	$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
	print "
<LINK href='".ROOT_DIR."theme/".$LOGIN_THEME."/style.css' type=text/css rel=stylesheet>


	<style type='text/css'>
	.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
</style>
<BODY class=bodycolor topMargin=5 >
<BR>
<table width='450'  border='0' align='center' cellpadding='0' cellspacing='0' class='small' style='border:1px solid #006699;'>
<tr>
<td height='80' valign=middle align='middle' colspan=2  bgcolor='#E0F2FC'>
<font color=red >$string<BR><BR><input type=button accesskey='c' name='cancel' value=' 点击返回 ' class=SmallButton onClick=\"$return\" title='快捷键:ALT+c'></font>
</td>
</tr>
<tr>
</table>";
}
//-----------------------------------------------------------------------------
//page_css()
//-----------------------------------------------------------------------------
function page_css($add="",$title="Sunshine20",$相对路径="1")	{
	global $choose_lang,$framework_html,$LOGIN_THEME;
	global $_SESSION,$action_type,$html_etc,$tablename;

	//$LOGIN_THEME=$_SESSION['SUNSHINE_USER_LOGIN_THEME'];
	$LOGIN_THEME==""?$LOGIN_THEME=3:'';
	if($title=='Sunshine20')		{
		$title=$framework_html[$choose_lang]['index_title'];
		$pageText = $add;
	}
	else	{
		$pageText = $title." - ".$add;
	}
	//print $LOGIN_THEME;print_R($_SESSION);;exit;
	//判断类型
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	array_pop($PHP_SELF_ARRAY);
	array_shift($PHP_SELF_ARRAY);
	//print_R($PHP_SELF_ARRAY);
	if(in_array("TDLIB",$PHP_SELF_ARRAY))		{
		$DIRNAME = "TDLIB";
	}
	
	elseif(in_array("ERP",$PHP_SELF_ARRAY))		{
		$DIRNAME = "ERP";
	}
	else	{
		$DIRNAME = "EDU";
	}
	
	if($_SESSION['LOGIN_THEME']!="") $LOGIN_THEME_TEXT = $_SESSION['LOGIN_THEME'];
	else	 $LOGIN_THEME_TEXT = 3;
	print "<TITLE>$pageText</TITLE>
	<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">
	<meta http-equiv=\"x-ua-compatible\" content=\"IE=6\">
	<LINK href=\"".ROOT_DIR."theme/$LOGIN_THEME_TEXT/style.css\" type=text/css rel=stylesheet>
	<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/$DIRNAME/Enginee/lib/common.js\"></script>
	<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/$DIRNAME/Enginee/lib/base64.js\"></script>
	<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/$DIRNAME/Enginee/lib/choose_all.js\"></script>
	<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/$DIRNAME/Enginee/lib/choose_all_form_zh.js\"></script>\r\r";
	if($action_type=='init' )
	{
		print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/$DIRNAME/Enginee/jquery/jquery.js\"></script>
		<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/$DIRNAME/Enginee/jquery/jquery-powerFloat.js\"></script>
		<LINK href=\"".ROOT_DIR."general/$DIRNAME/Enginee/jquery/powerFloat.css\" type=text/css rel=stylesheet>";
		print "<script type=\"text/javascript\">\n
		 function addClass(element, value) {
		 
         if(!element.className) {
             element.className = value; //如果element本身不存在class,则直接添加class为value的值
          } else {
          	 //element.className += \" \"+value; //如果element之前有一个class值，注意中间要多一个空格,然后再加上value的值
             element.className = value; 
          }
          
     }
     
     function stripeTable() {
         var tables = document.getElementsByTagName(\"table\"); //遍历文档中的所有table
          for(var i=0; i<tables.length; i++) {
             var rows = document.getElementsByTagName(\"tr\");
             for(var j=0; j<rows.length; j++) {
                 if(j%2 == 0) {
                     addClass(rows[j], \"TableLine2\"); //如是偶数行，则添加class为odd的属性
                      //rows[j].setAttribute(\"class\", \"odd\");
                  }
                  else
                  	 addClass(rows[j], \"TableLine1\"); //如是奇数行，则添加class为odd的属性
             }
         }
     }
     function highlightRows() {
     	
         var rows = document.getElementsByTagName(\"TR\");
         for(var i=0; i<rows.length; i++) {
         	
         	if(rows[i].className=='TableLine1' || rows[i].className=='TableLine2')
         	{
         		
             rows[i].oldClassName = rows[i].className; //首先保存之前的class值
              rows[i].onmouseover = function() {
              	 
                 addClass(this, \"highlight\"); //鼠标经过时添加class为highlight的值
                 
              }
             rows[i].onmouseout = function() {
                 this.className = this.oldClassName; //鼠标离开时还原之前的class值
                 
             }
             }
         }
         
     }
     $(function() {
     
     	highlightRows();
     });
	
    </script>
		";
	}
	if($action_type=='view' )
	{
	
		print "
		<script language=\"javascript\" src=\"../LODOP60/LodopFuncs_new.js\"></script>
		
	<script language = 'JavaScript'>
	
	  var LODOP; //声明为全局变量 
	function print_control(){
         	
				LODOP=getLodop();  			
				LODOP.PRINT_INIT(\"查看视图打印\");
				var strBodyStyle= \"<LINK href='".ROOT_DIR."theme/$LOGIN_THEME_TEXT/style.css' type=text/css rel=stylesheet><style>.TableControl{display:none;}table {width:100%}</style>\";
				LODOP.ADD_PRINT_HTM(20,'5%','90%','10%','<h2 align=center>".$_SESSION['UNIT_NAME']."<br>".$html_etc[$tablename][$tablename]."</h2>');
				var strFormHtml=\"<div style='margin:auto;'>\"+strBodyStyle+document.getElementById(\"form\").innerHTML+\"</div>\";			
				LODOP.ADD_PRINT_HTM('10%','5%','90%','84%',strFormHtml);
				//LODOP.SET_PRINT_STYLEA(0,'Vorient',3);
				//LODOP.SET_PRINT_MODE(\"PRINT_PAGE_PERCENT\",\"Auto-Width\");// 整宽不变形
				LODOP.ADD_PRINT_TEXT('96%','45%','10%','5%','第#页/共&页');
				LODOP.SET_PRINT_STYLEA(0,'ItemType',2);
				LODOP.SET_PRINT_STYLEA(0,'Horient',1);
				LODOP.SET_PRINT_STYLEA(0,'Vorient',1);
				LODOP.PREVIEW();
				
	}
	
	function XExportToExcel(filename)
	{
		 var content=form1.innerHTML;
		 form1.userdefine.value=encodeURIComponent(content); 
		 form1.action='../../Framework/viewexport.php?filename='+encodeURIComponent(filename)
		 form1.target='_self';
		 form1.submit();
	}
	</script>";
	}
	print "
	<STYLE>
	@media print {
	input{display:none}
	}
	xmp{page-break-before: always}
	.highlight {BACKGROUND:#d0ecfa;}
	</STYLE>
	<BODY class=bodycolor topMargin=5 leftmargin=0 rightmargin=0 bottommargin=0>";
}
/*系统调试函数
主要是调用php的内部函数print_r()，其实print_r就是用来调试用的，只是有些地方不够好，比如缩进关系，每次写还要在前面加上echo "<pre>" ，其实这很不爽的！还有内部的var_dump(),反正效果不怎么理想的，所以就写了这个，在配置文件中加上此函数、每次调用只要dump($var) $var不管是变量、数组、类库都能打印出来
2010-8-2
*/
function dump($vars, $label = '', $return = false) {
    if (ini_get('html_errors')) {
        $content = "<pre>\n";
        if ($label != '') {
            $content .= "<STRONG>{$label} :</STRONG>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true));
        $content .= "\n<pre>\n";
    }else {
        $content = $label . " :\n" . print_r($vars, true);
    }
    if($return) {
        return $content;
    }else {
        echo $content;
        return null;
    }
}
//字符串转换为浮点数
function floatvalue($value) {
     return floatval(ereg_replace("[^-0-9\.]","",$value));
}
//菜单权限验证
function validateMenuPriv()
{
	$uniMenuArray=func_get_args();
	$hasPriv=false;
	
	for($i=0;$i<count($uniMenuArray);$i++)
	{
		
		$uniMenu=$uniMenuArray[$i];
		$menuid=returntablefield("sys_function", "unimenu",$uniMenu,"func_Id");
		$menuStr=explode(",",$_SESSION['LOGIN_FUNC_ID_STR']);
		if(in_array($menuid,$menuStr))
		{
			$hasPriv=true;
		}
	}
	if(!$hasPriv)
	{
		print "<script language='javascript'>
		alert('对不起，您没有权限访问此页面');
		if(history.length==0)
			window.close();
		else
			window.history.back(-1);
		</script>";
		exit;
	}
	
}
//单个菜单权限验证
function validateSingleMenuPriv($uniMenu)
{

	$hasPriv=false;
	
	$menuid=returntablefield("sys_function", "unimenu",$uniMenu,"func_Id");
	$menuStr=explode(",",$_SESSION['LOGIN_FUNC_ID_STR']);
	if(in_array($menuid,$menuStr))
	{
		$hasPriv=true;
	}
	return $hasPriv;
	
}
function sendEmail($destlist,$zhuti,$content)
{

		require_once('../../Framework/phpmailer/class.phpmailer.php');

			$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
			$mail->IsSMTP(); // telling the class to use SMTP
			$error="";
			try {
				
				$mail->Host       = $_SESSION['SMTPServerIP']; // SMTP server
	  			//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
	 			$mail->SMTPAuth   = true;                  // enable SMTP authentication
	  			$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
	  			$mail->CharSet = "gb2312"; 
	  			$mail->Username   = $_SESSION['EmailAddress']; // SMTP account username
	  			$mail->Password   = $_SESSION['EmailPassword'];        // SMTP account password
				$mail->AddReplyTo($_SESSION['EmailAddress'], $_SESSION['LOGIN_USER_NAME']);
				 
			  $j=0;
			 
			  for($i=0;$i<count($destlist);$i++)
			  {
			  	
			  	 
			  	if($destlist[$i]['email']!='')
			  	{
			  		$mail->AddAddress($destlist[$i]['email'], $destlist[$i]['name']);
			  		$j=$j+1;
			  	}
			  	
			  }
			  
				if($j==0)
				{
					print "<script language=javascript>alert('发送目标不能为空');history.back(-1);</script>";
					exit;
				}
				$mail->SetFrom($_SESSION['EmailAddress'], $_SESSION['LOGIN_USER_NAME']);
				$mail->Subject = $zhuti;
				$mail->MsgHTML(preg_replace('/\\\\/','', $content));
				
				$YM = date( "ym", time( ) );
				$PATH=DOCUMENT_ROOT."attach/ERP/attachment/";
				$PATH = $PATH.$YM;
												
				if ( !file_exists( $PATH ) )
				{
					mkdir( $PATH, 448 );
				}
				$FILENAMEArray=array();
				foreach ( $GLOBALS['_FILES'] as $KEY => $ATTACHMENT )
				{
						if ( $ATTACHMENT['error'] == 0)
						{
							$ATTACH_NAME = $ATTACHMENT['name'];
							$ATTACH_SIZE = $ATTACHMENT['size'];
							$ATTACH_FILE = $ATTACHMENT['tmp_name'];
							$FILENAME=$PATH."/".$ATTACH_NAME;
							@copy( $ATTACH_FILE, $FILENAME );
							$mail->AddAttachment($FILENAME);
							array_push($FILENAMEArray,$FILENAME);
						}
						
				}
	
			  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
			  $mail->Send();
			  
			  while (list($key,$value) = each($FILENAMEArray)) 
			  { 
			  	@unlink($value);
			  } 
			  
			} catch (phpmailerException $e) 
			{
			  $error=$e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
			  $error=$e->getMessage(); //Boring error messages from anything else!
			}
			if($error!='')
			{
				$error = str_replace("\n",'',$error);
				$error = str_replace("\r",'',$error);
				$error =preg_replace('/<[^>]+>/iU','',$error);
				
				print "<script language=javascript>alert('邮件发送失败，原因：".$error."');</script>";
			}
		}
function get_last_day($year, $month) {
    $t = mktime(0, 0, 0, $month + 1, 1, $year);
    $t = $t - 60 * 60 * 24;
    return $t;
}

function export_XLS($FristLineArray,$contentArray,$exportFileName,$sumArray)					{


	if(is_file("../../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php"))	{
		require_once "../../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php";
		require_once "../../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_worksheet.inc.php";
	}
	else if(is_file("../DANDIAN/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php"))	{
		require_once "../DANDIAN/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php";
		require_once "../DANDIAN/PHPExcelParser4/WriteExcel/class.writeexcel_worksheet.inc.php";
	}
	else {
		require_once "../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php";
		require_once "../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_worksheet.inc.php";
	}

	if(!is_dir("FileCache")) mkdir("FileCache");
	$fname = "FileCache/".$exportFileName.".xls";
	@unlink($fname);//确实文件不存在,如果存在,则提前删除

	$workbook = &new writeexcel_workbook($fname);
	$worksheet1 =& $workbook->addworksheet('Sheet1');
	# Frozen panes


	$header =& $workbook->addformat();
	$header->set_color('white');
	$header->set_align('center');
	$header->set_align('vcenter');
	$header->set_fg_color('green');
	$header->set_border(1);
	$center =& $workbook->addformat();
	$center->set_align('center');
	$center->set_align('vcenter');
	$center->set_border(1);
	$right =& $workbook->addformat();
	$right->set_align('right');
	$right->set_align('vcenter');
	$right->set_border(1);
	//列出字段的EXCEL列,通过此指定列宽度
	$LitterArray = explode(',','A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z');
	$LeftArray = array();
	$LitterSize = sizeof($LitterArray);
	for($i=0;$i<10;$i++)					{
		if($i==0)	$Little = '';
		else		$Little = $LitterArray[$i-1];

		for($ii=0;$ii<$LitterSize;$ii++)				{
			$PartLitte = $LitterArray[$ii];
			$Left = $Little.$PartLitte;
			array_push($LeftArray,$Left);
		}
	}

	//写标题
	$i=0;
	foreach($FristLineArray as $key=>$val)		{
		//行列内容
		$Element = $FristLineArray[$key];
		$worksheet1->set_column($LitterArray[0].":".$LitterArray[$i], 16);
		$worksheet1->write_string(0, $i, $Element, $header);
		$i++;
	}
	
	//写内容
	
	$allcount =	sizeof($contentArray);
	if($allcount>16382)  $allcount= 16382;
	$m=0;
	foreach ($contentArray as $k=>$v)		{
		$m++;
		$worksheet1->set_row($m, 16);
		$i=0;
		foreach($FristLineArray as $key=>$val)		{
			$Element = $v[$key];
			
			$Element=preg_replace("/<(\/?font.*?)>/si","",$Element); //过滤font标签
			if(is_numeric($Element))
			{
				$Element=round($Element,2);
				$worksheet1->write_number($m, $i, $Element, $right);
			}
			else
				$worksheet1->write_string($m, $i, $Element, $center);
			$i++;
			foreach ($sumArray as $sumkey=>$sumval)
			{
				if($sumkey==$key)
					$sumArray[$sumkey]+=$Element;
			}
		}
		
	}
	
	//print_r($contentArray);exit;	
	//写合计
	$sumer =& $workbook->addformat();
	$sumer->set_align('right');
	$sumer->set_align('vcenter');
	$sumer->set_bold(1);
	$sumer->set_border(1);

	$i=0;
	foreach($FristLineArray as $key=>$val)		{
		//行列内容
		if($i==0)
		{
			$worksheet1->set_column($LitterArray[0].":".$LitterArray[$i], 16);
			$worksheet1->write_string($allcount+1, $i, "合计 ".$allcount." 条记录", $sumer);
		}
		else
		{
			
			$flag=false;
			foreach ($sumArray as $sumkey=>$sumval)
			{
				if($sumkey==$key)
				{
					$sumval=round($sumval,2);
					$worksheet1->write_number($allcount+1, $i, $sumval, $sumer);
					$flag=true;
					break;
				}
			}
			if(!$flag)
				$worksheet1->write_string($allcount+1, $i, "", $sumer);
			
		}
		$i++;
	}
	$workbook->close();
	$fnameArray = explode('/',$fname);
	$PureFileName = array_pop($fnameArray);
	header("Content-Type: application/x-msexcel; name=\"$PureFileName\"");
	header("Content-Disposition: inline; filename=\"$PureFileName\"");
	$fh=fopen($fname, "rb");
	fpassthru($fh);
	fclose($fh);
	unlink($fname);

}
function DateDiff_day($date1,$date2)
{
	$date1=substr($date1,0,10);
	$date2=substr($date2,0,10);
    $Date_List_a1=explode("-",$date1);
    $Date_List_a2=explode("-",$date2);
    $d1=mktime(0,0,0,$Date_List_a1[1],$Date_List_a1[2],$Date_List_a1[0]);
    $d2=mktime(0,0,0,$Date_List_a2[1],$Date_List_a2[2],$Date_List_a2[0]);
    $Days=round(($d2-$d1)/3600/24);
    return $Days;
}

function DateDiff($part, $begin, $end)
{
$diff = strtotime($end) - strtotime($begin);
switch($part)
{
case "y": $retval = bcdiv($diff, (60 * 60 * 24 * 365)); break;
case "m": $retval = bcdiv($diff, (60 * 60 * 24 * 30)); break;
case "w": $retval = bcdiv($diff, (60 * 60 * 24 * 7)); break;
case "d": $retval = bcdiv($diff, (60 * 60 * 24)); break;
case "h": $retval = bcdiv($diff, (60 * 60)); break;
case "n": $retval = bcdiv($diff, 60); break;
case "s": $retval = $diff; break;
}
return $retval;
}
Function DateAdd($part, $n, $date)
{
switch($part)
{
case "y": $val = date("Y-m-d H:i:s", strtotime($date ." +$n year")); break;
case "m": $val = date("Y-m-d H:i:s", strtotime($date ." +$n month")); break;
case "w": $val = date("Y-m-d H:i:s", strtotime($date ." +$n week")); break;
case "d": $val = date("Y-m-d H:i:s", strtotime($date ." +$n day")); break;
case "h": $val = date("Y-m-d H:i:s", strtotime($date ." +$n hour")); break;
case "n": $val = date("Y-m-d H:i:s", strtotime($date ." +$n minute")); break;
case "s": $val = date("Y-m-d H:i:s", strtotime($date ." +$n second")); break;
}
return $val;
}
?>