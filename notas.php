<?php
session_start();

class Notas_Atm {

    private $bills = array();
    private $money_left;
    private $cash = array();

    function __construct($preferencia_op) {
        $this->bills = $preferencia_op;
        rsort($this->bills);
    }

    public function getBills($withdrawAmount) {
        $this->cash = array();
        $this->money_left = $withdrawAmount;
        while ($this->money_left > 0) {
            if ($this->money_left < min($this->bills)) {
                $_SESSION['errors_op'] = "Essa quantia não pode ser retirada com as notas disponíveis.";
                header("Location: inserir_op.php");
            }
            $bill = $this->configureBills();
            $this->cash[] = $bill;
            $this->money_left -= $bill;
        }
        return array_count_values($this->cash);
    }

    private function configureBills() {
        foreach ($this->bills as $bill) {
            $division = $this->money_left / $bill;
            $rest = $this->money_left % $bill;
            if ( ($division >= 1) && ( $rest > (min($this->bills)+1) || ($rest === min($this->bills)) || ($rest === 0) ) ) {
                return $bill;
            }
        } 
        return min($this->bills);
    }

}

function insere_tabelas($valor_op,$op_pai){    
    $set_preferencias = array();
    $pega_notas = array();

    if (isset($_POST['preferencia_10'])) {
        $set_preferencias[] = 10;    
    }
    if (isset($_POST['preferencia_50'])) {
        $set_preferencias[] = 50;
    }
    if (isset($_POST['preferencia_100'])) {
        $set_preferencias[] = 100;
    }
    if (!isset($_POST['preferencia_10']) and
        !isset($_POST['preferencia_50']) and 
        !isset($_POST['preferencia_100'])){
        $set_preferencias[] = 10;
        $set_preferencias[] = 50;
        $set_preferencias[] = 100;
    }
    $_SESSION['errors_op'] = "";

    $atm = new Notas_Atm($set_preferencias);

    $pega_notas = $atm->getBills($valor_op);

    $qtd10 = $pega_notas[10] ?? "0"; // pega a qtd de notas da face, se não encontrar retorna 0
    $qtd50 = $pega_notas[50] ?? "0";
    $qtd100 = $pega_notas[100] ?? "0";

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
        // INSERE OPERAÇÃO
        if ($op_pai != null){
            $sql = "INSERT INTO operacao(cli_cpf,valor,op_pai,status_op)
            values ( '$_SESSION[cpf]'
                    ,'$valor_op'
                    ,'$op_pai'
                    ,'Aberto'
                )";
        }
        else {
            $sql = "INSERT INTO operacao(cli_cpf,valor,status_op)
            values ( '$_SESSION[cpf]'
                    ,'$valor_op'
                    ,'Aberto'
                )";
        }
        
        if($conn->query($sql)){
            $_SESSION['errors_op'] = "Operação criada com sucesso!.";
        }
        else {
            echo "Erro: ".$sql."<br>".$conn->error;
        }
        
        
        $sql=("SELECT max(op_id) op_id
                FROM operacao
                WHERE cli_cpf='$_SESSION[cpf]'");
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                $_SESSION['op_id'] = $row["op_id"];
            }   
        

        // INSERE PACOTE de 10
        if ($qtd10 > 0){ // verificação se houve alguma nota com a face
            $sql = "INSERT INTO pacote(vlr_nota,qtd,op_id,dt_aber,dt_fim)  
                    values ( 10
                            ,'$qtd10'
                            ,'$_SESSION[op_id]'
                            , sysdate()
                            , null)";
            if($conn->query($sql)){
                $_SESSION['errors_op'] = $_SESSION['errors_op']."<br> - Pacote de notas de 10 criado com sucesso!.";
            }
            else {
                echo "Erro: ".$sql."<br>".$conn->error;
            }
        }   
        
        // INSERE PACOTE de 50
        if ($qtd50 > 0){
            $sql = "INSERT INTO pacote(vlr_nota,qtd,op_id,dt_aber,dt_fim)  
                    values ( 50
                            ,'$qtd50'
                            ,'$_SESSION[op_id]'
                            , sysdate()
                            , null)";
            if($conn->query($sql)){
                $_SESSION['errors_op'] = $_SESSION['errors_op']."<br> - Pacote de notas de 50 criado com sucesso!";
            }
            else {
                echo "Erro: ".$sql."<br>".$conn->error;
            }
        }   
        
        // INSERE PACOTE de 100
        if ($qtd100 > 0){
            $sql = "INSERT INTO pacote(vlr_nota,qtd,op_id,dt_aber,dt_fim)  
                    values ( 100
                            ,'$qtd100'
                            ,'$_SESSION[op_id]'
                            , sysdate()
                            , null)";
            if($conn->query($sql)){
                $_SESSION['errors_op'] = $_SESSION['errors_op']."<br> - Pacote de notas de 100 criado com sucesso!";
            }
            else {
                echo "Erro: ".$sql."<br>".$conn->error;
            }
        }   
        $sql = "UPDATE operacao set status_op = 'Reservada' where op_id = '$_SESSION[op_id]'";
        if($conn->query($sql)){
            $_SESSION['errors_op'] = $_SESSION['errors_op']."<br> - Status de Operação alterado para 'Reservada'.";
        }
        else {
            echo "Erro: ".$sql."<br>".$conn->error;
        }
        $conn->close();
    }
}

$valor_restante = 0;

if (($_POST['valor_op']) > 5000){ //limite de 5000 por operação
    $valor_restante = $_POST['valor_op'] - 5000; 
    $_POST['valor_op'] = 5000;
    insere_tabelas($_POST['valor_op'], null);
    insere_tabelas($valor_restante, $_SESSION['op_id']);
}
else {
    insere_tabelas($_POST['valor_op'], null);
    $valor_restante = 0;
}
// $_SESSION['errors_op'] = "FORA-FIM".$_POST['valor_op']."<br>".$valor_restante;
header("Location: inserir_op.php"); //Redireciona o usuario

?>