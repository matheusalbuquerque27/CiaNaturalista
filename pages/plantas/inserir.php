<?php

$pdo = new PDO('mysql:host=localhost;dbname=CiaNat_DB', 'root', '');

if(isset($_POST['acao'])){
    $nome_popular = $_POST['nome_popular'];
    $nome_cientifico = $_POST['nome_cientifico'];

    $sql = $pdo->prepare('INSERT INTO `plantas` VALUES (null, ?, ?)');
    $sql->execute(array($nome_popular, $nome_cientifico));

    echo '<script>alert("Espécie adicionada ao sistema.")</script>';
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/plantas_style.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/all.min.css">
    <title>Adicionar Espécie</title>
</head>
<body>
    <div class="page_header">
        <h1>Cia Naturalista - Beta Version</h1>
        <h3>Plantas >> Adicionar Espécie</h3>
        <div class="menu">
        <a href="/CiaNaturalista/pages/plantas"><i class="fa-solid fa-rotate-left"></i>Voltar</a>
        </div>
    </div><!--page_header-->
    <div class="page_content">
        <form action="" method="POST" class="form_inserir">
            <div class="form_line">
                <label for="nome_popular">Nome popular: </label>
                <input type="text" name="nome_popular" placeholder="Nome popular">
            </div><!--form_line-->
            
            <div class="form_line">
                <label for="nome_cientifico">Nome científico: </label>
                <input type="text" name="nome_cientifico" placeholder="Nome científico">
            </div><!--form_line-->
            
            <div class="form_line">
                <input type="submit" name="acao" value="Adicionar à lista">
            </div><!--form_line-->
        </form><!--form_inserir-->
    </div><!--page_content-->
    <script src="../../js/jquery.js"></script><!--Importação Jquery-->
</body>
</html>