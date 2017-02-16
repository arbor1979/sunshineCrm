<?php
include_once( "../user_select/setting.inc.php" );
function deptListTree( $PARENT_ID )
{
    global $connection;
    global $LOGIN_USER_ID;
    global $LOGIN_DEPT_ID;
    global $LOGIN_USER_PRIV;
    global $PRIV_NO_FLAG;
    global $PARA_URL;
    global $PARA_TARGET;
    global $PARA_ID;
    global $PARA_VALUE;
    global $showButton;
    $query = "SELECT * from department where DEPT_PARENT='".$PARENT_ID."' order by DEPT_NO";
    $cursor1 = exequery( $connection, $query );
    while ( $ROW = mysql_fetch_array( $cursor1 ) )
    {
        $DEPT_ID1 = $ROW['DEPT_ID'];
        $DEPT_NAME1 = $ROW['DEPT_NAME'];
        $DEPT_NAME1 = htmlspecialchars( $DEPT_NAME1 );
        $DEPT_NAME1 = str_replace( "\"", "&quot;", $DEPT_NAME1 );
        $DEPT_NAME1 = stripslashes( $DEPT_NAME1 );
        $CHILD_COUNT = 0;
        $query = "SELECT 1 from department where DEPT_PARENT='".$DEPT_ID1."'";
        $cursor2 = exequery( $connection, $query );
        if ( $ROW1 = mysql_fetch_array( $cursor2 ) )
        {
            ++$CHILD_COUNT;
        }
        if ( $PRIV_NO_FLAG )
        {
            $DEPT_PRIV1 = is_dept_priv( $DEPT_ID1 );
        }
        else
        {
            $DEPT_PRIV1 = 1;
        }
        if ( $DEPT_PRIV1 == 1 )
        {
            $XML_TEXT_DEPT .= "<TreeNode id=\"".$DEPT_ID1."\" text=\"[{$DEPT_NAME1}]\" ";
        }
        else
        {
            $XML_TEXT_DEPT .= "<TreeNode id=\"".$DEPT_ID1."\" text=\"{$DEPT_NAME1}\" ";
        }
        if ( $showButton )
        {
            $XML_TEXT_DEPT .= "onclick=\"click_node('".$DEPT_ID1."',this.checked,'{$PARA_ID}','".str_replace( ".", "&amp;", $PARA_VALUE )."');\" ";
        }
        if ( $PARA_URL != "" && $DEPT_PRIV1 == 1 )
        {
            if ( $PARA_ID == "" )
            {
                $URL = "{$PARA_URL}?DEPT_ID={$DEPT_ID1}";
            }
            else
            {
                $URL = "{$PARA_URL}?DEPT_ID={$DEPT_ID1}&amp;{$PARA_ID}=".str_replace( ".", "&amp;", $PARA_VALUE );
            }
            $XML_TEXT_DEPT .= "href=\"".$URL."\" target=\"{$PARA_TARGET}\"";
        }
        else
        {
            $XML_TEXT_DEPT .= "href=\"javascript:;\" target=\"_self\"";
        }
        $XML_TEXT_DEPT .= " img_src=\"../../../Framework/images/endnode.gif\" title=\"".$DEPT_NAME1."\"";
        if ( 0 < $CHILD_COUNT )
        {
            $XML_TEXT_DEPT .= " Xml=\"tree.php?DEPT_ID=".$DEPT_ID1."&amp;PARA_URL={$PARA_URL}&amp;PARA_TARGET={$PARA_TARGET}&amp;PRIV_NO_FLAG={$PRIV_NO_FLAG}&amp;PARA_ID={$PARA_ID}&amp;PARA_VALUE={$PARA_VALUE}&amp;showButton={$showButton}\"";
        }
        $XML_TEXT_DEPT .= "/>\n";
    }
    return $XML_TEXT_DEPT;
}


//
ob_end_clean( );
header( "Content-type: text/xml" );
$PARENT_ID = $DEPT_ID;
echo "<?phpxml version=\"1.0\" encoding=\"gb2312\"?>\n<TreeNode>\n";
if ( $PARENT_ID == 0 )
{
    $query = "SELECT * from unit";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $UNIT_NAME = $ROW['UNIT_NAME'];
    }
    $UNIT_NAME = htmlspecialchars( $UNIT_NAME );
    $UNIT_NAME = str_replace( "\"", "&quot;", $UNIT_NAME );
    $UNIT_NAME = stripslashes( $UNIT_NAME );
    echo "  <TreeNode id=\"0\"";
    if ( $showButton )
    {
        echo " onclick=\"click_node('0',this.checked,'".$PARA_ID."','".str_replace( ".", "&amp;", $PARA_VALUE )."');\"";
    }
    echo " text=\"";
    echo $UNIT_NAME;
    echo "\" Xml=\"\" img_src=\"../../../Framework/images/endnode.gif\">\n";
    echo deptlisttree( $PARENT_ID );
    echo "  </TreeNode>\n";
}
else
{
    echo deptlisttree( $PARENT_ID );
}
echo "</TreeNode>\n";
?>
