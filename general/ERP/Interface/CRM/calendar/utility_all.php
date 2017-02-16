<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/
function compare_time( $TIME1, $TIME2 )
{
				$STR = strtok( $TIME1, ":" );
				$HOUR1 = $STR;
				$STR = strtok( ":" );
				$MIN1 = $STR;
				$STR = strtok( ":" );
				$SEC1 = $STR;
				$STR = strtok( $TIME2, ":" );
				$HOUR2 = $STR;
				$STR = strtok( ":" );
				$MIN2 = $STR;
				$STR = strtok( ":" );
				$SEC2 = $STR;
				if ( $HOUR2 < $HOUR1 )
				{
								return 1;
				}
				if ( $HOUR1 < $HOUR2 )
				{
								return -1;
				}
				if ( $MIN2 < $MIN1 )
				{
								return 1;
				}
				if ( $MIN1 < $MIN2 )
				{
								return -1;
				}
				if ( $SEC2 < $SEC1 )
				{
								return 1;
				}
				if ( $SEC1 < $SEC2 )
				{
								return -1;
				}
				return 0;
}
?>
