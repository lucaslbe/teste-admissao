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
        <title>ATM - Login</title>
        <meta name="description" content="ATM-login" />
        <link rel="stylesheet" href="stylelogin.css" />
    </head>
<div class="container" >
    <a class="links" id="paracadastro"></a>
    <a class="links" id="paralogin"></a>
    
    <div class="content">      
      <!---------FORMULÁRIO DE LOGIN----------->
      <div id="login">
        <form method="post" action="connect.php"> 
          <h1>Login</h1> 
          <p> 
            <label for="email">E-mail</label>
            <input id="email" name="email" required="required" type="text" placeholder="contato@frente-tech.com"/>
          </p>
          
          <p> 
            <label for="senha_login">Senha</label>
            <input id="senha_login" name="senha_login" required="required" type="password" placeholder="1234xxx" /> 
          </p>
          
          <p> 
            <input type="submit" name="enter" class="button" id="enter" value="Entrar"/>
          </p>
          
          <p class="link">
            Ainda não tem conta?
            <a href="#paracadastro">Cadastre-se</a>
          </p>
        </form>
      </div>

      <!--FORMULÁRIO DE CADASTRO-->
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
          
          <p class="link">  
            Já tem conta?
          <a href="#paralogin"> Ir para Login </a>
        </form>
      </div>
    </div>
  </div>
</html> 