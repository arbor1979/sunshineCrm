

<script language="JavaScript">
function GetResult(str)
{
var oBao = new ActiveXObject("Microsoft.XMLHTTP");
oBao.open("POST","XmlHttpServer.php?sel="+str,false);
oBao.send();
//服务器端处理返回的是经过escape编码的字符串.
//通过XMLHTTP返回数据,开始构建Select.
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
<option value="">请选择
<option value="福建省">福建省</option>
<option value="湖北省">湖北省</option>
<option value="辽宁省">辽宁省</option>
<select>
<select name="SelectName2">
<option value="">====</option>
</select>