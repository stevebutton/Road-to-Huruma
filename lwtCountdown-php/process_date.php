<?

	$now = time();
	$target = mktime(
		$config['targetDate']['hour'], 
		$config['targetDate']['minute'], 
		$config['targetDate']['second'], 
		$config['targetDate']['month'], 
		$config['targetDate']['day'], 
		$config['targetDate']['year']
	);

	$diffSecs = $target - $now;

	$date = array();
	$date['secs'] = $diffSecs % 60;
	$date['mins'] = floor($diffSecs/60)%60;
	$date['hours'] = floor($diffSecs/60/60)%24;
	$date['days'] = floor($diffSecs/60/60/24)%7;
	$date['weeks']	= floor($diffSecs/60/60/24/7);
	
	foreach ($date as $i => $d) {
		$d1 = $d%10;
		$d2 = ($d-$d1) / 10;
		$date[$i] = array(
			(int)$d2,
			(int)$d1,
			(int)$d
		);
	}
	
?>