<?php
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
page_css();
?>
<link rel="stylesheet" type="text/css" href="/theme/<?=$_SESSION['LOGIN_THEME']?>/style.css">
<script src="images/ccorrect_btn.js"></script>

<html>
<head>
<title>行政人员打卡考勤使用说明</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>

<body class="bodycolor">

<div class=small>
<b>行政人员打卡考勤-指纹考勤机及安装要求:</b><br><br>
第一：指纹考勤机可以实时与电脑传输数据。<br><br>
第二：指纹考勤机需要使用SQL SERVER2000做为数据库,不能使用MSDE。<br><br>
第三：指纹考勤机安装电脑必须跟OA服务器是同一台服务器或PHP可以读取到其它SQL SERVER服务器数据<br><br>

<b>指纹考勤机与通达OA集成要求:</b><br><br>
第一：修改D:\MYOA\bin\php.ini文件,把extension=php_mssql.dll行前面的';'去除,同时确保同一目录下存在php_mssql.dll文件。<br><br>
第二：用通达应用服务器重新启动OFFICE_ANYWHERE服务。<br><br>
第三：修改webroot/general/ERP/config_mssql_studentkaoqin.php文件,修改对应的数据库服务器所使用的主机地址/用户名/密码/数据库名<br><br>
<br>
<font color=red>注1:通达OA与考勤机的集成,暂时只支持朗伦指纹考勤机8900S型号</font><br><br>
<font color=red>注2:php_mssql.dll必须与系统PHP版本事情对应一致</font><br><br>


<b>数据配置说明:</b><br><br>
第一：行政人员卡号为指纹考勤机里面卡号信息。<br><br>
第二：行政人员每天应该打卡考勤次数根据排班表数据自动生成,无效刷卡记录,则不预记录<br><br>
第三：统计时统一从考勤机数据库读取数据,也可以实时读取数据<br><br>
<br><br>


</div>
</body>
</html>
