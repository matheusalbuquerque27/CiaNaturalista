<?php

/*Conectar com o banco*/
$pdo = new PDO('mysql:host=localhost;dbname=CiaNat_DB', 'root', '');

/*Consultar no banco*/
$sql = $pdo->prepare("SELECT * FROM `estoque`");

$sql->execute();

$estoque_data = $sql->fetchAll();



?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widdiv/div=device-widdiv/div, initial-scale=1.0">
    <title>Cia Naturalista - Beta Version</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <a href="/CiaNaturalista/pages/plantas"><li><i class="fa-solid fa-leaf"></i>Plantas</li></a>
                <a href="/CiaNaturalista/pages/estoque/inserir.php"><li><i class="fa-solid fa-warehouse"></i>Adicionar Produto</li></a>
            </ul>
        </nav>
    </header>

    <section>
        <div class="page_header">
            <h1>Cia Naturalista - Beta Version</h1>
            <h3>Estoque</h3>
        </div><!--page_header-->
        <div class="page_content">
            <div class="lista w100">
                <div class="linha">
                    <div class="fl topo w33">Espécie</div>
                    <div class="fl topo w33">Especificações</div>
                    <div class="fl topo w15">Quantidade</div>
                </div><!--linha-->
                <?php 
                foreach($estoque_data as $key => $value){
                    $id_estoque = $value['id'];
                    $id_planta = $value['id_planta'];
                    $id_processamento = $value['id_processamento'];
                    $id_parte_utilizada = $value['id_parte_utilizada'];
                    
                    // Resgatar nomes
                    $sql = $pdo->prepare("SELECT `nome_popular`, `nome_cientifico` FROM plantas WHERE id = $id_planta");
                    $sql->execute();
                    $data_nomes = $sql->fetch();

                    //Resgatar processamento
                    $sql = $pdo->prepare("SELECT `descricao` FROM processamento WHERE id = $id_processamento");
                    $sql->execute();
                    $data_proc = $sql->fetch();

                    //Resgatar processamento
                    $sql = $pdo->prepare("SELECT `descricao` FROM parte_utilizada WHERE id = $id_parte_utilizada");
                    $sql->execute();
                    $data_parte = $sql->fetch();

                    
                ?>
                <a href="/CiaNaturalista/pages/estoque/editar.php?id=<?php echo $id_estoque;?>">
                <div class="linha <?php if($key%2==0){echo 'bg-brown';}?>">
                    <div class="fl w33"><?php echo $data_nomes['nome_popular']. ' - ' . $data_nomes['nome_cientifico']; ?></div>
                    <div class="fl w33"><?php echo $data_parte[0];?> - <?php echo $data_proc[0];?></div>
                    <div class="fl w15"><?php echo $value['quantidade'];?></div>
                </div><!--linha-->
                </a><!--editar_item-->
                <?php    
                }
                ?>
            </div><!--lista-->
        </div><!--page_header-->
    </section>

    <footer>
        <p>Cia Naturalista - Beta Version</p>
    </footer>
    <script src="/CiaNaturalista/js/jquery.js"></script><!--Importação Jquery-->
</body>
</html>