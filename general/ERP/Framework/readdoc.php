<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/

echo "\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"./images/style.css\">\r\n\r\n\r\n<HTML>\r\n<HEAD>\r\n<TITLE>Sunshine Anywhere �ĵ������Ķ�</TITLE>\r\n<meta http-equiv=\"content-type\" content=\"text/html;charset=gb2312\">\r\n";
echo "<S";
echo "CRIPT LANGUAGE=\"JavaScript\" src=\"officedoc/tangerocx.js\"></SCRIPT>\r\n\r\n";
echo "<s";
echo "cript>\r\nfunction myload()\r\n{\r\n\r\n  TANGER_OCX_SetInfo();\r\n  TANGER_OCX_EnableFilePrintMenu(false);\r\n}\r\n\r\nfunction MY_SetMarkModify(flag)\r\n{\r\n  TANGER_OCX_SetMarkModify(flag);\r\n  if(flag)\r\n  {\r\n     mflag1.style.fontWeight=\"bold\";\r\n     mflag2.style.fontWeight=\"\";\r\n  }\r\n  else\r\n  {\r\n     mflag1.style.fontWeight=\"\";\r\n     mflag2.style.fontWeight=\"bold\";\r\n  } \r\n}\r\n\r\nfunction MY_ShowRevisions(flag)\r\n{\r";
echo "\n  TANGER_OCX_ShowRevisions(flag);\r\n  if(flag)\r\n  {\r\n     sflag1.style.fontWeight=\"bold\";\r\n     sflag2.style.fontWeight=\"\";\r\n  }\r\n  else\r\n  {\r\n     sflag1.style.fontWeight=\"\";\r\n     sflag2.style.fontWeight=\"bold\";\r\n  } \r\n}\r\n</script>\r\n</HEAD>\r\n\r\n<BODY class=\"bodycolor\" leftmargin=\"0\" topmargin=\"5\" onLoad=\"javascript:myload()\" onunload=\"javascript:close_doc()\">\r\n\r\n<FORM NAME=\"form1\" METHOD=post ACTION=";
echo "\"upload_OC.php\" ENCTYPE=\"multipart/form-data\">\r\n\r\n<table width=100% height=100% class=\"small\" cellspacing=\"1\" cellpadding=\"3\" align=\"center\">\r\n<tr width=100%>\r\n<td valign=top width=80>\r\n  <table border=\"0\" cellspacing=\"1\" width=\"100%\" class=\"small\" bgcolor=\"#000000\" cellpadding=\"3\" align=\"center\">\r\n\r\n   <tr class=\"TableHeader\">\r\n     <td nowrap align=\"center\">������֤</td>\r\n   </tr>\r\n     <tr class=\"TableH";
echo "eader1\" onclick=\"DoCheckSign('6180538820')\" style=\"cursor:pointer\">\r\n       <td nowrap align=\"center\">��֤ǩ����ӡ��</td>\r\n     </tr>\r\n\t <tr class=\"TableHeader1\" onclick=\"TANGER_OCX_PrintDoc()\" style=\"cursor:pointer\">\r\n       <td nowrap align=\"center\">��ӡ�ĵ�</td>\r\n     </tr>\r\n\t <tr class=\"TableHeader1\" onclick=\"javascript:window.close();\" style=\"cursor:pointer\">\r\n       <td nowrap align=\"center\">�رմ���</td>\r\n   ";
echo "  </tr>\r\n  </table>\r\n</td>\r\n<td width=100% valign=\"top\">\r\n\r\n\r\n\r\n<object id=\"TANGER_OCX\" classid=\"clsid:C9BC4DFF-4248-4a3c-8A49-63A7D317F404\" codebase=\"officedoc/OfficeControl.cab#version=3,0,0,2\" width=\"100%\" height=\"100%\">\r\n\t\t<param name=\"BorderStyle\" value=\"1\">\r\n\t \t<param name=\"BorderColor\" value=\"14402205\">        \r\n\t \t<param name=\"TitlebarColor\" value=\"14402205\">\r\n        <param name=\"TitlebarTextColor";
echo "\" value=\"0\">\t \r\n        <param name=\"Caption\" value=\"NTKO OFFICE�ĵ��ؼ�PHP��ʾ.V3,0,0,2. http://www.ntko.com\">\r\n        <param name=\"IsShowToolMenu\" value=\"-1\">\r\n        <param name=\"IsNoCopy\" value=\"-1\">\r\n\r\n\r\n";
echo "<S";
echo "PAN STYLE=\"color:red\"><br>����װ���ĵ��ؼ������ڼ���������ѡ���м��������İ�ȫ���á�</SPAN>\r\n</object>\r\n</td>\r\n</tr>\r\n</table>\r\n\r\n";
echo "<s";
echo "cript language=\"JScript\" for=TANGER_OCX event=\"OnDocumentClosed()\">\r\nTANGER_OCX_OnDocumentClosed()\r\n</script>\r\n\r\n";
echo "<s";
echo "cript language=\"JScript\">\r\nvar TANGER_OCX_str;\r\nvar TANGER_OCX_obj;\r\n\r\nvar close_op_flag=1;\r\n\r\nfunction close_doc()\r\n{\r\n   if(close_op_flag!=1)\r\n   {\r\n     msg='�Ƿ񱣴��  \\'";
echo $_GET['attachmentname'];
echo "\\'  ���޸ģ�';\r\n     if(window.confirm(msg))\r\n        TANGER_OCX_SaveDoc(0);\r\n   }\r\n}\r\n</script>\r\n\r\n";
echo "<s";
echo "cript language=\"JScript\" for=TANGER_OCX event=\"OnDocumentOpened(TANGER_OCX_str,TANGER_OCX_obj)\">\r\nTANGER_OCX_OnDocumentOpened(TANGER_OCX_str,TANGER_OCX_obj);\r\nTANGER_OCX_OBJ.Menubar=false;\r\nTANGER_OCX_OBJ.Titlebar = true;\r\nTANGER_OCX_OBJ.IsShowToolMenu=false;\r\n//TANGER_OCX_OBJ.Toolbars=false;\r\nTANGER_OCX_OBJ.IsNoCopy=false;\r\nTANGER_OCX_EnableFilePrintMenu(true);\r\nTANGER_OCX_EnableFileNewMenu(false";
echo ");\r\nTANGER_OCX_EnableFileSaveMenu(false);\r\nTANGER_OCX_EnableFileSaveAsMenu(false);\r\n</script>\t\r\n\r\n\r\n</script>\r\n\r\n";
echo "<S";
echo "PAN ID=\"TANGER_OCX_op\" style=\"display:none\">";
echo $_GET['op'];
echo "</SPAN>\r\n";
echo "<S";
echo "PAN ID=\"TANGER_OCX_filename\" style=\"display:none\">";
echo $_GET['attachmentname'];
echo "</SPAN>\r\n";
echo "<S";
echo "PAN ID=\"TANGER_OCX_attachName\" style=\"display:none\">";
echo $_GET['attachmentname'];
echo "</SPAN>\r\n";
echo "<S";
echo "PAN ID=\"TANGER_OCX_attachURL\" style=\"display:none\">download.php?action=download&sessionkey=";
echo $_GET['sessionkey'];
echo "&attachmentid=";
echo $_GET['attachmentid'];
echo "&attachmentname=";
echo $_GET['attachmentname'];
echo "</SPAN>\r\n";
echo "<S";
echo "PAN ID=\"TANGER_OCX_user\" style=\"display:none\">";
echo $_SEESION[$SUNSHINE_USER_NICK_NAME_VAR];
echo "</SPAN>\r\n\r\n<INPUT style=\"display:none\" TYPE=\"file\" NAME=\"ATTACHMENT\">\r\n<INPUT TYPE=\"hidden\" NAME=\"ATTACHMENT_ID\" value=\"";
echo $_GET['attachmentid'];
echo "\">\r\n<INPUT TYPE=\"hidden\" NAME=\"ATTACHMENT_NAME\" value=\"";
echo $_GET['attachmentname'];
echo "\">\r\n</FORM>\r\n\r\n</BODY>\r\n</HTML>\r\n";
?>
