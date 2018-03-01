<?php

// NOTE - FOR THE SAKE OF BREVITY, I RECYCLED AN OLD FILE. AN IMMEDIATE @TODO
// BEFORE PRODUCTION WOULD BE TO CONVERT THIS FILE TO MYSQLI

require_once 'config.inc.php';

GLOBAL $database;
$database = mysql_connect($dbhost,$dbuser,$dbpass) or die(mysqli_error());
//mysql_select_db($dbname,$database);
mysql_select_db($dbname,$database) or die(mysqli_error());

function secure($n)
{
    return mysql_escape_string($n);
}

function db_insert($dbtable, $row){
    $fieldvalues = $fieldnames = array();
    foreach($row as $k=>$v){
        $fieldnames[]=$k;
        $fieldvalues[]=mysql_real_escape_string((trim($v)));
    }
    $fieldnames = implode(',',$fieldnames);
    $fieldvalues = "'".implode("','",$fieldvalues)."'";
    $sql = "INSERT INTO $dbtable($fieldnames) VALUES ($fieldvalues)";
    mysql_query($sql) or die(mysql_error().$sql);
    return mysql_insert_id();
}

function db_update($dbtable, $fields, $where){
//db_update('TableName', $params, array('idEmployee'=>$user['idEmployee']))
    $values = array();
    if($where!=''){
        $where = _db_where($where);
    }
    foreach($fields as $k=>$v){
        $values[]=$k.'='."'".mysql_real_escape_string((trim($v)))."'";
    }
    $values = implode(", ",$values);
    $sql = "UPDATE $dbtable SET $values $where";
    #print $sql; exit;
    mysql_query($sql) or die(mysql_error().$sql);
}

function db_select($dbtable, $where='', $append=''){
    if($where!=''){
        $where = _db_where($where);
    }
    $sql = "SELECT * FROM $dbtable $where $append";
    $query = mysql_query($sql) or die(mysql_error().$sql);
    $res = array();
    while($row = mysql_fetch_assoc($query)){
        $res[]=$row;
    }
    return $res;
}

function db_raw($sql){
    $query = mysql_query($sql) or die(mysql_error().$sql);
    $res = array();
    while($row = mysql_fetch_assoc($query)){
        $res[]=$row;
    }
    return $res;
}

function db_like($dbtable, $where=''){
    if($where!=''){
        $where = _db_like($where);
    }
    $sql = "SELECT * FROM $dbtable $where";
    $query = mysql_query($sql) or die(mysql_error().$sql);
    $res = array();
    while($row = mysql_fetch_assoc($query)){
        $res[]=$row;
    }
    return $res;
}

function _db_where($where){
    if ($where=='') return '';
    $w = array();
    foreach($where as $k=>$v){
        if(is_array($v)) {
        }
        $w[]=$k.'='."'".mysql_real_escape_string($v)."'";
    }
    return ' WHERE '.implode(' AND ',$w);
}

function _db_like($where){
    if ($where=='') return '';
    $w = array();
    foreach($where as $k=>$v){
        $w[]=$k.' LIKE '."'%".mysql_real_escape_string($v)."%'";
    }
    return ' WHERE '.implode(' AND ',$w);
}
