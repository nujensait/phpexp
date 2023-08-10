<?php

/**
 * Convert string to upper case
 * @param $str
 * @return string
 */
function to_upper($str)
{
	$delta = 32;

	$ret = "";

	for($i = 0; $i < strlen($str); $i++) {
		$chr = $str[$i];
		$ord = ord($chr);
		if($ord >= 97 && $ord <= 122) {
			$str[$i] = chr($ord - $delta);
		}
	}

	return $str;
}

print "\n'" . to_upper("79879 abc xyz 2345") . "'\n";