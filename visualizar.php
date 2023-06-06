<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'conexao.php';

// $id = 1;
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$response = "";

$query_produtos = "SELECT id, titulo, descricao FROM produtos WHERE id=:id LIMIT 1";
$result_produtos = $conn->prepare($query_produtos);
$result_produtos->bindParam(':id', $id_param, PDO::PARAM_INT);
$id_param = $id;
$result_produtos->execute();

if(($result_produtos) AND ($result_produtos->rowCount() != 0)){
    $row_produto = $result_produtos->fetch(PDO::FETCH_ASSOC);
    extract($row_produto);

    $produto = [
        'id' => $id,
        'titulo' => $titulo,
        'descricao' => $descricao
    ];
    $response = [
        "erro" => false,
        "mensagem" => $produto
    ];
}else{
    $response = [
        "erro" => true,
        "mensagem" => "Produto não encontrado!"
    ];
}
http_response_code(200);
echo json_encode($response);