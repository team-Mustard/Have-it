<?php

session_start();
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
if(isset($_GET['mode'])) $mode = $_GET['mode'];
include "db/dbconn.php";
switch($mode){
        
    case 1:{
        $today = date("Y-m-d");

        /*
        $year = date("Y",strtotime($today));
        $month = date("m",strtotime($today));
        $day = date("d",strtotime($today));
        */

        $year = date("Y",strtotime($today));
        $month =3;
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
                        if($t_routineRow['routineID']!=$preRoutineID)
                        {
                            $allRoutine++;
                            if($t_routineRow['checkRoutine'] == 1){
                                $successRoutine++;

                        }
                            $preRoutineID = $t_routineRow['routineID'];

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
        echo "$achieveRoutine <br>";
        $insertSql = "insert into WeeklyReport (userID, date, routineAchieve) 
                    values($userid,'$today','$achieveRoutine')";

        //mysqli_query($conn, $insertSql);
        //mysqli_close($conn);

        
        
    }
    case 2:{
        
        if(isset($_POST['weeklyScore'])) $weeklyScore = $_POST['weeklyScore'];
        if(isset($_POST['good'])) $good = $_POST['good'];
        if(isset($_POST['bad'])) $bad = $_POST['bad'];
        if(isset($_POST['weeklyID'])) $weeklyID = $_POST['weeklyID'];
        $updateSql = "update weeklyreport set goodEvaluation = '$good', badEvaluation = '$bad', score = $weeklyScore where weeklyID = $weeklyID";
        
        mysqli_query($conn, $updateSql);
        mysqli_close($conn);
        
        echo ("
                <script>
                    alert('수정이 완료되었습니다');
                    history.back();
                </script>
        ");
        
        
    }
}




?>