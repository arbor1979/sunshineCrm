<?php
include_once("lib.inc.php");
if($_GET['action']=='')		{
?>


<link rel='stylesheet' type='text/css' href='<?php echo ROOT_DIR?>theme/3/style.css'>
<FORM name=form1 action="?action=login" method=post encType=multipart/form-data>
<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=550 style="border-collapse:collapse">
<TR><TD class=TableHeader align=center colSpan=4>&nbsp;Sunshine Anywhere �������ƽ̨(SAP)</TD></TR>
<TR><TD class=TableContent align=center width=25% colSpan=1 nowrap>&nbsp;���룺
<input  type=password name=password class=SmallInput value="">��Ĭ�����룺123456��
</TD></TR>
<TR><TD class=TableContent align=center width=25% colSpan=1 nowrap>
<INPUT class=SmallButton title=����ƽ̨ type=submit value="����ƽ̨" name=button>
</TD></TR>
</table></form>

<?php
}
else if($_GET['action']=='login'&&addslashes($_POST['password'])=='123456')		{
echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=main.php?action=action_init'>\n";
}
else		{
//print_R($_POST);
print "<link rel='stylesheet' type='text/css' href='".ROOT_DIR."theme/9/style.css'>\n";
print "<div align=center><INPUT class=SmallButton onclick=\"location='?'\" type=button value='�ص���ҳ'></div>";
}
?>
