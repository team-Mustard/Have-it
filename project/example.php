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
            <hr class="start">
            <p>
                목표는 내가 얻고싶은 보석💎을 뜻합니다.<br>
                새로운 목표와, 그 목표를 이루기 위한 작은 행동 단위인 루틴을 생성합니다.<br>
                지정한 기간동안 목표를 달성하기 위해, 루틴을 일정한 요일마다 수행합니다.<br>
                루틴은 개마다 인덱스 역할을 하는 대표색을 지정할 수 있습니다.
            </p>
            <h4>* 목표 추가하기</h4>
            <h5>1. 왼쪽 사이드 바에서 <img src="img/goal_add.png" alt="추가하기 버튼" style="height:25px; margin:1px 3px 5px 5px;"> 클릭!</h5> 
            <img src="img/goal_example_create.png" alt="목표 생성 구역 사진" width="500px">
            <h5>2. 목표 이름 입력하기</h5>
            <h5>3. 목표 기간 지정하기</h5>
            <p style="font-size:0.7em;">(한달, 세달, 1년은 오늘을 포함합니다)</p>
            <h5>4. 새로운 루틴 입력란 생성하기 </h5>
            <h5>5</h5>
            <p>
                -1. 루틴 이름 입력하기<br>
                -2. 루틴 대표색 지정하기<br>
                -3. 루틴 반복 주기 선택하기
            </p>
            <h5>6. <img src="img/goal_save.png" alt="저장 버튼" style="height:25px; margin:3px 5px 5px 5px;">눌러 목표를 추가하기</h5>
            
            
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
            <h5>4. <img src="img/goal_modifyComplete.png" alt="저장 버튼" style="height:25px; margin:3px 5px 6px 5px;">눌러 수정 완료하기<br></h5>
        </div>

    </div>


    <div class="example-schedule">
        <label for="schedule-manual">
            <h4><i id = "schedule-icon" class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i>
            <i class="fas fa-dolly-flatbed" style="color: dimgray; margin-right:10px;"></i>보석 캐러 가자! 시간표에 오늘의 일정 추가/변경하기</h4>
        </label>
        <input id="schedule-manual" type="checkbox" style="display:none;" onclick="changeTriangle('schedule-icon');">
        
        <div class = "schedule-content">
            <hr>
            <p>
                시간표를 통해 간편하게 하루의 일과를 들여다봅니다.<br>
                오늘의 일정을 계획하고, 실행한 일정은 ✔체크✔합니다.
            </p>
            <h4>* 일정 추가하기</h4>
            <p>
                등록된 루틴으로 오늘 하루의 일정을 채웁니다.<br>
                루틴 외의 일정도 직접 입력할 수 있습니다.
            </p>
            <h5>1. 우측 상단에서 <i class="fas fa-dolly-flatbed" style="color: dimgray; margin-right:10px;"></i>아이콘 클릭!</h5> 
            <img src="img/example_schedule_create.png" alt="일정 생성 구역 사진" width="500px">
            <h5>2. <img src="img/schedule-scheadd.png" alt="일정 추가 버튼" style="height:30px; padding-bottom:5px; margin:0;"> 클릭!</h5>
            <h5>3</h5>
            <p>
                -1. 목표 선택하기<br>
                -2. 루틴 선택하기<br>
                -3. 시간 저장하기<br>
                -4. '일정 직접 입력'을 선택하면 1회성 일정을 직접 등록하고 색상을 지정할 수 있습니다.<br>
                　  1회성 일정은 루틴으로 추가되지 않고 오늘 한 번만 사용됩니다. 품질 보증서에서도 다루지 않습니다.
            </p>
            <h5>4. <img src="img/schedule-add.png" alt="+추가하기 버튼" style="height:25px; margin:0;"> 눌러서 일정에 등록하기</h5>
            <h5>5. 잘못 추가한 루틴은 <i class="fas fa-minus-circle"></i>눌러서 삭제하기</h5>
            <h5>6. <img src="img/schedule-save.png" alt="확인 버튼" style="height:30px; padding-bottom:5px; margin:0;"> 버튼을 눌러 등록 완료하기</h5>
            
            <h4>* 일정 변경하기</h5>
            <p>
                오늘 일정을 완료 또는 변경되거나 추가된 경우, 시간표도 변경할 수 있습니다.
            </p>
            <h5>1. 우측 상단에서 <i class="fas fa-dolly-flatbed" style="color: dimgray; margin-right:10px;"></i>아이콘 클릭!</h5> 
            <img src="img/example_schedule_modi.png" alt="일정 변경 구역 사진" width="215px">
            <h5>2. 완료한 일정을 체크박스에 체크✔해 표시하기</h5>
            <h5>3. <img src="img/schedule-scheadd.png" alt="일정 추가 버튼" style="height:30px; padding-bottom:5px; margin:0;"> 클릭!</h5>
            <p style="font-size:0.8em;">일정을 추가, 삭제하는 페이지로 이동해 원하는 대로 변경합니다.</p>
        </div>
    </div>

    <div class="example-eval">
        <label for="eval-manual">
            <h4><i id ="eval-icon" class="fas fa-caret-right" style="font-size:30px; margin:0px 4px;"></i> 📃 품질 보증서, 나의 수행을 평가하기</h4></label>
        <input id="eval-manual" type="checkbox" style="display:none;" onclick="changeTriangle('eval-icon');">
        <div class="eval-content">
            <hr>
            <p>
                한 주 또는 한 달동안 계획을 성실하게 수행했는지, 부족한 부분은 없는지<br>
                보석의 품질 보증서에 비유한 리포트를 발행합니다.<br>
                시간표에서 실행한 일과에 체크(✔)하면 주간, 월간 품질 보증을 받을 수 있습니다.
            </p>
            <h4>* 주간 리포트</h4>
                <p>
                    주간 품질보증서는 매주 월요일마다 자동으로 발행됩니다.<br>
                    한 주간 루틴 성취도를 수치와 그래프로 확인할 수 있습니다.
                </p>
                <img src="img/example_report_week.png" alt="주간리포트 구역 사진" width="400px">
                <h5>1. 지난 주의 대표 이미지 등록하기</h5>
                <h5>2. 지난 주에 대해 스스로 점수 주기</h5>
                <h5>3. 스스로 칭찬 또는 반성하기</h5>
                <h5>4. 루틴 수행을 방해하는 요인 체크하기</h5>
                <h5>5. <img src="img/goal_save.png" alt="저장 버튼" style="height:25px; margin:3px 5px 5px 5px;">눌러 평가 완료하기<br></h5>
            <h4>* 월간 리포트</h4>
                <p>
                    월간 품질보증서는 매월 1일에 자동으로 발행됩니다.<br>
                    다양한 관점의 그래프를 한눈에 볼 수 있는 월간 품질보증서는<br>
                    앞으로의 계획을 정비하는 데 이정표 역할을 할 것입니다.
                </p>
                <img src="img/example_report_month.png" alt="월간리포트 구역 사진" width="400px">
                <h5>1. 시간, 주차, 요일별 목표 성취도를 그래프로 확인하기</h5>
                <img src="img/example_report_month_graph.png" alt="시간, 주차, 요일별 목표 성취도 그래프 전환" width="500px">
                <h5>2. 계획 대비 실행률이 가장 낮은 루틴 확인하기</h5>
                <p style="font-size:0.8em; margin-bottom:25px;"> 
                    <img src="img/go_routine1.png" alt="루틴 바로가기 버튼" width="100px" style="margin:0px 3px">클릭하여 해당 목표 페이지로 이동하고,<br>
                    좀 더 지키기 쉬운 루틴을 계획합니다.
                </p>
                <h5>3. 계획 대비 실행률이 가장 높은 루틴 확인하기</h5>
                <p style="font-size:0.8em; margin-bottom:25px;"> 
                    <img src="img/go_routine2.png" alt="새로운 루틴 생성하기 버튼" width="100px" style="margin:0px 3px">클릭하여 해당 목표 페이지로 이동하고,<br>
                    목표를 이루기 위해 더 발전된 루틴을 계획합니다.
                </p>
        </div>
    </div>

    <div>
        <p style="color: #777; bottom:-50px; right:10px; position:absolute;">
            Error Report : pmis118@naver.com
        </p>
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
