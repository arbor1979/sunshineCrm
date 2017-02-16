<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$rowid=$_GET['rowid'];
page_css();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/popup/js/popup.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/popup/js/popupclass.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
<script type="text/javascript">


function submitFormCheck() 
{
	//用于数据校验的临时对象
	for(var i=0;i<form1.elements.length;i++)
	{
		if(form1.elements[i].type=="text" && form1.elements[i].name.substring(0,4)=="num_")
		{
			var newamount=form1.elements[i].value;
			try
			{
				newamount=eval(newamount);
			}
			catch(err)
			{
				alert(err.description);
				return false;
			}
			if(IsInteger(newamount)==false)
			{
				alert("数量必须是整数");
				return false;
			}
		}
	}
	var boolflag=true;
	$("img", document.forms[0]).each(function()
	{	
		var imgsrc=this.src;
		if(imgsrc.indexOf('sepangray.gif')>-1)
		{
			alert('还有产品未进行颜色分配');
			boolflag=false;
			return boolflag;
		}
		
	}); 
	return boolflag;
	
    
}
function CountRecJine(id)
{
	
	var oldnum=parseFloat(document.getElementById("oldnum_"+id).innerText);
	var hasnum=parseFloat(document.getElementById("recnum_"+id).innerText);
	var recnum=parseFloat(form1.elements["num_"+id].value);
	
	if(recnum+hasnum>oldnum)
	{
		alert("本次入库数不能大于"+(oldnum-hasnum));
		document.getElementById("num_"+id).innerText=oldnum-hasnum;
		return;
	}
	var recdiv=document.getElementById("recjine_"+id);
	var price=form1.elements['price_'+id].value;
	var zhekou=form1.elements["zhekou_"+id].value;
	
	var recjine=Math.round(price*recnum*zhekou*100)/100;
	recdiv.innerText=recjine;
	form1.elements["recjine_"+id].value=recjine;
	CountAllJine();
}
function CountAllJine()
{
	var allnum=0;
	var allmoney=0;
	for(var i=0;i<form1.elements.length;i++)
	{
		if(form1.elements[i].name.substring(0,4)=="num_")
		{
			allnum=eval(allnum+Number(form1.elements[i].value));
		}
		if(form1.elements[i].name.substring(0,8)=="recjine_")
		{
			allmoney=eval(allmoney+Number(form1.elements[i].value));
		}
	}
	allmoney=Math.round(allmoney*100)/100;
	document.getElementById("allamount1").innerText=allnum;
	document.getElementById("allmoney1").innerText=allmoney;
	form1.allamount1.value=allnum;
	form1.allmoney1.value=allmoney;
}
function PopColorInput(id)
{
	ShowIframe('颜色分配','colorinput.php?tablename=buyplanmain_detail_color&id='+id,600,200);
}
</script>
</head>
<?php 
	$customerid= returntablefield("buyplanmain", "billid", $rowid, "supplyid");
	$customerName= returntablefield( "supply", "rowid", $customerid, "supplyname");
	
?>
<body class=bodycolor topMargin=5 onload="CountAllJine();">
1、采购单可分批入库，请输入本次入库的数量（若数量为负，将生成出库单）
<table id=listtable align=center class=TableBlock width=100% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;生成入库单&nbsp;（供应商：<?php echo $customerName?>）</TD></TR>
</table>
<div id="shoppingcart">
<form name="form1" method="post" action="buyplanmain_newai.php?action=saveruku&rowid=<?php echo $rowid?>" onsubmit="return submitFormCheck();">
<table align=center class=TableBlock width=100% border=0 id="table1">
<tr >
	<td align=center class=TableHeader>产品编号</td>
    <td align=center class=TableHeader>产品名称</td>
    <td align=center class=TableHeader>原厂码</td>
    <td align=center class=TableHeader>单位</td>
	<td align=center class=TableHeader>颜色</td>
    <td align=center class=TableHeader>成本价</td>
    <td align=center class=TableHeader>数量</td>
    <td align=center class=TableHeader>金额</td>
     <td align=center class=TableHeader>已入库数</td>
    <td align=center class=TableHeader>本次入库数</td>
    <td align=center class=TableHeader>本次入库金额</td>
    <td align=center class=TableHeader>备注</td>
</tr>

