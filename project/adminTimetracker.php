<?php

include_once("db/dbconn.php");
session_start();
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
$time = time();
$today = date("Y-m-d", $time);
//$today = '2021-03-22';



if(!empty($_POST["goalID"])){ 
    $selectRoutine = "SELECT * FROM routine WHERE goalID = ".$_POST['goalID']; 
    $routineResult = mysqli_query($conn,$selectRoutine);
    if($routineResult){ 
        echo '<option value="" selected="selectd" disabled hidden>루틴 선택</option>'; 
        while($routineRow = mysqli_fetch_array($routineResult,MYSQLI_ASSOC)){  
            echo '<option value="'.$routineRow['routineID'].'">'.$routineRow['routineName'].'</option>'; 
        } 
    }else{
        echo '<option value="">루틴이 존재하지 않습니다.</option>'; 
        
    }
}

if((!empty($_POST['goal']))&&(!empty($_POST['routine']))&&(!empty($_POST['startTime'])) && (!empty($_POST['endTime']))){
        
        $trackerSql = "select * from timetracker where date = '$today' and userid = '$userid'";
        $trackerRow = mysqli_fetch_array(mysqli_query($conn,$trackerSql),MYSQLI_ASSOC);
        if($trackerRow){
            $trackerID = $trackerRow['trackerID'];
            $selecttroutineSql = "select * from t_routine where trackerID = '$trackerID'";
            $selectScheduleSql = "select * from schedule where trackerID = '$trackerID'";
            $scheduleResult = mysqli_query($conn,$selectScheduleSql);
            $troutineResult = mysqli_query($conn,$selecttroutineSql);
            $startTime = date('H:i',strtotime($_POST['startTime']));
            $endTime = date('H:i',strtotime($_POST['endTime']));
            $routineID = $_POST['routine'];
            
            
                
            
            if(strtotime($startTime) >= strtotime($endTime)){

                echo "<script> alert('시작시간이 끝나는 시간과 같거나 클 수 없습니다.'); </script>";

            }else {
                while($troutineRow = mysqli_fetch_array($troutineResult,MYSQLI_ASSOC)){
                    if(($startTime >= $troutineRow['startTime'] && $startTime < $troutineRow['endTime']) || ($endTime >= $troutineRow['startTime'] && $endTime <= $troutineRow['endTime'])){
                    echo "<script> alert('기존 등록된 루틴과 시간이 겹칠 수 없습니다.'); </script>";
                    return;

                    }
                }
                while($scheduleRow = mysqli_fetch_array($scheduleResult,MYSQLI_ASSOC)){
                    if($startTime >= $scheduleRow['startTime'] && $startTime < $scheduleRow['endTime'] || $endTime >= $scheduleRow['startTime'] && $endTime <= $scheduleRow['endTime']){
                    echo "<script> alert('기존 등록된 루틴과 시간이 겹칠 수 없습니다.'); </script>";
                    return;

                    }
                }
                    $insertTRoutineSql = "insert into t_routine(routineID,trackerID,startTime,endTime) values('$routineID','$trackerID','$startTime','$endTime')";
                    mysqli_query($conn,$insertTRoutineSql);
                    $goalID = $_POST['goal'];
                    $routineID = $_POST['routine'];
                    $selectGoalSql = "select * from goal where goalID = $goalID";
                    $selectRoutineSql = "select * from routine where routineID = $routineID";
                    $goalRow = mysqli_fetch_array(mysqli_query($conn,$selectGoalSql),MYSQLI_ASSOC);
                    $routineRow = mysqli_fetch_array(mysqli_query($conn, $selectRoutineSql),MYSQLI_ASSOC);

                    $routineName = $routineRow['routineName'];
                    $routineColor = $routineRow['color'];
                    echo "<div><a class='fas fa-minus-circle' onclick= 'deleteRoutine($routineID,\"$startTime\");'></a>";
                    echo "<span> $startTime - $endTime </span><span style='color: $routineColor'> $routineName </span>";
                    echo "</div>";



            }
            
            
        }else{
           
            $insertTrackerSql = "insert into Timetracker(date,userid) values('$today','$userid')";
            mysqli_query($conn,$insertTrackerSql);
            $trackerSql = "select * from timetracker where date = '$today' and userid = '$userid'";
            $trackerRow = mysqli_fetch_array(mysqli_query($conn,$trackerSql),MYSQLI_ASSOC);
            $trackerID = $trackerRow['trackerID'];
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
                    $routineColor = $routineRow['color'];
                    echo "<div><a class='fas fa-minus-circle' onclick= 'deleteRoutine($routineID, \"$startTime\");'></a>";
                    echo "<span> $startTime - $endTime </span><span style='color: $routineColor'> $routineName </span>";
                    echo "</div>";



            }
            
            

        }

    
        
}
if(!empty($_POST['routineID']) && !empty($_POST['startTime']) || !empty($_POST['checkScheduleID']) && !empty($_POST['startTime'])){
    $trackerSql = "select * from timetracker where date = '$today' and userid = '$userid'";
    $trackerRow = mysqli_fetch_array(mysqli_query($conn,$trackerSql),MYSQLI_ASSOC);
    $trackerID = $trackerRow['trackerID'];
    if(isset($_POST['routineID'])){ 
        
        $routineID = $_POST['routineID'];
        $startTime = $_POST['startTime'];
        $deleteRoutineSql = "delete from t_routine where trackerID = $trackerID and routineID = $routineID and startTime = '$startTime'";
        
    }else if(isset($_POST['checkScheduleID'])){
        $scheduleID= $_POST['checkScheduleID'];
        $startTime = $_POST['startTime'];
        $deleteRoutineSql = "delete from schedule where trackerID = $trackerID and scheduleID = $scheduleID and startTime = '$startTime'";
    }
        mysqli_query($conn, $deleteRoutineSql);

        $routineCount = 0;
        $routineStart = null;
        $routineEnd = null;
        $routineName = null;
        $routineColor = null;
        $routineKind = null;
        $routineID = null;
        if($trackerRow){ 
    
            $trackerID = $trackerRow['trackerID'];
            $selecttRoutineSql = "select * from t_routine WHERE trackerID = '$trackerID'";
            $selectScheduleSql = "select * from schedule where trackerID = '$trackerID'";
            $troutineResult = mysqli_query($conn,$selecttRoutineSql);
            $scheduleResult = mysqli_query($conn,$selectScheduleSql);
            while($troutineRow = mysqli_fetch_array($troutineResult, MYSQLI_ASSOC)){
                $routineStart[$routineCount] = date('H:i',strtotime($troutineRow['startTime']));
                $routineEnd[$routineCount] = date('H:i',strtotime($troutineRow['endTime']));
                $routineID[$routineCount] = $troutineRow['routineID'];
                $routineSql = "select * from routine where routineID =$routineID[$routineCount]";
                $routineRow = mysqli_fetch_array(mysqli_query($conn,$routineSql),MYSQLI_ASSOC);
                $routineName[$routineCount] = $routineRow['routineName'];
                $routineColor[$routineCount] = $routineRow['color'];
                $routineKind[$routineCount] = 1;
                $routineCount++;
                //TODO: 색깔 바꾸기
            }
            while($scheduleRow = mysqli_fetch_array($scheduleResult, MYSQLI_ASSOC)){
                $routineStart[$routineCount] = date('H:i',strtotime($scheduleRow['startTime']));
                $routineEnd[$routineCount] = date('H:i',strtotime($scheduleRow['endTime']));
                $routineID[$routineCount] = $scheduleRow['scheduleID'];
                $routineName[$routineCount] = $scheduleRow['scheduleName'];
                $routineColor[$routineCount] = $scheduleRow['color'];
                $routineKind[$routineCount] = 2;
                $routineCount++;

            }

    }
    if($routineCount !=0){
        
    for($z=0;$z<$routineCount;$z++){
        if($routineKind[$z]==1){
            echo "<div id='routineList'><a class='fas fa-minus-circle' onclick= 'deleteRoutine($routineID[$z],\"$routineStart[$z]\");'></a>";
        }else{
            echo "<div id='routineList'><a class='fas fa-minus-circle' onclick= 'deleteSchedule($routineID[$z],\"$routineStart[$z]\");'></a>";
        }
        echo "<span> $routineStart[$z] - $routineEnd[$z] </span><span style='color: $routineColor[$z]'>$routineName[$z]</span>";
        echo "</div>"; 
        
        }
    
    }
       
    echo "<script> alert('해당 루틴이 타임트레커에서 제거되었습니다.'); </script>";
}

