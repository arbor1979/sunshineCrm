<?php
require_once('newai.lib.inc.php');
//����ȫ�ֱ���

$fields=returnfields($tablename,$showlistfieldlist,$showlistfieldfilter,$showlistnull,$showlistfieldprivate);
//�����SYSTEM_ADD_SQL��֧��,���ڸ߼���������֧��
newai_search_sql($fields);
//��������SQL��Ϣ
$return_sql_line=return_sql_line($fields);
//logbegin('systemLogin');
//print_r($return_sql_line);exit;
global $pagenums_model;
global $FORM_SELECT_DISABLED;
global $COLSPAN_SYSTEM;

//������SEARCHʱ��������������ʾ��
$ActionArray = explode('_',$_GET['action']);
if($ActionArray[0]=="init"&&$ActionArray[2]=="search")		{
	if($pagenums_model==0)	$pagenums_model = 25;
}

//һ������¶�ÿҳ��ʾ��������
$ROWS_PAGE=isset($pagenums_model)?$pagenums_model:25;

function returnfields($tablename,$showlistfieldlist,$showlistfieldfilter,$showlistnull,$showlistfieldprivate)		{
	global $columns,$html_etc,$common_html;
	global $primarykey,$uniquekey,$tablename,$realtablename;
	global $_SESSION,$SUNSHINE_USER_DEPT_VAR;
	$listarray=explode(',',$showlistfieldlist);
	$filterarray=explode(',',$showlistfieldfilter);
	$privaterarray=explode(',',$showlistfieldprivate);
	$nullarray=explode(',',$showlistnull);
	$fields['tablename']=$tablename;
	$fields['realtable']=$realtablename;
	
	for($i=0;$i<sizeof($listarray);$i++)		{
		$index=$listarray[$i];
		$fields['name'][$i]=$columns[$index];

		$FieldNameIndex = $columns[$index];
		$fields['null'][$i]['inputname']=$columns[$index];
		$fields['null'][$i]['inputtype']=$nullarray[$i];
		//�õ�INPUT��NOTNULL��������
		$filterArrayFilter = explode(":",$filterarray[$i]);
		$fields['null'][$i]['inputfilter']=$filterArrayFilter[0];
		$fields['null'][$i]['inputtext']=$html_etc[$tablename][(string)$columns[$index]]."".$common_html['common_html'][(string)$nullarray[$i]];

		//######################################################
		//�ж��Ƿ�Ҫ�����û�����ķǽ�ɫֻ���Ǳ༭ѡ�� -- ��ʼ
		/*
		 $USER_PRIV_ID = $_SESSION['SUNSHINE_USER_PRIV'];
		 //$USER_PRIV = returntablefield("user_priv","USER_PRIV",$USER_PRIV_ID,"PRIV_NO");
		 //$USER_PRIV = 5;
		 $PrivateStringElement = $privaterarray[$i];
		 $PrivateElementArray = explode(":",$PrivateStringElement);
		 //print_R($PrivateElementArray);

		 //�����û��Ƿ�Ϊ�ɱ༭ѡ��
		 if(sizeof($PrivateElementArray)>0&&$PrivateElementArray[0]!="")	{
		 //�Ѿ����壬������ֵ����
		 //||$USER_PRIV==1||$USER_PRIV==2||$USER_PRIV==3 �������Ա���ܾ���Ϊ��дȨ�� ��������ͨ��Ȩ����д���
		 if(in_array($USER_PRIV,$PrivateElementArray)||$USER_PRIV==1||$USER_PRIV==2||$USER_PRIV==3)		{
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL = 0;
			}
			else	{
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL = 1;
			}
			//����Ϊ��ע��Ϣ
			$ElementIndexArray = array();
			for($XY=0;$XY<sizeof($PrivateElementArray);$XY++)	{
			$ElementIndex = $PrivateElementArray[$XY];
			$ElementIndexArray[$XY] = returntablefield("systemprivate","ID",$ElementIndex,"NAME");
			}
			$ElementIndexName = join(', ',$ElementIndexArray);
			$fields['USER_PRIVATE_TEXT'][$FieldNameIndex] = $common_html['common_html']['IsEditPrivate'].": ".$ElementIndexName;
			}
			else	{
			//û�ж��壬�����еİ�Ĭ��ֵ���У���д
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL = 0;
			}

			//���������
			//print_R($SYSTEM_PRIVATE_USER_DEFINE_CONTROL);
			*/
		//�ж��Ƿ�Ҫ�����û�����ķǽ�ɫֻ���Ǳ༭ѡ�� -- ����
		$SYSTEM_PRIVATE_USER_DEFINE_CONTROL = 0;
		//######################################################


		$filter_explode=explode(':',$filterarray[$i]);
		//print_R($filter_explode);print "<BR>";
		if(sizeof($filter_explode)==1)		{
			$fields['filter'][$i]=$filterarray[$i];

			//ΪTEXTAREA׼��Ĭ��ֵ��ֵ
			$fields['other']['textarea'][$FieldNameIndex]['rows']=5;
			$fields['other']['textarea'][$FieldNameIndex]['cols']=35;

			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "readonly" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='ajax')	{
			$fields['filter'][$i]='ajax';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$fields['select'][$i]['tablename']=$filter_explode[1];
			$temp_name=returntablecolumn($filter_explode[1]);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			$fields['select'][$i]['initvalue']=$filter_explode[4];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='radiofilter')	{
			$fields['filter'][$i]='radio';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$fields['select'][$i]['tablename']=$filter_explode[1];
			$temp_name=returntablecolumn($filter_explode[1]);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			$fields['select'][$i]['initvalue']=$filter_explode[4];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;

		}
		else if($filter_explode[0]=='radiofiltergroup')	{
			$fields['filter'][$i]='radiogroup';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$fields['select'][$i]['tablename']=$filter_explode[1];
			$temp_name=returntablecolumn($filter_explode[1]);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			$fields['select'][$i]['initvalue']=$filter_explode[6];
			$groupFieldIndex = $filter_explode[4];
			$fields['select'][$i]['groupfield']=$temp_name[$groupFieldIndex];
			$fields['select'][$i]['groupvalue']=$filter_explode[5];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;

		}
		else if($filter_explode[0]=='tablefilter')	{
			$fields['filter'][$i]='select';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$fields['select'][$i]['tablename']=$filter_explode[1];
			$temp_name=returntablecolumn($filter_explode[1]);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			$fields['select'][$i]['initvalue']=$filter_explode[4];
			$fields['select'][$i]['setfieldname']=$filter_explode[5];
			$fields['select'][$i]['setfieldvalue']=$filter_explode[6];
			$fields['select'][$i]['setfieldboolean']=$filter_explode[7];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='tablefilterpriv')	{
			$fields['filter'][$i]='selectpriv';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$fields['selectpriv'][$i]['tablename']=$filter_explode[1];
			$temp_name=returntablecolumn($filter_explode[1]);
			$fields['selectpriv'][$i]['value']=$temp_name[$index2];
			$fields['selectpriv'][$i]['field']=$temp_name[$index3];
			$fields['selectpriv'][$i]['initvalue']=$filter_explode[4];
			$fields['selectpriv'][$i]['userpriv']=$filter_explode[5];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='tablefiltercolor')	{
			$fields['filter'][$i]='selectcolor';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$fields['select'][$i]['tablename']=$filter_explode[1];
			$temp_name=returntablecolumn($filter_explode[1]);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			$fields['select'][$i]['initvalue']=$filter_explode[4];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='tablefilter2')	{
			$fields['filter'][$i]='select2';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$fields['select'][$i]['tablename']=$filter_explode[1];
			$temp_name=returntablecolumn($filter_explode[1]);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			$fields['select'][$i]['initvalue']=$filter_explode[4];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='tablefilter6')	{
			$fields['filter'][$i]='tablefilter6';
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='tablefilter3')	{
			$fields['filter'][$i]='tablefilter3';
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='tablefilter_two')	{
			$fields['filter'][$i]='select_two';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$index4=$filter_explode[4];
			$index5=$filter_explode[5];
			$index6=$filter_explode[6];
			$index7=$filter_explode[7];
			$index8=$filter_explode[8];
			$index9=$filter_explode[9];
			switch($index5)				{
				case 'session':
					switch($index6)		{
						case 'dept':
							$where_value=$_SESSION[$SUNSHINE_USER_DEPT_VAR];
							break;
					}
					break;
			}

			$fields['select'][$i]['tablename']=$filter_explode[1];
			$temp_name=returntablecolumn($filter_explode[1]);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			$fields['select'][$i]['where_table']=$index5;
			$where_table_columns=returntablecolumn($index5);
			$fields['select'][$i]['where_value']=$where_value;
			$fields['select'][$i]['where_table_value']=$where_table_columns[$index6];
			$fields['select'][$i]['where_table_name']=$where_table_columns[$index7];
			$fields['select'][$i]['where']=$where_table_columns[$index4];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='tablefilter_select_input')	{
			$fields['filter'][$i]='select_select_input';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$index4=$filter_explode[4];
			$index5=$filter_explode[5];
			switch($index5)				{
				case 'session':
					switch($index6)		{
						case 'dept':
							$where_value=$_SESSION[$SUNSHINE_USER_DEPT_VAR];
							break;
					}
					break;
			}
			$fields['select'][$i]['tablename']=$filter_explode[1];
			$temp_name = returntablecolumn($filter_explode[1]);
			$temp_html_etc = returnsystemlang($filter_explode[1]);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			$fields['select'][$i]['secondType']=$index4;
			$fields['select'][$i]['secondIndex']=$index5;
			$fields['select'][$i]['secondIndexName']=$temp_name[$index5];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='userdefine')	{
			$fields['filter'][$i] = $filter_explode[0];
			$fields['userdefine'][$i] = $filter_explode[1];

			if(sizeof($filter_explode)>2)
			{
				for($j=2;$j<sizeof($filter_explode);$j++)
				{
					$fields['input'][$i][$j-2] = $filter_explode[$j];

				}
			}

			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='select_input')	{
			$fields['filter'][$i]='select_input';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$index4=$filter_explode[4];
			$tablename_=$filter_explode[1];
			$fields['select'][$i]['tablename']=$tablename_;
			$temp_name=returntablecolumn($tablename_);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			$fields['select'][$i]['userField']=$index4;
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='select_textarea')	{
			$fields['filter'][$i]='select_textarea';
			$index2=$filter_explode[2];
			$index3=$filter_explode[3];
			$tablename_=$filter_explode[1];
			$fields['select'][$i]['tablename']=$tablename_;
			$temp_name=returntablecolumn($tablename_);
			$fields['select'][$i]['value']=$temp_name[$index2];
			$fields['select'][$i]['field']=$temp_name[$index3];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='checkread')	{
			$fields['filter'][$i]='checkread';
			$fields['checkread'][$i]['field']=$filter_explode[1];
			$fields['checkread'][$i]['type']=$filter_explode[2];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='link')	{
			$fields['filter'][$i]='link';
			$fields['link'][$i]['url']=$filter_explode[1];
			$fields['link'][$i]['target']=$filter_explode[2];
			$fields['link'][$i]['filename']=$filter_explode[3];
		}
		else if($filter_explode[0]=='boolean')	{
			$fields['filter'][$i]='boolean';
			$fields['boolean'][$i]['value']=$filter_explode[1];
		}
		else if($filter_explode[0]=='hidden_field')	{
			$fields['filter'][$i]='hidden_field';
			$fields['hidden_field'][$i]['hiddenid']=$filter_explode[1];
			$fields['hidden_field'][$i]['hiddentype']=$filter_explode[2];
		}
		else if($filter_explode[0]=='multiselect')	{
			$fields['filter'][$i]='multiselect';
			$fields['multiselect'][$i]['tablename']=$filter_explode[1];
			$temp_name=returntablecolumn($filter_explode[1]);
			$fields['multiselect'][$i]['value']=$temp_name[(String)$filter_explode[2]];
			$fields['multiselect'][$i]['field']=$temp_name[(String)$filter_explode[3]];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='textarea')	{
			$fields['filter'][$i]='textarea';
			//print $FieldNameIndex;print_R($filter_explode);exit;
			if(TRIM($filter_explode[1])=="" || TRIM($filter_explode[2])=="")	{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=5;
				$fields['other']['textarea'][$FieldNameIndex]['cols']=35;
			}
			else		{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=TRIM($filter_explode[2]);
				$fields['other']['textarea'][$FieldNameIndex]['cols']=TRIM($filter_explode[1]);
				$fields['other']['textarea'][$FieldNameIndex]['other']=TRIM($filter_explode[3]);
			}
			//ΪTEXTAREA׼��ADDTEXT��ֵ

			if(TRIM($filter_explode[3])!="")		{
				$fields['INPUT_TEXT'][$FieldNameIndex] = $filter_explode[3];
			}

			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='jumpkehumulti')
		{
			$fields['filter'][$i]='jumpkehumulti';
			if(TRIM($filter_explode[1])=="" || TRIM($filter_explode[2])=="")	{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=5;
				$fields['other']['textarea'][$FieldNameIndex]['cols']=35;
			}
			else		{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=TRIM($filter_explode[2]);
				$fields['other']['textarea'][$FieldNameIndex]['cols']=TRIM($filter_explode[1]);
				$fields['other']['textarea'][$FieldNameIndex]['other']=TRIM($filter_explode[3]);
			}
		}
		else if($filter_explode[0]=='jumplinkmanmulti')
		{
			$fields['filter'][$i]='jumplinkmanmulti';
			if(TRIM($filter_explode[1])=="" || TRIM($filter_explode[2])=="")	{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=5;
				$fields['other']['textarea'][$FieldNameIndex]['cols']=35;
			}
			else		{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=TRIM($filter_explode[2]);
				$fields['other']['textarea'][$FieldNameIndex]['cols']=TRIM($filter_explode[1]);
				$fields['other']['textarea'][$FieldNameIndex]['other']=TRIM($filter_explode[3]);
			}
		}
		else if($filter_explode[0]=='jumpsupplylinkmanmulti')
		{
			$fields['filter'][$i]='jumpsupplylinkmanmulti';
			if(TRIM($filter_explode[1])=="" || TRIM($filter_explode[2])=="")	{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=5;
				$fields['other']['textarea'][$FieldNameIndex]['cols']=35;
			}
			else		{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=TRIM($filter_explode[2]);
				$fields['other']['textarea'][$FieldNameIndex]['cols']=TRIM($filter_explode[1]);
				$fields['other']['textarea'][$FieldNameIndex]['other']=TRIM($filter_explode[3]);
			}
		}
		else if($filter_explode[0]=='readonlytextarea')	{
			$fields['filter'][$i]='readonlytextarea';
			//print $FieldNameIndex;print_R($filter_explode);exit;
			if(TRIM($filter_explode[1])=="" || TRIM($filter_explode[2])=="")	{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=5;
				$fields['other']['textarea'][$FieldNameIndex]['cols']=35;
			}
			else		{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=TRIM($filter_explode[2]);
				$fields['other']['textarea'][$FieldNameIndex]['cols']=TRIM($filter_explode[1]);
			}
			//ΪTEXTAREA׼��ADDTEXT��ֵ
			if(TRIM($filter_explode[3])!="")		{
				$fields['INPUT_TEXT'][$FieldNameIndex] = $filter_explode[3];
			}

			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='readonlymulti')	{
			$fields['filter'][$i]='readonlymulti';
			//print $FieldNameIndex;print_R($filter_explode);exit;
			if(TRIM($filter_explode[1])=="" || TRIM($filter_explode[2])=="")	{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=5;
				$fields['other']['textarea'][$FieldNameIndex]['cols']=45;
			}
			else		{
				$fields['other']['textarea'][$FieldNameIndex]['rows']=TRIM($filter_explode[2]);
				$fields['other']['textarea'][$FieldNameIndex]['cols']=TRIM($filter_explode[1]);
			}
			//ΪTEXTAREA׼��ADDTEXT��ֵ
			if(TRIM($filter_explode[3])!="")		{
				$fields['INPUT_TEXT'][$FieldNameIndex] = $filter_explode[3];
			}

			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
		}
		else if($filter_explode[0]=='money' || $filter_explode[0]=='number')	{
			$fields['filter'][$i] = $filter_explode[0];
			$fields['INPUT_TEXT'][$FieldNameIndex] = $filter_explode[1];
			$fields['inputsize'][$FieldNameIndex] = $filter_explode[2];
			if($filter_explode[3]!='')
			{
				$limited = explode("-",$filter_explode[3]);
				$fields['min'][$FieldNameIndex]=$limited[0];
				$fields['max'][$FieldNameIndex]=$limited[1];
			}
			
			
		}
		//Ĭ��ѡ�INPUT������δ�����������ô�����
		else	{
			$fields['filter'][$i] = $filter_explode[0];
			$fields['INPUT_TEXT'][$FieldNameIndex] = $filter_explode[1];
			//�û������ɫȨ�ޣ��Ƿ�Ϊֻ��(��д)ѡ��
			$SYSTEM_PRIVATE_USER_DEFINE_CONTROL==1 ?
			$fields['USER_PRIVATE'][$FieldNameIndex] = "disabled" :
			$fields['USER_PRIVATE'][$FieldNameIndex] = "" ;
			$fields['inputsize'][$FieldNameIndex] = $filter_explode[2];
			$fields['inputother'][$FieldNameIndex] = $filter_explode[3];
		}
	}
	$fields['other']['title']=$common_html['common_html']['add'];
	$fields['other']['inputsize']=30;
	$fields['other']['inputcols']=2;
	$fields['other']['class']='SmallInput';

	$fields['form']['action']='action=add_data';
	$fields['form']['name']='form1';
	$fields['table']['name']=$tablename;
	$fields['table']['colspan']=sizeof($fields['name'])+2;
	$fields['table']['primarykey']=$primarykey;
	$fields['table']['uniquekey']=$uniquekey;
	$fields['table']['primarykeyindex']=$columns[$primarykey];
	return $fields;
}

