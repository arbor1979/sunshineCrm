<?php
require_once('lib.inc.php');
$common_html=returnsystemlang('common_html');
$GLOBAL_SESSION=returnsession();
$ExecTimeBegin=getmicrotime();

if($_GET['action']=="dataDeal")			{
	//print_R($_POST);//exit;
	//print_R($_SESSION);
	$tablecode = returnDateAutoIncrement("tablecode","stockinmain");
	$tabledate = date("Y-m-d");
	//print $tablecode."<HR>";
	$USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
	$NICK_NAME = $_SESSION['SUNSHINE_USER_NICK_NAME'];
	$stockid = $_POST['stockid'];
	$supplyid = $_POST['supplyId'];
	$amt = $_POST['countAllAmt'];
	//$factpayamt = $_POST['factpayamt'];
	$amt = ereg_replace(',','',$amt);
	$amt = (int)$amt;
	$factpayamt = $amt;
	$state = $_POST['state'];
	$buyman = $_POST['buyman'];
	$intype = $_POST['intype'];
	//$chinaAmt = $_POST['chinaAmt'];
	//�ܽ��������ɵ������������ܺ�
	//$chinaAmt
	$state = '1';					$_POST['state'];
	$flowState = '-1';
	$intype = $_POST['intype'];
	$sendDate = date("Y-m-d");
	$stockinsign = "�����ڲɹ�������";

	$sql = "insert into stockinmain (
		tablecode,tabledate,stockinpersion,stockid,stockiplaceid,
		supplyid,amt,factpayamt,ROWID,user_id,
		state,intype,chinaAmt,buyman,todate,
		payamt,stockinsign,flowState
		)
		values (
		'$tablecode','$tabledate','$USER_NAME', '$stockid','',
		'$supplyid','$amt','$factpayamt','','$USER_NAME',
		'$state','$intype','$chinaAmt','$buyman','$sendDate',
		'','$stockinsign','$flowState')";
	$db->Execute($sql);
	$Insert_ID = $db->Insert_ID();

	$MainTableCode = $tablecode;
	//print $sql."<HR>";//exit;
	$amt = 0;

	for($i=1;$i<=$_POST['num'];$i++)		{
		$backnum = $_POST["backnum".$i];
		$backamt = $_POST["backamt".$i];
		$backallamt = $_POST["backallamt".$i];
		$tablecode = $_POST["0".$i];
		$DEPT_NAME = $_POST["1".$i];
		$tabledate = $_POST["2".$i];
		$productid = $_POST["3".$i];
		$productname = $_POST["4".$i];
		$standard = $_POST["5".$i];
		$mode = $_POST["6".$i];
		$plannum = $_POST["7".$i];
		$stockinfactnum = $_POST["8".$i];
		$price = $_POST["9".$i];
		$buyplandetailsign = $_POST["10".$i];
		$ROWID = $_POST["ROWID_".$i];

		//$ordercode = $_POST['ordercode'];

		//��ʱ��ת���ݲ�Ϊ0ʱ��ת���ɹ�������ϸ���ɹ�������
		if($backnum>0)		{

			//�õ��ò�Ʒ�ڿ�����������
			$sql = "select stocknum from store where productid='$productid'";
			$rs = $db->Execute($sql);
			$rs_a  = $rs->GetArray();
			$MyStockNum = $rs_a[0]['stocknum'];

			//�õ������е�һ��¼�Ľ��
			$price = (int)$price;
			$money = $price*$backnum;
			$amt += $money;

			//������ϸ��ļ�¼
			$sql = "insert into stockindetail (
			productid,plannum,stockinfactnum,price,money,
			mainrowid,standard,mode,ordercode,allnum,storenum
			) values (
			'$productid','$backnum','$stockinfactnum', '$price','$money',
			'$Insert_ID','$standard','$mode','$ordercode','$backnum','$MyStockNum')";
			$db->Execute($sql);
			//print $sql."<HR>";

			//�޸Ĳɹ�������ϸ������״̬Ϊ����ִ��
			$update = "update buyplandetail set dataState ='1',stockinfactnum=stockinfactnum+'$backnum' where ROWID='$ROWID'";
			$db->Execute($update);
			//print $update."<HR>";

			//�޸Ĳɹ��������������״̬Ϊ����ִ��
			$MAINROWID = returntablefield("buyplandetail","ROWID",$ROWID,"mainrowid");
			$update = "update buyplanmain set dataState ='1' where ROWID='$MAINROWID'";
			$db->Execute($update);
			//print $update."<HR>";

			//�ж���������������Ƿ���ȫִ��
			$udpate = "select DISTINCT mainrowid from buyplandetail where (dataState!='2' and stockinfactnum>=plannum) and mainrowid='$MAINROWID'";
			$rs = $db->Execute($udpate);
			//print $udpate."<HR>";
			$rs_a = $rs->GetArray();	//print_R($rs_a);
			$mainrowid = $rs_a[0]['mainrowid'];
			if($mainrowid!="")		{
				$update = "update buyplanmain set dataState ='2' where ROWID='$MAINROWID'";
				$db->Execute($update);
				//print $udpate."<HR>";
			}
		}



	}
	//����ɹ�������ϸ����������ת��ɣ�����dataStateΪ2��������ת��ʾδȫ��ִ�У�����Ϊ1
	$udpate = "update buyplandetail set dataState ='2' where stockinfactnum>=plannum";
	$db->Execute($udpate);
	//print $udpate."<HR>";



	/*�����ּ�����������¼��ʱ������
	//�����������ܽ�������
	$udpate = "update stockinmain set amt='$amt',factpayamt='$amt' where tablecode='$MainTableCode'";
	$rs = $db->Execute($udpate);
	if($rs->EOF)	{
		$rs = $db->Execute($udpate);
	}
	print $udpate."<HR>";exit;
	*/

	//�����ص�����״̬��ʾ
	print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/3/style.css\">";
	print_infor("��ⵥ�������ɣ�",$infor='trip',$return='');
	print "<br>\n";
	print "<div align=center>\n";
	print "  <input type=button accesskey='r' value=\"".$common_html['common_html']['close']."\" class=\"SmallButton\" onclick=\"javasrcipt:window.opener =null;window.close();\">\n";
	print "</div>\n";
	//print "<script>window.opener =null;window.close();</script>";
	//echo "<META HTTP-EQUIV=REFRESH CONTENT='2;URL=notchecked.php'>\n";
	exit;



}


?>




<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/style.css">



<div style="position:absolute;width:322;height:14;border:1 #707888 solid;overflow:hidden" id="pinghead">
	<div style="position:absolute;top:-1;left:0" id="pimg">
	</div>
</div>
<center>
<div  style="position:absolute;top:30;left:120;font-size:9pt;color:#f4f4f4" id="abc">
���ڴӷ�������ȡ���ݣ����Ե�........
</div>
</center>
<script>
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
</script>
<script>
var now1 =new Date()
StarTime_S=now1.getTime()
</script>





<script language=javascript>
var amtdot='0';
if  (amtdot==""||amtdot==null){
	amtdot=2;
	}
function mult_Select(rowId)
{
  var idStr=document.all("rowId_STR").value;

  if (idStr=="")
  {
  idStr=rowId+"|";
  }
  else
  {
  if(idStr.search(rowId)!=-1)
  {
     idStr=idStr.replace(rowId+"|","");
  }
   else
  idStr=idStr+rowId+"|";
  }
  //alert(idStr);
  document.all("rowId_STR").value=idStr;

}

