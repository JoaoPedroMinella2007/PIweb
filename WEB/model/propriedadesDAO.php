<?php


require_once ("dal/conexao.php");



function listarPropriedades($filtros){

    

    

    $sql =  "SELECT p.*, pr.nome AS nome_proprietario, i.dados AS imagem_blob "
    . "FROM propriedades p "
    . "LEFT JOIN proprietarios pr ON p.id_proprietario = pr.id_proprietario "
    . "LEFT JOIN imagens_imoveis i ON i.id_imagem = p.id_imagem ";

   
    if(empty($filtros)==false){
        $sql .= " WHERE " ;
        
        $primeiro = true;
        foreach($filtros as $k=>$v){
            if($primeiro == true) 
                $sql .= " ".$k." = ?  ";
        else
            $sql .= " AND ".$k." = ?  ";

             
            

        }

     

    }
    $sql .=  " GROUP BY p.id_propriedade";
    $pdo = conectar();
    $stmt = $pdo->prepare($sql);

    $i=1;
    foreach($filtros as $k=>$v){
       
        switch ($k) {
            case 'area':
            case 'vagas':
                $stmt->bindParam($i, $v, PDO::PARAM_INT);
                break;
        
            case 'rua':
                $stmt->bindParam($i, $v, PDO::PARAM_STR);
                break;
            case 'jardim':
            case 'piscina':
                    $stmt->bindParam($i, $v, PDO::PARAM_INT);
                    break;
            
        }
       
        $i++;
   }

   $stmt->execute();

    if($stmt!=false){
        return $stmt->fetchAll();
    }
    return $stmt;
}