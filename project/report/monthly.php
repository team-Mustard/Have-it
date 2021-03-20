<!DOCTYPE html>
<html lang="en">

<head>

   
    <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="./js/sidebar.js"></script>
    <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="stylesheet" href="../css/monthlyReport.css">
</head>

<body>
    <div class="container text-center">
        <div id="grade" class="col-md-10">
            <p class="gradetitle">이번 달 나의 등급</p>
            <span class="gradeprint">상위 74%</span>
        </div>
    </div>
    <div id="chart" class="container">
        <div class="col-md-10">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="container">
        <div id="fail" class="col-md-5">
            <p>가장 실패율이 높은 루틴</p>
            <p>"반짝이는 금속 줍기"</p>
            <p>1/15</p>
            <button>루틴 바로가기</button>
        </div>
        <div id="success" class="col-md-5">
            <p>가장 성공률이 가장 높은 루틴</p>
            <p>"에메랄드 광산 깨기"</p>
            <p>2/15</p>
            <button>새로운 루틴 생성하기</button>
        </div>
    </div>



</body>

</html>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, { 
        type: 'line', 
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '10', '11', '12', '13', '14', '15', '16', '17', '18','19','20','21','22','23','24'],
            datasets: [{
                backgroundColor: 'transparent',
                borderColor: 'red',
                data: [3, 3, 4, 3, 2, 6, 7,8,2,3,4,0,0,0,8,9,7,6,5,6,3,8,10]
            }]
        }, // 옵션 
        options: {
            legend: {
                display: false
            }
        }
    });

</script>
