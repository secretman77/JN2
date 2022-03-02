

<?php
require 'config/banco.php';

//***Erros de validação + condições para chamada post***

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeErro = null;
    $telefoneErro = null;
    $cpfErro = null;
    $placaErro = null;

    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
        if (!empty($_POST['nome'])) {
            $nome = $_POST['nome'];
        } else {
            $nomeErro = 'Insira seu nome!';
            $validacao = False;
        }


        if (!empty($_POST['telefone'])) {
            $telefone = $_POST['telefone'];
        } else {
            $telefoneErro = 'Insira o número de seu telefone!';
            $validacao = False;
        }


        if (!empty($_POST['cpf'])) {
            $cpf = $_POST['cpf'];
            if (!filter_var($_POST['cpf'])) {
                $cpfErro = 'Este CPF não é válido!';
                $validacao = False;
            }
        } else {
            $cpfErro = 'Insira o número do seu CPF!';
            $validacao = False;
        }


        if (!empty($_POST['placa'])) {
            $placa = $_POST['placa'];
        } else {
            $placaErro = 'Insira a placa do veículo!';
            $validacao = False;
        }
    }

//***Atualizar banco de dados***
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO clientes (nome, telefone, cpf, placa) VALUES(?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $telefone, $cpf, $placa));
        Banco::desconectar();
        header("Location: index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Folha de estilo CSS -->
    <title>Dados do Cliente</title>
</head>

<body>
<div class="container">
    <div clas="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well">Dados do Cliente</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="cliente.php" method="post">
                    <!-- Tratamento de Erros -->
                    <div class="control-group  <?php echo !empty($nomeErro) ? 'error ' : ''; ?>">
                        <label class="control-label">Nome</label>
                        <!-- Validação Dados de Entrada -->
                        <div class="controls">
                            <input size="60" class="form-control" name="nome" type="text" placeholder="Nome"
                                   value="<?php echo !empty($nome) ? $nome : ''; ?>">
                            <?php if (!empty($nomeErro)): ?>
                                <span class="text-danger"><?php echo $nomeErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($telefoneErro) ? 'error ' : ''; ?>">
                        <label class="control-label">Telefone</label>
                        <div class="controls">
                            <input size="40" class="form-control" name="telefone" type="text" placeholder="Telefone"
                                   value="<?php echo !empty($telefone) ? $telefone : ''; ?>">
                            <?php if (!empty($telefoneErro)): ?>
                                <span class="text-danger"><?php echo $telefoneErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php !empty($cpfErro) ? '$cpfErro ' : ''; ?>">
                        <label class="control-label">CPF</label>
                        <div class="controls">
                            <input size="45" class="form-control" name="cpf" type="text" placeholder="Seu CPF"
                                   value="<?php echo !empty($cpf) ? $cpf : ''; ?>">
                            <?php if (!empty($emailErro)): ?>
                                <span class="text-danger"><?php echo $emailErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php !empty($placaErro) ? 'echo($placaErro)' : ''; ?>">
                        <div class="controls">
                            <label class="control-label">Placa do Carro</label>
                            <div class="controls">
                                    <input size="45" class="form-control" name="placa" type="text" placeholder="Sua Placa"
                                    value="<?php echo !empty($placa) ? $placa : ''; ?>">
                                    <?php if (!empty($placaErro)): ?>
                                        <span class="text-danger"><?php echo $placaErro; ?></span>
                                    <?php endif; ?>
                            </div>
                    </div>
                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Inserir</button>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- JavaScript Atualizado -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>

