<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/

function statics( $array )
{
				$max = max( $array );
				$min = min( $array );
				$alldistance = $max - $min;
				$distance_size = round( $alldistance / ( 1 + log( sizeof( $array ) ) * 3.322 ) );
				$distance_num = ceil( $alldistance / $distance_size );
				$statics['alldistance'] = $alldistance;
				$statics['distance_size'] = $distance_size;
				$statics['distance_num'] = $distance_num;
				$statics['geometry_multiply_all'] = 1;
				foreach ( $array as $list )
				{
								$array_num = ceil( ( $max - $list ) / $statics['distance_size'] );
								if ( $array_num == 0 )
								{
												$array_num = 1;
								}
								$array_num -= 1;
								$statics['array_num'][$array_num] += 1;
								$statics['array_sum'] += $list;
								$statics['geometry_log_all'] += log( $list, 10 );
								$statics['geometry_multiply_all'] *= pow( $list, 1 / sizeof( $array ) );
				}
				$mid_index = ( sizeof( $array ) + 1 ) / 2;
				$i = 0;
				for ( ;	$i < $statics['distance_num'];	++$i	)
				{
								$index1 = $max - $i * $statics['distance_size'];
								$index2 = $max - ( $i + 1 ) * $statics['distance_size'];
								if ( $index2 < $min )
								{
												$index2 = $min;
								}
								$statics['result'][$i] = $index2."-".$index1."\t";
								$statics['midvalue'][$i] = ( $index1 - $index2 ) / 2 + $index2;
								$statics['index1'][$i] = $index1;
								$statics['index2'][$i] = $index2;
								$temp += $statics['array_num'][$i];
								$statics['array_num_accu'][$i] += $temp;
								$statics['array_relative'][$i] = $statics['array_num'][$i] / sizeof( $array );
								$statics['array_relative'][$i] = number_format( $statics['array_relative'][$i], 2, ".", " " );
								$statics['array_relative_all'][$i] = $statics['array_num_accu'][$i] / sizeof( $array );
								$statics['array_relative_all'][$i] = number_format( $statics['array_relative_all'][$i], 2, ".", " " );
								$statics['FM_all'] += $statics['midvalue'][$i] * $statics['array_num'][$i];
								print $i."\t������";
								print $statics['result'][$i]."\t������".$statics['array_num'][$i]."\t������";
								print $statics['midvalue'][$i]."\t������";
								print $statics['array_num_accu'][$i]."\t  ����";
								print $statics['array_relative'][$i]."\t������";
								print $statics['array_relative_all'][$i]."\t      ";
								print "<BR>";
								$auth_average_all += $statics['midvalue'][$i] * $statics['array_num'][$i];
								if ( $statics['array_num_accu'][$i - 1] < $mid_index && $mid_index < $statics['array_num_accu'][$i] )
								{
												$mid_station['index'] = $i;
												$mid_station['index1'] = $statics['index1'][$i];
												$mid_station['index2'] = $statics['index2'][$i];
												$mid_station['array_num_accu'] = $statics['array_num_accu'][$i - 1];
								}
				}
				$statics['arith_average_group'] = $auth_average_all / $temp;
				$statics['arith_average_simple'] = $statics['array_sum'] / sizeof( $array );
				$mid_index = ( sizeof( $array ) + 1 ) / 2;
				if ( is_int( $mid_index ) )
				{
								$mid_num = $array[$mid_index];
				}
				else
				{
								$mid_num = ( $array[ceil( $mid_index )] + $array[floor( $mid_index )] ) / 2;
				}
				$statics['mid_num_simple'] = $mid_num;
				$mid_index = $mid_station['index'];
				$mid_station['array_num_prefix'] = $statics['array_num_accu'][$mid_index - 1];
				$mid_station['array_num_self'] = $statics['array_num'][$mid_index + 1];
				$mid_station['array_num_last'] = $statics['array_num_accu'][$distance_num - 1] - $mid_station['array_num_prefix'] - $mid_station['array_num_self'];
				$statics['mid_num_group'] = $mid_station['index1'] - $statics['distance_size'] * ( sizeof( $array ) / 2 - $mid_station['array_num_prefix'] ) / $mid_station['array_num_self'];
				$statics['mid_num_group'] = number_format( $statics['mid_num_group'], 2, ".", " " );
				$many_keys = array_keys( $statics['array_num'] );
				$many_values = array_values( $statics['array_num'] );
				$array_flip = array_flip( $statics['array_num'] );
				$many_index = max( $many_values );
				$many_index_name = $array_flip[$many_index] - 1;
				$statics['many_num_group'] = $statics['index1'][$many_index_name] - $statics['distance_size'] * $statics['array_num'][$many_index_name + 1] / ( $statics['array_num'][$many_index_name + 1] + $statics['array_num'][$many_index_name - 1] );
				$statics['many_num_group'] = number_format( $statics['many_num_group'], 2, ".", " " );
				$statics['geometry_log_aver'] = $statics['geometry_log_all'] / sizeof( $array );
				$statics['geometry_aver'] = pow( 10, $statics['geometry_log_aver'] );
				$R = $max - $min;
				$statics['R'] = $R;
				$diff_simple = 0;
				foreach ( $array as $list )
				{
								$temp = abs( $list - $statics['arith_average_simple'] );
								$temp_SD = pow( $temp, 2 );
								$temp_diff += $temp;
								$temp_SD_diff += $temp_SD;
				}
				$statics['AD_simple'] = $temp_diff / sizeof( $array );
				$statics['AD_simple'] = number_format( $statics['AD_simple'], 2, ".", " " );
				$i = 0;
				for ( ;	$i < $statics['distance_num'];	++$i	)
				{
								$temp_d = abs( $statics['midvalue'][$i] - $statics['arith_average_group'] ) * $statics['array_num'][$i];
								$statics['AD_all'] += $temp_d;
								$statics['SD_all'] += pow( $temp_d, 2 );
				}
				$statics['AD_group'] = $statics['AD_all'] / sizeof( $array );
				$statics['AD_group'] = number_format( $statics['AD_group'], 2, ".", " " );
				$statics['SD_simple'] = pow( $temp_SD_diff / sizeof( $array ), 0.5 );
				$statics['SD_simple'] = number_format( $statics['SD_simple'], 2, ".", " " );
				$statics['SD_group'] = pow( $statics['SD_all'] / sizeof( $array ), 0.5 );
				$statics['SD_group'] = number_format( $statics['SD_group'], 2, ".", " " );
				$statics['CV_simple'] = $statics['SD_simple'] / $statics['arith_average_simple'];
				$statics['CV_simple'] = number_format( $statics['CV_simple'], 2, ".", " " );
				$statics['CV_group'] = $statics['SD_group'] / $statics['arith_average_simple'];
				$statics['CV_group'] = number_format( $statics['CV_group'], 2, ".", " " );
				$i = 0;
				$newarray = $array;
				sort( $newarray );
				$newarray_r = array_flip( $newarray );
				foreach ( $array as $list )
				{
								$temp_Z = ( $list - $statics['arith_average_simple'] ) / $statics['SD_simple'];
								$temp_ZZ = number_format( $temp_Z, 2, ".", " " );
								$statics['Z'][$i] = $temp_ZZ;
								$statics['ZT'][$i] = $temp_ZZ * 10 + 50;
								$statics['CEEB'][$i] = $temp_ZZ * 100 + 500;
								$statics['PR_simple'][$i] = 100 - ( ( $newarray_r[$list] + 1 ) * 100 - 50 ) / sizeof( $array );
								++$i;
				}
				$m = 60;
				$statics['Pm'] = $mid_station['index2'] + $statics['distance_size'] * ( sizeof( $array ) * $m / 100 - $mid_station['array_num_last'] ) / $mid_station['array_num_self'];
				$statics['Pm'] = number_format( $statics['Pm'], 2, ".", " " );
				$statics['Pm'] = $mid_station['index1'] - $statics['distance_size'] * ( sizeof( $array ) * ( 1 - $m / 100 ) - $mid_station['array_num_prefix'] ) / $mid_station['array_num_self'];
				$statics['Pm'] = number_format( $statics['Pm'], 2, ".", " " );
				foreach ( $newarray as $list )
				{
								$p = ceil( ( $max - $list ) / $statics['distance_size'] );
								if ( $p == 0 )
								{
												$p = 1;
								}
								$p -= 1;
								$statics['array_data_index'][$list] = $p;
								$statics['PR_group'][$list] = ( sizeof( $array ) - $statics['array_num_accu'][$p] + ( $list - $statics['index2'][$p] ) * $statics['array_num'][$p] / $statics['distance_size'] ) * 100 / sizeof( $array );
				}
				$statics['FM'] = $statics['FM_all'] / sizeof( $array );
				return $statics;
}

$i = 0;
for ( ;	$i < 100;	++$i	)
{
				$int = rand( 10, 99 );
				$array[$i] = $int;
}
$statics = statics( $array );
?>
