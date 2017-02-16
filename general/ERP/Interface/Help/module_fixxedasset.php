<?php

if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
	$PrintText  = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >

我的固定资产使用明细：<BR>
&nbsp;&nbsp;①固定资产部分会显示当前用户名下的固定资产信息和其它的一些操作记录信息。<BR>
&nbsp;&nbsp;②数据的产生由固定资产管理员(数字化校园->后勤管理->固定资产)进行分配和操作,完成之后会显示自己的这部分数据。
</font></td></table>";
	print $PrintText;
}


?>