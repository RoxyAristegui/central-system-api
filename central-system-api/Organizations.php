<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once "Organizations_class.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id'])) {
        $organization =new Organization($_GET["id"],'', '');
        $list=$organization->get();

        if(!isset($list['code'])) {
            header("HTTP/1.1 200 OK");
            echo json_encode($list);
            exit();
        }
    }else{
        $organization =new organization('','', '');
        $list=$organization->getAll();

        if(!isset($list['code'])) {
            header("HTTP/1.1 200 OK");
            echo json_encode($list);
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $organization= new organization($_POST['id'],$_POST['name'],$_POST['legalEntity']);
    $res=$organization->set();
    if($res['code']==201){
        header("HTTP/1.1 200 OK");
        exit();
    }


}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
    $organization= new organization($_REQUEST["id"],'','');
    $res=$organization->delete();
    if($res['code']==201){
        header("HTTP/1.1 200 OK");
        exit();
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $values=parseParameters(file_get_contents( 'php://input', 'r' ));
    $organization= new organization($values["id"], $values["name"], $values["legalEntity"]);
    $resp=$organization->update();
      if($resp['code']==201){
          header("HTTP/1.1 200 OK");
          exit();
      }

}

header("HTTP/1.1 400 Bad Request");

function parseParameters($string)
{
     $myArray =array();
    $str=explode("&",$string);
    foreach ($str as $st){
        $pair=explode("=",$st);
        $myArray[$pair[0]]=$pair[1];

    } return $myArray;

}

?>