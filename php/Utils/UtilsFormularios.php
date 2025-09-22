<?php 
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
function existeVariableMostrar($variable){
    if (isset($variable)){
        echo $variable;
    }
}
?>