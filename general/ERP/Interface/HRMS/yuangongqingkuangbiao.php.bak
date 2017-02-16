<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//######################教育组件-权限较验部分##########################

require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
page_css("员工基本情况表");
//print_R($_GET);
?>
  <div id=MainData0>
<h2 align=center>员工基本情况表</h2>
<table class=TableBlock width=80% align=center>
<?php
  $sql = "select * from hrms_file where 编号='".$_GET['编号']."'";

  $rs  = $db->Execute($sql);
  $rs_a= $rs->GetArray();
	
  $i=0;
 foreach ($rs_a[0] as $key=>$value)
 {
  	if($i%3==0)
  		print "<tr>";
  	print "<td class=TableContent>$key</td>";
	print "<td class=TableData>$value</td>";
	if($i%3==2)
  		print "</tr>";
  	$i++;
 }
 	

?>
</table></div>
<p align=center>
<input type=button class=SmallButton value="预览" onclick="PreviewMytable()">
<input type=button class=SmallButton value="打印" onclick="PrintMytable()">
<input type=button class=SmallButton value="返回" onclick="history.back();">
</p>
<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="../LODOP60/install_lodop.exe"></embed>
</object>

<script language="javascript" type="text/javascript">
	var LODOP; //声明为全局变量
	LODOP=getLodop(document.getElementById('LODOP'),document.getElementById('LODOP_EM'));

    function PreviewFun(){
	    LODOP.PRINT_INIT("数字化校园打印程序");
		var strStyleCSS="<link href='/theme/3/style.css' type='text/css' rel='stylesheet'>";
		
		LODOP.ADD_PRINT_TABLE(20,"2%","90%","90%",strStyleCSS+"<body>"+document.getElementById("MainData0").innerHTML+"</body>");
		//LODOP.SET_PRINT_STYLEA(0,"ItemType",1);
		//LODOP.SET_PRINT_STYLEA(0,"LinkedItem",1);
		LODOP.NewPageA();
	};

	function PreviewMytable(){
		
		PreviewFun();
		LODOP.PREVIEW();
	};

	function PrintMytable(){

		PreviewFun();
		if (LODOP.PRINTA())  
			alert("已发出实际打印命令！");
	};
</script>