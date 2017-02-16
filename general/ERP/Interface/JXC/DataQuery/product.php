<?php
require_once("lib.inc.php");

?>
<HTML><HEAD><TITLE>选择产品</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="MSHTML 6.00.2900.3059" name=GENERATOR>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
</HEAD>
<BODY style="margin-top:5px; margin-left:5px; margin-right:0px">
<DIV id=pinghead
style="BORDER-RIGHT: #707888 1px solid; BORDER-TOP: #707888 1px solid; OVERFLOW: hidden; BORDER-LEFT: #707888 1px solid; WIDTH: 322px; BORDER-BOTTOM: #707888 1px solid; POSITION: absolute; HEIGHT: 14px">
<DIV id=pimg style="LEFT: 0px; POSITION: absolute; TOP: -1px"></DIV></DIV>
<CENTER>
<DIV id=abc
style="FONT-SIZE: 9pt; LEFT: 120px; COLOR: #f4f4f4; POSITION: absolute; TOP: 30px">正在从服务器读取数据，请稍等........
</DIV></CENTER>
<SCRIPT language="javascript">
s=new Array();
s[0]="#050626";
s[1]="#0a0b44";
s[2]="#0f1165";
s[3]="#1a1d95";
s[4]="#1c1fa7";
s[5]="#1c20c8";
s[6]="#060cff";
s[7]="#2963f8";
function ls(){
		pimg.innerHTML="";
		for(i=0;i<9;i++){
		pimg.innerHTML+="<input style=\"width:15;height:10;border:0;background:"+s[i]+";margin:1\">";
		}
	}

function rs(){
		pimg.innerHTML="";
		for(i=9;i>-1;i--){
		pimg.innerHTML+="<input style=\"width:15;height:10;border:0;background:"+s[i]+";margin:1\">";
		}
	}

ls();
var g=0;sped=0;
function str(){
	if(pimg.style.pixelLeft<350&&g==0){
	if(sped==0){
		ls();
		sped=1;
		}
	pimg.style.pixelLeft+=2;
	setTimeout("str()",1);
	return;
	}
	g=1;
	if(pimg.style.pixelLeft>-200&&g==1){
	if(sped==1){
		rs();
		sped=0;
		}
	pimg.style.pixelLeft-=2;
	setTimeout("str()",1);
	return;
	}
	g=0;
	str();
}

function flashs(){
if(abc.style.color=="#ffffff"){
	abc.style.color="#707888";
	setTimeout('flashs()',500);
	}
else{
	abc.style.color="#ffffff";
	setTimeout('flashs()',500);
	}
}
flashs();
str();

var now1 =new Date()
StarTime_S=now1.getTime()
</SCRIPT>

<SCRIPT language=JavaScript>
var parent_window = parent.dialogArguments;
var theDefaultColor="#FFFFFF";
var thePointerColor="#D9E8FF";
var theMarkColor="#003FBF";
var defaultNum='3';
if (isNaN(parseFloat(defaultNum))){
	defaultNum="";
	}
if (parseFloat(defaultNum)<=0){
	defaultNum="";
	}


function clickInsert(theRow, theId, theAction, field, theName, countStr, cliNo,price,standard,mode,num,rateStr){
	var cliNo=document.form1("cliNo").value;
	var parent_window = parent.dialogArguments;
	var isSelect="";
	var isInsert=false;
	var i=0;
	//alert("cliNo=="+cliNo);
      for (i=1;i<=cliNo;i++){
      	//alert("id_"+field+"_"+countStr+"_wxd_"+i);
      	isSelect=parent_window.document.form1("id_"+field+"_"+countStr+"_wxd_"+i).value;
      	//alert(isSelect);
      	if (isSelect==null||isSelect==""){
      		isInsert=false;
      		document.form1("cliNo").value=i;
      		break;
      	}else{
      		isInsert=true;
      		}
      	}



	if (isInsert==true){
		//alert("cliNo"+cliNo);
		if (i==cliNo){
		i++;
	  }
		//alert("i"+i);

		//alert(parent_window.document.getElementById("id_"+field+"_"+countStr+"_wxd_"+i));

		if(parent_window.document.getElementById("id_"+field+"_"+countStr+"_wxd_"+i)==null){
			isInsert=true;

		}else{
			isSelect=parent_window.document.form1("id_"+field+"_"+countStr+"_wxd_"+i).value;
		//alert(isSelect);
		cliNo++;
		document.form1("cliNo").value=cliNo;
		isInsert=false
	  }
		}
		//alert("isInsert"+isInsert);
	if (isInsert==true){
	//alert(cliNo);

	cliNo++;
	parent_window.document.getElementById("btninsert").click();

	window.parent.frames("query").document.form1("cliNo").value=cliNo;
	document.form1("cliNo").value=cliNo;
	//alert("修改后"+cliNo);


	}
}


