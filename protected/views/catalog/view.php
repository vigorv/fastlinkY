<?php


	//$url = AppController::set_input_server($f['Catalog']['dir'] . '/' . $f['name'], false, $f['sgroup']);
	if (!empty($url))
	{
		header('location: ' . $url);
	}
