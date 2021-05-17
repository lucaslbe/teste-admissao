<?php
session_start();
if ($_SESSION['tipo'] === 'C') {
    $_SESSION['tipo'] = "Cliente";
}
if ($_SESSION['tipo'] === 'A') {
    $_SESSION['tipo'] = "Administrador";
}
if(!isset($_SESSION['email'])){
    header("Location: login.php#paralogin");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <title>ATM - Home</title>
        <meta name="description" content="ATM" />
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <header>
            <nav>
                <ul id="nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="inserir_op.php">Nova Operação</a></li>
                    <li id="cadastrar_usuario"><a href="cadastrar_usuario.php">Cadastrar Usuário</a></li>
                    <li id="manter_cli"><a href="manter_cli.php">Manter Clientes</a></li>
                    <li><p class="logout"><a id="exit" href="#">Encerrar Sessão</a></p></li>
                </ul>
            </nav>
        </header>
        <div id="wrapper">
            <div id="menu">
                <fieldset>
                <h1>Bem vindo, </h1><br>
                <p class="welcome"><b><?php echo $_SESSION['nome']; ?></b></p>
                <p class="welcome"><i>e-mail</i>:  <?php echo $_SESSION['email'] ?> </p>
                <p class="welcome"><i>CPF</i>: <?php echo $_SESSION['cpf'] ?> </p>
                <p class="welcome"><i>Endereço</i>: <?php echo $_SESSION['endereco'] ?> </p>
                <p class="welcome"><i>Tipo de Acesso</i>: <?php echo $_SESSION['tipo'] ?> </p>
                </fieldset>
            </div>  
        
            <div id="lista_operacoes">
                <!-- SUAS OPERAÇÕES -->
                <fieldset>
                    <h3>Suas Operações</h3>
                    <?php  // BUSCA OPERAÇÕES NO BD  
                    $host = "localhost";
                    $dbusername = "root";
                    $dbpassword = "";
                    $dbname = "mysql";
                    
                    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
                    if (mysqli_connect_error()){
                        die('Connect Error('.mysqli_connect_errno().')');
                        mysqli_connect_error();
                        echo "ERRO1";
                    }
                    else {
                        $sql=("SELECT op_id,cli_cpf,valor,op_pai,status_op
                                FROM operacao
                                WHERE cli_cpf='$_SESSION[cpf]'
                                order by op_id");
                            
                        $result = $conn->query($sql);
                        echo "<table>";
                            echo "<tr>";
                                echo "<th>ID da <br>Operação</th>";
                                echo "<th>Valor da <br>Operação</th>";
                                echo "<th>ID da <br>OP Pai</th>";
                                echo "<th>Status da <br>OP</th>";
                            echo "</tr>";                
                        
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['op_id'] . "</td>";
                            echo "<td>R$" . $row['valor'] . "</td>";
                            echo "<td>" . $row['op_pai'] . "</td>";
                            echo "<td>" . $row['status_op'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    $conn->close();
                    ?>
                </fieldset>
            </div>
            <div id="lista_pacote">
                <!-- PACOTES -->
                <fieldset>
                    <h3>Pacotes</h3>
                    <?php  // BUSCA PACOTES NO BD  
                    $host = "localhost";
                    $dbusername = "root";
                    $dbpassword = "";
                    $dbname = "mysql";
                    
                    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
                    if (mysqli_connect_error()){
                        die('Connect Error('.mysqli_connect_errno().')');
                        mysqli_connect_error();
                        echo "ERRO1";
                    }
                    else {
                        $sql=("SELECT vlr_nota, op_id, qtd, dt_aber, nvl(dt_fim,' ') dt_fim
                                FROM pacote
                                order by op_id");
                            
                        $result = $conn->query($sql);
                        echo "<table>";
                            echo "<tr>";
                                echo "<th>Operação pai do<br>Pacote</th>";
                                echo "<th>Valor das Notas<br>Pacote</th>";
                                echo "<th>Quantidade de<br>Notas</th>";
                                echo "<th>Data de<br>Abertura</th>";
                                echo "<th>Data de<br>Fechamento</th>";
                            echo "</tr>";                
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . "<b>".$row['op_id'] . "</b></td>";
                            echo "<td>" . $row['vlr_nota'] . "</td>";
                            echo "<td>" . $row['qtd'] . "</td>";
                            echo "<td>" . $row['dt_aber'] . "</td>";
                            echo "<td>" . $row['dt_fim'] . "</td>"; 
                            echo "</tr>";
                            }
                    }
                    $conn->close();
                    ?>
                </fieldset>
            </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                $("#exit").click(function () {
                        var exit = confirm("Tem certeza que deseja encerrar a sessão?"||($("#acesso")));
                    if (exit == true) {
                        window.location = "connect.php?logout=true";
                    }
                });
            });
            function hideBotao(){  
            var tipo_acesso = "<?php echo $_SESSION['tipo'];?>";
                if (tipo_acesso === "Cliente"){
                    document.getElementById("manter_cli").style.visibility="hidden";  
                    document.getElementById("lista_pacote").style.visibility="hidden";  
                    document.getElementById("cadastrar_usuario").style.visibility="hidden";  
                }
                if (tipo_acesso === "Administrador"){
                    document.getElementById("manter_cli").style.visibility="visible";  
                    document.getElementById("lista_pacote").style.visibility="visible";  
                    document.getElementById("cadastrar_usuario").style.visibility="visible";  
                }
            }
            hideBotao();
        </script>
    </body>
</html>