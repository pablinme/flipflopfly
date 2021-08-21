<?php
class Timezone
{
	static function getZones()
	{
		$timezones = array();
		
		$timezones['1']['timeCode'] = 1;
		$timezones['1']['timeName'] = '(GMT-12:00) International Date Line West';
	
		$timezones['2']['timeCode'] = 2;
		$timezones['2']['timeName'] = '(GMT-11:00) Midway Island Samoa';
			
		$timezones['3']['timeCode'] = 3;
		$timezones['3']['timeName'] = '(GMT-10:00) Hawaii';
		
		$timezones['4']['timeCode'] = 4;
		$timezones['4']['timeName'] = '(GMT-09:00) Alaska';
			
		$timezones['5']['timeCode'] = 5;
		$timezones['5']['timeName'] = '(GMT-08:00) Pacific Time (US & Canada), Tijuana';
			
		$timezones['6']['timeCode'] = 6;
		$timezones['6']['timeName'] = '(GMT-07:00) Arizona';
			
		$timezones['7']['timeCode'] = 7;
		$timezones['7']['timeName'] = '(GMT-07:00) Chihuahua, La Paz, Mazatlan';
		
		$timezones['8']['timeCode'] = 8;
		$timezones['8']['timeName'] = '(GMT-07:00) Mountain Time (US & Canada)';
		
		$timezones['9']['timeCode'] = 9;
		$timezones['9']['timeName'] = '(GMT-06:00) Central America';
			
		$timezones['10']['timeCode'] = 10;
		$timezones['10']['timeName'] = '(GMT-06:00) Central Time (US & Canada)';
		
		$timezones['11']['timeCode'] = 11;
		$timezones['11']['timeName'] = '(GMT-06:00) Guadalajara, Mexico City, Monterrey';
		
		$timezones['12']['timeCode'] = 12;
		$timezones['12']['timeName'] = '(GMT-06:00) Saskatchewan';
		
		$timezones['13']['timeCode'] = 13;
		$timezones['13']['timeName'] = '(GMT-05:00) Bogota, Lime, Quito';
		
		$timezones['14']['timeCode'] = 14;
		$timezones['14']['timeName'] = '(GMT-05:00) Eastern Time (US & Canada)';
		
		$timezones['15']['timeCode'] = 15;
		$timezones['15']['timeName'] = '(GMT-05:00) Indiana (East)';
		
		$timezones['16']['timeCode'] = 16;
		$timezones['16']['timeName'] = '(GMT-04:00) Atlantic Time (Canada)';
		
		$timezones['17']['timeCode'] = 17;
		$timezones['17']['timeName'] = '(GMT-04:00) Caracas, La Paz';
		
		$timezones['18']['timeCode'] = 18;
		$timezones['18']['timeName'] = '(GMT-04:00) Santiago';
		
		$timezones['19']['timeCode'] = 19;
		$timezones['19']['timeName'] = '(GMT-03:30) Newfoundland';
		
		$timezones['20']['timeCode'] = 20;
		$timezones['20']['timeName'] = '(GMT-03:00) Brasilia';
		
		$timezones['21']['timeCode'] = 21;
		$timezones['21']['timeName'] = '(GMT-03:00) Buenos Aires, Georgetown';
		
		$timezones['22']['timeCode'] = 22;
		$timezones['22']['timeName'] = '(GMT-03:00) Greenland';
		
		$timezones['23']['timeCode'] = 23;
		$timezones['23']['timeName'] = '(GMT-02:00) Mid-Atlantic';
		
		$timezones['24']['timeCode'] = 24;
		$timezones['24']['timeName'] = '(GMT-01:00) Azores';
		
		$timezones['25']['timeCode'] = 25;
		$timezones['25']['timeName'] = '(GMT-01:00) Cape Verde Is.';
		
		$timezones['26']['timeCode'] = 26;
		$timezones['26']['timeName'] = '(GMT) Casablanca, Monrovia';
		
		$timezones['27']['timeCode'] = 27;
		$timezones['27']['timeName'] = '(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London';
		
		$timezones['28']['timeCode'] = 28;
		$timezones['28']['timeName'] = '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna';
		
		$timezones['29']['timeCode'] = 29;
		$timezones['29']['timeName'] = '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague';
		
		$timezones['30']['timeCode'] = 30;
		$timezones['30']['timeName'] = '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris';
		
		$timezones['31']['timeCode'] = 31;
		$timezones['31']['timeName'] = '(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb';
		
		$timezones['32']['timeCode'] = 32;
		$timezones['32']['timeName'] = '(GMT+01:00) West Central Africa';
	
		$timezones['33']['timeCode'] = 33;
		$timezones['33']['timeName'] = '(GMT+02:00) Athens, Istanbul, Minsk';
		
		$timezones['34']['timeCode'] = 34;
		$timezones['34']['timeName'] = '(GMT+02:00) Bucharest';
		
		$timezones['35']['timeCode'] = 35;
		$timezones['35']['timeName'] = '(GMT+02:00) Cairo';
		
		$timezones['36']['timeCode'] = 36;
		$timezones['36']['timeName'] = '(GMT+02:00) Harare, Pretoria';
		
		$timezones['37']['timeCode'] = 37;
		$timezones['37']['timeName'] = '(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius';
		
		$timezones['38']['timeCode'] = 38;
		$timezones['38']['timeName'] = '(GMT+02:00) Jerusalem';
		
		$timezones['39']['timeCode'] = 39;
		$timezones['39']['timeName'] = '(GMT+03:00) Baghdad';
		
		$timezones['40']['timeCode'] = 40;
		$timezones['40']['timeName'] = '(GMT+03:00) Kuwait, Riyadh';
		
		$timezones['41']['timeCode'] = 41;
		$timezones['41']['timeName'] = '(GMT+03:00) Moscow, St. Petersburg, Volgograd';
		
		$timezones['42']['timeCode'] = 42;
		$timezones['42']['timeName'] = '(GMT+03:00) Nairobi';
		
		$timezones['43']['timeCode'] = 43;
		$timezones['43']['timeName'] = '(GMT+03:30) Tehran';
		
		$timezones['44']['timeCode'] = 44;
		$timezones['44']['timeName'] = '(GMT+04:00) Abu Dhabi, Muscat';
		
		$timezones['45']['timeCode'] = 45;
		$timezones['45']['timeName'] = '(GMT+04:00) Baku, Tbilisi, Yerevan';
		
		$timezones['46']['timeCode'] = 46;
		$timezones['46']['timeName'] = '(GMT+04:30) Kabul';
		
		$timezones['47']['timeCode'] = 47;
		$timezones['47']['timeName'] = '(GMT+05:00) Ekaterinburg';
		
		$timezones['48']['timeCode'] = 48;
		$timezones['48']['timeName'] = '(GMT+05:00) Islamabad, Karachi, Tashkent';
		
		$timezones['49']['timeCode'] = 49;
		$timezones['49']['timeName'] = '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi';
		
		$timezones['50']['timeCode'] = 50;
		$timezones['50']['timeName'] = '(GMT+05.75) Kathmandu';
		
		$timezones['51']['timeCode'] = 51;
		$timezones['51']['timeName'] = '(GMT+06:00) Almaty, Novosibirsk';
		
		$timezones['52']['timeCode'] = 52;
		$timezones['52']['timeName'] = '(GMT+06:00) Astana, Dhaka';
	
		$timezones['53']['timeCode'] = 53;
		$timezones['53']['timeName'] = '(GMT+06:00) Sri Jayawardenepura';
			
		$timezones['54']['timeCode'] = 54;
		$timezones['54']['timeName'] = '(GMT+06:30) Rangoon';
		
		$timezones['55']['timeCode'] = 55;
		$timezones['55']['timeName'] = '(GMT+07:00) Bangkok, Hanoi, Jakarta';
		
		$timezones['56']['timeCode'] = 56;
		$timezones['56']['timeName'] = '(GMT+07:00) Krasnoyarsk';
		
		$timezones['57']['timeCode'] = 57;
		$timezones['57']['timeName'] = '(GMT+08:00) Beijing, Chongging, Hong Kong, Urumgi';
		
		$timezones['58']['timeCode'] = 58;
		$timezones['58']['timeName'] = '(GMT+08:00) Irkutsk, Ulaan Bataar';
		
		$timezones['59']['timeCode'] = 59;
		$timezones['59']['timeName'] = '(GMT+08:00) Kuala Lumpur, Singapore';
		
		$timezones['60']['timeCode'] = 60;
		$timezones['60']['timeName'] = '(GMT+08:00) Perth';
		
		$timezones['61']['timeCode'] = 61;
		$timezones['61']['timeName'] = '(GMT+08:00) Taipei';
		
		$timezones['62']['timeCode'] = 62;
		$timezones['62']['timeName'] = '(GMT+09:00) Osaka, Sapporo, Tokyo';
		
		$timezones['63']['timeCode'] = 63;
		$timezones['63']['timeName'] = '(GMT+09:00) Seoul';
			
		$timezones['64']['timeCode'] = 64;
		$timezones['64']['timeName'] = '(GMT+09:00) Yakutsk';
		
		$timezones['65']['timeCode'] = 65;
		$timezones['65']['timeName'] = '(GMT+09:30) Adelaide';
		
		$timezones['66']['timeCode'] = 66;
		$timezones['66']['timeName'] = '(GMT+09:30) Darwin';
		
		$timezones['67']['timeCode'] = 67;
		$timezones['67']['timeName'] = '(GMT+10:00) Brisbane';
		
		$timezones['68']['timeCode'] = 68;
		$timezones['68']['timeName'] = '(GMT+10:00) Canberra, Melbourne, Sydney';
		
		$timezones['69']['timeCode'] = 69;
		$timezones['69']['timeName'] = '(GMT+10:00) Guam, Port Moresby';
		
		$timezones['70']['timeCode'] = 70;
		$timezones['70']['timeName'] = '(GMT+10:00) Hobart';
		
		$timezones['71']['timeCode'] = 71;
		$timezones['71']['timeName'] = '(GMT+10:00) Vladivostok';
		
		$timezones['72']['timeCode'] = 72;
		$timezones['72']['timeName'] = '(GMT+11:00) Magadan, Solomon Is., New Caledonia';
		
		$timezones['73']['timeCode'] = 73;
		$timezones['73']['timeName'] = '(GMT+12:00) Auckland, Wellington';
		
		$timezones['74']['timeCode'] = 74;
		$timezones['74']['timeName'] = '(GMT+12:00) Figi, Kamchatka, Marshall Is.';
		
		$timezones['75']['timeCode'] = 75;
		$timezones['75']['timeName'] = '(GMT+13:00) Nukualofa';	
		
		return $timezones;
		
	}
}//class Timezone
?>