if(!empty($_POST['routineID']) && !empty($_POST['t_routineID']) && isset(($_POST['checked'])) && isset(($_POST['trackerID']))){
   
    $t_routineID = $_POST['t_routineID'];
    $trackerID = $_POST['trackerID'];
    $checked = $_POST['checked'];
    $routineID = $_POST['routineID'];
    $troutineCount = 0;
    $troutineChecked = null;
    $updateSql = "update t_routine set checkRoutine = '$checked' where t_routineID = '$t_routineID'";
    mysqli_query($conn,$updateSql); 
    
    $routineSql = "select * from routine where routineID = '$routineID'";
    
    $troutineSql = "select checkRoutine from t_routine where routineID = $routineID and trackerID = $trackerID";
    
    $troutineResult = mysqli_query($conn,$troutineSql);
    while($troutineRow = mysqli_fetch_array($troutineResult,MYSQLI_ASSOC)){
        $troutineChecked[$troutineCount++] = $troutineRow['checkRoutine']; 
    }
    
    $routineRow = mysqli_fetch_array(mysqli_query($conn,$routineSql),MYSQLI_ASSOC);
    if($routineRow){
        $habitTracker = $routineRow['habbitTracker'];
        $habitTracker = explode(';',$habitTracker);
        $dayofweek = date('w',strtotime($today));
        
        if($checked == 1){
            if($troutineCount == 1){
                $habitTracker[$dayofweek] = 1;
                $habitTracker = implode(';',$habitTracker);
                $updateRoutineSql = "update routine set habbitTracker = '$habitTracker' where routineID = '$routineID'";
                mysqli_query($conn,$updateRoutineSql);
                
            }else{
                $falseCheck = 1;
                for($i=0;$i<$troutineCount;$i++){
                    if(!$troutineChecked[$i]){
                        $falseCheck = 0;
                    }
                }
                if($falseCheck){
                    $habitTracker[$dayofweek] = 1;
                    $habitTracker = implode(';',$habitTracker);
                    $updateRoutineSql = "update routine set habbitTracker = '$habitTracker' where routineID = '$routineID'";
                    mysqli_query($conn,$updateRoutineSql);
                }
            }
            
        }else{
            $habitTracker[$dayofweek] = 0;
            $habitTracker = implode(';',$habitTracker);
            $updateRoutineSql = "update routine set habbitTracker = '$habitTracker' where routineID = '$routineID'";
            mysqli_query($conn,$updateRoutineSql);
            
        }
        
        
    }
       
}

