<?
	require_once "config.php";
	require_once "process_date.php";
	if ($_POST['email']) {
		include "subscribe.php";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<script language="Javascript" type="text/javascript" src="js/jquery-1.4.1.js"></script>
	<script language="Javascript" type="text/javascript" src="js/jquery.lwtCountdown-1.0.js"></script>
	<script language="Javascript" type="text/javascript" src="js/misc.js"></script>
	<link rel="Stylesheet" type="text/css" href="style/<?=($_GET['style'] == 'light' ? 'main.css' : 'dark.css')?>"></link>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<title>test</title>
</head>

<body>

	<div id="container">

		<h1>UNDER CONSTRUCTION</h1>
		<h2 class="subtitle">Stay tuned for news and updates.</h2>

		<!-- Countdown dashboard start -->
		<div id="countdown_dashboard">
			<div class="dash weeks_dash">
				<span class="dash_title">weeks</span>
				<div class="digit"><?=$date['weeks'][0]?></div>
				<div class="digit"><?=$date['weeks'][1]?></div>
			</div>

			<div class="dash days_dash">
				<span class="dash_title">days</span>
				<div class="digit"><?=$date['days'][0]?></div>
				<div class="digit"><?=$date['days'][1]?></div>
			</div>

			<div class="dash hours_dash">
				<span class="dash_title">hours</span>
				<div class="digit"><?=$date['hours'][0]?></div>
				<div class="digit"><?=$date['hours'][1]?></div>
			</div>

			<div class="dash minutes_dash">
				<span class="dash_title">minutes</span>
				<div class="digit"><?=$date['mins'][0]?></div>
				<div class="digit"><?=$date['mins'][1]?></div>
			</div>

			<div class="dash seconds_dash">
				<span class="dash_title">seconds</span>
				<div class="digit"><?=$date['secs'][0]?></div>
				<div class="digit"><?=$date['secs'][1]?></div>
			</div>

		</div>
		<!-- Countdown dashboard end -->

		<div class="dev_comment">
			This is a place holder for your comments.<br/>
			This page has been tested with <br />IE 6, IE 7, IE 8, FF 3, Safari 4, Opera 9, Chrome 4
		</div>

		<div class="subscribe">
			<form action="" method="POST" id="subscribe_form">
				<input type="text" name="email" id="email_field" class="faded" value="your@email.com" /> <input type="submit" id="subscribe_button" value="Stay updated" />
				<div id="error_message" class="form_message"<?=($error ? ' style="display: block"' : '')?>>
					<?=$error?>
				</div>
				<div id="info_message" class="form_message"<?=($info ? ' style="display: block"' : '')?>>
					<?=$info?>
				</div>
				<div id="loading">
					<img src="images/loading.gif" />
				</div>
			</form>
		</div>

		<script language="javascript" type="text/javascript">
			jQuery(document).ready(function() {
				$('#countdown_dashboard').countDown({
					targetDate: {
						'day': 		<?=$config['targetDate']['day']?>,
						'month': 	<?=$config['targetDate']['month']?>,
						'year': 	<?=$config['targetDate']['year']?>,
						'hour': 	<?=$config['targetDate']['hour']?>,
						'min': 		<?=$config['targetDate']['minute']?>,
						'sec': 		<?=$config['targetDate']['second']?>
					}
				});
				
				// Subscription functions
				$('#email_field').focus(email_focus).blur(email_blur);
				$('#subscribe_form').bind('submit', subscribe_submit);
			});
		</script>
	
	</div>
</body>

</html>
