<?php 
  session_start();
if (isset($_SESSION['error_login'])){?>
    <div class="form-errors">
      <p><?php echo $_SESSION['error_login']?></p>
    </div>
<?php } ?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <title>ATM - Cadastrar Usuário</title>
        <meta name="description" content="ATM-login" />
        <link rel="stylesheet" href="stylelogin.css" />
    </head>
    <header>
      <nav>
          <ul id="nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="inserir_op.php">Nova Operação</a></li>
          <li id="manter_cli"><a href="manter_cli.php">Manter Clientes</a></li>
          <li><p class="logout"><a id="exit" href="#">Encerrar Sessão</a></p></li>
          </ul>
      </nav>
    </header>
<div class="container" >
    <a class="links" id="paracadastro"></a>
    <a class="links" id="paralogin"></a>
    
    <div class="content">      
      <!--FORMULÁRIO DE CADASTRO PELO ADMINISTRADOR-->
      <div id="cadastro">
        <form method="post" action="connect.php"> 
          <h1>Cadastro</h1> 
          <p class="letras-miudas">Utilize um e-mail com domínio @frente-tech.com para acessar como "Atendente".</footer>
          
          <p> 
            <label for="nome_cad">Nome</label>
            <input id="nome_cad" name="nome_cad" required="required" type="text" placeholder="Lucas Barbosa Estevão" />
          </p>
          
          <p> 
            <label for="email_cad">E-mail</label>
            <input id="email_cad" name="email_cad" required="required" type="email" placeholder="contato@frente-tech.com"/> 
          </p>
          
          <p> 
            <label for="senha_cad">Sua senha</label>
            <input id="senha_cad" name="senha_cad" required="required" type="password" placeholder="123456"/>
          </p>
          
          <p> 
            <label for="cpf_cad">CPF</label>
            <input id="cpf_cad" name="cpf_cad" required="required" type="text" placeholder="000.000.000-00" />
          </p>
          
          <p> 
            <label for="ende_cad">Endereço</label>
            <input id="ende_cad" name="ende_cad" required="required" type="text" placeholder="R. Exemplo, 000 - Vila Olímpia, São Paulo" />
          </p>

          <p> 
            <label for="date_nasc_cad">Data de Nascimento</label>
            <input id="date_nasc_cad" name="date_nasc_cad" required="required" type="date" placeholder="01/01/1995" />
          </p>

          <p> 
            <input type="submit" name="cadastrar" class="button" id="cadastrar" value="Cadastrar"/>
          </p>
        </form>
      </div>

      <!--FORMULÁRIO DE UPDATE PELO ADMINISTRADOR-->
      <div id="form_update">
        <form method="post" action="connect.php"> 
          <h1>Alterar de dados de cliente</h1> 
          <p class="letras-miudas">Utilize um e-mail com domínio @frente-tech.com para acessar como "Atendente".</footer>
          
          <p> 
            <label for="nome_up">Nome</label>
            <input id="nome_up" name="nome_up" required="required" type="text" value="<?php echo $_SESSION['nome_up']?>" placeholder="Lucas Barbosa Estevão" />
          </p>
          
          <p> 
            <label for="email_up">E-mail</label>
            <input id="email_up" name="email_up" required="required" type="email" value="<?php echo $_SESSION['email_up']?>" placeholder="contato@frente-tech.com"/> 
          </p>
          
          <p> 
            <label for="cpf_up">CPF</label>
            <input id="cpf_up" name="cpf_up" required="required" type="text" value="<?php echo $_SESSION['cpf_up']?>" placeholder="000.000.000-00" />
          </p>
          
          <p> 
            <label for="ende_up">Endereço</label>
            <input id="ende_up" name="ende_up" required="required" type="text" value="<?php echo $_SESSION['endereco_up']?>" placeholder="R. Exemplo, 000 - Vila Olímpia, São Paulo" />
          </p>

          <p> 
            <label for="date_nasc_up">Data de Nascimento</label>
            <input id="date_nasc_up" name="date_nasc_up" required="required" type="date" value="<?php echo $_SESSION['dt_nasc_up']?>" placeholder="01/01/1995" />
          </p>

          <p> 
            <input type="submit" name="alterar" class="button" id="alterar" value="Alterar"/>
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
            var update = "<?php if (isset($_GET['update'])){ echo $_GET['update']; }
                                else { echo 0 ;} ?>";
              if (update>0){
                document.getElementById("cadastro").style.visibility="hidden";  
                document.getElementById("form_update").style.visibility="visible";  
              }
              else{
                document.getElementById("cadastro").style.visibility="visible";  
                document.getElementById("form_update").style.visibility="hidden";  
              }
            }
      hideBotao();
    </script>
  </div>
</html> 