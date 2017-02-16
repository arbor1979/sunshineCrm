<?php
//------------------------------------------------------------------
//ADODB CONNECTION
//------------------------------------------------------------------
require_once('../adodb/adodb.inc.php');
require_once('../adodb/adodb-session.php');
$db=NewADOConnection("mysql");
$db->Connect($localhost,$userdb_name,$userdb_pwd,$userdb);
$ADODB_FETCH_MODE=ADODB_FETCH_ASSOC;
$ADODB_CACHE_DIR='../cache';
?>