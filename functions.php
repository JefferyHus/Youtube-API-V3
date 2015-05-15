<?php

function array_key_filter($array, $callback) {
    $f = array_filter(array_keys($array), $callback);
    return array_intersect_key($array, array_flip($f));
}



function time_elapsed_string($ptime) {
    //var_dump(time());
    //var_dump($ptime);
    $etime = time() - $ptime;

    //var_dump($etime);

    if ($etime < 1) {
        return '0 seconds';
    }

    $a = array(12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        //var_dump($d);
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}

/**
 * @param $timestampl
 * @param $timestamp2
 * @param $time_unit
 * @return bool|float
 */
function time_difference($timestampl, $timestamp2, $time_unit)
{
	// determine the difference between two dates
	$timestampl = intval($timestampl);
	$timestamp2 = intval($timestamp2);
	if ($timestampl && $timestamp2)
	{
		$time_lapse = $timestamp2 - $timestampl;

		$seconds_in_unit = array(
			"second" => 1,
			"minute" => 60,
			"hour" => 3600,
			"day" => 86400,
			"week" => 604800,
		);

		if ($seconds_in_unit[$time_unit])
			return round($time_lapse/$seconds_in_unit[$time_unit]);
	}
	return false;
}

/**
 * Outputting formatted date-time
 * @param $date_time
 * @return string
 */
function date_time_out($date_time)
{
	$current_time = time();
	$time_diff = time_difference($date_time, $current_time, 'minute');
	$date_diff = time_difference($date_time, $current_time, 'day');
	$result = '';
	if ($time_diff < 60) return $time_diff . ' minute' . ($time_diff==1)?'':'es' . ' ago';
	else if ($time_diff >= 60 AND $date_diff == 0) $result.= 'Today';
	else if ($date_diff == 1) $result.= 'Yesterday';
	else $result.= date("Y-m-d", $date_time);
	$result.= ' at '. date('H:i', $date_time);
	return $result;
}

/**
 * Outputting text with limited words count
 * @param $text
 * @param $words_count
 * @return string
 */
function short_text_out($text, $words_count) {
	$arr = explode(' ', $text);
	$count_arr = count($arr);
	$arr = array_slice($arr, 0, $words_count);
	$text = implode(' ', $arr);
	if ($count_arr > $words_count) $text.= '...';
	unset($arr);
	unset($count_arr);
	return strip_tags($text);
}

?>
