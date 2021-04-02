<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/user.css" />
  </head>
  <body>
    <div class="container-fluid">
        <div class="sign text-center" style="margin-top:70px;">
            <img class="logo img-circle" src="img/logoRail.jpg">
            <h2>' Have it '</h2>
            <p style="font-size: 3.5em;">로 그 인</p>
            <form action = "db/checkuserinfo.php" method="post" id="signinform">
                <label><i class="fas fa-at babypink"></i></label>
                <input type="email" name="email" placeholder="e-mail"><br>
                <label><i class="fas fa-key blue"></i></label>
                <input type="password" name="password" placeholder="password">
            </form>
            <a class="btn pink fa-2" onclick="document.getElementById('signinform').submit();">로그인 <i class="fas fa-arrow-circle-right"></i></a>
            <p style="margin-bottom:0px;">회원이 아니신가요?
                <a href="javascript:location.replace('./signup.php')"> 회원가입하기</a>
            </p>
            <p>어플로 시작하려면?
                <a href="#"> 　　다운로드</a>
            </p>
        </div>
    </div>
  </body>
</html>