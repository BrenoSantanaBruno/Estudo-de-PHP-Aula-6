<?php
session_start();

// Verifica se o usuário está logado na sessão
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Verifica se o cookie está setado para lembrar o nome do usuário
if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
} else {
    $username = $_SESSION['user'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
<h2>Bem-vindo, <?php echo htmlspecialchars($username); ?>!</h2>
<p>Você está logado.</p>
<a href="logout.php">Sair</a>
</body>
</html>
