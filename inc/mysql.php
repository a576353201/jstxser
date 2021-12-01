<?php
/*
 * Created on 2011-2-17
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
//我的mysql类
  class mysql{


     private $host;
     private $name;
     private $pass;
     private $db;
     private $ut;



     function __construct($host,$name,$pass,$db,$ut){
     	$this->host=$host;
     	$this->name=$name;
     	$this->pass=$pass;
     	$this->db=$db;
     	$this->ut=$ut;
     	$this->connect();

     }

//连接数据库
     function connect(){
      $link=mysql_connect($this->host,$this->name,$this->pass) or die ($this->error());
      mysql_select_db($this->db,$link) or die("没找到该数据库：".$this->db);
      mysql_query("SET NAMES utf8mb4");
     }

	function query($sql) {
	    $query = mysql_query($sql);
	    return $query;
	}

    function show($message = '', $sql = '') {
		if(!$sql) echo $message;
		else echo $message.'<br>'.$sql;
	}

    function affected_rows() {
		return mysql_affected_rows();
	}

	function result($query, $row) {
		return mysql_result($query, $row);
	}

	function num_rows($query) {
		return mysql_num_rows($query);
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return mysql_insert_id();
	}

	function fetch_row($query) {
		return mysql_fetch_row($query);
	}
	function fetch_all($sql){
		
		$query=mysql_query($sql);
		while ($row=mysql_fetch_array($query)){
			
			$all[]=$row;
			
		}
		return $all;
	}
	
	

	function version() {
		return mysql_get_server_info();
	}

	function close() {
		return mysql_close();
	}

	function fetch_array($query){
		return mysql_fetch_array($query);
	}

   //==============

    function insert($table,$key,$value){

    	$this->query("insert into $table ($key) value ($value)");
    	return $this->insert_id();

    }
    
   function update($table,$array,$id){

      	foreach ($array as $key=>$value) {
      		$this->query("update $table set `$key`='$value' where id='$id'");
      		
      	}
      	
    
      }

      
      function exec($sql){
      	
      	$query=$this->query($sql);
      	return $this->fetch_array($query);
      	
      }
  

      
   }
include_once dirname(__FILE__).'/'.'config.php';

  $db =  new mysql($dbhost,$dbuser,$dbpwd,$dbname,$dbcharset);


?>
