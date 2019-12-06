<?php

    include 'includes/validacoes.php';

    $jsonUsuarios = file_get_contents('includes/usuarios.json');

    $arrayUsuarios = json_decode($jsonUsuarios,true);

    $ok_nome = true;
    $ok_email = true;
    $ok_senha = true;
    $ok_conf = true;
    $nome= '';
    $email= '';

    $ID = $_GET['id'];


    foreach($arrayUsuarios as $key=>$usuario) {
      if ($key == $ID) {
        $usuario_selecionado = $usuario;
        $index = $key;
        $nome = $usuario['nome'];
        $email = $usuario['email'];
      } 
    }

    if ($_POST) {

        $ok_nome = checarNome($_POST['nome']);
    
        if ($ok_nome) {

            $ok_nome = checarNome($_POST['nome']);
            $ok_email = checarEmail($_POST['email']);

            if (!$POST['senha']) {
                $novoUsuario['senha'] = $usuario_selecionado['senha'];
            } else {
                $ok_senha = checarSenha($_POST['senha']);
                $ok_conf = checarConf($_POST['senha'],$_POST['confSenha']);
            }

            if ($ok_nome  && $ok_email && $ok_senha && $ok_conf)  {

                $novoUsuario = [
                    'nome' => $_POST['nome'],
                    'email' => $_POST['email'],
                    'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
                ];

                $arrayUsuarios[$index] = $novoUsuario;

                $novoUsuarioJson = json_encode($arrayUsuarios);
                $cadastrou = file_put_contents('./includes/usuarios.json', $novoUsuarioJson);

                if ($cadastrou) {
                    header('Location: createUsuario.php');
                }
            }
        }
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <title>Editar Usuário</title>
</head>
<body>
    <div class="container">
        <div class="col-6 offset-3 p-4 bg-white">
            <form method="POST" enctype="multipart/form-data">     

                <div class="mt-3">
                    <h2>Editar Usuário</h2>
                    <label class="mt-2" for="nome">Nome do Usuário</label>
                    <input name="nome" type="text" id="nome" value="<?= $usuario_selecionado['nome'] ?>" class="form-control <?php if (!$ok_nome) { ?> is-invalid <?php } ?>">
                    <?php if (!$ok_nome): ?>
                        <div class="invalid-feedback">
                            Nome inválido.
                        </div>
                    <?php endif;?>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input name="email" type="text" id="email" value="<?= $usuario_selecionado['email'] ?>" class="form-control <?php if (!$ok_email) { ?> is-invalid <?php } ?>">
                    <?php if (!$ok_email): ?>
                        <div class="invalid-feedback">
                            Descrição inválida.
                        </div>
                    <?php endif;?>
                </div>

                <div>
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" class="form-control <?php if (!$ok_senha) { ?> is-invalid <?php } ?>">
                    <?php if (!$ok_senha): ?>
                        <div class="invalid-feedback">
                            Valor inválido.
                        </div>
                    <?php endif;?>
                </div>

                <div>
                    <label for="confirma">Confirma senha</label>
                    <input type="password" name="confirma" class="form-control <?php if (!$ok_conf) { ?> is-invalid <?php } ?>" >
                    <?php if (!$ok_conf): ?>
                        <div class="invalid-feedback">
                        Senhas não coincidem.
                        </div>
                    <?php endif;?>
                </div>

                <input type="hidden" name="id" value="<?=$id?>">
                <button class="btn btn-primary col-2 mt-3 offset-10" type="submit">Salvar</button>
            </form>
        </div>
    </div>
    
    </body>
</html>