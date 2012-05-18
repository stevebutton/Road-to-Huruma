<?php
header('Content-Type: application/rss+xml; charset=UTF-8;', true);

/*include 'user.php';*/

define('DB_NAME', 'db14582_crashbox');
define('DB_USER', 'db14582_arnaud');
define('DB_PASSWORD', 'capcom79');
define('DB_HOST', $_ENV{'DATABASE_SERVER'} );

function get_users($ct)
{
	$nb_users = "SELECT * FROM arnaud_users WHERE user_ct='" . $ct . "'";
	$nb_users = mysql_query($nb_users);
	$nb_users = mysql_num_rows($nb_users);
	return ($nb_users);
}

error_reporting(0);
$mysql_co = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if ($mysql_co)
{
	mysql_select_db(DB_NAME);
}
?>

<rss version="2.0"
	xmlns:georss="http://www.georss.org/georss">
 <channel>
 	<title>crash-box: user origin feed</title>  
 	<link>http://crash-box.fr/</link>
 	<description></description>
 	<lastBuildDate><?php echo date('D, d M Y H:i:s +0000'); ?></lastBuildDate> 
 	<language>en</language>
 	<generator>None.</generator> 
<?php
	$results = mysql_query("SELECT * FROM arnaud_countries");
	while ($row = mysql_fetch_array($results, MYSQL_ASSOC)) : ?>
	<?php $ct_users = get_users($row['name']); ?>
	<?php if ($ct_users > 0) : ?> 
	<item>
		<title><![CDATA[Utilisateurs de <?php echo $row['name']; ?>]]></title>
		<link>http://crash-box.fr/</link>
		<comments>http://crash-box.fr/</comments>
		<pubDate><?php echo date('D, d M Y H:i:s +0000', time()); ?></pubDate>
		<description><?php echo $ct_users; ?> utilisateurs.</description>
	<?php if ($row['latlong']) : ?>
		<georss:point><?php echo $row['latlong']; ?></georss:point>
	<?php endif; ?>
	</item>
	<?php endif; ?>
<?php endwhile; ?>
</channel>
</rss>
<?php
	mysql_close($mysql_co);
	error_reporting(-1);
?>