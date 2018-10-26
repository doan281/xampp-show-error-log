<?php
ob_clean();
echo "<a href='error_log.php?action=delete'>Delete All</a>";
echo '<br>';

/* Get error log file path */
$error_log_path = str_replace('htdocs', 'php/logs/php_error_log', $_SERVER['DOCUMENT_ROOT']);

/* Open error log file */
$error_log = @fopen($error_log_path, "r") or die("Unable to open file!");

/* Output one character until end-of-file */
$data = [];
while(!feof($error_log)) {
  $data[] = fgets($error_log);
}
fclose($error_log);

/* Show data */
if (count($data) > 1) {
	$data = array_reverse($data);
	
	foreach($data as $key => $value){
		echo ($key + 1) . '. ' . $value . '<br>';
	}
}

/**
 * Delete all error log
 * @param $error_log_path
 * @return bool
 */
function deleteAll($error_log_path){
    try {
        file_put_contents($error_log_path, '');
		
		if (empty($_SERVER['HTTP_REFERER'])) {
			header('location:' . $_SERVER['HTTP_REFERER']);
		} else {
			header('location:http://localhost/error_log.php');
		}        
		
        return true;
		
    } catch (Exception $e){
        return false;
    }
}

/* Delete all log */
$action = isset($_GET['action']) ? $_GET['action'] : '';
if (! empty($action) && $action == 'delete') {
	deleteAll($error_log_path);
}

?>
<html>
<head>
	<title>Show log</title>
	<meta http-equiv="refresh" content="30" />
	<meta charset="UTF-8">
</head>
<body></body>
</html>