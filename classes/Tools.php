<?php

	class Tools{
		public static function formatDate($date, $month=0, $monthly=0)
		{
			if ($date != "0000-00-00")
			{
				$dateExpl = explode("-", $date);

				if ($monthly == 1)
					return $dateExpl[2]."-".$month;
				else
					return $dateExpl[2]."-".$dateExpl[1]."-".$dateExpl[0];
			}
			else
				return "";
		}

		public static function getMonths()
		{
			return array(
				'1'  => 'Janvier',
				'2'  => 'F&eacute;vrier',
				'3'  => 'Mars',
				'4'  => 'Avril',
				'5'  => 'Mai',
				'6'  => 'Juin',
				'7'  => 'Juillet',
				'8'  => 'Ao&ucirc;t',
				'9'  => 'Septembre',
				'10' => 'Octobre',
				'11' => 'Novembre',
				'12' => 'D&eacute;cembre');
		}
	}
	