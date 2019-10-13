<?php
namespace Classes;

abstract class Model
{
    protected $db;
    public $query;
    public $err;
    public $result;

    protected function __construct()
    {
        global $dbObject;
        $this->db = $dbObject;
    }

    public function run($query)
    {
        $this->query = $query;
        $this->result = mysqli_query($this->db->link, $this->query);
        $this->err = mysqli_error($this->db->link);
    }
}