function newai_merge($fields,$merge)						{
	$name=$fields['name'];

	array_pop($fields['name']);
	$array_pop=array_pop($name);
	for($i=0;$i<sizeof($fields['value']);$i++)		{
		$attachmentname=$array_pop;

		$attachmentid=$name[sizeof($name)-1];

		//array_pop($fields['value'][$i]);
		$value_id=$fields['value'][$i][$attachmentid];
		$value_name=$fields['value'][$i][$attachmentname];
		if($value_id!=''&&$value_name!='')
		$new_id=returnfileurl($value_id,$value_name);
		else	{
			$new_id='';
		}
		array_pop($fields['value'][$i]);
		$fields['value'][$i][$attachmentid]=$new_id;
	}
	//print_R($fields['value']);
	return $fields;
}

function newai_childsums($fields,$childsums)						{
	global $common_html,$columns,$SYTEM_CONFIG_TABLE;
	global $UserUnitFunctionIndex;
	
	if($UserUnitFunctionIndex!="")	{
		$UserUnitFunctionIndexName = "[".$UserUnitFunctionIndex."]";
	}
	$name=$fields['name'];

	$child_array=explode(':',$childsums);
	$columns_child=returntablecolumn($child_array[1]);
	$html_etc_child=returnsystemlang($child_array[1],$SYTEM_CONFIG_TABLE);
	$index=$columns[$child_array[0]];

	array_push($fields['name'],'childsums');
	$array_pop=array_push($name,'childsums');
	
	for($i=0;$i<sizeof($fields['value']);$i++)		{
		$indexid=$fields['value'][$i][$index];
		$employeenums=returnrecordsum($child_array[1],$columns_child[(string)$child_array[2]],$indexid,$columns_child[(string)$child_array[3]]);
		
		$fields['value'][$i]['childsums']=$employeenums." ".$UserUnitFunctionIndexName;
	}
	//print_R($fields['value']);
	return $fields;
}

