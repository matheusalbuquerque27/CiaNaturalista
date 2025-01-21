<?php

/*Conectar com o banco*/
$pdo = new PDO('mysql:host=localhost;dbname=CiaNat_DB', 'root', '');

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

if(isset($_POST['acao'])){
    $id_planta = $_POST['planta'];
    $id_parte = $_POST['parte_utilizada'];
    $id_proc = $_POST['processamento'];
    $quantidade = $_POST['quantidade'];
    
    echo $id_planta;

    //Abaixo há uma busca por um produto igual, se tiver semelhante ele apenas acrescenta a quantidade
    $sql_comparacao = conectarBanco()->prepare("SELECT id FROM `estoque` WHERE id_planta=$id_planta AND id_processamento=$id_proc AND id_parte_utilizada=$id_parte");
    $sql_comparacao->execute();
    $result_comparacao = $sql_comparacao->fetch();

    if($result_comparacao){
        $id_encontrado = $result_comparacao['id'];
        $sql = conectarBanco()->prepare("UPDATE estoque SET quantidade=quantidade+$quantidade WHERE id=$id_encontrado");
        $sql->execute();
    } else {

        $sql = conectarBanco()->prepare("INSERT INTO estoque VALUES (null, ?, ?, ?, ?)");
        $sql->execute(array($id_planta, $id_proc, $id_parte, $quantidade));


    }

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
    <title>Adicionar Espécie</title>
</head>
<body>
    <div class="page_header">
        <h1>Cia Naturalista - Beta Version</h1>
        <h3>Estoque >> Adicionar Item</h3>
        <div class="menu">
            <a href="/CiaNaturalista/"><i class="fa-solid fa-rotate-left"></i>Voltar</a>
        </div>
    </div><!--page_header-->
    <div class="page_content">
        <form action="" method="POST" class="form_inserir">
            <div class="form_line">
                <label for="nome_popular">Nome popular: </label>
                <input type="text" id="nome_popular" placeholder="Pesquisar espécie">
                <input type="hidden" id="planta" name="planta">
            </div><!--form_line-->
            <div class="form_line">
                <section>
                    <div class="page_content">
                        <div class="lista w100 view" id="view">
                        
                        <!--Aqui serão inseridas as divs de retorno da pesquisa-->
                        
                        </div><!--lista-->
                    </div><!--page_content-->
                </section>
                
            </div><!--form_line-->
            
            <div class="form_line">
                <label for="parte_utilizada">Parte utilizada: </label>
                <select name="parte_utilizada" id="">
                    <option value="">Selecione a parte utilizada:</option>
                    <?php
                        
                        $parte_data = allData('parte_utilizada');

                        foreach($parte_data as $key => $value){ ?>
                        
                            <option value="<?php echo $value['id'];?>"><?php echo $value['descricao'];?></option>

                        <?php
                        }
                    ?>
                </select>
            </div><!--form_line-->

            <div class="form_line">
                <label for="processamento">Processamento: </label>
                <select name="processamento" id="">
                    <option value="">Selecione o processamento:</option>
                    <?php
                        
                        $proc_data = allData('processamento');

                        foreach($proc_data as $key => $value){ ?>
                        
                            <option value="<?php echo $value['id'];?>"><?php echo $value['descricao'];?></option>

                        <?php
                        }
                    ?>
                </select>
            </div><!--form_line-->

            <div class="form_line">
                <label for="quantidade">Quantidade: </label>
                <input type="text" name="quantidade" placeholder="Quantidade (KG)">
            </div><!--form_line-->
            
            <div class="form_line">
                <input type="submit" name="acao" value="Adicionar ao estoque">
            </div><!--form_line-->
        </form><!--form_inserir-->
    </div><!--page_content-->
    <script src="../../js/jquery.js"></script><!--Importação Jquery-->
    <script>
        $(function(){
            $('#nome_popular').keyup(function(){
                var busca = $('#nome_popular').val()

                $.post('/CiaNaturalista/pages/plantas/buscar.php', { busca: busca }, function(data){
                    $('#view').html(data)

                    $('.select').click(function(){
                        var nome_encontrado = $(this).children('#nome_encontrado').text()
                        var id_planta = $(this).attr('id')

                        $('#nome_popular').val(nome_encontrado)
                        $('#planta').val(id_planta)

                        $('#view').html('')
                    })
                })
            })
        })
        
    </script>
</body>
</html>