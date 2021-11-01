<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
include "db/dbconn.php";
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
$time = time();
$today = date("Y-m-d", $time);
//$today = '2021-03-22';


$sql = "SELECT * FROM timetracker WHERE date='$today' and userID=$userid";
$tracker = mysqli_query($conn, $sql);
$trackerRow = mysqli_fetch_array($tracker, MYSQLI_ASSOC);

if($trackerRow) {

    $trackerID = $trackerRow['trackerID'];
    $t_routineSql = "select * FROM t_routine WHERE trackerID = $trackerID";
    $t_routineResult = mysqli_query($conn,$t_routineSql);
    $t_routineRow = mysqli_fetch_array($t_routineResult, MYSQLI_ASSOC);
    
    
    if($t_routineRow){
        echo "<div class='col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate'>";
        include_once "timetracker.php";
        
    }else {
        //$deleteTracker = "delete from timetracker where trackerID = $trackerID";
        //mysqli_query($conn, $deleteTracker);
        echo "<div class='col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate'>";
        include_once "no-tracker.php";
        }
        
}
else {
    echo "<div class='col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate'>";
    include_once "no-tracker.php";
}
?>