<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
require_once("utility_all.php");
$GLOBAL_SESSION=returnsession();
page_css('CRM�ճ�');
date_default_timezone_set('PRC');
$CUR_YEAR = date( "Y" );
$CUR_MON = date( "m" );
$CUR_DAY = date( "d" );
if ( $BTN_OP != "" )
{
	if($BTN_OP!='0')
	{
    	$DATE = strtotime( $BTN_OP, strtotime( $YEAR."-".$MONTH."-".$DAY ) );
    	$YEAR = date( "Y", $DATE );
    	$MONTH = date( "m", $DATE );
    	$DAY = date( "d", $DATE );
	}
}
else  
{
	if($_SESSION['SEL_YEAR']!='')
		$YEAR=$_SESSION['SEL_YEAR'];
	if($_SESSION['SEL_MONTH']!='')
		$MONTH=$_SESSION['SEL_MONTH'];
	if($_SESSION['SEL_DAY']!='')
		$DAY=$_SESSION['SEL_DAY'];
}
if ( !$YEAR )
{
    $YEAR = $CUR_YEAR;
}
if ( !$MONTH )
{
    $MONTH = $CUR_MON;
}
if ( !$DAY )
{
    $DAY = $CUR_DAY;
}
if($user_id=='')
	$user_id=$_SESSION['LOGIN_USER_ID'];
