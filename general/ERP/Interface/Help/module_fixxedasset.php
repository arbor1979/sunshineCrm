<?php

if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
	$PrintText  = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >

�ҵĹ̶��ʲ�ʹ����ϸ��<BR>
&nbsp;&nbsp;�ٹ̶��ʲ����ֻ���ʾ��ǰ�û����µĹ̶��ʲ���Ϣ��������һЩ������¼��Ϣ��<BR>
&nbsp;&nbsp;�����ݵĲ����ɹ̶��ʲ�����Ա(���ֻ�У԰->���ڹ���->�̶��ʲ�)���з���Ͳ���,���֮�����ʾ�Լ����ⲿ�����ݡ�
</font></td></table>";
	print $PrintText;
}


?>