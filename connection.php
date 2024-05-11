<?php

$conexao = new mysqli("localhost", "root", "", "docit");

if ($conexao->connect_error) {
    die("Erro ao conectar ao Banco de Dados: " . $conexao->connect_error);
}

?>