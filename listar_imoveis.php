<?php
$host = "localhost";
$usuario = "root";
$senha = ""; // ajuste conforme seu ambiente
$banco = "bluehorizon";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$sql = "SELECT * FROM imoveis ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($imovel = $result->fetch_assoc()) {
        echo '<div class="property-card" data-id="' . $imovel['id'] . '">';
        echo '  <img src="imageExemplos/imagemExemplo.jpg" alt="Imagem imóvel" />';
        echo '  <div class="info">';
        echo '    <div><span>ID:</span><span>' . $imovel['id'] . '</span></div>';
        echo '    <div><span>Cidade:</span><span>' . $imovel['cidade'] . '</span></div>';
        echo '    <div><span>Rua:</span><span>' . $imovel['rua'] . '</span></div>';
        echo '    <div><span>Número:</span><span>' . $imovel['numero_casa'] . '</span></div>';
        echo '    <div><span>Área:</span><span>' . $imovel['area'] . '</span></div>';
        echo '    <div><span>Banheiros:</span><span>' . $imovel['banheiros'] . '</span></div>';
        echo '    <div><span>Quartos:</span><span>' . $imovel['quartos'] . '</span></div>';
        echo '    <div><span>Vagas Garagem:</span><span>' . $imovel['vagas'] . '</span></div>';
        echo '    <div><span>Jardim:</span><span>' . $imovel['jardim'] . '</span></div>';
        echo '    <div><span>Piscina:</span><span>' . $imovel['piscina'] . '</span></div>';
        echo '    <div><span>Sistema Segurança:</span><span>' . $imovel['sistema_seguranca'] . '</span></div>';
        echo '    <div><span>Mobiliada:</span><span>' . $imovel['mobiliada'] . '</span></div>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo "<p>Nenhum imóvel encontrado.</p>";
}

$conn->close();
?>
