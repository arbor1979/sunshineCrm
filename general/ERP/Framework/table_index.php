
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />

<title>�칫������</title>

<style>
html {height:100%;}
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px; height:100%;
}
</style>
<script type="text/javascript" language="javascript" src="../Enginee/jquery/jquery.js"></script>

<script type="text/javascript">
var iframeids=["table_main"];
//����û����������֧��iframe�Ƿ�iframe���� yes ��ʾ���أ�no��ʾ������
var iframehide="no";
//ǿ�ưѸ߶�����10����Ϊ�߶ȳ���ȥ�Ժ�����ô������ҳ��Ĵ�С�Ѿ��²����ˣ����ʱ�����Ҫǿ����һ���ٳŻ�ȥ
var forcemin="0";

function setforcemin(obj)
{
forcemin = obj;
}
function dyniframesize()
{
var dyniframe=new Array();
for (i=0; i<iframeids.length; i++)
{
if (document.getElementById)
{
//�Զ�����iframe�߶�
 dyniframe[i] = document.getElementById(iframeids[i]);
 if (dyniframe[i]!=null && !window.opera)
 {
  dyniframe[i].style.display="block";
  if (dyniframe[i].contentDocument && dyniframe[i].contentDocument.body.offsetHeight) //����û����������NetScape
   dyniframe[i].height = dyniframe[i].contentDocument.body.offsetHeight;
  else if (dyniframe[i].Document && dyniframe[i].Document.body.scrollHeight) //����û����������IE
   dyniframe[i].height = dyniframe[i].Document.body.scrollHeight;
  if (dyniframe[i].contentDocument && dyniframe[i].contentDocument.body.offsetWeight ) //����û����������NetScape
   dyniframe[i].weight = dyniframe[i].contentDocument.body.offsetWeight;
  else if (dyniframe[i].Document && dyniframe[i].Document.body.scrollWidth) //����û����������IE
  {
   //dyniframe[i].width = document.body.scrollWidth;
   if(forcemin == "1")
     dyniframe[i].width = 10;
    else
     dyniframe[i].width = dyniframe[i].Document.body.scrollWidth;
  } 
 }
}

}
}
function setReaded(id)
{
	$.get('../Interface/CRM/message_newai.php', {
	    action: 'readed',
	    id:id
	});
	$("#miaov_float_layer").hide();
}
function HideMessage()
{
	$("#miaov_float_layer").slideUp();
}

</script>

<style >
#loginBox {
    position:absolute;
    top:0px;
    right:0px;
    display:none;
    z-index:29;
	filter:alpha(opacity=90);
	POSITION: fixed;
}

#loginForm {
    width:380px; 
    border:1px solid #899caa;
    border-radius:3px 0 3px 3px;
    -moz-border-radius:3px 0 3px 3px;
    margin-top:-1px;
    background:#D8F9FE;
    padding:5px;
}

* { padding: 0; margin: 0; }

.float_layer {width: 300px;  display:none;  position:absolute;  bottom:0px; right:16px;z-index:29;
	filter:alpha(opacity=90);}
.float_layer h2 { height: 20px; line-height: 20px; padding-left: 10px; font-size: 14px;border:1px solid #899caa; background:url(../theme/3/images/header_bg1.gif) top repeat-x;;  position: relative; }


.float_layer .close { width: 21px; height: 20px; background: url(images/close1.gif) no-repeat 0 bottom; position: absolute; top: 2px; right: 3px; }
.float_layer .close:hover { background: url(images/close1.gif) no-repeat 0 0; }

.float_layer .content { height: 120px; overflow: hidden; font-size: 12px; line-height: 18px;  border:1px solid #899caa;
    border-radius:3px 0 3px 3px;
    -moz-border-radius:3px 0 3px 3px;
    margin-top:-1px;
    background:#E3F4FE;
    padding:10px;}
.float_layer .wrap { padding: 10px; }
</style>

</head>
<body>
<iframe id="table_main" name="table_main" src="../Interface/CRM/erp_mytable/crm_mytable.php" scrolling=auto frameborder="0" width="100%"  height="100%" marginwidth="0" marginheight="0" ></iframe>
				
<div id="loginBox">                
	<div id="loginForm">
    <iframe src="../Interface/CRM/erp_mytable/crm_notes.php" width="100%" height="100%" frameborder="0"  scrolling=no></iframe>
	</div>
</div>  
<div class="float_layer" id="miaov_float_layer">
    <h2>
        <strong></strong>
      
        <a id="btn_close" href="javascript:HideMessage()" class="close"></a>
    </h2>
    <div class="content" id="content">
  </div>
</div>
</body>
</html>
