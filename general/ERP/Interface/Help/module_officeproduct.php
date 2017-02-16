<?php

if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
	$PrintText  = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >

我的办公用品使用明细：<BR>
&nbsp;&nbsp;①由于办公用品大多为领用行为,属于常规性消耗品,所以此处仅显示办公用品的操作明细记录。<BR>
&nbsp;&nbsp;②数据的产生由办公用品管理员(数字化校园->后勤管理->办公用品)进行分配和操作,完成之后会显示自己的这部分数据。
</font></td></table>";
	print $PrintText;
}



require_once('../Help/module_officeproduct.php');

?>