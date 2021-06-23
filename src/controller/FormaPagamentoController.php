<?php

require_once '../../model/FormaPagamento.php';
require_once '../../model/Database.php';

class FormaPagamentoController extends FormaPagamento
{
    protected $tabela = 'formaPagamento';

    public function __construct()
    {
    }

    public function findOne($idformapagamento)
    {
        $query = "SELECT * FROM $this->tabela WHERE idformapagamento = :idformapagamento";
        $stm = Database::prepare($query);
        $stm->bindParam(':idformapagamento', $idformapagamento, PDO::PARAM_INT);
        $stm->execute();

        foreach ($stm->fetchAll() as $obj) {
            $formaPagamento = new FormaPagamento(null, null, null);
            $formaPagamento->setIdformapagamento($obj->idformapagamento);
            $formaPagamento->setCondicao($obj->condicao);
            $formaPagamento->setForma($obj->forma);
        }
        return $formaPagamento;  
    }

    public function findAll()
    {
        $query = "SELECT * FROM $this->tabela";
        $stm = Database::prepare($query);
        $stm->execute();
        $formaPagamento = array();

        foreach ($stm->fetchAll() as $obj) {
            array_push(
                $formaPagamento,
                new FormaPagamento($obj->idformapagamento, $obj->condicao, $obj->forma)
            );
        }
        return $formaPagamento;
    }
}
