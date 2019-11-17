<?php
session_start();
require_once 'config.php';

if (isset($_POST['agencia']) && !empty(['agencia'])){
    $agencia = addslashes($_POST['agencia']);
    $conta = addslashes($_POST['conta']);
    $senha = addslashes($_POST['senha']);

    $sql = $pdo->prepare("SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta AND senha = :senha");
    $sql->bindValue(":agencia", $agencia);
    $sql->bindValue(":conta", $conta);
    $sql->bindValue(":senha", md5($senha));
    $sql->execute();

    if ($sql->rowCount() > 0){
        $sql = $sql->fetch();

        $_SESSION['banco'] = $sql['id'];
        header("Location: index.php");
        exit;
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Caixa Eletronico</title>
</head>

<style>
    body{
        background-color: #5c5c5c;
    }
    .login{
        background-color: white;
        border: 2px solid #000;
        padding: 20px;
        width: 400px;
        margin: auto;
        margin-top: 200px;
        box-shadow: 5px 5px 0px #000;
        border-radius: 20px;
    }
</style>
<body>
<div class="login">
    <form method="post">
        <div class="form-group">
            <label>Agencia:</label>
            <input class="form-control" type="text" name="agencia" placeholder="Agencia">
        </div>
        <div class="form-group">
            <label>Conta:</label>
            <input class="form-control" type="text" name="conta" placeholder="Conta">
        </div>
        <div class="form-group">
            <label>Senha:</label>
            <input class="form-control" type="password" name="senha" placeholder="Senha">
        </div>

        <input class="btn btn-primary" type="submit" value="Enviar">
    </form>
</div>

</body>
</html>
