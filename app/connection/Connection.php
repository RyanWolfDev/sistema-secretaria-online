<?php 

	function iniciarConexao()
	{
	    $dsn  = 'mysql:host=bwcwcpl3yegpyf4kipnn-mysql.services.clever-cloud.com;dbname=bwcwcpl3yegpyf4kipnn;charset=utf8';
	    $user = 'uoex36a4w9rjgik0';
	    $pass = 'c8GiHQ2roKlfp01sk0gh';

	    try{
	        $conn = new PDO($dsn, $user, $pass);
	        return $conn;
	    }catch(PDOException $ex){
	        echo 'Erro: '.$ex->getMessage();
	    }
	}


	function exibirErro($stmt){
		print_r($stmt->errorInfo());	
	}
