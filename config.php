<?php
try{
    $pdo = new PDO(
        "mysql:dbname=projeto_caixaeletronico;host=localhost",
        "root",
        ""
    );

}catch (PDOException $erro){
    echo "Erro: {$erro->getMessage()}";
}