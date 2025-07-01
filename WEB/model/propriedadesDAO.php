<?php

require_once ("dal/conexao.php");

function listarPropriedades($filtros){

    $sql =  "SELECT p.*, pr.nome AS nome_proprietario, i.dados AS imagem_blob, c.nome AS nome_cidade "
          . "FROM propriedades p "
          . "LEFT JOIN proprietarios pr ON p.id_proprietario = pr.id_proprietario "
          . "LEFT JOIN imagens_imoveis i ON i.id_imagem = p.id_imagem "
          . "LEFT JOIN cidade c ON p.id_cidade = c.id ";

    if (!empty($filtros)) {
        $sql .= " WHERE ";

        $filtrosMap = [
            'id_propriedade' => 'p.id_propriedade',
            'area' => 'p.area',
            'vagasGaragem' => 'p.vagasGaragem',
            'banheiros' => 'p.banheiros',
            'numeroCasa' => 'p.numeroCasa',
            'rua' => 'p.rua',
            'cidade' => 'c.nome',
            'jardim' => 'p.jardim',
            'piscina' => 'p.piscina',
            'sistemaSeguranca' => 'p.sistemaSeguranca',
            'mobiliada' => 'p.mobiliada'
        ];

        $primeiro = true;

        foreach ($filtros as $k => $v) {
            if ($v === '' || $v === null) {
                continue;
            }

            if (!isset($filtrosMap[$k])) {
                continue;
            }

            $coluna = $filtrosMap[$k];

            if ($primeiro) {
                $sql .= " " . $coluna . " = ? ";
                $primeiro = false;
            } else {
                $sql .= " AND " . $coluna . " = ? ";
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
        if ($v === '' || $v === null) {
            continue;
        }

        if (!isset($filtrosMap[$k])) {
            continue;
        }

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

    if ($stmt !== false) {
        return $stmt->fetchAll();
    }

    return false;
}

// Função para buscar uma propriedade específica por ID
function buscarPropriedadePorId($id){
    $pdo = conectar();

    $sql = "SELECT p.*, pr.nome AS nome_proprietario, i.dados AS imagem_blob, c.nome AS nome_cidade
            FROM propriedades p
            LEFT JOIN proprietarios pr ON p.id_proprietario = pr.id_proprietario
            LEFT JOIN imagens_imoveis i ON i.id_imagem = p.id_imagem
            LEFT JOIN cidade c ON p.id_cidade = c.id
            WHERE p.id_propriedade = ?
            GROUP BY p.id_propriedade
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, (int)$id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(); // retorna um único registro ou false
}
