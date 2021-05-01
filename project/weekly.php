<head>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>


</head>

<div class="main col-md-8 col-md-offset-2">
    <div class="container col-md-10" id="weekButton">
        <a class="glyphicon glyphicon-remove-circle" aria-hidden="true"></a>
        <a class="glyphicon glyphicon-ok-circle" aria-hidden="true" onclick="document.getElementById('weeklyform').submit();"></a>
    </div>
    <?php 
        include "db/dbconn.php";
        
        if(isset($_GET['weeklyID'])) $weeklyID = $_GET['weeklyID'];
        $selectWeeklySql = "select * from WeeklyReport where weeklyID = $weeklyID";
        $weeklyResult = mysqli_query($conn,$selectWeeklySql);
        $weeklyRow = mysqli_fetch_array($weeklyResult, MYSQLI_ASSOC);
        if($weeklyRow){

            
            $good = $weeklyRow['goodEvaluation'];
            $bad = $weeklyRow['badEvaluation'];
            $score = $weeklyRow['score'];
            $date = $weeklyRow['date'];

            $month = date("m",strtotime($date));
            $year = date("Y",strtotime($date));
            $day = date("d",strtotime($date));
            
            if($weeklyRow['image'] != null){
                $image = $weeklyRow['image'];
            }else{
                $image = "img/logoRail.jpg";
            }
            

        
?>
    <form action="adminWeekly.php?mode=2" method="POST" id="weeklyform" enctype="multipart/form-data">

        <div class="container col-md-12">
            <row>
                <div id="calender" class="col-md-3">
                    <div class="year-month"></div>
                    <div class="dates"></div>
                </div>
                <div id="image" class="col-md-3">
                    <input type="file" name="inputImg" id = "inputImg" style='display: none;' accept="image/*">
                    <img src='<?=$image?>' width="180px"height="180px" id = 'weeklyImg' onclick='document.all.inputImg.click();'>


                </div>

                <div id="score" class="col-md-3">
                    <span class="mScore">이번 주 나의 점수
                        <input type="text" name="weeklyScore" value="<?=$score?>">
                        점</span>

                </div>

            </row>
        </div>
        <div class="container col-md-9">
            <canvas id="myChart"></canvas>
        </div>
        <div class="container writeEval col-md-10">
            <row>
                <div id="good" class="col-md-5">
                    <p>칭찬</p>
                    <textarea name="good"><?=$good?></textarea>
                </div>
                <div id="bad" class="col-md-5">
                    <p>반성</p>
                    <textarea name="bad"><?=$bad?></textarea>
                </div>
            </row>
        </div>
        <div class = "container selectFail col-md-10">
            <!--이름 복잡해서 테이블 만들거임 무슨 영어공부 하는 줄 알았네-->
            <label for="mobileGame"><input type="checkbox" id="mobileGame" value="mobileGame">핸드폰 게임</label> 
            <label for="onlineBroadcast"><input type="checkbox" id="onlineBroadcast" value="onlineBroadcast">인터넷방송 시청</label> 
            <label for="outsideActivity"><input type="checkbox" id="outsideActivity" value="outsideActivity">야외 활동</label> 
            <label for="unreasonablePlan"><input type="checkbox" id="unreasonablePlan" value="unreasonablePlan">무리한 계획</label> 
            <label for="youtube"><input type="checkbox" id="youtube" value="youtube">유튜브</label> 
            <label for="PCgame"><input type="checkbox" id="PCgame" value="PCgame">PC 게임</label> 
            <label for="drinking"><input type="checkbox" id="drinking" value="drinking">음주</label> 
            <label for="unscheduled"><input type="checkbox" id="unscheduled" value="unscheduled">예정에 없던 외출</label> 
            <label for="TV"><input type="checkbox" id="TV" value="TV">TV 시청</label> 
            <label for="sleep"><input type="checkbox" id="sleep" value="sleep">수면</label> 
            <label for="accident"><input type="checkbox" id="accident" value="accident">사고</label> 
            <label for="OTT"><input type="checkbox" id="OTT" value="OTT">넷플릭스/왓챠</label> 
            <label for="SNS"><input type="checkbox" id="SNS" value="SNS">SNS</label> 
            <label for="lackOfAbility"><input type="checkbox" id="lackOfAbility" value="lackOfAbility">능력 부족</label> 
            <label for="lackOfConcentration"><input type="checkbox" id="lackOfConcentration" value="lackOfConcentration">집중력 부족</label> 
            <label for="sick"><input type="checkbox" id="sick" value="sick">아픔</label> 
        
        
        </div>
        <input type="hidden" name="weeklyID" value="<?=$weeklyID?>">
    </form>
</div>

<?php 
        $achieveDayofWeekSql = "select * from weekly_achievedayofweek where weeklyID = $weeklyID order by goalID ASC";
    
        $dayofweekResult = mysqli_query($conn,$achieveDayofWeekSql);
        while($dayofweekRow = mysqli_fetch_array($dayofweekResult,MYSQLI_ASSOC)){
            $dayofweekGoalID = $dayofweekRow['goalID'];
            $achieveDayofWeek = $dayofweekRow['achieveDayofWeek'];
            $achieveDayofWeek = explode(';',$achieveDayofWeek);
            if(isset($goalIDArr)){
                if(!in_array($dayofweekGoalID,$goalIDArr)){
                    $goalIDArr[count($goalIDArr)] = $dayofweekGoalID;
                }
            }else{
                $goalIDArr[0] = $dayofweekGoalID;
                
            }
            for($i = 0; $i <7; $i++){
                
                if(isset($dayofweek[$dayofweekGoalID])){
                    $dayofweek[$dayofweekGoalID] = "$dayofweek[$dayofweekGoalID],$achieveDayofWeek[$i]";
                    
                }else {
                   $dayofweek[$dayofweekGoalID] = "$achieveDayofWeek[$i]";
                }
                                
            } 
            $selectRoutineSql = "select color from routine where goalID = $dayofweekGoalID";
            $routineRow = mysqli_fetch_array(mysqli_query($conn,$selectRoutineSql),MYSQLI_ASSOC);
            

            $goalColor[$dayofweekGoalID] = $routineRow['color'];
        }
?>
<script>
    var chBar = document.getElementById("myChart");
    var chartData = {
        labels: ["일", "월", "화", "수", "목", "금", "토"],
        datasets: [
            <?php 
            
                $dayofweekGoalIDCount = count($goalIDArr);
                for($i=0;$i<$dayofweekGoalIDCount;$i++){
                    $goalID = $goalIDArr[$i];
                
                   echo " {
                        data: [$dayofweek[$goalID]],
                        backgroundColor: '$goalColor[$goalID]'

                    },";
            }
              
                ?>
            
            
            
        ],
        
        
    };
    var myChart = new Chart(chBar, { // 챠트 종류를 선택 
        type: 'bar', // 챠트를 그릴 데이타 
        data: chartData, // 옵션 
        options: {
            legend: {
                display: false
            },
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true,
                        stepSize : 20
					
					}
				}]
			}
        }
    });

    const date = new Date();

    const viewYear = <?=$year?>;
    const viewMonth = <?=$month?> - 1;

    document.querySelector('.year-month').textContent = `${viewMonth + 1}月`;
    const prevLast = new Date(viewYear, viewMonth, 0);
    const thisLast = new Date(viewYear, viewMonth + 1, 0);

    const PLDate = prevLast.getDate();
    const PLDay = prevLast.getDay();

    const TLDate = thisLast.getDate();
    const TLDay = thisLast.getDay();

    const prevDates = [];
    const thisDates = [...Array(TLDate + 1).keys()].slice(1);
    const nextDates = [];



    if (PLDay !== 6) {
        for (let i = 0; i < PLDay + 1; i++) {
            prevDates.unshift(PLDate - i);
        }
    }

    for (let i = 1; i < 7 - TLDay; i++) {
        nextDates.push(i);
    }

    const dates = prevDates.concat(thisDates, nextDates);

    dates.forEach((date, i) => {
        dates[i] = `<div class="date">${date}</div>`;
    })

    document.querySelector('.dates').innerHTML = dates.join('');



    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#weeklyImg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(":input[name='inputImg']").change(function() {
        if ($(":input[name='inputImg']").val() == '') {
            $('#weeklyImg').attr('src', 'img/logoRail.jpg');
        }
        $('#image').css({
            'display': ''
        });
        readURL(this);
    });

    function imgAreaError() {
        $('#image').css({
            'display': 'none'
        });
    }
    
    
</script>

<?php }?>




