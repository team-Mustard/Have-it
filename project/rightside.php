<head>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <style>
        .checks input.checkbox1{
            font-size: 1em;
            width: 1.25em;
            height: 1.25em;
            color: white;
            /*vertical-align: middle;*/
            margin: -4px 0 0 0;
            vertical-align: -2px;
        }

        .checks input.checkbox1 + label{
            font-size: 1.125em;
            /*vertical-align: middle;*/
            color: white;
        }
        
        #routine { text-align: center; }
        
        .chart { margin-left: 26%;}
    </style>
</head>

        <div class="col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate text-center">
          <h2 class="right-header"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
            <?php
                $today = "2021-03-31";//date("Y-m-d");
                echo '<h4 style="color:white;">'.$today.'</h3>';
            ?>
           <table class="time">

               
            <div class="chart">
                <canvas id="myChart1" width="300" height="300"></canvas>
            </div>
               
            <br><br><br><br>
               
            <?php
                include "./db/dbconn.php";
                if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
                
                $tracker = "SELECT * FROM timetracker WHERE userID='$userid'";
                
                $result = mysqli_query($conn, $tracker);
                $bool = "false";
                while($row = mysqli_fetch_array($result)){
                    if($today == $row['date'])
                        { $bool = "true"; break; }
                } 
                
               
                if($bool == "true"){ //오늘 날짜와 일치하는 타임트래커 존재
                    $trackerID = $row['trackerID'];
                    
                    $t_routine = "SELECT * FROM t_routine WHERE trackerID='$trackerID'"; 
                    //타임트래커ID 받아서 해당 ID와 일치하는 t_routine 찾기
                    $result2 = mysqli_query($conn, $t_routine);
                    
                    while($row2 = mysqli_fetch_array($result2)){
                    //timetrackerID에 일치하는 t_routine 데이터
                        
                        $time_s = $row2['startTime']; //트래커 시작시간
                        $time_e = $row2['endTime'];  //트래커 종료시간
                        
                        $s = strtotime($time_s);
                        $e = strtotime($time_e);
                        $arr_s = intval(date('H', $s));
                        
                       
                        
                        $routineID = $row2['routineID'];
                    
                        $routine = "SELECT * FROM routine WHERE routineID='$routineID'";                    
                        $result3 = mysqli_query($conn, $routine);
                        $row3 = mysqli_fetch_array($result3);
                    
                        $routineName = $row3['routineName'];
                        $routineColor = $row3['color']; //routineID 통해서 색깔, 제목 받아옴
                        
                        echo '<div class="chart_content">
                        <div class="checks" id="routine">
                            <input type="checkbox" id="ex_chk" class="checkbox1" name="tracker" value="value1">
                            <label for="ex_chk" style="color: '.$routineColor.'">'.$time_s.' - '.$time_e.' &emsp;&emsp;' .$routineName.'</label> <br> </div>
                        </div>
                        ';
                    }
                }
                    
                    
                    //시작시간, 끝나는 시간 표시 + 라디오 통해 루틴 제목 옆에 체크 기능
                    //라디오 체크시 t_routine의 checkRoutine 1로 바꾸기
                    //하루가 끝났을 때 checkRoutine이 모두 1이면 routine의 habbitTracker +1..? 이건 어케해야할가
                    //시간에 따라서 backColor[해당시간]에 색깔 집어넣음
            ?>
                
            
            <!--<div class="chart_content">
                <div class="checks" id="time">
                <input type="checkbox" class="checkbox1">
                <label for="">12:30 ~ 14:00</label> <br>
                <input type="checkbox" class="checkbox1">
                <label for="">09:30 ~ 10:00 </label> <br>
                <input type="checkbox" class="checkbox1">
                <label for="">18:20 ~ 18:30 </label>
            </div>-->
               
           <!-- <div class="checks" id="routine">
                <input type="checkbox" id="ex_chk" class="checkbox1" name="tracker" value="value1">
                <label for="ex_chk" style="color: #ff0000">12:30 - 14:00 &emsp; 운동 가기</label> <br>
                <input type="checkbox" id="ex_chk2" class="checkbox1" name="tracker" value="value1">
                <label for="ex_chk2" style="color: #800000">09:30 - 10:00 &emsp; 아침밥 먹기</label> <br>
                <input type="checkbox" id="ex_chk3" class="checkbox1" name="tracker" value="value1">
                <label for="ex_chk3" style="color: #ffff00">18:20 - 18:30 &emsp; 영양제 먹기</label>
            </div>
            </div>-->
               
            <div class="modify" style="margin-top: 130px;">
            <input class="plus" type="button" value="+" style="color: red; margin-left: 5px;"/><span style="color:white; margin-left: 5px;">일정 수정하기</span>
            </div>
               
            <script>
                var ctx = document.getElementById('myChart1');
                var backColor = ["#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E","#04005E", "#04005E", "#04005E" ];
               
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
