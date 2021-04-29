<?php

session_start();
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
if(isset($_GET['mode'])) $mode = $_GET['mode'];
include "db/dbconn.php";
switch($mode){
        
    case 1:{
        
        /*$today = date("Y-m-d");       
        $year = date("Y",strtotime($today));
        $month = date("m",strtotime($today));
        $day = date("d",strtotime($today));
        */
        $today = '2021-03-15';    
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
                $t_routineSql = "select * from t_routine where trackerID = $trackerID";
                $t_routineResult = mysqli_query($conn, $t_routineSql);
                
                if($t_routineResult){
                    $successRoutine = 0;
                    $allRoutine = 0;
                    $preRoutineID = 0;
                    
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
                        
                        if(isset($weeklyRoutine[$goalID])){
                            
                            
                        }
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
                    values($userid,'$today','$achieveRoutine')";
        
        mysqli_query($conn, $insertSql);
        mysqli_close($conn);

        break;
        
    }
    case 2:{
        
        if(isset($_POST['weeklyScore'])) $weeklyScore = $_POST['weeklyScore'];
        if(isset($_POST['good'])) $good = $_POST['good'];
        if(isset($_POST['bad'])) $bad = $_POST['bad'];
        if(isset($_POST['weeklyID'])) $weeklyID = $_POST['weeklyID'];
        if(isset($_POST['inputWeeklyImg'])) $weeklyImg = $_POST['inputWeeklyImg'];
        $uploadDir = "upload/$userid/";
        $datetime = date("YmdHis");
        if(!is_dir(!$uploadDir)){
            mkdir($uploadDir, 0777,true);
        }
        
        
        
        if(isset($_FILES['inputImg'])){
        
            $inputImg = "$uploadDir$datetime.png";
            
            move_uploaded_file($_FILES["inputImg"]['tmp_name'], $inputImg); 
            $updateSql = "update weeklyreport set goodEvaluation = '$good', badEvaluation = '$bad', score = $weeklyScore, image = '$inputImg'  where weeklyID = $weeklyID";
        
            
        }else {
            $updateSql = "update weeklyreport set goodEvaluation = '$good', badEvaluation = '$bad', score = $weeklyScore where weeklyID = $weeklyID";
        
            
        }
        echo $updateSql;
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