$_SESSION['SEL_YEAR']=$YEAR;
$_SESSION['SEL_MONTH']=$MONTH;
$_SESSION['SEL_DAY']=$DAY;
if ( !checkdate( $MONTH, $DAY, $YEAR ) )
{
    message( "����", "���ڲ���ȷ" );
    exit( );
}
$DATE = strtotime( $YEAR."-".$MONTH."-".$DAY );
echo "<html>\r\n<head>\r\n<title>�ճ̰���</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<script>\r\nfunction my_affair(AFF_ID)\r\n{\r\n  myleft=(screen.availWidth-250)/2;\r\n  mytop=(screen.availHeight-200)/2;\r\n  window.open(\"../affair/note.php?AFF_ID=\"+AFF_ID,\"note_win\"+AFF_ID,\"height=200,width=250,status=0,toolbar=no,menubar=no,location=no,scrollbars=auto,resizable=no,top=\"+mytop+\",left=\"+myleft);\r\n}\r\n\r\nfunction my_note(CAL_ID)\r\n{\r\n  myleft=(screen.availWidth-250)/2;\r\n  mytop=(screen.availHeight-200)/2;\r\n  window.showModelessDialog(\"note.php?CAL_ID=\"+CAL_ID,null,\"dialogHeight=200px;dialogWidth=250px;dialogLeft=\"+myleft+\";dialogTop=\"+mytop+\";status=no\");\r\n}\r\n\r\nfunction My_Submit()\r\n{\r\n  document.form1.submit();\r\n}\r\n\r\nfunction set_year(op)\r\n{\r\n  document.form1.BTN_OP.value=op+\" year\";\r\n  My_Submit();\r\n}\r\n\r\nfunction set_mon(op)\r\n{\r\n  document.form1.BTN_OP.value=op+\" month\";\r\n  My_Submit();\r\n}\r\n\r\nfunction set_day(op)\r\n{\r\n  document.form1.BTN_OP.value=op+\" day\";\r\n  My_Submit();\r\n}\r\n\r\nfunction display_front()\r\n{\r\n   var front=document.getElementById(\"front\");\r\n   if(!front)\r\n      return;\r\n   if(front.style.display=='')\r\n      front.style.display='none';\r\n   else\r\n      front.style.display='';\r\n}\r\n\r\nfunction init()\r\n{\r\n   var elementI=document.getElementsByTagName(\"DIV\");\r\n\r\n   for(i=0;i<elementI.length;i++)\r\n   {\r\n      if(elementI[i].id.substr(0,4)!=\"cal_\")\r\n         continue;\r\n\r\n      elementI[i].onmouseover=function() {var op_i=document.getElementById(this.id+\"_op\");if(op_i) op_i.style.display=\"\";}\r\n      elementI[i].onmouseout =function() {var op_i=document.getElementById(this.id+\"_op\");if(op_i) op_i.style.display=\"none\";}\r\n   }\r\n}\r\nfunction set_view()\r\n{\r\n    var view=document.form1.VIEW.value;\r\n    if(!view) return;\r\n    var exp = new Date();\r\n    exp.setTime(exp.getTime() + 24*60*60*1000);\r\n    document.cookie = \"cal_view=\"+ escape (view) + \";expires=\" + exp.toGMTString()+\";path=/\";\r\n    \r\n    location=view+'.php?YEAR=";
echo $YEAR;
echo "&MONTH=";
echo $MONTH;
echo "&DAY=";
echo $DAY;
echo "';\r\n}\r\nfunction new_cal(CAL_TIME)\r\n{\r\n   location='../calendar_newai.php?action=add_default&CAL_DATE=";
echo $YEAR;
echo "-";
echo $MONTH;
echo "-";
echo $DAY;
echo "&CAL_TIME='+CAL_TIME;\r\n}\r\nfunction new_diary()\r\n{\r\n   window.open('../../diary/new/?CUR_DATE=";
echo $YEAR;
echo "-";
echo $MONTH;
echo "-";
echo $DAY;
echo "','diary_sub_window','height=560,width=650,status=0,toolbar=no,menubar=no,location=no,left=180,top=50,scrollbars=yes,resizable=yes');\r\n}\r\nfunction del_cal(CAL_ID)\r\n{\r\n   if(window.confirm(\"ɾ���󽫲��ɻָ���ȷ��ɾ����\"))\r\n      location=\"../calendar_newai.php?action=delete_array&selectid=\"+CAL_ID+\"&OVER_STATUS=1&YEAR=";
echo $YEAR;
echo "&MONTH=";
echo $MONTH;
echo "&DAY=";
echo $DAY;
echo "\";\r\n}\r\n</script>\r\n</head>\r\n<body class=\"bodycolor\" topmargin=\"5\" onload=\"init();\">\r\n\r\n  <table width=\"100%\" border=\"0\" cellspacing=\"0\" class=\"big1\" cellpadding=\"3\" align=\"center\">\r\n   <form name=\"form1\" action=\"";
echo $_SERVER['SCRIPT_NAME'];
echo "\">\r\n    <tr>\r\n      <td>\r\n       <input type=\"button\" value=\"����\" class=\"SmallButton\" title=\"����\" onclick=\"location='";
echo $_SERVER['SCRIPT_NAME'];
echo "?BTN_OP=a&YEAR=";
echo $CUR_YEAR;
echo "&MONTH=";
echo $CUR_MON;
echo "&DAY=";
echo $CUR_DAY;
echo "'\">\r\n       <input type=\"hidden\" value=\"\" name=\"BTN_OP\">\r\n<!-------------- �� ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_year(-1);\"><select name=\"YEAR\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"document.form1.BTN_OP.value='0';My_Submit();\">\r\n";
$I = $CUR_YEAR-3;
for ( ; $I <= $CUR_YEAR+1; ++$I )
{
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $YEAR )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "��</option>\r\n";
}
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_year(1);\">\r\n\r\n<!-------------- �� ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_mon(-1);\"><select name=\"MONTH\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"document.form1.BTN_OP.value='0';My_Submit();\">\r\n";
$I = 1;
for ( ; $I <= 12; ++$I )
{
    if ( $I < 10 )
    {
        $I = "0".$I;
    }
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $MONTH )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "��</option>\r\n";
}
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_mon(1);\">\r\n<!-------------- �� ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_day(-1);\"><select name=\"DAY\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"document.form1.BTN_OP.value='0';My_Submit();\">\r\n";
$I = 1;
for ( ; $I <= date( "t", strtotime( $YEAR."-".$MONTH."-".$DAY ) ); ++$I )
{
    if ( $I < 10 )
    {
        $I = "0".$I;
    }
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $DAY )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "��</option>\r\n";
}
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_day(1);\">\r\n      ";
$sql="select * from user where 1=1";
$sql=getRoleByUser($sql,"USER_ID");
$sql.=" order by USER_NAME";
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();
echo "<select name='user_id' class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"document.form1.BTN_OP.value='0';My_Submit();\">";
foreach ($rs_a as $row)
{
	$check="";
	if($user_id==$row['USER_ID'])
		$check="selected";
	echo "<option value='".$row['USER_ID']."' $check>".$row['USER_NAME']."</option>";
}
echo "</select></td>\r\n      <td align=\"right\">\r\n        <input type=\"button\"  value=\"�½��ճ�\" class=\"SmallButton\" onClick=\"new_cal('".date("H")."')\" title=\"�����µ��ճ̣��Ա������Լ�\">\r\n        <select name=\"VIEW\" class=\"SmallSelect\" onchange=\"set_view();\">\r\n          <option value=\"day\" selected>&nbsp;���б�</option>\r\n          <option value=\"week\">&nbsp;���б�</option>\r\n          <option value=\"month\">&nbsp;���б�</option>\r\n        </select>\r\n      </td>\r\n    </tr>\r\n   </form>\r\n  </table>\r\n\r\n";
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$CAL_COUNT = 0;
$query = "SELECT * from calendar where USER_ID='".$user_id."' and ((CAL_TIME>='".date( "Y-m-d", $DATE )." 00:00:00' and CAL_TIME<='".date( "Y-m-d", $DATE )." 23:59:59') or (END_TIME>='".date( "Y-m-d", $DATE )." 00:00:00' and END_TIME<='".date( "Y-m-d", $DATE )." 23:59:59') or (CAL_TIME<'".date( "Y-m-d", $DATE )." 00:00:00' and END_TIME>'".date( "Y-m-d", $DATE )." 23:59:59')) order by CAL_TIME";
$rs=$db->Execute($query);
$rs_a=$rs->GetArray();

