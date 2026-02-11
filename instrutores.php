<?php
class instrutores {
    private $conn;
    private $table_name = "instrutores";

    public $id;
    public $nome_instrutor;
    public $data_nasc;
    public $cpf;
    public $email;
    

    public function __construct($db) {
        $this->conn = $db;
    }
}
?>