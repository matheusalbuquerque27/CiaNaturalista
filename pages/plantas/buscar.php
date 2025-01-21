<?php

$pdo = new PDO("mysql:host=localhost;dbname=CiaNat_DB", "root", '');

$busca = $_POST['busca'];
$sql = $pdo->prepare("SELECT * FROM `plantas` WHERE nome_popular LIKE '%$busca%' LIMIT 3");
$sql->execute();

$plantas_data = $sql->fetchAll();

if($plantas_data != null){

foreach ($plantas_data as $key => $value) { ?>
    
    <div class="linha select" id="<?php echo $value['id'];?>">
        <div class="fl w50" id="nome_encontrado"><?php echo $value['nome_popular'];?></div>
        <div class="fl w50"><?php echo $value['nome_cientifico'];?></div>
    </div><!--linha-->
    <div class="clear"></div>

<?php
    
}//Fim do FOREACH

} else { //Fim do IF ?>

    <h3>Nenhum dado relacionado à sua pesquisa.</h3>

<?php

} //Fim do ELSE 

?>


