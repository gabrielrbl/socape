<?php
require_once __DIR__ . '/../../controller/SessaoController.php';
Sessao::verificaLogado();

require_once __DIR__ . '/../../controller/ItensEntradaController.php';
$itensEntrada = new ItensEntradaController();

require_once __DIR__ . '/../../controller/EntradasController.php';
$entradas = new EntradasController();

require_once __DIR__ . '/../../controller/FornecedoresController.php';
$fornecedores = new FornecedoresController();

require_once __DIR__ . '/../../controller/ProdutosController.php';
$produtos = new ProdutosController();

?>
<!doctype html>
<html class="no-js" lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SOCAPE | Entrada</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link href="./../../../public/css/estilos.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <main class="container-fluid bg-light min-vh-100 text-dark">
        <section class="container py-3">
            <div class="row align-items-center d-flex">
                <div class="col-2 col-md-2 col-sm-2"></div>
                <div class="col-8 col-md-8 col-sm-8 text-center">
                    <span class="display-6">ENTRADAS</span>
                </div>
            </div>
        </section>

        <?php
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == 1) echo '<script>alert("Informe o fornecedor!");</script>';
            if ($_GET['msg'] == 2) echo '<script>alert("Entrada finalizada!");</script>';
        }
        ?>
        <section class="d-flex justify-content-center">
            <form id="realizarEntrada" method="POST" action="./realizarEntrada.php">
                <div class="row align-items-end mb-3 d-flex">
                    <div class="col-12 col-md-12 col-sm-12 me-auto mb-3">
                        <label for="barraPesquisa" class="form-label black-text">FORNECEDOR</label>
                        <input type="text" placeholder="FORNECEDOR" class="form-control" id="barraPesquisa" aria-describedby="fornecedorHelp">
                        <input id="idfornecedor" name="idfornecedor" type="hidden" required>
                        <div id="fornecedorHelp" class="form-text">Digite o nome do fornecedor e selecione-o na lista.</div>
                    </div>
                    <div class="col-12 col-md-12 col-sm-12 ms-auto d-flex align-items-end">
                        <button type="submit" class="btn btn-primary ms-auto">DAR ENTRADA</button>
                    </div>
                </div>
            </form>
        </section>

        <section class="container-fluid text-start mb-5">
            <div class="table-responsive-lg">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">FORNECEDOR</th>
                            <th scope="col">DATA</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">ITENS</th>
                            <th scope="col">VALOR TOTAL</th>
                            <th scope="col">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entradas->findAll() as $obj) { ?>
                            <tr>
                                <td><?= $obj->getIdentrada(); ?></td>
                                <td><?= $fornecedores->findOne($obj->getIdfornecedor())->getNome(); ?></td>
                                <td><?= strftime('%d de %b de %Y', strtotime($obj->getDataCompra())); ?></td>
                                <td><?= $obj->getStatus() == 0 ? 'EM ANDAMENTO' : 'FINALIZADA'; ?></td>
                                <td><?= $itensEntrada->countItensByIdEntrada($obj->getIdentrada()); ?></td>
                                <td>R$<?= $obj->getValortotalnota(); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <?php if ($obj->getStatus() == 0) { ?>
                                            <a class="btn btn-danger" href="itensEntrada.php?identrada=<?= $obj->getIdentrada(); ?>">FINALIZAR</a>
                                        <?php } else { ?>
                                            <a class="btn btn-primary" href="itensEntrada.php?identrada=<?= $obj->getIdentrada(); ?>">VISUALIZAR</a>
                                        <?php } ?>
                                        <button class="btn btn-dark" onclick="deletar('<?= $obj->getIdentrada() ?>', '<?= $fornecedores->findOne($obj->getIdfornecedor())->getNome(); ?>')">APAGAR</button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script type="text/javascript">
        $(document).ready(function() {
            $.getJSON('./retornaFornecedor.php', function(data) {
                var fornecedor = [];

                $(data).each(function(key, value) {
                    fornecedor.push({
                        label: value.nome,
                        value: value.idfornecedor
                    });
                });

                $('#barraPesquisa').autocomplete({
                    source: fornecedor,
                    minLength: 3,
                    select: (event, ui) => {
                        $("#barraPesquisa").val(ui.item.label);
                        $("#idfornecedor").val(ui.item.value);

                        return false;
                    }
                });
            });

            $("#realizarEntrada").on("click", "button[type=submit]", function(e) {
                e.preventDefault();

                if ($("#idfornecedor").val() == "") {
                    alert("Informe o fornecedor!");

                    return false;
                } else {
                    $("#realizarEntrada").submit();
                    $("#realizarEntrada button[type=submit]").prop("disabled", true);
                    $("#realizarEntrada button[type=submit]").val("DANDO ENTRADA...");
                }
            });
        });

        function deletar(id, nome) {
            if (confirm("Deseja realmente excluir a entrada do fornecedor " + nome + "?")) {
                $.ajax({
                    url: '../apagar/entrada.php',
                    type: "POST",
                    data: {
                        id
                    },
                    success: (res) => {
                        if (res["status"]) {
                            alert("Entrada excluída com sucesso!");
                            window.location.href = './entrada.php';
                        } else {
                            alert(res["msg"]);
                        }
                    }
                });
                return false;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>

</html>