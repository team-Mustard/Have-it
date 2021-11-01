<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
include "./db/dbconn.php";
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
$time = time();
$today = date("Y-m-d",$time);
$selectDate = $today;


?>
    <div class="trackerTop" style="height:50px;">
            <div><h2 class="right-header" style="float: left;"><i class="fas fa-dolly-flatbed"></i>광산수레</h2></div>
            
              
              
        <div class="dateSelect" data-role="selectBox" style="float:right; z-index:3;" >
              <h4 date-value="selectDate" class="selectDate right-header"></h4>
            <ul class="hide">
            <li class="<?=$today?>"><?=$today?></li>    
                
<?php 
    for($i=1;$i<=7;$i++){
        
        $datetmp = date("Y-m-d",strtotime($today."-$i days"));
        $tmpSql = "select * from timetracker where date = '$datetmp' and userid = $userid";
        $tmpRow = mysqli_fetch_array(mysqli_query($conn,$tmpSql),MYSQLI_ASSOC);
        if($tmpRow){
            $trackerDate = $tmpRow['date'];
            echo "<li class='$trackerDate'>$trackerDate</li>";
            $trackerflag= 1;
        }
    }  
?>
              </ul>
        
              </div>
              
            </div>
    
  <div class="text-center" style="clear: both; padding:40% 0;">
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

    
const body = document.querySelector('body');
const select = document.querySelector(`[data-role="selectBox"]`);
const values = select.querySelector(`[date-value="selectDate"]`);
const option = select.querySelector('ul');
const opts = option.querySelectorAll('li');

/* 셀렉트영역 클릭 시 옵션 숨기기, 보이기 */
function selects(e){
    e.stopPropagation();

    option.setAttribute('style',`top:${select.offsetHeight}px`)
    if(option.classList.contains('hide')){
        option.classList.remove('hide');
        option.classList.add('show');
        
    }else{
        option.classList.add('hide');
        option.classList.remove('show');
    }
    selectDate();
}



function selectDate(){
    opts.forEach(opt=>{
        const innerValue = opt.innerHTML;
        function changeValue(){
            if(innerValue !=values.innerHTML){
                values.innerHTML = innerValue;
                trackerPrint(innerValue);
                
            }
        }
        opt.addEventListener('click',changeValue);
        
    });
    
}
function trackerPrint(v){
    $(".sidebar-right").load("timetracker.php?date="+v+"&exist=0");
    
    
}
function selectFirst(){
    const tdate = '<?=$selectDate?>';
    values.innerHTML = `${tdate}`
    
}

function hideSelect(){
    if(option.classList.contains('show')){
        option.classList.add('hide');
        option.classList.remove('show');
    }
}

selectFirst();
select.addEventListener('click',selects);
body.addEventListener('click',hideSelect);

    
    
</script>
    
