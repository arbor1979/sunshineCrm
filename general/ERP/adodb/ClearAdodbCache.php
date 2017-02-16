<?

$»º´æÄ¿Â¼ = "../cache/";

if ($dp = opendir($»º´æÄ¿Â¼)) {
	while (($file=readdir($dp)) != false) {
		if (is_dir($»º´æÄ¿Â¼.$file) && $file!='.' && $file!='..') {
			$filectime = filectime($»º´æÄ¿Â¼.$file);
			$nowtime = time();
			$lefttime = ($nowtime-$filectime)/(3600*4);
			$lefttime = floor($lefttime);
			print $lefttime."<BR>";
			if($lefttime>=1)	{
				deleteDir($»º´æÄ¿Â¼.$file);
			}
		}
		if (is_file($»º´æÄ¿Â¼.$file) && $file!='.' && $file!='..') {
			$filectime = filectime($»º´æÄ¿Â¼.$file);
			$nowtime = time();
			$lefttime = ($nowtime-$filectime)/(3600*4);
			$lefttime = floor($lefttime);
			print $lefttime."<BR>";
			if($lefttime>=1)	{
				@unlink($»º´æÄ¿Â¼.$file);
			}
		}
		//print $»º´æÄ¿Â¼.$file."<BR>";;

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