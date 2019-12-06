<?php 

     include 'includes/validacoes.php';

    $usuariosJson = file_get_contents('./includes/usuarios.json');
    $usuariosArray = json_decode($usuariosJson, true);

    $ok_nome = true;
    $ok_email = true;
    $ok_senha = true;
    $ok_conf = true;

    if ($_POST) {

        $ok_nome = checarNome($_POST['nome']);
        $ok_email = checarEmail($_POST['email']);
        $ok_senha = checarSenha($_POST['senha']);
        $ok_conf = checarConf($_POST['senha'],$_POST['confSenha']);

        if ($ok_nome  && $ok_email && $ok_senha && $ok_conf)  {

            $novoUsuario = [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
            ];

            $usuariosArray[] = $novoUsuario;

            $novoUsuariosJson = json_encode($usuariosArray);
            $cadastrou = file_put_contents('./includes/usuarios.json', $novoUsuariosJson);

            if ($cadastrou) {
                header('Location: index.php');
            } 
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatiblefile" content="ie=edge">
    <title>Cadastro</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <main class="container mt-5">
        <div class="row">

            <div class="form-group col-6 offset-3 bg-white p-5">

                <table class="table mt-4">
                    <thead class="">
                        <tr>
                        <th scope="col">Usuários Cadastrados</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuariosArray as $key=>$usuario) { ?>
                        <tr>
                        <th scope="row"><?=$usuario['nome']?></th>
                        <th><a href="editUsuario.php?id=<?= $key ?>">Editar Usuário</a></th>
                        <th><a href="deleteUsuario.php?id=<?= $key ?>"><i class="material-icons align-self-center">clear</i></a></th>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <hr>
                <form method="post" enctype="multipart/form-data">
                    <br>
                    <h5>Novo usuário</h5>
                    <br>
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>

                
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                

                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control <?php if (!$ok_senha) { ?> is-invalid <?php } ?> <?php if (!$ok_conf) { ?> is-invalid <?php } ?>">
                    <?php if (!$ok_senha): ?>
                        <div class="invalid-feedback">
                            Senha inválida.
                        </div>
                    <?php endif;?>
                    

                    <label for="confSenha">Confirmação de Senha</label>
                    <input type="password" name="confSenha" id="confSenha" class="form-control <?php if (!$ok_conf) { ?> is-invalid <?php } ?>">
                    <?php if (!$ok_conf): ?>
                        <div class="invalid-feedback">
                            Senhas não coincidem.
                        </div>
                    <?php endif;?>
                    <a href="index.php">Já sou cadastrado, fazer login</a>
                
                    <button type="submit" class="btn btn-primary mt-4 float-right">Cadastrar</button>
                </form>
            </div>

        
        </div>
    </main>
</body>

</html>