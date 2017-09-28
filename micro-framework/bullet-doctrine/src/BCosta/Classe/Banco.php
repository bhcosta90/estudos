<?php
namespace BCosta\Classe;

abstract class Banco{
    /**
    * @connect conexao;
    */
    protected static $_connection;

    protected $dados;
    /**
    * @instance instancia
    */
    private static $_instancia;

    private $printaSQL = false;

    protected function __conexao()
    {
        if(self::$_connection == null){
            self::$_connection = new \PDO( 'mysql:host=' . getenv('MYSQL_HOST') . ';port='.getenv('MYSQL_HOST').';dbname=' . getenv('MYSQL_DATABASE'), getenv('MYSQL_USER'), getenv('MYSQL_ROOT_PASSWORD') );
            self::$_connection->beginTransaction();
        }
        return self::$_connection;
    }

    public function limit(int $inteiro){
        $this->dados["limit"] = $inteiro;
        return $this;
    }

    public function offset(int $inteiro){
        $this->dados["offset"] = $inteiro;
        return $this;
    }

    private function gerarSQL(){
        $sql = $this->dados["sql"];
        if(isset($this->dados["variavel"]) && is_array($this->dados["variavel"])){
            $where_variavel = $this->dados["variavel"];
        }else{
            $where_variavel = [];
        }

        if(isset($this->dados["where"]) && is_array($this->dados["where"])){
            $sql .= " WHERE ";
            foreach($this->dados["where"] as $where){
                foreach($where["variavel"] as $k => $variavelWhere){
                    $where_variavel[$k] = $variavelWhere;
                }
                $sql .= "(".$where["sql"].") AND ";
            }
            $sql = substr($sql, 0, -4);
        }

        if(isset($this->dados["group"]) && is_array($this->dados["group"])){
            $sql .= " GROUP BY ";
            foreach($this->dados["group"] as $v){
                $sql .= "$v,";
            }
            $sql = substr($sql, 0, -1);
        }

        if(isset($this->dados["order"]) && is_array($this->dados["order"])){
            $sql .= " ORDER BY ";
            foreach($this->dados["order"] as $v){
                $sql .= "$v,";
            }
            $sql = substr($sql, 0, -1);
        }

        if(!empty($this->dados["limit"])){
            $sql .= " LIMIT ";
            if(!empty($this->dados["offset"])){
                $sql .= $this->dados["offset"].",";
            }
            $sql .= $this->dados["limit"];
        }

        return [
            "sql" => str_replace('  ',' ', $sql),
            "variavel" => $where_variavel,
        ];
    }

    public function getSQL(){
        $dados = $this->gerarSQL();
        $sql = $dados["sql"];

        print_r($dados["variavel"]);
        foreach($dados["variavel"] as $i => $v){
            $v = "'$v'";
            if(substr($i, 0, 6)==":campo" || substr($i, 0, 6)==":valor"){
                $sql = str_replace($i, $v, $sql);
            }
        }

        return $sql;
    }

    public function getArray(){
        $dados = $this->dados;
        return $dados;
    }

    public function execute(){
        $dados = $this->gerarSQL();
        $sql = $dados["sql"];

        $query = self::__conexao()->prepare($sql);
        $query->execute($dados["variavel"]);

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function persist(){
        try{
            $dados = $this->gerarSQL();
            $sql = $dados["sql"];

            $query = self::__conexao()->prepare($sql);
            $query->execute($dados["variavel"]);

            return intval(self::__conexao()->lastInsertId());
        }catch(\Exception $e){
            print 'error';exit;
        }
    }

    public function flush(){
        self::__conexao()->commit();
    }
}

?>
