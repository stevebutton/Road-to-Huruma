<?php
header('Content-Type: application/rss+xml; charset=UTF-8;', true);

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

echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; ?>

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
	$results = mysql_query("SELECT * FROM arnaud_users");
	while ($row = mysql_fetch_array($results, MYSQL_ASSOC)) : ?>	 
	<item>
		<title><![CDATA[Utilisateurs de <?php echo $row['user_ct']; ?>]]></title>
		<link>http://crash-box.fr/</link>
		<comments>http://crash-box.fr/</comments>
		<pubDate><?php echo date('D, d M Y H:i:s +0000', $row['user_date']); ?></pubDate>
		
		<description><?php echo get_users($row['user_ct']); ?> utilisateurs</description>
	<?php if ($row['user_ll']) : ?>
		<georss:point><?php echo $row['user_ll']; ?></georss:point>
	<?php endif; ?>
	</item>
<?php endwhile; ?>
</channel>
</rss>
<?php
	mysql_close($mysql_co);
	error_reporting(-1);
?>