</SCRIPT>

<script type="text/javascript" language="javascript" src="../../../../Enginee/lib/common.js"></script>
<TABLE class=TableBlock width="100%" border=0>
  <TBODY>
  <TR >
    <TD class=TableHeader align=center><FONT >编码</FONT></TD>
    <TD class=TableHeader align=center><FONT >名称</FONT></TD>
    <TD class=TableHeader align=center><FONT >颜色</FONT></TD>
    <TD class=TableHeader align=center><FONT >规格</FONT></TD>
    <TD class=TableHeader align=center><FONT >价格</FONT></TD>
    <TD class=TableHeader align=center><FONT >库存</FONT></TD>
    <TD class=TableHeader align=center><FONT >操作</FONT></TD></TR>

<?php
function getIds($parentid)
{
	global $db;
	global $ids;
	$sql = "select rowid from producttype where parentid='".$parentid."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();

	if(sizeof($rs_a)==0)
		return;
	else 
	{
		for($i=0;$i<sizeof($rs_a);$i++)	
		{
			$ids=$ids.",".$rs_a[$i]['rowid'];
			getIds($rs_a[$i]['rowid']);
		}
	}
}
$sql = "select * from product where 1=1";
if($_GET['producttype']!="")	{
	
	$ids=$_GET['producttype'];
	getIds($_GET['producttype']);
	$sql = $sql." and producttype in (".$ids.")";
}
if($_GET['KEYVALUE']!="" && $_GET['KEYVALUE']!="undefined")		{
	$KEYVALUE = $_GET['KEYVALUE'];
	$sql = $sql." and (productname like '%$KEYVALUE%' or productid like '%$KEYVALUE%' or productcn like '%$KEYVALUE%')";
}

//print $sql;
//print_R($_GET);
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();

for($i=0;$i<sizeof($rs_a);$i++)		{
	$Element = $rs_a[$i];
	$storenum = returntablefield("store","productid",$Element[productid],"stocknum");
	$storenum==""?$storenum=0:'';
	$class="";
	if($i%2==1)
		$class="TableLine1";
	else
		$class="TableLine2";
	print "<TR class=$class >
    <TD class=menulines align=middle width='15%' height=20>".$Element[productid]."</TD>
    <TD class=menulines align=middle width='20%' height=20>".$Element[productname]."</TD>
    <TD class=menulines align=middle width='15%' height=20>".$Element[standard]."</TD>
    <TD class=menulines align=middle width='10%' height=20>".$Element[mode]."</TD>
    <TD class=menulines align=middle width='10%' height=20>".$Element[sellprice]."</TD>
    <TD class=menulines align=middle width='10%' height=20>".$storenum."</TD>
    <TD class=menulines align=middle width='10%' height=20><INPUT class=SmallButton onclick=\"javascript:clickInsert(this, '".$Element[productid]."', 'click', 'productid', '".$Element[productname]."','1','1','".$Element[sellprice]."','".$Element[standard]."','".$Element[mode]."','".$storenum."','0');\" type=button value=选择 name=Submit>
    </TD></TR>";
  //clickInsert(theRow, theId, theAction, field, theName, countStr, cliNo,price,standard,mode,num,rateStr)
}

?>
</TBODY></TABLE><INPUT type=hidden value="<?php echo $_GET['cliNo']?>" name=cliNo>
<SCRIPT>
document.all("pimg").style.display="none";
 document.all("abc").style.display="none";
  document.all("pinghead").style.display="none";
</SCRIPT>
</BODY></HTML>
