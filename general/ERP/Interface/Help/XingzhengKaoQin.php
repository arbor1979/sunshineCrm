<?php
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
page_css();
?>
<link rel="stylesheet" type="text/css" href="/theme/<?=$_SESSION['LOGIN_THEME']?>/style.css">
<script src="images/ccorrect_btn.js"></script>

<html>
<head>
<title>������Ա�򿨿���ʹ��˵��</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>

<body class="bodycolor">

<div class=small>
<b>������Ա�򿨿���-ָ�ƿ��ڻ�����װҪ��:</b><br><br>
��һ��ָ�ƿ��ڻ�����ʵʱ����Դ������ݡ�<br><br>
�ڶ���ָ�ƿ��ڻ���Ҫʹ��SQL SERVER2000��Ϊ���ݿ�,����ʹ��MSDE��<br><br>
������ָ�ƿ��ڻ���װ���Ա����OA��������ͬһ̨��������PHP���Զ�ȡ������SQL SERVER����������<br><br>

<b>ָ�ƿ��ڻ���ͨ��OA����Ҫ��:</b><br><br>
��һ���޸�D:\MYOA\bin\php.ini�ļ�,��extension=php_mssql.dll��ǰ���';'ȥ��,ͬʱȷ��ͬһĿ¼�´���php_mssql.dll�ļ���<br><br>
�ڶ�����ͨ��Ӧ�÷�������������OFFICE_ANYWHERE����<br><br>
�������޸�webroot/general/ERP/config_mssql_studentkaoqin.php�ļ�,�޸Ķ�Ӧ�����ݿ��������ʹ�õ�������ַ/�û���/����/���ݿ���<br><br>
<br>
<font color=red>ע1:ͨ��OA�뿼�ڻ��ļ���,��ʱֻ֧������ָ�ƿ��ڻ�8900S�ͺ�</font><br><br>
<font color=red>ע2:php_mssql.dll������ϵͳPHP�汾�����Ӧһ��</font><br><br>


<b>��������˵��:</b><br><br>
��һ��������Ա����Ϊָ�ƿ��ڻ����濨����Ϣ��<br><br>
�ڶ���������Աÿ��Ӧ�ô򿨿��ڴ��������Ű�������Զ�����,��Чˢ����¼,��Ԥ��¼<br><br>
������ͳ��ʱͳһ�ӿ��ڻ����ݿ��ȡ����,Ҳ����ʵʱ��ȡ����<br><br>
<br><br>


</div>
</body>
</html>
