<?php

$����Ŀ¼ = "./FileCache/";

if ($dp = opendir($����Ŀ¼)) {
	while (($file=readdir($dp)) != false) {
		if (is_dir($����Ŀ¼.$file) && $file!='.' && $file!='..') {
			$filectime = filectime($����Ŀ¼.$file);
			$nowtime = time();
			$lefttime = ($nowtime-$filectime)/(3600*4);
			$lefttime = floor($lefttime);
			//print $lefttime."<BR>";
			//deleteDir($����Ŀ¼.$file);
		}
		if (is_file($����Ŀ¼.$file) && $file!='.' && $file!='..') {
			$filectime = filectime($����Ŀ¼.$file);
			$nowtime = time();
			$lefttime = ($nowtime-$filectime)/(3600*4);
			$lefttime = floor($lefttime);
			//print $lefttime."<BR>";
			unlink($����Ŀ¼.$file);
		}
		//print $����Ŀ¼.$file."<BR>";;

	}
}


function deleteDir($dir)
{
if (@rmdir($dir)==false && is_dir($dir)) {
	if ($dp = opendir($dir)) {
		while (($file=readdir($dp)) != false) {
			if (is_dir($dir."/".$file) && $file!='.' && $file!='..') {
				deleteDir($dir."/".$file);
			}
			else if (is_file($dir."/".$file) && $file!='.' && $file!='..') {
				unlink($dir."/".$file);
			}
		}
	@rmdir($dir);
	closedir($dp);
	} else {
		exit('Not permission');
    }
}

}

?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>