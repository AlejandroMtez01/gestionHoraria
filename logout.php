<?php 
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
session_destroy();
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
header("Location: login.php");
?>