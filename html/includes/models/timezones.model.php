<?php

class Timezones
{
	/*	Function that returns the formatted time */
	static function GetTime($input_location_id, $dst)
	{
		global $mysqli;	
		global $meminstance;

		$user_id = $_SESSION['user_id'];
		date_default_timezone_set('America/New_York');
		
		//first we check if memcache is set
		if ($meminstance == true)
		{
			$timezoneid = getCache($user_id.'timezoneid');
			$gmt_offset = getCache($user_id.'gmt_offset');
			$dst_offset = getCache($user_id.'dst_offset');
			$timezone_code = getCache($user_id.'timezone_code');
		}
		//if we do not have a value on cache, we fetch from db and then sava it to cache
		if ($meminstance != true || !$timezoneid || !$gmt_offset || !$dst_offset || !$timezone_code)
		{
			if ($stmt = $mysqli->prepare("SELECT id as timezoneid, gmt_offset, dst_offset, timezone_code FROM timezones WHERE id = ?"))
			{
				$stmt->bind_param('i', $input_location_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($timezoneid, $gmt_offset, $dst_offset, $timezone_code);
				$stmt->fetch();
				
				//memcache
				setCache($user_id.'timezoneid', $timezoneid, 86400);
				setCache($user_id.'gmt_offset', $gmt_offset, 86400);
				setCache($user_id.'dst_offset', $dst_offset, 86400);
				setCache($user_id.'timezone_code', $timezone_code, 86400);
			} 
		}

		if ($dst_offset > 0)
		{
			if (!($dst))
			{
				/*	Set the DST offset to zero if the box is not checked
				and append the standard time acronym to the timezone code */
				$dst_offset = 0;
				$timezone_code = self::getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "ST");
			}
			else if (!self::isDaylightSaving($timezoneid, $gmt_offset))
			{
				/*	Set the DST offset to zero if the timezone is not currently
				in DST and append the standard time acronym to the timezone code */
				$dst_offset = 0;
				$timezone_code = self::getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "ST");
			}
			else if ($timezone_code != '')
				/*	Leave the DST offset and append the daylight saving time acronym
				to the timezone code */
				$timezone_code = self::getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "DT");
			else
				/*	Assign a timezone code */
				$timezone_code = self::getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "");
		}
		/*	Does not observe DST at all */
		else
			$timezone_code = self::getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "ST");

		//timezone
		date_default_timezone_set('UTC');

		/* Get the DST offset in minutes */
		$dst_offset *= 60;
		/* Get the GMT offset in minutes */
		$gmt_offset *= 60;
		$gmt_hour = gmdate('H');
		$gmt_minute = gmdate('i');
		$gmt_second = gmdate('s');
		
		/* Calculate the time in the timezone */
		$time = $gmt_hour * 60 + $gmt_minute + $gmt_offset + $dst_offset;

		//return date('Y-m-d H:i', mktime($time / 60, $time % 60, 0, gmdate('m'), gmdate('d'), gmdate('Y'))) . " $timezone_code";
		return date('Y-m-d H:i:s', mktime($time / 60, $time % 60, $gmt_second, gmdate('m'), gmdate('d'), gmdate('Y')));
	}

	/*	This function returns true if the specified timezone ID is in daylight
	saving time and false if it is not */
	static function isDaylightSaving($timezoneid, $gmt_offset)
	{
		/*	Get the current year by geting GMT time and date and then adding
		offset */
		$gmt_minute = gmdate("i");
		$gmt_hour = gmdate("H");
		$gmt_month = gmdate("m");
		$gmt_day = gmdate("d");
		$gmt_year = gmdate("Y");
		$cur_year = date("Y", mktime($gmt_hour + $gmt_offset, $gmt_minute, 0, $gmt_month, $gmt_day, $gmt_year));

		switch ($timezoneid)
		{
		/*	North American cases: begins at 2 am on the first Sunday in April
		and ends on the last Sunday in October.  Note: Monterrey does not
		actually observe DST */
			case 4:		/*	Alaska */
			case 5:		/*	Pacific Time (US & Canada); Tijuana */
			case 8:		/*	Mountain Time (US & Canada) */
			case 10:	/*	Central Time (US & Canada) */
			case 11:	/*	Guadalajara, Mexico City, Monterrey */
			case 14:	/*	Eastern Time (US & Canada) */
			case 16:	/*	Atlantic Time (Canada) */
			case 19:	/*	Newfoundland */
				if (self::afterFirstDayInMonth($cur_year, $cur_year, 4, "Sun", $gmt_offset) &&
				self::beforeLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 7:		/*	Chihuahua, La Paz, Mazatlan */
				if (self::afterFirstDayInMonth($cur_year, $cur_year, 5, "Sun", $gmt_offset) &&
				self::beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 18:	/*	Santiago, Chile */
				if (self::afterSecondDayInMonth($cur_year, 10, "Sat", $gmt_offset) &&
				self::beforeSecondDayInMonth($cur_year + 1, $cur_year, 3, "Sat", $gmt_offset))
					return true;

				else
					return false;
				break;

			case 20:	/*	Brasilia, Brazil */
				if (self::afterFirstDayInMonth($cur_year, $cur_year, 11, "Sun", $gmt_offset) &&
				self::beforeThirdDayInMonth($cur_year, $cur_year, 2, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 23:	/*	Mid-Atlantic */
				if (self::afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
				self::beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			/*	EU, Russia, other cases: begins at 1 am GMT on the last Sunday
			in March and ends on the last Sunday in October */
			case 22:	/*	Greenland */
			case 24:	/*	Azores */
			case 27:	/*	Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London */
			case 28:	/*	Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna */
			case 29:	/*	Belgrade, Bratislava, Budapest, Ljubljana, Prague */
			case 30:	/*	Brussels, Copenhagen, Madrid, Paris */
			case 31:	/*	Sarajevo, Skopje, Warsaw, Zagreb */
			case 33:	/*	Athens, Istanbul, Minsk */
			case 34:	/*	Bucharest */
			case 37:	/*	Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius */
			case 41:	/*	Moscow, St. Petersburg, Volgograd */
			case 47:	/*	Ekaterinburg */
			case 45:	/*	Baku, Tbilisi, Yerevan */
			case 51:	/*	Almaty, Novosibirsk */
			case 56:	/*	Krasnoyarsk */
			case 58:	/*	Irkutsk, Ulaan Bataar */
			case 64:	/*	Yakutsk, Sibiria */
			case 71:	/*	Vladivostok */
				if (self::afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
				self::beforeLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 35:	/*	Cairo, Egypt */
				if (self::afterLastDayInMonth($cur_year, $cur_year, 4, "Fri", $gmt_offset) &&
				self::beforeLastDayInMonth($cur_year, $cur_year, 9, "Thu", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 39:	/*	Baghdad, Iraq */
				if (self::afterFirstOfTheMonth($cur_year, $cur_year, 4, $gmt_offset) &&
				self::beforeFirstOfTheMonth($cur_year, $cur_year, 10, $gmt_offset))
					return true;
				else
					return false;
				break;

			case 43:	/*	Tehran, Iran - Note: This is an approximation to 
							the actual DST dates since Iran goes by the Persian
							calendar.  There are tools for converting between
							Gregorian and Persian calendars at www.farsiweb.info.
							This may be added at a later date for better accuracy */
				if (self::afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
				self::beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 65:	/*	Adelaide */
			case 68:	/*	Canberra, Melbourne, Sydney */
				if (self::afterLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
				self::beforeLastDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 70:	/*	Hobart */
				if (self::afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
				self::beforeLastDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 73:	/*	Auckland, Wellington */
				if (self::afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
				self::beforeThirdDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			default:
				break;
		}
		return false;
	}

	/*	This function returns true if the current date (at the specified GMT
	offset) is after the first specified day of the week in specified
	month and false if it is not */
	static function afterFirstDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		for ($i = 1; $i < 8; $i++)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$first_day = $i;
				break;
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
		/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

		/* Time stamp for the first occurence for the specified day in the month */
		$first_day_stamp = mktime(2, 0, 0, $month, $first_day, $year);
				
		if ($cur_stamp >= $first_day_stamp)
			return true;
			
		return false;
	}
	
	/*	This function returns true if the current date (at the specified GMT
	offset) is before the last specified day of the week in specified
	month and false if it is not */
	static function beforeLastDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$days_in_month = self::getDaysInMonth($month);
		
		for ($i = $days_in_month; $i > ($days_in_month - 8); $i--)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$last_day = $i;
				break;
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
		/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

		/* Time stamp for the last occurrence of the day in the month at 2 am */
		$last_sun_stamp = mktime(2, 0, 0, $month, $last_day, $year);
				
		if ($cur_stamp < $last_sun_stamp)
			return true;
			
		return false;
	}

	/*	This function returns true if the current date (at the specified GMT
	offset) is after the last specified day of the week in specified
	month and false if it is not */
	static function afterLastDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$days_in_month = self::getDaysInMonth($month);

		for ($i = $days_in_month; $i > ($days_in_month - 8); $i--)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$last_day = $i;
				break;
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		/* All EU countries observe the DST change at 1 am GMT */
		$curHour = gmdate("H");
		/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

		/* Time stamp for the first occurence for the specified day in the month */
		$last_day_stamp = mktime(1, 0, 0, $month, $last_day, $year);
				
		if ($cur_stamp >= $last_day_stamp)
			return true;
			
		return false;
	}

	/*	This function returns true if the current date (at the specified GMT
	offset) is after the first day of the specified month and false if
	it is not */
	static function afterFirstOfTheMonth($curYear, $year, $month, $gmt_offset)
	{
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
		/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

		/* Time stamp for the first of the month */
		$last_day_stamp = mktime(3, 0, 0, $month, 1, $year);
				
		if ($cur_stamp >= $last_day_stamp)
			return true;
			
		return false;
	}

	/*	This function returns true if the current date (at the specified GMT
	offset) is before the first day of the specified month and false if
	it is not */
	static function beforeFirstOfTheMonth($curYear, $year, $month, $gmt_offset)
	{
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
		/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

		/* Time stamp for the first of the month */
		$first_day_stamp = mktime(3, 0, 0, $month, 1, $year);
				
		if ($cur_stamp < $first_day_stamp)
			return true;
			
		return false;
	}

	/*	This function returns true if the current date (at the specified GMT
	offset) is before the third occurrence of the specified day of the
	week in the specified month and false if it is not */
	static function beforeThirdDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$count = 0;
		
		for ($i = 1; $i < 22; $i++)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$count++;
				if ($count == 3)
				{
					$third_day = $i;
					break;
				}
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
		/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

		/* Time stamp for the third occurence for the specified day in the month */
		$third_day_stamp = mktime(2, 0, 0, $month, $third_day, $year);
				
		if ($cur_stamp < $third_day_stamp)
			return true;
			
		return false;
	}

	/*	This function returns true if the current date (at the specified GMT
	offset) is before the second occurrence of the specified day of the
	week in the specified month and false if it is not */
	static function beforeSecondDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$count = 0;
		
		for ($i = 1; $i < 15; $i++)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$count++;
				if ($count == 2)
				{
					$second_day = $i;
					break;
				}
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
		/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

		/*	Time stamp for the second occurence of the specified day in the month;
		change in Chile occurs at midnight */
		$second_day_stamp = mktime(0, 0, 0, $month, $second_day, $year);

		if ($cur_stamp < $second_day_stamp)
			return true;
			
		return false;
	}

	/*	This function returns true if the current date (at the specified GMT
	offset) is after the second occurrence of the specified day of the
	week in the specified month and false if it is not */
	static function afterSecondDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$count = 0;
		
		for ($i = 1; $i < 15; $i++)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$count++;
				if ($count == 2)
				{
					$second_day = $i;
					break;
				}
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
		/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

		/*	Time stamp for the second occurence of the specified day in the month;
		change in Chile occurs at midnight */
		$second_day_stamp = mktime(0, 0, 0, $month, $second_day, $year);

		if ($cur_stamp >= $second_day_stamp)
			return true;
			
		return false;
	}

	/*	A function that returns the number of days in the specified month */
	static function getDaysInMonth($month)
	{
		switch ($month)
		{
			/*	The February case, check for leap year */
			case 2:
				return (date("L")?29:28);
				break;
			/* Months with 31 days */
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				return 31;
				break;
			default:
				return 30;
				break;
		}
	}
	
	/*	This function returns a formated time zone code based on the
	value of the input code, the offset, any suffix that might apply */	
	static function getTimeZoneCode($timezone_code, $total_offset, $suffix)
	{
		if ($timezone_code == '')
		{
		/* If the code is NULL, create one */
			if ($total_offset > 0)
				return ("GMT +$total_offset");
			else if ($total_offset == 0)
				return ("GMT");
			else
				return ("GMT $total_offset");
		}
		else
		/* If not, append the suffix */
			return $timezone_code . "$suffix";
	}	
}//class Timezoness

?>