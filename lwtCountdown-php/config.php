<?
$config = array(
	'messages' => array(	// Error and info messages. Always escape double quotes. " => \"
		'email_exists' 		=> 'Your email address already exists',
		'no_email' 			=> 'Please provide a valid email address',
		'email_invalid' 	=> 'Your email seams invalid. <br/>Please provide a valid email address',
		'thank_you' 		=> 'Thank you for your interest in our greate product!<br />We will get back to you with updates and further information.',
		'technical' 		=> 'We are currently experiencing some technical difficulties. <br />Please try again later.'
	),
	'database' => array(	// Database connection settings
		'host'				=> 'localhost',
		'username'			=> 'root',
		'password'			=>	'',
		'database'			=>	'subscribers'
	),
	'targetDate' => array(	// Target countdown date
		'day'				=> 18,
		'month'				=> 2,
		'year'				=> 2012,
		'hour'				=> 22,
		'minute'			=> 0,
		'second'			=> 0
	)
);

?>