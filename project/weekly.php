<head>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<?php 
        include "db/dbconn.php";
        ini_set('error_reporting','E_ALL ^ E_NOTICE');
    
        if(isset($_GET['weeklyID'])) $weeklyID = $_GET['weeklyID'];
        $selectWeeklySql = "select * from WeeklyReport where weeklyID = $weeklyID";
        $weeklyResult = mysqli_query($conn,$selectWeeklySql);
        $weeklyRow = mysqli_fetch_array($weeklyResult, MYSQLI_ASSOC);
        function toWeekNum($get_year, $get_month, $get_day){
             $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
             $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
             return ceil(($w + date('j',$timestamp) - 1)/7);
        }
     
        if($weeklyRow){

            
            $good = $weeklyRow['goodEvaluation'];
            $bad = $weeklyRow['badEvaluation'];
            $score = $weeklyRow['score'];
            $date = $weeklyRow['date'];
            $routineCount = $weeklyRow['routineCnt'];
            $hourCount = $weeklyRow['hourCnt'];
            $checkCount = $weeklyRow['checkCnt'];
            $preDate = date("Y-n-d",strtotime($date.'-7 days'));
            $preRoutineDf = $routineCount;
            $preHourDf = $hourCount;
            $preCheckDf = $checkCount;
            $preYear = date("Y",strtotime($preDate));
            $preMonth = date("n",strtotime($preDate));
            $preDay = date("d",strtotime($preDate));
            
            $preWeek = toWeekNum($preYear,$preMonth,$preDay);
            $preWeeklySql = "select * from WeeklyReport where userid = $userid and date = '$preDate'";
            $preWeeklyRow = mysqli_fetch_array(mysqli_query($conn,$preWeeklySql),MYSQLI_ASSOC);
            
            if($preWeeklyRow){
                $preRoutineDf = $routineCount - $preWeeklyRow['routineCnt'];
                $preHourDf = $hourCount - $preWeeklyRow['hourCnt'];
                $preCheckDf = $checkCount - $preWeeklyRow['checkCnt'];
            }
            
            
            if(!$routineCount){
                $weeklyAchievement = 0;
            }else{
                
                $weeklyAchievement = round($checkCount/$routineCount * 100,1);
            }
            

            
            $month = date("m",strtotime($date));
            $year = date("Y",strtotime($date));
            $day = date("d",strtotime($date));
            
            if($weeklyRow['image'] != null){
                $image = $weeklyRow['image'];
            }else{
                $image = "img/logoRail.jpg";
            }
            
            function checkUpDown($diff){
                
                if($diff < 0){
                    echo "감소";
                    
                }else{
                    echo "증가";
                }
            }
            


        
?>
</head>
<div class="col-md-1"></div>
<div class="main col-md-8 col-md-offset-2">
    <div class="weeklyTop">
        <div class="weeklyName">
            <b style="font-size:25px; text-align:center; float:left;"><?=$preMonth?>월 <?=$preWeek?>주차 품질보증서</b>
        </div>
        <div  id="weekButton">
            <a class="bg_purple_btn round_btn word_2_btn" onclick="document.getElementById('weeklyform').submit();">저장</a>
        </div>
  
    </div>
    <hr style="border:0; height:3px; background: #04005E;">
    <div class="clear"></div>

    
    
    <form action="adminWeekly.php?mode=2" method="POST" id="weeklyform" enctype="multipart/form-data">

        <div class="container col-md-12">
            <row>
                <div class="col-md-1"></div>
                <div id="calender" class="col-md-3">
                    <div class="year-month"></div>
                    <div class="dates"></div>
                </div>
                <div id="image" class="col-md-3">
                    <input type="file" name="inputImg" id = "inputImg" style='display: none;' accept="image/*">
                    <img src='<?=$image?>' width="190px"height="190px" style="margin: 0 auto;"id = 'weeklyImg' onclick='document.all.inputImg.click();'>
                </div>
                <div id="score" class="col-md-3">
                    <span class="mScore">이번 주 나의 점수
                        <br><input type="text" name="weeklyScore" value="<?=$score?>">
                        점</span>

                </div>
                <div class="col-md-1"></div>
            </row>
        </div>
        <div class=" container col-md-12 weeklyContent">
            <row>
                <div class="col-md-1"></div>
                <div id="weeklyTime" class="col-md-3">
                    <div style="flex:100%; margin-right:5px;">
                        <p style="margin: 0; font-size: 14px;"><b>이번 주 Have-it과 계획한 시간</b></p>
                        <p class="text-center" style="margin: 20px; font-weight:bold;"><span style="font-size:50px;"><?=$hourCount?></span> 시간</p>
                        <p class="text-center" style="margin: 0; font-size: 13px;">지난 주 대비 <?php echo abs($preHourDf)?>시간 <?php checkUpDown($preHourDf);?>했어요!</p>
                    </div>
                    <div class="weeklyVertical"></div>
                    
                </div>
                <div id="weeklyAll" class="col-md-3">
                    <div style="flex:100%; margin-right:5px;">
                        <p style="margin: 0; font-size: 14px;"><b>이번 주 루틴 등록 횟수</b></p>
                        <p class="text-center" style="margin: 20px; font-weight:bold;"><span style="font-size:50px;"><?=$routineCount?></span> 번</p>
                        <p class="text-center" style="margin: 0; font-size: 13px;">지난 주 대비 <?php echo abs($preRoutineDf)?>번 <?php checkUpDown($preRoutineDf); ?>했어요!</p>
                    </div>
                    <div class="weeklyVertical"></div>
                </div>
                <div id = "weeklyCheck"class="col-md-3">
                    <div style="flex:100%; margin-right:5px; ">
                        <p style="margin: 0; font-size: 14px;"><b>이번 주 루틴 성공 횟수</b></p>
                        <p class="text-center" style="margin: 20px; font-weight:bold;"><span style="font-size:50px;"><?=$checkCount;?></span> 번</p>
                        <p class="text-center" style="margin: 0; font-size: 13px;">지난 주 대비 <?php echo abs($preCheckDf)?>번 <?php checkUpDown($preCheckDf); ?>했어요!</p>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </row>
        </div>
        <div class="col-md-12 text-center" style="margin-bottom:20px;">
            <b style="font-size:20px;">위와 같이, 이번 주 <?=$weeklyAchievement?>%의 보석 품질을 보증합니다💎</b>
            <br><br>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <b style="font-size: 18px;"> 요일별 목표 성취도</b>
            <canvas id="myChart" style="margin:25px 0px 25px 0px;"></canvas>
        </div>
        <div class="col-md-1"></div>
        
        
        <div class="col-md-12 text-left">
            <div class="col-md-1"></div>
            <b style="font-size: 18px; margin-bottom:20px;"> 나의 품질 평가</b>
        </div>
        <div class="container writeEval col-md-12">
            <row>
     
                <div class="col-md-1"></div>
                
                <div id="good" class="col-md-5">
                    <p>칭찬</p>
                    <textarea name="good"><?=$good?></textarea>
                </div>
                <div id="bad" class="col-md-5">
                    <p>반성</p>
                    <textarea name="bad"><?=$bad?></textarea>
                </div>
                <div class="col-md-1"></div>
            </row>
        </div>
        <div class="col-md-12 text-left">
            <div class="col-md-1"></div>
            <b style="font-size: 18px;"> Q. 왜 루틴을 수행하지 못했나요?</b>
        </div>
        <div class = "checkFailure col-md-12">
        
            <div class="col-md-1"></div>
            <div class = "col-md-10" id = "labels">
            
                <label for="1"><input type="checkbox" name="failure[]"id="1" value="1"> 핸드폰 게임</label> 
                <label for="2"><input type="checkbox" name="failure[]" id="2" value="2"> 인터넷방송 시청</label> 
                <label for="3"><input type="checkbox" name="failure[]" id="3" value="3"> 야외 활동</label> 
                <label for="4"><input type="checkbox" name="failure[]" id="4" value="4"> 무리한 계획</label> 
                <br>
                <label for="5"><input type="checkbox" name="failure[]" id="5" value="5"> 유튜브</label> 
                <label for="6"><input type="checkbox" name="failure[]" id="6" value="6"> PC 게임</label> 
                <label for="7"><input type="checkbox" name="failure[]" id="7" value="7"> 음주</label> 
                <label for="8"><input type="checkbox" name="failure[]" id="8" value="8"> 예정에 없던 외출</label> 
                <br>
                <label for="9"><input type="checkbox" name="failure[]" id="9" value="9"> TV 시청</label> 
                <label for="10"><input type="checkbox" name="failure[]" id="10" value="10"> 수면</label> 
                <label for="11"><input type="checkbox" name="failure[]" id="11" value="11"> 사고</label> 
                <label for="12"><input type="checkbox" name="failure[]" id="12" value="12"> 넷플릭스/왓챠</label> 
                <br>
                <label for="13"><input type="checkbox" name="failure[]" id="13" value="13"> SNS</label> 
                <label for="14"><input type="checkbox" name="failure[]" id="14" value="14"> 능력 부족</label> 
                <label for="15"><input type="checkbox" name="failure[]" id="15" value="15"> 집중력 부족</label> 
                <label for="16"><input type="checkbox" name="failure[]" id="16" value="16"> 아픔</label> 
        
            </div>
            <div class="col-md-1"></div>
        
        </div>
        <input type="hidden" name="weeklyID" value="<?=$weeklyID?>">
    </form>
</div>

<?php 
        $achieveDayofWeekSql = "select * from weekly_achieve_dayofweek where weeklyID = $weeklyID order by goalID ASC";
    
        $dayofweekResult = mysqli_query($conn,$achieveDayofWeekSql);
        while($dayofweekRow = mysqli_fetch_array($dayofweekResult,MYSQLI_ASSOC)){
            $dayofweekGoalID = $dayofweekRow['goalID'];
            if(!$dayofweekGoalID){
                break;
            }
            $achieveDayofWeek = $dayofweekRow['achieveDayofWeek'];
            $achieveDayofWeek = explode(';',$achieveDayofWeek);
            if(isset($goalIDArr)){
                if(!in_array($dayofweekGoalID,$goalIDArr)){
                    $goalIDArr[count($goalIDArr)] = $dayofweekGoalID;
                }
            }else{
                $goalIDArr[0] = $dayofweekGoalID;
                
            }
            for($i = 1; $i <7; $i++){
                
                if(isset($dayofweek[$dayofweekGoalID])){
                    $dayofweek[$dayofweekGoalID] = "$dayofweek[$dayofweekGoalID],$achieveDayofWeek[$i]";
                    
                }else {
                   $dayofweek[$dayofweekGoalID] = "$achieveDayofWeek[$i]";
                }
                
                if($i == 6){
                    $dayofweek[$dayofweekGoalID] = "$dayofweek[$dayofweekGoalID],$achieveDayofWeek[0]";
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
        labels: ["월", "화", "수", "목", "금", "토","일"],
        datasets: [
            <?php 
                // $goalIDArr예외처리 하기
                if(isset($goalIDArr)){
                    $dayofweekGoalIDCount = count($goalIDArr);
                    for($i=0;$i<$dayofweekGoalIDCount;$i++){
                        $goalID = $goalIDArr[$i];
                        $goalSql = "select goalName from goal where goalID=$goalID"; $goalRow=mysqli_fetch_array(mysqli_query($conn,$goalSql));
                        $goalName = $goalRow['goalName'];

                       echo " {
                            label: ['$goalName'],
                            data: [$dayofweek[$goalID]],
                            backgroundColor: '$goalColor[$goalID]'

                        },";
                        

                }
                    
                
            }else{
                        echo " {
                            label:['데이터 없음'],
                            data: [],
                            backgroundColor: []

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
                display: true,
                position: 'right',
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

    const viewYear = <?=$preYear?>;
    const viewMonth = <?=$month?>-1;

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

    //const dates = prevDates.concat(thisDates, nextDates);
    prevDates.forEach((date, i) => {
        prevDates[i] = `<div class="preDate">${date}</div>`;
    })
    thisDates.forEach((date, i) => {
        thisDates[i] = `<div class="date">${date}</div>`;
    })
    nextDates.forEach((date, i) => {
        nextDates[i] = `<div class="nextDate">${date}</div>`;
    })
    
    
    document.querySelector('.dates').innerHTML = prevDates.join('');
    document.querySelector('.dates').innerHTML += thisDates.join('');
    document.querySelector('.dates').innerHTML += nextDates.join('');
    
    
    
    const term = new Date('<?=$date?>');
    var z = 1;
    for(var i=1; i <8;i++){  
        var w = 0;
        for (let date of document.querySelectorAll('.date')) {
            w++;
            if (+date.innerText === term.getDate() - i) {
                if(+date.innerText >=22 && w<7){
                    break;
                }
                date.classList.add('term');
                break;
              }
            }
        if((term.getDate() - i)<=0) {
            for (let preDate of document.querySelectorAll('.preDate')){
                if(PLDate -(z-1) === +preDate.innerText){
                    preDate.classList.add('term');
                    z++;
                    break;               
                 }
            
            }
          }
            
       }
        
    
  
        
    
    


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





<?php 
$weekly_failure = $weeklyRow['weekly_failure'];
$weekly_failure = explode(';',$weekly_failure);
            
for($z=0;$z<count($weekly_failure);$z++){
    
    $temp = $weekly_failure[$z];
    if($temp != null)
        echo "<script>document.getElementById('$temp').checked = true;</script>";
    
    
}      

  
        
}?>




