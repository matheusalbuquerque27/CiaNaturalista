<?php

$pdo = new PDO("mysql:host=localhost;dbname=CiaNat_DB", 'root', '');

// Resgatar nomes
$sql = $pdo->prepare("SELECT * FROM `plantas` ORDER BY nome_popular ASC");
$sql->execute();
$plantas_data = $sql->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/plantas_style.css">
    <link rel="stylesheet" href="../../css/all.min.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Plantas</title>
</head>
<body>
    <section>
    <div class="page_header">
        <h1>Cia Naturalista - Beta Version</h1>
        <h3>Plantas</h3>
        <div class="menu">
            <a href="/CiaNaturalista/pages/plantas/inserir.php"><i class="fa-solid fa-plus"></i>Adicionar</a>
            <a href="/CiaNaturalista/"><i class="fa-solid fa-rotate-left"></i>Voltar</a>
        </div>
    </div><!--page_header-->

    <div class="page_content">
            <div class="lista w100">
                <div class="linha">
                    <div class="fl topo w50">Nome popular</div>
                    <div class="fl topo w50">Nome científico</div>
                </div><!--linha-->
                <?php 
                foreach($plantas_data as $key => $value){

                ?>
                <a href="/CiaNaturalista/pages/plantas/editar.php?id=<?php echo $value['id'];?>">
                <div class="linha <?php if($key%2==0){echo 'bg-brown';}?>">
                    <div class="fl w50"><?php echo $value['nome_popular']; ?></div>
                    <div class="fl w50"><?php echo $value['nome_cientifico'];?></div>
                </div><!--linha-->
                </a><!--editar_item-->
                <?php    
                }
                ?>
            </div><!--lista-->
    </div><!--page_content-->
    </section>
</body>
</html>