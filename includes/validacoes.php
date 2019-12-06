<?php

function checarNome($str) {

    if (strlen($str) < 3) {
        return false;
    } 

    if (strlen($str) > 10) {
        return false;
    } 

    return true;
}

function checarEmail($str) {

    if (strlen($str) < 3) {
        return false;
    } 
    return true;
}

function checarSenha($str) {

    if (strlen($str) < 6) {
        return false;
    }

    return true;
}

function checarConf($str1,$str2) {

    if (strlen($str1) < 6) {
        return false;
    }
    
    if ($str1!=$str2) {
        return false;
    }

    return true;
}


?>