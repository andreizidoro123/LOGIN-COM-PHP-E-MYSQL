<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
 <div class="container">
    <div class="trocar">
        <button onclick="mudarParaRegister()" class="troca">REGISTRAR</button>
    </div>
    <div class="formulario">
    <?php
session_start(); // Inicia uma nova sessão ou resume a sessão existente

// Cria uma nova conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'formulario-login');
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error); // Verifica se houve erro na conexão e encerra o script se houve
}

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['usuariologin'])) {
        // Lógica de login
        $username = $_POST['usuariologin']; // Obtém o nome de usuário do formulário
        $password = $_POST['senhalogin'];   // Obtém a senha do formulário

        // Prepara uma declaração SQL para selecionar a senha do usuário
        $stmt = $conn->prepare("SELECT password FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username); // Substitui o ? na declaração SQL pelo nome de usuário
        $stmt->execute(); // Executa a declaração
        $stmt->store_result(); // Armazena o resultado

        // Verifica se o usuário existe
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password); // Liga a variável $hashed_password ao resultado da consulta
            $stmt->fetch(); // Obtém o resultado

            // Verifica se a senha fornecida corresponde ao hash armazenado
            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username; // Define a sessão do usuário
                header("Location: entrar.php"); // Redireciona para a página "entrar.php"
                exit(); // Encerra o script
            } else {
                echo "Senha incorreta."; // Mensagem de erro se a senha estiver incorreta
            }
        } else {
            echo "Usuário não encontrado."; // Mensagem de erro se o usuário não for encontrado
        }
        $stmt->close(); // Fecha a declaração
    } elseif (isset($_POST['usuarioregistro'])) {
        // Lógica de registro
        $username = $_POST['usuarioregistro']; // Obtém o nome de usuário do formulário de registro
        $email = $_POST['emailregistro'];      // Obtém o email do formulário de registro
        $password = password_hash($_POST['senharegistro'], PASSWORD_BCRYPT); // Criptografa a senha

        // Verificar se o email já está registrado
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email); // Substitui o ? na declaração SQL pelo email
        $stmt->execute(); // Executa a declaração
        $stmt->store_result(); // Armazena o resultado

        // Verifica se o email já está registrado
        if ($stmt->num_rows > 0) {
            echo "Este email já está registrado."; // Mensagem de erro se o email já estiver registrado
        } else {
            $stmt->close(); // Fecha a declaração

            // Prepara uma declaração SQL para inserir um novo usuário
            $stmt = $conn->prepare("INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password); // Substitui os ? na declaração SQL pelos valores fornecidos
            
            // Executa a declaração e verifica se a inserção foi bem-sucedida
            if ($stmt->execute()) {
                echo "Usuário registrado com sucesso!"; // Mensagem de sucesso
            } else {
                echo "Erro: " . $stmt->error; // Mensagem de erro se a inserção falhar
            }
        }
        $stmt->close(); // Fecha a declaração
    }
}
$conn->close(); // Fecha a conexão com o banco de dados
?>

        <form id="loginForm" class="logar" method="POST">
            <h2>LOGIN</h2>
            <input type="text" placeholder="Insira seu nome de usuário" name="usuariologin" id="usuarioLogin" required>
            <input type="password" placeholder="Insira sua senha" name="senhalogin" id="senhaLogin" required>
            <button type="submit">Entrar</button>
        </form>

        <form id="registerForm" style="display: none;" method="POST">
            <h2>REGISTRAR</h2>
            <input type="text" placeholder="Insira seu nome de usuário" name="usuarioregistro" id="usuarioRegistro" required>
            <input type="email" placeholder="Insira seu E-mail" name="emailregistro" required>
            <input type="password" placeholder="Insira sua senha" name="senharegistro" required>
            <button type="submit">Registrar</button>
        </form>
    </div>
 </div>
</body>
<script src="scripts.js"></script>
</html>
