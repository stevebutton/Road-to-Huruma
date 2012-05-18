<?
	function get_ll($ct)
	{
		$geocodect = "http://maps.google.com/maps/geo?output=csv&q=" . $ct . "&key=ABQIAAAA6_dV86BKC_gLYZ5tApeZ9xTSt96hixEnaeI_G75f3vOosJRVGxTF82F0dUIsP0tta6IBfx4oTYy2rw";
		$geocodect = file_get_contents($geocodect);
		if ($geocodect == NULL)
		{
			return ("");
		}
		$geocodect = explode(",", $geocodect);
		if ($geocodect[0] == "200")
		{
			$geocodect = $geocodect[2] . "," . $geocodect[3];
			return ($geocodect);
		}
		return ("");
	}
	
	function get_ll_from_ct($mysql_co, $ct)
	{
		if ($ct == "XX")
		{
			return ("");
		}
		if ($mysql_co)
		{

			$requestct = "SELECT latlong FROM arnaud_countries WHERE name='" . $ct . "'";
			$resultct = mysql_query($requestct);
			if (mysql_num_rows($resultct) != 0)
			{	
				return (mysql_result($resultct, 0));	
			}
			else
			{
				$ll = get_ll($ct);								
				$requestinsll = $requestinsert = "INSERT INTO arnaud_countries (name, latlong) VALUES ('" . $ct . "', '" . $ll. "')";
				mysql_query($requestinsll);
				return ($ll);
			}
		}
		else
		{
			return ("");
		}
	}


	define('DB_NAME', 'db14582_sameheart');
	define('DB_USER', 'db14582_arnaud');
	define('DB_PASSWORD', 'capcom79');
	define('DB_HOST', $_ENV{'DATABASE_SERVER'} );
	
	error_reporting(0);
	$mysql_co = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if ($mysql_co)
	{
		mysql_select_db(DB_NAME);
	}
	
	$user = array();
	$user['ip'] = $_SERVER['REMOTE_ADDR'];
	$user['ref'] = "" . urlencode($_SERVER['HTTP_REFERER']);
	$user['time'] = time();
	$user['ct'] = file_get_contents("http://api.hostip.info/country.php?ip=" . $user['ip']);
	if ($user['ct'] == FALSE)
	{
		$user['ct'] = "XX";
	}
	$user['ll'] = "" . get_ll_from_ct($mysql_co, $user['ct']);
	
	$requestinsert = "INSERT INTO arnaud_users (user_date, user_ip, user_ref, user_ct, user_ll) VALUES ('" . $user['time'] . "', '" . $user['ip'] . "', '" . $user['ref'] . "', '" . $user['ct'] . "', '" . $user['ll'] . "')";
	mysql_query($requestinsert);
	mysql_close($mysql_co);
	error_reporting(-1);
?>