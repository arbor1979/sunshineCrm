<?php 
require_once('../../../config.inc.php');
?>
<SCRIPT language="javascript">
var xmlHttp;    //���ڱ���XMLHttpRequest�����ȫ�ֱ���

//���ڴ���XMLHttpRequest����
function createXmlHttp() {
//����window.XMLHttpRequest�����Ƿ����ʹ�ò�ͬ�Ĵ�����ʽ
if (window.XMLHttpRequest) {
   xmlHttp = new XMLHttpRequest();                  //FireFox��Opera�������֧�ֵĴ�����ʽ
} else {
   xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");//IE�����֧�ֵĴ�����ʽ
}
}

//����������Ͳ�������
function sendSearch() {
	if(kword.value=='')
	{
		kword.value=='�ؼ�������...';
		searchResult.innerHTML='';
		return false;
	}
	createXmlHttp();                        //����XmlHttpRequest����
    xmlHttp.onreadystatechange =function() {showSearchResult(xmlHttp)};   
    xmlHttp.open("GET", "inc_prod_detail_update.php?action=search&keyword="+kword.value, true);
    xmlHttp.send(null);
}
//����������Ӧ��Ϣд�빺�ﳵdiv��
function showSearchResult(xmlHttp) {
    if (xmlHttp.readyState == 4) {
        var res=xmlHttp.responseText;
        if(res.indexOf("<a href")!=-1)
        	searchResult.innerHTML = xmlHttp.responseText;
        else
        {
            alert(xmlHttp.responseText);
            location.reload();
        }
            
    }
}
</SCRIPT>

<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
<div align=left  style="margin: 10px;">
����һ��<input type="text" id="kword" name="kword" value="�ؼ�������..."   class="SmallInput" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" 
onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="width:100px;color:#999999"  onkeyup="sendSearch()">

<div id="searchResult">
</div>
</div>

