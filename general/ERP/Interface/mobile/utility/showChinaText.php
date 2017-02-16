<?php
class showChinaText
{
	function showChinaText($showText='')
	{
	}


	function show_firstword($姓名='',$fileName,$R,$G,$B)
	{

		$姓名第一个字	= mb_substr($姓名,0,1,'utf-8');

		$im = @imagecreate(120, 120);
		$bg = imagecolorallocate($im, $R, $G, $B);
		$text_color = imagecolorallocate($im, 255, 255, 255);
		//imagestring($im,10, 50, 50,  $姓名第一个字X, $text_color);
		imagettftext($im,45, 0, 30,80,$text_color,$this->font='utility/simhei.ttf',$姓名第一个字);
		// 保存图像为 'simpletext.jpg'
		$fileName=iconv("utf-8","gbk",$fileName);
		imagepng($im, $fileName);
		ImageDestroy($im);
	}
	//abcdefghijklmnopqrstuvwxyz

}
?>