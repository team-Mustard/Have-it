<?php 
session_start();
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
include "db/dbconn.php";
$userid = 1;
//$today = date("Y-m-d");
$today = '2021-04-01';
$year = date("Y",strtotime($today));
$month = 4;
$day = 1;


$preLastDay = date('t',mktime(0,0,1,$month-1,$day,$year));
$preMonth = $month -1;
$preLastWeek = toWeekNum($year,$preMonth,$preLastDay);

$startTerm = date('Y-m-d',mktime(0,0,0,$month-1,1,$year));
$endTerm = date('Y-m-d', mktime(0,0,0,$month-1,$preLastDay,$year));


function toWeekNum($get_year, $get_month, $get_day){
 $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
 $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
 return ceil(($w + date('j',$timestamp) - 1)/7);
}



$insertMonthlySql = "insert into monthlyreport(date,userID) values('$today',$userid)";
mysqli_query($conn,$insertMonthlySql);
$selectMonthlySql = "select monthlyID from monthlyReport where date = '$today'";

$monthlyResult = mysqli_query($conn,$selectMonthlySql);
$monthlyRow = mysqli_fetch_array($monthlyResult,MYSQLI_ASSOC);

$monthlyID = $monthlyRow['monthlyID'];
    


$trackerSql = "select * from timetracker where userID = $userid and date(date) between '$startTerm' and '$endTerm'";


$trackerResult = mysqli_query($conn,$trackerSql);

if($trackerResult){
    while($trackerRow = mysqli_fetch_array($trackerResult, MYSQLI_ASSOC)){
        $trackerID = $trackerRow['trackerID'];
        $t_routineSql = "select * from t_routine where trackerID = $trackerID";
        $t_routineResult = mysqli_query($conn,$t_routineSql);
        $preRoutineID = 0;
        while($t_routineRow = mysqli_fetch_array($t_routineResult, MYSQLI_ASSOC)){
            
            $routineID = $t_routineRow['routineID'];
            $checkRoutine = $t_routineRow['checkRoutine'];
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
            
            if(isset($routineIDArr)){
                if(!in_array($routineID,$routineIDArr)){
                    $routineIDArr[count($routineIDArr)] = $routineID;
                }
            }else{
                $routineIDArr[0] = $routineID;
            }
            
           
            $t_routineDatetime = $t_routineRow['datetime'];
            $hour = date('G',strtotime($t_routineDatetime));
            $month = date('m',strtotime($t_routineDatetime));
            $year = date('Y',strtotime($t_routineDatetime));
            $day = date('d',strtotime($t_routineDatetime));
            $week = toWeekNum($year,$month,$day);
            $dayofweek = date('w',strtotime($t_routineDatetime));
            
            if($preRoutineID != $routineID){
                //시간
                if(isset($countHour[$hour][$goalID])){
                    $countHour[$hour][$goalID]++;

                }else{
                    $countHour[$hour][$goalID] = 1;                   
                 }
                //주차
                if(isset($countWeek[$week][$goalID])){
                    $countWeek[$week][$goalID]++;
                }else{
                    $countWeek[$week][$goalID] = 1;
                }
                //요일
                if(isset($countDayWeek[$dayofweek][$goalID])){
                    $countDayWeek[$dayofweek][$goalID]++;
                }else{
                    $countDayWeek[$dayofweek][$goalID] = 1;
                }
                //루틴 성취도
                if(isset($countRoutine[$routineID])){
                    $countRoutine[$routineID]++;                   
                }else {
                    $countRoutine[$routineID] = 1;
                }
                
                if($checkRoutine != 0){
                    //시간
                    if(isset($countCheckHour[$hour][$goalID])){
                        $countCheckHour[$hour][$goalID]++;

                    }else{
                        $countCheckHour[$hour][$goalID] = 1;                   
                     }
                    //주차
                    if(isset($countCheckWeek[$week][$goalID])){
                        $countCheckWeek[$week][$goalID]++;
                    }else{
                        $countCheckWeek[$week][$goalID] = 1;
                    }
                    //요일
                    if(isset($countCheckDayWeek[$dayofweek][$goalID])){
                        $countCheckDayWeek[$dayofweek][$goalID]++;
                    }else{
                        $countCheckDayWeek[$dayofweek][$goalID] = 1;
                    }
                    //루틴
                    if(isset($countCheckRoutine[$routineID])){
                        $countCheckRoutine[$routineID]++;
                    }else
                    {
                        $countCheckRoutine[$routineID] = 1;
                    }

                }
                
                
            }
            
            $preRoutineID = $routineID;
        }
        
        
    }
}



$goalIDCount = count($goalIDArr);
$routineIDCount = count($routineIDArr);

