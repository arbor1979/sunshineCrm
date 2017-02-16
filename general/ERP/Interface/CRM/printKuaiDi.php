<?php
	
	ini_set('display_errors',1);
	ini_set('error_reporting',E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once("lib.inc.php");
	$GLOBAL_SESSION=returnsession();
	$mobile='';
	if($_SESSION['LOGIN_USER_MOBILE']=='')
		$mobile=$_SESSION['TEL_NO'];
	else 
		$mobile=$_SESSION['LOGIN_USER_MOBILE'];
	$CustOrSupply=$_GET['CustOrSupply'];
	$linkmanlist=$_GET['linkmanlist'];
	$sendlistarray=explode(",", $linkmanlist);

	$shoujianrenArray=array();
	for($i=0;$i<count($sendlistarray);$i++)
	{
		if($sendlistarray[$i]=='')
			continue;
		if($CustOrSupply=="customer")
		{
			$linkmaninfo	= returntablefield("linkman", "rowid", $sendlistarray[$i], "linkmanname,customerid,mobile,phone,address");
			$shoujianren['name']		=	$linkmaninfo['linkmanname'];
			$shoujianren['address']		=	$linkmaninfo['address'];
			$shoujianren['mobile']		=	$linkmaninfo['mobile']." ".$linkmaninfo['phone'];
			$customerInfor	= returntablefield("customer","rowid",$linkmaninfo['customerid'],"supplyname,contactaddress");
			$shoujianren['supplyname']	=	$customerInfor['supplyname'];
			if(trim($shoujianren['address'])=='')
				$shoujianren['address']		=	$customerInfor['contactaddress'];
			
			array_push($shoujianrenArray,$shoujianren);
		}
		else if($CustOrSupply=="supply")
		{
			$linkmaninfo				=	returntablefield("supplylinkman", "rowid", $sendlistarray[$i], "supplyname,supplyid,phone,address");
			$shoujianren['name']		=	$linkmaninfo['supplyname'];
			$shoujianren['mobile']		=	$linkmaninfo['phone'];
			$shoujianren['address']		=	$linkmaninfo['address'];
			$supplyInfor	= returntablefield("supply","rowid",$linkmaninfo['supplyid'],"supplyname,chargesection,phone");
			$shoujianren['supplyname']=$supplyInfor['supplyname'];
			if(trim($shoujianren['address'])=='')
				$shoujianren['address']		=	$supplyInfor['chargesection'];
			if(trim($shoujianren['mobile'])=='')
				$shoujianren['mobile']=$supplyInfor['phone'];
			array_push($shoujianrenArray,$shoujianren);
		}
		else if($CustOrSupply=="fahuodan")
		{
			$linkmaninfo				=	returntablefield("fahuodan", "billid", $sendlistarray[$i], "shouhuoren,tel,address,fahuotype");
			$shoujianren['name']		=	$linkmaninfo['shouhuoren'];
			$shoujianren['mobile']		=	$linkmaninfo['tel'];
			$shoujianren['address']		=	$linkmaninfo['address'];
			$fahuotype	=	$linkmaninfo['fahuotype'];		
			array_push($shoujianrenArray,$shoujianren);
		}
	}
	
	//print_R($shoujianrenArray);
	
	global $db;
	$sql="select * from fahuotype where kuaididan is not null order by shunxu";
	$rs=$db->Execute($sql);
	$rs_b = $rs->GetArray();
	print "<LINK href=\"".ROOT_DIR."theme/".$_SESSION['LOGIN_THEME']."/style.css\" type=text/css rel=stylesheet>";
	print "\n<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>\n";
?>
<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
</head>

<body onload="if (typeof(LODOP.VERSION)!='undefined') changemoban(kuaidicom.value);">
<table class=TableBlock align=center width=800 >
<TR><TD class=TableHeader align=center colSpan=3>打印快递单</TD></TR>
<tr>
<td  class="TableContent" width=20%>快递公司:</td>
<td class="TableData" colspan=2>
<select name="kuaidicom" id="kuaidicom" onchange="changemoban(this.value)">
 <?php
 for($i=0;$i<sizeof($rs_b);$i++)
{
	print "<option value=".$rs_b[$i]['id'];
	if($fahuotype!='' && $rs_b[$i]['id']==$fahuotype)
		print " selected ";
	print ">".$rs_b[$i]['name']."</option>";
}
 ?>
 </select></td>
</tr>
<tr>
<td class="TableContent" width=20%>收件人:</td>
<td class="TableData" colspan=2>
<textarea id=dests style="width:450px;" rows="5" style="overflow-y:auto;" class="BigStatic" wrap="yes" readonly>
<?php
for($i=0;$i<count($shoujianrenArray);$i++)
{
	print $shoujianrenArray[$i]['name'].",";
}
?>
</textarea>
</td>
</tr>
<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="center">
 <input type="button" class="SmallButton" value="预览" onclick="Preview1();">
 <input type="button" class="SmallButton" value="打印" onclick="RealPrint();">
 <input type="button" class="SmallButton" value="设计" onclick="Design1();">
 <input type="button" class="SmallButton" value="关 闭" onclick="window.close();">
</div>
  </td>
</tr>

<TR>
	<TD class=TableControl noWrap align=middle  colspan="3">
		<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=800 height=600> 
	<embed id="LODOP_EM" type="application/x-print-lodop" width=900 height=700 pluginspage="../LODOP60/install_lodop.exe"></embed>
</object> 
	</td>
</tr>

</table>


<script  type="text/javascript">
	var LODOP;
	var imgmoban;
	var designmoban;
	var kdarray=new Array();
	var rootpath="<?php echo ROOT_DIR?>";

	LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));

	var $$ = jQuery.noConflict();
	function getdesignmoban()
	{
		
		if(kuaidicom.value=='')
		{
			alert('没有可用的快递公司，或者没有上传快递单图片');
			return false;
		}
		
		$$.post('../JXC/fahuotype_newai.php', {
		    action: 'getmoban',
		    id:kuaidicom.value
		}, function(data) {
			designmoban=unescape(data);
			ShowWindowInPage();
		});

	}

	
	
	function Preview1() {
		var m=Math.random();
		CreateFullBill(m);
	  	LODOP.PREVIEW();
	};
	function Design1() {

		printInit('design');

		eval(designmoban);
		//designmoban=LODOP.PRINT_DESIGN();

		LODOP.SET_PRINT_MODE("PRINT_SETUP_PROGRAM",true);
		designmoban=LODOP.PRINT_DESIGN();
		$$.post('../JXC/fahuotype_newai.php', {
		    action: 'postmoban',
		    id:kuaidicom.value,
		    moban: escape(designmoban)
		}, function(data) {
			designmoban=unescape(data);
			//$("#dests").val(data);
		});
	};
	function RealPrint() {
		LODOP.SELECT_PRINTER();
		CreateFullBill();
		if (LODOP.PRINT())		{
			//document.getElementById("RealPrint").readonly = true;
			//document.getElementById("RealPrint").disabled = true;
			alert("已打印！");
		}
	};
	function printInit(taskid)
	{
		LODOP.PRINT_INITA(0,0,2150,1400,taskid);
		LODOP.ADD_PRINT_SETUP_BKIMG("<img border='0' src='"+imgmoban+"'>");
		LODOP.SET_PRINT_PAGESIZE(1,2150,1400,"");
		LODOP.SET_SHOW_MODE("BKIMG_LEFT","5");
		LODOP.SET_SHOW_MODE("BKIMG_TOP","5");
		
	}

	function ShowWindowInPage()				{
		var m=Math.random();
		CreateFullBill(m);
		LODOP.SET_SHOW_MODE("PREVIEW_IN_BROWSE",1);
		LODOP.SET_SHOW_MODE("HIDE_PAPER_BOARD",1);
		LODOP.SET_SHOW_MODE("BKIMG_IN_PREVIEW",1);
		LODOP.PREVIEW();
	};

	function CreateFullBill(taskid) {
		var generalContent;
		printInit(taskid);
		LODOP.SET_SHOW_MODE("BKIMG_IN_PREVIEW",true);
		<?php
		for($i=0;$i<count($shoujianrenArray);$i++)
		{
		?>
		
		generalContent=designmoban;
		generalContent=generalContent.replace("收件人地址","<?php echo $shoujianrenArray[$i]['address']?>");
		generalContent=generalContent.replace("收件人单位","<?php echo $shoujianrenArray[$i]['supplyname']?>");
		generalContent=generalContent.replace("收件人姓名","<?php echo $shoujianrenArray[$i]['name']?>");
		generalContent=generalContent.replace("收件人电话","<?php echo $shoujianrenArray[$i]['mobile']?>");

		generalContent=generalContent.replace("寄件人地址","<?php echo $_SESSION['ADDRESS']?>");
		generalContent=generalContent.replace("寄件人单位","<?php echo $_SESSION['UNIT_NAME']?>");
		generalContent=generalContent.replace("寄件人姓名","<?php echo $_SESSION['LOGIN_USER_NAME']?>");
		generalContent=generalContent.replace("寄件人电话","<?php echo $mobile?>");
		LODOP.NewPage();
		eval(generalContent);


		<?php

		}
		?>

	};
	<?php
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "kdarray[$i]=new Array();\r\n";
		print "kdarray[$i][0]='".$rs_b[$i]['id']."';\r\n";
		print "kdarray[$i][1]='".$rs_b[$i]['kuaididan']."';\r\n";

	}
	?>

	function changemoban(id)
	{
		imgmoban='';
		for(i=0;i<kdarray.length;i++)
		{
			if(kdarray[i][0]==id && kdarray[i][1]!='')
			{
				
				var patharray=kdarray[i][1].split("&amp;");
				var pathnamearray=patharray[patharray.length-1].split("=");
				var pathfoldarray=patharray[patharray.length-2].split("=");
				imgmoban=rootpath+"general/ERP/Framework/attachment/"+pathfoldarray[pathfoldarray.length-1]+"/"+pathnamearray[pathnamearray.length-1];
				break;
			}
				
		}
		getdesignmoban();
	}


	//ShowWindowInPage();
</script>

</body>
</html>