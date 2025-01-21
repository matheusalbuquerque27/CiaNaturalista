<?php

$pdo = new PDO('mysql:hostname=localhost;dbname=CiaNat_DB', 'root', '');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = $pdo->prepare("SELECT * FROM `plantas` WHERE id=$id");
    $sql->execute();
    $planta_data = $sql->fetch();
}

if(isset($_POST['acao'])){
    $id = $_GET['id'];
    $nome_popular = $_POST['nome_popular'];
    $nome_cientifico = $_POST['nome_cientifico'];

    $sql = $pdo->prepare("UPDATE `plantas` SET nome_popular=?, nome_cientifico=? WHERE id=$id");
    $sql->execute(array($nome_popular, $nome_cientifico));

    //Redireciona para a página da lista de plantas
    header('Location: /CiaNaturalista/pages/plantas/');

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
    <title>Editar Espécie</title>
</head>
<body>
    <div class="page_header">
        <h1>Cia Naturalista - Beta Version</h1>
        <h3>Plantas >> Editar Espécie</h3>
        <div class="menu">
            <a href="/CiaNaturalista/pages/plantas/excluir.php?id=<?php echo $_GET['id'];?>"><i class="fa-solid fa-rotate-left"></i>Excluir</a>
            <a href="/CiaNaturalista/pages/plantas"><i class="fa-solid fa-rotate-left"></i>Voltar</a>
        </div>
    </div><!--page_header-->
    <div class="page_content">
        <form action="" method="POST" class="form_inserir">
            <div class="form_line">
                <label for="nome_popular">Nome popular: </label>
                <input type="text" name="nome_popular" value="<?php echo $planta_data['nome_popular'];?>" >
            </div><!--form_line-->
            
            <div class="form_line">
                <label for="nome_cientifico">Nome científico: </label>
                <input type="text" name="nome_cientifico" value="<?php echo $planta_data['nome_cientifico'];?>">
            </div><!--form_line-->
            
            <div class="form_line">
                <input type="submit" name="acao" value="Salvar edição">
            </div><!--form_line-->
        </form><!--form_inserir-->
    </div><!--page_content-->
</body>
</html>