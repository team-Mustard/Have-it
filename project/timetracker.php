<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
        <!--<div class="col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate text-center">-->
          <div><h2 class="right-header" style="float: left;"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
            <?php
                $time = time();
                $today = date("Y-m-d", $time);
                //$today = '2021-09-06';

                echo '<h4 class="right-header" style="float: right;">'.$today.'</h4>';
            ?>
          </div>
<div>
</div>
             <div class = "chartWrapper">
                 <center>
                <div class="chart">
                    
                        <canvas id="scheduleChart" width="300" height="350"></canvas>

                </div>
                <div class = "backChart">
                        <canvas id="backChart" width="350" height="350"></canvas>

                </div>
              
                </center>

            </div>
<script>
var canvas = document.getElementById('backChart');
var ctx2 = canvas.getContext('2d');

ctx2.beginPath();
ctx2.arc(175, 175, 150, 0, Math.PI * 2);
ctx2.strokeStyle = "white";
ctx2.fillStyle = "white";
ctx2.fill();
ctx2.lineWidth = 2;
ctx2.stroke();
    
function drawNumber(ctx, radius) {
    var ang;
    var num;
    ctx2.font = radius*0.1 + "px 고딕";
    ctx2.textBaseline="middle";
    ctx2.textAlign="center";
    ctx2.translate(173, 175);
    ctx2.fillStyle = "white";
    for(num = 1; num <= 24; num++){
        ang = num * 2 *Math.PI / 24;
        ctx2.rotate(ang);
        ctx2.translate(0, -radius);
        ctx2.rotate(-ang);
        ctx2.fillText(num.toString(), 0, 0);
        ctx2.rotate(ang);
        ctx2.translate(0, radius);
        ctx2.rotate(-ang);
   }
    
}
    