function newai_childnums($fields,$childnums)						{
	global $common_html,$columns,$SYTEM_CONFIG_TABLE;
	$name=$fields['name'];

	$child_array=explode(':',$childnums);
	$columns_child=returntablecolumn($child_array[1]);
	$html_etc_child=returnsystemlang($child_array[1],$SYTEM_CONFIG_TABLE);
	$index=$columns[$child_array[0]];

	array_push($fields['name'],'childnums');
	$array_pop=array_push($name,'childnums');
	for($i=0;$i<sizeof($fields['value']);$i++)		{
		$indexid=$fields['value'][$i][$index];
		$employeenums=returnrecordnum($child_array[1],$columns_child[(string)$child_array[2]],$indexid);
		$fields['value'][$i]['childnums']=$employeenums;
	}
	//print_R($fields['value']);
	return $fields;
}

function return_parent_group()		{
	global $common_html,$db,$group_user,$SYTEM_CONFIG_TABLE;
	global $SUNSHINE_USER_NAME_VAR,$SUNSHINE_USER_ID_VAR,$_SESSION;
	$group_user_array=explode(':',$group_user);
	$columns_group=returntablecolumn($group_user_array[0]);
	$html_etc_group=returnsystemlang($group_user_array[0],$SYTEM_CONFIG_TABLE);
	$group_array['tablename']=$group_user_array[0];
	$group_array['sql_text'][(string)$group_user_array[1]]=$columns_group[(string)$group_user_array[2]];
	$group_array['sql_text'][(string)$group_user_array[3]]=$columns_group[(string)$group_user_array[4]];
	$group_array['sql_text'][(string)$group_user_array[5]]=$columns_group[(string)$group_user_array[6]];
	$group_array['sql_text'][(string)$group_user_array[7]]=$columns_group[(string)$group_user_array[8]];
	$group_array['sql_text'][(string)$group_user_array[9]]=$group_user_array[10];
	return $group_array;
}

