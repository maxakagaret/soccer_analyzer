<?php
define ('_DS_', DIRECTORY_SEPARATOR);
include_once (dirname(__FILE__)._DS_.'index.php');

$isDebug=true;
for($i=0;$i<30;$i++){
	for($j=$i+1;$j<31;$j++){
		match($i,$j);
	}
}
?>