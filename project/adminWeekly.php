<?php

session_start();
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
if(isset($_GET['mode'])) $mode = $_GET['mode'];
include "db/dbconn.php";
switch($mode){
        
    case 1:{
        
        $today = date("Y-m-d");   
        //$today = '2021-09-06';    
        $year = date("Y",strtotime($today));
        $month = date("m",strtotime($today));
        $day = date("d",strtotime($today));
        
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
        
     
        $trackerSql = "select * from timetracker where userID = '$userid' 
                and date(date) between '$startTerm' and '$endTerm'";
        
        $trackerResult = mysqli_query($conn,$trackerSql);
        $achieveRoutine = null;
        
        if($trackerResult){ 

            while($trackerRow = mysqli_fetch_array($trackerResult, MYSQLI_ASSOC)){
                $trackerID = $trackerRow['trackerID'];
                $trackerDate = $trackerRow['date'];
                $dayofweek = date('w',strtotime($trackerDate));
                $t_routineSql = "select * from t_routine where trackerID = $trackerID";
                $t_routineResult = mysqli_query($conn, $t_routineSql);
                
                if($t_routineResult){                 
                    while($t_routineRow = mysqli_fetch_array($t_routineResult, MYSQLI_ASSOC)){
                        $routineID = $t_routineRow['routineID'];
                        $routineSql = "select goalID from routine where routineID = $routineID";
                        $routineResult = mysqli_query($conn,$routineSql);
                        $routineRow = mysqli_fetch_array($routineResult,MYSQLI_ASSOC);
                        $goalID = $routineRow['goalID'];
                        if(isset($goalIDArr)){
                            if(!in_array($goalID,$goalIDArr)){
                                $goalIDArr[count($goalIDArr)] = $goalID;
                            }
                        }else{
                            $goalIDArr[0] = $goalID;

                        }

                        if(isset($weeklyRoutine[$dayofweek][$goalID])){
                            $weeklyRoutine[$dayofweek][$goalID]++;
                            
                        }else {
                            $weeklyRoutine[$dayofweek][$goalID] = 1;
                            
                        }
                        
                        if($t_routineRow['checkRoutine'] == 1){
                            if(isset($checkWeeklyRoutine[$dayofweek][$goalID])){                      
                                $checkWeeklyRoutine[$dayofweek][$goalID]++;
                            }else{ 
                                $checkWeeklyRoutine[$dayofweek][$goalID] = 1;
                            }
                        }   
                    }

                }


            }

        }
        $insertWeeklySql = "insert into WeeklyReport (userID, date) 
                    values($userid,'$today')";
        mysqli_query($conn, $insertWeeklySql);
        $selectWeeklySql = "select weeklyID from weeklyreport where date = '$today' and userid = $userid";
        $weeklyResult = mysqli_query($conn, $selectWeeklySql);
        $weeklyRow = mysqli_fetch_array($weeklyResult, MYSQLI_ASSOC);
        $weeklyID = $weeklyRow['weeklyID'];
        if(isset($goalIDArr)){
            $goalIDCount = count($goalIDArr);
            
        }else{
            $goalIDCount = 0;
        }
        
                             
        for($w=0;$w<$goalIDCount;$w++){
            $goalID = $goalIDArr[$w];

            $dayweekAchieve = null;
        
            for($i=0;$i<7;$i++){

                if(isset($weeklyRoutine[$i][$goalID])){
                    if(isset($checkWeeklyRoutine[$i][$goalID])) {    
                        $dayweekPercent = round($checkWeeklyRoutine[$i][$goalID] / $weeklyRoutine[$i][$goalID] * 100 ,1);

                    }else{                
                        $dayweekPercent = 0;
                    }     
                }else        
                    $dayweekPercent = 0;                

                if($dayweekAchieve != null){            

                    $dayweekAchieve = "$dayweekAchieve;$dayweekPercent";

                }else{            
                    $dayweekAchieve = "$dayweekPercent";        
                }      

            }    
            $insertWeeklyAchieveSql = "insert into weekly_achieve_dayofweek (goalID, weeklyID,achieveDayofWeek) values($goalID,$weeklyID,'$dayweekAchieve')";
              
        
           
            mysqli_query($conn, $insertWeeklyAchieveSql);
            

           
        }
        
        
        
        
        
        
        mysqli_close($conn);
        echo("
                    <script>
                        location.href='./index.php';
                    </script>"
                    );
        
        break;
        
        
        
        

    }
    
        
    case 2:{
        
        if(isset($_POST['weeklyScore'])) $weeklyScore = $_POST['weeklyScore'];
        if(isset($_POST['good'])) $good = $_POST['good'];
        if(isset($_POST['bad'])) $bad = $_POST['bad'];
        if(isset($_POST['weeklyID'])) $weeklyID = $_POST['weeklyID'];
        if(isset($_POST['inputWeeklyImg'])) $weeklyImg = $_POST['inputWeeklyImg'];
        if(isset($_POST['failure'])) $failure = $_POST['failure'];
        $inputFailure = null;
        if(isset($failure)){
            $failureCount = count($failure);
        }else{
            $failureCount = 0;
        }
        echo $failureCount;
        for($i=0;$i<$failureCount;$i++){
              
            if($inputFailure!=null){
                
                $inputFailure = "$inputFailure;$failure[$i]";
                
            }else{
                
                $inputFailure = "$failure[$i]";
                
            }
   
        }
              
        $uploadDir = "upload/$userid/";
        $datetime = date("YmdHis");
        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777,true);
        }
        
        
        
        if(isset($_FILES['inputImg'])){
            if($_FILES['inputImg']['size']!=null){
                $inputImg = "$uploadDir$datetime.png";
                move_uploaded_file($_FILES["inputImg"]['tmp_name'], $inputImg); 
                $updateSql = "update weeklyreport set goodEvaluation = '$good', badEvaluation = '$bad', score = '$weeklyScore', image = '$inputImg', weekly_failure = '$inputFailure'  where weeklyID = '$weeklyID'";
            }else {
                $updateSql = "update weeklyreport set goodEvaluation = '$good', badEvaluation = '$bad', score = '$weeklyScore', weekly_failure = '$inputFailure' where weeklyID = '$weeklyID'";

            }
            
        }
        //echo $updateSql;
        mysqli_query($conn, $updateSql);
        mysqli_close($conn);
        
        echo ("
                <script>
                    alert('수정이 완료되었습니다');
                    history.back();
                </script>
        ");
        
        break;
    }
}




?>