drawNumber(ctx2,165);
</script>

            <?php
        
            include "./db/dbconn.php";
            if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
            $selectTrackerSql = "select * from timetracker where date = '$today' and userid = $userid";
            $trackerRow = mysqli_fetch_array(mysqli_query($conn,$selectTrackerSql), MYSQLI_ASSOC);
            $trackerID = $trackerRow['trackerID'];
            $selectT_RoutineSql = "select * from t_routine WHERE trackerID='$trackerID'";
            $selectScheduleSql = "select * from schedule where trackerID = '$trackerID'";
            $t_routineResult = mysqli_query($conn, $selectT_RoutineSql);
            $schedultResult = mysqli_query($conn, $selectScheduleSql);
            
            $print_legend = '<div class="container-fluid row tracker-legend"> ';
            $time_s_to_e = '<div class="col-sm-6 legend-time"> ';
            $r_name = '<div class="col-sm-6 legend-name"> ';  

            //$chartRoutineName = null;
            //$chartRoutineColor = null;
            //$chartRoutineTime = null;
            $routineCount = 0;
            $routineID=null;
            $routineName=null;
            $routineColor=null;
            $routineKind = null;
            $routineStart = null;
            $routineEnd = null;
            $routineCheck = null;
            $troutineID = null;
            if($trackerRow){ 
    
                $trackerID = $trackerRow['trackerID'];
                $selecttRoutineSql = "select * from t_routine WHERE trackerID = '$trackerID' order by startTime ASC";
                $selectScheduleSql = "select * from schedule where trackerID = '$trackerID' order by startTime ASC";
                $troutineResult = mysqli_query($conn,$selecttRoutineSql);
                $scheduleResult = mysqli_query($conn,$selectScheduleSql);
                while($troutineRow = mysqli_fetch_array($troutineResult, MYSQLI_ASSOC)){
                    $routineStart[$routineCount] = date('H:i',strtotime($troutineRow['startTime']));
                    $routineEnd[$routineCount] = date('H:i',strtotime($troutineRow['endTime']));
                    $troutineID[$routineCount] = $troutineRow['t_routineID'];
                    $routineCheck[$routineCount] = $troutineRow['checkRoutine'];
                    $routineID[$routineCount] = $troutineRow['routineID'];
                    $routineSql = "select * from routine where routineID = $routineID[$routineCount]";
                    $routineResult = mysqli_query($conn,$routineSql);
                    $routineRow = mysqli_fetch_array($routineResult,MYSQLI_ASSOC);
                    $routineName[$routineCount] = $routineRow['routineName'];
                    $routineColor[$routineCount] = $routineRow['color'];
                    $routineKind[$routineCount] = 1;
                    //$tmp = round(abs((int)$routineEnd[$routineCount] - (int)$routineStart[$routineCount]) / 60,2);
                    //$chartRoutineName .= "\"$routineName[$routineCount]\",";
                    //$chartRoutineColor .= "\"$routineColor[$routineCount]\",";   
                    //$chartRoutineTime .= "\"$tmp\",";
                    $routineCount++;

                }
                while($scheduleRow = mysqli_fetch_array($scheduleResult, MYSQLI_ASSOC)){
                    $routineStart[$routineCount] = date('H:i',strtotime($scheduleRow['startTime']));
                    $routineEnd[$routineCount] = date('H:i',strtotime($scheduleRow['endTime']));
                    $troutineID[$routineCount] = $scheduleRow['scheduleID'];
                    $routineID[$routineCount] = $scheduleRow['scheduleID'];
                    $routineName[$routineCount] = $scheduleRow['scheduleName'];
                    $routineColor[$routineCount] = $scheduleRow['color'];
                    $routineCheck[$routineCount] = $scheduleRow['checkSchedule'];
                    $routineKind[$routineCount] = 2;
                    //$tmp = round(abs((int)$routineEnd[$routineCount] - (int)$routineStart[$routineCount]) / 60,2);
                    //$chartRoutineName .= "\"$routineName[$routineCount]\",";
                    //$chartRoutineColor .= "\"$routineColor[$routineCount]\",";   
                    //$chartRoutineTime .= "\"$tmp\",";
                    $routineCount++;

                }

        }
        function swap(&$x, &$y){
            $temp = $x;
            $x = $y;
            $y = $temp;
        }

        for($i=0;$i<$routineCount-1;$i++){
            for($j = $i+1;$j<$routineCount;$j++){
                  
                $min = $i;
                if(strtotime($routineStart[$j]) < strtotime($routineStart[$min])){  
                    $min = $j;
                }
                swap($routineName[$min], $routineName[$i]);
                swap($routineColor[$min],$routineColor[$i]);
                swap($routineKind[$min],$routineKind[$i]);
                swap($routineStart[$min],$routineStart[$i]);
                swap($routineEnd[$min],$routineEnd[$i]);
                swap($routineCheck[$min],$routineCheck[$i]);
                swap($troutineID[$min],$troutineID[$i]);
                
            }            
        }



        for($z=0;$z<$routineCount;$z++){
            
            $time_s_to_e .= '<div class="checks"> <label> '.$routineStart[$z].' - '.$routineEnd[$z].' </label></div>';

            if($routineKind[$z] == 1){
                $r_name .= '<div id = "checks" class="checks"> <input type="checkbox" onchange="changeRoutineCheck('.$troutineID[$z].');" id="checkRoutine" name="routine'.$troutineID[$z].'" value="'.$troutineID[$z].'"';
                if($routineCheck[$z] == 1){
                        $r_name .= 'checked';
                }        
            }else{
                
                $r_name .= '<div id = "checks" class="checks"> <input type="checkbox" onchange="changeScheduleCheck('.$troutineID[$z].');" id="checkRoutine" name="schedule'.$troutineID[$z].'" value="'.$troutineID[$z].'"';
                if($routineCheck[$z] == 1){
                        $r_name .= 'checked';
                }  
            }

            $r_name .= '><label style="color: '.$routineColor[$z].'"> '.$routineName[$z].'</label></div>';
            
        }
        $print_legend .= $time_s_to_e . '</div>' . $r_name . '</div> </div>';
        echo $print_legend;

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
            
            <h4 style="margin-top: 60px; text-align: center;"><i class="fas fa-plus-circle schedule_add" onclick="add_schedule()"> 일정 추가하기</i></h4>
               
            <script>
                <?php
                //for($q=0;$q<24;$q++){
                //    $label[$q] = "\"$q\"";
                //}
                //$data = array_fill(0,24,"\"1\"");
                //$color = array_fill(0,24,"\"#04005E\"");
                
                // 배열 크기가 24이상이 될 수도 있음
                // 합이 1이면 됨.
                // 빈곳은 1이여야됨.
                /*
                while{
                count++ []배열안
                합 -> 계속구하기
                24면 break;
                24 아니면 count늘리기
                routine에 맞는게 있으면 루틴대로
                없으면 1
                }
                
                //$routineStart[$routineCount];
                //$routineEnd[$routineCount];
                //$routineID[$routineCount];
                //$routineName[$routineCount];
                //$routineColor[$routineCount];
                
                */
                $label = null;
                $data = null;
                $color = null;
                $tempCount = 1;
                $tempSum = 0;
                $tempRoutineID = 0;
                $pIndex = 0;
                
                /*for($q=0;$q<24;$q++){
                    $label[$q] = "\"$q\"";
                }*/
                $label = array_fill(0,24,"\"null\"");
                $data = array_fill(0,24,"\"1\"");
                $color = array_fill(0,24,"\"#04005E\"");
                $checkhalf = 0;
                
                
                for($i=0; $i<24; $i++){
                    for($w=0;$w<$routineCount;$w++){
                        if(!isset($label[$i+$pIndex])){
                            $label[$i+$pIndex] = "\"null\"";
                            $data[$i+$pIndex] = "\"1\"";
                            $color[$i+$pIndex] = "\"#04005E\"";
                        }
                        $startHour = date('G',strtotime($routineStart[$w]));
                        $endHour = date('G',strtotime($routineEnd[$w]));
                        $minuteDf = (int)((strtotime($routineEnd[$w]) - strtotime($routineStart[$w])) / 60);
                        $hourDf = $endHour - $startHour;
                        $endMinute = date('i',strtotime($routineEnd[$w]));
                        $startMinute = date('i',strtotime($routineStart[$w]));
                        
                        if($startHour == $i){
                            if($minuteDf < 60){
                                if($label[$i+$pIndex] == "\"null\"" && $data[$i+$pIndex] == "\"1\""){
                                    $label[$i+$pIndex] = "\"$routineName[$w]\"";
                                    $data[$i+$pIndex] = "\"0.5\"";
                                    $color[$i+$pIndex] = "\"$routineColor[$w]\"";
                                    $data[$i+1+$pIndex] = "\"0.5\"";
                                    $pIndex++;
                                }else{
                                    $label[$i+$pIndex] = "\"$routineName[$w]\"";
                                    $data[$i+$pIndex] = "\"0.5\"";
                                    $color[$i+$pIndex] = "\"$routineColor[$w]\"";
                                    
                                }
                            }else{
                                if($label[$i+$pIndex] == "\"null\"" && $data[$i+$pIndex] == "\"1\""){
                                    $tempHour = $hourDf;
                                    if($endMinute > 0){
                                        $tempHour = $hourDf+0.5;
                                        $data[$i+$hourDf+$pIndex] = "\"0.5\"";
                                        $label[$i+$hourDf+$pIndex] = "\"null\"";
                                        $color[$i+$hourDf+$pIndex] = "\"#04005E\"";
                                    }
                                    $label[$i+$pIndex] = "\"$routineName[$w]\"";
                                    $data[$i+$pIndex] = "\"$tempHour\"";
                                    $color[$i+$pIndex] = "\"$routineColor[$w]\"";
                                    for($z= $i+1+$pIndex; $z <= $i+$hourDf+$pIndex-1 ; $z++){
                                        $label[$z] = "\"\"";
                                        $data[$z] = "\"\"";
                                        $color[$z] = "\"\"";  
                                    }
                                    
                                }else if($label[$i+$pIndex == "\"null\""] && $data[$i+$pIndex] == "\"0.5\""){
                                    $tempHour = $hourDf - 0.5;
                                    if($endMinute > 0){
                                        $tempHour += 0.5;
                                        $data[$i+$hourDf+$pIndex] = "\"0.5\"";
                                        $label[$i+$hourDf+$pIndex] = "\"null\"";
                                        $color[$i+$hourDf+$pIndex] = "\"#04005E\"";
                                    }
                                    $label[$i+$pIndex] = "\"$routineName[$w]\"";
                                    $data[$i+$pIndex] = "\"$tempHour\"";
                                    $color[$i+$pIndex] = "\"$routineColor[$w]\"";
                                    for($z= $i+1+$pIndex; $z <= $i+$hourDf+$pIndex-1 ; $z++){
                                        $label[$z] = "\"\"";
                                        $data[$z] = "\"\"";
                                        $color[$z] = "\"\"";  
                                    }
                                    
                                    
                                    
                                }

                            }
                            
                            
                            
                            
                        }
                        
                        
                        
                        
                    }
                    
                    
                    
                }
                
                
                
                /*while($tempSum >= 24){
                    if($tempRoutineID != $routineCount){
                        $nextStartHour = date('G',strtotime($routineStart[$tempRoutineID+1]));
                        $nextEndHour = date('G',strtotime($routineEnd[$tempRoutineID+1]));
                    }else{
                        $nextStartHour = -1;
                        $nextEndHour = -1;
                    }
                    */
                   
                
                
                    
                    
                //}
                /*for($i=0;$i<$routineCount;$i++){
                    $startHour = date('G',strtotime($routineStart[$i]));
                    $endHour = date('G',strtotime($routineEnd[$i]));
                    
                    for($z=0;$z<24;$z++){
                        if($z == $startHour){
                            if($startHour==$endHour){
                                $color[$z] = "\"$routineColor[$i]\"";
                                break;
                            }else{
                                $temp = $endHour - $startHour;
                                //$label[$z] = "\"$z\"";
                                $data[$z] = "\"$temp\"";
                                $color[$z] = "\"$routineColor[$i]\"";
                                $label[$z] = "\"$routineName[$i]\"";
                                for($w=$z+1; $w< $z + $temp; $w++){
                                    $label[$w] = null;
                                    $data[$w] = null;
                                    $color[$w] = null;
                                }
                            }
                        }
                    }
                        
                }*/
  
                $chartLabel = implode(',',$label);
                $chartData = implode(',',$data);
                $chartColor = implode(',',$color);
                ?>
                
                var ctx = document.getElementById('scheduleChart');
                var data = {
                    labels:[<?=$chartLabel?>],
                    datasets: [{
                        backgroundColor: [<?=$chartColor?>],
                        data: [<?=$chartData?>],
                        borderColor: ['white'],
                        borderWidth: 0,
                    }],
                };
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        segmentShowStroke: false,
                        elements: {
                            arc: {
                              
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
    function changeScheduleCheck(scheduleID) {
        var checked = 0;
        var tmp = 'schedule' + scheduleID;
       
        if ($("input:checkbox[name='"+tmp+"']").is(":checked") == true){

            checked = 1;

            }else{

            checked = 0;

            }
            var ajaxDate = {"scheduleID":scheduleID,"checked":checked};
            $.ajax({
                type: 'POST',
                url: 'adminTimetracker.php',
                data: ajaxDate,
                success: function(html) {

                }

            });
    }
    
    
</script>

