<?php

    include 'includes/validacoes.php';

    $jsonProdutos = file_get_contents('includes/produtos.json');

    $arrayProdutos = json_decode($jsonProdutos,true);

    $ok_nome = true;
    $nome= '';
    $ok_preco = true;
    $ok_foto = true;

    $ID = $_GET['id'];


    foreach($arrayProdutos as $produto) {
      if ($produto['id'] == $ID) {
        $prod_selecionado = $produto;
        $index = key($arrayProdutos);
      } 
    }

    if ($_POST) {

        $ok_nome = checarNome($_POST['nome']);
    
        if (is_numeric($_POST['preco']) == true) {
            $prod_selecionado['preco'] = $_POST['preco'];
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

            $prod_selecionado['nome']= $_POST['nome'];
            $prod_selecionado['descricao']= $_POST['descricao'];
            $prod_selecionado['preco']= $_POST['preco'];
            $prod_selecionado['foto']= $nomeFoto;

            $arrayProdutos['index'] = $prod_selecionado;
 
            $jsonAtualizado = json_encode($arrayProdutos); 
            
           $salvou = file_put_contents('includes/produtos.json', $jsonAtualizado);
    
           if ($salvou) {
               header('Location: showProduto.php?id='.$ID);
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
    
    <title>Editar</title>
</head>
<body>
    <div class="container">
        <div class="col-6 offset-3">
            <form method="POST" enctype="multipart/form-data">     

                <div class="mt-3">
                    <h2>Editar Produto</h2>
                    <label class="mt-2" for="nome">Nome do Produto</label>
                    <input name="nome" type="text" id="nome" value="<?= $prod_selecionado['nome'] ?>" class="form-control <?php if (!$ok_nome) { ?> is-invalid <?php } ?>">
                    <?php if (!$ok_nome): ?>
                        <div class="invalid-feedback">
                            Nome inválido.
                        </div>
                    <?php endif;?>
                </div>

                <div>
                    <label for="descricao">Descrição</label>
                    <input name="descricao" type="text" id="descricao" value="<?= $prod_selecionado['descricao'] ?>" class="form-control <?php if (!$ok_nome) { ?> is-invalid <?php } ?>">
                    <?php if (!$ok_nome): ?>
                        <div class="invalid-feedback">
                            Descrição inválida.
                        </div>
                    <?php endif;?>
                </div>

                <div>
                    <label for="preco">Preço</label>
                    <input type="number" name="preco" step="0.01" min="0" class="form-control <?php if (!$ok_preco) { ?> is-invalid <?php } ?>" value="<?= $prod_selecionado['preco'] ?>">
                    <?php if (!$ok_preco): ?>
                        <div class="invalid-feedback">
                            Valor inválido.
                        </div>
                    <?php endif;?>
                </div>

                <div>
                    <label for="preco">Foto do Produto</label>
                    <input type="file" name="foto" class="form-control <?php if (!$ok_foto) { ?> is-invalid <?php } ?>" placeholder="Selecione o arquivo" required>
                    <?php if (!$ok_foto): ?>
                        <div class="invalid-feedback">
                            Arquivo inválido.
                        </div>
                    <?php endif;?>
                </div>

                <input type="hidden" name="id" value="<?=$id?>">
                <button class="btn btn-primary float-right mt-3" type="submit">Salvar</button>
            </form>
        </div>
    </div>
    
</body>
</html>