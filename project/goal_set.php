<?php
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
?>
<div class="col-md-1">
    <!-- 빈 공간 -->
</div>
<div class="main col-md-8 col-md-offset-2">
    
    <h3><b>목표 추가하기</b></h3>
    <hr style="border:0; margin-bottom:25px; height:3px; background: #04005E;">
    
    <div style="margin:20px 20%;" class="text-center">
        <form class="goal_set_form" name="goal_set_form" method="post" action="db/goal_save.php">
            <input id="goal_name" name="goal_name" type="text" placeholder="새로운 목표 이름" required/><br/>
            
            <p style="margin-bottom:10px;">기간　:
            
            <input id="term_sel" type="radio" name="term" value="select" required>
            <label for="term_sel">선택</label>
            <input id="term_a_month" type="radio" name="term" value="a-month">
            <label for="term_a_month">한달</label>
            <input id="term_3_month" type="radio" name="term" value="3-month">
            <label for="term_3_month">세달</label>    
            <input id="term_year" type="radio" name="term" value="year">
            <label for="term_year">1년</label><br/>
            <!-- 평소엔 display:none, '선택'항목에 radio 선택되면 display: inline; -->
            <span id="termtime" style="display:none;">
            <label style="font-weight:normal;"><input type="date" name="term_s_date" style="margin-left: 60px; margin-top:10px;"> 부터　</label>
            <label style="font-weight:normal;"><input type="date" name="term_e_date" style="margin-top:10px;"> 까지</label>
            </span>
            </p>            
            
            <hr id="between"> 
            
            <div id="div_routine0">
                <!-- <input name="routine_name<?=$routine_num?>" class="routine_name" type="text" placeholder="루틴 이름" required/> <input type="color"><br>

                <p style="margin-bottom:10px;" required>주기　:
                <input id="mon<?=$routine_num?>" type="checkbox" name="routine<?=$routine_num?>[]" value="mon"><label for="mon<?=$routine_num?>">월</label>
                <input id="tue<?=$routine_num?>" type="checkbox" name="routine<?=$routine_num?>[]" value="tue"><label for="tue<?=$routine_num?>">화</label>
                <input id="wed<?=$routine_num?>" type="checkbox" name="routine<?=$routine_num?>[]" value="wed"><label for="wed<?=$routine_num?>">수</label>
                <input id="thu<?=$routine_num?>" type="checkbox" name="routine<?=$routine_num?>[]" value="thu"><label for="thu<?=$routine_num?>">목</label>
                <input id="fri<?=$routine_num?>" type="checkbox" name="routine<?=$routine_num?>[]" value="fri"><label for="fri<?=$routine_num?>">금</label>
                <input id="sat<?=$routine_num?>" type="checkbox" name="routine<?=$routine_num?>[]" value="sat"><label for="sat<?=$routine_num?>">토</label>
                <input id="sun<?=$routine_num?>" type="checkbox" name="routine<?=$routine_num?>[]" value="sun"><label for="sun<?=$routine_num?>">일</label><br/>
                </p> -->
            </div>
            
            <input id="plus_btn" type="button" value="+ 루틴 추가하기" onclick="plus_routine()"><br/><br/>
            <p style="float:right; margin-right: 80px;">
                <input type="reset" value="삭제" class="word_2_btn bg_gray_btn round_btn">
                <input type="submit" onclick="goal_set_submit()" value="저장" class="word_2_btn bg_purple_btn round_btn">
            </p>
            <input style="display:none" id="routineNum" type="text" name="routineNum" value="">
        </form>
    </div>
</div>
</div>
<div class="col-md-2">
    <!-- 빈 공간 -->
</div>


<script>
    var routine_num = 0;
    var rad = document.goal_set_form.term;
    for (var i = 0; i < rad.length; i++) {
        rad[i].addEventListener('change', function() {
            if (this.value == "select") {
                document.getElementById("termtime").style.display = "inline";
            }
            else {
                document.getElementById("termtime").style.display = "none";
            }
        });
    }
    
    function plus_routine() {
      var content = document.getElementById("div_routine"+routine_num);
      var new_routine = '<input name="routine_name'+routine_num+'" class="routine_name" type="text" placeholder="루틴 이름" required/> <input type="color" name="colors'+routine_num+'"><br><p style="margin-bottom:10px;">주기　:<input id="sun'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="sun"><label for="sun'+routine_num+'">일</label><input id="mon'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="mon"><label for="mon'+routine_num+'">월</label><input id="tue'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="tue"><label for="tue'+routine_num+'">화</label><input id="wed'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="wed"><label for="wed'+routine_num+'">수</label><input id="thu'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="thu"><label for="thu'+routine_num+'">목</label><input id="fri'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="fri"><label for="fri'+routine_num+'">금</label><input id="sat'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="sat"><label for="sat'+routine_num+'">토</label><br/></p>';     
      routine_num++;
      new_routine += '<div id="div_routine'+routine_num+'"></div>';
      content.innerHTML += new_routine;
        
      document.getElementById('routineNum').value = routine_num;
    }
    
    function goal_set_submit() {
        var form = document.goal_set_form;
        for(var i=0; i<routine_num; i++){
            var routines = document.getElementsByName("routine"+i+"[]");
            var check = checkbox_permit(routines);
            if (!check) {
                var name_routine = document.getElementsByName("routine_name"+i)[0].value;
                alert(name_routine+" 루틴의 주기를 하루 이상 체크해 주세요!");
                return;
            }
        }
        form.submit();
    }
    
    function checkbox_permit(routines) {
        var ck_num = 0;
        for(var i=0; i<routines.length; i++) {
            if(routines[i].checked){
                ck_num++;
            }
        }
        return ck_num;
    }
  
    </script>
            
