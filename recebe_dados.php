<?php
// ===========================
// 📩 recebe_dados.php
// ===========================

// Recebe o JSON enviado pelo Webhook do JotForm
$data = file_get_contents("php://input");
$form = json_decode($data, true);

// LOG opcional para depuração
file_put_contents("log_webhook.txt", print_r($form, true));

// Pega dados principais (ajuste conforme os nomes dos campos do seu formulário)
$submissionID = $form['submissionID'] ?? uniqid();
$nome = $form['q1_nome'] ?? 'Não informado';
$emailUsuario = $form['q2_email'] ?? 'sem-email@cea.com';
$descricao = $form['q3_mensagem'] ?? 'Sem descrição';

// E-mail do supervisor
$supervisorEmail = "jordannogueira@cea-termoeletrica.com.br"; // 🔹 altere aqui

// Cria links de aprovação e reprovação
$linkAprovar = "https://seudominio.com/aprovacao.php?id={$submissionID}&acao=aprovar";
$linkReprovar = "https://seudominio.com/aprovacao.php?id={$submissionID}&acao=reprovar";

// Monta corpo do e-mail
$mensagem = "
<html>
  <body style='font-family: Arial, sans-serif; background-color: #f5f8fc; padding: 20px;'>
    <div style='max-width: 600px; margin: auto; background: #fff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);'>
      <h2 style='color:#256fa7;'>Nova Sugestão de Melhoria Recebida</h2>
      <p><strong>Nome:</strong> {$nome}</p>
      <p><strong>E-mail:</strong> {$emailUsuario}</p>
      <p><strong>Descrição:</strong><br>{$descricao}</p>
      <hr style='margin: 20px 0;'>
      <p>Escolha uma ação:</p>
      <p>
        <a href='{$linkAprovar}' style='padding:12px 18px;background:#28a745;color:white;text-decoration:none;border-radius:6px;'>✅ Aprovar</a>
        <a href='{$linkReprovar}' style='padding:12px 18px;background:#dc3545;color:white;text-decoration:none;border-radius:6px;margin-left:10px;'>❌ Reprovar</a>
      </p>
      <hr>
      <small style='color:#666;'>CEA - Sistema de Aprovação Automática</small>
    </div>
  </body>
</html>
";

// Envia e-mail
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html;charset=UTF-8\r\n";
$headers .= "From: CEA Sistema <no-reply@cea.com>\r\n";

if (mail($supervisorEmail, "Nova Sugestão de Melhoria - Aprovação Necessária", $mensagem, $headers)) {
  echo "Webhook recebido e e-mail enviado com sucesso.";
} else {
  echo "Erro ao enviar e-mail.";
}
?>
