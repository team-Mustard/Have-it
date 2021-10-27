<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <script data-require="jquery@*" data-semver="3.6.0" src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/intro.css" />
</head>
<body>
<div class="container" id="top">
        <div class="sign">
          <div class="logo">
            <img class="img-circle" src="img/logoRail.png">
            <h1>' Have it '</h1>
          </div>
          <div class="buttons right">
            <a class="btn purple" href="javascript:location.href='./login.php'">
                <span style="font-size:1.3em;">로그인</span><br/>
            </a>
            <a class="btn pink" href="javascript:location.href='./signup.php'">
                <span style="font-size:1.3em;">회원가입</span><br/>
            </a>
          </div>
        </div>
        
        <div class="slogan">
          나만의<br>
          <span class="jewel">보석</span>같은<br>
          습관 형성하기!
        </div>


        <div class="problem row text-center">
          <div class="col-sm-2"></div>
          <div class="col-sm-3">
              <img class="problemIcon img-circle" src="./img/thumb_down.svg" alt="thumb-down" width="55px" height="55px">
              <p class="problemSub">날 지치게 하는</p>
              <p class="problemTitle"><b>저조한 능률</b></p>
          </div>
          <div class="col-sm-2">
              <img class="problemIcon img-circle" src="./img/timer_off.svg" alt="thumb-down" width="55px" height="55px">
              <p class="problemSub">어떤 다짐도</p>
              <p class="problemTitle"><b>작심 삼일</b></p>
          </div>
          <div class="col-sm-3">
              <img class="problemIcon img-circle" src="./img/date_range.svg" alt="thumb-down" width="55px" height="55px">
              <p class="problemSub">자꾸만</p>
              <p class="problemTitle"><b>놓치는 일정</b></p>
          </div>
          <div class="col-sm-2"></div>
        </div>

        <div class="solution text-center">
          <h4>거듭되는 실패를 극복하기 위해서?</h4>
          <div class="sol images">
            <img alt="goal_set" src="./img/solution1.png" width="500px">
            <img alt="goal" src="./img/solution2.png" width="500px">
            <img alt="monthly" src="./img/solution3.png" width="500px">
          </div>
          <h3><strong>PDCA-cycle</strong>을 활용한 Have-it으로 시작하세요</h3>
        </div>
        
        <div class="carousel text-center" id="carousel">
          <div class="prev">
            <img src="./img/action.png" alt="plan" width="150px">
          </div>
          <div class="selected">
            <img src="./img/plan.png" alt="do" width="150px">
          </div>
          <div class="next interval">
            <img src="./img/do.png" alt="check" width="150px">
          </div>
          <div class="hiddenimg">
            <img src="./img/check.png" alt="action" width="150px">
          </div>
        </div>

        <div class="PDCA text-center">
          <p>
            *PDCA-cycle이란, 계획하고(Plan) 계획을 실행하면(Do)<br>스스로 성취도를 평가하고 원인을 파악하여(Check)<br>다음 계획에 개선안을 적용하는(Action) 사이클입니다.
          </p>
        </diV>

        <div class="footer text-center" style="margin-top:30px;margin-bottom:30px;">
            <img class="img-circle" src="img/logoRail.png">
            <h3> Developers : 이주영, 이송이, 최승혜</h3>
            <h6><i class="fab fa-github"></i> <a href="https://github.com/team-Mustard/Have-it">https://github.com/team-Mustard/Have-it</a></h6>
            <h6 class="loc"><i class="fas fa-map-marker-alt"></i> Department of Software, Chungbuk National University</h6>
            
            <a onclick="goTop();"><i class="fas fa-arrow-circle-up"></i></a>
        </div>
    </div>
</body>
<script>
  function goTop(){
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }

  const observerP = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      const up = entry.target.querySelectorAll('.img-circle');
      up.forEach(element => {
        if(entry.isIntersecting) {
          element.classList.add('problemIcon');
          return;
        }
        element.classList.remove('problemIcon');
      });
    });
  });

  observerP.observe(document.querySelector('.problem'));

  const observerS = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      const up = entry.target.querySelector('.images');
      if(entry.isIntersecting) {
        up.classList.add('sol');
        up.classList.remove('hidden');
        return;
      }
      up.classList.add('hidden');
      up.classList.remove('sol');
    });
  });

  observerS.observe(document.querySelector('.solution'));

  function moveToSelected(element) {

    var selected = element;
    if(element.hasClass('next')) {
      var prevFlag = false;
    } else {
      var prevFlag = true;
    }

    var next = $(selected).next().length ? $(selected).next() : $(selected).prev().prev().prev();
    var prev = $(selected).prev().length ? $(selected).prev() : $(selected).next().next().next();
    var hiddenimg = $(prev).prev().length ? $(prev).prev() : $(prev).next().next().next();

    $(selected).removeClass().addClass("selected");

    $(prev).removeClass().addClass("prev");
    $(next).removeClass().addClass("next interval");

    $(hiddenimg).removeClass().addClass("hiddenimg");
    
    $(selected).css('z-index', '10');
    $(hiddenimg).css('z-index', '0');

    if(prevFlag) {
      $(prev).css('z-index', '4');
      $(next).css('z-index', '5');
    }
    else {
      $(prev).css('z-index', '5');
      $(next).css('z-index', '4');
    }
  }

  $('.carousel div').click(function() {
    moveToSelected($(this));
  });

  setInterval(function() {
    var selected = $('.next');

    var next = $(selected).next().length ? $(selected).next() : $(selected).prev().prev().prev();
    var prev = $(selected).prev().length ? $(selected).prev() : $(selected).next().next().next();
    var hiddenimg = $(prev).prev().length ? $(prev).prev() : $(prev).next().next().next();

    $(selected).removeClass().addClass("selected");
    $(prev).removeClass().addClass("prev");
    $(next).removeClass().addClass("next interval");
    $(hiddenimg).removeClass().addClass("hiddenimg");
    
    $(selected).css('z-index', '10');
    $(hiddenimg).css('z-index', '0');
    $(prev).css('z-index', '5');
    $(next).css('z-index', '4');

  }, 3000);

  

</script>
</html>