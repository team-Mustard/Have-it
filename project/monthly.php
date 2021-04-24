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
    ?>    
        
        

    <div class="main col-md-10 col-md-offset-2">
        <div class="container text-center col-md-10">
            <div id="grade">
                <p class="gradetitle">이번 달 나의 등급</p>
                <span class="gradeprint">상위 74%</span>
            </div>
        </div>
        <div id="chart" class="container col-md-10">
            <a onclick="showRoutineTime();">시간</a>
            <a onclick="showRoutineWeek();">주차</a>
            <a onclick="showRoutineDayofweek();">요일</a>
            <canvas id="myChart"></canvas>

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
                    <p>가장 성공률이 가장 높은 루틴</p>
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
    
    var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'],
            datasets: [{
                backgroundColor: 'transparent',
                borderColor: 'red',
                data: [3, 3, 4, 3, 2, 6, 7, 8, 2, 3, 4, 0, 0, 0, 8, 9, 7, 6, 5, 6, 3, 8, 10]
            }]
        }, // 옵션 
        options: {
            legend: {
                display: false
            }
        }
    });
    
    function showRoutineTime(){
        
        <?php   
        $achieveWeekSql = "select * from achieve_dayweek where monthlyID = $monthlyID";
        $achieveDayweekSql = "select * from achieve_week where monthlyID = $monthlyID";
        
        
        $achieveTimeSql = "select * from achieve_time where monthlyID = $monthlyID ";
        
        $achieveTimeRow = mysqli_fetch_array(mysqli_query($conn,$achieveTimeSql),MYSQLI_ASSOC);

        
        
        
        ?>
        
        
        
        var barOptions_stacked = {
            tooltips: {
                enabled: false
            },
            hover :{
                animationDuration:0
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero:true,
                        fontFamily: "'Open Sans Bold', sans-serif",
                        fontSize:11
                    },
                    scaleLabel:{
                        display:false
                    },
                    gridLines: {
                    }, 
                    stacked: true
                }],
                yAxes: [{
                    gridLines: {
                        display:false,
                        color: "#fff",
                        zeroLineColor: "#fff",
                        zeroLineWidth: 0
                    },
                    ticks: {
                        fontFamily: "'Open Sans Bold', sans-serif",
                        fontSize:11
                    },
                    stacked: true
                }]
            },
            legend:{
                display:false
            },

            animation: {
                onComplete: function () {
                    var chartInstance = this.chart;
                    var ctx = chartInstance.ctx;
                    ctx.textAlign = "left";
                    ctx.font = "9px Open Sans";
                    ctx.fillStyle = "#fff";

                    Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        Chart.helpers.each(meta.data.forEach(function (bar, index) {
                            data = dataset.data[index];
                            if(i==0){
                                ctx.fillText(data, 50, bar._model.y+4);
                            } else {
                                ctx.fillText(data, bar._model.x-25, bar._model.y+4);
                            }
                        }),this)
                    }),this);
                }
            },
            pointLabelFontFamily : "Quadon Extra Bold",
            scaleFontFamily : "Quadon Extra Bold",
        };

        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["2014", "2013", "2012", "2011"],

                datasets: [{
                    data: [727, 589, 537, 543, 574],
                    backgroundColor: "rgba(63,103,126,1)",
                    hoverBackgroundColor: "rgba(50,90,100,1)"
                },{
                    data: [238, 553, 746, 884, 903],
                    backgroundColor: "rgba(163,103,126,1)",
                    hoverBackgroundColor: "rgba(140,85,100,1)"
                },{
                    data: [1238, 553, 746, 884, 903],
                    backgroundColor: "rgba(63,203,226,1)",
                    hoverBackgroundColor: "rgba(46,185,235,1)"
                }]
            },

            options: barOptions_stacked,
        });

    }
    function showRoutineWeek(){
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7'],
            datasets: [{
                backgroundColor: 'transparent',
                borderColor: 'red',
                data: [3, 3, 4, 3, 2, 6, 7]
            }]
        }, // 옵션 
        options: {
            legend: {
                display: false
            }
        }
    });
        
    }
    function showRoutineDayofweek(){
        
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7'],
            datasets: [{
                backgroundColor: 'transparent',
                borderColor: 'red',
                data: [8, 9, 7, 6, 5, 6, 3]
            }]
        }, // 옵션 
        options: {
            legend: {
                display: false
            }
        }
    });
    }
</script>