function return_navigation($navigation,$value)		{
	$temp=array();
	if($value==''||$value==0)
	return array(0);
	while($value!=0)		{
		array_push($temp,$value);
		$value=$navigation['parent'][$value];
	}
	array_push($temp,0);
	$temp=array_reverse($temp);
	return $temp;
}



function show_submit_element($action_submit,$align='middle')		{
	global $common_html,$_GET;
	global $tablename,$primarykey_index,$print_title;
	$temp_array=explode('_',$_GET['action']);
	$mark=$temp_array[1];

	$action_model_array=explode(',',$action_submit);
	for($i=0;$i<sizeof($action_model_array);$i++)	{
		$index_mid=$action_model_array[$i];
		$index_array=explode('_',$index_mid);
		$index=$index_array[0];
		$index_array=explode(':',$index);
		$index0=$index_array[0];
		$index1=$index_array[1];
		if($index1!='')		{
			$index_name=$index1;
		}
		else	{
			$index_name=$index0;
		}
		
		switch($index0)	{
			case 'submit':
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='submit';
				$array[$i]['shortcut']=$index_array[2];
				$array[$i]['name']='submit';
				break;
			case 'cancel':

				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="if((is_ie && history.length==0) || (!is_ie && history.length==1))  window.close();else history.back();";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				$array[$i]['name']='cancel';
				break;
			case 'return':
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="history.back();";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				break;
				//��ɫȨ��ʱ�õ�MySubmit
			case 'mysubmit':
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="mysubmit();";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				$array[$i]['mysubmit']='mysubmit';
				$array[$i]['name']='mysubmit';
				break;
			case 'userdefine':
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='submit';
				$array[$i]['name']='IsSendMail_Button';
				$array[$i]['shortcut']=$index_array[2];
				$array[$i]['userdefine']='userdefine';
				break;
			case 'userdefine1':
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="UserDefaultAdd();";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['name']='userdefine1';
				$array[$i]['shortcut']=$index_array[2];
				$array[$i]['userdefine1']='userdefine1';
				break;
			case 'modifyrecord':
				$array[$i]['value']=$common_html['common_html'][$index_name];
				$array[$i]['title']=$common_html['common_html'][$index_name];
				$array[$i]['url']="window.open('../JXC/modifyrecord_newai.php?".base64_encode("tablename=$tablename&keyfield=".$primarykey_index."&keyvalue=".$_GET[$primarykey_index])."');";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['name']='modifyrecord';
				$array[$i]['shortcut']=$index_array[2];
				break;
			case 'add':
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="location='?action=".$index0."_".$mark."'";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				$array[$i]['name']='add';
				break;
			case 'init':
				//print_R($index_array);
				if($index_array[3]=='email'||$index_array[3]=='sms')
				$temp_mark=$index_array[1];
				else
				$temp_mark=$mark;
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="location='?action=".$index0."_".$temp_mark."'";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				break;
			case 'delete':
				global $primarykey_index;
				$newarray=returnpagearray();
				$newarray['action']='delete_array';
				//$newarray['returnmodel']='';
				$newarray['pageid']=$_GET['pageid']!=''?$_GET['pageid']:1;
				$newarray['selectid']=$_GET[$primarykey_index].",";
				$makestring=makestring($newarray);
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="javascript:if(confirm('".$common_html['common_html']['reallydelete']."'))location='?$makestring'";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				break;
			case 'set':
				$return=FormPageAction();
				global $tablename;
				$temp_index=explode(':',$index_mid);
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="location='?action=".$temp_index[0]."&table_name=$tablename&table_action=".$_GET['action']."'";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				break;
			case 'print':
				$return=FormPageAction();
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="print_control();";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				$array[$i]['name']='print';
				break;
			case 'export':
				$return=FormPageAction();
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="XExportToExcel('".$print_title."');";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				$array[$i]['name']='export';
				break;
			case 'savelink':
				$return=FormPageAction();
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="form1.action=form1.action+'&addlink=1'";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='submit';
				$array[$i]['shortcut']=$index_array[2];
				$array[$i]['name']='savelink';
				break;
			case 'reply':
				//$actionValue=explode("_",$_GET['action']);
				$actionValueText="";
				//for($m=1;$m<sizeof($actionValue);$m++)	{
				//$actionValueText.="_".$actionValue[$m];
				//}
				$actionValueText="edit_reply";
				$return=FormPageAction("action",$actionValueText);
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="location='?$return'";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				break;
			case 'forward':
				//$actionValue=explode("_",$_GET['action']);
				$actionValueText="";
				//for($m=1;$m<sizeof($actionValue);$m++)	{
				//$actionValueText.="_".$actionValue[$m];
				//}
				$actionValueText="edit_forward";
				$return=FormPageAction("action",$actionValueText);
				$array[$i]['value']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['title']=" ".$common_html['common_html'][$index_name]." ";
				$array[$i]['url']="location='?$return'";
				$array[$i]['class']='SmallButton';
				$array[$i]['type']='button';
				$array[$i]['shortcut']=$index_array[2];
				break;
		}
	}
	is_array($array)?print_submit_element_array($array,$align,6):'';

}

