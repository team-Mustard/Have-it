<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>

<body>
    
<?php 
    include "db/dbconn.php";
    if(isset($_GET['monthlyID'])) $monthlyID = $_GET['monthlyID'];

    $monthlySql = "select * from monthlyreport where monthlyID = $monthlyID";
    $monthlyResult = mysqli_query($conn, $monthlySql);
    $monthlyRow = mysqli_fetch_array($monthlyResult, MYSQLI_ASSOC);
    if($monthlyRow){
        $highestRoutine = $monthlyRow['highestRoutine'];
        $lowestRoutine = $monthlyRow['lowestRoutine'];
        
        $highestRoutine = explode(';',$highestRoutine);
        $lowestRoutine = explode(';',$lowestRoutine);
        
        $highestRoutineSql = "select routineName from routine where routineID = $highestRoutine[0]";
        
        $LowestRoutineSql = "select routineName from routine where routineID = $lowestRoutine[0]";
        
        $highestRow = mysqli_fetch_array(mysqli_query($conn,$highestRoutineSql),MYSQLI_ASSOC);
        
        $lowestRow = mysqli_fetch_array(mysqli_query($conn,$LowestRoutineSql),MYSQLI_ASSOC);
        
        $achieveTimeSql = "select * from monthly_achieveTime where monthlyID = $monthlyID order by goalID ASC";
        $achieveWeekSql = "select * from monthly_achieveWeek where monthlyID = $monthlyID order by goalID ASC";
        $achieveDayofWeekSql = "select * from monthly_achieveDayofweek where monthlyID = $monthlyID order by goalID ASC";
        $timeResult = mysqli_query($conn, $achieveTimeSql);
        $weekResult = mysqli_query($conn,$achieveWeekSql);
        $dayofweekResult = mysqli_query($conn,$achieveDayofWeekSql);
        while($timeRow = mysqli_fetch_array($timeResult,MYSQLI_ASSOC)){
            
            $timeGoalID = $timeRow['goalID'];
            $achieveTime = $timeRow['achieveTime'];
            $achieveTime = explode(';',$achieveTime);
            if(isset($timeGoalIDArr)){
                if(!in_array($timeGoalID,$timeGoalIDArr)){
                    $timeGoalIDArr[count($timeGoalIDArr)] = $timeGoalID;
                }
            }else{
                $timeGoalIDArr[0] = $timeGoalID;
                
            }
            for($i = 0; $i <24; $i++){
                
                if(isset($hour[$timeGoalID])){
                    $hour[$timeGoalID] = "$hour[$timeGoalID],$achieveTime[$i]";
                    
                }else {
                   $hour[$timeGoalID] = "$achieveTime[$i]";
                }
                                
            } 
            $selectRoutineSql = "select color from routine where goalID = $timeGoalID";
            $routineRow = mysqli_fetch_array(mysqli_query($conn,$selectRoutineSql),MYSQLI_ASSOC);
            
            $timeGoalColor[$timeGoalID] = $routineRow['color'];
        }
        while($weekRow = mysqli_fetch_array($weekResult,MYSQLI_ASSOC)){
            
            $weekGoalID = $weekRow['goalID'];
            $achieveWeek = $weekRow['achieveWeek'];
            $achieveWeek = explode(';',$achieveWeek);
            if(isset($weekGoalIDArr)){
                if(!in_array($weekGoalID,$weekGoalIDArr)){
                    $weekGoalIDArr[count($weekGoalIDArr)] = $weekGoalID;
                }
            }else{
                $weekGoalIDArr[0] = $weekGoalID;
            }
            for($i=0;$i < count($achieveWeek);$i++){
                
                if(isset($week[$weekGoalID])){
                    $week[$weekGoalID] = "$week[$weekGoalID],$achieveWeek[$i]";
                    
                }else {
                    $week[$weekGoalID] = "$achieveWeek[$i]";
                }
                
                
                $selectRoutineSql = "select color from routine where goalID = $weekGoalID";        
                $routineRow = mysqli_fetch_array(mysqli_query($conn,$selectRoutineSql),MYSQLI_ASSOC);  
                $weekGoalColor[$weekGoalID] = $routineRow['color'];
                
                
            }
            
            
            
        }
        while($dayofweekRow = mysqli_fetch_array($dayofweekResult,MYSQLI_ASSOC)){
            
            $dayofweekGoalID = $dayofweekRow['goalID'];
            $achieveDayofWeek = $dayofweekRow['achieveDayofWeek'];
            $achieveDayofWeek = explode(';',$achieveDayofWeek);
            if(isset($dayofweekGoalIDArr)){
                if(!in_array($dayofweekGoalID,$dayofweekGoalIDArr)){
                    $dayofweekGoalIDArr[count($dayofweekGoalIDArr)] = $dayofweekGoalID;
                }
            }else{
                $dayofweekGoalIDArr[0] = $dayofweekGoalID;
            }
            for($i=0;$i < 7;$i++){
                
                if(isset($dayofweek[$dayofweekGoalID])){
                    $dayofweek[$dayofweekGoalID] = "$dayofweek[$dayofweekGoalID],$achieveDayofWeek[$i]";
                    
                }else {
                    $dayofweek[$dayofweekGoalID] = "$achieveDayofWeek[$i]";
                }
                
                
                $selectRoutineSql = "select color from routine where goalID = $dayofweekGoalID";        
                $routineRow = mysqli_fetch_array(mysqli_query($conn,$selectRoutineSql),MYSQLI_ASSOC);  
                $dayofweekGoalColor[$dayofweekGoalID] = $routineRow['color'];
                
                
            }
            
            
            
        }
    
    
    ?>    
        
        

    <div class="main col-md-8 col-md-offset-2">
        <div class="container text-center col-md-10">
            <div id="grade">
                <p class="gradetitle">이번 달 나의 등급</p>
                <span class="gradeprint">상위 74%</span>
            </div>
        </div>
        <div id = "chartBtn" class="container">
            <a onclick="showRoutineTime();">시간</a>
            <a onclick="showRoutineWeek();">주차</a>
            <a onclick="showRoutineDayofweek();">요일</a>
        </div>
        
        <div id="chart" class="container col-md-10">
            <canvas id="monthlyChart"></canvas>
        </div>
        <div class="container col-md-10">
            <row>
                <div id="fail" class="col-md-6">
                    <p>가장 실패율이 높은 루틴</p>
                    <p>"<?=$lowestRow['routineName']?>"</p>
                    <p><?=$lowestRoutine[2]?>/<?=$lowestRoutine[1]?></p>
                    <button>루틴 바로가기</button>
                </div>
                <div id="success" class="col-md-6">
                    <p>가장 성공률이 높은 루틴</p>
                    <p>"<?=$highestRow['routineName']?>"</p>
                    <p><?=$highestRoutine[2]?>/<?=$highestRoutine[1]?></p>
                    <button>새로운 루틴 생성하기</button>
                </div>
            </row>
        </div>
    </div>


</body>
<?php 
    
    }    