<?php 
	
	$sql = "select a.*,b.name as colorname from buyplanmain_detail a left join productcolor b on a.prodguige=b.id where mainrowid=".$rowid;
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$sql="select * from stock where 1=1 ";
	$sql=getKucunByUserid($sql,$_SESSION['LOGIN_USER_ID'],'ROWID');
	$rs=$db->Execute($sql);
	$rs_b = $rs->GetArray();
    if (count($rs_a) != 0) 
    {
    	
    	$allnum=0;
    	$allmoney=0;
    	$class="";
    	$imgurl=ROOT_DIR."general/ERP/Framework/images/sepan.gif";
        $imgurlgray=ROOT_DIR."general/ERP/Framework/images/sepangray.gif";
        for($i=0;$i<count($rs_a);$i++)
        {
        	$allnum=$allnum+$rs_a[$i]['num'];
        	$allnum1=$allnum1+$rs_a[$i]['recnum'];
        	$allmoney=$allmoney+round($rs_a[$i]['num']*$rs_a[$i]['price']*$rs_a[$i]['zhekou'],2);
        	$allmoney1=$allmoney1+round($rs_a[$i]['recnum']*$rs_a[$i]['price']*$rs_a[$i]['zhekou'],2);
        	if($i%2==1)
        		$class="TableLine1";
        	else
        		$class="TableLine2";
        	$jine=round($rs_a[$i]['price']*$rs_a[$i]['zhekou']*($rs_a[$i]['num']-$rs_a[$i]['recnum']),2);
        	
?>
            <tr class=<?php echo $class?>>
            	<td><?php echo $rs_a[$i]['prodid']?></td>
                <td><?php echo $rs_a[$i]['prodname']?></td>
                <td align="center"><?php echo $rs_a[$i]['oldprodid']?></td>
                <td align="center"><?php echo $rs_a[$i]['proddanwei']?></td>
				<td align="center"><?php echo $rs_a[$i]['colorname']?></td>
                <td align="right" ><?php echo number_format($rs_a[$i]['price'],2,'.',',')?></td>
                <td align="right" id="oldnum_<?php echo $rs_a[$i]['id']?>"><?php echo $rs_a[$i]['num']?></td>
                <td align="right"><?php echo number_format($jine,2,'.',',')?></td>
                 <td align="right" id="recnum_<?php echo $rs_a[$i]['id']?>"><?php echo $rs_a[$i]['recnum']?></td>
                <?php if($rs_a[$i]['num']-$rs_a[$i]['recnum']!=0){?>
                <td align="center">
                <?php 
                
                $hascolor=returntablefield("product","productid", $rs_a[$i]['prodid'], "hascolor");
                if($hascolor=='是')
                {
                	
                	$sql="select sum(num) as allnum from buyplanmain_tmp_color where id=".$rs_a[$i]['id'];
                	$rs=$db->Execute($sql);
					$rs_c = $rs->GetArray();
					$jine=round($rs_a[$i]['price']*$rs_a[$i]['zhekou']*$rs_c[0]['allnum'],2);
					print "<input class='SmallStatic' readonly size=8 name='num_".$rs_a[$i]['id']."' id='num_".$rs_a[$i]['id']."' onkeydown='focusNext(event)' value='".intval($rs_c[0]['allnum'])."' onchange='CountRecJine(".$rs_a[$i]['id'].")'>";
					if($rs_c[0]['allnum']==$rs_a[$i]['num']-$rs_a[$i]['recnum'])
						print "<a href='javascript:PopColorInput(".$rs_a[$i]['id'].");' title='调整颜色分配'><img id='img_".$rs_a[$i]['id']."' src=$imgurl></a>";
					else
                		print "<a href='javascript:PopColorInput(".$rs_a[$i]['id'].");' title='还未进行颜色分配'><img id='img_".$rs_a[$i]['id']."' src=$imgurlgray></a>";
                }
                else
                	print "<input class='SmallInput' size=8 name='num_".$rs_a[$i]['id']."' id='num_".$rs_a[$i]['id']."' onkeydown='focusNext(event)' onKeyPress='return inputInteger(event)' value='".(intval($rs_a[$i]['num'])-intval($rs_a[$i]['recnum']))."' onchange='CountRecJine(".$rs_a[$i]['id'].")'>";
                ?>
                </td>
                <?php }else{?>
                <td align="center"></td>
                <?php }?>
                <td align="right"><div id="recjine_<?php echo $rs_a[$i]['id']?>"><?php echo number_format($jine,2,'.',',')?></div></td>
                <td align="center"><?php echo $rs_a[$i]['beizhu']?></td>
                <input type="hidden" id="price_<?php echo $rs_a[$i]['id']?>" name="price_<?php echo $rs_a[$i]['id']?>" value="<?php echo $rs_a[$i]['price']?>">
                <input type="hidden" id="zhekou_<?php echo $rs_a[$i]['id']?>" name="zhekou_<?php echo $rs_a[$i]['id']?>" value="<?php echo $rs_a[$i]['zhekou']?>">
                <input type="hidden"  name="recjine_<?php echo $rs_a[$i]['id']?>" value="<?php echo $jine?>"> 
                <input type="hidden" id="prodid_<?php echo $rs_a[$i]['id']?>" name="prodid_<?php echo $rs_a[$i]['id']?>" value="<?php echo $rs_a[$i]['prodid']?>"> 
                
            </tr>
            <?php 
        }
        ?>
        <tr class=TableHeader >
             <td align=center>总计</td>
             <td></td><td></td><td></td><td></td><td></td>
             <td align="right"><div id="allamount"><?php echo $allnum?></div></td>
             <td align="right"><div id="allmoney"><?php echo $allmoney?></div></td><td></td>
             <td align="right"><div id="allamount1"><?php echo $allnum1?></div></td>
             <td align="right"><div id="allmoney1"><?php echo $allmoney1?></div></td>
             <td></td>
        <?php
    } else {
        ?>
        <tr>
            <td colspan="9" style="height:50px" align="center">没有找到产品明细</td>
        </tr>
        <?php
    }
?>
<input type="hidden" name="allamount1" value=""> 
<input type="hidden" name="allmoney1" value=""> 
</table>
</div><br>
2、选择入库仓库 ：<select name="stock">
 <?php
 for($i=0;$i<sizeof($rs_b);$i++)
{
	print "<option value=".$rs_b[$i]['ROWID'].">".$rs_b[$i]['name']."</option>";
}
 ?>
 </select>
 &nbsp;运单号：<input type=text name='yundanhao' class='SmallInput' size=15>
 &nbsp;货运公司：<?php 
 	print_select_single_select("huoyungongsi", $value, "fahuotype", "id","name");
 ?>
<p align=center>
<input type=submit value=" 保存 " class="SmallButton" >
&nbsp;&nbsp;<input type=button value=" 返回 " class="SmallButton" onclick="location='buyplanmain_newai.php';"></p>
</form>
</body>
</html>