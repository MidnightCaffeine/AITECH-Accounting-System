<?php
function time2str($ts)
{
    if (!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if ($diff == 0)
        return 'now';
    elseif ($diff > 0) {
        $day_diff = floor($diff / 86400);
        if ($day_diff == 0) {
            if ($diff < 60) return  'just now';
            if ($diff < 120) return '1 minute ago';
            if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if ($diff < 7200) return '1 hour ago';
            if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if ($day_diff == 1) return 'Yesterday';
        if ($day_diff < 7) return $day_diff . ' days ago';
        if ($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
        if ($day_diff < 60) return 'last month';
        return date('F Y', $ts);
    } else {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if ($day_diff == 0) {
            if ($diff < 120) return 'a minute ago';
            if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if ($diff < 7200) return 'an hour ago';
            if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if ($day_diff == 1) return 'Tomorrow';
        if ($day_diff < 4) return date('l', $ts);
        if ($day_diff < 7 + (7 - date('w'))) return 'next week';
        if (ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
        if (date('n', $ts) == date('n') + 1) return 'next month';
        return date('F Y', $ts);
    }
}

function generateNumericOTP($n)
{
  // Taking a generator string that consists of
  // all the numeric digits
  $generator = "1357902468";

  // Iterating for n-times and pick a single character
  // from generator and append it to $result

  // Login for generating a random character from generator
  //     ---generate a random number
  //     ---take modulus of same with length of generator (say i)
  //     ---append the character at place (i) from generator to result

  $result = "";

  for ($i = 1; $i <= $n; $i++) {
    $result .= substr($generator, rand() % strlen($generator), 1);
  }

  // Returning the result
  return $result;
}
