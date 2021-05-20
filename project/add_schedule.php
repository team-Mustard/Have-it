<div><h2 class="right-header" style="float: left;"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
<?php
    $time = time();
    $today = date("Y-m-d", $time);
    echo '<h4 class="right-header" style="float: right;">'.$today.'</h4>';
?>
</div>

<div class="schedule" style="clear: both;">
    <form class="schedule_form" name="schedule_form" method="post" action="db/......php">
        목표
        <select name="goal">
            <option value="" selected="selected">목표 선택</option>
            <option value="goalID1">목표 1</option>
            <option value="goalID2">목표 2</option>
            <option value="goalID3">목표 3</option>
        </select>
        <br> 루틴
        <select name="routine">
            <option value="" selected="selected">루틴 선택</option>
            <option value="routineID1">루틴 1</option>
            <option value="routineID2">루틴 2</option>
            <option value="routineID3">루틴 3</option>
        </select>
        <br> 시간
        <label><input type="time" name="time_s"> ~ <input type="time" name="time_e"></label>
        <br>
        <label for="submit_schedule" style="cursor: pointer;"><i class="fas fa-plus-circle fa-2"></i></label><input id="submit_schedule" type="submit" value=" 추가하기">
    </form>
</div>
    
<div class="schedule-list text-left"> <!-- timetracker.php 참고 -->
    <h3 style="margin-bottom:10px;">추가된 루틴</h3>
        <div><i class="fas fa-minus-circle"></i>
            <span>12:00 ~ 13:00　</span><span style="color: white">오늘의 루틴~</span>
        </div>
        <div><i class="fas fa-minus-circle"></i>
            <span>13:00 ~ 15:00　</span><span style="color: white">오늘의 루틴~</span>
        </div>
        <div><i class="fas fa-minus-circle"></i>
            <span>15:00 ~ 15:30　</span><span style="color: white">오늘의 루틴~</span>
        </div>
        <div><i class="fas fa-minus-circle"></i>
            <span>16:00 ~ 19:00　</span><span style="color: white">오늘의 루틴~</span>
        </div>
</div>
    
    <!-- 이 div는 지우면 right side bar가 밀립니다. 지우지 마세요 -->
    <div style="margin-top: 51px;"></div>