for ($j=0;$j<sizeof($rs_a);$j++)
{
    $CAL_ID = $rs_a[$j]['id'];
    $CAL_TIME = $rs_a[$j]['CAL_TIME'];
    $END_TIME = $rs_a[$j]['END_TIME'];
    $CAL_TYPE = $rs_a[$j]['CAL_TYPE'];
    $CONTENT = $rs_a[$j]['CONTENT'];
    $CONTENT = cutStr($rs_a[$j]['CONTENT'],50);
    if($rs_a[$j]['CONTENT']!=$CONTENT)
    	$CONTENT.="..";
    
    $MANAGER_ID = $rs_a[$j]['MANAGER_ID'];
    $OVER_STATUS = $rs_a[$j]['OVER_STATUS'];
    $CAL_TYPE_DESC = $CAL_TYPE."��";
    if ( $OVER_STATUS == "0" )
    {
        if ( 0 < compare_time( $CUR_TIME, $END_TIME ) )
        {
            $STATUS_COLOR = "#FF0000";
            $CAL_TITLE = "״̬���ѹ���";
        }
        else if ( compare_time( $CUR_TIME, $CAL_TIME ) < 0 )
        {
            $STATUS_COLOR = "#0000FF";
            $CAL_TITLE = "״̬��δ��";
        }
        else
        {
            $STATUS_COLOR = "#0000FF";
            $CAL_TITLE = "״̬��������";
        }
    }
    else
    {
        $STATUS_COLOR = "#00AA00";
        $CAL_TITLE = "״̬�������";
    }
    $MANANAMER_NAME = "";
    if ( $MANAGER_ID != "" )
    {
        $query = "SELECT USER_NAME from user where USER_ID='".$MANAGER_ID."'";
        $rs=$db->Execute($query);
		$rs_b=$rs->GetArray();
        if ( sizeof($rs_b)>0)
        {
            $MANANAMER_NAME = "(������:".$rs_b[0]['USER_NAME'].")";
        }
    }
    $CONTENT = htmlspecialchars( $CONTENT );
    $showBeginDate=substr( $CAL_TIME, 11, 5 );
    $showEndDate=substr( $END_TIME, 11, 5 );
    $days=DateDiff_day($CAL_TIME, $END_TIME);
	if($days>0)
    {
    	$showBeginDate=date("d��H:i",strtotime($CAL_TIME));
    	$showEndDate=date("d��H:i",strtotime($END_TIME));	
    }
    $CONTENT = "<div id=\"cal_".$CAL_ID."\" title='".$CAL_TITLE."'>".$showBeginDate."-".$showEndDate." ".$CAL_TYPE_DESC.( "<a href='javascript:my_note(".$CAL_ID.");' style='color:" ).$STATUS_COLOR.";'>".$CONTENT."</a> ".$MANANAMER_NAME;
    $CONTENT .= "<span id=\"cal_".$CAL_ID."_op\" style=\"display:none;\">";
    if($user_id==$_SESSION['LOGIN_USER_ID'])
    {
	    if ( $OVER_STATUS == "0" )
	    {
	        $CONTENT .= "<a href=\"../calendar_newai.php?action=finish&id=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}\"> &nbsp;���</a>";
	    }
	    else if ( $OVER_STATUS == "" || $OVER_STATUS == "1" )
	    {
	        $CONTENT .= "<a href=\"../calendar_newai.php?action=finish&id=".$CAL_ID."&OVER_STATUS=0&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}\"> δ���</a>";
	    }
	    if ( $MANAGER_ID == "" || $MANAGER_ID == $LOGIN_USER_ID )
	    {
	        $CONTENT .= "<a href=\"../calendar_newai.php?action=edit_default&id=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}\"> �޸�</a>";
	        $CONTENT .= "<a href=\"javascript:del_cal(".$CAL_ID.");\"> ɾ��</a>";
	    }
    }
    $CONTENT .= "</span></div>";
    
    if(date("Y-m-d",$DATE)==date("Y-m-d",strtotime($CAL_TIME)))
    	$CAL_ARRAY[date( "G", strtotime( $CAL_TIME ) )] .= $CONTENT;
	
    for($k=0;$k<$days;$k++)
    {
    	$nextDay=DateAdd("d",($k+1),$CAL_TIME);
    	if(date("Y-m-d",$DATE)==date("Y-m-d",strtotime($nextDay)))
    		$CAL_ARRAY[24] .= $CONTENT;
    	
    }
}

