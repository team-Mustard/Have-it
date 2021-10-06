<div class="col-md-1">
</div>
<div class="main col-md-8 col-md-offset-2">
    <div class="example-img no-drag">
        <!--<img width="840px" src="img/example-manual-1.png">-->
        
        <!--To-Do: 메뉴 오픈 시 왼쪽 사이드바 크기가 줄어드는 버그 픽스-->
        <div class="example-back">
            <label><h3  style="margin:0px 23px;"><i class="fas fa-question-circle fa-2" ></i> 이 페이지로 다시 돌아오기</h3></label>
        </div>
        <div class="example-goal">
            <label for="goal-manual">
                <h3><i id = "goal-icon" class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i>💎 나만의 보석을 찾으러 가기</h3></label>
            <input id="goal-manual" type="checkbox" style="display:none" onclick="changeTriangle('goal-icon');">
            <div class="goal-content">
                <h3>* 목표 추가하기</h3>
                    <h4>1. <img src="img/goal_add.png" alt="추가하기 버튼" style="height:25px; border:1px solid grey; margin:1px 3px 5px 5px;"> 클릭!</h4> 
                    <h4>2. 목표 이름 입력하기</h4>
                    <h4>3. 목표 달성 기간을 선택하기</h4>
                        <p>* 선택: 시작일과 종료일을 선택<br>
                            * 한달: 오늘을 포함하여 한달<br>
                            * 세달: 오늘을 포함하여 세달<br>
                            * 1년: 오늘을 포함하여 1년</p>
                    <h4>4. <img src="img/goal_routineAdd.png" alt="루틴 추가하기 버튼" style="height:25px; margin:1px 3px 5px 5px;">버튼을 눌러서 새로운 루틴 입력란 생성하기 </h4>
                    <h4>5. 루틴 이름 입력하기</h4>
                    <h4>6. <img src="img/goal_color.png" alt="컬러 선택 폼" style="height:25px; margin:3px 5px 5px 5px;">에서 루틴 대표색 지정하기</h4>
                    <h4>7. 루틴 반복 주기 선택하기</h4>
                    <h4>8. <img src="img/goal_save" alt="저장 버튼" style="height:25px; margin:3px 5px 5px 5px;">눌러 목표를 추가하기</h4>
                <h3>* 목표 수정하기</h3>
                    <h4>1. 왼쪽 상단의 <img src="img/goal_modify.png" alt="목표수정 버튼" style="height:25px; margin:3px 3px 6px 3px;">클릭!</h4>
                    <h4>2-1. 목표 이름과 기간 수정하기</h4>
                        <p>1. 변경될 목표 이름 입력하기<br>
                            2. 변경될 기간 입력하기<br>
                            3. <img src="img/goal_modifyComplete.png" alt="저장 버튼" style="height:25px; margin:3px 5px 6px 5px;">을 눌러 수정 완료하기<br>
                            4. <img src="" alt="취소 버튼">을 눌러 이전 화면으로 되돌아가기
                        </p>
                    <h4>2-2. 루틴 이름과 대표 색, 주기 수정하기</h4>
                        <p>1. 변경될 루틴의 루틴 이름 입력하기<br>
                            2. 변경될 루틴의 대표색 지정하기<br>
                            3. 변경될 루틴의 주기 선택하기<br>
                            4. <img src="img/goal_modifyComplete.png" alt="저장 버튼" style="height:25px; margin:3px 5px 6px 5px;">을 눌러 수정 완료하기<br>
                            5. <img src="" alt="취소 버튼">을 눌러 이전 화면으로 되돌아가기<br>
                        </p>
            </div>
        
        </div>
        <div class="example-schedule">
            <label for="schedule-manual">
                <h3><i id = "schedule-icon" class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i>
                <i class="fas fa-dolly-flatbed" style="color: dimgray; margin-right:10px;"></i>오늘 일정을 추가/변경하기</h3>
            </label>
            <input id="schedule-manual" type="checkbox" style="display:none;" onclick="changeTriangle('schedule-icon');">
            <div class = "schedule-content">
                <h3>* 일정 추가하기</h3>
                
                    <h4>1. <img src="img/schedule-scheadd.png" alt="일정 추가 버튼" style="height:30px; padding-bottom:5px;"> 클릭!</h4> 
                    <h4>2-1. 나의 루틴을 일정에 등록하기</h4>
                        <p>내가 결심한 목표별 루틴을 수행할 계획을 세워요<br>
                            1.<img src="img/schedule-goal.png" alt="목표 선택 버튼" style="height:20px; border:1px solid grey; margin:3px 8px 5px 5px;">눌러서 목표 선택하기<br>
                            2.<img src="img/schedule-routine.png" alt="루틴 선택 버튼" style="height:20px; border:1px solid grey; margin:3px 8px 5px 5px;">눌러서 루틴 선택하기<br>
                            3.<img src="img/schedule-time.png" alt="시간 선택 폼" style="height:20px; border:1px solid grey; margin:3px 11px 5px 5px;">눌러서 시간 저장하기<br>
                            4.<img src="img/schedule-add.png" alt="+추가하기 버튼" style="height:25px; margin:3px 13px 5px 5px;">눌러서 일정에 등록하기</p>
                    <h4>2-2. 새로운 스케쥴을 일정에 등록하기</h4>
                        <p>일회성 할 일을 등록할 수 있어요<br>
                            1.<img src="img/schedule-goal.png" alt="목표 선택 버튼" style="height:20px; border:1px solid grey; margin:3px 5px 5px 5px;">에서 스케쥴 등록 선택하기<br>
                            2.<img src="img/schedule-input.png" alt="스케쥴 입력 폼" style="height:25px; margin:3px 5px 5px 5px;">에 스케쥴 입력하기<br>
                            3.<img src="img/schedule-time.png" alt="시간 선택 폼 " style="height:20px; border:1px solid grey; margin:3px 5px 5px 5px;">을 눌러서 시간 저장하기<br>
                            4.<img src="img/schedule-add.png" alt="+추가하기 버튼 " style="height:25px; margin:3px 5px 5px 5px;">을 일정에 등록하기</p>
                    <h4>3. <img src="img/schedule-save.png" alt="확인 버튼" style="height:30px; padding-bottom:5px; margin-right:3px;">버튼을 눌러 등록 완료하기</h4>
                <h3>* 일정 변경하기</h3>
                    <h4>1. <img src="img/schedule-scheadd.png" alt="+ 일정 추가하기" style="height:30px; padding-bottom:5px; margin-right:3px;">클릭!</h4>
                    <h4>2-1. 등록된 루틴 스케쥴 삭제하기</h4>
                    <h4>2-2. 더 많은 루틴/스케쥴 등록하기</h4>
            </div>
        </div>
        <div class="example-eval">
            <label for="eval-manual">
                <h3><i id ="eval-icon" class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i> 📃 나의 수행을 평가하기</h3></label>
            <input id="eval-manual" type="checkbox" style="display:none;" onclick="changeTriangle('eval-icon');">
            <div class="eval-content">
                <h3>* 주간 리포트</h3>
                    <h4>1. 주간 리포트는 매주 월요일마다 자동으로 생성돼요</h4>
                    <h4>2. 그래프를 통해 요일별 루틴 성취도를 목표별로 확인할 수 있어요</h4>
                    <h4>3. 본인의 한 주 평가하고 돌아보기!</h4>
                        <p>1. 지난 일주일에 대해 점수를 줄 수 있어요<br>
                            2. 리포트에 이미지를 추가할 수 있어요<br>
                            3. 일주일 동안의 칭찬할 점과 반성할 점을 작성할 수 있어요<br>
                            4. 루틴을 수행하지 못한 이유를 체크할 수 있어요
                        </p>
                    <h4>4. 수정 사항은 <i class="glyphicon glyphicon-ok-circle" aria-hidden="true" style="margin-right:2px;"></i>을 눌러 저장할 수 있어요</h4>
                <h3>* 월간 리포트</h3>
                    <h4>1. 매월 1일마다 월간 리포트가 자동으로 생성돼요</h4>
                    <h4>2. 한 달간의 루틴 성취도를 목표별로 시간, 주차, 요일 카테고리 별로 확인할 수 있어요</h4>
                    <h4>3. 가장 실패율이 높은 루틴과 성공률이 높은 루틴을 확인할 수 있어요</h4>
                        <p> * 루틴 바로가기와 새로운 루틴 생성하기 버튼 클릭 시 해당 목표 페이지로 이동합니다<br>
                            &nbsp;실패율이 높은 루틴을 수정하거나 루틴을 새롭게 추가해보세요!
                        </p>
                    <h4>4. 주간 리포트에서 체크했던 한달간의 루틴 실패 원인을 원형 그래프로 확인할 수 있어요</h4>
                    <h4>5. 지난 5달간의 성취도 추이를 확인할 수 있어요</h4>
                    <h4>6. 다른 사용자와 성취도를 비교하여 이번 달의 성취도가 상위 몇프로 인지 확인할 수 있어요</h4>
            </div>
        </div>
        <div class="example-mode">
            <label for="mode-manual">
            <h3><i id = "mode-icon" class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i> ⚫ 다크모드 적용하기</h3></label>
            <input id="mode-manual" type="checkbox" style="display:none;" onclick="changeTriangle('mode-icon');">
            <div class="mode-content">
                <h4>1. 오른쪽 하단의 <img src="img/mode-dark.png" alt="다크모드" style="padding-bottom:4px; margin-right:2px;">를 클릭하면 배경을 어두운 색으로 교체할 수 있어요.</h4>
                <h4>2. 다크 모드에서 같은 위치의 <img src="img/mode-light.png" alt="라이트모드" style="padding-bottom:4px; margin-right:2px;" >를 클릭하면 다시 원래대로 돌아올 수 있어요</h4>
            </div>
        </div>
        <div class="example-logout">
            <label for="logout-manual">
            <h3><i id="logout-icon"class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i> 👤 로그아웃 하기</h3>
            </label>
            <input id="logout-manual" type="checkbox" style="display:none;" onclick="changeTriangle('logout-icon')">
            <div class="logout-content">
                <h4>1. 어느 페이지에서나 오른쪽 하단의 <img src="img/logout.png" alt="로그아웃" style="padding-bottom:4px; margin-right:2px;">을 클릭하면 로그아웃 할 수 있어요</h4>
                <h4>2. 로그아웃을 하면 초기 화면으로 돌아가요</h4>
            </div>
        </div>
        
    </div>
</div>
<div class="col-md-1">
</div>

<script>

function changeTriangle(type){
    
    var className = document.getElementById(type).className;
    if(className == 'fas fa-caret-down'){
        
        document.getElementById(type).className = 'fas fa-caret-right';
    
    }else{
       document.getElementById(type).className = 'fas fa-caret-down';
    }
    
}


    
    


</script>
