<?php

// Includes
include 'includes/validacoes.php';

// Definindo valores padroes
$ok_nome = true;
$nome= '';
$ok_preco = true;
$ok_foto = true;

// Verificando se o formulário foi enviado
if ($_POST) {

    // Validando se o nome foi digitado
    $ok_nome = checarNome($_POST['nome']);

    // Adicionando o nome à variável
    $nome = $_POST['nome'];

    // Validando se o preço é numérico
    if (is_numeric($_POST['preco']) == true) {
        $preco = $_POST['preco'];
    } else {
        $ok_preco = false;
    }

    if ($_FILES["foto"]["error"] == 0 ) {
        $nomeFoto = $_FILES["foto"]["name"];
        $caminhoFoto = $_FILES["foto"]["tmp_name"]; 
        $movendo = move_uploaded_file($caminhoFoto, './assets/fotosProdutos/'.$nomeFoto);
    } else {
        $ok_foto = false;
    }

    if ($ok_nome  && $ok_foto && $ok_preco) {

        $produtosJson = file_get_contents('includes/produtos.json');

        $arrayProdutos = json_decode($produtosJson,true);

        if (empty($arrayProdutos)) {
            $ID = 1;
          } else {
            $ID = ((int)array_key_last($arrayProdutos))+2;  
          }

        $novoProduto = [
            'id' => $ID,
            'nome' => $_POST['nome'],
            'descricao' => $_POST['descricao'],
            'preco' => $_POST['preco'],
            'foto' => $nomeFoto
        ];

        $arrayProdutos[] = $novoProduto;

        $jsonAtualizado = json_encode($arrayProdutos); 
        
       $salvou = file_put_contents('includes/produtos.json', $jsonAtualizado);

       if ($salvou) {
           header('Location: indexProdutos.php');
       }

    }

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=form, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
	<form method="POST" enctype="multipart/form-data">     

		<div class="col-6 mb-3 bg-white offset-3 p-4">
            <div class="breadCrumbs py-5">
                <a href="logout.php" class="text-danger"> Logout</a>   |   <a href="indexProdutos.php">Lista de Produtos</a> > <b>Cadastro de Produto</b>
            </div>
            
            <h2>Cadastrar Produto</h2>
            <label class="mt-5" for="nome">Nome do Produto</label>
            <input name="nome" type="text" id="nome" value="<?=$nome?>" class="form-control <?php if (!$ok_nome) { ?> is-invalid <?php } ?>" placeholder="Nome" required>
            <?php if (!$ok_nome): ?>
                <div class="invalid-feedback">
                    Nome inválido.
                </div>
            <?php endif;?>

            <label for="descricao">Descrição</label>
            <input name="descricao" type="text" id="descricao" value="<?=$nome?>" class="form-control <?php if (!$ok_nome) { ?> is-invalid <?php } ?>" placeholder="Descrição">
            <?php if (!$ok_nome): ?>
                <div class="invalid-feedback">
                    Descrição inválida.
                </div>
            <?php endif;?>

            <label for="preco">Preço</label>
            <input type="number" name="preco" step="0.01" min="0" class="form-control <?php if (!$ok_preco) { ?> is-invalid <?php } ?>" placeholder="Preço" value="<?=$preco?>">
             <?php if (!$ok_preco): ?>
                <div class="invalid-feedback">
                    Valor inválido.
                </div>
            <?php endif;?>

            <label for="preco">Foto do Produto</label>
            <input type="file" name="foto" class="form-control <?php if (!$ok_foto) { ?> is-invalid <?php } ?>" placeholder="Selecione o arquivo" required>
             <?php if (!$ok_foto): ?>
                <div class="invalid-feedback">
                    Arquivo inválido.
                </div>
            <?php endif;?>

		    <button class="btn-primary btn col-2 offset-10 mt-2" type="submit">Enviar</button>
        </div>

	</form>
</body>
</html>





