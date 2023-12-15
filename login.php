<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "interventoras";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para verificar o login
function verificarLogin($Email, $Senha, $conn) {
    // Consulta SQL para verificar se o usuário e senha existem no banco de dados
    $sql = "SELECT * FROM cadastrodeusuario WHERE Email='$Email' AND Senha='$Senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuário autenticado com sucesso
        return true;
    } else {
        // Falha na autenticação
        return false;
    }
}

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber dados do formulário
    $Email = $_POST["Email"];
    $Senha = $_POST["Senha"];

    // Verificar o login
    if (verificarLogin($Email, $Senha, $conn)) {
        echo "Login bem-sucedido!";
        // Aguarde 5 segundos
        sleep(3);
        header("Location: index.html");
            exit();
        // Adicione aqui o redirecionamento para a página após o login
    } else {
        echo "Usuário ou senha inválidos.";
    }
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
