<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

@set_time_limit(120000);
//header("Content-Type: text/html; charset=GBK") ;

$SERVER_NAME = $_SERVER['SERVER_NAME'];

require_once('../config.inc.php');
require_once('../adodb/adodb.inc.php');

require_once('../setting.inc.php');


@copy("../Framework/images/qitaxitong.gif","../../../images/menu/qitaxitong.gif");



//���version.php����ʱ��ʾΪ�����汾,����Ҫ���в˵��Ż�����
if(0)																{
	if(!is_file(ROOT_DIR."/general/version.php"))							{
			//���ֻ�У԰
			$sql = "select * from TD_OA.sys_function where MENU_ID like '%c4%'";
			$rs = $db->Execute($sql);
			$rs_a = $rs->GetArray();
			for($i=0;$i<sizeof($rs_a);$i++)                {
				$MENU_ID = $rs_a[$i]['MENU_ID'];
				$NEW_MENU_ID = ereg_replace("c4","c8",$MENU_ID);
				$NEW_MENU_ID = ereg_replace("C4","c8",$NEW_MENU_ID);
				$sql = "update TD_OA.sys_function set MENU_ID='$NEW_MENU_ID' where MENU_ID='$MENU_ID'";
				$db->Execute($sql);
				//print $sql."<BR>";
			}
			$sql = "update TD_OA.sys_menu set MENU_ID='c8' where MENU_ID='c4'";
			$db->Execute($sql);
			//print $sql."<BR>";


			//���ڹ���
			$sql = "select * from TD_OA.sys_menu where MENU_ID like '%c1%'";
			$rs = $db->Execute($sql);
			if($rs->fields['MENU_NAME']=="���ڹ���")			{
				$sql = "select * from TD_OA.sys_function where MENU_ID like '%c1%'";
				$rs = $db->Execute($sql);
				$rs_a = $rs->GetArray();
				for($i=0;$i<sizeof($rs_a);$i++)                {
					$MENU_ID = $rs_a[$i]['MENU_ID'];
					$NEW_MENU_ID = ereg_replace("c1","c7",$MENU_ID);
					$NEW_MENU_ID = ereg_replace("c1","c7",$NEW_MENU_ID);
					$sql = "update TD_OA.sys_function set MENU_ID='$NEW_MENU_ID' where MENU_ID='$MENU_ID'";
					$db->Execute($sql);
					//print $sql."<BR>";
				}
				$sql = "update TD_OA.sys_menu set MENU_ID='c7' where MENU_ID='c1'";$db->Execute($sql);//print $sql."<BR>";
			}


			$sql = "delete from TD_OA.SYS_MENU where MENU_ID='c0'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "delete from TD_OA.SYS_MENU where MENU_ID='c1'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "delete from TD_OA.SYS_MENU where MENU_ID='c5'";$db->Execute($sql);//print $sql."<BR>";

			$sql = "INSERT INTO TD_OA.SYS_MENU VALUES('c0','��������ϵͳ','qitaxitong')";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_MENU VALUES('c1','�ҵ��ʲ�','@EDU')";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_MENU VALUES('c5','�ҵĲ���','@EDU')";$db->Execute($sql);//print $sql."<BR>";



			$sql = "delete from TD_OA.SYS_FUNCTION where FUNC_NAME='ʳ�ù���'";$db->Execute($sql);//print $sql."<BR>";

			$sql = "delete from TD_OA.SYS_FUNCTION where FUNC_ID='281'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_FUNCTION VALUES('281','c102','�ҵİ칫��Ʒ','EDU/Interface/officeproduct/officeproduct_my.php')";$db->Execute($sql);//print $sql."<BR>";
			$sql = "delete from TD_OA.SYS_FUNCTION where FUNC_ID='295'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_FUNCTION VALUES('295','c104','�ҵĹ̶��ʲ�','EDU/Interface/fixedasset/my_fixedasset.php')";$db->Execute($sql);//print $sql."<BR>";
			$sql = "delete from TD_OA.SYS_FUNCTION where FUNC_ID='346'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_FUNCTION VALUES('346','c108','���Ϲ��ﱨ��','EDU/Interface/Teacher/wygl_teacher.php')";$db->Execute($sql);//print $sql."<BR>";
			$sql = "delete from TD_OA.SYS_FUNCTION where FUNC_ID='391'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_FUNCTION VALUES('391','c106','�ҵ���������','EDU/Interface/XinZhengGuanLi/my_xingzheng.php')";$db->Execute($sql);//print $sql."<BR>";

			$sql = "delete from TD_OA.SYS_FUNCTION where FUNC_ID='370'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_FUNCTION VALUES('370','c502','�̶��ʲ����ż�����','EDU/Interface/fixedasset/fixedasset_department_newai.php')";$db->Execute($sql);//print $sql."<BR>";
			$sql = "delete from TD_OA.SYS_FUNCTION where FUNC_ID='371'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_FUNCTION VALUES('371','c504','�������ڲ��ż�����','EDU/Interface/XinZhengGuanLi/my_bumen_xingzheng.php')";$db->Execute($sql);//print $sql."<BR>";

			$sql = "delete from TD_OA.SYS_FUNCTION where MENU_ID='c004'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_FUNCTION VALUES('372','c004','��������ϵͳ','EDU/Interface/EDU/other_system_userlogin_newai.php')";$db->Execute($sql);//print $sql."<BR>";
			$sql = "delete from TD_OA.SYS_FUNCTION where MENU_ID='c30452'";$db->Execute($sql);//print $sql."<BR>";
			$sql = "INSERT INTO TD_OA.SYS_FUNCTION VALUES('373','c30452','��������','EDU/Interface/Teacher/NewStudentBaoDao.php')";$db->Execute($sql);//print $sql."<BR>";

			print "<div align=center><font color=green>���ӹ���ִ�гɹ�!</font></div>";
	}
}
?>