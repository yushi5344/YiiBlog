<?php
	function dump2file($vars, $label = '', $return = false)
	{
		$m_time = microtime();
		list($t1, $t2) = explode(' ', $m_time);
		$t1 = $t1*1000000;
		$t2 = date('Y-m-d H:i:s',$t2);
		$flag = $t2.':'.$t1;
		$import_data = print_r($vars,1);
		$import_data = "================".$flag."================\r\n".$import_data."\r\n";
		file_put_contents('debug_log.txt', $import_data,FILE_APPEND);
		return null;
	}