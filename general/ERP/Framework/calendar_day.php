<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

session_start();
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
page_css("�����ճ̰���");

$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];

$CAL_ID = $_GET['CAL_ID'];
$GOBACK = $_GET['GOBACK'];
$YEAR	= $_GET['YEAR'];
$MONTH	= $_GET['MONTH'];
$DAY	= $_GET['DAY'];

$CUR_YEAR = date( "Y" );
$CUR_MON = date( "m" );
$CUR_DAY = date( "d" );
if ( $BTN_OP != "" )
{
    $DATE = strtotime( $BTN_OP, strtotime( $YEAR."-".$MONTH."-".$DAY ) );
    $YEAR = date( "Y", $DATE );
    $MONTH = date( "m", $DATE );
    $DAY = date( "d", $DATE );
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
if ( !checkdate( $MONTH, $DAY, $YEAR ) )
{
    message( "����", "���ڲ���ȷ" );
    exit( );
}
$DATE = strtotime( $YEAR."-".$MONTH."-".$DAY );
$MONTH_BEGIN = strtotime( $YEAR."-".$MONTH."-01" );
$MONTH_END = strtotime( $YEAR."-".$MONTH."-".date( "t", $DATE ) );
?>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<script>
function my_affair(AFF_ID)
{
  myleft=(screen.availWidth-250)/2;
  mytop=(screen.availHeight-200)/2;
  window.open("../affair/calendar_note.php?AFF_ID="+AFF_ID,"note_win"+AFF_ID,"height=200,width=250,status=0,toolbar=no,menubar=no,location=no,scrollbars=auto,resizable=no,top="+mytop+",left="+myleft);
}

function my_note(CAL_ID)
{
  myleft=(screen.availWidth-250)/2;
  mytop=(screen.availHeight-200)/2;
  window.open("calendar_note.php?CAL_ID="+CAL_ID,"note_win"+CAL_ID,"height=200,width=250,status=0,toolbar=no,menubar=no,location=no,scrollbars=auto,resizable=no,top="+mytop+",left="+myleft);
}

function My_Submit()
{
  document.form1.submit();
}

function set_year(op)
{
  document.form1.BTN_OP.value=op+" year";
  My_Submit();
}

function set_mon(op)
{
  document.form1.BTN_OP.value=op+" month";
  My_Submit();
}

function set_day(op)
{
  document.form1.BTN_OP.value=op+" day";
  My_Submit();
}

function display_front()
{
   var front=document.getElementById("front");
   if(!front)
      return;
   if(front.style.display=='')
      front.style.display='none';
   else
      front.style.display='';
}

function init()
{
   var elementI=document.getElementsByTagName("DIV");

   for(i=0;i<elementI.length;i++)
   {
      if(elementI[i].id.substr(0,4)!="cal_")
         continue;

      elementI[i].onmouseover=function() {var op_i=document.getElementById(this.id+"_op");if(op_i) op_i.style.display="";}
      elementI[i].onmouseout =function() {var op_i=document.getElementById(this.id+"_op");if(op_i) op_i.style.display="none";}
   }
}
function set_view()
{
    var view=document.form1.VIEW.value;
    if(!view) return;
    var exp = new Date();
    exp.setTime(exp.getTime() + 24*60*60*1000);
    document.cookie = "cal_view="+ escape (view) + ";expires=" + exp.toGMTString()+";path=/";


<?php
echo "location= 'calendar_'+view+'.php?YEAR=";
echo $YEAR;
echo "&MONTH=";
echo $MONTH;
echo "&DAY=";
echo $DAY;
echo "';\r\n}\r\nfunction new_cal(CAL_TIME)\r\n{\r\n   window.open('new?CAL_DATE=";
echo $YEAR;
echo "-";
echo $MONTH;
echo "-";
echo $DAY;
echo "&CAL_TIME='+CAL_TIME,'oa_sub_window','height=350,width=500,status=0,toolbar=no,menubar=no,location=no,left=300,top=200,scrollbars=yes,resizable=yes');\r\n}\r\nfunction new_diary()\r\n{\r\n   window.open('../../diary/new/?CUR_DATE=";
echo $YEAR;
echo "-";
echo $MONTH;
echo "-";
echo $DAY;
echo "','diary_sub_window','height=560,width=650,status=0,toolbar=no,menubar=no,location=no,left=180,top=50,scrollbars=yes,resizable=yes');\r\n}\r\nfunction del_cal(CAL_ID)\r\n{\r\n   if(window.confirm(\"ɾ���󽫲��ɻָ���ȷ��ɾ����\"))\r\n      location=\"calendar_delete.php?CAL_ID=\"+CAL_ID+\"&GOBACK=calendar_day&OVER_STATUS=1&YEAR=";
echo $YEAR;
echo "&MONTH=";
echo $MONTH;
echo "&DAY=";
echo $DAY;
echo "\";\r\n}\r\n";
?>
	</script>
<?php

echo "</head>\r\n<body class=\"bodycolor\" topmargin=\"5\" onload=\"init();\">  <table width=\"100%\" border=\"0\" cellspacing=\"0\" class=\"big1\" cellpadding=\"3\" align=\"center\">\r\n   <form name=\"form1\" action=\"";
echo $_SERVER['SCRIPT_NAME'];
echo "\">\r\n    <tr>\r\n      <td>\r\n       <input type=\"button\" value=\"����\" class=\"SmallButton\" title=\"����\" onclick=\"location='";
echo $_SERVER['SCRIPT_NAME'];
echo "?YEAR=";
echo $CUR_YEAR;
echo "&MONTH=";
echo $CUR_MON;
echo "&DAY=";
echo $CUR_DAY;
echo "'\">\r\n       <input type=\"hidden\" value=\"\" name=\"BTN_OP\">\r\n<!-------------- �� ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_year(-1);\"><select name=\"YEAR\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"My_Submit();\">\r\n";
$I = 2000;
for ( ; $I <= 2015; ++$I )
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
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_year(1);\"><!-------------- �� ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_mon(-1);\"><select name=\"MONTH\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"My_Submit();\">\r\n";
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
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_mon(1);\">\r\n<!-------------- �� ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_day(-1);\"><select name=\"DAY\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"My_Submit();\">\r\n";
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
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"��һ��\" onclick=\"set_day(1);\">\r\n      </td>\r\n      <td align=\"right\">\r\n        <select name=\"VIEW\" class=\"SmallSelect\" onchange=\"set_view();\">\r\n          <option value=\"day\" selected>&nbsp;���б�</option>\r\n          <option value=\"week\">&nbsp;���б�</option>\r\n          <option value=\"month\">&nbsp;���б�</option>\r\n        </select>\r\n      </td>\r\n    </tr>\r\n   </form>\r\n  </table>";
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$query = "SELECT * from calendar where USER_ID='".$LOGIN_USER_ID."' and TO_DAYS(CAL_TIME)=TO_DAYS('{$YEAR}-{$MONTH}-{$DAY}') order by CAL_TIME";
$rs		= $db->Execute($query);
$CAL_COUNT = 0;
while (!$rs->EOF)
{
    $CAL_ID = $rs->fields['CAL_ID'];
    $CAL_TIME = $rs->fields['CAL_TIME'];
    $END_TIME = $rs->fields['END_TIME'];
    $CAL_TYPE = $rs->fields['CAL_TYPE'];
    $CONTENT = $rs->fields['CONTENT'];
    $MANAGER_ID = $rs->fields['MANAGER_ID'];
    $OVER_STATUS = $rs->fields['OVER_STATUS'];
    $CAL_TYPE_DESC = get_code_name( $CAL_TYPE, "CAL_TYPE" )."��";
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
        $cursor1 = exequery( $connection, $query );
        if ( $ROW1 = mysql_fetch_array( $cursor1 ) )
        {
            $MANANAMER_NAME = "(������:".$ROW1['USER_NAME'].")";
        }
    }
    $CONTENT = htmlspecialchars( $CONTENT );
    $CONTENT = "<div id=\"cal_".$CAL_ID."\" title='".$CAL_TITLE."'>".substr( $CAL_TIME, 11, 5 )."-".substr( $END_TIME, 11, 5 )." ".$CAL_TYPE_DESC.( "<a href='javascript:my_note(".$CAL_ID.");' style='color:" ).$STATUS_COLOR.";'>".$CONTENT."</a> ".$MANANAMER_NAME;
    $CONTENT .= "<span id=\"cal_".$CAL_ID."_op\" style=\"display:none;\">";
    if ( $OVER_STATUS == "0" )
    {
        $CONTENT .= " <a href=\"calendar_status.php?CAL_ID=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}&GOBACK=calendar_day\">���</a>";
    }
    else if ( $OVER_STATUS == "" || $OVER_STATUS == "1" )
    {
        $CONTENT .= " <a href=\"calendar_status.php?CAL_ID=".$CAL_ID."&OVER_STATUS=0&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}&GOBACK=calendar_day\">δ���</a>";
    }
    if ( $MANAGER_ID == "" || $MANAGER_ID == $LOGIN_USER_ID )
    {
        //$CONTENT .= "<a href=\"modify.php?CAL_ID=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}\"> �޸�</a>";
        $CONTENT .= " <a href=\"javascript:del_cal(".$CAL_ID.");\">ɾ��</a>";
    }
    $CONTENT .= "</span></div>";
    $CAL_ARRAY[date( "G", strtotime( $CAL_TIME ) )] .= $CONTENT;
	$rs->MoveNext();
}
$query = "SELECT * from affair where USER_ID='".$LOGIN_USER_ID."' and BEGIN_TIME<='".date( "Y-m-d", $DATE )." 23:59:59' and (TYPE='2' or TYPE='3' and REMIND_DATE='".date( "w", $DATE )."' or TYPE='4' and REMIND_DATE='".date( "j", $DATE )."' or TYPE='5' and REMIND_DATE='".date( "n-j", $DATE )."') order by BEGIN_TIME desc";
$rs		= $db->Execute($query);
while (!$rs->EOF)
{
    $AFF_ID = $rs->fields['AFF_ID'];
    $BEGIN_TIME = $rs->fields['BEGIN_TIME'];
    $REMIND_DATE = $rs->fields['REMIND_DATE'];
    $REMIND_TIME = $rs->fields['REMIND_TIME'];
    $CONTENT = $rs->fields['CONTENT'];
    $TYPE = $rs->fields['TYPE'];
    $LAST_REMIND = $rs->fields['LAST_REMIND'];
    $CONTENT = htmlspecialchars( $CONTENT );
    if ( $LAST_REMIND == "0000-00-00" )
    {
        $LAST_REMIND = "";
    }
    switch ( $TYPE )
    {
    case "2" :
        $TYPE_DESC = "ÿ��";
        break;
    case "3" :
        $TYPE_DESC = "ÿ��";
        if ( $REMIND_DATE == "1" )
        {
            $REMIND_DATE = "һ";
        }
        else if ( $REMIND_DATE == "2" )
        {
            $REMIND_DATE = "��";
        }
        else if ( $REMIND_DATE == "3" )
        {
            $REMIND_DATE = "��";
        }
        else if ( $REMIND_DATE == "4" )
        {
            $REMIND_DATE = "��";
        }
        else if ( $REMIND_DATE == "5" )
        {
            $REMIND_DATE = "��";
        }
        else
        {
            if ( $REMIND_DATE == "6" )
            {
                $REMIND_DATE = "��";
            }
            else
            {
                if ( !( $REMIND_DATE == "0" ) )
                {
                    break;
                }
                $REMIND_DATE = "��";
            }
        }
        break;
    case "4" :
        $TYPE_DESC = "ÿ��";
        $REMIND_DATE .= "��";
        break;
    case "5" :
        $TYPE_DESC = "ÿ��";
        $REMIND_DATE = str_replace( "-", "��", $REMIND_DATE )."��";
    }
    $AFF_TITLE = "����ʱ�䣺".$TYPE_DESC.$REMIND_DATE." ".substr( $REMIND_TIME, 0, -3 )."\n�ϴ����ѣ�".$LAST_REMIND."\n��ʼʱ�䣺".$BEGIN_TIME;
    $CONTENT = substr( $REMIND_TIME, 0, -3 ).( " <a href='javascript:my_affair(".$AFF_ID.");' title='" ).$AFF_TITLE."'>".$CONTENT."</a><br>";
    $REMIND_HOUR = intval( substr( $REMIND_TIME, 0, strpos( $REMIND_TIME, ":" ) ) );
    if ( $BEGIN_TIME <= date( "Y-m-d", $DATE )." ".$REMIND_TIME )
    {
        $CAL_ARRAY[$REMIND_HOUR] .= $CONTENT;
    }
	$rs->MoveNext();
}
echo "\r\n  <table class=\"TableList\" width=\"100%\" align=\"center\">\r\n    <tr align=\"center\" class=\"TableHeader\">\r\n      <td class=\"TableControl\" width=\"9%\"><a href=\"javascript:display_front();\"><font color=green>0-6��</font></a></td>\r\n      <td class=\"TableControl\">����</td>\r\n    </tr>\r\n    <tbody id=\"front\" style=\"display:none;\">\r\n";
$I = 0;
for ( ; $I < 7; ++$I )
{
    echo "    <tr class=\"TableData\" height=\"30\">\r\n      <td align=\"center\" class=\"TableControl\" width=\"9%\"><font color=green>";
    if ( $I < 10 )
    {
        echo "0";
    }
    echo $I;
    echo ":00</font></td>\r\n      <td>";
    echo $CAL_ARRAY[$I];
    echo "</td>\r\n    </tr>\r\n";
}
echo "    </tbody>\r\n";
$I = 7;
for ( ; $I < 24; ++$I )
{
    echo "    <tr class=\"TableData\" height=\"30\">\r\n      <td align=\"center\" class=\"TableControl\" width=\"9%\"><font color=green>";
    if ( $I < 10 )
    {
        echo "0";
    }
    echo $I;
    echo ":00</font></td>\r\n      <td>";
    echo $CAL_ARRAY[$I];
    echo "</td>\r\n    </tr>\r\n";
}
echo "  </table></body>\r\n</html>\r\n";
?>