echo "\r\n  <table class=\"TableList\" width=\"100%\" align=\"center\">\r\n    <tr align=\"center\" class=\"TableHeader\">\r\n      <td class=\"TableControl\" width=\"9%\"><a href=\"javascript:display_front();\">0-6��</a></td>\r\n      <td>����</td>\r\n    </tr>\r\n    <tbody id=\"front\" style=\"display:none;\">\r\n";
$I = 0;
for ( ; $I < 7; ++$I )
{
    echo "    <tr class=\"TableData\" height=\"30\">\r\n      <td align=\"center\" class=\"TableControl\" width=\"9%\"><a href=\"javascript:new_cal('";
    echo $I;
    echo "')\">";

    echo $I;
    echo ":00</a></td>\r\n      <td>";
    echo $CAL_ARRAY[$I];
    echo "</td>\r\n    </tr>\r\n";
}
echo "    </tbody>\r\n";
$I = 7;
for ( ; $I < 25; ++$I )
{
    echo "    <tr class=\"TableData\" height=\"30\">\r\n      <td align=\"center\" class=\"TableControl\" width=\"9%\">";

    echo $I==24?"����":"<a href=\"javascript:new_cal('$I')\">".$I.":00</a>";
    echo "</td>\r\n      <td>";
    echo $CAL_ARRAY[$I];
    echo "</td>\r\n    </tr>\r\n";
}
echo "  </table>\r\n\r\n</body>\r\n</html>\r\n";
?>
