<?php
include "db/dbconn.php";
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
$time = time();
$today = date("Y-m-d", $time);

$sql = "SELECT * FROM timetracker WHERE date='$today' and userID=$userid";
$tracker = mysqli_query($conn, $sql);
$trackerRow = mysqli_fetch_array($tracker, MYSQLI_ASSOC);

if($trackerRow) {
    $trackerID = $trackerRow['trackerID'];
    include_once "timetracker.php";
}
else {
    include_once "no-tracker.php";
}
?>