function converUrlStr(urlStr) {
  var reArray = new Array(
    /[%]{1}/g,
    /[#]{1}/g,
    /[&]{1}/g,
    /[+]{1}/g,
    /[\\]{1}/g,
    /[=]{1}/g,
    /[?]{1}/g
  );
  var strArray = new Array(
    "%25",
    "%23",
    "%26",
    "%2B",
    "%2F",
    "%3D",
    "%3F"
  );
  var newStr = urlStr;
  for (var i = 0; i < reArray.length; i++) {
    var newStr = newStr.replace(reArray[i], strArray[i]);
  }
  return newStr;
}
function mult_Select(rowId)
{
  var idStr=document.all("rowId_STR").value;

  if (idStr=="")
  {
  idStr=rowId+"|";
  }
  else
  {
  if(idStr.search(rowId)!=-1)
  {
     idStr=idStr.replace(rowId+"|","");
  }
   else
  idStr=idStr+rowId+"|";
  }
  //alert(idStr);
  document.all("rowId_STR").value=idStr;

}
function value_empty(fld_must,fld_name)
{
   fld_str_obj=document.all(fld_must);
   name_str_obj=document.all(fld_name);
   if(fld_str_obj.value=="")
      return false;

   fld_array=fld_str_obj.value.split(",");
   name_array=name_str_obj.value.split(",");

   for(i=0;i<=fld_array.length;i++)
   {
     if(fld_array[i]=="")
        break;
     fld_obj=document.all(fld_array[i]);
     if(fld_obj.value=="")
     {
       alert("��"+name_array[i]+"������Ϊ�գ�");
       if(fld_obj.readonly=="")
         fld_obj.focus();
         return (true);
     }
   }
   return (false);
}

function find_id(theId,idStr)
{
	//alert("theId"+theId);
	//alert("idStr"+idStr);
   if(theId=="" || idStr=="")
      return false;
   if(idStr.search(theId)==-1)
      return false;
   return true;
}

function add(openurl)
{
   loc_x=300;
   loc_y=200;
window.open(openurl,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function secadd(openurl)
{
   loc_x=300;
   loc_y=200;
window.open(openurl,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
//�޸�--����
function order()
{
  var ModuleId=document.all("ModuleId").value;
  URL="./order.php?ModuleId="+ModuleId;
  loc_x=150;
  loc_y=100;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=700px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function selectMan(ModuleId)
{
	 var idStr=document.all("ID_STR").value;

   if(idStr=="")
   {
      alert("��ѡ��һ�");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("ֻ��ѡ��һ�");
      return false;
   }
  idStr=idStr.substring(0,idStr.indexOf(","));
  URL="./inflow/index/orderprod.php?ModuleId="+idStr;
  loc_x=150;
  loc_y=100;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=700px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function selectField(ModuleId)
{
	 var idStr=document.all("ID_STR").value;

   if(idStr=="")
   {
      alert("��ѡ��һ�");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("ֻ��ѡ��һ�");
      return false;
   }
  idStr=idStr.substring(0,idStr.indexOf(","));
  URL="./inflow/index/orderfield.php?FolderID="+idStr+"&ModuleId="+ModuleId;
  loc_x=150;
  loc_y=100;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=700px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function lookquery(ModuleId)
{
  URL="./module/combquery/index.php?ModuleId="+ModuleId;
  loc_x=400;
  loc_y=150;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:150px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=500px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function lookhelp(ModuleId,ModuleActionId)
{
  URL="./module/helpquery/index.php?ModuleId="+ModuleId+"&ModuleActionId="+ModuleActionId;
  loc_x=400;
  loc_y=150;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:150px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=500px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function data_out(ModuleId,ModuleName)
{
  URL="./export.php?ModuleId="+ModuleId+"&ModuleName="+ModuleName;
  loc_x=450;
  loc_y=250;
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=300px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function data_select(ModuleId,ModuleName)
{
  URL="./setSql.php";
  loc_x=450;
  loc_y=250;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=350px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function data_query(ModuleId,ModuleName)
{
  URL="./query.php?ModuleId="+ModuleId+"&ModuleName="+ModuleName;
  loc_x=450;
  loc_y=250;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:150px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=300px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function edit(openrul)
{
   var idStr=document.all("ID_STR").value;
   //var idRowid=idStr.substring(0,18)+",";
   var idStr2=idStr.substring(0,idStr.length-1);
   //alert(idStr2);
   if (document.getElementById("NotDel_"+idStr2)!=null){
   var NotDel=document.all("NotDel_"+idStr2).value;
   //alert(NotDel);
   if(NotDel=="1")
   {
      alert("ϵͳ���ò������޷��޸ģ�");
      return false;
   }
  }

   if(idStr=="")
   {
      alert("��ѡ��һ��༭��");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("ֻ��ѡ��һ��༭��");
      return false;
   }
   URL=openrul+"?rowid="+idStr;
   loc_x=300;
   loc_y=200;
window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function secedit(openrul)
{
   var idStr=document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("��ѡ��һ��༭��");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("ֻ��ѡ��һ��༭��");
      return false;
   }
   URL=openrul+"?rowid="+idStr;
   loc_x=100;
   loc_y=200;
window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=800px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function bathedit(openrul)
{
   var idStr=document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("��ѡ��һ��༭��");
      return false;
   }

   URL=openrul+"?rowid="+idStr;
   loc_x=300;
   loc_y=200;
window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function voucher(openrul)
{
   var idStr=document.all("rowId_STR").value;
   //  var idStr=document.all("rowId_STR").value;
   //var idRowid=idStr.substring(0,18)+",";
   alert(idStr);
   var tableStr=document.all("A_Table").value;
   if(idStr=="")
   {
      alert("��ѡ��һ������ƾ֤��");
      return false;
   }
   idStr=converUrlStr(idStr);
   //idStr=idStr.replace("+","%2B");
   //if(idStr.indexOf(",") < idStr.length-1)
   //{
   //   alert("ֻ��ѡ��һ������ƾ֤��");
   //   return false;
   //}
   alert(idStr);
   URL=openrul+"?rowid="+idStr+"&A_Table="+tableStr;
   alert(URL);
   loc_x=150;
   loc_y=100;

window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function editvoucher(openrul,rowid)
{
   var idRowid=rowid.substring(0,18)+",";
   URL=openrul+"?rowid="+idRowid;

   loc_x=150;
   loc_y=100;

window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=470px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function voucheredit(openrul)
{
   var idStr=document.all("ID_STR").value;
   //alert(idStr);
   var idRowid=idStr.substring(0,18)+",";
   var tableStr=document.all("A_Table").value;
   if(idStr=="")
   {
      alert("��ѡ��һ��༭ƾ֤��");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("ֻ��ѡ��һ��༭ƾ֤��");
      return false;
   }

   URL=openrul+"?rowid="+idRowid+"&A_Table="+tableStr;
 //  alert(tableStr);
   loc_x=150;
   loc_y=100;

window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=470px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function del()
{
   var idStr=document.all("ID_STR").value;
   var ModuleId=document.all("ModuleId").value;
   var userIdStr=document.all("userIdStr").value;
   var idStr2=idStr.substring(0,idStr.length-1);
   //alert(idStr2);
   if (document.getElementById("NotDel_"+idStr2)!=null){
   var NotDel=document.all("NotDel_"+idStr2).value;
   //alert(NotDel);
   if(NotDel=="1")
   {
      alert("ϵͳ���ò������޷�ɾ����");
      return false;
   }
  }
   if(idStr=="")
   {
      alert("������ѡ��һ��ɾ����");
      return false;
   }

   if(!window.confirm("ȷ��ɾ����"))
      return false;
   //alert(idStr);
   Qform1.qflag.value="delete";
   Qform1.deletevalue.value=idStr;
   Qform1.submit();
}
function refer()
{
   var idStr=document.all("ID_STR").value;
   if(idStr=="")
   {
      alert("������ѡ��һ������ύ��");
      return false;
   }
   if(!window.confirm("ȷ���ύ������"))
      return false;
   Qform1.qflag.value="refer";
   Qform1.deletevalue.value=idStr;
   Qform1.updateStateId.value="2";
   Qform1.submit();
}
function referPass()
{
   var idStr=document.all("ID_STR").value;
   if(idStr=="")
   {
      alert("������ѡ��һ�����������");
      return false;
   }
   if(!window.confirm("ȷ������ͨ����"))
      return false;
   Qform1.qflag.value="refer";
   Qform1.deletevalue.value=idStr;
   Qform1.updateStateId.value="3";
   Qform1.submit();
}
function referReject()
{
   var idStr=document.all("ID_STR").value;
   if(idStr=="")
   {
      alert("������ѡ��һ����в��أ�");
      return false;
   }
   if(!window.confirm("ȷ������������"))
      return false;
   Qform1.qflag.value="refer";
   Qform1.deletevalue.value=idStr;
   Qform1.updateStateId.value="5";
   Qform1.submit();
}
function delvou()
{
   var idStr=document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("������ѡ��һ��ɾ����");
      return false;
   }

   if(!window.confirm("ȷ��ɾ����"))
      return false;

   Qform1.qflag.value="deleteandvoucher";
   Qform1.deletevalue.value=idRowid;
   Qform1.submit();
}
function query()
{
   Qform1.qflag.value="query";
   //alert("11111111111");
   Qform1.submit();
}
function addnew()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="addnew";
   form1.submit();
}

function balance()
{
   //if(value_empty("GRP_NO,UNIT_ID,","FLD_NAME_STR"))
     //return (false);

   form1.flag.value="balance";
   form1.submit();
}
function update()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);

   form1.flag.value="update";
   form1.submit();
}
function updateDelete()
{

   form1.flag.value="deleteLev";

   form1.submit();
}
function delLeverList()
{
	//alert("����");
	var idStr=parent.dept_main.form1.ID_STR.value;

	if (idStr==null){
		idStr="";
		}
  if (idStr=="") {
  	alert("��ѡ��Ҫɾ�������ݣ�");
  	return;
  	}
   form1.ID_STR.value=idStr;
   form1.flag.value="deleteLevList";
   form1.submit();
}
function updatevou()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   //alert("123");
   form1.flag.value="updatevoucher";
   form1.submit();
}

function update2()
{

   form1.flag.value="updatevoucher";
   //alert("123");
   form1.submit();
}
function update3()
{
   form1.flag.value="editvoucher";
   //alert("123");
   form1.submit();
}
var theDefaultColor="#FFFFFF";
var thePointerColor="#D9E8FF";
var theMarkColor="#003FBF";
function setKeyId(){
	document.all("keyId").value=event.keyCode;
}
function retKeyId(){
	document.all("keyId").value="";
}

function setPointer(theRow, theId, theAction)
{
	 //var theCells = null;
   var idStr=document.all("ID_STR").value;
   theId+=",";

   var keyId=document.all("keyId").value;


   	if (keyId == 16){//shift�� ����ѡ��

    }else if (keyId == 17){//ctrl��  ������ѡ
    	  if(theAction=="over" && !find_id(theId,idStr)){
      //theRow.style.background=thePointerColor;
    }
   else if(theAction=="out" && !find_id(theId,idStr)){
      theRow.style.background=theDefaultColor;
    }
   else if(theAction=="click")
   {
      if(find_id(theId,idStr))
      {
      	//alert("���");
         idStr=idStr.replace(theId,"");
         theRow.style.background=thePointerColor;
         theRow.style.color="#000000";
      }
      else
      {
        //alert("�����");
         if(idStr!=""&&document.all("TR"+idStr.replace(",",""))!=null)
         {
         	//alert("�Ƿ�ѡ����ɫ");
            //document.all("TR"+idStr.replace(",","")).style.background=theDefaultColor;
            //document.all("TR"+idStr.replace(",","")).style.color="#000000";
         }
         idStr+=theId;
         theRow.style.background=theMarkColor;
         theRow.style.color="#FFFFFF";
      }
      document.all("ID_STR").value=idStr;
    }
    }
    else{

    	  if(theAction=="over" && theId!=idStr && !find_id(theId,idStr) ){
      //theRow.style.background=thePointerColor;
    }
   else if(theAction=="out" && theId!=idStr && !find_id(theId,idStr) ){
      //theRow.style.background=theDefaultColor;
    }
   else if(theAction=="click")
   {
    	if(theId==idStr)
      {

         idStr="";

         theRow.style.background=thePointerColor;
         theRow.style.color="#000000";
      }
      else
      {

         if(idStr!=""&&document.all("TR"+idStr.replace(",",""))!=null)
         {

           document.all("TR"+idStr.replace(",","")).style.background=theDefaultColor;
           document.all("TR"+idStr.replace(",","")).style.color="#000000";
         }
         idStr=theId;
         theRow.style.background=theMarkColor;
         theRow.style.color="#FFFFFF";
      }

	  //���idStr����","�� -- ����
	  /*
	  if (idStr.charAt(idStr.length-1)== ',')
	  {
		  alert("fda");
		  idStr = idStr.substr(0, idStr.length-1);
	  }*/
      document.all("ID_STR").value=idStr;
    }
    	}

}

function query_code(field)
{
  //alert(field);
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="./query/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_user(field)
{
  init_value=document.all(field).value;
  code="1";
  table="user";
  URL="./queryuser/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_userid(field)
{
  init_value=document.all(field).value;
  code="1";
  table="user";
  URL="./queryuserid/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_bath(field)
{
  //alert(field);
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="./bathquery/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_two(field)
{
  //alert(field);
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="./lever/code/query/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_acct(field)
{
  //alert(field);
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="./queryacct/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_ongrpno(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="./ongrpnoquery/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  //URL="./ongrpnoquery/index.php?FIELD="+field;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_ongrpno_exps(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="./ongrpnoqueryexps/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  //URL="./ongrpnoquery/index.php?FIELD="+field;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}


function query_pay(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="./payquery/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_date(field)
{
  init_value=field;
  URL="../../Framework/sms_index/calendar_begin.php?datetime="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:205px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
var fld_name_display="";
function set_explain(field,BURSAR_ATTR)
{
  document.all(field).style.display="";
  if(fld_name_display!="")
  document.all(fld_name_display).style.display="none";
  fld_name_display=field;
  //alert(BURSAR_ATTR);
  if (BURSAR_ATTR.length>0)
         {
         var cust=BURSAR_ATTR.substring(0,1);//��λ
         custfield=field+"1";
         if (cust==1)
         {
         document.all(custfield).style.display="";
         }
         else
         {
         document.all(custfield).style.display="none";
         }

         var dept=BURSAR_ATTR.substring(1,2);//����
         deptfield=field+"2";
         if (dept==1)
         {
         document.all(deptfield).style.display="";
         }
         else
         {
         document.all(deptfield).style.display="none";
         }

         var empl=BURSAR_ATTR.substring(2,3);//��Ա
         emplfield=field+"3";
         if (empl==1)
         {
         document.all(emplfield).style.display="";
         }
         else
         {
         document.all(emplfield).style.display="none";
         }

         var class1=BURSAR_ATTR.substring(3,4);//ͳ��
         class1field=field+"4";
         if (class1==1)
         {
         document.all(class1field).style.display="";
         }
         else
         {
         document.all(class1field).style.display="none";
         }
         var class2=BURSAR_ATTR.substring(4,5);//��Ŀ
         class2field=field+"5";
         if (class2==1)
         {
         document.all(class2field).style.display="";
         }
         else
         {
         document.all(class2field).style.display="none";
         }
         }

}
function query_voucher(field,ModuleId,row,typeid)
{
  init_value=document.all(field).value;
  URL="./voucher/index.php?FIELDNAME="+field+"&voucher="+ModuleId+"&INIT_VALUE="+init_value+"&row="+row+"&typeid="+typeid;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function balance_query_code(field,grp_no)
{
  grp_no=document.all(grp_no).value;
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;

  URL="./balancequery/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value+"&GRP_NO="+grp_no;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

//verify for netscape/mozilla
var isNS4 = (navigator.appName=="Netscape")?1:0;

function check_input_num(num_type)
{
  if(num_type=="NUMBER")
  {
     if(!isNS4)
     {
     	 if((event.keyCode < 48 || event.keyCode > 57)&&event.keyCode != 46)
     	    event.returnValue = false;
     }
     else
     {
     	 if((event.which < 48 || event.which > 57)&&event.keyCode != 46)
     	    return false;
     }
  }
  else if(num_type=="MONEY")
  {
     if(!isNS4)
     {
     	 if((event.keyCode < 45 || event.keyCode > 57)&&event.keyCode != 47)
     	    event.returnValue = false;
     }
     else
     {
     	 if((event.which < 45 || event.which > 57)&&event.which != 47)
     	    return false;
     }
  }
}

function  ForDight(Dight,How)
{
           Dight  =  Math.round  (Dight*Math.pow(10,How))/Math.pow(10,How);
           return  Dight;
}

function check_value(field)
{
   var obj=document.all(field);
   if(obj.value=="")
      return;

   addMoneyStr(field);

}

function  init_value(field)
{
   var obj=document.all(field);
   if (obj.value=="")
      return;

   re=/,/g;
   obj.value=obj.value.replace(re,"");
}
function uploadFromFile() {
  openURL="./fileupload/index.php";
  loc_x=300;
  loc_y=200;
  window.open(openurl,"fileupload","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function detailclick(idRowid,ModuleId)
{
   URL="./detail.php?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=254;
   loc_y=162;
  window.showModalDialog(URL,self,"edge:raised;scroll:1;status:1;help:1;resizable:1;dialogWidth:870px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function datadetailclick(idRowid,ModuleId)
{
	 var stockName=document.Qform1("stockName").value;
	 var fromdata=document.Qform1("fromdata").value;
	 var enddata=document.Qform1("enddata").value;

   URL="./datadetail.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&stockName="+stockName+"&fromdata="+fromdata+"&enddata="+enddata;
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function datadetail(State)
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("������ѡ��һ��鿴��ϸ��");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);

   var ModuleId=document.all("ModuleId").value;
   var stockName=document.Qform1("stockName").value;
	 var fromdata=document.Qform1("fromdata").value;
	 var enddata=document.Qform1("enddata").value;
   URL="./datadetail.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&stockName="+stockName+"&fromdata="+fromdata+"&enddata="+enddata+"&State="+State;
   loc_x=100;
   loc_y=100;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=400px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function datadetailchart(chartState)
{
   var idRowid=document.all("ID_STR").value;
   if (chartState=="1"){
      if(idRowid=="")
      {
      alert("������ѡ��һ�");
      return false;
      }
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   var ModuleId=document.all("ModuleId").value;
	 var fromdata=document.Qform1("fromdata").value;
	 var enddata=document.Qform1("enddata").value;
	 var groupByStr=document.Qform1("groupByStr").value;
	 var flowState=document.Qform1("flowState").value;
	 var dataState=document.Qform1("dataState").value;

   URL="./setSql6.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&groupByStr="+groupByStr+"&fromdata="+fromdata+"&enddata="+enddata+"&flowState="+flowState+"&dataState="+dataState+"&chartState="+chartState;//
   loc_x=254;
   loc_y=162;
   //alert(URL);
   window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
   //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function dataPrint()
{
   var idRowid=document.all("ID_STR").value;

      if(idRowid=="")
      {
      alert("������ѡ��һ�");
      return false;
      }

   idRowid=idRowid.substring(0,idRowid.length-1);
   var ModuleId=document.all("ModuleId").value;

   URL="./setSqlPrint.php?rowid="+idRowid+"&ModuleId="+ModuleId;//
   loc_x=254;
   loc_y=162;
   //alert(URL);
   //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
   window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function datachart()
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("������ѡ��һ��鿴��ϸ��");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);

   var ModuleId=document.all("ModuleId").value;
   var stockName=document.Qform1("stockName").value;
	 var fromdata=document.Qform1("fromdata").value;
	 var enddata=document.Qform1("enddata").value;
   URL="./datachart.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&stockName="+stockName+"&fromdata="+fromdata+"&enddata="+enddata;
   loc_x=254;
   loc_y=162;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:770px;dialogHeight:500px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=750px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function detail()
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("������ѡ��һ��鿴��ϸ��");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);

   var ModuleId=document.all("ModuleId").value;
   URL="./detail.php?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=154;
   loc_y=162;
  window.showModalDialog(URL,self,"edge:raised;scroll:1;status:1;help:1;resizable:1;dialogWidth:870px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=850px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function detailsec(ModuleId)
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("������ѡ��һ��鿴��ϸ��");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   URL="./detailsec.php?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=10;
   loc_y=10;
   //alert(URL);
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function flow()
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("������ѡ��һ��鿴��");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);

   var ModuleId=document.all("ModuleId").value;
   URL="./flowdetail.php?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function backStock()
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("������ѡ��һ������˻���");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);

   var ModuleId=document.all("ModuleId").value;
   URL="./back.php?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=750px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function printDetail(openrul)
{
   var idStr=document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("��ѡ��һ����д�ӡ��");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("ֻ��ѡ��һ����д�ӡ��");
      return false;
   }
   URL=openrul+"?rowid="+idStr;
   loc_x=300;
   loc_y=200;
   //window.showModalDialog(URL,self,"edge:raised;scroll:1;status:1;help:1;resizable:1;dialogWidth:770px;dialogHeight:500px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
   window.open(URL,"","menubar=1,toolbar=1,status=1,scrollbars=1,resizable=1,width=700px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function secorderInput(thisBut){
if (event.keyCode == 13)
{
secorderquery();
}
thisBut.onfocus();
}
function queryInput(thisBut){
if (event.keyCode == 13)
{
query();
}
thisBut.onfocus();
}

 function addMoneyStr(moneyField){

 	  if (document.form1(moneyField).value.indexOf(",")>=0){
 	  	return;
 	  	}

   if(document.form1(moneyField).value=="")
      return;
    if(document.form1(moneyField).value.substring(0,1)=="-")
   {
   	   op_Money="-";
   	   document.form1(moneyField).value=document.form1(moneyField).value.substring(1,document.form1(moneyField).value.length);
   }
   else
       op_Money="";

    val_Money=parseFloat(document.form1(moneyField).value);
    document.form1(moneyField).value=ForDight(val_Money,amtdot);
    var value_array_Money=document.form1(moneyField).value.split(".");

   start_Money=0;
   len_Money=0;
   val_int_Money="";

   while(1)
   {
   	  if((value_array_Money[0].length-start_Money)%3==0)
   	     len_Money=3;
   	  else
   	  	 len_Money=value_array_Money[0].length%3;

      if(val_int_Money=="")
         val_int_Money=value_array_Money[0].substring(start_Money,start_Money+len_Money);
      else
         val_int_Money=val_int_Money+","+value_array_Money[0].substring(start_Money,start_Money+len_Money);
   	  start_Money=len_Money+start_Money;

   	  if(start_Money>=value_array_Money[0].length)
   	     break;
   }
   if(val_int_Money!="")
      value_array_Money[0]=val_int_Money;

   if(value_array_Money.length==1)
   	  value_array_Money[1]="00";
   else if(value_array_Money.length==amtdot)
   {
   	  if(value_array_Money[1].length==0)
   	    value_array_Money[1]="00";
   	  else if(value_array_Money[1].length==1)
   	    value_array_Money[1]=value_array_Money[1]+"0";
   	  else if(value_array_Money[1].length>=amtdot)
   	    value_array_Money[1]=value_array_Money[1].substr(0,amtdot);
   }
   document.form1(moneyField).value=op_Money+value_array_Money[0]+"."+value_array_Money[1];
 	}
 	function detailFlow(dataState)
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("������ѡ��һ��鿴��ϸ��");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);

   var ModuleId=document.all("ModuleId").value;
   URL="./detailflow.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&dataState="+dataState;
   loc_x=100;
   loc_y=100;
  window.showModalDialog(URL,self,"edge:raised;scroll:1;status:1;help:1;resizable:1;dialogWidth:970px;dialogHeight:500px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=850px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_stock(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  ModuleId=document.all("ModuleId").value;
  URL="./querystock/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value+"&ModuleId="+ModuleId;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:750px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

	function editSate(StateId)
{
   var idStr=document.all("ID_STR").value;
   var ModuleId=document.all("ModuleId").value;


   if(idStr=="")
   {
      alert("��ѡ��һ��༭��");
      return false;
   }
   URL="./changestate/index.php?rowid="+idStr+"&ModuleId="+ModuleId+"&StateId="+StateId;
      //   engserv\module\code\changestate
   //URL=openrul+"?rowid="+idStr+"&ModuleId="+ModuleId;
   loc_x=300;
   loc_y=200;
  // alert(URL);
   //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");

window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_supply(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  ModuleId=document.all("ModuleId").value;
  URL="../../Framework/frame_depart_notify.php?title=ѡ���¼&tablename=supply&fieldid=supplyid&fieldname=supplyname&field="+field+"&field2="+field+"_NAME&INIT_VALUE="+init_value+"";
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:750px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}


var imgpath = "/images/images/";


function toggleSetting(id) {
	var div = document.all[id];
	var img = document.all[id+"_tgimg"];
	//var stockInitButton = document.all["stockInitButton"];
	if (div.style.display == "none") {
		div.style.display = "block";
		img.src = imgpath + "minus.gif";
		//stockInitButton.style.display = "block";
	}
	else {
		div.style.display = "none";
		//stockInitButton.style.display = "none";
		img.src = imgpath + "plus.gif";
	}
}

function check_value2(field)
{
  //alert(field);
  init_value=document.all(field).value;
  ModuleId=document.all("ModuleId").value;
  Add_table=document.all("Add_table").value;
  if (init_value==null||init_value==""){
  alert("��������Ҫ��֤������");
  return false;
  	}
  URL="./checkvalue/index.php?ModuleId="+ModuleId+"&Add_table="+Add_table+"&INIT_VALUE="+init_value+"&field="+field;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
</script>


<script language=javascript>

var amtdot='0';
if  (amtdot==""||amtdot==null){
	amtdot=2;
	}
var numdot='0';
if  (numdot==""||numdot==null){
	numdot=2;
	}
var outType='1';
var numdotValue="";
var amtdotValue="";
//alert("numdot="+numdot);
for (i=0;i<numdot;i++){
	numdotValue=numdotValue+"0";
	}
for (i=0;i<amtdot;i++){
	amtdotValue=amtdotValue+"0";
	}
//alert("numdotValue="+numdotValue);
 var tmpStr="";
 var temInt=1;
 var standtmpStr="";
 var dataTemStr="";
 var fieldNum2="";
  function refreshClienArea() {
    var tempStr=hiddenDataId.innerHTML.replace("style=\"DISPLAY:","");
    //alert(tempStr);
    var repStr="value="+temInt+" name=dataNo> <B>"+temInt+"</B>";
    tempStr=tempStr.replace("value=1 name=dataNo> <B>1</B>",repStr);
    tempStr=tempStr.replace("none\"","");
    var repStr2="_wxd_"+temInt;//
    tempStr=tempStr.replace("_wxd_1",repStr2);
    var repStr3="_wxdid_"+temInt;//
    tempStr=tempStr.replace("_wxdid_1",repStr3);
    var repStr5="_wxdnum_"+temInt;//
    tempStr=tempStr.replace("_wxdnum_1",repStr5);
    var repStr6="_wxdrate_"+temInt;//
    tempStr=tempStr.replace("_wxdrate_1",repStr6);
    var repStr4="dataClick('"+temInt+"')";//
    tempStr=tempStr.replace("dataClick('1')",repStr4);
    var sStr=/dxw/g;
    tempStr=tempStr.replace(sStr,temInt);
    //alert(tempStr);
    if (tmpStr=="")
    {
    standtmpStr=tempStr;
    tmpStr = tempStr;
    }else{
    tmpStr += tempStr;
    }
    //alert(tmpStr);
    clientArea.innerHTML = tmpStr;
  }
  function deleteClienArea() {
  	var dataCount=document.form1("dataCount").value;
  	//alert("dataCount:"+dataCount);
    if (tmpStr=="")
    {
     temInt=1;
     alert("�޷�ɾ����");
     return;
    }else{
    var cuntMon=0;
    for (var i=1;i<=temInt;i++)
    {
    	if (document.form1("money_"+i).value!=""&&document.form1("money_"+i).value!=null){
    	cuntMon=cuntMon+parseFloat(document.form1("money_"+i).value);
        }
    }
    if (cuntMon!=0&&cuntMon!=null){
    document.form1("amt").value=cuntMon;
    }
    tmpStr = tmpStr.substring(0,tmpStr.length-standtmpStr.length);
    document.form1("dataCount").value=parseFloat(dataCount)-1;
    }
    clientArea.innerHTML = tmpStr;
  }
  function deleteUpdateClienArea() {
  	temInt--;

    if (tmpStr=="")
    {
    	if (dataTemStr!="")
    	{

         dataId.innerHTML = dataTemStr.substring(0,dataTemStr.lastIndexOf("<TABLE"));
         var intDel=dataId.innerHTML.substring(dataId.innerHTML.lastIndexOf("money_")+6,dataId.innerHTML.lastIndexOf("money_")+7)
        var cuntMon=0;
    for (var i=1;i<=parseInt(intDel);i++)
    {

    	if (document.form1("money_"+i).value!=""&&document.form1("money_"+i).value!=null){
    	cuntMon=cuntMon+parseFloat(document.form1("money_"+i).value);
        }
    }
    if (cuntMon!=0&&cuntMon!=null){
    document.form1("amt").value=cuntMon;
    }
        }
    }else{


    tmpStr = tmpStr.substring(0,tmpStr.length-standtmpStr.length);
    clientArea.innerHTML = tmpStr;
    var intDel=clientArea.innerHTML.substring(clientArea.innerHTML.lastIndexOf("money_")+6,clientArea.innerHTML.lastIndexOf("money_")+7)
        var cuntMon=0;
    for (var i=1;i<=parseInt(intDel);i++)
    {

    	if (document.form1("money_"+i).value!=""&&document.form1("money_"+i).value!=null){
    	cuntMon=cuntMon+parseFloat(document.form1("money_"+i).value);
        }
    }
    if (cuntMon!=0&&cuntMon!=null){
    document.form1("amt").value=cuntMon;
    }
    }
  }
  function insertRow() {
  if (event.keyCode == 10){
    tmpStr = clientArea.innerHTML;

    temInt++;
    refreshClienArea();
    }
  }
  function dataQuery(fieldname,moduleId,countStr) {
  if (event.keyCode == 10){
    var dataStr=dataId.innerHTML;
    var hasInt1=dataStr.lastIndexOf("name=dataNo")-2;
    var hasInt2=dataStr.lastIndexOf("name=dataNo")-1;
    var hasInt=dataStr.substring(dataStr.lastIndexOf("name=dataNo")-2,dataStr.lastIndexOf("name=dataNo")-1)
    //alert(hasInt);
    if (temInt==1){
       if (hasInt>temInt){
       temInt=hasInt;
       }
    }
    temInt++;
    tmpStr = clientArea.innerHTML;
    refreshClienArea();
  }else if (event.keyCode == 13||event.keyCode == 0){
  var cliNo=document.form1("hidDataNo").value;
  var supplyId="";
  var stockId="";
  var typeId="0";
  if (document.getElementById("supplyid")!=null){
  supplyId=document.form1("supplyid").value;
  if (supplyId==null||supplyId==""){
  	alert("����ȷ����λ");
  	return;
  	}
  }
  if (document.getElementById("intype")!=null){
  typeId=document.all("intype").value;
  }
  if (document.getElementById("outtype")!=null){
  typeId=document.all("outtype").value;
  }
  if (document.getElementById("stockId")!=null){
  stockId=document.all("stockId").value;
  }
  //var stockId=document.all("stockId").value;

  var fieldValue=document.form1("id_"+fieldname+"_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.form1("id_"+fieldname+"_id"+"_"+countStr+"_wxdid_"+cliNo).value;

  URL="./dataquery/index.php?moduleId="+moduleId+"&fieldname="+fieldname+"&fieldValue="+fieldValue+"&codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId+"&stockId="+stockId+"&typeId="+typeId;
   loc_x=0;
   loc_y=0;
   //alert(URL);
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:1000px;dialogHeight:500px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");

  }
  }
  function orderQuery(fieldname,moduleId,countStr) {
  if (event.keyCode == 10){
    var dataStr=dataId.innerHTML;
    var hasInt1=dataStr.lastIndexOf("name=dataNo")-2;
    var hasInt2=dataStr.lastIndexOf("name=dataNo")-1;
    var hasInt=dataStr.substring(dataStr.lastIndexOf("name=dataNo")-2,dataStr.lastIndexOf("name=dataNo")-1)
    //alert(hasInt);
    if (temInt==1){
       if (hasInt>temInt){
       temInt=hasInt;
       }
    }
    temInt++;
    tmpStr = clientArea.innerHTML;
    refreshClienArea();
  }else if (event.keyCode == 13){
  var cliNo=document.form1("hidDataNo").value;
  var fieldValue=document.form1("id_"+fieldname+"_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.form1("id_"+fieldname+"_id"+"_"+countStr+"_wxdid_"+cliNo).value;
  var supplyId=document.form1("supplyid").value;
  var tableDate=document.form1("tabledate").value;
  URL="./orderquery/index.php?moduleId="+moduleId+"&fieldname="+fieldname+"&fieldValue="+fieldValue+"&codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId+"&tableDate="+tableDate;
   loc_x=354;
   loc_y=262;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  }
  }
  function amtQuery(fieldname,moduleId,countStr) {
  if (event.keyCode == 10){
    var dataStr=dataId.innerHTML;
    var hasInt1=dataStr.lastIndexOf("name=dataNo")-2;
    var hasInt2=dataStr.lastIndexOf("name=dataNo")-1;
    var hasInt=dataStr.substring(dataStr.lastIndexOf("name=dataNo")-2,dataStr.lastIndexOf("name=dataNo")-1)
    if (temInt==1){
       if (hasInt>temInt){
       temInt=hasInt;
       }
    }
    temInt++;
    tmpStr = clientArea.innerHTML;
    refreshClienArea();
  }else if (event.keyCode == 13||event.keyCode == 0){
  var cliNo=document.form1("hidDataNo").value;
  var supplyId=document.form1("supplyid").value;
  var fieldValue=document.form1("id_"+fieldname+"_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.form1("id_"+fieldname+"_id"+"_"+countStr+"_wxdid_"+cliNo).value;
  URL="./amtquery/index.php?moduleId="+moduleId+"&fieldname="+fieldname+"&fieldValue="+fieldValue+"&codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId;
   loc_x=354;
   loc_y=262;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  }
  }
  function clickInsertRow() {
    var dataStr=dataId.innerHTML;
    var hasInt1=dataStr.lastIndexOf("name=dataNo")-2;
    var hasInt2=dataStr.lastIndexOf("name=dataNo")-1;
    var hasInt=dataStr.substring(dataStr.lastIndexOf("name=dataNo")-2,dataStr.lastIndexOf("name=dataNo")-1)
    //alert("hasInt:"+hasInt);
    //alert("dataStr:"+dataStr);
    if (temInt==1){
       if (hasInt>temInt){
       temInt=hasInt;
       }
    }
    temInt++;

    var dataCount=document.form1("dataCount").value;
    //alert("33dataCount:"+dataCount);
    //alert("dataCount:"+dataCount);
    var addDataCount=parseFloat(dataCount)+1;
    temInt=addDataCount;
    dataCount=addDataCount.toString();
    //document.form1("dataCount").value=addDataCount.toString();
    //dataCount=document.form1("dataCount").value;
    //alert("33dataCount:"+dataCount);
    document.form1("dataCount").value=dataCount;
    tmpStr = clientArea.innerHTML;
    //alert("tmpStr:"+tmpStr);
    refreshClienArea();
  }
  function clickDeleteRow() {
    tmpStr = clientArea.innerHTML;
    temInt--;
    deleteClienArea();
  }
function secaddnew()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="secaddnew";
   form1.submit();
}
function secupdate()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="secupdate";
   form1.submit();
}
function secamtaddnew()
{
   var i=0;
   var tableName=document.all.form1.Add_table.value
   var idValue="id_stockinid_id_1_wxdid_";
   if (tableName=="getmain")
   {
   idValue="id_stockoutid_id_1_wxdid_";
   }
   var idValue2="thispaymoney_";

   var dataArea=dataId.innerHTML;
   var dataClient=clientArea.innerHTML;
   var dataLast="";
   if (tableName=="getmain")
   {
   dataLast=dataClient.lastIndexOf("id_stockoutid_id_1_wxdid");
   }else{
   dataLast=dataClient.lastIndexOf("id_stockinid_id_1_wxdid");
   }
   var dataLast2=dataClient.indexOf("thispaymoney_");

   var int1=-1;
   if (tableName=="getmain")
   {
   int1=dataClient.substring(dataLast+25,dataLast+26);
   }else{
   int1=dataClient.substring(dataLast+24,dataLast+25);
   }
   var int2=dataClient.substring(dataLast2+13,dataLast2+14);
   if(dataLast==-1){
   	int1=1;
   	}
   var value1;
   var value2;
   var value3=0;
   for (i=1;i<=int1;i++){
   if (tableName=="getmain")
   {
   idValue=idValue.substring(0,25)+i;
   }else{
   idValue=idValue.substring(0,24)+i;
   }
   idValue2=idValue2.substring(0,13)+i;
   if (i==1){
   if (tableName=="getmain")
   {
   value1=document.all.form1.id_stockoutid_id_1_wxdid_1.value;
   }else{
   value1=document.all.form1.id_stockinid_id_1_wxdid_1.value;
   }
   }else{
   value1=document.all(idValue).value;
   }
   if (i==1){
   value2=document.all.form1.thispaymoney_1.value;
   }else{
   value2=document.all(idValue2).value;
   }
       if (value1==null||value1==""){
   	alert("���ڵ�"+i+"�е�1��ͨ��˫��ѡ����Ʒ��Ϣ");
   	return;
   	}
      if (value2==null||value2==""){
   	alert("���ڵ�"+i+"�е�4��������Ʒ����");
   	return;
   	}
   	var sStr=/,/g;
         value2=value2.replace(sStr,"");
     value3=value3+parseFloat(value2);
   }
   if (document.getElementById("factgetamt")!=null||document.getElementById("checkamt")!=null){
   	var checkamt=document.all("checkamt").value;
   	if (checkamt==null||checkamt==""){
   		checkamt="0";
   		}
   	if (parseFloat(value3)-parseFloat(checkamt)<0){
   		alert("�����������ܽ������º�����");
   		return;
   		}
   	document.all("factgetamt").value=parseFloat(value3)-parseFloat(checkamt);

  }



   document.all.form1.paymoney.value=value3;
   form1.flag.value="secorderaddnew";
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.submit();
}
function secamtupdate()
{
	 var i=0;
   var tableName=document.all("Update_table").value;
   var dataCount=document.all("dataCount").value;
   //alert(dataCount);
   var idValue="id_stockinid_id_1_wxdid_";
   if (tableName=="getmain")
   {
   idValue="id_stockoutid_id_1_wxdid_";
   }
   var idValue2="thispaymoney_";

   var dataArea=dataId.innerHTML;
   var dataClient=clientArea.innerHTML;
   var dataLast="";
   if (tableName=="getmain")
   {
   dataLast=dataClient.lastIndexOf("id_stockoutid_id_1_wxdid");
   }else{
   dataLast=dataClient.lastIndexOf("id_stockinid_id_1_wxdid");
   }
   var dataLast2=dataClient.indexOf("thispaymoney_");


   var int2=dataClient.substring(dataLast2+13,dataLast2+14);

   var value1;
   var value2;
   var value3=0;

   for (i=1;i<=dataCount;i++){
   if (tableName=="getmain")
   {
   idValue=idValue.substring(0,25)+i;
   }else{
   idValue=idValue.substring(0,24)+i;
   }
   //alert("idValue"+idValue);
   idValue2=idValue2.substring(0,13)+i;
   if (i==1){
   if (tableName=="getmain")
   {
   value1=document.all.form1.id_stockoutid_id_1_wxdid_1.value;
   }else{
   value1=document.all.form1.id_stockinid_id_1_wxdid_1.value;
   }
   }else{
   value1=document.all(idValue).value;
   }
   //alert("value1"+value1);
   if (i==1){
   value2=document.all.form1.thispaymoney_1.value;
   }else{
   value2=document.all(idValue2).value;
   }
   //alert("value2"+value2);
       if (value1==null||value1==""){
   	alert("���ڵ�"+i+"�е�1��ͨ��˫��ѡ����Ʒ��Ϣ");
   	return;
   	}
      if (value2==null||value2==""){
   	alert("���ڵ�"+i+"�е�4��������");
   	return;
   	}
   	var sStr=/,/g;
         value2=value2.replace(sStr,"");
     value3=value3+parseFloat(value2);
   }
   if (document.getElementById("factgetamt")!=null||document.getElementById("checkamt")!=null){
   	var checkamt=document.all("checkamt").value;
   	if (checkamt==null||checkamt==""){
   		checkamt="0";
   		}
   	if (parseFloat(value3)-parseFloat(checkamt)<0){
   		alert("�����������ܽ������º�����");
   		return;
   		}
   	document.all("factgetamt").value=parseFloat(value3)-parseFloat(checkamt);

  }



   document.all.form1.paymoney.value=value3;


   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);

   form1.flag.value="secorderupdate";
   form1.submit();
}
function clickDeleteUpdateRow() {
    tmpStr = clientArea.innerHTML;
    dataTemStr = dataId.innerHTML;

    deleteUpdateClienArea();
  }
function secorderaddnew()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="secorderaddnew";
   var i=0;
   var idValue="id_productid_id_1_wxdid_";
   var idValue2="plannum_";
   var dataArea=dataId.innerHTML;
   var dataClient=clientArea.innerHTML;
   var dataLastf=dataClient.lastIndexOf("name=dataNo");
   var dataLastl=dataClient.lastIndexOf("><INPUT type=hidden value=");
   var dataLast=dataClient.lastIndexOf("id_productid_id_1_wxdid");
   var dataLast2=dataClient.indexOf("plannum_");
   var subLast=dataClient.substring(dataLastl+26,dataLastf);
   var int1=dataClient.substring(dataLast+24,dataLast+25);
   var int2=dataClient.substring(dataLast2+8,dataLast2+9);
   //alert("dataLast"+dataLast);
   //alert("int1"+int1);
   int1=subLast;
   if(dataLast==-1){
   	int1=1;
   	}
   var value1
   var value2
   var nextMoney;
   var countMoney=0;
   var dataCount=document.form1("dataCount").value;
   var ModuleId=document.form1("ModuleId").value;
   //alert("dataCount:"+dataCount);
   if (dataCount!=null&&dataCount!=""){
   	int1=dataCount;
   	}
   for (i=1;i<=int1;i++){
   idValue=idValue.substring(0,24)+i;
   idValue2=idValue2.substring(0,8)+i;
   if (i==1){
   value1=document.all.form1.id_productid_id_1_wxdid_1.value;
   }else{
   value1=document.all(idValue).value;
   }
   if (i==1){
   value2=document.all.form1.plannum_1.value;
   }else{
   value2=document.all(idValue2).value;
   }
       if (value1==null||value1==""){
   	alert("���ڵ�"+i+"�е�1��ͨ��˫��ѡ����Ʒ��Ϣ");
   	return;
   	}


      if (value2==null||value2==""){
   	alert("���ڵ�"+i+"�е�4��������Ʒ����");

   	return;
  }else{
  	planNum=parseFloat(value2);
  	//alert("planNum"+planNum);

  	if (isNaN(planNum)){
  	alert("��������ȷ������");
  	return;
  }

  	}

   var planNum=document.form1("plannum_"+i).value;

      if (document.getElementById("storenum_"+i)!=null){
   var storenumNum=document.form1("storenum_"+i).value;
   var storenumNumFlo=parseFloat(storenumNum);
   if (isNaN(storenumNumFlo)){
   	storenumNum="0";
   	document.form1("storenum_"+i).value="0";
  }

   	if (parseFloat(planNum)>parseFloat(storenumNum)&&(ModuleId=="S04"||ModuleId=="S17")){
   		var alertName="";
   		if (ModuleId=="S04"){
   			alertName="����";
   		}else if (ModuleId=="S17"){
   			alertName="����";
   		}
   		if(!window.confirm("��Ʒ  "+value1+"  "+alertName+"�������ڿ������,��"+alertName+"�����޸�Ϊ���������")){
   			if (outType=="1"){
   			document.form1("plannum_"+i).value="0";
   		}
      return false;
    }else{
    	document.form1("plannum_"+i).value=storenumNum;
    	}

   		}
  }


  if (document.getElementById("freenum_"+i)!=null){
   var freeNum=document.form1("freenum_"+i).value;
   var freeNumFlo=parseFloat(freeNum);
   if (isNaN(freeNumFlo)){
   	freeNum="0";
   	document.form1("freenum_"+i).value="0";
  }

   	document.form1("allnum_"+i).value=parseFloat(freeNum)+parseFloat(planNum);
  }



   if (document.getElementById("price_"+i)!=null){
   var planPrice=document.form1("price_"+i).value;
   if (planPrice!=null){
   	planPrice=planPrice.replace(",","");
   	}

   if (isNaN(planPrice)){
   	document.form1("price_"+i).value="0";
   	}
   init_value_order("plannum_"+i);
   init_value_order("price_"+i);
   init_value_order("money_"+i);

   nextMoney=parseFloat(document.form1("plannum_"+i).value)*parseFloat(document.form1("price_"+i).value);
   if (isNaN(nextMoney)){
   	nextMoney="0";
   	}
   	document.form1("money_"+i).value=nextMoney;
   	addMoneyStr("money_"+i);
   if (nextMoney!=null&&nextMoney!=""){
     //if (nextMoney.indexOf(",")>0){
  	 //  nextMoney=nextMoney.replace(",","");
    // }
   countMoney=countMoney+parseFloat(nextMoney);
   }
   //alert("countMoney"+countMoney);
  }
   }
   if (document.getElementById("amt")!=null){
     var sendAmt="0";
   if (document.getElementById("sendAmt")!=null){
   	sendAmt=document.form1("sendAmt").value;
   	if (sendAmt==null||sendAmt==""){
   		sendAmt="0";
   		}
   		if (sendAmt.indexOf(",")>0){
  	   sendAmt=sendAmt.replace(/,/g,"");
       }
   		addMoneyStr("sendAmt");
   	}

   	document.form1("factpayamt").value=countMoney-parseFloat(sendAmt);
   document.form1("amt").value=countMoney;
   //��Ը����ʵ�ʸ���Ĵ���
   var planAmt=document.form1("amt").value;

   if (planAmt==null){
   	planAmt="";
   	}
   	if (document.getElementById("rebate")!=null){
      	var rebate=document.form1("rebate").value;
      	planAmt=countMoney*(parseFloat(rebate)/10);
      	}
   if (planAmt!=""){

     document.form1("factpayamt").value=planAmt-parseFloat(sendAmt);

     //���˰��Ĵ���
     if (document.getElementById("isfax")!=null&&document.getElementById("noFaxAmt")!=null){
      	var faxRate=document.form1("isfax").value;
      	if (faxRate==""||faxRate==null){
      		faxRate="0";
      		}
      	var noFaxAmt=countMoney/(1+parseFloat(faxRate));
      	document.form1("noFaxAmt").value=noFaxAmt;
      	addMoneyStr("noFaxAmt");
      	}


   	}

   var xiaoxieAmt=form1.amt.value;
	 var daxieAmt=atoc(xiaoxieAmt);
	 form1.chinaAmt.value=daxieAmt;

	 addMoneyStr("amt");
   addMoneyStr("factpayamt");
	}
   form1.submit();
}

function check_send(field)
{
   var obj=document.all(field);
   if(obj.value=="")
      return;
   var allamt=document.all("amt").value;
   var thisamt=obj.value;

   if (allamt==""||allamt==null){
   	allamt="0";
   	}else{
   		if (allamt.indexOf(",")>0){
  	   allamt=allamt.replace(/,/g,"");
       }
     }
    if (thisamt.indexOf(",")>0){
  	   thisamt=thisamt.replace(/,/g,"");
       }
   	var rebate="0";
   if (document.getElementById("rebate")!=null){
      	rebate=document.form1("rebate").value;
    }
   // document.all("amt").value=parseFloat(allamt)*(1-parseFloat(rebate))-parseFloat(thisamt);
   // planAmt=countMoney*(1-parseFloat(rebate));
   document.all("factpayamt").value=parseFloat(allamt)*(parseFloat(rebate)/10)-parseFloat(thisamt);

   addMoneyStr(field);
   addNumberStr(field.replace("price","plannum"));
   addMoneyStr("factpayamt");
}

function checkRate(field)
{
   var obj=document.all(field);
   if(obj.value=="")
      return;
      //alert("allamt"+field);
   var allamt=document.all("amt").value;
   var thisRate=obj.value;
   if (allamt==""||allamt==null){
   	allamt="0";
   	}else{
   		if (allamt.indexOf(",")>0){
  	   allamt=allamt.replace(/,/g,"");
       }
     }

   	alert("allamt"+allamt);
   	if (field=="rebate"){
   document.all("factpayamt").value=parseFloat(allamt)*(parseFloat(thisRate)/10);
   addMoneyStr("factpayamt");
   }
   if (field=="isfax"){
   	if (thisRate==""||thisRate==null){
      		thisRate="0";
      		}
   document.all("noFaxAmt").value=parseFloat(allamt)/(1+parseFloat(thisRate));
   addMoneyStr("noFaxAmt");
   }
}
function secorderupdate()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="secorderupdate";

   var i=0;
   var idValue="id_productid_id_1_wxdid_";
   var idValue2="plannum_";
   var dataArea=dataId.innerHTML;
   var dataClient=clientArea.innerHTML;
   //alert("dataClient"+dataClient);
   var dataLast=dataClient.lastIndexOf("id_productid_id_1_wxdid");
   var dataLast2=dataClient.indexOf("plannum_");

   var int1=dataClient.substring(dataLast+24,dataLast+25);
   var int2=dataClient.substring(dataLast2+8,dataLast2+9);
   if(dataLast==-1){
   	int1=1;
   	}
   var value1
   var value2
   var nextMoney;
   var countMoney=0;
   var dataCount=document.form1("dataCount").value;
   var ModuleId=document.form1("ModuleId").value;
   //alert("dataCount:"+dataCount);
   if (dataCount!=null&&dataCount!=""){
   	int1=dataCount;
   	}

   for (i=1;i<=int1;i++){
   idValue=idValue.substring(0,24)+i;
   idValue2=idValue2.substring(0,8)+i;
   if (i==1){
   value1=document.all.form1.id_productid_id_1_wxdid_1.value;
   }else{
   value1=document.all(idValue).value;
   }
   if (i==1){
   value2=document.all.form1.plannum_1.value;
   }else{
   value2=document.all(idValue2).value;
   }
       if (value1==null||value1==""){
   	alert("���ڵ�"+i+"�е�1��������Ʒ��Ϣ");
   	return;
   	}
      if (value2==null||value2==""){
   	alert("���ڵ�"+i+"�е�4��������Ʒ����");
   	return;
   	}

   var planNum=document.form1("plannum_"+i).value;

   //alert(planNum);
   if (document.getElementById("freenum_"+i)!=null){
   var freeNum=document.form1("freenum_"+i).value;
   //var allNum=document.form1("allnum_"+i).value;
   //if (freeNum=null||freeNum="")
   //{
   //	freeNum="0";
   //	}
   	//alert(freeNum);
   	//alert(planNum);
   	document.form1("allnum_"+i).value=parseFloat(freeNum)+parseFloat(planNum);

  }

   if (document.getElementById("price_"+i)!=null){
   var planPrice=document.form1("price_"+i).value;
   if (planPrice!=null){
   	planPrice=planPrice.replace(/,/g,"");
   	}
   if (planPrice==null||planPrice==""){
   	document.form1("price_"+i).value="0";
   }

   if (isNaN(planPrice)){
   	document.form1("price_"+i).value="0";
   	//alert("planPrice"+planPrice);
   	}
   //	alert("c2ountMoney"+document.form1("money_"+i).value);
   init_value_order("plannum_"+i);
   init_value_order("price_"+i);
   init_value_order("money_"+i);
   //alert("icountMoney"+i);
   nextMoney=parseFloat(document.form1("plannum_"+i).value)*parseFloat(document.form1("price_"+i).value);
   //alert("countMoney"+countMoney);
   //alert("c1ountMoney"+document.form1("money_"+i).value);
   if (isNaN(nextMoney)){
   	nextMoney="0";
   	}
   	document.form1("money_"+i).value=nextMoney;
   	addMoneyStr("money_"+i);
   if (nextMoney!=null&&nextMoney!=""){
   countMoney=countMoney+parseFloat(nextMoney);
   }
   //alert("countMoney"+countMoney);
  }
   }
   //alert("countMoney"+countMoney);
   if (document.getElementById("amt")!=null){
   var sendAmt="0";
   if (document.getElementById("sendAmt")!=null){
   	sendAmt=document.form1("sendAmt").value;
   	if (sendAmt==null||sendAmt==""){
   		sendAmt="0";
   		}
   	if (sendAmt.indexOf(",")>0){
  	   sendAmt=sendAmt.replace(/,/g,"");
       }
   	addMoneyStr("sendAmt");
   	}
   	document.form1("amt").value=countMoney;
   	document.form1("factpayamt").value=countMoney-parseFloat(sendAmt);
   //��Ը����ʵ�ʸ���Ĵ���
   var planAmt=document.form1("amt").value;
   if (planAmt==null){
   	planAmt="";
   	}
   	if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }
   	if (document.getElementById("rebate")!=null){
      	var rebate=document.form1("rebate").value;
      	planAmt=countMoney*(parseFloat(rebate)/10)
      	}
   if (planAmt!=""){
     document.form1("factpayamt").value=planAmt-parseFloat(sendAmt);

      //���˰��Ĵ���
     if (document.getElementById("isfax")!=null&&document.getElementById("noFaxAmt")!=null){
      	var faxRate=document.form1("isfax").value;
      	if (faxRate==""||faxRate==null){
      		faxRate="0";
      		}
      	var noFaxAmt=countMoney/(1+parseFloat(faxRate));
      	document.form1("noFaxAmt").value=noFaxAmt;
      	addMoneyStr("noFaxAmt");
      	}

   	}



   var xiaoxieAmt=form1.amt.value;
	 var daxieAmt=atoc(xiaoxieAmt);

	 form1.chinaAmt.value=daxieAmt;

	  addMoneyStr("amt");
   addMoneyStr("factpayamt");
	}

   form1.submit();
}
function secorderquery()
{
   Qform1.qflag.value="secorderquery";
   Qform1.submit();
}
function doIn()
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("������ѡ��һ�������⣡");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   var ModuleId=document.all("ModuleId").value;
   URL="./doStock.php?mainrowid="+idRowid+"&ModuleId="+ModuleId+"&doState='0'";
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function doOut()
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("������ѡ��һ����г��⣡");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   var ModuleId=document.all("ModuleId").value;
   URL="./outStock.php?mainrowid="+idRowid+"&ModuleId="+ModuleId+"&doState='1'";
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function stockin()
{
   form1.flag.value="stockin";
   form1.submit();
}
function stockout()
{
   form1.flag.value="stockout";
   form1.submit();
}
function dataClick(dataNo){
form1.hidDataNo.value=dataNo
}
function check_value_order(field)
{

   if (field.indexOf("money")>=0){
   return;
   }

   var moduleId=document.form1("ModuleId").value;

   var sStr=/freenum/g;
   if (field.indexOf("freenum")>=0){
   	var thissStr=/freenum/g;
   	var thisPlanNum=document.form1(field.replace(thissStr,"plannum")).value;
   	var thisFreeNum=document.form1(field).value;
   	if (thisPlanNum==null||thisPlanNum==""){
   	thisPlanNum="0";
   	}
   	if (thisFreeNum==null||thisFreeNum==""){
   	thisFreeNum="0";
   	}
        if (isNaN(parseFloat(thisPlanNum))){
           alert("��������ȷ������");
        return;
        }
        if (isNaN(parseFloat(thisFreeNum))){
           alert("��������ȷ������");
        return;
        }
   	document.form1(field.replace(thissStr,"allnum")).value=parseFloat(thisPlanNum)+parseFloat(thisFreeNum);

   		var fieldNo=field.substring(field.lastIndexOf("_")+1,field.length);

   	var stockStr="num_productid_id_1_wxdnum_"+fieldNo;
    var stocknum=document.form1(stockStr).value;
    //alert(stockStr+"����Ʒ�ĳ�����������������"+stocknum);

    var thisNum=document.form1(field.replace(sStr,"allnum")).value;  //ModuleId
    if (stocknum==null||stocknum==""){
    	stocknum=thisNum;
    	}
    	//alert(field.replace(sStr,"plannum")+"=="+stocknum+"==="+thisNum);
    if (parseFloat(stocknum)<parseFloat(thisNum)&&document.form1("ModuleId").value=="S04")
    {
    	//alert(document.form1("StockIsNeg").value);
    	if (document.form1("StockIsNeg").value=="1"){
     var subnum=parseFloat(thisNum)-parseFloat(stocknum);

    alert("����Ʒ�ĳ�����������������"+subnum);
    document.form1(field.replace(sStr,"plannum")).value="0";
    document.form1(field.replace(sStr,"allnum")).value="0";
    document.form1(field.replace(sStr,"freenum")).value="0";
    }
    //return;
    }

   	}

   var obj=document.form1(field);
   sStr=/price/g;
   var fieldInt=field.indexOf("price");
   if (fieldInt>=0){
   var fieldNum2="";
   var fieldNum=field.substring(6,field.length);
   var dataCount=document.form1("dataCount").value;
   //alert("dataCount"+dataCount);
   if (dataCount!=null&&dataCount!=""){
   	fieldNum=dataCount;
   	}


   if (fieldNum2==""){
   fieldNum2=fieldNum;
   }else if (fieldNum2>fieldNum){
   fieldNum=fieldNum2;
   }else if (fieldNum>fieldNum2){
   fieldNum2=fieldNum;
   }
   //alert("ҵ�����ݵ�fieldNum2"+fieldNum2);
   //�����Ʒ����Ĵ���

   var rateStr="num_productid_id_1_wxdrate_"+fieldNum2;
   if (field.indexOf("price")>=0&&(moduleId=="S02"||moduleId=="S04")){
   var thisPlanNum=document.form1(field.replace(sStr,"plannum")).value;
   if (thisPlanNum==null||thisPlanNum==""){
   	thisPlanNum="0";
   	}
      if (isNaN(parseFloat(thisPlanNum))){
           alert("��������ȷ������");
          document.form1(field.replace(sStr,"plannum")).value="";
        return;
        }
   	var freenum=0;
   	var allnum=0;
   	//alert("rateStr"+rateStr);
    var rateNum=document.form1(rateStr).value;

    if (rateNum==null||rateNum==""){
   	rateNum="0";
   	}
   if (isNaN(parseFloat(rateNum))){
           alert("��Ʒ����Ʒ�����ò���ȷ");
   return;
        }

    //alert("rateNum"+rateNum);
   	freenum=parseFloat(thisPlanNum)*parseFloat(rateNum);
   	allnum=parseFloat(thisPlanNum)*(parseFloat(rateNum)+1);
    //alert("freenum"+freenum);
    //alert("allnum"+allnum);
    var freenumstr=freenum.toString();
    if (freenumstr.indexOf(".")>=0){
    	freenumstr=freenumstr.substring(0,freenumstr.indexOf("."));
    	}
    var allnumstr=allnum.toString();
    if (allnumstr.indexOf(".")>=0){
    	allnumstr=allnumstr.substring(0,allnumstr.indexOf("."));
    	}
    	if (document.form1(field.replace(sStr,"freenum")).value==null||document.form1(field.replace(sStr,"freenum")).value==""){
       document.form1(field.replace(sStr,"freenum")).value=freenumstr;
   	   document.form1(field.replace(sStr,"allnum")).value=allnumstr;
      }else{

      	document.form1(field.replace(sStr,"allnum")).value=parseFloat(thisPlanNum)+parseFloat(document.form1(field.replace(sStr,"freenum")).value);
      	}
   }


   //��Ʒ�������

   //alert("ҵ�����ݵ�fieldNum"+fieldNum+"dataCount"+dataCount);

   var moneyField=field;
    moneyField=moneyField.replace(sStr,"money");
    if(obj.value==""||obj.value==null){
   	document.form1(moneyField).value="";
      return;
    }

   var perMoney=document.form1(moneyField).value;
   document.form1(moneyField).value="";
   //alert(document.form1(field.replace(sStr,"plannum")).value);

   if (document.form1(field.replace(sStr,"plannum")).value==""){
   document.form1(field.replace(sStr,"plannum")).value="0";
   document.form1(moneyField).value=parseFloat(document.form1(field.replace(sStr,"plannum")).value)*parseFloat(obj.value);//parseFloat(obj.value)
   }else{ //num_productid_id_1_wxdnum_1
   	//alert("����Ʒ�ĳ�����������������");
   	//alert("1����Ʒ�ĳ�����������������"+field.length);
   	//alert("2����Ʒ�ĳ�����������������"+field.lastIndexOf("_"));
   	var fieldNo=field.substring(field.lastIndexOf("_")+1,field.length);

   	var stockStr="num_productid_id_1_wxdnum_"+fieldNo;
    var stocknum=document.form1(stockStr).value;
    //alert(stockStr+"����Ʒ�ĳ�����������������"+stocknum);

    if (document.getElementById(field.replace(sStr,"allnum"))!=null){
    var thisNum=document.form1(field.replace(sStr,"allnum")).value;  //ModuleId


    if (stocknum==null||stocknum==""){
    	stocknum=thisNum;
    	}
    }
    	//alert(field.replace(sStr,"plannum")+"=="+stocknum+"==="+thisNum);
    if (parseFloat(stocknum)<parseFloat(thisNum)&&document.form1("ModuleId").value=="S04")
    {
    	//alert(document.form1("StockIsNeg").value);
    	if (document.form1("StockIsNeg").value=="1"){
     var subnum=parseFloat(thisNum)-parseFloat(stocknum);

    alert("����Ʒ�ĳ�����������������"+subnum);
    document.form1(field.replace(sStr,"plannum")).value="0";
    document.form1(field.replace(sStr,"allnum")).value="0";
    document.form1(field.replace(sStr,"freenum")).value="0";
    }
    //return;
    }
   //alert("����Ʒ�ĳ�����������������2"+document.form1(field.replace(sStr,"plannum")).value);
   //alert("����Ʒ�ĳ�����������������3"+obj.value);
   document.form1(moneyField).value=parseFloat(document.form1(field.replace(sStr,"plannum")).value)*parseFloat(obj.value);//parseFloat(obj.value)
   }


   if (document.form1("amt").value==""){
   document.form1("amt").value=document.form1(moneyField).value;
   }else{
   var i=0;
   var nextMoney;
   var countMoney=0;
   for (i=1;i<=fieldNum;i++)
   {
   init_value_order("money_"+i);
   nextMoney=document.form1("money_"+i).value;
   if (nextMoney!=null&&nextMoney!=""){
   countMoney=countMoney+parseFloat(nextMoney);
   }
   }
   document.form1("amt").value=countMoney
   //alert("ǰ"+document.form1(moneyField).value);
   addMoneyStr(moneyField);

   //alert("��"+document.form1(moneyField).value);

   }

   //alert(document.form1(moneyField).value);
   //��Ը����ʵ�ʸ���Ĵ���
   planAmt=document.form1("amt").value;
   if (planAmt==null){
   	planAmt="";
  }else{
  	   if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }
  	}
    sendAmt="0";
   //����˷ѵĴ���
   if (document.getElementById("sendAmt")!=null){
   	var sendAmt=document.form1("sendAmt").value;
   	if (sendAmt==null||sendAmt==""){
   		sendAmt="0";
   		}
   	var sendAmtDou=parseFloat(sendAmt);
   	document.form1("factpayamt").value=parseFloat(planAmt)-parseFloat(sendAmt);
   	planAmt=document.form1("amt").value;
   	if (planAmt==null){
   	planAmt="";
    }else{
    	//alert("planAmt"+planAmt+"indexOf"+planAmt.indexOf(","));
  	   if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }
  	}
   	addMoneyStr("sendAmt");

   	}
   	if (document.getElementById("rebate")!=null){
      	var rebate=document.form1("rebate").value;
      	if (rebate==null||rebate==""){
      		rebate="0";
      		}
      	planAmt=parseFloat(planAmt)*(parseFloat(rebate)/10)-parseFloat(sendAmt);
      	}

   	if (planAmt!=""){
     document.form1("factpayamt").value=planAmt;
     	planAmt=document.form1("amt").value;
   	if (planAmt==null){
   	planAmt="";
    }else{
  	   if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }
  	}

     //���˰��Ĵ���
     if (document.getElementById("isfax")!=null&&document.getElementById("noFaxAmt")!=null){
      	var faxRate=document.form1("isfax").value;
      	if (faxRate==""||faxRate==null){
      		faxRate="0";
      		}
      	var noFaxAmt=parseFloat(planAmt)/(1+parseFloat(faxRate))
      	document.form1("noFaxAmt").value=noFaxAmt;
      	addMoneyStr("noFaxAmt");
      	}
   	}
   //	alert("ǰ"+document.form1(field.replace("price","plannum")).value);
   addMoneyStr("amt");
   addMoneyStr("factpayamt");
   addNumberStr(field.replace("price","plannum"));
  //alert("��"+document.form1(moneyField).value);
  // 	alert(planAmt);
   if(obj.value.substring(0,1)=="-")
   {
   	   op="-";
   	   obj.value=obj.value.substring(1,obj.value.length);
   }
   else
       op="";
   val=parseFloat(obj.value);

   if(isNaN(val))
   {
      alert("�Ƿ�������");
      obj.focus();
      return;
   }
   obj.value=ForDight(val,amtdot);
   var value_array=obj.value.split(".");
   //��ʽ������λ
   start=0;
   len=0;
   val_int="";
   while(1)
   {
   	  if((value_array[0].length-start)%3==0)
   	     len=3;
   	  else
   	  	 len=value_array[0].length%3;

      if(val_int=="")
         val_int=value_array[0].substring(start,start+len);
      else
         val_int=val_int+","+value_array[0].substring(start,start+len);
   	  start=len+start;

   	  if(start>=value_array[0].length)
   	     break;
   }
   if(val_int!="")
      value_array[0]=val_int;
   if(value_array.length==1)
   	  value_array[1]="00";
   else if(value_array.length==amtdot)
   {
   	  if(value_array[1].length==0)
   	    value_array[1]="00";
   	  else if(value_array[1].length==1)
   	    value_array[1]=value_array[1]+"0";
   	  else if(value_array[1].length>=amtdot)
   	    value_array[1]=value_array[1].substr(0,amtdot);
   }
   obj.value=op+value_array[0]+"."+value_array[1];

}
}
function  init_value_order(field)
{
   var obj=document.form1(field);

   if (obj.value==""||obj.value==null)
      return;
   re=/,/g;
   obj.value=obj.value.replace(re,"");
}


function check_value_amt(field)
{
   var obj=document.form1(field);
   if(obj.value==""||obj.value==null)
      return;

   if (field.indexOf("allpaymoney_")>=0){
   	 return;
   	}
   	if (field.indexOf("haspaymoney_")>=0){
   	 return;
   	}
   	//alert(field);
   var oldAmt=document.form1("tempAmt").value;
   var allAmt=document.form1("paymoney").value;
   var newAmt=obj.value;
   //alert("���Ե㣺"+fieldNum);
   //alert("�ͽ��"+oldAmt+"�½��"+obj.value+"�ܽ��"+allAmt);
   var fieldNo=field.substring(field.lastIndexOf("_")+1,field.length);
   //alert("���Ե㣺"+fieldNo);
   var allAmtName="allpaymoney_"+fieldNo;
   var hasAmtName="haspaymoney_"+fieldNo;

   var thisAllAmt=document.form1(allAmtName).value;
   var thishasAmt=document.form1(hasAmtName).value;
   var moduelId=document.form1(moduelId).value;
   thisAllAmt=subsymb(thisAllAmt);
   thishasAmt=subsymb(thishasAmt);
   var toPayAmt=parseFloat(thisAllAmt)-parseFloat(thishasAmt);
   var thisSubAmt=parseFloat(newAmt)-toPayAmt;
   if (thisSubAmt>0)
   {
    if(!window.confirm("���θ��������Ӧ������:"+thisSubAmt+",����������"))
      {
      document.form1(field).value=addsymb(parseFloat(oldAmt));
      return false;
      }
   }

   allAmt=subsymb(allAmt);
   oldAmt=subsymb(oldAmt);

   var tempAmt=parseFloat(allAmt)-parseFloat(oldAmt)+parseFloat(newAmt);
   allAmt=addsymb(tempAmt);
   document.form1("paymoney").value=allAmt;
   document.form1(field).value=addsymb(parseFloat(newAmt));
}

function  init_value_amt(field)
{
   var obj=document.form1(field);

   if (obj.value==""||obj.value==null)
      return;
   re=/,/g;
   obj.value=obj.value.replace(re,"");

   document.form1("tempAmt").value=obj.value;//��ʱ���
}

function addsymb(fieldValue)
{
	fieldValue=fieldValue.toString();
   if(fieldValue=="")
      return;

   if(fieldValue.substring(0,1)=="-")
   {
   	   op="-";
   	   fieldValue=fieldValue.substring(1,fieldValue.length);
   }
   else
       op="";

   val=parseFloat(fieldValue);
   if(isNaN(val))
   {
      alert("�Ƿ�������");
      return;
   }

  if(fieldValue.indexOf(".")<0){
  	fieldValue=fieldValue+".00";
  	}

   var value_array=fieldValue.split(".");


   start=0;
   len=0;
   val_int="";


   while(1)
   {
   	  if((value_array[0].length-start)%3==0)
   	     len=3;
   	  else
   	  	 len=value_array[0].length%3;

      if(val_int=="")
         val_int=value_array[0].substring(start,start+len);
      else
         val_int=val_int+","+value_array[0].substring(start,start+len);
   	  start=len+start;

   	  if(start>=value_array[0].length)
   	     break;
   }
   if(val_int!="")
      value_array[0]=val_int;

   //��ʽ��С��λ
   if(value_array.length==1)
   	  value_array[1]="00";
   else if(value_array.length==amtdot)
   {
   	  if(value_array[1].length==0)
   	    value_array[1]="00";
   	  else if(value_array[1].length==1)
   	    value_array[1]=value_array[1]+"0";
   	  else if(value_array[1].length>=amtdot)
   	    value_array[1]=value_array[1].substr(0,amtdot);
   }

   fieldValue=op+value_array[0]+"."+value_array[1];

    return fieldValue;
}

function  subsymb(fieldValue)
{
   if (fieldValue=="")
      return;

   re=/,/g;
   fieldValue=fieldValue.replace(re,"");

   return fieldValue;
}
function atoc(numberValue){
  var numberValue=new String(Math.round(numberValue*100)); // ���ֽ��
  var chineseValue="";          // ת����ĺ��ֽ��
  var String1 = "��Ҽ��������½��ƾ�";       // ��������
  var String2 = "��Ǫ��ʰ��Ǫ��ʰ��Ǫ��ʰԪ�Ƿ�";     // ��Ӧ��λ
  var len=numberValue.length;         // numberValue ���ַ�������
  var Ch1;             // ���ֵĺ������
  var Ch2;             // ����λ�ĺ��ֶ���
  var nZero=0;            // ����������������ֵ�ĸ���
  var String3;            // ָ��λ�õ���ֵ
  if(len>15){
   alert("�������㷶Χ");
   return "";
  }
  if (numberValue==0){
   chineseValue = "��Ԫ��";
   return chineseValue;
  }
  String2 = String2.substr(String2.length-len, len);   // ȡ����Ӧλ����STRING2��ֵ

  for(var i=0; i<len; i++){

   String3 = parseInt(numberValue.substr(i, 1),10);   // ȡ����ת����ĳһλ��ֵ
   //alert(String3);
   if ( i != (len - 3) && i != (len - 7) && i != (len - 11) && i !=(len - 15) ){

    if ( String3 == 0 ){

     Ch1 = "";
     Ch2 = "";
     nZero = nZero + 1;

    }else if ( String3 != 0 && nZero != 0 ){

     Ch1 = "��" + String1.substr(String3, 1);
     Ch2 = String2.substr(i, 1);
     nZero = 0;

    }else{

     Ch1 = String1.substr(String3, 1);
     Ch2 = String2.substr(i, 1);
     nZero = 0;
    }
   }else{              // ��λ�����ڣ��ڣ���Ԫλ�ȹؼ�λ
    if( String3 != 0 && nZero != 0 ){

     Ch1 = "��" + String1.substr(String3, 1);
     Ch2 = String2.substr(i, 1);
     nZero = 0;

    }else if ( String3 != 0 && nZero == 0 ){

     Ch1 = String1.substr(String3, 1);
     Ch2 = String2.substr(i, 1);
     nZero = 0;

    }else if( String3 == 0 && nZero >= 3 ){

     Ch1 = "";
     Ch2 = "";
     nZero = nZero + 1;

    }else{

     Ch1 = "";
     Ch2 = String2.substr(i, 1);
     nZero = nZero + 1;

    }

    if( i == (len - 11) || i == (len - 3)) {    // �����λ����λ��Ԫλ�������д��
     Ch2 = String2.substr(i, 1);
    }

   }
   chineseValue = chineseValue + Ch1 + Ch2;

  }

  if ( String3 == 0 ){           // ���һλ���֣�Ϊ0ʱ�����ϡ�����
   chineseValue = chineseValue + "��";
  }

  return chineseValue;
 }

 function addMoneyStr(moneyField){

 	  if (document.form1(moneyField).value.indexOf(",")>=0){
 	  	return;
 	  	}

   if(document.form1(moneyField).value=="")
      return;
    if(document.form1(moneyField).value.substring(0,1)=="-")
   {
   	   op_Money="-";
   	   document.form1(moneyField).value=document.form1(moneyField).value.substring(1,document.form1(moneyField).value.length);
   }
   else
       op_Money="";

    val_Money=parseFloat(document.form1(moneyField).value);
    document.form1(moneyField).value=ForDight(val_Money,amtdot);
    var value_array_Money=document.form1(moneyField).value.split(".");

   start_Money=0;
   len_Money=0;
   val_int_Money="";

   while(1)
   {
   	  if((value_array_Money[0].length-start_Money)%3==0)
   	     len_Money=3;
   	  else
   	  	 len_Money=value_array_Money[0].length%3;

      if(val_int_Money=="")
         val_int_Money=value_array_Money[0].substring(start_Money,start_Money+len_Money);
      else
         val_int_Money=val_int_Money+","+value_array_Money[0].substring(start_Money,start_Money+len_Money);
   	  start_Money=len_Money+start_Money;

   	  if(start_Money>=value_array_Money[0].length)
   	     break;
   }
   if(val_int_Money!="")
      value_array_Money[0]=val_int_Money;

   if(value_array_Money.length==1)
   	  value_array_Money[1]=amtdotValue;
   else if(value_array_Money.length==amtdot)
   {
   	  if(value_array_Money[1].length==0)
   	    value_array_Money[1]=amtdotValue;
   	  else if(value_array_Money[1].length==1)
   	    value_array_Money[1]=value_array_Money[1]+"0";
   	  else if(value_array_Money[1].length>=amtdot)
   	    value_array_Money[1]=value_array_Money[1].substr(0,amtdot);
   }

   if (amtdot==0){
   document.form1(moneyField).value=op_Money+value_array_Money[0];
   }else {
   document.form1(moneyField).value=op_Money+value_array_Money[0]+"."+value_array_Money[1];
  }

 	}

 function addNumberStr(moneyField){

 	  if (document.form1(moneyField).value.indexOf(",")>=0){
 	  	return;
 	  	}

   if(document.form1(moneyField).value=="")
      return;
    if(document.form1(moneyField).value.substring(0,1)=="-")
   {
   	   op_Money="-";
   	   document.form1(moneyField).value=document.form1(moneyField).value.substring(1,document.form1(moneyField).value.length);
   }
   else
       op_Money="";

    val_Money=parseFloat(document.form1(moneyField).value);
    document.form1(moneyField).value=ForDight(val_Money,numdot);


  	var value_array_Money=document.form1(moneyField).value.split(".");

   start_Money=0;
   len_Money=0;
   val_int_Money="";


   if(val_int_Money!="")
      value_array_Money[0]=val_int_Money;

   if(value_array_Money.length==1)
   	  value_array_Money[1]=numdotValue;
   else if(value_array_Money.length==numdot)
   {
   	  if(value_array_Money[1].length==0)
   	    value_array_Money[1]=numdotValue;
   	  else if(value_array_Money[1].length==1)
   	    value_array_Money[1]=value_array_Money[1]+"0";
   	  else if(value_array_Money[1].length>=numdot)
   	    value_array_Money[1]=value_array_Money[1].substr(0,numdot);
   }
   if (numdot==0){
   document.form1(moneyField).value=op_Money+value_array_Money[0];
   }else {
   document.form1(moneyField).value=op_Money+value_array_Money[0]+"."+value_array_Money[1];
  }

 	}
</script>









<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
 <link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/style.css">



<html>
<head>
<title>�ɹ�����������</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
 <script>
 function stockBack(num)
{
    var backNum;
    var backNumStr="backnum";
    var backAmtStr="backamt";
    var countNum=0;
    var countAmt=0;
    for (i=1;i<=num;i++){
    backNumStr="backnum"+i;
    backNum=document.all(backNumStr).value;
    //document.all(backNumStr).value
    if (backNum!=""&&backNum!=null){
    countNum=countNum+parseFloat(backNum);
    }
    }
    if (countNum==0){
    alert("��ȷ���������!");
    return (false);
    }


var thisAllAmt;
var thisAddNum;
var resAllAmt=document.form1("countAllAmt").value;
if (resAllAmt==null||resAllAmt==""){
	resAllAmt="0";
	}
var folAllAmt=0;

var resAllNum=document.form1("countNum").value;
if (resAllNum==null||resAllNum==""){
	resAllNum="0";
	}
var folAllNum=0;

for (var i=1;i<=num;i++){

	thisAddNum=document.form1("backnum"+i).value;
  thisAllAmt=document.form1("backallamt"+i).value;
  thisAllAmt=thisAllAmt.replace(",","");
  if (thisAddNum==null||thisAddNum==""){
	thisAddNum="0";
	}
	if (thisAllAmt==null||thisAllAmt==""){
	thisAllAmt="0";
	}

  folAllAmt=folAllAmt+parseFloat(thisAllAmt);
	folAllNum=folAllNum+parseFloat(thisAddNum);
	}
document.form1("countAllAmt").value=folAllAmt;
document.form1("countNum").value=folAllNum;

    document.form1("chinaAmt").value=atoc(folAllAmt);

addMoneyStr("countAllAmt");


   form1.flag.value="stockBuyPlan";
   form1.submit();
}
function checkNum(numNo)
{

    var num1=document.form1("7"+numNo).value;//�ƻ�����
    var numCount=document.form1("num").value;//������
    var num2=document.form1("8"+numNo).value; //��������
    var numIn=document.form1("backnum"+numNo).value;
    if (document.form1("backamt"+numNo).value==null||document.form1("backamt"+numNo).value==""){
    document.form1("backamt"+numNo).value=document.form1("9"+numNo).value; //���ε�������
    }
    //document.form1("backprice"+numNo).value
    if (numIn!=""&&numIn!=null){

    	if (num1==null||num1==""){
    		num1="0";
    		}
    	if (num2==null||num2==""){
    		num2="0";
    		}
    if (numIn==null||numIn==""){
    	return false;
    	}
    	var lastNum=parseFloat(num1)-parseFloat(num2);
    if (lastNum<parseFloat(numIn)){
     if(window.confirm("���ζ�����������Ӧ��������,�Ƿ�������У�")){
     //return false;
      document.form1("backallamt"+numNo).value="";
      document.form1("backamt"+numNo).value="";
      document.form1("backnum"+numNo).value="";
      }
    }

    var thisNum=document.form1("backnum"+numNo).value;
    var thisAmt=document.form1("backamt"+numNo).value;
       if (thisNum==null){
    		thisNum="";
    		}
    	 if (thisAmt==null){
    		thisAmt="";
    		}
    if(thisNum!=""&&thisAmt!=""){
    thisAmt=thisAmt.replace(",","");
    document.form1("backallamt"+numNo).value=parseFloat(thisNum)*parseFloat(thisAmt);

    addMoneyStr("backallamt"+numNo);
    addMoneyStr("backamt"+numNo);
    }
}

var thisAllAmt;
var thisAddNum;
var resAllAmt=document.form1("countAllAmt").value;
if (resAllAmt==null||resAllAmt==""){
	resAllAmt="0";
	}
var folAllAmt=0;

var resAllNum=document.form1("countNum").value;
if (resAllNum==null||resAllNum==""){
	resAllNum="0";
	}
var folAllNum=0;

for (var i=1;i<=numCount;i++){

	thisAddNum=document.form1("backnum"+i).value;
  thisAllAmt=document.form1("backallamt"+i).value;
  thisAllAmt=thisAllAmt.replace(",","");
  if (thisAddNum==null||thisAddNum==""){
	thisAddNum="0";
	}
	if (thisAllAmt==null||thisAllAmt==""){
	thisAllAmt="0";
	}

  folAllAmt=folAllAmt+parseFloat(thisAllAmt);
	folAllNum=folAllNum+parseFloat(thisAddNum);
	}
document.form1("countAllAmt").value=folAllAmt;
document.form1("countNum").value=folAllNum;

    document.form1("chinaAmt").value=atoc(folAllAmt);

addMoneyStr("countAllAmt");
}
 </script>
</head>

<body class="bodycolor">
<div align="center">
<form name="form1" action="?action=dataDeal" method="post">
<input type=hidden name=isAddNum value=1>
<table width="95%" class="TableBlock">
<tr align="center" >

      <td nowrap  class="TableHeader" >���</td>

      <td nowrap  class="TableHeader" >������</td>

      <td nowrap  class="TableHeader" >�ƻ�����</td>

      <td nowrap  class="TableHeader" >��Ʒ����</td>

      <td nowrap  class="TableHeader" >��Ʒ����</td>

      <td nowrap  class="TableHeader" >�ƻ�����</td>

      <td nowrap  class="TableHeader" >�Ѷ�������</td>

      <td nowrap  class="TableHeader" >����</td>

<td nowrap  class="TableHeader" >��������</td>
<td nowrap  class="TableHeader" >��������</td>
<td nowrap  class="TableHeader" >С��</td>
</tr>

<?php
$sql = "select buyplanmain.tablecode,
				department.DEPT_NAME,
				buyplanmain.tabledate,
				buyplandetail.productid,
				product.productname,
				buyplandetail.standard,
				buyplandetail.mode,
				buyplandetail.plannum,
				buyplandetail.stockinfactnum,
				buyplandetail.price,
				buyplandetail.buyplandetailsign,
				buyplandetail.buyplandetailsign,
				buyplandetail.buyplandetailsign,
				buyplandetail.buyplandetailsign,
				buyplandetail.ROWID
		from buyplandetail,
				buyplanmain,
				department,
				product
		where buyplandetail.mainrowid=buyplanmain.ROWID
				and buyplanmain.stockid=department.DEPT_ID and
				buyplandetail.productid=product.productid   and
				buyplanmain.flowState='1'
				and ( buyplandetail.plannum>buyplandetail.stockinfactnum
				or buyplandetail.dataState!='2' )
				and buyplanmain.supplyid='".$_GET['supplyId']."'
		order by product.productid
		";
//print $sql;
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();


//�����ظ��Ĳ�Ʒ
//print_R($rs_a);
$RsNew = array();
$NewTestArray = array();
$NewCount = 0;
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$Array = array_keys($Element);
	//print_R($Array);
	$Test = 0;
	for($ii=0;$ii<sizeof($Array);$ii++)		{
		$IndexName = $Array[$ii];
		if($IndexName=="productid")		{
			$productid = $rs_a[$i][$IndexName];
			if(!in_array($productid,$NewTestArray))	{
				array_push($NewTestArray,$productid);
				$Test = 1;
			}
		}
		//print_R($NewTestArray);

		if($IndexName=="plannum"&&in_array($productid,$NewTestArray))		{
			//print "<BR>";
			$RsNew[$NewCount][$IndexName] += (int)$rs_a[$i][$IndexName];
		}
		else	{
			$RsNew[$NewCount][$IndexName] = $rs_a[$i][$IndexName];
		}
	}
	//��û��һ�����ظ���ʱ�򣬼�������һ������У����������ü�һ
	if($Test==0)	{
		$NewCount += 1;
	}

}
//�Ѵ������ֵ����Ʒ�б�
$rs_a = $RsNew;
//print_R($RsNew);

for($i=0;$i<sizeof($rs_a);$i++)			{
$Element = $rs_a[$i];
$MarkID = $i+1;
?>

<tr class="TableLine1" id="TR10" >

<td   align="left" ><input readonly  type="text"   name="0<?php echo $MarkID?>" value="<?php echo $Element['tablecode']?>" size="10" maxlength="54"  class="SmallStatic"></td>

<td   align="left" ><input readonly  type="text"   name="1<?php echo $MarkID?>" value="<?php echo $Element['DEPT_NAME']?>" size="10" maxlength="54"  class="SmallStatic"></td>

<td   align="left" ><input readonly  type="text"   name="2<?php echo $MarkID?>" value="<?php echo $Element['tabledate']?>" size="10" maxlength="54"  class="SmallStatic"></td>

<td   align="left" ><input readonly  type="text"   name="3<?php echo $MarkID?>" value="<?php echo $Element['productid']?>" size="10" maxlength="54"  class="SmallStatic"></td>

<td   align="left" ><input readonly  type="text"   name="4<?php echo $MarkID?>" value="<?php echo $Element['productname']?>" size="15" maxlength="54"  class="SmallStatic"></td>

<input readonly  type="hidden" name="5<?php echo $MarkID?>" value="<?php echo $Element['standard']?>" size="10" maxlength="54"  class="SmallInput2">

<input readonly  type="hidden" name="6<?php echo $MarkID?>" value="<?php echo $Element['mode']?>" size="10" maxlength="54"  class="SmallInput2">

<td   align="left" ><input readonly  type="text"   name="7<?php echo $MarkID?>" value="<?php echo $Element['plannum']?>" size="5" maxlength="54"  class="SmallStatic"></td>

<td   align="left" ><input readonly  type="text"   name="8<?php echo $MarkID?>" value="<?php echo $Element['stockinfactnum']?>" size="7" maxlength="54"  class="SmallStatic"></td>

<td   align="right" ><input readonly  type="text"   name="9<?php echo $MarkID?>" value="<?php echo $Element['price']?>" size="7" maxlength="54"  class="SmallStatic"></td>

<td  ><input   type="text"   name="backnum<?php echo $MarkID?>" size="10" maxlength="54"  onblur="checkNum('<?php echo $MarkID?>')"  class="SmallInput"></td>
<td  ><input   type="text"   name="backamt<?php echo $MarkID?>" size="10" maxlength="54"  onblur="checkNum('<?php echo $MarkID?>')"   class="SmallInput"></td>
<td  ><input   type="text"   name="backallamt<?php echo $MarkID?>" size="10" maxlength="54"   class="SmallInput"></td>
</tr>
<input type="hidden" name="ROWID_<?php echo $MarkID?>" value="<?php echo $Element['ROWID']?>">


<?php
$All_plannum += $Element['plannum'];
$All_stockinfactnum += $Element['stockinfactnum'];
$All_price += $Element['price'];

}//end for

?>

<tr class="TableLine1" id="TR" style="cursor:pointer;">
<td  class="TableHeader">�ϼ�</td>

<td class="TableHeader" align="left">&nbsp</td>

<td class="TableHeader" align="left">&nbsp</td>

<td class="TableHeader" align="left">&nbsp</td>

<td class="TableHeader" align="left">&nbsp</td>

<td class="TableHeader" align="left"><?php echo $All_plannum?></td>

<td class="TableHeader" align="left"><?php echo $All_stockinfactnum?></td>

<td  class="TableHeader" align="right"><?php echo $All_price?></td>


<td class="TableHeader" align="left" >
	<input   type="text"   name="countNum" readonly size="10" maxlength="54"   class="SmallStatic">
	</td>
<td  class="TableHeader" align="left">
	<input   type="text"   name="countAmt" readonly size="10" maxlength="54"   class="SmallStatic">
	</td>
<td  class="TableHeader" align="left">
	<input   type="text"   name="countAllAmt" readonly size="10" maxlength="54"   class="SmallStatic">
	</td>
</tr>
</table>
<input type="hidden" name="rowid" value="1">
<input type="hidden" name="num" value="<?php echo sizeof($rs_a)?>">
<input type="hidden" name="supplyId" value="<?php echo $_GET['supplyId']?>">
<input type="hidden" name="ModuleId" value="<?php echo $_GET['ModuleId']?>">
<input type="hidden" name="oldModuleId" value="<?php echo $_GET['oldModuleId']?>">
<input type="hidden" name="tablecode" value="<?php echo $_GET['tablecode']?>">
<input type="hidden" name="tabledate" value="<?php echo $_GET['tabledate']?>">
<input type="hidden" name="stockid" value="<?php echo $_GET['stockid']?>">
<input type="hidden" name="buyman" value="<?php echo $_GET['buyman']?>">
<input type="hidden" name="intype" value="<?php echo $_GET['intype']?>">
<input type="hidden" name="sendDate" value="<?php echo $_GET['sendDate']?>">
<input type="hidden" name="stockinsign" value="<?php echo $_GET['stockinsign']?>">
<input type="hidden" name="payamt" value="<?php echo $_GET['payamt']?>">
<input type="hidden" name="chinaAmt" value="<?php echo $_GET['chinaAmt']?>">
<input type="hidden" name="flag">
 </form>
<br>
<input type="button" name="close" id="close" class="SmallButton" value="����" onClick="javascript:stockBack('<?php echo sizeof($rs_a)?>');">
<input type="button" name="close" id="close" class="SmallButton" value="�ر�" onClick="javascript:parent.window.close();">
</body>
</html>

<script>
document.all("pimg").style.display="none";
 document.all("abc").style.display="none";
  document.all("pinghead").style.display="none";
</script>