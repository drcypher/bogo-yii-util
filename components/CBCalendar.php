<?php
/**
 * Datetime functions.
 *
 * @since 1.0
 * @package Components
 * @author Konstantinos Filios <konfilios@gmail.com>
 */
class CBCalendar
{
	/**
	 * Number of seconds in an hour
	 */
	const SECONDS_IN_AN_HOUR = 3600;
	/**
	 * Number of seconds in a day
	 */
	const SECONDS_IN_A_DAY = 86400;

	/**
	 * Create an array of hours ranging from $from to $to (inclusive),
	 * optionally appending $appendString to each hour's label
	 *
	 * @param integer $from
	 * @param integer $to
	 * @param string $appendString
	 * @return array
	 */
	static public function hourRange($from, $to, $appendString = ':00')
	{
		$hours = array();
		for ($i = $from; $i <= $to; $i++) {
			$hours[$i] = sprintf("%02d", $i).$appendString;
		}
		return $hours;
	}

	/**
	 * Formats $fromDate as if it was expressed in $fromTimezoneAlias into a new date with format
	 * $format converting it to $toTimezoneAlias. Result is formatted using date()
	 *
	 * @param mixed $fromDate Source date, either as timestamp or date parsable by strtotime()
	 * @param string $format
	 * @param string $toTimezoneAlias
	 * @param string $fromTimezoneAlias
	 * @return string
	 */
	static public function dateToTimezone($fromDate, $format, $toTimezoneAlias, $fromTimezoneAlias = 'UTC')
	{
		// Keep original timezone
		$origTimezoneAlias = date_default_timezone_get();

		if (is_int($fromDate) || is_numeric($fromDate)) {
			// It's a UTC timestamp already
			$stamp = intval($fromDate);
		} else {
			// Convert date to timestamp using $fromTimezoneAlias
			date_default_timezone_set($fromTimezoneAlias);
			$stamp = intval(strtotime($fromDate));
		}

		// Convert stamp to date using
		date_default_timezone_set($toTimezoneAlias);
		$toDate = date($format, $stamp);

		// Revert to original timezone
		date_default_timezone_set($origTimezoneAlias);

		return $toDate;
	}

	/**
	 * Convert seconds to a human-readable representation.
	 *
	 * @param integer $initTime Time in seconds.
	 *
	 * @return string
	 */
	static public function secondsToTime($initTime)
	{
		if ($initTime < 1.0) {
			return number_format($initTime, 1).' sec';
		}

		$components = array();

		$hours = floor($initTime / 3600);
		if ($hours > 0) {
			$components[] = "$hours hr";
		}

		$minutes = floor(($initTime / 60) % 60);
		if ($minutes > 0) {
			$components[] = "$minutes min";
		}

		$seconds = $initTime % 60;
		if ($seconds > 0) {
			$components[] = "$seconds sec";
		}

		return implode(' ', $components);
	}
}
