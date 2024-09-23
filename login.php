<?php
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificação simples de login
    if ($username == 'breno' && $password == '123456') {
        // Armazenando o usuário na sessão
        $_SESSION['user'] = $username;

        // Verifica se o usuário quer ser lembrado com um cookie
        if (isset($_POST['remember'])) {
            // Define o cookie com duração de 7 dias (604800 segundos)
            setcookie('username', $username, time() + 604800, "/");
        }

        // Redireciona para o dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuário ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<form method="POST" action="">
    <label for="username">Usuário:</label>
    <input type="text" id="username" name="username" required value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>">
    <br><br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    <br><br>
    <input type="checkbox" id="remember" name="remember">
    <label for="remember">Lembrar meu usuário</label>
    <br><br>
    <button type="submit">Entrar</button>
</form>

<?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</body>
</html>
