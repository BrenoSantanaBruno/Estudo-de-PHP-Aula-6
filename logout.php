<?php
session_start();

// Destrói a sessão
session_destroy();

// Limpa o cookie do nome de usuário, se existir
if (isset($_COOKIE['username'])) {
    setcookie('username', '', time() - 3600, "/"); // Expira o cookie
}

// Redireciona para a página de login
header("Location: login.php");
exit;
?>
