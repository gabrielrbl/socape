<?php
require_once __DIR__ . '/../../controller/SessaoController.php';
Sessao::verificaLogado();

require_once __DIR__ . '/../../model/Database.php';

$query = "SELECT * FROM fornecedor";
$stm = Database::prepare($query);
$stm->execute();

echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
