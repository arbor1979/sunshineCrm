<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
?>
<html>
<head>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
<script type="text/javascript">

</script>
</head>
<?php 
	global $storeid;
	global $db;
	$storename= returntablefield( "stock", "rowid", $storeid, "name");
	
?>
<body class=bodycolor topMargin=5>
<table id=listtable align=center class=TableBlock width=100% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;库存初始化明细&nbsp;（仓库：<?php echo $storename?>）</TD></TR>
</table>
<div id="shoppingcart">
<form name="form1" method="post" action="stockinit_newai.php?action=save&storeid=<?php echo $storeid?>" onsubmit="return submitFormCheck();">
<table align=center class=TableBlock width=100% border=0 id="table1">
<tr >
	<td align=center class=TableHeader>产品编号</td>
    <td align=center class=TableHeader>产品名称</td>
    <td align=center class=TableHeader>颜色</td>
    <td align=center class=TableHeader>规格</td>
    <td align=center class=TableHeader>单位</td>
    <td align=center class=TableHeader>类别</td>
    <td align=center class=TableHeader>价格</td>
    <td align=center class=TableHeader>数量</td>
    <td align=center class=TableHeader>金额</td>
    <td align=center class=TableHeader>备注</td>
</tr>

<?php 
	$sql="select a.*,b.name as prodtypename  from store_init a left join producttype b on a.typename=b.ROWID where storeid=$storeid and flag=1";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$allnum=0;
	$allmoney=0;
    	$class="";
        for($i=0;$i<count($rs_a);$i++)
        {
        	
        	if($i%2==1)
        		$class="TableLine1";
        	else
        		$class="TableLine2";
        	$allnum=$allnum+$rs_a[$i]['num'];
        	$allmoney=$allmoney+(round($rs_a[$i]['num']*$rs_a[$i]['price'],2));
?>
            <tr class=<?php echo $class?>>
            	<td><?php echo $rs_a[$i]['prodid']?></td>
                <td><?php echo $rs_a[$i]['prodname']?></td>
                <td align="center"><?php echo $rs_a[$i]['guige']?></td>
                <td align="center"><?php echo $rs_a[$i]['xinghao']?></td>
                <td align="center"><?php echo $rs_a[$i]['danwei']?></td>
                <td align="center"><?php echo $rs_a[$i]['prodtypename']?></td>
                <td align="right"><?php echo $rs_a[$i]['price']?></td>
                <td align="right"><?php echo $rs_a[$i]['num']?></td>
                <td align="right"><?php echo round($rs_a[$i]['num']*$rs_a[$i]['price'],2)?></td>
                <td align="center"><?php echo $rs_a[$i]['memo']?></td>
            </tr>
            <?php 
            
        }
        ?>
        <tr class=TableHeader >
             <td align=center>总计</td>
             <td></td><td></td><td></td><td></td><td></td><td></td>
             <td align="right"><div id="allamount"><?php echo $allnum?></div></td>
             <td align="right"><div id="allmoney"><?php echo $allmoney?></div></td>
             <td align="right"></td>
             <td></td>


</table>
</div>
<p align=center><input type=button value=" 返回 " class="SmallButton" onclick="location='stockinit_newai.php';"></p>
</form>
</body>
</html>