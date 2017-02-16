<?php
session_start();
header("Content-type:text/html;charset=gb2312");
global $framework_html;
$choose_lang	=	@$_GET['choose_lang'];
if($choose_lang=='')		{
	$choose_lang='zh';
}

$framework_html['zh']['shutdown']="关闭";
$framework_html['zh']['calendar']="日历";
$framework_html['zh']['ThisMonth']="本月";
$framework_html['zh']['Year']="年";
$framework_html['zh']['NextYear']="下一年";
$framework_html['zh']['LastYear']="上一年";
$framework_html['zh']['Month']="月";
$framework_html['zh']['NextMonth']="下一月";
$framework_html['zh']['LastMonth']="上一月";

$framework_html['en']['shutdown']="Close";
$framework_html['en']['calendar']="Calendar";
$framework_html['en']['ThisMonth']="Month";
$framework_html['en']['Year']="Year";
$framework_html['en']['NextYear']="Next Year";
$framework_html['en']['LastYear']="Last Year";
$framework_html['en']['Month']="Month";
$framework_html['en']['NextMonth']="Next Month";
$framework_html['en']['LastMonth']="Last Month";

$datetime	=	@$_GET['datetime'];
if($datetime=='')	{
	$datetime='BEGIN_DATE';
}


print "<LINK href=\"../../../../theme/".$_SESSION['LOGIN_THEME']."/style.css\" rel=stylesheet>";

?>

<html>
<head>
<title><?php echo $framework_html[$choose_lang]['calendar']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">


<script language="JavaScript">
function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function doCal()
{
  n=new Date();
  var n = new Date();
  var cy = n.getFullYear();
  var cm = n.getMonth();
  var cd = n.getDate();
  n.setFullYear(cy);
  n.setMonth(cm);

  writeMonth(n);
}

function set_year(op)
{
  if(op==-1 && document.form1.YEAR.selectedIndex==0)
     return;
  if(op==1 && document.form1.YEAR.selectedIndex==(document.form1.YEAR.options.length-1))
     return;

  document.form1.YEAR.selectedIndex=document.form1.YEAR.selectedIndex+op;

  yr=document.form1.YEAR.value;
  cm=document.form1.MONTH.value;
  doOther(yr,cm);
}

function set_mon(op)
{
  if(op==-1 && document.form1.MONTH.selectedIndex==0)
     return;
  if(op==1 && document.form1.MONTH.selectedIndex==(document.form1.MONTH.options.length-1))
     return;

  document.form1.MONTH.selectedIndex=document.form1.MONTH.selectedIndex+op;

  yr=document.form1.YEAR.value;
  cm=document.form1.MONTH.value;
  doOther(yr,cm);
}

function doOther(yr,cm)
{
  n=new Date();
  n.setFullYear(yr);
  n.setMonth(cm-1);
  writeMonth(n);
}

function writeMonth(n)
{
	var Today = new Date();
	var tY = Today.getFullYear();
	var tM = Today.getMonth();
	var tD = Today.getDate();
  yr=document.form1.YEAR.value;
  cm=document.form1.MONTH.value;
  n.setDate(1);dow=n.getDay();moy=n.getMonth();

  for (i=0;i<41;i++)
  {
    if ((i<dow)||(moy!=n.getMonth()))
       dt="&nbsp;";
    else
    {
      dt=n.getDate();
      n.setDate(n.getDate()+1);

      if(dt==tD&&moy==tM&&yr==tY)
         dt="<a href='#' onclick='dateClick("+dt+")'><font color=red>"+dt+"</font></a>";
      else
         dt="<a href='#' onclick='dateClick("+dt+")'>"+dt+"</a>";
    }

    MM_findObj('day')[i].innerHTML="<b>"+dt+"</b>";
  }
}

function setPointer(theRow, thePointerColor)
{
   theRow.bgColor = thePointerColor;
}

var parent_window = window.dialogArguments;

function dateClick(theDate)
{
   yr=document.form1.YEAR.value;
   cm=document.form1.MONTH.value;
   if(theDate<10)	theDate="0"+theDate;
   date_str=yr+"-"+cm+"-"+theDate;
   parent_window.form1.<?php echo $datetime?>.value=date_str+parent_window.form1.<?php echo $datetime?>.value.substring(10);
   window.close();
}

