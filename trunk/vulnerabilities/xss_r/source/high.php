<?php
	
if(!array_key_exists ("name", $_GET) || $_GET['name'] == NULL || $_GET['name'] == ''){

	$isempty = true;
	
} else {
	/* Previnir ataques XSS com codificação UTF-7 */

	$name = htmlentities($_GET['name'], ENT_QUOTES);

	$html .= '<pre>';
	$html .= 'Hello ' . $name;
	$html .= '</pre>';
}

?>