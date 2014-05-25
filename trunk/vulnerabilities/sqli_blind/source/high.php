<?php

/* Não exibir erros no browser */
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if(isset($_GET['Submit'])){

	// Retrieve data

	$id = $_GET['id'];
	$id = stripslashes($id);
	$id = mysql_real_escape_string($id);

	if (is_numeric($id)) {
        /*  Previnir injeção de código hexadecimal */
		$id = (int) $id;

		$getid = "SELECT first_name, last_name FROM users WHERE user_id = '$id'";
		$result = mysql_query($getid); // Removed 'or die' to suppres mysql errors

		$num = @mysql_numrows($result); // The '@' character suppresses errors making the injection 'blind'

		$i=0;

		/*  Iterar em apenas um resultado */
		if ($num == 1) {

			$first = mysql_result($result,$i,"first_name");
			$last = mysql_result($result,$i,"last_name");
			
			$html .= '<pre>';
			$html .= 'ID: ' . $id . '<br>First name: ' . $first . '<br>Surname: ' . $last;
			$html .= '</pre>';

			$i++;
		}
	}
}
?>
