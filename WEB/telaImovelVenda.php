<?php
include_once("model/propriedadesDAO.php");

// Pega o ID do imóvel via GET
$id = $_GET['id'] ?? null;

if (!$id) {
  die("ID do imóvel não fornecido.");
}

// Busca os dados do imóvel no banco
$imovel = buscarPropriedadePorId($id);

if (!$imovel) {
  die("Imóvel não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BlueHorizon - Imóvel à Venda</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #41687a; /* azul sólido */
      color: #222;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 100vh;
    }
    h1 {
      color: #f0f0f0;
      text-align: center;
      margin: 60px 0 20px 0;
      font-weight: 700;
      font-size: 24px;
      text-shadow: 0 1px 2px rgba(0,0,0,0.15);
    }
    main {
      max-width: 900px;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      margin-bottom: 40px;
    }
    .card-image {
      flex: 1 1 320px;
      min-height: 220px;
      background: #fff;
      border: 1px solid #999;
      box-shadow: 1px 1px 5px #3333;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card-image img, .card-image svg {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .card-info-owner,
    .card-info-property {
      background: #ccc;
      border: 1px solid #a0a0a0;
      box-shadow: inset 0 0 8px #8886;
      padding: 16px 20px;
      font-size: 13px;
      line-height: 1.4;
    }
    .card-info-owner {
      flex: 1 1 320px;
      min-height: 140px;
    }
    .card-info-owner > h2,
    .card-info-property > h2 {
      font-weight: 600;
      font-size: 14px;
      margin-top: 0;
      margin-bottom: 7px;
      text-align: center;
    }
    .card-info-owner p,
    .card-info-property p {
      margin: 7px 0;
    }
    .card-info-property {
      flex: 1 1 500px;
      min-height: 220px;
    }
    .divider-line {
      margin: 14px 0 12px 0;
      border: none;
      border-bottom: 1px solid #888;
    }
    .info-double-col {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
    }
    .info-double-col > div {
      flex: 1;
    }
    .info-double-col div p {
      margin: 5px 0;
    }

    @media (max-width: 750px) {
      main {
        flex-direction: column;
        align-items: center;
      }
      .card-info-property,
      .card-info-owner {
        min-width: 320px;
      }
    }
  </style>
</head>
<body>

<h1>IMÓVEL À VENDA</h1>

<main>
  <section class="card-image" aria-label="Imagem do imóvel">
    <img src="imageExemplos/imagemExemplo.jpg" alt="Imagem do imóvel">
  </section>

  <section class="card-info-property" aria-label="Informações do imóvel">
    <h2>Informações do imóvel</h2>
    <p><strong>ID:</strong> <?php echo $imovel['id_propriedade']; ?></p>
    <p><strong>Valor:</strong> R$ <?php echo number_format($imovel['valor'], 2, ',', '.'); ?></p>
    <p><strong>Disponibilidade:</strong> <?php echo $imovel['disponivel'] ? 'Disponível' : 'Indisponível'; ?></p>
    <p><strong>Data de cadastro:</strong> <?php echo date("d/m/Y", strtotime($imovel['dataCadastro'])); ?></p>

    <hr class="divider-line" />

    <div class="info-double-col">
      <div>
        <p><strong>Área (m²):</strong> <?php echo $imovel['area']; ?></p>
        <p><strong>Quartos:</strong> <?php echo $imovel['quartos']; ?></p>
        <p><strong>Banheiros:</strong> <?php echo $imovel['banheiros']; ?></p>
        <p><strong>Vagas de garagem:</strong> <?php echo $imovel['vagasGaragem']; ?></p>
        <p><strong>Mobiliada:</strong> <?php echo $imovel['mobilia'] ? 'Sim' : 'Não'; ?></p>
        <p><strong>Jardim:</strong> <?php echo $imovel['jardim'] ? 'Sim' : 'Não'; ?></p>
      </div>
      <div>
        <p><strong>Piscina:</strong> <?php echo $imovel['piscina'] ? 'Sim' : 'Não'; ?></p>
        <p><strong>Sistema de segurança:</strong> <?php echo $imovel['sistemaSeguranca']; ?></p>
        <p><strong>Cidade:</strong> <?php echo $imovel['nome_cidade']; ?></p>
        <p><strong>Rua:</strong> <?php echo $imovel['rua']; ?></p>
        <p><strong>Numeração do imóvel:</strong> <?php echo $imovel['numeroCasa']; ?></p>
      </div>
    </div>
  </section>

  <section class="card-info-owner" aria-label="Informações do proprietário">
    <h2>Informações do proprietário</h2>
    <p><strong>Nome:</strong> <?php echo $imovel['nome_proprietario']; ?></p>
    <p><strong>Email:</strong> <?php echo $imovel['email_proprietario']; ?></p>
    <p><strong>Telefone:</strong> <?php echo $imovel['telefone_proprietario']; ?></p>
  </section>
</main>

</body>
</html>
