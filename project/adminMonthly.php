<?php 
session_start();
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
include "db/dbconn.php";
$userid = 1;
//$today = date("Y-m-d");
$today = '2021-06-01';
$year = date("Y",strtotime($today));
$month = date("m",strtotime($today));
$day = date("d",strtotime($today));


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
$selectMonthlySql = "select monthlyID from monthlyReport where date = '$today' and userid = $userid";

$monthlyResult = mysqli_query($conn,$selectMonthlySql);
$monthlyRow = mysqli_fetch_array($monthlyResult,MYSQLI_ASSOC);

$monthlyID = $monthlyRow['monthlyID'];
    


$trackerSql = "select * from timetracker where userID = $userid and date(date) between '$startTerm' and '$endTerm'";


$trackerResult = mysqli_query($conn,$trackerSql);
$totalAchieve = 0;
$totalCheckAchieve = 0;
if($trackerResult){
    while($trackerRow = mysqli_fetch_array($trackerResult, MYSQLI_ASSOC)){
        $trackerID = $trackerRow['trackerID'];
        $trackerDate = $trackerRow['date'];
        $t_routineSql = "select * from t_routine where trackerID = $trackerID";
        $t_routineResult = mysqli_query($conn,$t_routineSql);
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
            
           
            
            $t_routineStartTime = $t_routineRow['startTime'];
            $t_routineEndTime = $t_routineRow['endTime'];
            $month = date('m',strtotime($trackerDate));
            $year = date('Y',strtotime($trackerDate));
            $day = date('d',strtotime($trackerDate));
            $week = toWeekNum($year,$month,$day);
            $dayofweek = date('w',strtotime($trackerDate));
            $startHour = date('G',strtotime($t_routineStartTime));
            $endHour = date('G',strtotime($t_routineEndTime));
            $endMinute = date('i',strtotime($t_routineEndTime));
            //시간
            if($startHour == $endHour){
                if(isset($countHour[$startHour][$goalID])){
                     $countHour[$startHour][$goalID]++;

                }else{
                    $countHour[$startHour][$goalID] = 1;                   
                }
                       
             }else {
                for($z=0;$z<=$endHour - $startHour;$z++){
                    if(($z == $endHour - $startHour) && $endMinute == 0){
                        break;
                    }
                    
                    if(isset($countHour[$startHour+$z][$goalID])){
                        $countHour[$startHour+$z][$goalID]++;

                    }else{
                        $countHour[$startHour+$z][$goalID] = 1;                   
                    } 

                }

      
            }   
            
            $totalAchieve++;
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
                $totalCheckAchieve++;
                if($startHour == $endHour){
                    if(isset($countCheckHour[$startHour][$goalID])){
                        $countCheckHour[$startHour][$goalID]++;

                    }else{
                        $countCheckHour[$startHour][$goalID] = 1;                   
                    }
                    
                }
                else {
                    for($z=0;$z<=$endHour - $startHour;$z++){
                        if(($z == $endHour - $startHour) && $endMinute == 0){                         
                            break;
                    }
                        if(isset($countCheckHour[$startHour+$z][$goalID])){              
                            $countCheckHour[$startHour+$z][$goalID]++;     
                        }else{                     
                            $countCheckHour[$startHour+$z][$goalID] = 1;                               
                        } 
                    }    
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
    
    $achieveTimeSql = "insert into monthly_achieve_Time(goalID,monthlyID,achieveTime)
                        values($goalID,$monthlyID,'$hourAchieve')";
    $achieveWeekSql = "insert into monthly_achieve_Week(goalID,monthlyID,achieveWeek)
                        values($goalID,$monthlyID,'$weekAchieve')";
    $achieveDayWeekSql = "insert into monthly_achieve_Dayofweek(goalID,monthlyID,achieveDayofWeek)
                        values($goalID,$monthlyID,'$dayweekAchieve')";
    mysqli_query($conn, $achieveTimeSql);
    mysqli_query($conn, $achieveWeekSql);
    mysqli_query($conn, $achieveDayWeekSql);

}

for($z = 0; $z < $routineIDCount; $z++){
    
    $routineID = $routineIDArr[$z];
    $routineAchieve[$routineID] = round($countCheckRoutine[$routineID] / $countRoutine[$routineID] * 100,1);
  
        
}

$highestRoutine = max($routineAchieve);
$highestRoutineID = array_search($highestRoutine,$routineAchieve);

$lowestRoutine = min($routineAchieve);
$lowestRoutineID = array_search($lowestRoutine,$routineAchieve);

$SaveHighest = "$highestRoutineID;$countRoutine[$highestRoutineID];$countCheckRoutine[$highestRoutineID]";
$SaveLowest = "$lowestRoutineID;$countRoutine[$lowestRoutineID];$countCheckRoutine[$lowestRoutineID]";



$failureSql  = "select * from weeklyReport where userID = $userid and date(date) between '$startTerm' and '$endTerm'";

$failResult = mysqli_query($conn,$failureSql);

while($failRow = mysqli_fetch_array($failResult,MYSQLI_ASSOC)){
    
    
    $failure = $failRow['weekly_failure'];
    $failure = explode(';',$failure);

    for($i=0;$i<count($failure);$i++){
        
        $tmp = $failure[$i];
        if(isset($failureArr)){      
            if(!in_array($tmp,$failureArr)){                   
                $failureArr[count($failureArr)] = $tmp;          
            }         
        }else{         
            $failureArr[0] = $tmp;
        }
        
        
        if(isset($countFailure[$tmp])){
            $countFailure[$tmp]++;
        }else{
            $countFailure[$tmp] = 1;
        }
        
    }
    
    
    
    
    
}
$inputFail = null;
for($z=0;$z<count($failureArr);$z++){
        
        $failureID = $failureArr[$z];
        if($failureID !=null){
        
            if($inputFail !=null){
               $inputFail = "$inputFail;$failureID-$countFailure[$failureID]";
   
            }else{
            
        
                $inputFail = "$failureID-$countFailure[$failureID]";
      
            }
 
        }
   
}
    
$insertTotal = round($totalCheckAchieve / $totalAchieve * 100,3);

$updateMonthlySql = "update monthlyreport set lowestRoutine = '$SaveLowest', highestRoutine = '$SaveHighest', monthly_failure = '$inputFail',totalAchieve = $insertTotal where monthlyID = $monthlyID";



mysqli_query($conn, $updateMonthlySql);

mysqli_close($conn);
echo ("
                <script>
                    history.back();
                </script>
        ");
echo $achieveTimeSql;
echo "<br>";
echo $achieveWeekSql;
echo "<br>";
echo $achieveDayWeekSql;
echo "<br>";
echo $updateMonthlySql;
echo "<br>";
echo $failureSql;


function pp($v){
	echo "<xmp>";
	print_r($v);
	echo "</xmp><br>";
}

/*
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
*/




?>