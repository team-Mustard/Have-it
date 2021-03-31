<?php

    include_once "./head.php";
    include_once "./leftside.php";
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>

<body>
    <div class="main col-md-10 col-md-offset-2">
        <div class="container text-center">
            <div id="grade">
                <p class="gradetitle">이번 달 나의 등급</p>
                <span class="gradeprint">상위 74%</span>
            </div>
        </div>
        <div id="chart" class="container">

            <canvas id="myChart"></canvas>

        </div>
        <div class="container">
            <row>
                <div id="fail" class="col-md-6">
                    <p>가장 실패율이 높은 루틴</p>
                    <p>"반짝이는 금속 줍기"</p>
                    <p>1/15</p>
                    <button>루틴 바로가기</button>
                </div>
                <div id="success" class="col-md-6">
                    <p>가장 성공률이 가장 높은 루틴</p>
                    <p>"에메랄드 광산 깨기"</p>
                    <p>2/15</p>
                    <button>새로운 루틴 생성하기</button>
                </div>
            </row>
        </div>
    </div>



</body>
<?php 
 include_once "./rightside.php";
include_once "./bottom.php";?>

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

</script>
