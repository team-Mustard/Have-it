<head>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>


</head>

    <div class="main col-md-10 col-md-offset-2">
        <div class="container" id = "weekButton">
            <a class="glyphicon glyphicon-remove-circle" aria-hidden="true"></a>
            <a class="glyphicon glyphicon-ok-circle" aria-hidden="true" onclick="document.getElementById('weeklyform').submit();"></a>
        </div>
<?php 
        include "db/dbconn.php";
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        
        if(isset($_GET['weeklyID'])) $weeklyID = $_GET['weeklyID'];
        $sql = "select * from WeeklyReport where weeklyID = $weeklyID";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($row){

            $good = $row['goodEvaluation'];
            $bad = $row['badEvaluation'];
            $score = $row['score'];
            $date = $row['date'];
            $routineAchieve = $row['routineAchieve'];
            $month = date("m",strtotime($date));
            $year = date("Y",strtotime($date));
            $day = date("d",strtotime($date));

        
?>
        <form action="adminWeekly.php?mode=2" method="POST" id = "weeklyform">
        
        <div class="container">
            <row>
                <div id="calender" class="col-md-4">
                    <div class="year-month"></div>
                    <div class="dates"></div>
                </div>
                <div id="image" class="col-md-4">
                    <img src="noimage.png" width="250px" alt="이미지 없음">
                </div>
                
                <div id="score" class="col-md-3">
                    <span class="mScore">이번 주 나의 점수
                        <input type="text" name="weeklyScore" value="<?=$score?>">
                        점</span>

                </div>
              
            </row>
        </div>
        <div class="container">
            <canvas id="myChart"></canvas>
        </div>
        <div class="container writeEval">
            <row>
                <div id="good" class="col-md-6">
                    <p>칭찬</p>
                    <textarea name="good"><?=$good?></textarea>
                </div>
                <div id="bad" class="col-md-6">
                    <p>반성</p>
                    <textarea name="bad"><?=$bad?></textarea>
                </div>
            </row>
        </div>
         <input type="hidden" name = "weeklyID" value = "<?=$weeklyID?>">
        </form>
    </div>

<?php 
    $weeklyRoutine = explode(';',$routineAchieve);
    
?>
<script>
    var chBar = document.getElementById("myChart");
    var chartData = {
        labels: ["월", "화", "수", "목", "금", "토", "일"],
        datasets: [{
            data: [<?=$weeklyRoutine[0]?>,<?=$weeklyRoutine[2]?>,<?=$weeklyRoutine[4]?>,
                   <?=$weeklyRoutine[6]?>,<?=$weeklyRoutine[8]?>,<?=$weeklyRoutine[10]?>,<?=$weeklyRoutine[12]?>],
            backgroundColor: '#ff1f78'
        }, {
            data: [<?=$weeklyRoutine[1]?>,<?=$weeklyRoutine[3]?>,<?=$weeklyRoutine[5]?>,
                   <?=$weeklyRoutine[7]?>,<?=$weeklyRoutine[9]?>,<?=$weeklyRoutine[11]?>,<?=$weeklyRoutine[13]?>],
            backgroundColor: '#ff1f78'
        }]
    };
    var myChart = new Chart(chBar, { // 챠트 종류를 선택 
        type: 'bar', // 챠트를 그릴 데이타 
        data: chartData, // 옵션 
        options: {
            legend: {
                display: false
            }
        }
    });

    const date = new Date();

    const viewYear = <?=$year?>;
    const viewMonth = <?=$month?> -1 ;

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

</script>
<?php }?>