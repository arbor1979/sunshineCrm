

<script language="JavaScript">
function GetResult(str)
{
var oBao = new ActiveXObject("Microsoft.XMLHTTP");
oBao.open("POST","XmlHttpServer.php?sel="+str,false);
oBao.send();
//�������˴����ص��Ǿ���escape������ַ���.
//ͨ��XMLHTTP��������,��ʼ����Select.
BuildSel(unescape(oBao.responseText),document.all.SelectName2)
}
function BuildSel(str,sel)
{
sel.options.length=0;
var arrstr = new Array();
arrstr = str.split(",");

for(var i=0;i<arrstr.length;i++)
{
sel.options[sel.options.length]=new Option(arrstr[i],arrstr[i])
}
}
</script>
<select name="SelectName" onChange="GetResult(this.value)">
<option value="">��ѡ��
<option value="����ʡ">����ʡ</option>
<option value="����ʡ">����ʡ</option>
<option value="����ʡ">����ʡ</option>
<select>
<select name="SelectName2">
<option value="">====</option>
</select>