<?php

class DB extends PDO
{
    public function __construct()
    {
    $port = 'suaporta';
    $host = 'seuhost';
    $password = 'suasenha';
    $user = 'seuusuario';
    $dbname = 'seubanco';


    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";


    parent::__construct($dsn, $user, $password);


    $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function runQuery(string $sql, array $args): array
    {
        try{
            $stmt = $this->prepare($sql);
            $stmt->execute($args);
            return $stmt->FetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            var_dump($e->getMessage());
            return [];
        }
    }
}

function teste($db, $name){
    $teste = $db->runQuery("select * from $name limit 1;", []);
    return array_keys($teste[0]);
};

function snakeToCamelCase($string, $capitalizeFirstCharacter = false) 
{

    $str = str_replace('_', '', ucwords($string, '_'));

    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }

    return $str;
}

$db = new DB;
$arr = teste($db, $name);
foreach($arr as $colum){
    if (strpos($colum, '_')){
        $camelCase = snakeToCamelCase($colum);
        echo "'$camelCase'" .' => $this->' . $colum . ',' . PHP_EOL; 
    } else
    echo "'$colum'" .' => $this->' . $colum . ',' . PHP_EOL; 
}
