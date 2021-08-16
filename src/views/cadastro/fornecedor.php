<?php
session_start();

if(!$_SESSION['logado']) header('Location: ./../../../login.php');

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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="./../../../public/css/estilos.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
</head>

<body>
    <img class="img-fluid w-100" src="./public/imagens/titulo.png">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navegacao" aria-controls="navegacao" aria-expanded="false" aria-label="Alterar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navegacao">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../../../index.php">INÍCIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../views/venda/venda.php">VENDER</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../views/entrada/entrada.php">DAR ENTRADA</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="consultar" role="button" data-bs-toggle="dropdown" aria-expanded="false">CONSULTAR</a>
                        <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="consultar">
                            <li><a class="dropdown-item" href="../../views/consulta/cliente.php">CLIENTE</a></li>
                            <li><a class="dropdown-item" href="../../views/consulta/fornecedor.php">FORNECEDOR</a></li>
                            <li><a class="dropdown-item" href="../../views/consulta/produto.php">PRODUTO</a></li>
                            <li><a class="dropdown-item" href="../../views/consulta/carro.php">CARRO</a></li>
                            <li><a class="dropdown-item" href="../../views/consulta/localizacao.php">LOCALIZAÇÃO</a></li>
                            <li><a class="dropdown-item" href="../../views/consulta/valvula.php">VÁLVULA</a></li>
                            <li><a class="dropdown-item" href="../../views/consulta/categoria.php">CATEGORIA</a></li>
                            <li><a class="dropdown-item" href="../../views/consulta/motor.php">MOTOR</a></li>
                            <li><a class="dropdown-item" href="../../views/consulta/anofabricacao.php">FABRICAÇÃO</a></li>
                            <li><a class="dropdown-item" href="../../views/consulta/marca.php">MARCA</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="perfil" role="button" data-bs-toggle="dropdown" aria-expanded="false">MINHA CONTA</a>
                        <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="perfil">
                            <li>
                                <h6 class="dropdown-header">Olá <?= $_SESSION['nome']; ?></h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../../views/usuario/perfil.php">PERFIL</a></li>
                            <li><a class="dropdown-item" href="../../../logout.php">SAIR</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="container">
        <h1>
            <span class="badge bg-light text-dark">CADASTRAR FORNECEDOR</span>
        </h1>

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

        <img id="imagemFornecedor" src="./../../../public/imagens/caminhão.png" align="right">
        <form style="margin-left: 25%" action="" method="post">
            <div class="mb-3">
                <label class="form-label">NOME</label>
                <input style="width: 130%" type="text" name="nome" class="form-control" placeholder="NOME" required>
            </div>
            <div class="mb-3">
                <label class="form-label">ENDEREÇO</label>
                <input style="width: 130%" type="text" name="endereco" class="form-control" placeholder="ENDEREÇO" required>
            </div>
            <div class="mb-3">
                <label class="form-label">TELEFONE</label>
                <input style="width: 130%" type="text" name="telefone" class="form-control" placeholder="TELEFONE" required>
            </div>
            <div class="mb-3">
                <label class="form-label">CNPJ</label>
                <input style="width: 130%" type="text" name="cnpj" class="form-control" placeholder="CNPJ" required>
            </div>

            <input  style="margin-left: 75% ;padding: 4px 15px 3px 15px;border-radius: 50px;" type="button" class="btn btn-primary" onClick="this.form.submit(); this.disabled=true; this.value='CADASTRANDO…';" value="CADASTRAR">
        </form>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>