function show_search_element($mark)	{
	global $common_html,$html_etc;
	global $action_search,$columns,$tablename;
	global $group_filter,$db,$action_model,$SYSTEM_ADD_SQL;
	$action_search_array=explode(',',$action_search);
	for($i=0;$i<sizeof($action_search_array);$i++)		{
		$index=$action_search_array[$i];
		$value[$i]=$columns[$index];
		$index_name=$value[$i];
		$name[$i]=$html_etc[$tablename][$index_name];
	}
	
	if($group_filter!='')								{
		$group_filter_array=explode(',',$group_filter);
	
		for($i=0;$i<sizeof($group_filter_array);$i++)		{
			$temp_array=explode(':',$group_filter_array[$i]);

			$index_name=$columns["".$temp_array[0].""];
			//print_r($index_name);
			//�õ�ʵ���õ����ֶ�ֵ�б�����ʼ
			$tablename2=$temp_array[1];
			$attribute=$temp_array[4];//exit;
			$sql_parent = "select DISTINCT $index_name from $tablename where 1=1 $SYSTEM_ADD_SQL order by $index_name";
			if($temp_array[2]=="" && $temp_array[3]=="")
			{
				$fieldname=$index_name;
				$fieldid=$index_name;
			}
			else
			{
				$columns_=returntablecolumn($tablename2);
				$fieldid=$columns_["".$temp_array[2].""];
				$fieldname=$columns_["".$temp_array[3].""];
			
				$datefield=$_GET['ʱ���ֶ�'];
				$addsql='';
				if($datefield!='')
				{
					if($_GET['��ʼʱ��ADD']!="")	
						$addsql.= "and $datefield>='".$_GET['��ʼʱ��ADD']."'";
					if($_GET['����ʱ��ADD']!="")		
						$addsql.= "and $datefield<='".$_GET['����ʱ��ADD']."'"; 
				}
				
				$sql_parent = "select DISTINCT a.$index_name,b.$fieldname from $tablename a left join $tablename2 b on a.$index_name=b.$fieldid where 1=1 $addsql order by b.$fieldname";
				if($tablename2=='producttype')
				{
					$sql_parent = "select DISTINCT $fieldid as $index_name,$fieldname from $tablename2 where $fieldid='".$_GET[$index_name]."'";
					
				}
			}
							
			//���Ӷ���ʦGROUP_FILTER��֧��
			$markSQL = $temp_array[4];

			if($markSQL=="teachersession")	{
				//print_R($_SESSION);
				$sunshine_teacher_code = $_SESSION['sunshine_teacher_code'];
				if($sunshine_teacher_code!="")	{
					$sql_parent = "select DISTINCT ��� from edu_student,edu_banji where edu_student.���=edu_banji.�༶���� and edu_banji.��ʦ����='$sunshine_teacher_code'";
					//print $sql_parent;
				}
			}
			
			$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
			$FILE_SELF_NAME = array_pop($PHP_SELF_ARRAY);
			$FileDirName = array_pop($PHP_SELF_ARRAY);
			//&&$FileDirName=="Teacher" ֻ����TeacherĿ¼����ʹ�� 2010-9-25 ����ʹ��
			//����PGSQL���治�������ݽ���
			//print $_SESSION['LOGIN_USER_ID'];
			//���ǿ��GET�����Ѿ����й�Ԥ����,��ô����Ԥ�������ݽ��� 2010-9-2
			$GET����ֵ = explode(',',$_GET[$index_name]);
			global $_GETȨ�����Ʊ���ֵ;//2010-9-25����Ȩ�����Ʊ�������
			$GET����ֵ_Ȩ�����Ʊ���ֵ = explode(',',$_GETȨ�����Ʊ���ֵ[$index_name]);
			//���GET��ֵֻ��һ��,������GET��ֵ,���GET��ֵΪ����������,����ϵͳֵ

			if($GET����ֵ[1]!="")			{
				$�����ж�����Array = explode(',',$_GET[$index_name]);
				$�����ж����� = "'".join("','",$�����ж�����Array)."'";
				$sql_parent = "select DISTINCT $index_name from $tablename where $index_name in ($�����ж�����) order by $index_name";
			}
			else if($GET����ֵ_Ȩ�����Ʊ���ֵ[0]!='')			{
				$�����ж�����Array = explode(',',$_GETȨ�����Ʊ���ֵ[$index_name]);
				$�����ж����� = "'".join("','",$�����ж�����Array)."'";
				$sql_parent = "select DISTINCT $index_name from $tablename where $index_name in ($�����ж�����) order by $index_name";
			}
			//print $sql_parent."<BR>";exit;
			//����ǵ����򣬲���ѯ�˺�����
			
			$rs_parent = $db->Execute($sql_parent);
			$rs_parent_Array = $rs_parent->GetArray();

			
			//������Ϣ�б�
			$affixation[$i]['tablename']=$tablename2;
			$affixation[$i]['index_name']=$index_name;
			$affixation[$i]['attribute']=$attribute;
			$j=0;
			//print_R($index_name);
			//print_R($rs_parent_Array);
			//2009-5-26���ж����$_GET������ֵ��һ������,��ô�������ݱ������ֵ������ȡ,ת����ȡ���������ֵ
			//��Ҫ��;:���ڽ��Ȩ���ڲ���ֵ�б�����$_GET�б���ʾʱ,��Ȩ��ֵ����Ȩ��֮��,�����������,��ô������HIDDEN����,���Ų�����
			global $_GET2;							//���ⲿ��ȡ����ֵ
			if($_GET2[$index_name]!="")			{	//�ⲿ�����������
				$Ȩ��ֵ������� = explode(',',$_GET2[$index_name]);
				if($Ȩ��ֵ�������[1]!="")	{		//���Ҵ������������
					$rs_parent_Array = array();
					for($ix=0;$ix<count($Ȩ��ֵ�������);$ix++)		{
						$rs_parent_Array[]['���'] = $Ȩ��ֵ�������[$ix];
					}
				}
			}
			
			
			//ʵ��ʹ��
			for($gg=0;$gg<sizeof($rs_parent_Array);$gg++)		{
				$NewValue = $rs_parent_Array[$gg][$index_name];//print "<BR>";
				if($tablename2!="")
					$NewName = $rs_parent_Array[$gg][$fieldname];//print "<BR>";
				else
					$NewName = $rs_parent_Array[$gg][$index_name];
					
				if($NewName!="")							{
					//#######################################################################################
					//2008-10-30��NewValue��ΪNewNameֵ�ж�,Ŀ��:ʹΪ��GROUP_FILTER���б���Զ�̬�ķ����仯,���ӷ���ʵ�ʵ�Ӧ��.
					//#######################################################################################
					$indexid=trim($NewValue);
					$indexname=trim($NewName);
					$affixation[$i]['fieldid'][$j]=trim($NewValue);

					//2009-5-26���VALUE��NAME��ֵһ��,��ôֻ��ʾһ����¼
					if(trim($NewName)==trim($NewValue))	{
						$affixation[$i]['fieldname'][$j]=trim($NewName);
					}
					else	{
						//$affixation[$i]['fieldname'][$j]=trim($NewName)."[".trim($NewValue)."]";
						$affixation[$i]['fieldname'][$j]=trim($NewName);
					}

					if($_GET[$index_name]==$affixation[$i]['fieldid'][$j])	{
						$affixation[$i]['selected'][$j]='selected';
						$affixation_index=$indexname;
					}
					$j++;
				}
					
			}
			
			//��ǰʹ�õ���ʾȫ������ʱ���õ��ķ�ʽ
			/*
			 while(!$rs->EOF)	{
			 $indexid=trim($rs->fields[$fieldid]);
			 $indexname=trim($rs->fields[$fieldname]);
			 $affixation[$i]['fieldid'][$j]=trim($rs->fields[$fieldid]);
			 $affixation[$i]['fieldname'][$j]=trim($rs->fields[$fieldname])."[".trim($rs->fields[$fieldid])."]";
			 $affixation[$i]['tablename']=$tablename2;
			 $affixation[$i]['index_name']=$index_name;
			 $affixation[$i]['attribute']=$attribute;
			 if($_GET[$index_name]==$affixation[$i]['fieldid'][$j])	{
				$affixation[$i]['selected'][$j]='selected';
				$affixation_index=$indexname;
				}
				$j++;
				$rs->MoveNext();

				//}*/
		}//end for
	}//end if
	//print_r($affixation);
	print_search_element_array($name,$value,$mark,$affixation,$affixation_index);
}

