<?php
	function formatDate($date, $monthly=0)
	{
		if ($date != "0000-00-00")
		{
			$dateExpl = explode("-", $date);

			if ($monthly == 1)
				return $dateExpl[2]."-".date("m");
			else
				return $dateExpl[2]."-".$dateExpl[1]."-".$dateExpl[0];
		}
		else
			return "";
	}