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
        <title>ATM - Inserir Operação</title>
        <meta name="description" content="ATM-login" />
        <link rel="stylesheet" href="stylelogin.css" />
    </head>

<header>
  <nav>
    <ul id="nav">
      <li><a href="index.php">Home</a></li>
      <li id="cadastrar_usuario"><a href="cadastrar_usuario.php">Cadastrar Usuário</a></li>
      <li id="manter_cli"><a href="manter_cli.php">Manter Clientes</a></li>
      <li><p class="logout"><a id="exit" href="#">Encerrar Sessão</a></p></li>
    </ul>
  </nav>
</header>
<div class="container" >
  <div class="content">      
      <!---------form para criar operação----------->
      <div id="nova_op">
        <form id="form_criar_op" method="post" action="notas.php"> 
          <h1>Nova Operação</h1> 
          <p> 
            <h2><label id="label_valor" for="valor_op">Valor</label></h2>
            <i><label id="label_reais" for="valor_op">R$</label></i>
            <input id="valor_op" name="valor_op" max="5000" required="required" type="money" placeholder="Ex.:110"/>
          </p>
          <p class="checkbox"> 
          <h3><label> Preferência de notas </label></h3>
            <label for="preferencia_10">10</label>
            <input id="preferencia_10" name="preferencia_10" type="checkbox" value="10" checked/> 
            
            <label for="preferencia_50">50</label>
            <input id="preferencia_50" name="preferencia_50" type="checkbox" value="50" checked/> 
            
            <label for="preferencia_100">100</label>
            <input id="preferencia_100" name="preferencia_100" type="checkbox" value="100" checked/> 
          </p> 
          <?php $_SESSION['errors_op'] = null;?>
          <p>
            <input type="submit" name="enter" class="button" id="enter" value="Entrar"/>
          </p>
        </form>
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
              document.getElementById("cadastrar_usuario").style.visibility="hidden";  
          }
          if (tipo_acesso === "Administrador"){
              document.getElementById("manter_cli").style.visibility="visible";  
              document.getElementById("cadastrar_usuario").style.visibility="visible";  
          }
      }
      hideBotao();
    </script>
  </div>
</html> 