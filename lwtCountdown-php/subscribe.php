<?
require_once "config.php";

$error = '';
$info = '';

$email = $_POST['email'];

// Check if email was provided
if ($email == '' || $email == 'your@email.com') {
	$error = $config['messages']['no_email'];
}
// Validate email format
else if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) { 
	$error = $config['messages']['email_invalid'];
}
// Connect to database
else if (!@mysql_connect($config['database']['host'], $config['database']['username'], $config['database']['password'])) {
	$info = $config['messages']['technical'];
} 
else if (!@mysql_select_db($config['database']['database'])) {
	$error = $config['messages']['technical'];
} else {
	// Insert subscription
	$q = "INSERT INTO `subscribers` (email, subscribed_at) VALUES ('".$email."', NOW())";
	@mysql_query($q);
	if (mysql_error()) {
		$error = $config['messages']['technical'];
	} else {
		// Done.
		$info = $config['messages']['thank_you'];
	}
}

if ($_GET['json']) {
	if ($error) {
		echo '{"error": "'.$error.'"}';
	} else if ($info) {
		echo '{"info": "'.$info.'"}';
	}
}
?>