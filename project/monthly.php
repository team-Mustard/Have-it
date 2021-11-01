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
        $month = date("n",strtotime($monthlyDate));
        $preMonth = $month -1;
        $highestRoutine = $monthlyRow['highestRoutine'];
        $lowestRoutine = $monthlyRow['lowestRoutine'];
        $monthlyTotalAchieve = $monthlyRow['totalAchieve'];
        $highestRoutine = explode(';',$highestRoutine);
        $lowestRoutine = explode(';',$lowestRoutine);
        $routineKind = $monthlyRow['routineKind'];
        
        
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
        
        $achieveTimeSql = "select * from monthly_achieve_time where monthlyID = $monthlyID order by goalID ASC";
        $achieveWeekSql = "select * from monthly_achieve_week where monthlyID = $monthlyID order by goalID ASC";
        $achieveDayofWeekSql = "select * from monthly_achieve_dayofweek where monthlyID = $monthlyID order by goalID ASC";
        $timeResult = mysqli_query($conn, $achieveTimeSql);
        $weekResult = mysqli_query($conn,$achieveWeekSql);
        $dayofweekResult = mysqli_query($conn,$achieveDayofWeekSql);
        while($timeRow = mysqli_fetch_array($timeResult,MYSQLI_ASSOC)){
            
            if($timeRow['goalID']){
                
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
        }
        while($weekRow = mysqli_fetch_array($weekResult,MYSQLI_ASSOC)){
            
            if($weekRow['goalID']){
                
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
            
            
            
        }
        while($dayofweekRow = mysqli_fetch_array($dayofweekResult,MYSQLI_ASSOC)){
            
            if($dayofweekRow['goalID']){
                
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
            $grade = round(100 - ((($countReport -$rank) +($sameRank/2)) / $countReport * 100),1);
            //$grade = (($rank / ($countReport))*100);
            
        }else {
            $grade = 0;
        }
    ?>
    <div class="col-md-1"></div>
    <div class="main col-md-8 col-md-offset-2">
        <div class="monthlyTop" style="display:grid;">
            <div class="monthlyName">
                <b style="font-size:25px; text-align:center; float:left;"><?=$preMonth?>월 품질 보증서</b>
            </div>
        </div>
        <hr style="border:0; height:3px; background: #04005E;">
        <div class="clear"></div>
        
        <div class="container text-center col-md-12">
            <div class="col-md-1"></div>
            <div id="grade">
                <p class="gradetitle">이번 달 나의 등급</p>
                <span class="gradeprint">상위 <?=$grade?>%</span>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class= "col-md-12 monthlyContent" style="margin: 0 auto;">
            <div class="col-md-1"></div>
            <div class="addedRoutine col-md-5">
                <p style="text-align:center; font-size:18px;">이번 달 수행한 루틴</p>
                <canvas id="addedRoutineChart" width="400" height="200"style="margin: 0 auto;"></canvas>
            </div>
            <div class="totalAchievement col-md-5">
                <p style="text-align:center; font-size:18px;">이번 달 총 성취도</p>
                <canvas id="totalAchievementChart"width="350" height="200"style="margin: 0 auto;"></canvas>
            </div>
            <div class="col-md-1"></div>
                    
        </div>
        
        
        <div class="col-md-1"></div>
        <div id="routineChartBtn" class="col-md-10">
            <br>
            <b style="font-size: 18px;"> 시간/주차/요일 목표 성취도</b>
            <br>
            <div style="float:right;">
            <a onclick="showRoutineTime();">시간</a>
            <span>|</span>
            <a onclick="showRoutineWeek();">주차</a>
            <span>|</span>
            <a onclick="showRoutineDayofweek();">요일</a>
            </div>
        </div>
        
        <div class="col-md-1"></div>
        <div id="routineChart" class="col-md-10">
            <canvas id="monthlyChart"></canvas>
        </div>
        <div class="container col-md-12">
            <row>
                <div class="col-md-1"></div>
                <div id="fail" class="col-md-5">
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
                <div id="success" class="col-md-5">
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
                    if(isset($highestRow)){
            
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
                <div class="col-md-1"></div>
            </row>
        </div>
        <div class="col-md-1"></div>
        <div id="failureChart" class="col-md-10">
            <h4 style="text-align:center;">실패 원인 분석</h4>
            <canvas id="mChartFailure" width="300" height="300"></canvas>
            <div id='customLegend' class="customLegend"></div>
        </div>
        <div class="col-md-1"></div>
        
        <div id="monthChart" class="col-md-12">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h4 style="text-align:right;">5달간 성취도 추이</h4>
                <canvas id="mChartMonth"></canvas>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="col-md-1"></div>
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
                    $goalSql = "select goalName from goal where goalID=$goalID"; $goalRow=mysqli_fetch_array(mysqli_query($conn,$goalSql));
                    $goalName = $goalRow['goalName'];
                
               echo " {
                    label:['$goalName'],
                    data: [$hour[$goalID]],
                    backgroundColor: '$timeGoalColor[$goalID]'
                },";
            }
              
                ?>


            ]
        },

        options: {
            legend: {
                display: true,
                position: 'right'
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
                    $goalSql = "select goalName from goal where goalID=$goalID"; $goalRow=mysqli_fetch_array(mysqli_query($conn,$goalSql));
                    $goalName = $goalRow['goalName'];

                   echo "{
                        label: ['$goalName'],
                        data: [$week[$goalID]],
                        backgroundColor: '$weekGoalColor[$goalID]'
                    },";
            }
              
                ?>
                ]
            },

            options: {
                legend: {
                    display: true,
                    position: 'right'
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
                    $goalSql = "select goalName from goal where goalID=$goalID"; $goalRow=mysqli_fetch_array(mysqli_query($conn,$goalSql));
                    $goalName = $goalRow['goalName'];
                
               echo " {
                    label:['$goalName'],
                    data: [$dayofweek[$goalID]],
                    backgroundColor: '$dayofweekGoalColor[$goalID]'
                },";
            }
              
                ?>
                ]
            },

            options: {
                legend: {
                    display: true,
                    position: 'right'
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

                display: false

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
    
        $addedRoutineName = null;
        $addedRoutineColor = null;
        $addedRoutineCnt = null;
        $routineKind = explode(';',$routineKind);
        if($routineKind[0]){
            for($k=0;$k<count($routineKind);$k++){
                $routinetmp = explode('-',$routineKind[$k]);
                $addedRoutineSql = "select color,routineName from routine where routineID = $routinetmp[0]";
                $addedRow = mysqli_fetch_array(mysqli_query($conn,$addedRoutineSql),MYSQLI_ASSOC);
                $addedRoutineName[$k] = $addedRow['routineName'];
                $addedRoutineColor[$k] = $addedRow['color'];
                $addedRoutineCnt[$k] = $routinetmp[1];

            }
            
        }




    
    

?>
    
    var ctxAdded = document.getElementById("addedRoutineChart");
    var addedRoutineData = { 
        type: 'doughnut',    
        data: {
            labels: [
                <?php 
                if($addedRoutineName){
                    for($w=0;$w<count($routineKind);$w++){
                            echo "'$addedRoutineName[$w]',";

                        }
                }else{
                    echo "\"데이터 없음\"";
                    
                }

            ?>
            ],

            datasets: [{
                <?php 
                    echo "data:[";
                    if($addedRoutineCnt){
                        for($i=0;$i<count($routineKind);$i++){
                                echo "$addedRoutineCnt[$i],";
                            }
                    }else{
                        echo "1";
                        
                    }
                    echo "],backgroundColor:[";
                    if($addedRoutineColor){
                        for($i= 0; $i<count($routineKind);$i++){
                            echo "'$addedRoutineColor[$i]',";
                        }

                    }else{
                        echo "\"#C2C7EB\"";
                        
                    }
                    echo "]";
            
            
            ?>
            }]},
        options: {
            responsive: false,
            legend: {

                display: true,
                position: 'right',

            },
            //legendCallback: customLegend,
        },
    }
    var addedRoutineChart = new Chart(ctxAdded, addedRoutineData); //document.getElementById('addedCustomLegend').innerHTML = window.addedRoutineChart.generateLegend();
    
    
    
    
    var ctxTotal = document.getElementById("totalAchievementChart");
    var totalAchievementData = {
        type: 'doughnut',
        data: {
            datasets: [{
            data: [
                <?php 
                    $monthlyTotalAchieve = round($monthlyTotalAchieve,1);
                    $monthlyTotalFail = 100 - $monthlyTotalAchieve;
                    echo "$monthlyTotalAchieve,$monthlyTotalFail";
                
                
                ?>],
            backgroundColor:['#BAE6E8','grey']
            }],

            labels: [
                
                '성공',
                '실패'
            ]
        },

        options: {
            legend:{
                display: false
            },
            responsive: false,
            elements: {
            center: {
              text: '<?=$monthlyTotalAchieve?>%',
              color: '#000000', // Default is #000000
              fontStyle: 'Arial', // Default is Arial
              sidePadding: 30, // Default is 20 (as a percentage)
              minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
              lineHeight: 25 // Default is 25 (in px), used for when text wraps
            }
          }

        },
    }
    var totalAchieveChart = new Chart(ctxTotal, totalAchievementData);
    
    
    Chart.pluginService.register({
      beforeDraw: function(chart) {
        if (totalAchieveChart.config.options.elements.center) {
          var ctx = totalAchieveChart.chart.ctx;

          var centerConfig = totalAchieveChart.config.options.elements.center;
          var fontStyle = centerConfig.fontStyle || 'Arial';
          var txt = centerConfig.text;
          var color = centerConfig.color || '#000';
          var maxFontSize = centerConfig.maxFontSize || 75;
          var sidePadding = centerConfig.sidePadding || 20;
          var sidePaddingCalculated = (sidePadding / 100) * (totalAchieveChart.innerRadius * 2)
          ctx.font = "40px " + fontStyle;

          var stringWidth = ctx.measureText(txt).width;
          var elementWidth = (totalAchieveChart.innerRadius * 2) - sidePaddingCalculated;

          var widthRatio = elementWidth / stringWidth;
          var newFontSize = Math.floor(30 * widthRatio);
          var elementHeight = (totalAchieveChart.innerRadius * 2);

          var fontSizeToUse = Math.min(newFontSize, elementHeight, maxFontSize);
          var minFontSize = centerConfig.minFontSize;
          var lineHeight = centerConfig.lineHeight || 25;
          var wrapText = false;

          if (minFontSize === undefined) {
            minFontSize = 20;
          }

          if (minFontSize && fontSizeToUse < minFontSize) {
            fontSizeToUse = minFontSize;
            wrapText = true;
          }

          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          var centerX = ((totalAchieveChart.chartArea.left + totalAchieveChart.chartArea.right) / 2);
          var centerY = ((totalAchieveChart.chartArea.top + totalAchieveChart.chartArea.bottom) / 2);
          ctx.font = fontSizeToUse + "px " + fontStyle;
          ctx.fillStyle = color;

          if (!wrapText) {
            ctx.fillText(txt, centerX, centerY);
            return;
          }

          var words = txt.split(' ');
          var line = '';
          var lines = [];

          for (var n = 0; n < words.length; n++) {
            var testLine = line + words[n] + ' ';
            var metrics = ctx.measureText(testLine);
            var testWidth = metrics.width;
            if (testWidth > elementWidth && n > 0) {
              lines.push(line);
              line = words[n] + ' ';
            } else {
              line = testLine;
            }
          }

          centerY -= (lines.length / 2) * lineHeight;

          for (var n = 0; n < lines.length; n++) {
            ctx.fillText(lines[n], centerX, centerY);
            centerY += lineHeight;
          }
          ctx.fillText(line, centerX, centerY);
        }
      }
});


    
    

</script>