?>
<script>


 <?php
    
     $timeGoalIDCount = count($timeGoalIDArr);   
     $weekGoalIDCount = count($weekGoalIDArr);
     $dayofweekGoalIDCount = count($dayofweekGoalIDArr);
                
    
?>   
var chart = document.getElementById("chart");

var ctxTime = document.getElementById("monthlyChart");
var timeData =
  {
    type: 'bar',
    data: {
        labels: [
            <?php
                for($w=1;$w<25;$w++){
                    echo "\"$w 시\"";
                    if($w !=24 ){
                        echo ",";
                    }
                }
            
            
            ?>
            
            
        ],
        
        datasets: [
            <?php 
                for($i=0;$i<$timeGoalIDCount;$i++){
                    $goalID = $timeGoalIDArr[$i];
                
               echo " {
                    data: [$hour[$goalID]],
                    backgroundColor: '$timeGoalColor[$goalID]'
                },";
            }
              
                ?>
            
            
        ]
    },
    
    options: {
        legend:{
            display: false
        },
        
        scales: {
        
          xAxes: [{
            stacked: true
          }],
          yAxes: [{
            stacked: true
          }],
        

        }
    },
}    
var chartTime = new Chart(ctxTime,timeData);
    
function showRoutineTime() {
    if(!document.getElementById('monthlyChart')){
        chart.innerHTML = "<canvas id='mChartTime'></canvas>";
        var ctxTime = document.getElementById("mChartTime");
        var chartTime = new Chart(ctxTime,timeData);
        
    }
    
      
}    
function showRoutineWeek(){
    chart.innerHTML = "<canvas id='mChartWeek'></canvas>";
    var ctxWeek = document.getElementById("mChartWeek");

    var weekData=
  {
    type: 'horizontalBar',
    data: {
        labels: [
            <?php 
            for($z=1;$z<=count($achieveWeek);$z++){
                echo "\"$z 주차\"";
                if($z!=count($achieveWeek)){
                    echo ",";
                }
                
            }

            ?>
            
            
        ],
        
        datasets: [
            <?php 
                for($i=0;$i<$weekGoalIDCount;$i++){
                    $goalID = $weekGoalIDArr[$i];
                
               echo "{
                    data: [$week[$goalID]],
                    backgroundColor: '$weekGoalColor[$goalID]'
                },";
            }
              
                ?>]
    },

    options: {
        legend:{
            display: false
        },
        
        scales: {
        
          xAxes: [{
            stacked: true
          }],
          yAxes: [{
            stacked: true
          }],
        

        }
    },
}
   var chartWeek = new Chart(ctxWeek,weekData);
}
function showRoutineDayofweek(){
    chart.innerHTML = "<canvas id='mChartDayofWeek'></canvas>";
    var ctxDayofWeek = document.getElementById("mChartDayofWeek");

    var dayofweekData=
  {
    type: 'horizontalBar',
    data: {
        labels: ["월", "화", "수", "목","금","토","일"],
        
        datasets: [
            <?php 
                for($i=0;$i<$dayofweekGoalIDCount;$i++){
                    $goalID = $dayofweekGoalIDArr[$i];
                
               echo " {
                    data: [$dayofweek[$goalID]],
                    backgroundColor: '$dayofweekGoalColor[$goalID]'

                },";
            }
              
                ?>]
    },

    options: {
        legend:{
            display: false
        },
        
        scales: {
        
          xAxes: [{
            stacked: true
          }],
          yAxes: [{
            stacked: true
          }],
        

        }
    },
}
   var chartDayofWeek = new Chart(ctxDayofWeek,dayofweekData);
}
    
</script>
