<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$rowid=$_GET['rowid'];
?>
<head>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/popup/js/popup.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/popup/js/popupclass.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>

<script type="text/javascript">


function submitFormCheck() 
{
	//��������У�����ʱ����
	for(var i=0;i<form1.elements.length;i++)
	{
		if(form1.elements[i].type=="text" && form1.elements[i].name.substring(0,7)=="recnum_")
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
			<?php if($_SESSION['numzero']==0){?>
			if(IsInteger(newamount)==false)
			{
				alert("��������������");
				form1.elements[i].select();
				return false;
			}
			<?php }else{?>
			if(IsFloat(newamount)==false)
			{
				alert("���������Ǹ�����");
				form1.elements[i].select();
				return false;
			}
			<?php }?>
		}
	}
	var boolflag=true;
	$("img", document.forms[0]).each(function()
	{	
		var imgsrc=this.src;
		if(imgsrc.indexOf('sepangray.gif')>-1)
		{
			alert('���в�Ʒδ������ɫ����');
			boolflag=false;
			return false;
		}
		
	});
	if(!boolflag)
		return boolflag;
	var allnum=document.getElementById("allamount1").innerText;
	if(parseInteger(allnum)==0)
	{
		alert('���γ���ϼ����������0');
		return false;
	}
	var sbtn=document.getElementsByName('submit');
	for(i=0;i<sbtn.length;i++)
	{
		sbtn[i].value='�ύ��';
		sbtn[i].disabled=true;
	}
	return true;
    
}
function CountRecJine(id)
{
	var num=document.getElementById("num_"+id).innerText;
	var recnum=form1.elements['recnum_'+id].value
	if(num>0 && Number(recnum)>Number(num))
	{
		alert("������"+(recnum)+"���ܴ���"+(num));
		form1.elements("recnum_"+id).value=num;
		return;
	}
	if(recnum<0)
	{
		alert("������������ڵ���0");
		form1.elements("recnum_"+id).value=num;
		return;
	}
	CountAllJine();
	
	
}
function CountAllJine()
{
	var allnum=0;
	for(var i=0;i<form1.elements.length;i++)
	{
		if(form1.elements[i].name.substring(0,7)=="recnum_")
		{
			allnum=eval(allnum+Number(form1.elements[i].value));
		}
	
	}
	
	document.getElementById("allamount1").innerText=allnum;

}
function PopColorInput(id)
{
	var num=$("#recnum_"+id).val();
	ShowIframe('��ɫ����','colorinput.php?tablename=stockoutmain_detail_color&id='+id+'&num='+num,600,200);
	
}
</script>
</head>
<?php 
	$storeid=returntablefield("stockoutmain", "billid", $rowid, "storeid");
	$storename= returntablefield("stock", "rowid", $storeid, "name");
	
?>
<body class=bodycolor topMargin=5 onload="CountAllJine();">
<table id=listtable align=center class=TableBlock width=100% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;����ȷ��&nbsp;���ֿ⣺<?php echo $storename?>��</TD></TR>
</table>
<div id="shoppingcart">
<form name="form1" method="post" action="stockoutmain_newai.php?action=savechuku&rowid=<?php echo $rowid?>" onsubmit="return submitFormCheck();">
<table align=center class=TableBlock width=100% border=0 id="table1">
<tr >
	<td align=center class=TableHeader>��Ʒ���</td>
    <td align=center class=TableHeader>��Ʒ����</td>
    <td align=center class=TableHeader>ԭ����</td>
    <td align=center class=TableHeader>��λ</td>
    <td align=center class=TableHeader>����</td>
    <td align=center class=TableHeader>��ǰ���</td>
    <td align=center class=TableHeader>���γ�����</td>
    <td align=center class=TableHeader>��ע</td>
</tr>

