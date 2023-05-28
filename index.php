<?php

//cabecalhos obrigatorios
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'conexao.php';

$query_produtos = "SELECT id, titulo, descricao FROM produtos ORDER BY id DESC";
$result_produtos = $conn->prepare($query_produtos);
$result_produtos->execute();
 
if(($result_produtos) AND ($result_produtos->rowCount() != 0)){
    while($row_produto = $result_produtos->fetch(PDO::FETCH_ASSOC)){
        extract($row_produto);

        $lista_produtos["records"][$id] = [
            'id' => $id,
            'titulo' => $titulo,
            'descricao' => $descricao
        ];
    }

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

    http_response_code(200);

    echo json_encode($lista_produtos);
}