<?php

include "./admin/connect.php";

$sql = new connect();

//cabeçalho para que todos os retornos sejam em json
header("Content-type: application/json; charset=utf-8");


//retorna dados da página home
if($_REQUEST['acao'] == "getSettings"){

    $respostaDoBanco = $sql->selectFor("SELECT * FROM settings");

    echo json_encode(["data" => $respostaDoBanco]);

}