if((!empty($_POST['scheduleID']))&&isset(($_POST['checked']))){
    
    
    $scheduleID = $_POST['scheduleID'];
    $checked = $_POST['checked'];
    $updateSql = "update schedule set checkSchedule = '$checked' where scheduleID = '$scheduleID'";
    mysqli_query($conn,$updateSql);    
}


if((!empty($_POST['scheduleName'])) && (!empty($_POST['startTime'])) && (!empty($_POST['endTime']))&&
(!empty($_POST['scheduleColor']))){
    
    
    $trackerSql = "select * from timetracker where date = '$today' and userid = '$userid'";
        
    $trackerRow = mysqli_fetch_array(mysqli_query($conn,$trackerSql),MYSQLI_ASSOC);
    if($trackerRow){
             $trackerID = $trackerRow['trackerID'];
        }else{

        $insertTrackerSql = "insert into Timetracker(date,userid) values('$today','$userid')";
         mysqli_query($conn,$insertTrackerSql);
        $trackerSql = "select * from timetracker where date = '$today' and userid = $userid";
        $trackerRow = mysqli_fetch_array(mysqli_query($conn,$trackerSql),MYSQLI_ASSOC);
        $trackerID = $trackerRow['trackerID'];
        
        
        
        
        
        
        }

    
    
    $startTime = date('H:i',strtotime($_POST['startTime']));
    $endTime = date('H:i',strtotime($_POST['endTime']));
    $scheduleName = $_POST['scheduleName'];
    $scheduleColor = $_POST['scheduleColor'];
    $selecttroutineSql = "select * from t_routine where trackerID = '$trackerID'";
    $selectScheduleSql = "select * from schedule where trackerID = '$trackerID'";
    $scheduleResult = mysqli_query($conn,$selectScheduleSql);
    $troutineResult = mysqli_query($conn,$selecttroutineSql);
    
    
    
    if(strtotime($startTime) >= strtotime($endTime)){
            
        echo "<script> alert('시작시간이 끝나는 시간과 같거나 클 수 없습니다.'); </script>";
            
     }else {
        /* 중복처리 */
        while($troutineRow = mysqli_fetch_array($troutineResult,MYSQLI_ASSOC)){
            if($startTime >= $troutineRow['startTime'] && $startTime < $troutineRow['endTime']  || $endTime >= $troutineRow['startTime'] && $endTime <= $troutineRow['endTime']){
            echo "<script> alert('기존 등록된 루틴과 시간이 겹칠 수 없습니다.'); </script>";
            return;

                }
            }
        while($scheduleRow = mysqli_fetch_array($scheduleResult,MYSQLI_ASSOC)){
            if($startTime >= $scheduleRow['startTime'] && $startTime < $scheduleRow['endTime'] || $endTime >= $scheduleRow['startTime'] && $endTime <= $scheduleRow['endTime']){
            echo "<script> alert('기존 등록된 루틴과 시간이 겹칠 수 없습니다.'); </script>";
            return;
                
            }
         }
               
            
        $insertScheduleSql = "insert into schedule(scheduleName,startTime,endTime,trackerID,color) values('$scheduleName','$startTime','$endTime','$trackerID','$scheduleColor')";
            
        mysqli_query($conn,$insertScheduleSql);
        
        $selectSchduleSql = "select scheduleID from schedule where trackerID = $trackerID and scheduleName = '$scheduleName'";
        
        $scheduleRow = mysqli_fetch_array(mysqli_query($conn,$selectSchduleSql),MYSQLI_ASSOC);
        $scheduleID = $scheduleRow['scheduleID'];
        
        
            
        echo "<div><a class='fas fa-minus-circle' onclick= 'deleteSchedule($scheduleID,\"$startTime\");'></a>";
            
        echo "<span> $startTime - $endTime </span><span style='color: $scheduleColor'> $scheduleName </span>";
            
        echo "</div>";
               
        }

}



?>