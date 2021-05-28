        <div class="col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate text-center">
          <div><h2 class="right-header" style="float: left;"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
            <?php
                $time = time();
                $today = date("Y-m-d", $time);
                //$today = "2021-04-30";
                echo '<h4 class="right-header" style="float: right;">'.$today.'</h4>';
            ?>
          </div>
               
            <div class="chart">
                <center>
                <canvas id="myChart1" width="300" height="300"></canvas>
                </center>
            </div>

            <?php
        
            include "./db/dbconn.php";
            if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
            $selectTrackerSql = "select * from timetracker where date = '$today' and userid = $userid";
            $trackerRow = mysqli_fetch_array(mysqli_query($conn,$selectTrackerSql), MYSQLI_ASSOC);
            $trackerID = $trackerRow['trackerID'];
            $selectT_RoutineSql = "select * from t_routine WHERE trackerID='$trackerID'";
            $t_routineResult = mysqli_query($conn, $selectT_RoutineSql);
            
            $print_legend = '<div class="container-fluid row tracker-legend"> ';
            $time_s_to_e = '<div class="col-sm-6 legend-time"> ';
            $r_name = '<div class="col-sm-6 legend-name"> ';  
            $chartRoutineName = null;
            $chartRoutineColor = null;
            $chartRoutineTime = null;
            while($row2 = mysqli_fetch_array($t_routineResult,MYSQLI_ASSOC)){
                
                //timetrackerID에 일치하는 t_routine 데이터 
                $t_routineID = $row2['t_routineID']; 
                $t_routineCheck = $row2['checkRoutine'];
                $time_s = $row2['startTime']; //트래커 시작시간
                $time_e = $row2['endTime'];  //트래커 종료시간
                $s = strtotime($time_s);
                $e = strtotime($time_e);
                $arr_s = intval(date('H', $s));
                $tmp = round(abs($e - $s) / 60,2);
                $routineID = $row2['routineID'];
                $routine = "SELECT * FROM routine WHERE routineID='$routineID'"; 
                $result3 = mysqli_query($conn, $routine);
                $row3 = mysqli_fetch_array($result3);
                $routineName = $row3['routineName'];
                $routineColor = $row3['color']; //routineID 통해서 색깔, 제목 받아옴
                $chartRoutineName .= "\"$routineName\",";
                $chartRoutineColor .= "\"$routineColor\",";   
                $chartRoutineTime .= "\"$tmp\",";
                
               
                
                $time_s_to_e .= '<div class="checks"> <label> '.$time_s.' - '.$time_e.' </label></div>';
                        
                $r_name .= '<div id = "checks" class="checks"> <input type="checkbox" onchange="changeRoutineCheck('.$t_routineID.');" id="checkRoutine" name="routine'.$t_routineID.'" value="'.$t_routineID.'"';
                if($t_routineCheck == 1){
                    $r_name .= 'checked';
                }    
                    
                $r_name .= '><label style="color: '.$routineColor.'"> '.$routineName.'</label></div>';
                        
                        /*echo '
                        <div class="chart_content">
                        <div class="checks" id="routine">
                            <input type="checkbox" id="ex_chk" class="checkbox1" name="tracker" value="value1">
                            <label for="ex_chk" style="color: '.$routineColor.'">'.$time_s.' - '.$time_e.' &emsp;&emsp;' .$routineName.'</label> <br> </div>
                        </div>
                        ';*/
                    }
                //}
                $print_legend .= $time_s_to_e . '</div>' . $r_name . '</div> </div>';
                echo $print_legend;
                    
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
            
            <h4 style="margin-top: 130px;"><i class="fas fa-plus-circle schedule_add" onclick="add_schedule()"> 일정 추가하기</i></h4>
               
            <script>
                var ctx = document.getElementById('myChart1');
                var backColor = ["#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E", "#04005E","#04005E", "#04005E", "#04005E" ];
               
                var data = {
                    labels:[<?=$chartRoutineName?>],
                    datasets: [{
                        backgroundColor: [<?=$chartRoutineColor?>],
                        data: [<?=$chartRoutineTime?>],
                    }],
                };
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        elements: {
                            arc: {
                              borderWidth: 0
                            }
                        },
                        responsive: false,
                        legend:{
                            display: false,

                        },

                    }
                })
            </script>         
                        
            
            <!-- 이 div는 지우면 right side bar가 밀립니다. 지우지 마세요 -->
            <div style="margin-top: 51px;"></div>
        </div>
            

<script>
    function add_schedule() {
        $(".sidebar-right").load("add_schedule.php");
    }
    function changeRoutineCheck(t_routineID) {
        var checked = 0;
        var tmp = 'routine' + t_routineID;
       
        if ($("input:checkbox[name='"+tmp+"']").is(":checked") == true){

            checked = 1;

            }else{

            checked = 0;

            }
            var ajaxDate = {"t_routineID":t_routineID,"checked":checked};
            $.ajax({
                type: 'POST',
                url: 'adminTimetracker.php',
                data: ajaxDate,
                success: function(html) {

                }

            });
        
        
        
        
    }
   
</script>