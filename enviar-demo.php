<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$configEmail = require __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

/* ---------- Verificação do método ---------- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'ok' => false,
        'message' => 'Método não permitido.'
    ]);
    exit;
}

/* ---------- Dados do formulário ---------- */
$nome     = trim($_POST['nome'] ?? '');
$empresa  = trim($_POST['empresa'] ?? '');
$email    = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$veiculos = trim($_POST['veiculos'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

/* ---------- Validação ---------- */
if (!$nome || !$empresa || !$email || !$telefone || !$veiculos) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'Preencha todos os campos obrigatórios.'
    ]);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'O e-mail informado não é válido.'
    ]);
    exit;
}

/* ---------- Proteção do conteúdo ---------- */
$nome     = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
$empresa  = htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8');
$email    = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$telefone = htmlspecialchars($telefone, ENT_QUOTES, 'UTF-8');
$veiculos = htmlspecialchars($veiculos, ENT_QUOTES, 'UTF-8');
$mensagem = nl2br(
    htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8')
);

/* ---------- E-mail ---------- */
$assunto = 'Nova solicitação de demonstração — InterFi';
$corpo = "
<!DOCTYPE html>
<html lang='pt'>
    <head>
        <meta charset='UTF-8'>
    </head>
    <body>
        <h2>Nova solicitação de demonstração</h2>
        <p><strong>Nome:</strong><br>
        {$nome}</p>
        <p><strong>Empresa:</strong><br>
        {$empresa}</p>
        <p><strong>E-mail:</strong><br>
        {$email}</p>
        <p><strong>Telefone:</strong><br>
        {$telefone}</p>
        <p><strong>Número de veículos:</strong><br>
        {$veiculos}</p>
        <p><strong>Mensagem:</strong><br>
        {$mensagem}</p>
        <hr>
        <p>
        <strong>InterFi</strong><br>
        O futuro da mobilidade começa aqui.
        </p>
    </body>
</html>
";

/* ---------- PHPMailer ---------- */
$mail = new PHPMailer(true);
$mail->SMTPDebug = 2;
$mail->Debugoutput = function ($str, $level) {
    error_log("SMTP: " . $str);
};

try {
    $mail->isSMTP();
    $mail->Host = 'smtppro.zoho.com';
    $mail->SMTPAuth = true;
    $mail->Username = $configEmail['usuario'];
    $mail->Password = $configEmail['password_app'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';

    /* Remetente */
    $mail->setFrom(
        'contato@interfi.net',
        'InterFi'
    );

    /* Destinatário */
    $mail->addAddress(
        'contato@interfi.net',
        'InterFi'
    );

    /* Responder diretamente ao cliente */
    $mail->addReplyTo(
        $email,
        $nome
    );
    $mail->isHTML(true);
    $mail->Subject = $assunto;
    $mail->Body = $corpo;
    $mail->send();
    echo json_encode([
        'ok' => true,
        'message' => 'Pedido enviado com sucesso.'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'message' => 'Erro ao enviar: ' . $mail->ErrorInfo
    ]);
}