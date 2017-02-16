<?php
class Utility
{
	var $db;
	function __construct($db) {
       $this->db=&$db;
   }
	function returntablefield($tablename,$what,$value,$return,$where1='',$value1='',$where2='',$value2='')		
	{

		if($value=='') return '';
		$sql="select distinct $return from $tablename where $what='$value'";
		if(!empty($where1) && !empty($value1))			
			$sql.=" and $where1='$value1'";
		if(!empty($where2) && !empty($value2))			
			$sql.=" and $where2='$value2'";
		
		//print $sql."<BR>";
		$rs=$this->db->Execute($sql);
		
		//print_r($rs->fields)."<BR>";
		$returnArray = explode(',',$return);
		
		if(@$returnArray[1]!="")
			return $rs->fields;					//返回数组
		else
			return trim($rs->fields[$return]);	//返回某一字段的值
	}
	function returnAutoIncrement($FieldName,$tablename)		
	{
		$sql = "select max($FieldName) as NUM from $tablename";//print $sql;
		$rs = $this->db->Execute($sql);
		$number = $rs->fields['NUM'];
		return $number+1;
	}
	
}

?>