function checkread_username($mode='checkread',$markread_value,$index_key)	{
	global $db,$tablename;
	global $_POST,$_GET,$columns,$primarykey,$primarykey_index;
	global $SUNSHINE_USER_NAME_VAR,$SUNSHINE_USER_ID_VAR,$_SESSION;
	global $return_sql_line,$isrechecked;
	$user_value=$_SESSION[$SUNSHINE_USER_NAME_VAR];
	$SQL="select ".$columns[(string)$markread_value]." from $tablename where ".$primarykey_index."='".$index_key."'";
	$rs=$db->CacheExecute(150,$SQL);
	$string=$rs->fields[(string)$columns[(string)$markread_value]];
	$string_array=explode(',',$string);
	$in_array=in_array($user_value,$string_array);
	if($mode=='checkread')	return $in_array;
	if(!$in_array)		{
		$new_value=$string."$user_value,";
		$SQL="update $tablename set ".$columns[(string)$markread_value]."='$new_value' where ".$primarykey_index."='".$index_key."'";
		$result=$db->Execute($SQL);
	}
	if($result->EOF) return false;
	else return true;
}

function markread_record_newai($mode='makeread',$element='')	{
	global $db,$tablename;
	global $_POST,$_GET,$columns,$primarykey,$primarykey_index;
	global $SUNSHINE_USER_NAME_VAR,$SUNSHINE_USER_ID_VAR,$_SESSION;
	global $return_sql_line,$isrechecked;
	$user_value=$_SESSION[$SUNSHINE_USER_NAME_VAR];//$user_value='122';
	$mark_array=explode('_',$_GET['action']);
	switch($mode)		{
		case 'makeread':
			$SQL=$return_sql_line['markread_sql'];//print $SQL;//exit;
			$result=$db->Execute($SQL);
			break;
		case 'makeadd':
			$SQL=$return_sql_line['markadd_sql'];//print $SQL;//exit;
			$result=$db->Execute($SQL);
			break;
		case 'addusername':
			$index_key=$_GET[(string)$columns[$primarykey]];
			//print $index_key;
			checkread_username($mode='addusername',$element[markread],$index_key);
			return;
			break;
	}
	//print $SQL;exit;
	if($result->EOF) return false;
	else return true;
}

