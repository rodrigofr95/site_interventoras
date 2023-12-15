<?php
// Conectar ao banco de dados
$host = 'localhost';
$user = 'root';
$pass = '1234';
$db = 'interventoras';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    error_log("Falha na conexão com o banco de dados.");
    echo "<h2>Ocorreu um problema. Por favor, tente novamente mais tarde.</h2>";
    exit();
}

// ... outras partes do código ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nome = trim($_POST['Nome']);
    $Email = trim($_POST['Email']);

    // Validate email format
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo "<h2>Formato de e-mail inválido.</h2>";
        exit();
    }

    $Senha = $_POST['Senha'];

    // Hash da senha usando PASSWORD_DEFAULT
    $SenhaHash = password_hash($Senha, PASSWORD_DEFAULT);

    // Preparar e executar a consulta
    $sql = "INSERT INTO cadastrodeusuario (Nome, Email, Senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $Nome, $Email, $Senha);

        // Executar a consulta preparada
        if ($stmt->execute()) {
            header("Location: signinsuccess.html");
            exit();
        } else {
            error_log("Erro ao inserir registro: " . $stmt->error);
            echo "<h2>Ocorreu um erro durante o registro. Por favor, tente novamente mais tarde.</h2>";
        }

        // Limpar recursos
        $stmt->close();
    } else {
        error_log("Erro na preparação da consulta.");
        echo "<h2>Ocorreu um problema. Por favor, tente novamente mais tarde.</h2>";
    }
}

// ... outras partes do código ...

// Fechar a conexão ao final do script
$conn->close();
?>
