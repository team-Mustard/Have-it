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
            <p style="font-size: 3.5em;">회 원 가 입</p>
            <form>
                <label><i class="fas fa-at babypink"></i></label>
                <input type="email" name="email" placeholder="e-mail"><br>
                <label><i class="fas fa-key blue"></i></label>
                <input type="password" name="password" placeholder="password"><br>
                <label><i class="fas fa-check-double blue"></i></label>
                <input type="password" name="password_check" placeholder="password double check">
            </form>
            <a class="btn purple fa-2" href="javascript:location.replace('./login.php')">가입하기</a>
        </div>
    </div>
  </body>
</html>