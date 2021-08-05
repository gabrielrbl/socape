<?php

require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../model/Database.php';

class ProdutosController extends Produto
{
    protected $tabela = 'produto';

    public function __construct()
    {
    }

    public function findOne($idproduto)
    {
        $query = "SELECT * FROM $this->tabela WHERE idproduto = :idproduto";
        $stm = Database::prepare($query);
        $stm->bindParam(':idproduto', $idproduto, PDO::PARAM_INT);
        $stm->execute();

        foreach ($stm->fetchAll() as $obj) {
            $produto = new Produto(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
            $produto->setIdproduto($obj->idproduto);
            $produto->setIdmotor($obj->idmotor);
            $produto->setIdcarro($obj->idcarro);
            $produto->setIdvalvulas($obj->idvalvulas);
            $produto->setIdfabricacao($obj->idfabricacao);
            $produto->setIdcategoria($obj->idcategoria);
            $produto->setIdmarca($obj->idmarca);
            $produto->setIcms($obj->icms);
            $produto->setIpi($obj->ipi);
            $produto->setFrete($obj->frete);
            $produto->setValornafabrica($obj->valornafabrica);
            $produto->setValordecompra($obj->valordecompra);
            $produto->setLucro($obj->lucro);
            $produto->setValorvenda($obj->valorvenda);
            $produto->setDesconto($obj->desconto);
            $produto->setQuantidade($obj->quantidade);
            $produto->setUnidade($obj->unidade);
            $produto->setIdlocalizacao($obj->idlocalizacao);
            $produto->setReferencia($obj->referencia);
        }
        return $produto;
    }

    public function findAll()
    {
        $query = "SELECT * FROM $this->tabela ORDER BY idproduto";
        $stm = Database::prepare($query);
        $stm->execute();
        $produtos = array();

        foreach ($stm->fetchAll() as $obj) {
            array_push(
                $produtos,
                new Produto(
                    $obj->idproduto,
                    $obj->idmotor,
                    $obj->idcarro,
                    $obj->idvalvulas,
                    $obj->idfabricacao,
                    $obj->idcategoria,
                    $obj->idmarca,
                    $obj->icms,
                    $obj->ipi,
                    $obj->frete,
                    $obj->valornafabrica,
                    $obj->valordecompra,
                    $obj->lucro,
                    $obj->valorvenda,
                    $obj->desconto,
                    $obj->quantidade,
                    $obj->unidade,
                    $obj->idlocalizacao,
                    $obj->referencia
                )
            );
        }
        return $produtos;
    }

    public function findWithFilter($params)
    {
        $query = "SELECT * FROM $this->tabela ORDER BY idproduto";
        $stm = Database::prepare($query);
        $stm->execute();
        $produtos = array();

        foreach ($stm->fetchAll() as $obj) {
            array_push(
                $produtos,
                new Produto(
                    $obj->idproduto,
                    $obj->idmotor,
                    $obj->idcarro,
                    $obj->idvalvulas,
                    $obj->idfabricacao,
                    $obj->idcategoria,
                    $obj->idmarca,
                    $obj->icms,
                    $obj->ipi,
                    $obj->frete,
                    $obj->valornafabrica,
                    $obj->valordecompra,
                    $obj->lucro,
                    $obj->valorvenda,
                    $obj->desconto,
                    $obj->quantidade,
                    $obj->unidade,
                    $obj->idlocalizacao,
                    $obj->referencia
                )
            );
        }
        return $produtos;
    }

    public function insert($idmotor, $idcarro, $idvalvulas, $idfabricacao, $idcategoria, $idmarca, $icms, $ipi, $frete, $valornafabrica, $valordecompra, $lucro, $valorvenda, $desconto, $quantidade, $unidade, $idlocalizacao, $referencia)
    {
        $query = "INSERT INTO $this->tabela (idmotor, idcarro, idvalvulas, idfabricacao, idcategoria, idmarca, icms, ipi, frete, 
        valornafabrica, valordecompra, lucro, valorvenda, desconto, quantidade, unidade, idlocalizacao, referencia)
        VALUES (:idmotor, :idcarro, :idvalvulas, :idfabricacao, :idcategoria, :idmarca, :icms, :ipi, :frete, :valornafabrica, 
        :valordecompra, :lucro, :valorvenda, :desconto, :quantidade, :unidade, :idlocalizacao, :referencia)";
        $stm = Database::prepare($query);
        $stm->bindParam(':idmotor', $idmotor);
        $stm->bindParam(':idcarro', $idcarro);
        $stm->bindParam(':idvalvulas', $idvalvulas);
        $stm->bindParam(':idfabricacao', $idfabricacao);
        $stm->bindParam(':idcategoria', $idcategoria);
        $stm->bindParam(':idmarca', $idmarca);
        $stm->bindParam(':icms', $icms);
        $stm->bindParam(':ipi', $ipi);
        $stm->bindParam(':frete', $frete);
        $stm->bindParam(':valornafabrica', $valornafabrica);
        $stm->bindParam(':valordecompra', $valordecompra);
        $stm->bindParam(':lucro', $lucro);
        $stm->bindParam(':valorvenda', $valorvenda);
        $stm->bindParam(':desconto', $desconto);
        $stm->bindParam(':quantidade', $quantidade);
        $stm->bindParam(':unidade', $unidade);
        $stm->bindParam(':idlocalizacao', $idlocalizacao);
        $stm->bindParam(':referencia', $referencia);
        return $stm->execute();
    }

