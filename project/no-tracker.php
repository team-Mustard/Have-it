<div class="col-xs-12 col-sm-7 col-md-4 sidebar sidebar-right sidebar-animate">
  <div><h2 class="right-header" style="float: left;"><i class="fas fa-dolly-flatbed"></i>광산수레</h2>
    <?php
        $time = time();
        $today = date("Y-m-d", $time);
        //$today = '2021-04-30';
        echo '<h4 class="right-header" style="float: right;">'.$today.'</h4>';
    ?>
  </div>
    
    
  <div class="text-center" style="clear: both; padding:50% 0;">
      <img src="img/no-tracker.png">
      <h3>오늘은 일정이 없어요!</h3>
      
      <h4><i class="fas fa-plus-circle schedule_add" onclick="add_schedule()"> 일정 추가하기</i></h4>
  </div>

    
    <!-- 이 div는 지우면 right side bar가 밀립니다. 지우지 마세요 -->
    <div style="margin-top: 51px;"></div>
</div>

<script>
    function add_schedule() {
        $(".sidebar-right").load("add_schedule.php");
    }
</script>