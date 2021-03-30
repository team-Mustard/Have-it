        <div class="main col-md-10 col-md-offset-2">
          <div class="page-header">
            
    <script>
        function changeColor(change){
            var color = document.getElementById("basket");
            var color2 = document.getElementById("jew");
            color.style.backgroundColor = change;
            color2.style.color = change;                       
        }
        
        function changeColor2(change){
            var color = document.getElementById("basket2");
            var color2 = document.getElementById("jew2");
            color.style.backgroundColor = change;
            color2.style.color = change;
        }
    </script>
        
      <div class="container" style="background-color:white; margin-top: 20px;">
          <div class="con1" style="float: left; margin-right: 40px;">
              <form>
                  <div class="colors">
                      <p> 색깔 설정 </p>
                      <input type='color' id='myColor' onclick="changeColor(this.value)">
                  </div>
              </form>
          </div>
          <div class="con1" style="float: left; margin-top: 12px; margin-right: 15px;">
              <img src="title.png" width="52px" height="50px">
          </div>
          <div class="con1" style="margin-top: 8px; float: left;">
              <h3> 에메랄드 광산 캐기 </h3>
          </div>
      </div>
    
   
       
        
        <div id="basket" class="container">
            <div class="row no-gutters">             
                <div class="col-xs-1 col-md-1"><i id="jew" class="jew fa fa-trophy fa-3x" style="margin-top:7px; margin-left:7px" aria-hidden="true"></i></div>
                <div class="col-xs-1 col-md-1"></div>
                <div class="col-xs-1 col-md-1"></i></div>
                <div class="col-xs-1 col-md-1"></div>
                
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>                
                <!-- DB 연결하면 for문으로 다시 짜서 전체 보석 개수만큼 생성되도록 하면 되지~ 않을까`~ 글쎄 잘 모르겟네 ~ -->
            </div>
        </div>  
              
        <!-- 지울 곳 -->
            
            <div class="container" style="background-color:white; margin-top: 20px;">
          <div class="con1" style="float: left; margin-right: 40px;">
              <form>
                  <div class="colors">
                      <p> 색깔 설정 </p>
                      <input type='color' id='myColor' onclick="changeColor2(this.value)">
                  </div>
              </form>
          </div>
          <div class="con1" style="float: left; margin-top: 12px; margin-right: 15px;">
              <img src="jew2.png" width="52px" height="50px">
          </div>
          <div class="con1" style="margin-top: 8px; float: left;">
              <h3> 반짝이는 금속 줍기 </h3>
          </div>
      </div>
    
   
       
        
        <div id="basket2" class="container">
            <div class="row no-gutters">             
                <div class="col-xs-1 col-md-1"><i id="jew2" class="jew fa fa-trophy fa-3x" style="margin-top:7px; margin-left:7px" aria-hidden="true"></i></div>
                <div class="col-xs-1 col-md-1"></div>
                <div class="col-xs-1 col-md-1"></i></div>
                <div class="col-xs-1 col-md-1"></div>
                
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>
                <div class="col-xs-1 col-md-1"> </div>                
                <!-- DB 연결하면 for문으로 다시 짜서 전체 보석 개수만큼 생성되도록 하면 되지~ 않을까`~ 글쎄 잘 모르겟네 ~ -->
            </div>
        </div> 
            
        <!-- 여기까지 -->    
              
          </div>          
        </div>