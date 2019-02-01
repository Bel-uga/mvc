<?php
namespace DB;

class Connect
{
	public $link;

	function __construct() {
		$this->connect();
	}
	
	function connect() {		
		$this->link = mysqli_connect (DB_HOST, DB_USER, DB_PASS, DB_NAME);   
		mysqli_query($this->link,'SET NAMES utf8');          
		mysqli_query($this->link,'SET CHARACTER SET  utf8');  
		mysqli_query($this->link,'SET COLLATION_CONNECTION="utf8_general_ci"');		
	}


}

