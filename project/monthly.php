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
        $monthlyDate = $monthlyRow['date'];
        $highestRoutine = $monthlyRow['highestRoutine'];
        $lowestRoutine = $monthlyRow['lowestRoutine'];
        $monthlyTotalAchieve = $monthlyRow['totalAchieve'];
        $highestRoutine = explode(';',$highestRoutine);
        $lowestRoutine = explode(';',$lowestRoutine);
        
        $highestRoutineSql = "select routineName,goalID from routine where routineID = $highestRoutine[0]";
        
        $LowestRoutineSql = "select routineName,goalID from routine where routineID = $lowestRoutine[0]";
        
        $highestResult = mysqli_query($conn,$highestRoutineSql);
        $lowestResult = mysqli_query($conn,$LowestRoutineSql);
        if($highestResult){
            
            $highestRow = mysqli_fetch_array($highestResult,MYSQLI_ASSOC);
        }
        if($lowestResult){
            $lowestRow = mysqli_fetch_array($lowestResult,MYSQLI_ASSOC);
            
        }
        
        $achieveTimeSql = "select * from monthly_achieve_Time where monthlyID = $monthlyID order by goalID ASC";
        $achieveWeekSql = "select * from monthly_achieve_Week where monthlyID = $monthlyID order by goalID ASC";
        $achieveDayofWeekSql = "select * from monthly_achieve_Dayofweek where monthlyID = $monthlyID order by goalID ASC";
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
    
    
        $monthlySql2 = "select totalAchieve, monthlyID from monthlyReport where date = '$monthlyDate' order by totalAchieve DESC ";
        $monthlyResult2 = mysqli_query($conn,$monthlySql2);
        $countReport=0;
        $sameRank = 0;
        while($monthlyRow2 = mysqli_fetch_array($monthlyResult2,MYSQLI_ASSOC)){
            $countReport++;
            
            if($monthlyTotalAchieve == $monthlyRow2['totalAchieve'] && $monthlyID == $monthlyRow2['monthlyID']){
                $rank = $countReport;
            }
            if($monthlyTotalAchieve == $monthlyRow2['totalAchieve'] && $monthlyID != $monthlyRow2['monthlyID']){
                $sameRank++;
            }
        }
        if($countReport !=1){
            /*$grade = 100 - ((($countReport -$rank) +($sameRank/2))  / $countReport * 100);*/
            $grade = (($rank / ($countReport))*100);
            
        }else {
            $grade = 10;
        }
    ?>
    <div class="main col-md-8 col-md-offset-2">
        <div class="container text-center col-md-10">
            <div id="grade">
                <p class="gradetitle">이번 달 나의 등급</p>
                <span class="gradeprint">상위 <?=$grade?>%</span>
            </div>
        </div>
        <div id="routineChartBtn" class="container">
            <a onclick="showRoutineTime();">시간</a>
            <span>|</span>
            <a onclick="showRoutineWeek();">주차</a>
            <span>|</span>
            <a onclick="showRoutineDayofweek();">요일</a>
        </div>

        <div id="routineChart" class="container col-md-10">
            <canvas id="monthlyChart"></canvas>
        </div>
        <div class="container col-md-10">
            <row>
                <div id="fail" class="col-md-6">
                    <p>가장 실패율이 높은 루틴</p>
                    <p>"<?php
                            if(isset($lowestRow['routineName']))
                                echo $lowestRow['routineName'];
                            else
                                echo "no-data";
                            ?>"</p>
                    <p>
                        <?php
                            if(isset($lowestRoutine[2]))
                               echo $lowestRoutine[2];
                            else
                                echo "no-data";
                        ?>/<?php
                                if(isset($lowestRoutine[1]))
                                    echo $lowestRoutine[1];                
                                else
                                    echo "no-data";?></p>
                    <?php 
                    $today = date("Y-m-d");
                    if(isset($lowestRow)){
                        
                    $lowestGoalID =  $lowestRow['goalID'];
                    $selectGoalSql = "select startTerm, endTerm from goal where goalID = '$lowestGoalID'";
                               
                    $lowestGoalRow = mysqli_fetch_array(mysqli_query($conn,$selectGoalSql),MYSQLI_ASSOC);
                    $lowStartTerm = $lowestGoalRow['startTerm'];
                    $lowEndTerm = $lowestGoalRow['endTerm'];
        
        
                    if($today<$lowStartTerm || $today > $lowEndTerm) {
                        echo "<a href='#' onclick=\"alert('기간이 끝난 목표입니다.');\" return false;>루틴 바로가기</a>";


                    }else{

                         echo "<a href='?page=goal&goalID=$lowestGoalID'>루틴 바로가기</a>";

                    }

                        
                    }else {
                        
                         echo "<a href='#'>루틴 바로가기</a>";
                        
                        
                    }
                    
                    ?>


                </div>
                <div id="success" class="col-md-6">
                    <p>가장 성공률이 높은 루틴</p>
                    <p>"<?php
                            if(isset($highestRow['routineName'])){
                                echo $highestRow['routineName'];
                                
                                
                            }
        
        
                                
                            else
                                echo "no-data";
                            ?>"</p>
                    <p>
                        <?php
                            if(isset($highestRoutine[2]))
                               echo $highestRoutine[2];
                            else
                                echo "no-data";
                        ?>/<?php
        if(isset($highestRoutine[1]))
            echo $highestRoutine[1];                
        else
            echo "no-data";  
                        
                        
                        ?> </p>

                    <?php
                    if($highestRow){
            
                                $highestGoalID = $highestRow['goalID'];
                        
                                $selectGoalSql2 = "select startTerm, endTerm from goal where goalID = '$highestGoalID'"; 
                                $highestGoalRow = mysqli_fetch_array(mysqli_query($conn,$selectGoalSql2),MYSQLI_ASSOC);
                                
                                $highStartTerm = $highestGoalRow['startTerm'];
                                $highEndTerm = $highestGoalRow['endTerm'];
        
        
                    if($today<$highStartTerm || $today > $highEndTerm) {
                        echo "<a href='#' onclick=\"alert('기간이 끝난 목표입니다.');\" return false;>새로운 루틴 생성하기</a>";


                    }else{

                         echo "<a href='?page=goal&goalID=$highestGoalID'>새로운 루틴 생성하기</a>";

                    }
            
            
                    }else {
                        
                        echo "<a href=#'>새로운 루틴 생성하기</a>";
                        
                        }
                    
                    
                    ?>



                </div>
            </row>
        </div>

        <div id="failureChart" class="contatiner col-md-10">
            <h4 style="text-align:center;">실패 원인 분석</h4>
            <canvas id="mChartFailure" width="300" height="300"></canvas>
            <div id='customLegend' class="customLegend"></div>
        </div>
        <div id="monthChart" class="contatiner col-md-10">
            <h4 style="text-align:right;">5달간 성취도 추이</h4>
            <canvas id="mChartMonth"></canvas>
        </div>
    </div>


