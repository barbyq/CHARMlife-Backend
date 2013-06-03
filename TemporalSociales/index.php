<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
session_start();
error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

if (isset($_POST['temporaral'])) {
	$_SESSION['id'] = $_POST['temporaral']; 
}
$upload_handler = new UploadHandler();
?>
