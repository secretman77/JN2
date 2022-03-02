<?php
<!-- Gratidão à comunidade DEV!Desenvolvido por Marcelo Matos Machado -->
require 'config/banco.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}

if (!empty($_POST)) {

    $nomeErro = null;
    $telefoneErro = null;
    $cpfErro = null;
    $placaErro = null;

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $placa = $_POST['placa'];

    //Validação
    $validacao = true;
    if (empty($nome)) {
        $nomeErro = 'Insira seu nome!';
        $validacao = false;
    }

    if (empty($cpf)) {
        $cpfErro = 'Insira o número do seu CPF!';
        $validacao = false;
    }

    if (empty($telefone)) {
        $telefoneErro = 'Insira o número de seu telefone!';
        $validacao = false;
    }

    if (empty($placa)) {
        $placaErro = 'Insira a placa do veículo!';
        $validacao = false;
    }

    // ***atualizando dados***

    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE clientes set nome = ?, telefone = ?, cpf = ?, placa = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $telefone, $cpf, $placa, $id));
        Banco::desconectar();
        header("Location: index.php");
    }
} else {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM clientes where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $nome = $data['nome'];
    $telefone = $data['telefone'];
    $cpf = $data['cpf'];
    $placa = $data['placa'];
    Banco::desconectar();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- using new bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Dados do Cliente</title>
</head>

<body>
<div class="container">

    <div class="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> Dados do Cliente </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="update.php?id=<?php echo $id ?>" method="post">

                    <div class="control-group <?php echo !empty($nomeErro) ? 'error' : ''; ?>">
                        <label class="control-label">Nome</label>
                        <div class="controls">
                            <input name="nome" class="form-control" size="60" type="text" placeholder="Nome"
                                   value="<?php echo !empty($nome) ? $nome : ''; ?>">
                            <?php if (!empty($nomeErro)): ?>
                                <span class="text-danger"><?php echo $nomeErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>


                    <div class="control-group <?php echo !empty($telefoneErro) ? 'error' : ''; ?>">
                        <label class="control-label">Telefone</label>
                        <div class="controls">
                            <input name="telefone" class="form-control" size="45" type="text" placeholder="Telefone"
                                   value="<?php echo !empty($telefone) ? $telefone : ''; ?>">
                            <?php if (!empty($telefoneErro)): ?>
                                <span class="text-danger"><?php echo $telefoneErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($cpfErro) ? 'error' : ''; ?>">
                        <label class="control-label">CPF</label>
                        <div class="controls">
                            <input name="cpf" class="form-control" size="45" type="text" placeholder="Seu CPF"
                                   value="<?php echo !empty($cpf) ? $cpf : ''; ?>">
                            <?php if (!empty($cpfErro)): ?>
                                <span class="text-danger"><?php echo $cpfErro; ?></span>
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

                    <br/>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Atualizar Dados</button>
                        <a href="index.php" type="btn" class="btn btn-default">Retornar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<!-- Desenvolvido por Marcelo Matos Machado -->
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
