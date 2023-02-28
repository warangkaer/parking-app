<?php
namespace Index;
date_default_timezone_set('Asia/Jakarta');

use DateTime;

class Parking{

  // Get Data
  public function index()
  {
    echo json_encode(['data' => $_SESSION['customer']]);
  }

  // Get queue of all vehicles
  public function getQueue(int $id)
  {
    foreach ($_SESSION['customer'] as $key => $val) {
        if ($val['id'] === $id) {
            return $val;
        }
    }
    return [];
  }

  // set time for entering vehicle
  public function setInTime($time)
  {
    $in_time = strtotime($time);

    if(time() < $in_time){
      echo json_encode(["message" => "In time can't greater than now!"]);
      exit();
    }

    $queue = !isset($_SESSION['customer']) ? $queue = 1 : count($_SESSION['customer']) + 1;

    $newArr = array('id' => $queue, 'in_time' => $in_time);
    $_SESSION['customer'][] =  $newArr;

    echo json_encode(['data' => $newArr]);
  }  

  // total time of vehicle has been parking
  public function totalTime(int $out_time, int $id)
  {
    $queue = $this->getQueue($id);
    if($queue["in_time"] > $out_time){
      echo json_encode(['message' => "Out Time can't be lower than in time!"]);
      exit();
    }

    $dt_inTime = new DateTime(date('Y-m-d H:i:s',$queue["in_time"]));
    $dt_outTime = new DateTime(date('Y-m-d H:i:s',$out_time));
    $diff_time = $dt_outTime->diff($dt_inTime);
    $total_time = $diff_time->h * 60 + $diff_time->i;
    $this->totalParkingPayment($total_time);

    $this->remove($id);
  }

  // count the payment
  public function totalParkingPayment($total_time)
  {
    $payment = $total_time >= 180 ? 2000 + floor(($total_time-120)/60) * 500 : 2000;
    
    echo json_encode(['payment' => $payment]);
  }

  // remove exit vehicle
  public function remove(int $id)
  {
    foreach ($_SESSION['customer'] as $key => $val) {
        if ($val['id'] === $id) {
            unset($_SESSION['customer'][$key]);
        }
    }
  }
}