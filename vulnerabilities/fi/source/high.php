<?php

	// Uso seguro da url
	$file = urlencode($_GET['page']);
	$file = htmlentities($file);

	// Only allow include.php
	if ($file != "include.php") {
		echo "ERROR: File not found!";
		exit;
	}

?>