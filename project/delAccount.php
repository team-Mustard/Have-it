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
            <p style="font-size: 3.5em;">회 원 탈 퇴</p>
            <form action = "db/deleteUser.php" method="post">
                <p>
                    계정 비밀번호를 입력해주세요.<br>
                    탈퇴 계정의 데이터가 즉시 삭제되며,<br>
                    복구가 불가능합니다. 
                </p>
                <label><i class="fas fa-key red"></i></label>
                <input type="password" name="password" placeholder="password"><br>
                <hr class="hr_bord">
                <input type="submit" class="btn pink fa-2" value="탈퇴하기">
            </form>
        </div>
    </div>
  </body>
</html>