<?php
session_start();

require_once 'config.php';

if(isset($_SESSION['banco']) && !empty($_SESSION['banco'])){
    $id = $_SESSION['banco'];

    $sql = $pdo->prepare("SELECT * FROM contas WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    if ($sql->rowCount()){
        $info = $sql->fetch();
    }else{
        header("Location: login.php");
        exit;
    }
}else{
    header("Location: login.php");
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
    <title>Caixa Eletrônico</title>
</head>
<style>
    #banco{
        padding: 20px;
    }
</style>
<body>
    <div class="container" id="banco">
        <h1>Banco XYZ</h1>
        Titular: <?php echo $info['titular']; ?><br>
        Agencia: <?php echo $info['agencia']; ?><br>
        Conta: <?php echo $info['conta']; ?><br>
        Saldo: <?php echo $info['saldo']; ?><br>
        <a href="sair.php">Sair</a>

        <hr>
        <h3>Movimentação/Extrato</h3>

        <a class="btn btn-primary" href="add-transacao.php">Saque/Deposito</a><br><br>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <?php
            $sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta = :id_conta");
            $sql->bindValue(":id_conta", $id);
            $sql->execute();

            if ($sql->rowCount()){
                foreach ($sql->fetchAll() as $item){
                    ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i', strtotime($item['data_operacao'])); ?></td>
                        <td>
                            <?php if ($item['tipo'] == '0'): ?>
                                <font color="green"> + R$ <?php echo $item['valor'] ?></font>
                            <?php else: ?>
                                <font color="red"> - R$ <?php echo $item['valor'] ?></font>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</body>
</html>