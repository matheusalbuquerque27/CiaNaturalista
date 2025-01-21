<?php

    $id = $_GET['id']; // ID do elemento a editar

/*Conectar com o banco*/
function conectarBanco(){
    $pdo = new PDO('mysql:host=localhost;dbname=CiaNat_DB', 'root', '');
    return $pdo;
}


function allData($table){
    $sql = conectarBanco()->prepare("SELECT * FROM `$table`");
    $sql->execute();
    $data = $sql->fetchAll();

    return $data;
}


if(isset($_GET['id'])){
    
    /*Consultar no banco*/
    $sql = conectarBanco()->prepare("SELECT * FROM estoque WHERE id=$id");
    $sql->execute();
    $estoque_item = $sql->fetch();

    $id_planta = $estoque_item['id_planta'];
    $id_processamento = $estoque_item['id_processamento'];
    $id_parte_utilizada = $estoque_item['id_parte_utilizada'];
    $quantidade = $estoque_item['quantidade'];
    
    // Resgatar nomes
    $sql = conectarBanco()->prepare("SELECT `nome_popular`, `nome_cientifico` FROM plantas WHERE id = $id_planta");
    $sql->execute();
    $data_nomes = $sql->fetch();

    //Resgatar processamento
    $sql = conectarBanco()->prepare("SELECT id, `descricao` FROM processamento WHERE id = $id_processamento");
    $sql->execute();
    $data_proc = $sql->fetch();

    //Resgatar parte utilizada
    $sql = conectarBanco()->prepare("SELECT id, `descricao` FROM parte_utilizada WHERE id = $id_parte_utilizada");
    $sql->execute();
    $data_parte = $sql->fetch();

}

if(isset($_POST['acao'])){

    //Puxar dados do formulario
    $id = $_GET['id'];
    $novo_proc = $_POST['processamento'];
    $nova_parte = $_POST['parte_utilizada'];
    $nova_quantidade = $_POST['quantidade'];

    $sql_edicao = conectarBanco()->prepare("UPDATE estoque SET id_processamento=$novo_proc, id_parte_utilizada=$nova_parte, quantidade=$nova_quantidade WHERE id=$id");
    $sql_edicao->execute();

    header('Location: /CiaNaturalista/');

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
    <title>Editar Item</title>
</head>
<body>
    <div class="page_header">
        <h1>Cia Naturalista - Beta Version</h1>
        <h3>Estoque >> Editar Item</h3>
        <div class="menu">
            <a href="/CiaNaturalista/pages/estoque/excluir.php?id=<?php echo $_GET['id'];?>"><i class="fa-solid fa-rotate-left"></i>Excluir</a>
            <a href="/CiaNaturalista/"><i class="fa-solid fa-rotate-left"></i>Voltar</a>
        </div>
    </div><!--page_header-->
    <div class="page_content">
        <form action="" method="POST" class="form_inserir">
            <div class="form_line">
                <label for="produto">Produto: </label>
                <span><b><?php echo $data_nomes['nome_popular'];?> - <?php echo $data_nomes['nome_cientifico'];?></b></span><!--nome da planta-->
            </div><!--form_line-->
            
            <div class="form_line">
                <label for="parte_utilizada">Parte utilizada: </label>
                <select name="parte_utilizada" id="">
                    <option value="<?php echo $data_parte[0];?>"><?php echo $data_parte[1];?></option><!--a primeira posição mostra o id, a segunda a descricao da parte ultilizada-->
                    <?php
                        
                        $parte_data = allData('parte_utilizada');

                        foreach($parte_data as $key => $value){ 
                            if($value['descricao'] != $data_parte[1]){

                            ?>
                        
                            <option value="<?php echo $value['id'];?>"><?php echo $value['descricao'];?></option>

                        <?php

                        }//final do IF para tirar a parte utilizada já selecionada

                        }
                    ?>
                </select>
            </div><!--form_line-->

            <div class="form_line">
                <label for="processamento">Processamento: </label>
                <select name="processamento" id="">
                    <option value="<?php echo $data_proc[0];?>"><?php echo $data_proc[1];?></option><!--a primeira posição mostra o id, a segunda a descricao do processamento-->
                    <?php

                        $proc_data = allData('processamento');//usando a função para recuperar todos os dados de processamento

                        foreach($proc_data as $key => $value){ 
                            if($value['descricao'] != $data_proc[1]){
                            ?>
                        
                            <option value="<?php echo $value['id'];?>"><?php echo $value['descricao'];?></option>

                        <?php

                        }//final do IF para tirar o processamento já selecionado

                        }
                    ?>
                </select>
            </div><!--form_line-->

            <div class="form_line">
                <label for="quantidade">Quantidade: </label>
                <input type="text" name="quantidade" placeholder="(KG)" value="<?php echo $quantidade;?>">
            </div><!--form_line-->
            
            <div class="form_line">
                <input type="submit" name="acao" value="Salvar edição">
            </div><!--form_line-->
        </form><!--form_inserir-->
    </div><!--page_content-->
</body>
</html>