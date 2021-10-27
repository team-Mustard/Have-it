<div class="col-md-1">
</div>
<div class="main col-md-8 col-md-offset-2">
<div class="example-img no-drag">
    <div class="text-center">
        <img width="640px" src="img/example-manual-1.png" alt="전체 설명 구역 사진">
    </div>
        
    <div class="example-goal">
        
        <label for="goal-manual">
            <h4><i id = "goal-icon" class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i>💎 나만의 보석을 찾는 여정, 목표 추가하기</h4>
        </label>
        <input id="goal-manual" type="checkbox" style="display:none" onclick="changeTriangle('goal-icon');">
        
        <div class="goal-content">
            <hr>
            <p>
                새로운 목표와, 그 목표를 이루기 위한 작은 단위인 루틴을 생성합니다.<br>
                지정한 기간동안 목표를 달성하기 위해, 루틴을 일정한 요일마다 수행합니다.<br>
                루틴은 개마다 인덱스 역할을 하는 대표색을 지정할 수 있습니다.
            </p>
            <h4>* 목표 추가하기</h4>
            <h5>1. 왼쪽 사이드 바에서 <img src="img/goal_add.png" alt="추가하기 버튼" style="height:25px; border:1px solid grey; margin:1px 3px 5px 5px;"> 클릭!</h5> 
            <img src="img/goal_example_create.png" alt="목표 생성 구역 사진" width="500px">
            <h5>2. 목표 이름 입력하기</h5>
            <h5>3. 목표 기간 지정하기</h5>
            <p>(한달, 세달, 1년은 오늘을 포함합니다)</p>
            <h5>4. 새로운 루틴 입력란 생성하기 </h5>
            <h5>5</h5>
            <p>
                -1. 루틴 이름 입력하기<br>
                -2. 루틴 대표색 지정하기<br>
                -3. 루틴 반복 주기 선택하기
            </p>
            <h5>6. <img src="img/goal_save" alt="저장 버튼" style="height:25px; margin:3px 5px 5px 5px;">눌러 목표를 추가하기</h5>
            
            
            <h4>* 목표 수정하기</h4>
            <p>
                왼쪽 사이드 바에 있는 목표 리스트를 클릭하면 상세페이지로 이동합니다.<br>
                PDCA사이클에 따라 목표의 루틴을 수정할 경우, 다음과 같은 절차가 필요합니다.
            </p>
            <img src="img/goal_example_modi.png" alt="목표 수정 구역 사진" width="600px">
            <h5>1. 원하는 목표 리스트를 클릭하여 상세페이지로 이동</h5>
            <h5>2. <img src="img/goal_modify.png" alt="목표수정 버튼" style="height:25px; margin:3px 3px 6px 3px;">클릭!</h5>
            <h5>3</h5>
            <p>
                -1. 목표 이름 수정하기<br>
                -2. 목표 기간 수정하기<br>
                -3. 루틴 이름 수정하기<br>
                -4. 루틴 대표색 수정하기<br>
                -5. 루틴 주기 수정하기<br>
                -6. 루틴 삭제하기<br>
                -7. 새로운 루틴 추가하기
            </p>
            <h5>4. <img src="img/goal_modifyComplete.png" alt="저장 버튼" style="height:25px; margin:3px 5px 6px 5px;">을 눌러 수정 완료하기<br></h5>
            <hr>
        </div>

    </div>


    <div class="example-schedule">
        <label for="schedule-manual">
            <h4><i id = "schedule-icon" class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i>
            <i class="fas fa-dolly-flatbed" style="color: dimgray; margin-right:10px;"></i>보석 캐러 가자! 광산수레에 오늘의 일정 추가/변경하기</h4>
        </label>
        <input id="schedule-manual" type="checkbox" style="display:none;" onclick="changeTriangle('schedule-icon');">
        
        <div class = "schedule-content">
            <hr>
            <h4>* 일정 추가하기</h4>
            <p>
                등록된 루틴으로 오늘 하루의 일정을 채웁니다.<br>
                루틴 외의 일정도 직접 입력할 수 있습니다.
            </p>
            <h5>1. 우측 상단에서 <i class="fas fa-dolly-flatbed" style="color: dimgray; margin-right:10px;"></i>아이콘 클릭!</h5> 
            <img src="img/example_schedule_create.png" alt="일정 생성 구역 사진" width="500px">
            <h5>2. <img src="img/schedule-scheadd.png" alt="일정 추가 버튼" style="height:30px; padding-bottom:5px;"> 클릭!</h5>
            <p>
                내가 결심한 목표별 루틴을 수행할 계획을 세워요<br>
                1.<img src="img/schedule-goal.png" alt="목표 선택 버튼" style="height:20px; border:1px solid grey; margin:3px 8px 5px 5px;">눌러서 목표 선택하기<br>
                2.<img src="img/schedule-routine.png" alt="루틴 선택 버튼" style="height:20px; border:1px solid grey; margin:3px 8px 5px 5px;">눌러서 루틴 선택하기<br>
                3.<img src="img/schedule-time.png" alt="시간 선택 폼" style="height:20px; border:1px solid grey; margin:3px 11px 5px 5px;">눌러서 시간 저장하기<br>
                4.<img src="img/schedule-add.png" alt="+추가하기 버튼" style="height:25px; margin:3px 13px 5px 5px;">눌러서 일정에 등록하기
            </p>
            <h5>2-2. 새로운 스케쥴을 일정에 등록하기</h5>
            <p>
                일회성 할 일을 등록할 수 있어요<br>
                1.<img src="img/schedule-goal.png" alt="목표 선택 버튼" style="height:20px; border:1px solid grey; margin:3px 5px 5px 5px;">에서 스케쥴 등록 선택하기<br>
                2.<img src="img/schedule-input.png" alt="스케쥴 입력 폼" style="height:25px; margin:3px 5px 5px 5px;">에 스케쥴 입력하기<br>
                3.<img src="img/schedule-time.png" alt="시간 선택 폼 " style="height:20px; border:1px solid grey; margin:3px 5px 5px 5px;">을 눌러서 시간 저장하기<br>
                4.<img src="img/schedule-add.png" alt="+추가하기 버튼 " style="height:25px; margin:3px 5px 5px 5px;">을 일정에 등록하기
            </p>
            <h5>3. <img src="img/schedule-save.png" alt="확인 버튼" style="height:30px; padding-bottom:5px; margin-right:3px;">버튼을 눌러 등록 완료하기</h5>
            <h4>* 일정 변경하기</h4>
            <h5>1. <img src="img/schedule-scheadd.png" alt="+ 일정 추가하기" style="height:30px; padding-bottom:5px; margin-right:3px;">클릭!</h5>
            <h5>2-1. 등록된 루틴 스케쥴 삭제하기</h5>
            <h5>2-2. 더 많은 루틴/스케쥴 등록하기</h5>
            <hr>
        </div>
    </div>
            <div class="example-eval">
                <label for="eval-manual">
                    <h4><i id ="eval-icon" class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i> 📃 나의 수행을 평가하기</h4></label>
                <input id="eval-manual" type="checkbox" style="display:none;" onclick="changeTriangle('eval-icon');">
                <div class="eval-content">
                    <h4>* 주간 리포트</h4>
                        <h5>1. 주간 리포트는 매주 월요일마다 자동으로 생성돼요</h5>
                        <h5>2. 그래프를 통해 요일별 루틴 성취도를 목표별로 확인할 수 있어요</h5>
                        <h5>3. 본인의 한 주 평가하고 돌아보기!</h5>
                            <p>1. 지난 일주일에 대해 점수를 줄 수 있어요<br>
                                2. 리포트에 이미지를 추가할 수 있어요<br>
                                3. 일주일 동안의 칭찬할 점과 반성할 점을 작성할 수 있어요<br>
                                4. 루틴을 수행하지 못한 이유를 체크할 수 있어요
                            </p>
                        <h5>4. 수정 사항은 <i class="glyphicon glyphicon-ok-circle" aria-hidden="true" style="margin-right:2px;"></i>을 눌러 저장할 수 있어요</h5>
                    <h4>* 월간 리포트</h4>
                        <h5>1. 매월 1일마다 월간 리포트가 자동으로 생성돼요</h5>
                        <h5>2. 한 달간의 루틴 성취도를 목표별로 시간, 주차, 요일 카테고리 별로 확인할 수 있어요</h5>
                        <h5>3. 가장 실패율이 높은 루틴과 성공률이 높은 루틴을 확인할 수 있어요</h5>
                            <p> * 루틴 바로가기와 새로운 루틴 생성하기 버튼 클릭 시 해당 목표 페이지로 이동합니다<br>
                                &nbsp;실패율이 높은 루틴을 수정하거나 루틴을 새롭게 추가해보세요!
                            </p>
                        <h5>4. 주간 리포트에서 체크했던 한달간의 루틴 실패 원인을 원형 그래프로 확인할 수 있어요</h5>
                        <h5>5. 지난 5달간의 성취도 추이를 확인할 수 있어요</h5>
                        <h5>6. 다른 사용자와 성취도를 비교하여 이번 달의 성취도가 상위 몇프로 인지 확인할 수 있어요</h5>
                </div>
            </div>
            
    </div>
<div class="col-md-1">
</div>
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
