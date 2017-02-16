<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

$TargetDatetime = "2012-07-18 00:00:00";
//if(date("Y")!="2025")			{
//	print "当前系统时间不为2025,请重新设定!";
//	exit;
//}

$OneDir		= "D:/PHPProject/SunshineJXC/www/general/ERP/";
$TargetDir	= "D:/PHPProject/SunshineJXC/www/UPDATE_PACKET/ERP/";
$TargetDir2 = "D:/PHPProject/SunshineJXC/www/UPDATE_PACKET/";


//目录文件验证
$TargetDirNAME = substr($TargetDatetime,0,10);

if(!is_dir($TargetDir2.$TargetDirNAME))   {
	rename($TargetDir2."ERP",$TargetDir2.$TargetDirNAME);
	mkdir($TargetDir2."ERP");
}


$JumpFile[] = "sms_config.ini";
$JumpFile[] = "config_mssql_studentkaoqin.php";
$JumpFile[] = "config_mssql_teacherkaoqin.php";
$JumpFile[] = "SCHOOL_MODEL.ini";
$JumpFile[] = "system_config.ini";
$JumpFile[] = "cache.inc.php";
$JumpFile[] = "config.php";

$ReadZipFileList .= ReadZipFileList("/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("adodb/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("adodb/session/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("adodb/drivers/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("databackup/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Development/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Development/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/lib/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/jquery/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/userdefine/",$TargetDatetime);

$ReadZipFileList .= ReadZipFileList("Enginee/Module/dept_select_single/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/kehu_select_multi/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/kehu_select_single/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/linkman_select_multi/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/prodtype_select_single/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/product_select_single/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/supply_select_single/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/supplylinkman_select_multi/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/user_select/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/user_select_single/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Enginee/Module/workplan_select_single/",$TargetDatetime);

$ReadZipFileList .= ReadZipFileList("Framework/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/FusionCharts/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/images/menu/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/inc/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/inc/img/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/phpmailer/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/sms_index/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/tiny_mce/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/PHPExcelParser4/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/PHPExcelParser4/excelparser/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Framework/PHPExcelParser4/WriteExcel/",$TargetDatetime);

$ReadZipFileList .= ReadZipFileList("Interface/",$TargetDatetime);

$ReadZipFileList .= ReadZipFileList("Interface/EDU/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/Help/",$TargetDatetime);


$ReadZipFileList .= ReadZipFileList("Interface/CRM/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/CRM/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/CRM/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/CRM/userdefine/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/CRM/erp_mytable/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/CRM/calendar/",$TargetDatetime);

$ReadZipFileList .= ReadZipFileList("Interface/JXC/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/JXC/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/JXC/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/JXC/userdefine/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/JXC/DAO/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/JXC/DataQuery/",$TargetDatetime);

$ReadZipFileList .= ReadZipFileList("Interface/LODOP60/",$TargetDatetime);

$ReadZipFileList .= ReadZipFileList("Interface/DICT/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/DICT/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/DICT/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/DICT/userdefine/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/DICT/templates/",$TargetDatetime);


$ReadZipFileList .= ReadZipFileList("Interface/officeproduct/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/officeproduct/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/officeproduct/Module/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/officeproduct/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/officeproduct/userdefine/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/officeproduct/templates/",$TargetDatetime);


$ReadZipFileList .= ReadZipFileList("Interface/WuYeGuanLi/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/WuYeGuanLi/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/WuYeGuanLi/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/WuYeGuanLi/userdefine/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/WuYeGuanLi/templates/",$TargetDatetime);


$ReadZipFileList .= ReadZipFileList("Interface/fixedasset/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/fixedasset/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/fixedasset/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/fixedasset/userdefine/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/fixedasset/templates/",$TargetDatetime);


$ReadZipFileList .= ReadZipFileList("Interface/HOUQIN/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/HOUQIN/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/HOUQIN/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/HOUQIN/userdefine/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/HOUQIN/templates/",$TargetDatetime);


$ReadZipFileList .= ReadZipFileList("Interface/WUYE/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/WUYE/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/WUYE/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/WUYE/userdefine/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/WUYE/templates/",$TargetDatetime);

$ReadZipFileList .= ReadZipFileList("Interface/Framework/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/Framework/Model/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/Framework/images/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/Framework/userdefine/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("Interface/Framework/templates/",$TargetDatetime);

$ReadZipFileList .= ReadZipFileList("LOGIN/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("theme/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("theme/3/",$TargetDatetime);
$ReadZipFileList .= ReadZipFileList("theme/3/images/",$TargetDatetime);



//print_R($ReadZipFileList);

//writeFileRemote("E:\updatepacketlist.txt",$ReadZipFileList);

$ReadZipFileListArray = explode('::',$ReadZipFileList);







//exit;
for($i=0;$i<sizeof($ReadZipFileListArray);$i++)			{
	$Element = $ReadZipFileListArray[$i];
	if($Element!="")			{
		$fileArray	= explode('/',$Element);
		$filename		= array_pop($fileArray);
		if(in_array($filename,$JumpFile))			{
		}
		else	{
			copy($OneDir.$Element,$TargetDir.$Element);
			//$time = mktime('1','1','1','01','10','2025');
			//touch($TargetDir."/".$Element,$time,$time);
			print $Element."<BR>";
		}

	}


}




function writeFileRemote($filename,$text)		{
	if(strlen($text)==0)	return;
	@!$handle = fopen($filename, 'w');
	if (!fwrite($handle, $text)) {
		exit;
		}
	fclose($handle);
	print "HTTP下载文件完成";
}

function ReadZipFileList($testdir,$TargetDatetime)					{
	global $SYSTEMDOCLINK,$TargetDir;
	//print $TargetDir."".$testdir;//exit;
	if(!is_dir($TargetDir."".$testdir))	mkdir($TargetDir."".$testdir);
	$d=opendir($testdir."/");
	$dirList  = array();
	$fileSizeList = array();
	while($file=readdir($d)){
		if($file!='.'&&$file!='..'&&$file!='')		{
			$path=$testdir."/".$file;
			if(is_file($path))		{
				//print $path."DIR<BR>";
				$filectime = filemtime($path);
				$curtime = date("Y-m-d H:i:s",$filectime);
				//print $curtime;print "<BR>";
				//&&$file!="update.txt"
				if($curtime!="2025-01-10 01:01:00"&&$curtime>$TargetDatetime&&$file!="license.ini"&&$file!="Thumbs.db"&&$file!="ReturnUpdatePacketInfor.php")		{
					$ReturnText .= $testdir."".$file."::";
					//print $testdir."".$file."<BR>";;
				}
			}
		}
	}//end while
	//print $curtime;exit;
	return $ReturnText;
}

//以下是类及函数定义
class Zip //ZIP压缩类
{

 var $datasec, $ctrl_dir = array();
 var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
 var $old_offset = 0; var $dirs = Array(".");

 function get_List($zip_name)
 {
   $zip = @fopen($zip_name, 'rb');
   if(!$zip) return(0);
   $centd = $this->ReadCentralDir($zip,$zip_name);

    @rewind($zip);
    @fseek($zip, $centd['offset']);

   for ($i=0; $i<$centd['entries']; $i++)
   {
    $header = $this->ReadCentralFileHeaders($zip);
    $header['index'] = $i;$info['filename'] = $header['filename'];
    $info['stored_filename'] = $header['stored_filename'];
    $info['size'] = $header['size'];$info['compressed_size']=$header['compressed_size'];
    $info['crc'] = strtoupper(dechex( $header['crc'] ));
    $info['mtime'] = $header['mtime']; $info['comment'] = $header['comment'];
    $info['folder'] = ($header['external']==0x41FF0010||$header['external']==16)?1:0;
    $info['index'] = $header['index'];$info['status'] = $header['status'];
    $ret[]=$info; unset($header);
   }
  return $ret;
 }
 function Add($files,$compact)
 {
  if(!is_array($files[0])) $files=Array($files);

  for($i=0;$files[$i];$i++){
    $fn = $files[$i];
    if(!in_Array(dirname($fn[0]),$this->dirs))
     $this->add_Dir(dirname($fn[0]));
    if(basename($fn[0]))
     $ret[basename($fn[0])]=$this->add_File($fn[1],$fn[0],$compact);
  }
  return $ret;
 }

 function get_file()
 {
   $data = implode('', $this -> datasec);
   $ctrldir = implode('', $this -> ctrl_dir);

   return $data . $ctrldir . $this -> eof_ctrl_dir .
    pack('v', sizeof($this -> ctrl_dir)).pack('v', sizeof($this -> ctrl_dir)).
    pack('V', strlen($ctrldir)) . pack('V', strlen($data)) . "\x00\x00";
 }

 function add_dir($name)
 {
   $name = str_replace("\\", "/", $name);
   $fr = "\x50\x4b\x03\x04\x0a\x00\x00\x00\x00\x00\x00\x00\x00\x00";

   $fr .= pack("V",0).pack("V",0).pack("V",0).pack("v", strlen($name) );
   $fr .= pack("v", 0 ).$name.pack("V", 0).pack("V", 0).pack("V", 0);
   $this -> datasec[] = $fr;

   $new_offset = strlen(implode("", $this->datasec));

   $cdrec = "\x50\x4b\x01\x02\x00\x00\x0a\x00\x00\x00\x00\x00\x00\x00\x00\x00";
   $cdrec .= pack("V",0).pack("V",0).pack("V",0).pack("v", strlen($name) );
   $cdrec .= pack("v", 0 ).pack("v", 0 ).pack("v", 0 ).pack("v", 0 );
   $ext = "\xff\xff\xff\xff";
   $cdrec .= pack("V", 16 ).pack("V", $this -> old_offset ).$name;

   $this -> ctrl_dir[] = $cdrec;
   $this -> old_offset = $new_offset;
   $this -> dirs[] = $name;
 }

 function add_File($data, $name, $compact = 1)
 {
   $name     = str_replace('\\', '/', $name);
   $dtime    = dechex($this->DosTime());

   $hexdtime = '\x' . $dtime[6] . $dtime[7].'\x'.$dtime[4] . $dtime[5]
     . '\x' . $dtime[2] . $dtime[3].'\x'.$dtime[0].$dtime[1];
   eval('$hexdtime = "' . $hexdtime . '";');

   if($compact)
   $fr = "\x50\x4b\x03\x04\x14\x00\x00\x00\x08\x00".$hexdtime;
   else $fr = "\x50\x4b\x03\x04\x0a\x00\x00\x00\x00\x00".$hexdtime;
   $unc_len = strlen($data); $crc = crc32($data);

   if($compact){
     $zdata = gzcompress($data); $c_len = strlen($zdata);
     $zdata = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
   }else{
     $zdata = $data;
   }
   $c_len=strlen($zdata);
   $fr .= pack('V', $crc).pack('V', $c_len).pack('V', $unc_len);
   $fr .= pack('v', strlen($name)).pack('v', 0).$name.$zdata;

   $fr .= pack('V', $crc).pack('V', $c_len).pack('V', $unc_len);

   $this -> datasec[] = $fr;
   $new_offset        = strlen(implode('', $this->datasec));
   if($compact)
        $cdrec = "\x50\x4b\x01\x02\x00\x00\x14\x00\x00\x00\x08\x00";
   else $cdrec = "\x50\x4b\x01\x02\x14\x00\x0a\x00\x00\x00\x00\x00";
   $cdrec .= $hexdtime.pack('V', $crc).pack('V', $c_len).pack('V', $unc_len);
   $cdrec .= pack('v', strlen($name) ).pack('v', 0 ).pack('v', 0 );
   $cdrec .= pack('v', 0 ).pack('v', 0 ).pack('V', 32 );
   $cdrec .= pack('V', $this -> old_offset );

   $this -> old_offset = $new_offset;
   $cdrec .= $name;
   $this -> ctrl_dir[] = $cdrec;
   return true;
 }

 function DosTime() {
   $timearray = getdate();
   if ($timearray['year'] < 1980) {
     $timearray['year'] = 1980; $timearray['mon'] = 1;
     $timearray['mday'] = 1; $timearray['hours'] = 0;
     $timearray['minutes'] = 0; $timearray['seconds'] = 0;
   }
   return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) |     ($timearray['mday'] << 16) | ($timearray['hours'] << 11) |
    ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
 }

 function Extract ( $zn, $to, $index = Array(-1) )
 {
   $ok = 0; $zip = @fopen($zn,'rb');
   if(!$zip) return(-1);
   $cdir = $this->ReadCentralDir($zip,$zn);
   $pos_entry = $cdir['offset'];

   if(!is_array($index)){ $index = array($index);  }
   for($i=0; $index[$i];$i++){
     if(intval($index[$i])!=$index[$i]||$index[$i]>$cdir['entries'])
      return(-1);
   }

   for ($i=0; $i<$cdir['entries']; $i++)
   {
     @fseek($zip, $pos_entry);
     $header = $this->ReadCentralFileHeaders($zip);
     $header['index'] = $i; $pos_entry = ftell($zip);
     @rewind($zip); fseek($zip, $header['offset']);
     if(in_array("-1",$index)||in_array($i,$index))
      $stat[$header['filename']]=$this->ExtractFile($header, $to, $zip);

   }
   fclose($zip);
   return $stat;
 }

  function ReadFileHeader($zip)
  {
    $binary_data = fread($zip, 30);
    $data = unpack('vchk/vid/vversion/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len', $binary_data);

    $header['filename'] = fread($zip, $data['filename_len']);
    if ($data['extra_len'] != 0) {
      $header['extra'] = fread($zip, $data['extra_len']);
    } else { $header['extra'] = ''; }

    $header['compression'] = $data['compression'];$header['size'] = $data['size'];
    $header['compressed_size'] = $data['compressed_size'];
    $header['crc'] = $data['crc']; $header['flag'] = $data['flag'];
    $header['mdate'] = $data['mdate'];$header['mtime'] = $data['mtime'];

    if ($header['mdate'] && $header['mtime']){
     $hour=($header['mtime']&0xF800)>>11;$minute=($header['mtime']&0x07E0)>>5;
     $seconde=($header['mtime']&0x001F)*2;$year=(($header['mdate']&0xFE00)>>9)+1980;
     $month=($header['mdate']&0x01E0)>>5;$day=$header['mdate']&0x001F;
     $header['mtime'] = mktime($hour, $minute, $seconde, $month, $day, $year);
    }else{$header['mtime'] = time();}

    $header['stored_filename'] = $header['filename'];
    $header['status'] = "ok";
    return $header;
  }

 function ReadCentralFileHeaders($zip){
    $binary_data = fread($zip, 46);
    $header = unpack('vchkid/vid/vversion/vversion_extracted/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len/vcomment_len/vdisk/vinternal/Vexternal/Voffset', $binary_data);

    if ($header['filename_len'] != 0)
      $header['filename'] = fread($zip,$header['filename_len']);
    else $header['filename'] = '';

    if ($header['extra_len'] != 0)
      $header['extra'] = fread($zip, $header['extra_len']);
    else $header['extra'] = '';

    if ($header['comment_len'] != 0)
      $header['comment'] = fread($zip, $header['comment_len']);
    else $header['comment'] = '';

    if ($header['mdate'] && $header['mtime'])
    {
      $hour = ($header['mtime'] & 0xF800) >> 11;
      $minute = ($header['mtime'] & 0x07E0) >> 5;
      $seconde = ($header['mtime'] & 0x001F)*2;
      $year = (($header['mdate'] & 0xFE00) >> 9) + 1980;
      $month = ($header['mdate'] & 0x01E0) >> 5;
      $day = $header['mdate'] & 0x001F;
      $header['mtime'] = mktime($hour, $minute, $seconde, $month, $day, $year);
    } else {
      $header['mtime'] = time();
    }
    $header['stored_filename'] = $header['filename'];
    $header['status'] = 'ok';
    if (substr($header['filename'], -1) == '/')
      $header['external'] = 0x41FF0010;
    return $header;
 }

 function ReadCentralDir($zip,$zip_name)
 {
  $size = filesize($zip_name);
  if ($size < 277) $maximum_size = $size;
  else $maximum_size=277;

  @fseek($zip, $size-$maximum_size);
  $pos = ftell($zip); $bytes = 0x00000000;

  while ($pos < $size)
  {
    $byte = @fread($zip, 1); $bytes=($bytes << 8) | Ord($byte);
    if ($bytes == 0x504b0506){ $pos++; break; } $pos++;
  }

 $data=unpack('vdisk/vdisk_start/vdisk_entries/ventries/Vsize/Voffset/vcomment_size',fread($zip,18));


  if ($data['comment_size'] != 0)
    $centd['comment'] = fread($zip, $data['comment_size']);
    else $centd['comment'] = ''; $centd['entries'] = $data['entries'];
  $centd['disk_entries'] = $data['disk_entries'];
  $centd['offset'] = $data['offset'];$centd['disk_start'] = $data['disk_start'];
  $centd['size'] = $data['size'];  $centd['disk'] = $data['disk'];
  return $centd;
 }

 function ExtractFile($header,$to,$zip)
 {
   $header = $this->readfileheader($zip);

   if(substr($to,-1)!="/") $to.="/";
   if(!@is_dir($to)) @mkdir($to,0777);

   $pth = explode("/",dirname($header['filename']));
   for($i=0;isset($pth[$i]);$i++){
     if(!$pth[$i]) continue;$pthss.=$pth[$i]."/";
     if(!is_dir($to.$pthss)) @mkdir($to.$pthss,0777);
   }
  if (!($header['external']==0x41FF0010)&&!($header['external']==16))
  {
   if ($header['compression']==0)
   {
    $fp = @fopen($to.$header['filename'], 'wb');
    if(!$fp) return(-1);
    $size = $header['compressed_size'];

    while ($size != 0)
    {
      $read_size = ($size < 2048 ? $size : 2048);
      $buffer = fread($zip, $read_size);
      $binary_data = pack('a'.$read_size, $buffer);
      @fwrite($fp, $binary_data, $read_size);
      $size -= $read_size;
    }
    fclose($fp);
    //touch($to.$header['filename'], $header['mtime']);

  }else{
   $fp = @fopen($to.$header['filename'].'.gz','wb');
   if(!$fp) return(-1);
   $binary_data = pack('va1a1Va1a1', 0x8b1f, Chr($header['compression']),
     Chr(0x00), time(), Chr(0x00), Chr(3));

   fwrite($fp, $binary_data, 10);
   $size = $header['compressed_size'];

   while ($size != 0)
   {
     $read_size = ($size < 1024 ? $size : 1024);
     $buffer = fread($zip, $read_size);
     $binary_data = pack('a'.$read_size, $buffer);
     @fwrite($fp, $binary_data, $read_size);
     $size -= $read_size;
   }

   $binary_data = pack('VV', $header['crc'], $header['size']);
   fwrite($fp, $binary_data,8); fclose($fp);

   $gzp = @gzopen($to.$header['filename'].'.gz','rb') or die("Cette archive est compress閑");
    if(!$gzp) return(-2);
   $fp = @fopen($to.$header['filename'],'wb');
   if(!$fp) return(-1);
   $size = $header['size'];

   while ($size != 0)
   {
     $read_size = ($size < 2048 ? $size : 2048);
     $buffer = gzread($gzp, $read_size);
     $binary_data = pack('a'.$read_size, $buffer);
     @fwrite($fp, $binary_data, $read_size);
     $size -= $read_size;
   }
   fclose($fp); gzclose($gzp);

   //touch($to.$header['filename'], $header['mtime']);
   @unlink($to.$header['filename'].'.gz');

  }}
  return true;
 }
} //ZIP压缩类end



//判断GET变量是否为BASE64编码，不是很科学，需要进一步改进此函数
function isBase64()		{
	global $_SERVER;
	$QUERY_STRING = $_SERVER['QUERY_STRING'];
	$Code = base64_decode($QUERY_STRING);//print base64_decode($Code);
	$Array = explode('=',$Code);
	if(sizeof($Array)>1)		{
		return 1;
	}
	else
		return 0;
}

//重置_GET变量
function CheckBase64()	{
	global $_GET,$_SERVER;
	$QUERY_STRING = $_SERVER['QUERY_STRING'];
	$QUERY_STRING_ARRAY = explode('&',$QUERY_STRING);
	$QUERY_STRING = $QUERY_STRING_ARRAY[0];
	$QUERY_STRING = base64_decode($QUERY_STRING);
	$Array = explode('&',$QUERY_STRING);
	$_GET = array();
	//形成新的_GET变量信息
	$NewArray = array();
	for($i=0;$i<sizeof($Array);$i++)		{
		if($Array[$i]!="")		{
			$ElementArray = explode('=',$Array[$i]);
			$_GET[(String)$ElementArray[0]] = $ElementArray[1];
			$NewArray[$i] = $ElementArray[0]."=".$ElementArray[1];
		}
	}
	//附加GET变量形成部分
	for($i=1;$i<sizeof($QUERY_STRING_ARRAY);$i++)		{
		if($QUERY_STRING_ARRAY[$i]!="")		{
			$ElementArray = explode('=',$QUERY_STRING_ARRAY[$i]);
			$_GET[(String)$ElementArray[0]] = $ElementArray[1];
			$NewArray[$i] = $ElementArray[0]."=".$ElementArray[1];
		}
	}
	//形成新的_SERVER变量信息
	$_SERVER['QUERY_STRING'] = join('&',$NewArray);
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
}

//汉字字符切割，可以防止出现半个汉字的情况
function substr_cut($title,$length=8)
{
if (strlen($title)>$length) {
$temp = 0;
for($i=0; $i<$length; $i++)
if (ord($title[$i]) >128) $temp++;
if ($temp%2 == 0)
$title = substr($title,0,$length)."..";
else
$title = substr($title,0,$length+1)."..";
}
return $title;
}



?>