<?php

if ($ListSheets && count($ListSheets))
{
	$ind = 0;
	$last = count($ListSheets) - 1;
	foreach ($ListSheets AS $ListSheet)
	{
		echo $this->render('print', [
			'Authorized' => $Authorized,
			'Dispatched' => $Dispatched,
			'Mainlist' => $Mainlist,

			'Driver' => $ListSheet['Driver'],
			'Client' => $ListSheet['Client'],
			'MainlistClientItems' => $ListSheet['MainlistClientItems'],
			'Numero' => $ListSheet['Numero'],
			'TotalBultos' => $ListSheet['TotalBultos'],
			'MainlistClient' => $ListSheet['MainlistClient'],
		]);
		//if ($ind < $last)
		//{
		//	echo $this->render('print-break');
		//}
	}
}