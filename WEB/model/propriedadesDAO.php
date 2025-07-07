<?php

require_once("dal/conexao.php");

// FUNÇÃO PARA LISTAR PROPRIEDADES COM FILTROS OPCIONAIS
function listarPropriedades($filtros) {
    $sql = "SELECT 
                p.*, 
                pr.nome AS nome_proprietario, 
                i.dados AS imagem_blob, 
                c.nome AS nome_cidade 
            FROM propriedades p 
            LEFT JOIN proprietarios pr ON p.id_proprietario = pr.id_proprietario 
            LEFT JOIN imagens_imoveis i ON i.id_imagem = p.id_imagem 
            LEFT JOIN cidade c ON p.id_cidade = c.id ";

    if (!empty($filtros)) {
        $sql .= " WHERE ";

        $filtrosMap = [
            'id_propriedade'     => 'p.id_propriedade',
            'area'               => 'p.area',
            'vagasGaragem'       => 'p.vagasGaragem',
            'banheiros'          => 'p.banheiros',
            'numeroCasa'         => 'p.numeroCasa',
            'rua'                => 'p.rua',
            'cidade'             => 'c.nome',
            'jardim'             => 'p.jardim',
            'piscina'            => 'p.piscina',
            'sistemaSeguranca'   => 'p.sistemaSeguranca',
            'mobiliada'          => 'p.mobilia'
        ];

        $primeiro = true;

        foreach ($filtros as $k => $v) {
            if ($v === '' || $v === null) continue;
            if (!isset($filtrosMap[$k])) continue;

            $coluna = $filtrosMap[$k];

            if ($primeiro) {
                $sql .= " $coluna = ? ";
                $primeiro = false;
            } else {
                $sql .= " AND $coluna = ? ";
            }
        }

        if ($primeiro) {
            $sql = rtrim($sql, " WHERE ");
        }
    }

    $sql .= " GROUP BY p.id_propriedade";

    $pdo = conectar();
    $stmt = $pdo->prepare($sql);

    $i = 1;
    foreach ($filtros as $k => $v) {
        if ($v === '' || $v === null) continue;
        if (!isset($filtrosMap[$k])) continue;

        switch ($k) {
            case 'id_propriedade':
            case 'area':
            case 'vagasGaragem':
            case 'banheiros':
            case 'numeroCasa':
            case 'jardim':
            case 'piscina':
            case 'sistemaSeguranca':
            case 'mobiliada':
                $stmt->bindValue($i, (int)$v, PDO::PARAM_INT);
                break;

            case 'rua':
            case 'cidade':
                $stmt->bindValue($i, $v, PDO::PARAM_STR);
                break;

            default:
                $stmt->bindValue($i, $v);
                break;
        }

        $i++;
    }

    $stmt->execute();

    return $stmt !== false ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
}

// FUNÇÃO PARA BUSCAR UMA PROPRIEDADE ESPECÍFICA POR ID
function buscarPropriedadePorId($id) {
    $conn = conectar();

    $sql = "SELECT 
                p.id_propriedade,
                p.preco,
                p.disponibilidade,
                p.data_cadastro,
                p.area,
                p.quartos,
                p.banheiros,
                p.vagasGaragem,
                p.mobilia,
                p.jardim,
                p.piscina,
                p.sistemaSeguranca,
                p.rua,
                p.numeroCasa,
                c.nome AS nome_cidade,
                pr.nome AS nome_proprietario,
                pr.email AS email_proprietario,
                pr.telefone AS telefone_proprietario,
                i.dados AS imagem_blob
            FROM propriedades p
            LEFT JOIN cidade c ON p.id_cidade = c.id
            LEFT JOIN proprietarios pr ON p.id_proprietario = pr.id_proprietario
            LEFT JOIN imagens_imoveis i ON i.id_imagem = p.id_imagem
            WHERE p.id_propriedade = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
