<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/intro.css" />
  </head>
  <body>
    <div class="container-fluid" id="top">
        <div class="sign text-center" style="margin-top:30px;">
            <img class="logo img-circle" src="img/logoRail.jpg">
            <h1>' Have it '</h1>
            <a class="btn purple" href="javascript:location.href='./login.php'">
                <span style="font-size:1.3em;">로그인</span><br/>
                <span>Login</span>
            </a>
            <a class="btn pink" href="javascript:location.href='./signup.php'">
                <span style="font-size:1.3em;">회원가입</span><br/>
                <span>Sign up</span>
            </a>
        </div>
            
        <div class="blue text-center">
            <img src="img/problem1.svg" width="500" height="auto">
        </div>
        <div class="text-center" style="margin:50px 20%;">
            <img src="img/problem2.svg" width="500" height="auto">
        </div>
        
        <div id="infoCarousel" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#infoCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#infoCarousel" data-slide-to="1"></li>
            <li data-target="#infoCarousel" data-slide-to="2"></li>
            <li data-target="#infoCarousel" data-slide-to="3"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active">
              <img src="img/plan.png" alt="plan">
            </div>

            <div class="item">
              <img src="img/do.png" alt="do">
            </div>

            <div class="item">
              <img src="img/check.png" alt="check">
            </div>

            <div class="item">
              <img src="img/action.png" alt="action">
            </div>
          </div>
        </div>
    
        <div class="babypink text-center">
            <img src="img/get.svg" width="auto" height="485">

        </div>
        <div class="footer text-center" style="margin-top:30px;margin-bottom:30px;">
            <img class="logo img-circle" src="img/logoRail.jpg">
            <h2> Developers : Team-Mustard</h2>
            <h6><i class="fab fa-github"></i> <a href="https://github.com/team-Mustard/Have-it">https://github.com/team-Mustard/Have-it</a></h6>
            <h6 class="loc"><i class="fas fa-map-marker-alt"></i> Department of Software, Chungbuk National University</h6>
            <a class="btn pink" href="#">
                <i class="fab fa-android"></i> Play Store
            </a><br/>
            <a class="btn purple" onclick="goTop();">Touch To Top</a>
        </div>
    </div>
  </body>
    <script>
        function goTop(){
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>
</html>