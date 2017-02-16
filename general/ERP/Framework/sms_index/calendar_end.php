<?php
session_start();

global $framework_html;
$choose_lang = @$_GET['choose_lang'];
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


print "<LINK href=\"".ROOT_DIR."theme/".$_SESSION['LOGIN_THEME']."/style.css\" rel=stylesheet>";

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
   parent_window.form1.END_DATE.value=date_str;
   window.close();
}

function thisMonth()
{
	var Today = new Date();
	var tY = Today.getFullYear();
	var tM = Today.getMonth();
	var tD = Today.getDate();
   document.form1.YEAR.selectedIndex=(tY-1920);
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
        <input type="button" value="〈" class="SmallButton" title="<?php echo $framework_html[$choose_lang]['LastYear']?>" onclick="set_year(-1);"><select name="YEAR" class="SmallSelect" onchange="set_year(0);">
		  <option value="1920" >1920</option>
          <option value="1921" >1921</option>
          <option value="1922" >1922</option>
          <option value="1923" >1923</option>
          <option value="1924" >1924</option>
          <option value="1925" >1925</option>
          <option value="1926" >1926</option>
          <option value="1927" >1927</option>
          <option value="1928" >1928</option>
          <option value="1929" >1929</option>
          <option value="1930" >1930</option>
          <option value="1931" >1931</option>
          <option value="1932" >1932</option>
          <option value="1933" >1933</option>
          <option value="1934" >1934</option>
          <option value="1935" >1935</option>
          <option value="1936" >1936</option>
          <option value="1937" >1937</option>
          <option value="1938" >1938</option>
          <option value="1939" >1939</option>
          <option value="1940" >1940</option>
          <option value="1941" >1941</option>
          <option value="1942" >1942</option>
          <option value="1943" >1943</option>
          <option value="1944" >1944</option>
          <option value="1945" >1945</option>
          <option value="1946" >1946</option>
          <option value="1947" >1947</option>
          <option value="1948" >1948</option>
          <option value="1949" >1949</option>
          <option value="1950" >1950</option>
          <option value="1951" >1951</option>
          <option value="1952" >1952</option>
          <option value="1953" >1953</option>
          <option value="1954" >1954</option>
          <option value="1955" >1955</option>
          <option value="1956" >1956</option>
          <option value="1957" >1957</option>
          <option value="1958" >1958</option>
          <option value="1959" >1959</option>
          <option value="1960" >1960</option>
          <option value="1961" >1961</option>
          <option value="1962" >1962</option>
          <option value="1963" >1963</option>
          <option value="1964" >1964</option>
          <option value="1965" >1965</option>
          <option value="1966" >1966</option>
          <option value="1967" >1967</option>
          <option value="1968" >1968</option>
          <option value="1969" >1969</option>
          <option value="1970" >1970</option>
          <option value="1971" >1971</option>
          <option value="1972" >1972</option>
          <option value="1973" >1973</option>
          <option value="1974" >1974</option>
          <option value="1975" >1975</option>
          <option value="1976" >1976</option>
          <option value="1977" >1977</option>
          <option value="1978" >1978</option>
          <option value="1979" >1979</option>
          <option value="1980" >1980</option>
          <option value="1981" >1981</option>
          <option value="1982" >1982</option>
          <option value="1983" >1983</option>
          <option value="1984" >1984</option>
          <option value="1985" >1985</option>
          <option value="1986" >1986</option>
          <option value="1987" >1987</option>
          <option value="1988" >1988</option>
          <option value="1989" >1989</option>
          <option value="1990" >1990</option>
          <option value="1991" >1991</option>
          <option value="1992" >1992</option>
          <option value="1993" >1993</option>
          <option value="1994" >1994</option>
          <option value="1995" >1995</option>
          <option value="1996" >1996</option>
          <option value="1997" >1997</option>
          <option value="1998" >1998</option>
          <option value="1999" >1999</option>
          <option value="2000" >2000</option>
          <option value="2001" >2001</option>
          <option value="2002" >2002</option>
          <option value="2003" >2003</option>
          <option value="2004" >2004</option>
          <option value="2005" >2005</option>
          <option value="2006" >2006</option>
          <option value="2007" >2007</option>
          <option value="2008" >2008</option>
          <option value="2009" >2009</option>
          <option value="2010" >2010</option>
          <option value="2011" >2011</option>
          <option value="2012" >2012</option>
          <option value="2013" >2013</option>
          <option value="2014" >2014</option>
          <option value="2015" >2015</option>
          <option value="2016" >2016</option>
          <option value="2017" >2017</option>
          <option value="2018" >2018</option>
          <option value="2019" >2019</option>
          <option value="2020" >2020</option>
          <option value="2021" >2021</option>
          <option value="2022" >2022</option>
          <option value="2023" >2023</option>
          <option value="2024" >2024</option>
          <option value="2025" >2025</option>
          <option value="2026" >2026</option>
          <option value="2027" >2027</option>
          <option value="2028" >2028</option>
          <option value="2029" >2029</option>
          <option value="2030" >2030</option>
          <option value="2031" >2031</option>
          <option value="2032" >2032</option>
          <option value="2033" >2033</option>
          <option value="2034" >2034</option>
          <option value="2035" >2035</option>
          <option value="2036" >2036</option>
          <option value="2037" >2037</option>
          <option value="2038" >2038</option>
          <option value="2039" >2039</option>
          <option value="2040" >2040</option>
          <option value="2041" >2041</option>
          <option value="2042" >2042</option>
          <option value="2043" >2043</option>
          <option value="2044" >2044</option>
          <option value="2045" >2045</option>
          <option value="2046" >2046</option>
          <option value="2047" >2047</option>
          <option value="2048" >2048</option>
          <option value="2049" >2049</option>
          <option value="2050" >2050</option>
        </select>
        <input type="button" value="〉" class="SmallButton" title="<?php echo $framework_html[$choose_lang]['NextYear']?>" onclick="set_year(1);"> <b><?php echo $framework_html[$choose_lang]['Year']?></b>

<!-------------- 月 ------------>
        <input type="button" value="〈" class="SmallButton" title="<?php echo $framework_html[$choose_lang]['LastMonth']?>" onclick="set_mon(-1);"><select name="MONTH" class="SmallSelect" onchange="set_mon(0);">
          <option value="01" >01</option>
          <option value="02" >02</option>
          <option value="03" selected>03</option>
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
