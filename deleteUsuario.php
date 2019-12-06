<?php

    $ID = $_GET['id'];


    $usuariosJson = file_get_contents('./includes/usuarios.json');
    $usuariosArray = json_decode($usuariosJson, true);

    unset($usuariosArray[$ID]);

    $semUsuarioJson = json_encode($usuariosArray);
    $excluiu = file_put_contents('./includes/usuarios.json', $semUsuarioJson);


    if ($excluiu) {
        header('Location: createUsuario.php');
    } 
    
    