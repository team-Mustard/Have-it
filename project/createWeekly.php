<?php

session_start();
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];

include "db/dbconn.php";
$today = date("Y-m-d");

/*
$year = date("Y",strtotime($today));
$month = date("m",strtotime($today));
$day = date("d",strtotime($today));*/

$year = date("Y",strtotime($today));
$month = 3;
$day = 8;

$preLastday = date('t',mktime(0, 0, 1, $month-1, $day, $year));

if($day > 7){
    $startTerm = date('Y-m-d',mktime(0,0,0,$month,$day - 7,$year));
}else{
    $startTerm = date('Y-m-d',mktime(0,0,0,$month-1,$preLastday + $day - 7,$year));
}
if($day > 1)
{
    $endTerm =  date('Y-m-d',mktime(0,0,0,$month,$day - 1,$year));
    
}else {
    $endTerm = date('Y-m-d',mktime(0,0,0,$month-1,$preLastday,$year));
}
echo "$startTerm <br> $endTerm <br>";
$trackerSql = "select * from timetracker where userID = '$userid' 
        and date(date) between '$startTerm' and '$endTerm'";
$trackerResult = mysqli_query($conn,$trackerSql);
$achieveRoutine = null;
if($trackerResult){ 
    
    while($trackerRow = mysqli_fetch_array($trackerResult, MYSQLI_ASSOC)){
        $trackerID = $trackerRow['trackerID'];
        echo $trackerID;
        echo "<br>";
        $t_routineSql = "select * from t_routine where trackerID = $trackerID";
        $t_routineResult = mysqli_query($conn, $t_routineSql);
        if($t_routineResult){
            $successRoutine = 0;
            $allRoutine = 0;
            while($t_routineRow = mysqli_fetch_array($t_routineResult, MYSQLI_ASSOC)){
                $allRoutine++;
                if($t_routineRow['checkRoutine'] == 1){
                    $successRoutine++;
                    
                }   
            }
            if($achieveRoutine !=null){
                $achieveRoutine = "$achieveRoutine;$allRoutine;$successRoutine";
            }else {
                $achieveRoutine = "$allRoutine;$successRoutine";
            }
            
        }
        
        
    }
    
}

$insertSql = "insert into WeeklyReport (userID, date, routineAchieve) 
            values($userid,'2021-03-08','$achieveRoutine')";

//mysqli_query($conn, $insertSql);
//mysqli_close($conn);


?>