<?php 
	$sql = "select a.*,b.oldproductid from stockoutmain_detail a inner join product b on a.prodid=b.productid where mainrowid=".$rowid;
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
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
        	$ifkucun=returntablefield("product","productid",$rs_a[$i]['prodid'],"ifkucun");
			if($ifkucun=="��")
			{
				$color="black";
				$kucun="����";
			}
			else 
			{
	        	$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_a[$i]['prodid']."'";
				$rs = $db->Execute($sql);
				$rs_b = $rs->GetArray();
				if(count($rs_b)==1)
	        		$kucun=$rs_b[0]['num'];
	        	else
	        		$kucun=0;
	        	
	        	if($kucun<$rs_a[$i]['num'])
	        		$color="red";
	        	else
	        		$color="green";
			}
        	if($i%2==1)
        		$class="TableLine1";
        	else
        		$class="TableLine2";
        	
        	$hascolor=returntablefield("product","productid", $rs_a[$i]['prodid'], "hascolor");
?>
            <tr class=<?php echo $class?>>
            	<td align='center'><?php echo $rs_a[$i]['prodid']?></td>
                <td><?php echo $rs_a[$i]['prodname']?></td>
                <td><?php echo $rs_a[$i]['oldproductid']?></td>
                <td><?php echo $rs_a[$i]['proddanwei']?></td>
         
                <td align="right" id="num_<?php echo $rs_a[$i]['id']?>"><?php echo $rs_a[$i]['num']?></td>
                <td align="right"><font color=<?php echo $color?>><?php echo $kucun?></font></td>
                <td align="center">
                 <?php 
                
                
                if($hascolor=='��')
                {
                	$sql="select sum(num) as allnum from stockoutmain_detail_color where id=".$rs_a[$i]['id'];
                	$rs=$db->Execute($sql);
					$rs_c = $rs->GetArray();
					print "<input class='SmallStatic' readonly size=8 id='recnum_".$rs_a[$i]['id']."' name='recnum_".$rs_a[$i]['id']."' onkeydown='focusNext(event)'  value='".intval($rs_c[0]['allnum'])."' onchange='CountRecJine(".$rs_a[$i]['id'].")'>";
					if($rs_c[0]['allnum']!=0)
						print "<a href=\"javascript:PopColorInput(".$rs_a[$i]['id'].");\" title='������ɫ����'><img id='img_".$rs_a[$i]['id']."' src=$imgurl></a>";
					else
                		print "<a href=\"javascript:PopColorInput(".$rs_a[$i]['id'].");\" title='��δ������ɫ����'><img id='img_".$rs_a[$i]['id']."' src=$imgurlgray></a>";
                }
                else
                	print "<input class='SmallInput' size=8 id='recnum_".$rs_a[$i]['id']."' name='recnum_".$rs_a[$i]['id']."' onkeydown='focusNext(event)' onKeyPress='return inputFloat(event)' value='".$rs_a[$i]['num']."' onchange='CountRecJine(".$rs_a[$i]['id'].")'>";
                ?>
                </td>
                <td align="center"><?php echo $rs_a[$i]['beizhu']?></td>
                
            </tr>
            <?php 
        }
        ?>
        <tr class=TableHeader >
             <td align=center>�ܼ�</td>
             <td></td><td></td><td></td>
             <td align="right"><div id="allamount"><?php echo $allnum?></div></td>
             <td></td>
             <td align="center"><div id="allamount1"></div></td>
             <td></td>
        <?php
    }
?>
</table>
</div>
<p align=center>
<input type=button accesskey="p" name="print" value="ȡ��СƱ" class=SmallButton onClick="window.open('quhuodan_print.php?billid=<?php echo $rowid?>')" title="��ݼ�:ALT+p">
&nbsp;&nbsp;<input type=submit name='submit' value=" ���� " class="SmallButton" >
&nbsp;&nbsp;<input type=button value=" ���� " class="SmallButton" onclick="location='stockoutmain_newai.php';"></p>
</form>
</body>
</html>