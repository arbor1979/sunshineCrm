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

$uploaddir = "docs/";
$uploadfile = $uploaddir.$_FILES['EDITFILE']['name'];
print "��������:".$_POST['data']."<br>";
if ( is_uploaded_file( $_FILES['EDITFILE']['tmp_name'] ) )
{
				if ( move_uploaded_file( $_FILES['EDITFILE']['tmp_name'], $uploadfile ) )
				{
								print "�ɹ������ļ�:".$_FILES['EDITFILE']['name'].". ��С:".$_FILES['EDITFILE']['size']."�ֽ�<br>";
				}
				else
				{
								print "�ļ��������";
				}
}
$attachdir = "attaches/";
if ( array_key_exists( "attaches", $_FILES ) )
{
				print "���渽��:<br>";
				foreach ( $GLOBALS['_FILES']['attaches']['tmp_name'] as $key => $value )
				{
								$uploadfile = $attachdir.$_FILES['attaches']['name'][$key];
								if ( is_uploaded_file( $_FILES['attaches']['tmp_name'][$key] ) )
								{
												if ( move_uploaded_file( $_FILES['attaches']['tmp_name'][$key], $uploadfile ) )
												{
																print "�ɹ������ļ�:".$_FILES['attaches']['name'][$key].".��С:".$_FILES['attaches']['size'][$key]."�ֽ�<br>";
												}
												else
												{
																print "�ļ�".$_FILES['attaches']['name'][$key]."�������";
												}
								}
				}
}
else
{
				print "û������������";
}
?>
