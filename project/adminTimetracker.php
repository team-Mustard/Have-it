<?php

include_once("db/dbconn.php");
session_start();
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
$time = time();
$today = date("Y-m-d", $time);
//$today = "2021-03-11";



if(!empty($_POST["goalID"])){ 
    $selectRoutine = "SELECT * FROM routine WHERE goalID = ".$_POST['goalID']; 
    $routineResult = mysqli_query($conn,$selectRoutine);
    if($routineResult){ 
        echo '<option value="">루틴 선택</option>'; 
        while($routineRow = mysqli_fetch_array($routineResult,MYSQLI_ASSOC)){  
            echo '<option value="'.$routineRow['routineID'].'">'.$routineRow['routineName'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">루틴 없는데요?</option>'; 
    } 
}
if((!empty($_POST['goal']))&&(!empty($_POST['routine']))&&(!empty($_POST['startTime'])) && (!empty($_POST['endTime']))){
        
        $trackerSql = "select * from timetracker where date = '$today'";
        $trackerRow = mysqli_fetch_array(mysqli_query($conn,$trackerSql),MYSQLI_ASSOC);
        if($trackerRow){
             $trackerID = $trackerRow['trackerID'];
        }else{
            $insertTrackerSql = "insert into Timetracker(date,userid) values('$today','$userid')";
            mysqli_query($conn,$insertTrackerSql);
            $trackerSql = "select * from timetracker where date = '$today'";
            $trackerRow = mysqli_fetch_array(mysqli_query($conn,$trackerSql),MYSQLI_ASSOC);
            $trackerID = $trackerRow['trackerID'];
        }

    
    
        $startTime = date('H:i',strtotime($_POST['startTime']));
        $endTime = date('H:i',strtotime($_POST['endTime']));
        $routineID = $_POST['routine'];
        if(strtotime($startTime) >= strtotime($endTime)){
            
            echo "<script> alert('시작시간이 끝나는 시간과 같거나 클 수 없습니다.'); </script>";
            
        }else {

               
                $insertTRoutineSql = "insert into t_routine(routineID,trackerID,startTime,endTime) values('$routineID','$trackerID','$startTime','$endTime')";
                mysqli_query($conn,$insertTRoutineSql);
                $goalID = $_POST['goal'];
                $routineID = $_POST['routine'];
                $selectGoalSql = "select * from goal where goalID = $goalID";
                $selectRoutineSql = "select * from routine where routineID = $routineID";
                $goalRow = mysqli_fetch_array(mysqli_query($conn,$selectGoalSql),MYSQLI_ASSOC);
                $routineRow = mysqli_fetch_array(mysqli_query($conn, $selectRoutineSql),MYSQLI_ASSOC);
                $routineName = $routineRow['routineName'];
                echo "<div><a class='fas fa-minus-circle' onclick= 'deleteRoutine($routineID);'></a>";
                echo "<span> $startTime - $endTime </span><span style='color: white'> $routineName </span>";
                echo "</div>";
   
            
            
        }
    
}
if(!empty($_POST['routineID'])){
    $trackerSql = "select * from timetracker where date = '$today'";
    $trackerRow = mysqli_fetch_array(mysqli_query($conn,$trackerSql),MYSQLI_ASSOC);
    $trackerID = $trackerRow['trackerID'];
    $routineID = $_POST['routineID'];
    $deleteRoutineSql = "delete from t_routine where trackerID = $trackerID and routineID = $routineID";
    mysqli_query($conn, $deleteRoutineSql);
    $routineCount = 0;
    $selecttRoutineSql = "select * from t_routine WHERE trackerID =$trackerID";
    
    $troutineResult = mysqli_query($conn,$selecttRoutineSql);
    while($troutineRow = mysqli_fetch_array($troutineResult, MYSQLI_ASSOC)){
        
            $routineCount++;
            $startTime = date('H:i',strtotime($troutineRow['startTime']));
            $endTime = date('H:i',strtotime($troutineRow['endTime']));
            $routineID = $troutineRow['routineID'];
            $routineSql = "select * from routine where routineID =$routineID ";
            $routineRow = mysqli_fetch_array(mysqli_query($conn,$routineSql),MYSQLI_ASSOC);
            $routineName = $routineRow['routineName'];

            echo "<div><a class='fas fa-minus-circle' onclick= 'deleteRoutine($routineID);'></a>";
            echo "<span> $startTime ~ $endTime </span><span style='color: white'>$routineName</span>";
            
    }
    echo "<script> alert('해당 루틴이 타임트레커에서 제거되었습니다.'); </script>";
}

if((!empty($_POST['t_routineID']))){
    
    
    $t_routineID = $_POST['t_routineID'];
    $checked = $_POST['checked'];
    $updateSql = "update t_routine set checkRoutine = '$checked' where t_routineID = '$t_routineID'";
    mysqli_query($conn,$updateSql);
 
   
    
}

?>