    public function update($idproduto, $icms, $ipi, $frete, $valornafabrica, $valordecompra, $lucro, $valorvenda, $desconto, $quantidade, $unidade, $referencia)
    {
        $query = "UPDATE $this->tabela SET  icms = :icms, ipi = :ipi, frete = :frete, valornafabrica = :valornafabrica, valordecompra = :valordecompra, 
        lucro = :lucro, valorvenda = :valorvenda, desconto = :desconto, quantidade = :quantidade, unidade = :unidade, referencia = :referencia WHERE idproduto = :idproduto";
        $stm = Database::prepare($query);
        $stm->bindParam(':idproduto', $idproduto, PDO::PARAM_INT);
        $stm->bindValue(':icms', $icms);
        $stm->bindValue(':ipi', $ipi);
        $stm->bindValue(':frete', $frete);
        $stm->bindValue(':valornafabrica', $valornafabrica);
        $stm->bindValue(':valordecompra', $valordecompra);
        $stm->bindValue(':lucro', $lucro);
        $stm->bindValue(':valorvenda', $valorvenda);
        $stm->bindValue(':desconto', $desconto);
        $stm->bindValue(':quantidade', $quantidade);
        $stm->bindValue(':unidade', $unidade);
        $stm->bindValue(':referencia', $referencia);
        return $stm->execute();
    }

    public function delete($idproduto)
    {
        $query = "DELETE FROM $this->tabela WHERE idproduto = :idproduto";
        $stm = Database::prepare($query);
        $stm->bindParam(':idproduto', $idproduto, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function findBestSellers()
    {
        $query = "SELECT * FROM PRODUTOSMAISVENDIDOS(" . date('m') . ")";
        $stm = Database::prepare($query);
        $stm->execute();
        $produtos = array();

        foreach ($stm->fetchAll() as $obj) {
            array_push(
                $produtos,
                new Produto(
                    $obj->idproduto,
                    $obj->idmotor,
                    $obj->idcarro,
                    $obj->idvalvulas,
                    $obj->idfabricacao,
                    $obj->idcategoria,
                    $obj->idmarca,
                    $obj->icms,
                    $obj->ipi,
                    $obj->frete,
                    $obj->valornafabrica,
                    $obj->valordecompra,
                    $obj->lucro,
                    $obj->valorvenda,
                    $obj->desconto,
                    $obj->quantidade,
                    $obj->unidade,
                    $obj->idlocalizacao,
                    $obj->referencia
                )
            );
        }
        return $produtos;
    }
}
