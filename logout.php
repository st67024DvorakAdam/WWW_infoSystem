<?php
session_start();
$_SESSION = array();
session_destroy();

// Přesměrování na přihlašovací stránku
header("Location: index.php"); 
exit();
?>
