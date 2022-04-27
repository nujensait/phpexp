<?php

/**
 * Filter emails: decline emails under domains nicelocal.com, zoon.ru (others are valid)
 * @param string $email
 * @return bool
 */
function validateZoonEmail(string $email): bool {
	$subject = $email;
	$pattern = "/(.*?)\@(nicelocal\.com|zoon\.ru)$/i";
	preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);
	//print_r($matches);

	return (count($matches) ? false : true);
}

// T ~ valid email,
// F ~ invalid email
$emails = [
	'legal@nicelocal.com',				// F
	'legal@nicelocalPlace.com',			// T
	'user@zoon.ru',						// F
	'user@zoon.ru.com',					// T
	'user@sadfsafzoon.ru',				// T
];

foreach($emails as $email) {
	$valid = validateZoonEmail($email);
	echo $email . " ===> " . ($valid ? 'T' : 'F') . "\n";
}


