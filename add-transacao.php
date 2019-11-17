<?php
session_start();
require_once 'config.php';

if (isset($_POST['tipo'])){
    $tipo = addslashes($_POST['tipo']);
    $valor = addslashes(str_replace(",", ".", $_POST['valor']));
    $valor = floatval($valor);

    $sql = $pdo->prepare("INSERT INTO historico (id_conta, tipo, valor, data_operacao)
                                    VALUES (:id_conta, :tipo, :valor, NOW())");

    $sql->bindValue(":id_conta", $_SESSION['banco']);
    $sql->bindValue(":tipo", $tipo);
    $sql->bindValue(":valor", $valor);

    $sql->execute();

    if($tipo == '0'){
        // Deposito

        $sql = $pdo->prepare("UPDATE contas SET saldo = saldo + :valor WHERE id = :id");
        $sql->bindValue(":id", $_SESSION['banco']);
        $sql->bindValue(":valor", $valor);
        $sql->execute();
    }else{
        // Retirada

        $sql = $pdo->prepare("UPDATE contas SET saldo = saldo - :valor WHERE id = :id");
        $sql->bindValue(":id", $_SESSION['banco']);
        $sql->bindValue(":valor", $valor);
        $sql->execute();
    }

    header("Location: index.php");
    exit;
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
    .container{
        margin-top: 150px;
    }
</style>
<body>
<div class="container">
    <form method="post">
        Tipo de transação: <br>
        <select class="custom-select mr-sm-2" name="tipo">
            <option value="0">Depósito</option>
            <option value="1">Retirada</option>
        </select><br><br>
        Valor: <br>
        <input class="form-control" type="text" name="valor" pattern="[0-9.,]{1,}"><br><br>

        <input class="btn btn-primary" type="submit" value="Adicionar">
    </form>
</div>

</body>
</html>

