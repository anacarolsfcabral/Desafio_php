<?php

session_start(); 

if(empty($_SESSION['usuario'])) {
    header ('Location: login.php');
}

    $jsonProdutos = file_get_contents('includes/produtos.json');

    $arrayProdutos = json_decode($jsonProdutos,true)


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <title>Lista de Produtos</title>
</head>
<body>
    
    <div class="col-8 offset-2 mt-5 bg-white">
        <div class="breadCrumbs py-5">
            <a href="logout.php" class="text-danger"> Logout</a>   |   <b>Lista de Produtos</b> > Produto > Editar
        </div>
        <a href="createProduto.php" class="float-right btn btn-primary mb-2">Criar novo</a>
        <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Identificador</th>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col">Preço</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($arrayProdutos as $produto) { ?>
            <tr>
            <th scope="row"><?=$produto['id']?></th>
            <td><?=$produto['nome']?></td>
            <td><?=$produto['descricao']?></td>
            <td><?=$produto['preco']?></td>
            <td><a href="showProduto.php?id=<?= $produto['id'] ?>">Ver produto</a></td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
       
    </div>
    
</body>
</html>