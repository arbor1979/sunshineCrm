<?php

if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
	$PrintText  = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >

�ҵİ칫��Ʒʹ����ϸ��<BR>
&nbsp;&nbsp;�����ڰ칫��Ʒ���Ϊ������Ϊ,���ڳ���������Ʒ,���Դ˴�����ʾ�칫��Ʒ�Ĳ�����ϸ��¼��<BR>
&nbsp;&nbsp;�����ݵĲ����ɰ칫��Ʒ����Ա(���ֻ�У԰->���ڹ���->�칫��Ʒ)���з���Ͳ���,���֮�����ʾ�Լ����ⲿ�����ݡ�
</font></td></table>";
	print $PrintText;
}



require_once('../Help/module_officeproduct.php');

?>