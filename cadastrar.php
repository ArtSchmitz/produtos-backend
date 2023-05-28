<?php

//cabecalho obrigatorio
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");
// header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

//conexao com o db
include_once 'conexao.php';

$response_json = file_get_contents('php://input');
$dados = json_decode($response_json, true);

if ($dados){

    $query_produtos = "INSERT INTO produtos (titulo, descricao) VALUES (:titulo, :descricao)";
    $cad_produto = $conn->prepare($query_produtos);

    $cad_produto->bindParam(':titulo', $dados['produto']['titulo'], PDO::PARAM_STR);
    $cad_produto->bindParam(':descricao', $dados['produto']['descricao'], PDO::PARAM_STR);

    $cad_produto->execute();

    if($cad_produto->rowCount()){
        $response = [
            "error" => false,
            "mensagem" => "Produto cadastrado com sucesso"
        ];
    }else{
        $response = [
            "error" => true,
            "mensagem" => "Erro ao cadastrar produto"
            ];
    }

    $response = [
        "error" => false,
        "mensagem" => "Produto cadastrado com sucesso"
    ];
}else {
    $response = [
        "error" => true,
        "mensagem" => "Erro ao cadastrar produto"
    ];
}

http_response_code(200);
echo json_encode($response);