</body>

<script>
    <?php
    $timeGoalIDCount = 0;
    $weekGoalIDCount = 0;
    $dayofweekGoalIDCount = 0;
    if(isset($timeGoalIDArr))
        $timeGoalIDCount = count($timeGoalIDArr); 
    if(isset($weekGoalIDArr))
        $weekGoalIDCount = count($weekGoalIDArr);
    if(isset($dayofweekGoalIDArr))
        $dayofweekGoalIDCount = count($dayofweekGoalIDArr);
                
    
?>
    var chart = document.getElementById("routineChart");
    var ctxTime = document.getElementById("monthlyChart");
    var timeData = {
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
            legend: {
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
    var chartTime = new Chart(ctxTime, timeData);

    function showRoutineTime() {
        if (!document.getElementById('monthlyChart')) {
            chart.innerHTML = "<canvas id='mChartTime'></canvas>";
            var ctxTime = document.getElementById("mChartTime");
            var chartTime = new Chart(ctxTime, timeData);

        }


    }

    function showRoutineWeek() {
        chart.innerHTML = "<canvas id='mChartWeek'></canvas>";
        var ctxWeek = document.getElementById("mChartWeek");

        var weekData = {
            type: 'horizontalBar',
            data: {
                labels: [
                    <?php 
            if(isset($achieveWeek)){
            for($z=1;$z<=count($achieveWeek);$z++){
                echo "\"$z 주차\"";
                if($z!=count($achieveWeek)){
                    echo ",";
                }
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
              
                ?>
                ]
            },

            options: {
                legend: {
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
        var chartWeek = new Chart(ctxWeek, weekData);
    }

    function showRoutineDayofweek() {
        chart.innerHTML = "<canvas id='mChartDayofWeek'></canvas>";
        var ctxDayofWeek = document.getElementById("mChartDayofWeek");

        var dayofweekData = {
            type: 'horizontalBar',
            data: {
                labels: ["일", "월", "화", "수", "목", "금", "토"],

                datasets: [
                    <?php 
                for($i=0;$i<$dayofweekGoalIDCount;$i++){
                    $goalID = $dayofweekGoalIDArr[$i];
                
               echo " {
                    data: [$dayofweek[$goalID]],
                    backgroundColor: '$dayofweekGoalColor[$goalID]'
                },";
            }
              
                ?>
                ]
            },

            options: {
                legend: {
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
        var chartDayofWeek = new Chart(ctxDayofWeek, dayofweekData);
    }


    <?php
    $failList = ["핸드폰 게임","인터넷 방송","야외 활동","무리한 계획","유튜브","PC 게임","음주","예정에 없던 외출","TV 시청","수면","사고","넷플릭스/왓챠","SNS","능력 부족","집중력 부족","아픔"];
    
    $failure = $monthlyRow['monthly_failure'];
    $failure = explode(';',$failure);
    
    
?>
    var colorIndex = ["#C6E8BA", "#ADE3AB", "#9FB6DF", "#94DBC0", "#E4C9ED", "#BAE6E8", "#CCE3AB", "#EDD5C9", "#E1F4DD", "#D9F2F2", "#8C8FD9", "#EDDEC9", "#C2C7EB", "#C9EDE7", "#F4F6E4", "#ECF9F7"];
    var customLegend = function(chart) {
        var ul = document.createElement('ul');
        var color = chart.data.datasets[0].backgroundColor;

        chart.data.labels.forEach(function(label, index) {
            ul.innerHTML += `<li><span style="background-color: ${color[index]};"></span> ${label}</li>`;
        });

        return ul.outerHTML;
    };
    var ctxFailure = document.getElementById("mChartFailure");
    var randomcolor = "#" + Math.round(Math.random() * 0xffffff).toString(16);
    var failData = {
        type: 'pie',
        data: {
            labels: [
                <?php 
            for($z=0;$z<count($failure);$z++){
                if($failure[$z] != null){
                    
                $failtmp = explode('-',$failure[$z]);
                $failString = $failList[$failtmp[0]-1];
                echo "\"$failString\"";
                if($z!=count($failure)){
                    echo ",";
                }
 
                    
                }else {
                    
                    echo "\"데이터 없음\"";
                }
            }

            ?>


            ],

            datasets: [{
                <?php 
            
            echo "data:[";
            for($z=0;$z<count($failure);$z++){
                if($failure[$z]!=null){
                    
                    
                $failtmp = explode('-',$failure[$z]);
                echo "$failtmp[1]";
                if($z!=count($failure)){
                    echo ",";
                }
                    
                    
                }else{
                    
                    echo "1";
                    
                }
                
            }
            echo "],backgroundColor:[";
            for($w= 0; $w<count($failure);$w++){
                
                echo "colorIndex[$w]";
                
                if($w!=count($failure)){
                    echo ",";
                }

            }
        
        
            echo "]";
            
            
            ?>
            }]
        },

        options: {
            responsive: false,
            legend: {

                display: false,
                position: 'right'

            },
            legendCallback: customLegend,
        },
    }

    var chartFailure = new Chart(ctxFailure, failData);
    document.getElementById('customLegend').innerHTML = window.chartFailure.generateLegend();

    <?php

        $preMonth = strtotime($monthlyDate.'-5 month');
        $select5monthSql = "select * from monthlyReport where userID = $userid and date(date) between '$preMonth' and '$monthlyDate' order by date ASC";
        $monthResult = mysqli_query($conn,$select5monthSql);
        $countMonth = 0;
        while($monthRow = mysqli_fetch_array($monthResult,MYSQLI_ASSOC)){
            $month[$countMonth] = $monthRow['totalAchieve'];
            $monthDate[$countMonth] = $monthRow['date'];
            $countMonth++;
        }
        
    
?>

    var ctx5Month = document.getElementById("mChartMonth");
    var monthData = {
        type: 'line',
        data: {
            labels: [
                <?php 
            for($h=0;$h<$countMonth;$h++){
                $tmp = date('m',strtotime($monthDate[$h]));
                $tmp2 = preg_replace('/(0)(\d)/','$2', $tmp);
                echo "\"$tmp2 월\"";
                if($h!=$countMonth){
                    echo ",";
                }
 
            }

            ?>


            ],

            datasets: [{
                <?php 
        
            echo "data:[";
            for($q=0;$q<$countMonth;$q++){
                echo "\"$month[$q]\"";
                if($q!=$countMonth){
                    echo ",";
                }
                
            }
            echo "],";
        ;?>
                fill: false,
                lineTension: 0,
                borderColor: "#fc914c"
            }]
        },

        options: {

            legend: {

                display: false
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontSize: 18
                    },
                    gridLines: {
                        lineWidth: 2
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                        stepSize: 20,
                        fontSize: 18

                    },
                    gridLines: {
                        lineWidth: 2
                    }
                }]
            }

        },
    }
    var chartmonth = new Chart(ctx5Month, monthData);

    <?php 
    
    }    

?>

</script>
