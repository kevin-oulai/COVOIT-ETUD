<?php

include_once 'include.php';

$pdo = Bd::getInstance()->getConnexion();
$path = "data/backup";
$date = date("Y-m-d_H-i-s");
$filename = "backup_". $date.".sql";

$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE';";
$query = $pdo->prepare($query);
$query->execute();
$tables = $query->fetchAll();
file_put_contents($path."/".$filename, "SET FOREIGN_KEY_CHECKS=0;\n", FILE_APPEND);

// Suppression des tables
foreach ($tables as $key => $table){
    $content = "DROP TABLE IF EXISTS ". $table[0] . ";\n";
    file_put_contents($path."/".$filename, $content, FILE_APPEND);
}

// Creation des tables
foreach ($tables as $key => $table){
    $query = "SHOW CREATE TABLE ". $table[0];
    $query = $pdo->prepare($query);
    $query->execute();
    $create = $query->fetch();
    $content = $create[1].";\n";
    file_put_contents($path."/".$filename, $content, FILE_APPEND);
}

// Insertion des donnees
foreach ($tables as $key => $table){
    $query = "SELECT * FROM ". $table[0] . ";";
    $query = $pdo->prepare($query);
    $query->execute();
    $query->setFetchMode(PDO::FETCH_NUM);
    $datas = $query->fetchAll();

    $insert = "INSERT INTO " . $table[0] . " (";
    $query = "DESCRIBE ". $table[0] . ";";
    $query = $pdo->prepare($query);
    $query->execute();
    $query->setFetchMode(PDO::FETCH_NUM);
    $columns = $query->fetchAll();
    foreach ($columns as $key => $column){
        $insert .= "`" .$column[0]. "`";
        if ($key != array_key_last($columns)){
            $insert .= ", ";
        }
    }

    $insert .= ") VALUES \n";

    foreach ($datas as $keys => $data){
        $insert .= "(";
        foreach ($data as $key => $value){
            if(is_numeric($value)){
                $insert .= $value;
            }
            else{
                if($value){
                    $value = str_replace("'", "\'", $value);
                    $insert .= "'" . $value . "'";
                }
                else{
                    if($key != "2"){
                        $insert .= "NULL";
                    }
                    else{
                        $insert .= "' '";
                    }
                }
            }
            if ($key != array_key_last($data)){
                $insert .= ", ";
            }
        }
        $insert .= ")";
        if ($keys != array_key_last($datas)){
            $insert .= ",\n";
        }
    }
    $insert .= ";\n";
    file_put_contents($path."/".$filename, $insert, FILE_APPEND);
}
file_put_contents($path."/".$filename, "SET FOREIGN_KEY_CHECKS=1;", FILE_APPEND);