Vamos combinar os dois exemplos que mencionei, criando um sistema de login com **sessões** e **cookies** para lembrar o nome do usuário. O sistema permitirá que o usuário faça login e, caso ele opte por ser lembrado, o nome será salvo em um cookie e exibido nas próximas visitas, mesmo após fechar o navegador.

### **Sistema de Login com Sessões e Cookies**

#### Estrutura dos arquivos:
1. `login.php` – Formulário de login.
2. `dashboard.php` – Área de boas-vindas com sessão e cookie.
3. `logout.php` – Destrói a sessão e redireciona para a página de login.

---

#### **Arquivo: `login.php`**

Aqui vamos adicionar a funcionalidade de "lembrar usuário", que define um cookie com o nome do usuário.

```php
<?php
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Verificação simples de login
    if ($username == 'admin' && $password == '123456') {
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
```

---

#### **Arquivo: `dashboard.php`**

Essa página só pode ser acessada se o usuário estiver logado. Caso o usuário tenha marcado "Lembrar meu usuário", ele será saudado com seu nome a partir do cookie.

```php
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
```

---

#### **Arquivo: `logout.php`**

Este script destrói a sessão do usuário e o redireciona de volta para a página de login. Ele também limpa o cookie se o usuário fizer logout.

```php
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
```

---

### **Funcionamento do Sistema:**

1. **Login:**
    - O aluno preenche o nome de usuário e senha.
    - Se o login for bem-sucedido, o nome do usuário é salvo na sessão.
    - Se o checkbox "Lembrar meu usuário" estiver marcado, o nome também será salvo em um cookie.

2. **Dashboard:**
    - O usuário verá uma mensagem de boas-vindas com o nome armazenado na sessão ou no cookie (caso o cookie esteja definido).
    - Ao acessar novamente, se o cookie existir, o nome será pré-preenchido no campo de login.

3. **Logout:**
    - A sessão é destruída, e o cookie é apagado.
    - O usuário é redirecionado para a página de login.

---

Com esses arquivos, você poderá demonstrar um sistema funcional de login com **sessões e cookies** para lembrar o nome do usuário e garantir uma experiência de aula prática no PhpStorm!