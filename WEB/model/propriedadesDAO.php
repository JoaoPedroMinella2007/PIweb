<?php


require_once ("dal/conexao.php");



function listarPropriedades(){

    

    

    $sql =  "SELECT p.*, pr.nome AS nome_proprietario, i.dados AS imagem_blob "
    . "FROM propriedades p "
    . "LEFT JOIN proprietarios pr ON p.id_proprietario = pr.id_proprietario "
    . "LEFT JOIN imagens_imoveis i ON i.id_imagem = p.id_imagem "
    . "GROUP BY p.id_propriedade";

    $pdo = conectar();
    $stmt = $pdo->query($sql);
    if($stmt!=false){
        return $stmt->fetchAll();
    }
    return $stmt;
}