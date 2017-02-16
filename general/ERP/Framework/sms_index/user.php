<?php
function getuserdepartment($departmentid)		{
	global $db;
	switch($db->databaseType)		{
		case 'mssql':
			$sql="select [USER_ID],[USER_NAME],[NICK_NAME] from [user] where DEPT_ID='$departmentid'";
			break;
		case 'mysql':
			$sql="select USER_ID,USER_NAME,NICK_NAME from user where DEPT_ID='$departmentid'";
			break;
		case 'oracle':
			break;
		default:
			$sql="select USER_ID,USER_NAME,NICK_NAME from user where DEPT_ID='$departmentid'";
			break;
	}
	$rs=$db->CacheExecute(15,$sql);
	return $rs;
}
function frame_user_element($userid,$nickname)	{
	print "<TR class=TableControl><TD class=menulines style=\"CURSOR: hand\"    onclick=\"javascript:add_user('$userid','$nickname')\" align=middle>$nickname</TD></TR>\n";
}
function frame_user_element_single($userid,$nickname)	{
	print "<TR class=TableControl><TD class=menulines style=\"CURSOR: hand\"    onclick=\"javascript:add_user_one('$userid','$nickname')\" align=middle>$nickname</TD></TR>\n";
}
function frame_user_data($departmentid)	{
	global $lang,$common_html;
	global $_GET;
	print "<TABLE class=small onmouseover=borderize_on(event) onclick=borderize_on1(event) \n";
	print "onmouseout=borderize_off(event) cellSpacing=0 borderColorDark=#ffffff \n";
	print "cellPadding=3 width=\"100%\" borderColorLight=#000000 border=1>\n";
	print "<THEAD class=TableControl><TR>\n";
	print "<TH bgColor=#d6e7ef colSpan=2>\n<B>".$common_html['common_html']['chooseuser']."</B></TH>\n</TR></THEAD>\n";
	if($_GET['MODE']=='single')		{
	}
	else	{
		print "<TBODY><TR class=TableContent>\n<TD class=menulines style=\"CURSOR: hand\" onclick=javascript:add_all(); align=middle>".$common_html['common_html']['adduserall']."</TD></TR>\n";
	}
	$rs=getuserdepartment($departmentid);
	while(!$rs->EOF)	{
		$userid=$rs->fields['USER_NAME'];
		$nickname=$rs->fields['NICK_NAME'];
		if($_GET['MODE']=='single')		{
			frame_user_element_single($userid,$nickname);
		}
		else	{
			frame_user_element($userid,$nickname);
		}
		$rs->Movenext();
	}
	print "</table>";
}
function frame_user_data_one($departmentid)	{
	global $common_html,$lang;
	print "<TABLE class=small onmouseover=borderize_on(event) onclick=borderize_on1(event) \n";
	print "onmouseout=borderize_off(event) cellSpacing=0 borderColorDark=#ffffff \n";
	print "cellPadding=3 width=\"100%\" borderColorLight=#000000 border=1>\n";
	print "<THEAD class=TableControl><TR>\n";
	print "<TH bgColor=#d6e7ef colSpan=2>\n<B>".$common_html['common_html']['chooseuser']."</B></TH>\n</TR></THEAD>\n";
	$rs=getuserdepartment($departmentid);
	while(!$rs->EOF)	{
		$userid=$rs->fields[USER_ID];
		$nickname=$rs->fields[USER_NAME];
		print "<TR class=TableControl><TD class=menulines style=\"CURSOR: hand\"    onclick=\"javascript:add_user_one('$userid','$nickname')\" align=middle>$nickname</TD></TR>\n";
		$rs->Movenext();
	}
	print "</table>";
}
function frame_user_header()	{
	print "<META content=\"MSHTML 6.00.2800.1106\" name=GENERATOR></HEAD><BODY class=bodycolor onmouseover=borderize_on(event) \n";
	print "onclick=borderize_on1(event) onmouseout=borderize_off(event) topMargin=5>\n";
}

function frame_user_js($departmentid,$TO_ID='TO_ID',$TO_NAME='TO_NAME')	{
?>
<STYLE>.menulines {
	
}
</STYLE>

<SCRIPT>
<!--

var menu_enter="";

function borderize_on(e)
{
 color="#708DDF";
 source3=event.srcElement

 if(source3.className=="menulines" && source3!=menu_enter)
    source3.style.backgroundColor=color;
}

function borderize_on1(e)
{
 for (i=0; i<document.all.length; i++)
 { document.all(i).style.borderColor="";
   document.all(i).style.backgroundColor="";
   document.all(i).style.color="";
   document.all(i).style.fontWeight="";
 }

 color="#003FBF";
 source3=event.srcElement

 if(source3.className=="menulines")
 { source3.style.borderColor="black";
   source3.style.backgroundColor=color;
   source3.style.color="white";
   source3.style.fontWeight="bold";
 }

 menu_enter=source3;
}

function borderize_off(e)
{
 source4=event.srcElement

 if(source4.className=="menulines" && source4!=menu_enter)
    {source4.style.backgroundColor="";
     source4.style.borderColor="";
    }
}

//-->
</SCRIPT>

<SCRIPT language=JavaScript>
var parent_window = parent.dialogArguments;

function add_user(user_id,user_name)
{
  TO_VAL=parent_window.form1.<?php echo $TO_ID?>.value;
  if(TO_VAL.indexOf(","+user_id+",")<0 && TO_VAL.indexOf(user_id+",")!=0)
  {
    parent_window.form1.<?php echo $TO_ID?>.value += user_id+",";
    parent_window.form1.<?php echo $TO_NAME?>.value += user_name+",";
  }
}

function add_user_one(user_id,user_name)
{
  TO_VAL=parent_window.form1.<?php echo $TO_ID?>.value;
  if(TO_VAL.indexOf(","+user_id+",")<0 && TO_VAL.indexOf(user_id+",")!=0)
  {
    parent_window.form1.<?php echo $TO_ID?>.value = user_id;
    parent_window.form1.<?php echo $TO_NAME?>.value = user_name;
  }
}

</SCRIPT>
<?php
	add_all($departmentid);
}

function add_all($departmentid)	{
	print "<SCRIPT language=JavaScript>\n";
	print "function add_all()	{\n";
	$rs=getuserdepartment($departmentid);
	while(!$rs->EOF)	{
		$USER_NAME=$rs->fields[USER_NAME];
		$NICK_NAME=$rs->fields[NICK_NAME];
		print "add_user('$USER_NAME','$NICK_NAME');\n";
		$rs->Movenext();
	}
	print "}	</SCRIPT>\n";
	}

?>