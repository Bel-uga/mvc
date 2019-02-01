<?php
namespace Classes;

Abstract class Model
{
	protected $db;
	public $query;
	public $err;
	public $result;
	
	public function __construct($select = false) {		
		global $dbObject;
		$this->db = $dbObject;		
	}
	
	function run($query) {
		$this->query = $query;	
		$this->result = mysqli_query($this->db->link, $this->query);	
		$this->err = mysqli_error($this->db->link);	
	}
}