function thisMonth()
{
	var Today = new Date();
	var tY = Today.getFullYear();
	var tM = Today.getMonth();
	var tD = Today.getDate();
<?php if($_GET['datetime']=='出生年月'||$_GET['datetime']=='出生日期') {	?>
   document.form1.YEAR.selectedIndex=(tY-1950-18);
<?php } else   {?>
   document.form1.YEAR.selectedIndex=(tY-1950);
<?php } ?>
   document.form1.MONTH.selectedIndex=(tM-0);
   doCal();
}
</script>
</head>

<body class="bodycolor" onload="thisMonth();" topmargin="0" leftmargin="0">
<form action="#"  method="post" name="form1">
<table width="100%" border="0" cellspacing="1" class="small" bgcolor="" cellpadding="3" align="center">
  <tr align="center" class="bodycolor">
    <td colspan="7" class="big1">
      <!-------------- 年 ------------>
        <input type="button" value="〈" class="SmallButton" title="<?php echo $framework_html[$choose_lang]['Lastyear']?>" onclick="set_year(-1);"><select name="YEAR" class="SmallSelect" onchange="set_year(0);">
		  <?php
			for($i=1950;$i<2038;$i++)		{
				$index = (int)date("Y");
				if($i==$index)
					$selectText = "selected";
				print "<option value=\"$i\" $selectText>$i</option>";
				$selectText = '';
			}
		  ?>
        </select>
        <input type="button" value="〉" class="SmallButton" title="<?php echo $framework_html[$choose_lang]['NextYear']?>" onclick="set_year(1);"> <b><?php echo $framework_html[$choose_lang]['Year']?></b>

<!-------------- 月 ------------>
        <input type="button" value="〈" class="SmallButton" title="<?php echo $framework_html[$choose_lang]['LastMonth']?>" onclick="set_mon(-1);"><select name="MONTH" class="SmallSelect" onchange="set_mon(0);">
          <option value="01" >01</option>
          <option value="02" >02</option>
          <option value="03" >03</option>
          <option value="04" >04</option>
          <option value="05" >05</option>
          <option value="06" >06</option>
          <option value="07" >07</option>
          <option value="08" >08</option>
          <option value="09" >09</option>
          <option value="10" >10</option>
          <option value="11" >11</option>
          <option value="12" >12</option>
        </select><input type="button" value="〉" class="SmallButton" title="<?php echo $framework_html[$choose_lang]['NextMonth']?>" onclick="set_mon(1);"> <b><?php echo $framework_html[$choose_lang]['Month']?></b>

    </td>
  </tr>
  <tr align="center" class="TableHeader">
    <td width="14%" bgcolor="#FFCCFF"><b>日</b></td>
    <td width="14%"><b>一</b></td>
    <td width="14%"><b>二</b></td>
    <td width="14%"><b>三</b></td>
    <td width="14%"><b>四</b></td>
    <td width="14%"><b>五</b></td>
    <td width="14%" bgcolor="#CCFFCC"><b>六</b></td>
  </tr>
  <tr bgcolor="#FFFFFF" align="center" style="cursor:pointer">
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
  </tr>
  <tr bgcolor="#FFFFFF" align="center" style="cursor:pointer">
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
  </tr>
  <tr bgcolor="#FFFFFF" align="center" style="cursor:pointer">
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
  </tr>
  <tr bgcolor="#FFFFFF" align="center" style="cursor:pointer">
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
  </tr>
  <tr bgcolor="#FFFFFF" align="center" style="cursor:pointer">
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
  </tr>
  <tr bgcolor="#FFFFFF" align="center" style="cursor:pointer">
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%" id="day" onmouseover="setPointer(this,'#E2E8FA')" onmouseout="setPointer(this,'')"></td>
    <td width="14%"><a href="#" onclick="thisMonth();"><b><?php echo $framework_html[$choose_lang]['ThisMonth']?></b></a></td>
  </tr>
</table>
</form>

</body>
</html>
