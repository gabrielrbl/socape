<?php
require_once __DIR__ . '/../../controller/SessaoController.php';
Sessao::verificaLogado();

require_once __DIR__ . '/../../controller/FornecedoresController.php';
$fornecedores = new FornecedoresController();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOCAPE | Cadastrar fornecedor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link href="./../../../public/css/estilos.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
</head>

<body>
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <section class="text-center container">
            <div class="row">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="display-6">CADASTRAR FORNECEDOR</h1>
                </div>
            </div>
        </section>
        <?php
        if ($_POST) {
            $data = $_POST;
            $fornecedor = new FornecedoresController();

            $err = FALSE;

            if (!$data['nome']) {
                echo
                '<script>
                 alert("Informe o nome do Fornecedor!");
                </script>';
                $err = TRUE;
            }
            if (!$data['endereco']) {
                echo
                '<script>
                 alert("Informe o endereço!");
                </script>';
                $err = TRUE;
            }
            if (!$data['telefone']) {
                echo
                '<script>
                 alert("Informe o telefone!");
                </script>';
                $err = TRUE;
            }
            if (!$data['cnpj']) {
                echo
                '<script>
                 alert("Informe o CNPJ do Fornecedor!");
                </script>';
                $err = TRUE;
            }

            $fornecedor->setNome($data['nome']);
            $fornecedor->setEndereco($data['endereco']);
            $fornecedor->setTelefone($data['telefone']);
            $fornecedor->setCnpj($data['cnpj']);

            if (!$err) {
                try {
                    $fornecedor->insert($fornecedor->getNome(), $fornecedor->getEndereco(), $fornecedor->getTelefone(), $fornecedor->getCnpj());
                    echo
                    '<script>
                        alert("Fornecedor cadastrado com sucesso!");
                        window.location.href = "../consulta/fornecedor.php";
                    </script>';
                } catch (PDOException $err) {
                    echo $err->getMessage();
                }
            }
        }
        ?>
    </div>
    <div class="py-5 bg-light">
            <section class="d-flex justify-content-center align-items-center text-dark">
            
                <form method="post" id="form">
                    
                    <div class="row mb-3">
                        
                        <label for="nome" class="form-label">NOME</label>
                        <input type="text" name="nome" id="nome" oninput="validaInput(this, false)" class="form-control" placeholder="NOME" autocomplete="off" required>
                    </div>
                    <div class="row mb-3">
                        <label for="endereco" class="form-label">ENDEREÇO</label>
                        <input type="text" name="endereco" id="endereco" oninput="validaInput(this, true)" class="form-control" placeholder="ENDEREÇO" autocomplete="off" required>
                    </div>
                    <div class="row mb-3">
                        <label for="telefone" class="form-label">TELEFONE</label>
                        <input type="text" name="telefone" id="telefone" oninput="mascara(this, 'tel')" class="form-control" placeholder="TELEFONE" autocomplete="off" required>
                    </div>
                    <div class="row mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text"  name="cnpj" id="cnpj"  oninput="mascara(this, 'cnpj')" class="form-control" placeholder="CNPJ" autocomplete="off" required>
                    </div>
                    <div class="text-end">
                        <input  type="button" class="btn btn-primary" onClick="this.form.submit(); this.disabled=true; this.value='CADASTRANDO…';" value="CADASTRAR">
                    </div>
                </form>
                    <div class="row-mb-3">
                        <img class="img-fluid w-100" src="./../../../public/imagens/caminhão.png">
                    </div>
               
            </section>
        </div>
    <script>
        function deletar(id, nome) {
            if (confirm("Deseja realmente excluir o(a) fornecedor(a) " + nome + "?")) {
                $.ajax({
                    url: '../apagar/fornecedor.php',
                    type: "POST",
                    data: {
                        id
                    },
                    success: (res) => {
                        if (res["status"]) {
                            alert("Fornecedor excluído com sucesso!");
                            window.location.href = './fornecedor.php';
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
    <script src="./../../../public/js/validaInput.js"></script>
    <script src="./../../../public/js/mascara.js"></script>
</body>

</html>