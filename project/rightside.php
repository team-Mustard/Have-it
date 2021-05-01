<head>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>

        <div class="col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate text-center">
          <h2 class="right-header"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
            <?php
                $today = date("Y-m-d");
                echo '<h4 style="color:white;">'.$today.'</h3>';
            ?>
           <table class="time">

            <div class="chart">
                <canvas id="myChart1" width="300" height="300"></canvas>
            </div>

            <?php
                include "./db/dbconn.php";
                if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
                
                //if($today == $term_s)
            
            ?>
               
            <script>
                var ctx = document.getElementById('myChart1');
                var backColor = [];
                //backColor[1] = '#1a53ff';
                
                var data = {
                    datasets: [{
                        backgroundColor: backColor,
                        data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                    }],
                };
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        responsive: false
                    }
                })
            </script>
               
            </table>
            <!-- 이 div는 지우면 right side bar가 밀립니다. 지우지 마세요 -->
            <div style="margin-top: 51px;"></div>
        </div>
