<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
global $storeid;
	global $db;
?>
<html>
<head>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/ajaxfileupload.js"></script>
<script type="text/javascript">

var $$ = jQuery.noConflict();
function ajaxFileUpload()
{
	
   loading("#btnimport","执行中","导入");
   $$.ajaxFileUpload({
             url:'store_init_newai.php?action=import_default_data&foreignkey=storeid&foreignvalue=<?php echo $storeid?>', 
             secureuri:false,
             fileElementId:'uploadfileXLS',
        	 async:false,
        	 dataType:'text', 
             success: function (data)
             {
                 
            	if(data.substring(0,5)== 'error')
                { 
            		 alert(data.substring(5)); 
            	 } 
            	location.reload();

             },	
   			error: function (data, status, e){ 
	   			alert(e); 
	   		} 
    });
   
} 
function ClearAll()
{
	
   $$.ajax({
             url:'store_init_newai.php?action=clearall&storeid=<?php echo $storeid?>', 
             type:'GET', 
        	 async:false,
        	 dataType:'text', 
        	 cache:false,
			 async: false,
             success: function (data)
             {

            	location.reload();

             },	
   			error: function (data, status, e){ 
	   			alert(e); 
	   		} 
    });
   
} 
function loading(id,beforetitle,endtitle){

	$$(id).ajaxStart(function(){ 
		$$(this).val(beforetitle);
		$$(this).attr('disabled',true);
	}).ajaxComplete(function(){ 
		$$(this).val(endtitle);
		$$(this).attr('disabled',false);
	}); 
} 
</script>
</head>
<?php 
	
	$storename= returntablefield( "stock", "rowid", $storeid, "name");
	
?>
<body class=bodycolor topMargin=5>
<table id=listtable align=center class=TableBlock width=100% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;库存初始化&nbsp;（仓库：<?php echo $storename?>）</TD></TR>
</table>
<div id="shoppingcart">
<form name="form1" method="post" action="stockinit_newai.php?action=save&storeid=<?php echo $storeid?>">
<table align=center class=TableBlock width=100% border=0 id="table1">
<tr >
	<td align=center class=TableHeader>产品编号</td>
    <td align=center class=TableHeader>产品名称</td>
    <td align=center class=TableHeader>颜色</td>
    <td align=center class=TableHeader>规格</td>
    <td align=center class=TableHeader>单位</td>
    <td align=center class=TableHeader>类别</td>
    <td align=center class=TableHeader>单价</td>
    <td align=center class=TableHeader>数量</td>
    <td align=center class=TableHeader>金额</td>
    <td align=center class=TableHeader>备注</td>
</tr>

<?php 

	$sql = "select a.*,b.name from store_init a inner join producttype b on a.typename=b.ROWID where storeid=$storeid and flag=0 ";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
    if (count($rs_a) != 0) 
    {
    	$class="";
        for($i=0;$i<count($rs_a);$i++)
        {
        	$allnum=$allnum+$rs_a[$i]['num'];
        	$alljine=$alljine+$rs_a[$i]['jine'];
        	if($i%2==1)
        		$class="TableLine1";
        	else
        		$class="TableLine2";
        	
?>
            <tr class=<?php echo $class?>>
            	<td><?php echo $rs_a[$i]['prodid']?></td>
                <td><?php echo $rs_a[$i]['prodname']?></td>
                <td align="center"><?php echo $rs_a[$i]['guige']?></td>
                <td align="center"><?php echo $rs_a[$i]['xinghao']?></td>
                <td align="center"><?php echo $rs_a[$i]['danwei']?></td>
                <td align="center"><?php echo $rs_a[$i]['name']?></td>
                <td align="right"><?php echo $rs_a[$i]['price']?></td>
                <td align="right"><?php echo $rs_a[$i]['num']?></td>
                <td align="right"><?php echo $rs_a[$i]['jine']?></td>
                <td align="center"><?php echo $rs_a[$i]['memo']?></td>
               
            </tr>
            <?php 
        }
        ?>
        <tr class=TableHeader >
             <td align=center>总计</td>
             <td></td><td></td><td></td><td></td><td></td><td></td>
             <td align="right"><div id="allamount"><?php echo $allnum?></div></td>
             <td align="right"><div id="allmoney"><?php echo $alljine?></div></td>
             <td align="right"></td>
             <td></td>
        <?php
    } 
?>

</table>
</div>
<div id="inputarea">
<table id=listtable align=center class=TableBlock width=100% >
<TR class=TableData>
<?php 
$filepath_system="Model/store_init_newai.ini";
if(file_exists($filepath_system))	
	$file_ini=parse_ini_file($filepath_system,true);
$showlistfieldlist=$file_ini['export_default']['showlistfieldlist'];
?>
<TD noWrap align=middle width=50%>批量导入(Excel):<input name='uploadfileXLS' id='uploadfileXLS' type=file size=25 class=SmallInput>
<input type='button' id='btnimport' value='导入' class='SmallButton' onclick='ajaxFileUpload()'>&nbsp;<a href="store_init_newai.php?action=export_default_data&exportfield=<?php echo $showlistfieldlist?>&tablename=store_init&searchfield=1&searchvalue=0">下载模版</a></TD>

</table>
</div>
<p align=center><input type=button value=" 清空 " class="SmallButton" onclick='ClearAll()'>&nbsp;&nbsp;<input type=submit value=" 保存 " class="SmallButton" >
&nbsp;&nbsp;<input type=button value=" 返回 " class="SmallButton" onclick="location='stockinit_newai.php';"></p>
</form>
</body>
</html>