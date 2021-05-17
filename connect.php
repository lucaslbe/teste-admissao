<?php
session_start();

if(isset($_GET['logout'])){ //LOGOUT   
    session_destroy();
    header("Location: login.php#paralogin"); //Redireciona o usuario
}

if(isset($_GET['update'])){  //dá select nos dados do cliente para exibir na tela de cadastro  
    $cpf_update = $_GET['update'];
    echo $cpf_update;
    // criar conexão
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
        $sql=("SELECT email,nome,senha,cpf,endereco,dt_nasc,dt_insert,tipo
                       FROM usuario
                       WHERE cpf=$cpf_update");
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                   $_SESSION['email_up'] = $row["email"];
                   $_SESSION['nome_up'] = $row["nome"];
                   $_SESSION['cpf_up'] = $row["cpf"];
                   $_SESSION['endereco_up'] = $row["endereco"];
                   $_SESSION['tipo_up'] = $row["tipo"];
                   $_SESSION['dt_nasc_up'] = $row["dt_nasc"];
                   $_SESSION['dt_insert_up'] = $row["dt_insert"];
                   $_SESSION['tipo_up'] = $row["tipo"];
                }
        
        if($conn->query($sql)){
            header("Location: cadastrar_usuario.php?update=".$cpf_update); //Redireciona o usuario
        }
        else {
            echo "Erro: ".$sql."<br>".$conn->error;
        }
        $conn->close();
    }
}

if(isset($_GET['delete'])){    //DELETA USUARIO NO BD
    $cpf_delete = $_GET['delete'];
    echo $cpf_delete;
        
    // criar conexão
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
        $sql = "DELETE FROM usuario WHERE cpf=".$cpf_delete;
        
        if($conn->query($sql)){
            header("Location: manter_cli.php"); //Redireciona o usuario
        }
        else {
            echo "Erro: ".$sql."<br>".$conn->error;
        }
        $conn->close();
    }
    // header("Location: login.php#paralogin"); //Redireciona o usuario
}

if(isset($_POST['enter'])){ //connect para logar
    //fazer login
    if($_POST['email'] != ""){
        // criar conexão
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
            $sql=("SELECT 1 FROM usuario
                   WHERE email ='$_POST[email]' 
                     and senha = '$_POST[senha_login]'");
            
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
              // retorna dados por linha
                $sql=("SELECT email,nome,senha,cpf,endereco,dt_nasc,dt_insert,tipo
                       FROM usuario
                       WHERE email='$_POST[email]'");
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                   $_SESSION['email'] = $row["email"];
                   $_SESSION['nome'] = $row["nome"];
                   $_SESSION['cpf'] = $row["cpf"];
                   $_SESSION['endereco'] = $row["endereco"];
                   $_SESSION['tipo'] = $row["tipo"];
                   $_SESSION['errors'] = NULL;
                }
            } else {
                $_SESSION['error_login'] = "Seu e-mail ou senha está incorreto.";
                header("Location: login.php#paralogin");
            }
                        
            if($conn->query($sql)){
                header("Location: index.php");
            }
            else {
                echo "Erro: ".$sql."<br>".$conn->error;
            }
            $conn->close();
        }
    }
    else{
        echo '<span class="error">Por favor, preencha o campo de e-mail.</span>';
    }
    if (!isset($_SESSION['error_login'])){
        header("Location: index.php");
    }
}

if(isset($_POST['cadastrar'])){ //connect para cadastrar usuario

    $_SESSION['email_cad'] = $_POST['email_cad'];
    $_SESSION['nome_cad'] = $_POST['nome_cad'];
    $_SESSION['senha_cad'] = $_POST['senha_cad'];
    $_SESSION['cpf_cad'] = $_POST['cpf_cad'];
    $_SESSION['ende_cad'] = $_POST['ende_cad'];
    $_SESSION['date_nasc_cad'] = $_POST['date_nasc_cad'];
    
    // criar conexão
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
        if(str_contains($_SESSION['email_cad'],"frente-tech")){
            $_SESSION['tipo_cad'] = "A"; // Se o usuário tiver um e-mail com o domínio frente-tech, ele tem permissão de administrador
        }
        else{
            $_SESSION['tipo_cad'] = "C"; // Caso contrário, o usuário será cadastrado como cliente.
        }
        
        $sql = "INSERT INTO usuario(email,nome,senha,cpf,endereco,dt_nasc,dt_insert,tipo) 
                values ('$_SESSION[email_cad]'
                        ,'$_SESSION[nome_cad]'
                        ,'$_SESSION[senha_cad]'
                        ,'$_SESSION[cpf_cad]'
                        ,'$_SESSION[ende_cad]'
                        ,'$_SESSION[date_nasc_cad]' 
                        ,sysdate()
                        ,'$_SESSION[tipo_cad]')";
        if($conn->query($sql)){
            header("Location: login.php#paralogin"); //Redireciona o usuario
        }
        else {
            echo "Erro: ".$sql."<br>".$conn->error;
        }
        $conn->close();
    }
}

if(isset($_POST['alterar'])){ //connect para cadastrar usuario

    // criar conexão
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
        if(str_contains($_POST['email_up'],"frente-tech")){
            $_POST['tipo_cad'] = "A"; // Se o usuário tiver um e-mail com o domínio frente-tech, ele tem permissão de administrador
        }
        else{
            $_POST['tipo_cad'] = "C"; // Caso contrário, o usuário será cadastrado como cliente.
        }
        
        $sql = "update usuario set email='$_POST[email_up]'
                                   ,nome='$_POST[nome_up]'
                                   ,cpf='$_POST[cpf_up]'
                                   ,endereco='$_POST[ende_up]'
                                   ,dt_nasc='$_POST[date_nasc_up]' 
                                   ,tipo = '$_POST[tipo_cad]'
                where cpf = $_SESSION[cpf_up]";

        if($conn->query($sql)){
            header("Location: manter_cli.php"); //Redireciona o usuario
        }
        else {
            echo "Erro: ".$sql."<br>".$conn->error;
        }
        $conn->close();
    }
}
?>