<?php
include_once './model/propriedadesDAO.php';

// Filtros
$filtros = [];

$campos = [
  'area', 'vagas', 'sistemaSeguranca', 'rua', 'quartos',
  'mobiliada', 'piscina', 'numeroCasa', 'banheiros',
  'jardim', 'cidade'
];

foreach ($campos as $campo) {
  if (!empty($_GET[$campo])) {
    $filtros[$campo] = $_GET[$campo];
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BlueHorizon - página inicial</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: white;
      margin: 24px;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .filter-container {
      background-color: #57b7e3;
      border-radius: 12px;
      border: 1px solid #000000;
      padding: 24px 32px;
      margin-bottom: 48px;
    }

    .header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 24px;
      gap: 12px;
    }

    h2 {
      font-weight: 700;
      font-size: 18px;
      color: #121212;
      margin: 0;
    }

    .property-code-container {
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
      flex-shrink: 0;
    }

    .property-code-label {
      font-weight: 600;
      font-size: 13px;
      color: #121212;
    }

    .property-code-input {
      width: 425px;
      font-size: 13px;
      padding: 6px 12px;
      border-radius: 6px;
      border: 1px solid #cccccc;
      color: #555555;
      background: white;
    }

    .property-code-input::placeholder {
      font-weight: 400;
      color: #b5b5b5;
    }

    .property-code-input:focus {
      outline-offset: 2px;
      outline-color: #57b7e3;
    }

    .inputs-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px 28px;
      align-items: center;
    }

    .input-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
      font-size: 13px;
      font-weight: 600;
      color: #121212;
    }

    input[type="text"] {
      border-radius: 6px;
      border: 1px solid #cccccc;
      padding: 6px 12px;
      font-size: 13px;
      font-weight: 400;
      color: #555555;
      background: white;
      outline-offset: 2px;
      outline-color: transparent;
      transition: outline-color 0.2s ease;
    }

    input[type="text"]::placeholder {
      color: #b5b5b5;
      font-weight: 400;
    }

    input[type="text"]:focus {
      outline-color: #57b7e3;
    }

    .button-container {
      grid-column: 4 / 5;
      justify-self: center;
      padding-top: 24px;
    }

    .btn-search {
      background: linear-gradient(to bottom, #e4e4e4 0%, #aaa 100%);
      border-radius: 4px;
      border: 1px solid #888;
      padding: 6px 16px;
      color: #121212;
      font-weight: 600;
      font-size: 13px;
      cursor: pointer;
      box-shadow: inset 0 1px 0 white;
      transition: background 0.3s ease, box-shadow 0.2s ease;
      user-select: none;
      width: 200px;
    }

    .btn-search:hover {
      background: linear-gradient(to bottom, #cccccc 0%, #999999 100%);
      box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Div dos cards com scroll horizontal */
    .results-container {
      background-color: #57b7e3;
      border-radius: 12px;
      border: 1px solid #000000;
      padding: 24px;
      height: 600px;

      display: flex;
      flex-wrap: nowrap; /* Sem quebra de linha */
      overflow-x: auto;  /* Scroll horizontal */
      overflow-y: hidden; /* Sem scroll vertical */
      gap: 24px;
    }

    /* Estilo dos cards */
    .property-card {
      min-width: 280px;
      background: #d9d9d9;
      border-radius: 8px;
      border: 1px solid #aaa;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      cursor: pointer; /* Deixa o cursor de mãozinha */
      transition: transform 0.2s ease;
    }

    .property-card:hover {
      transform: scale(1.05);
      box-shadow: 0 0 12px rgba(0,0,0,0.2);
    }

    .property-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .property-card .info {
      padding: 12px 16px;
      font-size: 13px;
      color: #333;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .property-card .info div {
      display: flex;
      justify-content: space-between;
    }

    .property-card .info div span:first-child {
      font-weight: bold;
      color: #000;
    }

    /* Responsivo */
    @media (max-width: 1024px) {
      .inputs-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .button-container {
        grid-column: auto;
        justify-self: start;
        padding-top: 12px;
      }

      .header-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
      }

      .property-code-container {
        width: 100%;
        justify-content: flex-start;
        gap: 6px;
      }

      .property-code-input {
        width: 150px;
      }
    }

    @media (max-width: 480px) {
      .inputs-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="filter-container" role="region" aria-labelledby="filterTitle">
    <div class="header-row">
      <h2 id="filterTitle">Pesquisa filtrada</h2>
      <div class="property-code-container">
        <label for="codImovel" class="property-code-label">Cód. do Imóvel:</label>
        <input id="codImovel" type="text" class="property-code-input" placeholder="Inserir cód do imóvel" />
      </div>
    </div>
    <form action="telaHome.php" method="get">
      <div class="inputs-grid">
        <?php
        // Geração automática dos campos com manutenção de valores
        $labels = [
          'area' => 'Área (metro quadrado)',
          'vagas' => 'Vagas de Garagem',
          'sistemaSeguranca' => 'Sistema de Segurança',
          'rua' => 'Rua',
          'quartos' => 'Quartos',
          'mobiliada' => 'Mobiliada',
          'piscina' => 'Piscina',
          'numeroCasa' => 'Número da Casa',
          'banheiros' => 'Banheiros',
          'jardim' => 'Jardim',
          'cidade' => 'Cidade'
        ];

        foreach ($labels as $campo => $label) {
          $valor = htmlspecialchars($_GET[$campo] ?? '', ENT_QUOTES);
          echo "
          <div class='input-group'>
            <label for='{$campo}'>{$label}</label>
            <input id='{$campo}' name='{$campo}' type='text' placeholder='Inserir {$label}' value='{$valor}' />
          </div>";
        }
        ?>
        <div class="button-container">
          <button type="submit" class="btn-search">Pesquisar</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Cards dos imóveis -->
  <div class="results-container" aria-label="Resultados da pesquisa">
    <?php 
    $result = listarPropriedades($filtros);
    foreach ($result as $imovel) {
      echo '<div class="property-card" data-id="' . $imovel['id_propriedade'] . '">';

      // Imagem
      if (!empty($imovel['imagem_blob'])) {
        $imgBase64 = base64_encode($imovel['imagem_blob']);
        echo "<img src='data:image/jpeg;base64,{$imgBase64}' alt='Imagem imóvel' />";
      } else {
        echo "<img src='imageExemplos/imagemExemplo.jpg' alt='Imagem padrão' />";
      }

      echo '<div class="info">';
      echo '<div><span>ID:</span><span>' . $imovel['id_propriedade'] . '</span></div>';
      echo '<div><span>Cidade:</span><span>' . $imovel['nome_cidade'] . '</span></div>';
      echo '<div><span>Rua:</span><span>' . $imovel['rua'] . '</span></div>';
      echo '<div><span>Número:</span><span>' . $imovel['numeroCasa'] . '</span></div>';
      echo '<div><span>Área:</span><span>' . $imovel['area'] . '</span></div>';
      echo '<div><span>Banheiros:</span><span>' . $imovel['banheiros'] . '</span></div>';
      echo '<div><span>Quartos:</span><span>' . $imovel['quartos'] . '</span></div>';
      echo '<div><span>Vagas Garagem:</span><span>' . $imovel['vagasGaragem'] . '</span></div>';
      echo '<div><span>Jardim:</span><span>' . ($imovel['jardim'] ? 'Sim' : 'Não') . '</span></div>';
      echo '<div><span>Piscina:</span><span>' . ($imovel['piscina'] ? 'Sim' : 'Não') . '</span></div>';
      echo '<div><span>Sistema Segurança:</span><span>' . ($imovel['sistemaSeguranca'] ? 'Sim' : 'Não') . '</span></div>';
      echo '<div><span>Mobiliada:</span><span>' . ($imovel['mobilia'] ? 'Sim' : 'Não') . '</span></div>';
      echo '</div>'; // .info
      echo '</div>'; // .property-card
    }
    ?>
  </div>

  <script>
    // Torna todos os cards clicáveis e leva para a página de detalhes
    document.querySelectorAll('.property-card').forEach(card => {
      card.addEventListener('click', () => {
        const id = card.getAttribute('data-id');
        if(id) {
          window.location.href = `telaImovelVenda.php?id=${id}`;
        }
      });
    });
  </script>
</body>
</html>
