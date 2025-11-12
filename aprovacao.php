<?php
// ===========================
// ✅ aprovacao.php
// ===========================
$id = $_GET['id'] ?? null;
$acao = $_GET['acao'] ?? null;

if (!$id || !$acao) {
  die("Parâmetros inválidos");
}

// Registra aprovação ou reprovação
$registro = date('Y-m-d H:i:s') . " | ID: {$id} | Ação: {$acao}\n";
file_put_contents('aprovacoes.txt', $registro, FILE_APPEND);

// Mensagem de retorno ao supervisor
$msg = ($acao === 'aprovar')
  ? "✅ A solicitação #{$id} foi <strong>APROVADA</strong> com sucesso!"
  : "❌ A solicitação #{$id} foi <strong>REPROVADA</strong>.";

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Resultado da Aprovação</title>
  <style>
    body {
      background: linear-gradient(135deg, #6dd5fa, #2980b9);
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .box {
      background: #fff;
      padding: 50px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      text-align: center;
      max-width: 450px;
    }
    .box h2 {
      color: #256fa7;
    }
    .box p {
      color: #333;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 20px;
      background-color: #256fa7;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: background-color 0.3s;
    }
    .btn:hover {
      background-color: #1b4f7c;
    }
  </style>
</head>
<body>
  <div class="box">
    <h2><?= $msg ?></h2>
    <p>Obrigado por realizar esta aprovação.</p>
    <a href="https://seudominio.com/relatorio.html" class="btn">Voltar ao Sistema</a>
  </div>
</body>
</html>
