<?

$����Ŀ¼ = "../cache/";

if ($dp = opendir($����Ŀ¼)) {
	while (($file=readdir($dp)) != false) {
		if (is_dir($����Ŀ¼.$file) && $file!='.' && $file!='..') {
			$filectime = filectime($����Ŀ¼.$file);
			$nowtime = time();
			$lefttime = ($nowtime-$filectime)/(3600*4);
			$lefttime = floor($lefttime);
			print $lefttime."<BR>";
			if($lefttime>=1)	{
				deleteDir($����Ŀ¼.$file);
			}
		}
		if (is_file($����Ŀ¼.$file) && $file!='.' && $file!='..') {
			$filectime = filectime($����Ŀ¼.$file);
			$nowtime = time();
			$lefttime = ($nowtime-$filectime)/(3600*4);
			$lefttime = floor($lefttime);
			print $lefttime."<BR>";
			if($lefttime>=1)	{
				@unlink($����Ŀ¼.$file);
			}
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
				@unlink($dir."/".$file);
			}
		}
	@rmdir($dir);
	closedir($dp);
	} else {
		exit('Not permission');
    }
}

}

?>