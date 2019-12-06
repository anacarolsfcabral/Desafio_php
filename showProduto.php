<?php

    session_start(); 

    if(empty($_SESSION['usuario'])) {
        header ('Location: login.php');
    }

    $jsonProdutos = file_get_contents('includes/produtos.json');

    $arrayProdutos = json_decode($jsonProdutos,true);

    $ID = $_GET['id'];


    foreach($arrayProdutos as $produto) {
      if ($produto['id'] == $ID) {
        $prod_selecionado = $produto;
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Produto</title>
</head>
<body>
    
    <div class="container m-5">
        <div class="row no-gutters">
            <div class="col-8 offset-2 bg-white p-4">
                <div class="breadCrumbs py-4">
                    <a href="logout.php" class="text-danger">Logout </a>   |   <a href="indexProdutos.php">Lista de Produtos</a> > <b>Produto </b>> Editar
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <img src="assets/fotosProdutos/<?= $prod_selecionado['foto']?>" class="card-img" alt="...">
                    </div>
                    <div class="card-body col-7">
                        <a href="editProduto.php?id=<?= $ID ?>" class="float-right"><i class="material-icons edit align-self-center">create</i></a>
                        <p class="titulo">Nome:</p>
                        <h5 class="card-title"><?= $prod_selecionado['nome']?></h5>
                        <p class="titulo">Descrição:</p>
                        <p class="card-text"><?= $prod_selecionado['descricao']?></p>
                        <p class="titulo">Preço:</p>
                        <p class="card-text">R$<?= $prod_selecionado['preco']?></p> 
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>