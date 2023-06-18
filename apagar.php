<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");

include_once 'conexao.php';

$response_json = file_get_contents('php://input');
$dados = json_decode($response_json, true);

if ($dados && isset($dados['produto']['id'])) {
    $query_delete = "DELETE FROM produtos WHERE id = :id";
    $delete_produto = $conn->prepare($query_delete);
    $delete_produto->bindParam(':id', $dados['produto']['id'], PDO::PARAM_INT);
    $delete_produto->execute();

    if ($delete_produto->rowCount()) {
        $response = [
            "error" => false,
            "mensagem" => "Produto removido com sucesso"
        ];
    } else {
        $response = [
            "error" => true,
            "mensagem" => "Erro ao remover produto"
        ];
    }
} else {
    $response = [
        "error" => true,
        "mensagem" => "Erro ao remover produto: ID inválido"
    ];
}

http_response_code(200);
echo json_encode($response);