for($w=0;$w<$goalIDCount;$w++){
    $goalID = $goalIDArr[$w];
    $hourAchieve = null;
    $weekAchieve = null;
    $dayweekAchieve = null;
    for($i = 0;$i<24;$i++){
        if(isset($countHour[$i][$goalID])){
            if(isset($countCheckHour[$i][$goalID])){
                $hourPercent = round($countCheckHour[$i][$goalID] / $countHour[$i][$goalID] * 100 ,1);
                
            }else{
                $hourPercent = 0;
                
            }   
        }else{
                $hourPercent = 0;
                
        }  
        
        if($hourAchieve != null){
            $hourAchieve = "$hourAchieve;$hourPercent";
        }else{

            $hourAchieve = "$hourPercent";
        }
    }
    
    for($i=1;$i<$preLastWeek+1; $i++){
        if(isset($countWeek[$i][$goalID])){
            if(isset($countCheckWeek[$i][$goalID])){
                $weekPercent = round($countCheckWeek[$i][$goalID] / $countWeek[$i][$goalID] * 100 ,1);
                
            }else{
                $weekPercent = 0;
                
            }   
        }else{
                $weekPercent = 0;
                
        }  
        
        if($weekAchieve != null){
            $weekAchieve = "$weekAchieve;$weekPercent";
        }else{

            $weekAchieve = "$weekPercent";
        }
        
    }
    for($i=0;$i<7;$i++){
        if(isset($countDayWeek[$i][$goalID])){
            if(isset($countCheckDayWeek[$i][$goalID])){
                $dayweekPercent = round($countCheckDayWeek[$i][$goalID] / $countDayWeek[$i][$goalID] * 100 ,1);
                
            }else{
                $dayweekPercent = 0;
                
            }   
        }else{
                $dayweekPercent = 0;
                
        }  
        
        if($dayweekAchieve != null){
            $dayweekAchieve = "$dayweekAchieve;$dayweekPercent";
        }else{

            $dayweekAchieve = "$dayweekPercent";
        }
        
    }
    echo "목표 $goalID 의 성취도 <br><br>$hourAchieve <br> $weekAchieve <br> $dayweekAchieve <br><br>";
    
    $achieveTimeSql = "insert into achieve_time(goalID,monthlyID,achieveTime)
                        values($goalID,$monthlyID,'$hourAchieve')";
    $achieveWeekSql = "insert into achieve_week(goalID,monthlyID,achieveWeek)
                        values($goalID,$monthlyID,'$weekAchieve')";
    $achieveDayWeekSql = "insert into achieve_dayweek(goalID,monthlyID,achieveDayWeek)
                        values($goalID,$monthlyID,'$dayweekAchieve')";
    mysqli_query($conn, $achieveTimeSql);
    mysqli_query($conn, $achieveWeekSql);
    mysqli_query($conn, $achieveDayWeekSql);

}

for($z = 0; $z < $routineIDCount; $z++){
    
    $routineID = $routineIDArr[$z];
    $routineAchieve[$routineID] = round($countCheckRoutine[$routineID] / $countRoutine[$routineID] * 100,1);
    echo $routineAchieve[$routineID];
    echo "<br>";
        
}

$highestRoutine = max($routineAchieve);
$highestRoutineID = array_search($highestRoutine,$routineAchieve);

$lowestRoutine = min($routineAchieve);
$lowestRoutineID = array_search($lowestRoutine,$routineAchieve);

$SaveHighest = "$highestRoutineID;$countRoutine[$highestRoutineID];$countCheckRoutine[$highestRoutineID]";
$SaveLowest = "$lowestRoutineID;$countRoutine[$lowestRoutineID];$countCheckRoutine[$lowestRoutineID]";


echo "<br><br>$highestRoutineID = $highestRoutine<br>$lowestRoutineID = $lowestRoutine";
echo "<br>$SaveHighest<br>$SaveLowest";



$updateMonthlySql = "update monthlyreport set lowestRoutine = '$SaveLowest', highestRoutine = '$SaveHighest' where monthlyID = $monthlyID";

mysqli_query($conn, $updateMonthlySql);

function pp($v){
	echo "<xmp>";
	print_r($v);
	echo "</xmp><br>";
}
mysqli_close($conn);
echo "<br><br>시간 총 루틴";
pp($countHour);
echo "시간 체크 루틴<br>";
pp($countCheckHour);
echo "주 총 루틴";
pp($countWeek);
echo "주 체크 루틴<br>";
pp($countCheckWeek);
echo "요일 총 루틴";
pp($countDayWeek);
echo "요일 체크 루틴<br>";
pp($countCheckDayWeek);
echo "총 루틴 개수<br>";
pp($countRoutine);
echo "총 체크 루틴 개수<br>";
pp($countCheckRoutine);





?>