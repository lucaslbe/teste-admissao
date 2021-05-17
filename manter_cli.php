<?php 
  session_start();
if (isset($_SESSION['errors_op'])){?>
    <div class="form-errors">
      <p><?php echo $_SESSION['errors_op']?></p>
    </div>
<?php } ?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <title>ATM - Manter Clientes</title>
        <meta name="description" content="ATM-Manter-Clientes" />
        <link rel="stylesheet" href="style.css" />
    </head>

<header>
  <nav>
    <ul id="nav">
      <li><a href="index.php">Home</a></li>
      <li><a href="inserir_op.php">Nova Operação</a></li>
      <li><a id="cadastrar_usuario" href="cadastrar_usuario.php">Cadastrar Usuário</a></li>
      <li><p class="logout"><a id="exit" href="#">Encerrar Sessão</a></p></li>  
    </ul>
  </nav>
</header>
<div class="container" >
  <div class="content">      
      <div id="manter_cli">
        <fieldset method="post" action="manter_cli_bk.php"> 
          <h1>Excluir ou Alterar Cliente</h1> 
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
            $sql=("select nome, endereco, dt_nasc, cpf, email, dt_insert, tipo
                   from usuario 
                   where tipo = 'C'");
            $result = $conn->query($sql);
              echo "<table id='table_pac'>";
                  echo "<tr>";
                      echo "<th>Nome</th>";
                      echo "<th>Endereço</th>";
                      echo "<th>Data de<br> Nascimento</th>";
                      echo "<th>e-mail</th>";
                      echo "<th>Data de Cadastro</th>";
                      echo "<th>Tipo de Acesso</th>";
                      echo "<th>CPF</th>";
                  echo "</tr>";                
              while($row = $result->fetch_assoc()) {
                echo "<tr>";
                  echo "<td>" . $row['nome'] . "</td>";
                  echo "<td>" . $row['endereco'] . "</td>";
                  echo "<td>" . $row['dt_nasc'] . "</td>";
                  echo "<td>" . $row['email'] . "</td>"; 
                  echo "<td>" . $row['dt_insert'] . "</td>"; 
                  echo "<td>" . $row['tipo'] . "</td>";
                  echo "<td>" . $row['cpf'] . "</td>";
                  echo "</tr>";
                }
                echo "</table>";
              }
              $conn->close();
              ?>
        <input type='button' name='OK' class='ok' value='Remover'/>
        <input type='button' name='alterar' class='alterar' value='Alterar'/>
        </fieldset>
      </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
      // jQuery Document
      $(document).ready(function () {
          $("#exit").click(function () {
              var exit = confirm("Tem certeza que deseja encerrar a sessão?");
              if (exit == true) {
                  window.location = "connect.php?logout=true";
              }
          });
      });
      
      var linha_selecionada;

      $("#table_pac tr").click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');    
        //alert($("#table_pac .selected").html());
      });

      $('.ok').on('click', function(e){
        var value = $("#table_pac tr.selected td:last").html();
        if (value>0){
          value = $("#table_pac tr.selected td:first").html();
          var exit = confirm("Tem certeza que deseja excluir o cliente "+value+" ?");
            if (exit == true) {
              value = $("#table_pac tr.selected td:last").html();
              // alert(value);
              window.location = "connect.php?delete="+value;
            }
        }
        else alert("Selecione um cliente.");
      });
      
      $('.alterar').on('click', function(e){
        var value = $("#table_pac tr.selected td:last").html();
        if (value>0){
          // alert(value);
          window.location = "connect.php?update="+value;
        }
        else alert("Selecione um cliente.");
      });
    </script>
  </div>
</html> 