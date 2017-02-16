<?php
class ReadExcel
{
	var $excfile = '';
	function ReadExcel($readfile)
	{
		$this->excfile = $readfile;
	}
	function read()
	{
		$reArr = array();
		include_once( "excelparser/excelparser.php" );
		$exc = new ExcelFileParser();
		$res = $exc->ParseFromFile($this->excfile);
		$RS = $exc->worksheet['data'];
		//print_R($RS);exit;

		for($she = 0;$she <=count($exc->worksheet['name']);$she++)
		{
			for( $col=0;$col<=$exc->worksheet['data'][0]['max_col'];$col++ )
			{
				for($row=0;$row<=$exc->worksheet['data'][0]['max_row'];$row++)
				{
					 $data = $exc->worksheet['data'][0]['cell'][$row][$col];
					 $ind = $data['data'];
					 
					
					 switch ($data['type'])				{
							// string
							case 0:
								$ind = $data['data'];
								if( $exc->sst['unicode'][$ind] )
								{
									$s = $this->uc2html($exc->sst['data'][$ind]);
								}
								else
								{
									$s = $exc->sst['data'][$ind];
								}
								if( strlen(trim($s))==0 )
									$reArr[$she][$col][$row] = "";
								else
									$reArr[$she][$col][$row] = $s;
								break;
							// integer number
							case 1:
								$s = $data['data'];
								$reArr[$she][$col][$row] = $s;
								break;
							// float number
							case 2:
								$s = $data['data'];
								$reArr[$she][$col][$row] = $s;
								break;
							// date
							case 3:
								$s = $data['data'];
								
								//$ret = str_replace( " 00:00:00", "", gmdate( "Y-m-d H:i:s", $exc->xls2tstamp( $s ) ) );
								$ret = str_replace( " 00:00:00", "", $s );
								$reArr[$she][$col][$row] = $ret;
								break;
							default:
								$ind = $data['data'];
								if( $exc->sst['unicode'][$ind] )
								{
									$s = $this->uc2html($exc->sst['data'][$ind]);
								}
								else
								{
									$s = $exc->sst['data'][$ind];
								}
								if( strlen(trim($s))==0 )
									$reArr[$she][$col][$row] = "";
								else
									$reArr[$she][$col][$row] = $s;
								break;
					}
					//print $data['type'].":".$reArr[$she][$col][$row]."<BR>";
			}
		}
	}

	//print_R($reArr);
	return $reArr;
}


 function uc2html($str)					{
	$ret = '';
	for( $i=0; $i<strlen($str)/2; $i++ )
	{
		$charcode = ord($str[$i*2])+256*ord($str[$i*2+1]); //一个汉字
		if($charcode > 128)
		{
			//convert to char
			$src_str_hex = dechex($charcode);
			$char1 = substr($src_str_hex,0,2);
			$char2 = substr($src_str_hex,2,2);
			$char=chr(hexdec($char1)).chr(hexdec($char2));//转成unicode字符

			$s=$char;
			$gbk = iconv("UTF-16","GBK",$s);
			$ret.=$gbk;
		}
		else{
			$ret.=$str[$i*2];
		}
	}
	return $ret;
	}
}





//此文件被其它文件调用,不宜在此做测试
//$a = new ReadExcel("Book1.xls");
//$tmp = $a->read();
//print_R($tmp);






?>