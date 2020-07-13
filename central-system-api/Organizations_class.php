<?php
include_once 'DB.php';

class Organization extends DB{

var $id;
var $name;
var $legalEntity;

function __construct($id,$name,$legalEntity){
    $this->id=$id;
    $this->name=$name;
    $this->legalEntity=$legalEntity;
}

function get(){
    $this->query="select * from organization where id='".$this->id."'";
    $this->get_results_from_query();
    if($this->feedback['code']=='200'){
        return $this->rows;
    }else {
        return $this->feedback;
    }
}

function getAll(){
    $this->query="select * from organization" ;
    $this->get_results_from_query();
    if($this->feedback['code']=='200'){
        return $this->rows;
    }else {
        return $this->feedback;
    }

}
function set(){
    $this->query="insert into organization (id, name, legalEntity) values ('".$this->id."','".$this->name."','".$this->legalEntity."')";
    $this->execute_single_query();
    return $this->feedback;
}

function update(){
    $this->query="update organization set name='".$this->name."', legalEntity='".$this->legalEntity."' where id='".$this->id."'";
    $this->execute_single_query();
    return $this->feedback;
}

function delete(){
    $this->query="delete from organization where id='".$this->id."'";
    $this->execute_single_query();
    return $this->feedback;
}

}