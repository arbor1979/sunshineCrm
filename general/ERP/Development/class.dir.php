<?php
    //$d=new PHP_Dir();               //create a new PHP_Dir object
    //$d->set_mask("*.*");          //set the default mask to '*.txt'

 //echo "<table cellpadding='5' cellspacing='5'>\n";
 //echo "<tr><td colspan='4'>Found ".count($RESULT)."</td></tr>\n";

/*
	$dirs=$d->list_dirs($getdir); 
	for($i=0;$i<sizeof($dirs);$i++){
     echo "<tr bgcolor='$bgcolor'>";
     echo "<td>&nbsp;<a href=\"?getdir=$folder_temp\" target=_blank>".$dirs[$i]."</a></td>";
     echo "<td>&nbsp;<a href=\"?pathfile=$getdir".$dirs[$i]."/$files_temp&getdir=$getdir/".$dirs[$i]."\">".$dirs[$i]."</a></td>";
     echo "<td>&nbsp;$size_temp</td>";
	}*/
    class PHP_Dir{
    
        var $mask='';
    
            function PHP_Dir(){}
            
        //exterior
        
            function set_mask($mask=''){
                $this->mask=$mask;
            }
        
            function list_files($dir='/', $mask=''){

                $return = array();
                
                if(!$mask){
                    $mask=$this->mask;
                }
                
                if(!file_exists($dir)){
                    echo "PHP_Dir: Directory does not exist $dir <BR>";
                    return $return;
                }
                
                $d=opendir($dir) or die("PHP_Dir: Failure opening directory");
				$counter=0;
                while($file=readdir($d)){
                    if(is_file($dir.$file))		{
                        $return['filename'][$counter]=$file;
						$file_array=explode('.',$file);
						$return[$counter]['filesize']=filesize($dir.$file);
						$return[$counter]['filetype']=$file_array[sizeof($file_array)-1];
						$return[$counter]['filectime']=filectime($dir.$file);
						$counter++;
					}
                }
                if(sizeof($return['filename'])>=1)
					sort($return['filename']);
                return $return;
            }
            
            function list_dirs($dir, $mask=''){
            
                $return = array();
                
                if(!$mask){
                    $mask=$this->mask;
                }
                
                if(!file_exists($dir)){
                    echo "PHP_Dir: Directory does not exist";
                    return $return;
                }
                
                $d=opendir($dir) or die("PHP_Dir: Failure opening directory");
				$counter=0;
                while($file=readdir($d)){
                    //if(is_dir($dir.$file) && $this->matches_mask($file, $mask))
					if(is_dir($dir.$file))		{
                        $return['dirname'][$counter]=$file;
						$return[$counter]['dirsize']='-';
						$return[$counter]['dirtype']="DIR";
						$return[$counter]['dirctime']=filectime($dir);
						$counter++;
					}
                }
                if(sizeof($return['dirname'])>=1)
	                sort($return['dirname']);
                return $return;
            }
        
        //interior
        
            function matches_mask($file, $mask){
            
                $mask = str_replace(".", "\.", $mask);
                $mask = str_replace("*", "(.*)", $mask);
                
                if(eregi("^$mask", $file, $blah))
                    return true;
            }
        
        }
    
?>