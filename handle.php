<?php
  session_start();
  include_once './Parking.php';
  header("Access-Control-Allow-Origin: *");

  use Index\Parking;

  $req = trim(file_get_contents("php://input")); 
  $decoded = json_decode($req, true);

  $parking = new Parking();
  // input new entry
  if(isset($decoded["in_time"]) && $_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $parking->setInTime($decoded["in_time"]);
  } //remove an entry
  else if(isset($decoded['id']) && isset($decoded['out_time']) && $_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $parking->totalTime(strtotime($decoded['out_time']), $decoded['id']);
  } //get all entry
  else if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $parking->index();
  }
?>