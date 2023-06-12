<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");

include_once 'conexao.php';

$response_json = file_get_contents("php://input");
$dados = json_decode($response_json, true);

if ($dados) {
    $query_verificar_id = "SELECT * FROM produtos WHERE id=:id";
    $verificar_id = $conn->prepare($query_verificar_id);
    $verificar_id->bindParam(':id', $dados['id'], PDO::PARAM_INT);
    $verificar_id->execute();

    if ($verificar_id->rowCount() > 0) {
        $query_produto = "UPDATE produtos SET titulo=:titulo, descricao=:descricao WHERE id=:id";
        $edit_produto = $conn->prepare($query_produto);

        $edit_produto->bindParam(':titulo', $dados['titulo'], PDO::PARAM_STR);
        $edit_produto->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        $edit_produto->bindParam(':id', $dados['id'], PDO::PARAM_INT);

        $edit_produto->execute();

        if ($edit_produto->rowCount()) {
            $response = [
                "erro" => false,
                "mensagem" => "Produto editado com sucesso!"
            ];
        } else {
            $response = [
                "erro" => true,
                "mensagem" => "Erro, produto não editado com sucesso!"
            ];
        }
    } else {
        $response = [
            "erro" => true,
            "mensagem" => "Erro, ID do produto não encontrado!"
        ];
    }
} else {
    $response = [
        "erro" => true,
        "mensagem" => "Erro, dados não foram recebidos corretamente!"
    ];
}

http_response_code(200);
echo json_encode($response);