function get_record_newai()	{
	global $db;
	global $_POST,$_GET;
	global $return_sql_line,$isrechecked;
	$SQL=$return_sql_line['select_sql'];
	$result=$db->CacheExecute(150,$SQL);
	return $result;
}


function newai_filelist($getdir='statics')	{
	require_once('./class.dir.php');
	$d=new PHP_Dir();
	$dirlist="../cache/".$getdir."/";
	$dir=$d->list_files($dirlist); //print_R($dir);
	for($i=2;$i<sizeof($dir['filename']);$i++)	{
		$filename_b=$dir['filename'][$i];//print_R($filename_b);
		$file_array=explode('_',$filename_b);
		$type=$file_array[0];
		$filelist[$type][$i-2]=$getdir."/".$filename_b;
	}
	return $filelist;
}

function return_summarize($mode='summarize_email',$functionname='summarize_template')	{
	global $html_etc,$common_html;
	global $_SESSION,$SUNSHINE_USER_NAME_VAR,$SUNSHINE_USER_ID_VAR;
	global $db,$_GET,$_POST;
	$USER_ID=$_SESSION[$SUNSHINE_USER_NAME_VAR];
	switch($mode)		{
		case 'summarize_email':
			$infor['title']=$common_html['common_html']['internalemail'];
			$sql_inbox="select count(emailid) as num from email where toid='$USER_ID' and delete_receive=0";
			$rs=$db->Execute($sql_inbox);
			$infor['inbox']['num']=$rs->fields['num'];

			$infor['title']=$common_html['common_html']['internalemail'];
			$sql_inbox="select count(emailid) as num from email where toid='$USER_ID' and delete_receive=0 and readflag=0";
			$rs=$db->Execute($sql_inbox);
			$infor['inbox']['new']=$rs->fields['num'];

			$infor['title']=$common_html['common_html']['internalemail'];
			$sql_outbox="select count(emailid) as num from email where fromid='$USER_ID' and delete_sender=0";
			$rs=$db->Execute($sql_outbox);
			$infor['outbox']['num']=$rs->fields['num'];

			$functionname($infor);
			break;
		case 'summarize_sms':
			$infor['title']=$common_html['common_html']['sms'];
			$sql_inbox="select count(SMS_ID) as num from sms where TO_ID='$USER_ID' and delete_receive=0";
			$rs=$db->Execute($sql_inbox);
			$infor['inbox']['num']=$rs->fields['num'];

			$sql_inbox="select count(SMS_ID) as num from sms where TO_ID='$USER_ID' and REMIND_FLAG=1 and delete_receive=0";
			$rs=$db->Execute($sql_inbox);
			$infor['inbox']['new']=$rs->fields['num'];

			$sql_outbox="select count(SMS_ID) as num from sms where FROM_ID='$USER_ID' and delete_sender=0";
			$rs=$db->Execute($sql_outbox);
			$infor['outbox']['num']=$rs->fields['num'];
			$functionname($infor);
			break;
	}

}
function array_show()						{
	global $SUNSHINE_USER_NAME_VAR,$SUNSHINE_USER_ID_VAR,$_SESSION;
	global $array_show,$primarykey_index,$primarykey,$common_html;
	$USER_ID=$_SESSION[$SUNSHINE_USER_NAME_VAR];
	$ID=$_SESSION[$SUNSHINE_USER_ID_VAR];
	$show_array=explode(',',$array_show);
	for($i=0;$i<sizeof($show_array);$i++)		{
		$element=explode(':',$show_array[$i]);
		$link="?action=".$element[1];
		print "<BR><div align=\"center\"><input type=\"button\" value=\"".$common_html['common_html'][(string)$element[0]]."\" class=\"SmallButton\" onClick=\"location='$link'\"></div><BR>\n";
	}

}
?>