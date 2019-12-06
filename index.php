<?php
    session_start();

    if ($_POST) {
        $usuariosJson = file_get_contents('./includes/usuarios.json');
        $usuariosArray = json_decode($usuariosJson, true);

        foreach($usuariosArray as $usuario) {
            if($_POST['email'] == $usuario['email'] && password_verify($_POST['senha'], $usuario['senha'])) {
                
                if ($_POST['manter'] == "on") {
                    
                    setcookie('emailUsuario', $_POST['email']);
                    setcookie('senhaUsuario', $_POST['senha']);
                }
                
                $_SESSION['usuario'] = $usuario;
                
                return header('Location: indexProdutos.php');
            }
        }

        $erro = 'Usuário e senha não coincidem';
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatiblefile" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <main class="container mt-5">
        <?php if (isset($erro)) { ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php } ?>
        <form method="post" enctype="multipart/form-data">

            <div class="form-group row">
                <div class="col-md-6 offset-3 bg-white p-5">
                    <h5>Login</h5>
                    <br>
                    <label for="e-mail">Email</label>
                    <input type="email" name="email" id="e-mail" class="form-control" 
                        <?php if (isset($_COOKIE['emailUsuario'])) { 
                                echo "value='$_COOKIE[emailUsuario]'"; 
                            } 
                        ?> 
                    >
           

                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" 
                        class="form-control"
                        <?php if (isset($_COOKIE['senhaUsuario'])) { 
                                echo "value='$_COOKIE[senhaUsuario]'"; 
                            } 
                        ?>
                    >
        
                <input type="checkbox" name="manter" id="manter">
                <label for="manter">Manter conectado</label>
                
                <button type="submit" class="btn btn-primary w-25 float-right mt-3">Enviar</button>
                <a class="float-right mt-4 mr-2" href="createUsuario.php">Novo Cadastro</a>
            

        </form>
    </main>
</body>

</html>