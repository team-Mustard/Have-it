<div>
    <h2 class="right-header" style="float: left;"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
    <?php
    $time = time();
    $today = date("Y-m-d", $time);
    //$today = '2021-09-06';
    echo '<h4 class="right-header" style="float: right;">'.$today.'</h4>';
?>

    <?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
include "db/dbconn.php";
$selectGoalSql = "select * from goal where userid = $userid";
$goalResult = mysqli_query($conn,$selectGoalSql);
  

?>

    <div class="schedule" style="clear: both;">
        <form class="schedule_form" id="schedule_form" method="post">
            목표
            <select name="goal" id="goal">

                <option value="temp" selected="selected" disabled hidden>목표 선택</option>

                <?php
            
            if($goalResult!=null){
                while($goalRow = mysqli_fetch_array($goalResult,MYSQLI_ASSOC)){
                    if(strtotime($today) >= strtotime($goalRow['startTerm']) && strtotime($today) <= strtotime($goalRow['endTerm'])){
                        echo "<option value='".$goalRow['goalID']."'>".$goalRow['goalName']."</option>";
                        
                    }
                    
                }
                echo "<option value='0'>일정 직접 입력</option>";
                
            }
            
            ?>
            </select>
            <div class="routineSelect">
                <br> 루틴
                <select name="routine" id="routine">
                    <option value="" selected="selected" disabled hidden>루틴 선택</option>
                    <!--<option value="routineID1">루틴 1</option>
            <option value="routineID2">루틴 2</option>
            <option value="routineID3">루틴 3</option>-->
                </select>
            </div>
            <br> 시간
            <label><input type="time" name="startTime"> - <input type="time" name="endTime"></label>
            <br>
        </form>
        <label for="submit_schedule" style="cursor: pointer;">
            <i class="fas fa-plus-circle fa-2"></i>
            <a id="submit_schedule" onclick="submitForm();">추가하기</a>


        </label>

    </div>
    <?php
    $selectTrackerSql = "SELECT * FROM timetracker WHERE date='$today' and userID=$userid";
    $trackerResult = mysqli_query($conn,$selectTrackerSql);
    $trackerRow = mysqli_fetch_array($trackerResult, MYSQLI_ASSOC);
    

?>
    <div class="schedule-list text-left">
        <!-- timetracker.php 참고 -->
        <h3 style="margin-bottom:10px; ">추가된 루틴</h3>
        <div id="scheduleList">
    <?php
        
        $routineCount = 0;
        if($trackerRow){ 
    
        $trackerID = $trackerRow['trackerID'];
        $selecttRoutineSql = "select * from t_routine WHERE trackerID = '$trackerID'";
        $selectScheduleSql = "select * from schedule where trackerID = '$trackerID'";
        $troutineResult = mysqli_query($conn,$selecttRoutineSql);
        $scheduleResult = mysqli_query($conn,$selectScheduleSql);
        while($troutineRow = mysqli_fetch_array($troutineResult, MYSQLI_ASSOC)){
            $routineStart[$routineCount] = date('H:i',strtotime($troutineRow['startTime']));
            $routineEnd[$routineCount] = date('H:i',strtotime($troutineRow['endTime']));
            $routineID[$routineCount] = $troutineRow['routineID'];
            $routineSql = "select * from routine where routineID =$routineID[$routineCount]";
            $routineRow = mysqli_fetch_array(mysqli_query($conn,$routineSql),MYSQLI_ASSOC);
            $routineName[$routineCount] = $routineRow['routineName'];
            $routineColor[$routineCount] = $routineRow['color'];
            $routineKind[$routineCount] = 1;
            $routineCount++;
            //TODO: 색깔 바꾸기
        }
        while($scheduleRow = mysqli_fetch_array($scheduleResult, MYSQLI_ASSOC)){
            $routineStart[$routineCount] = date('H:i',strtotime($scheduleRow['startTime']));
            $routineEnd[$routineCount] = date('H:i',strtotime($scheduleRow['endTime']));
            $routineID[$routineCount] = $scheduleRow['scheduleID'];
            $routineName[$routineCount] = $scheduleRow['scheduleName'];
            $routineColor[$routineCount] = $scheduleRow['color'];
            $routineKind[$routineCount] = 2;
            $routineCount++;
            
        }
        
    }
    if($routineCount !=0){
        
    for($z=0;$z<$routineCount;$z++){
        if($routineKind[$z]==1){
            echo "<div id='routineList'><a class='fas fa-minus-circle' onclick= 'deleteRoutine($routineID[$z],\"$routineStart[$z]\");'></a>";
        }else{
            echo "<div id='routineList'><a class='fas fa-minus-circle' onclick= 'deleteSchedule($routineID[$z],\"$routineStart[$z]\");'></a>";
        }
        echo "<span> $routineStart[$z] - $routineEnd[$z] </span><span style='color: $routineColor[$z]'>$routineName[$z]</span>";
        echo "</div>"; 
        
        }
    
    }
       

    ?>
        </div>

    </div>
    <div class="saveSchedule text-center">
        <label for='saveScheduleBtn' style="cursor: pointer;">
            <i class="fas fa-check-circle"></i>
            <a id="saveScheduleBtn" onclick="add_schedule();"> 완료</a>
        </label>
    </div>

    <!-- 이 div는 지우면 right side bar가 밀립니다. 지우지 마세요 -->
    <div style="margin-top: 51px;"></div>

    <script>
        $(document).ready(function() {
            $('#goal').on('change', function() {
                var goalID = $(this).val();
                if (goalID != 0) {

                    $('.routineSelect').html('<br> 루틴 <select name="routine" id="routine"></select>');
                    $.ajax({
                        type: 'POST',
                        url: 'adminTimetracker.php',
                        data: 'goalID=' + goalID,
                        success: function(html) {
                            $('#routine').html(html);
                        }

                    });
                }
                else {
                    $('.routineSelect').html('<br> 일정 <input type="text" name="scheduleName" placeholder="일정 이름 입력"><input type="color" name="scheduleColor">');
                }
            });
        });

        function submitForm() {

            var form = $("form[id=schedule_form]").serialize();

            $.ajax({
                type: "POST",
                url: 'adminTimetracker.php',
                data: form,
                success: function(html) {
                    $('#scheduleList').append(html);
                },
                error: function(e) {

                    alert('error');
                }
            });
        }

        function deleteRoutine(routineID, startTime) {
            var ajaxDate = {"routineID":routineID,"startTime":startTime};
            $.ajax({
                type: "POST",
                url: 'adminTimetracker.php',
                data: ajaxDate,
                success: function(html) {
                    $('#scheduleList').html(html);
                },
                error: function(e) {

                    alert('error');
                }
            });

        }
        function deleteSchedule(scheduleID,startTime) {
            var ajaxDate = {"checkScheduleID":scheduleID, "startTime":startTime};
            $.ajax({
                type: "POST",
                url: 'adminTimetracker.php',
                data: ajaxDate,
                success: function(html) {
                    $('#scheduleList').html(html);
                    
                },
                error: function(e) {
                    alert('error');
                }
            });
            
        }

        function add_schedule() {
            var ele = document.querySelector('#scheduleList span');
            if (ele != null){
                
            $(".sidebar-right").load("timetracker.php");
                
            }else{
                
            $(".sidebar-right").load("no-tracker.php");
            }
        }

    </script>
