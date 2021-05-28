<div><h2 class="right-header" style="float: left;"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
<?php
    $time = time();
    $today = date("Y-m-d", $time);
    //$today = "2021-04-30";
    echo '<h4 class="right-header" style="float: right;">'.$today.'</h4>';
?>
</div>
<?php
session_start();
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
include "db/dbconn.php";
$selectGoalSql = "select * from goal where userid = $userid";
$goalResult = mysqli_query($conn,$selectGoalSql);
  

?>
<div class="schedule" style="clear: both;">
    <form class="schedule_form" id="schedule_form" method="post">
        목표
        <select name = "goal" id="goal">
            
            <option value="" selected="selected">목표 선택</option>
            
            <?php
            
            if($goalResult!=null){
                while($goalRow = mysqli_fetch_array($goalResult,MYSQLI_ASSOC)){
                    if(strtotime($today) >= strtotime($goalRow['startTerm']) && strtotime($today) <= strtotime($goalRow['endTerm'])){
                        echo "<option value='".$goalRow['goalID']."'>".$goalRow['goalName']."</option>";
                        
                    }
                    
                }
                
            }
            
            ?>
        </select>
        <br> 루틴
        <select name = "routine" id="routine">
            <option value="" selected="selected">루틴 선택</option>
            <!--<option value="routineID1">루틴 1</option>
            <option value="routineID2">루틴 2</option>
            <option value="routineID3">루틴 3</option>-->
        </select>
        <br> 시간
        <label><input type="time" name="startTime"> ~ <input type="time" name="endTime"></label>
        <br>
        <label for="submit_schedule" style="cursor: pointer;"><i class="fas fa-plus-circle fa-2"></i></label><input id="submit_schedule" type="submit" value=" 추가하기" onclick="submitForm();">
    </form>
    <a class="glyphicon glyphicon-ok-circle" aria-hidden="true" onclick="document.getElementById('weeklyform').submit();"></a>
    <button onclick="submitForm();">이걸 눌러보자</button>
</div>
<?php
    $selectTrackerSql = "SELECT * FROM timetracker WHERE date='$today' and userID=$userid";
    $trackerResult = mysqli_query($conn,$selectTrackerSql);
    $trackerRow = mysqli_fetch_array($trackerResult, MYSQLI_ASSOC);
    

?>
<div class="schedule-list text-left"> <!-- timetracker.php 참고 -->
    <h3 style="margin-bottom:10px;">추가된 루틴</h3>
    <div id = "scheduleList">
    <?php
        
        if($trackerRow){ 
    
        $trackerID = $trackerRow['trackerID'];
        $selecttRoutineSql = "select * from t_routine WHERE trackerID = '$trackerID'";

        $troutineResult = mysqli_query($conn,$selecttRoutineSql);
    
        $routineCount = 0;
        while($troutineRow = mysqli_fetch_array($troutineResult, MYSQLI_ASSOC)){
            $routineCount++;
            $startTime = date('H:i',strtotime($troutineRow['startTime']));
            $endTime = date('H:i',strtotime($troutineRow['endTime']));
            $routineID = $troutineRow['routineID'];
            $routineSql = "select * from routine where routineID =$routineID ";
            $routineRow = mysqli_fetch_array(mysqli_query($conn,$routineSql),MYSQLI_ASSOC);
            $routineName = $routineRow['routineName'];

            echo "<div><a class='fas fa-minus-circle' onclick= 'deleteRoutine($routineID);'></a>";
            echo "<span> $startTime ~ $endTime </span><span style='color: white'>$routineName</span>";
            echo "</div>";
        }
    }
    ?>
    </div>
</div>
    
    <!-- 이 div는 지우면 right side bar가 밀립니다. 지우지 마세요 -->
    <div style="margin-top: 51px;"></div>

<script>
    $(document).ready(function() {
        $('#goal').on('change', function() {
            var goalID = $(this).val();
            if(goalID) {
                $.ajax({
                    type: 'POST',
                    url: 'adminTimetracker.php',
                    data: 'goalID=' + goalID,
                    success: function(html) {
                        $('#routine').html(html);
                    }

                });
            } else {
                $('#routine').html('<option value="">루틴 없는데요?</option>');
            }
        });
    });
    function submitForm(){
        
        var form = $("form[id=schedule_form]").serialize();
        $.ajax({
			type: "POST",
			url: 'adminTimetracker.php',	
			data: form,
			success: function (html) {
				$('#scheduleList').append(html);
			},
			error: function (e) {

				alert('error');
			}
		});      
    }
    function deleteRoutine(routineID){
        $.ajax({
			type: "POST",
			url: 'adminTimetracker.php',	
			data: 'routineID='+ routineID,
			success: function (html) {
				$('#scheduleList').html(html);
			},
			error: function (e) {

				alert('error');
			}
		});   
        
        
        
    }

</script>