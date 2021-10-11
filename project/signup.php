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
            <form action="db/insertuserinfo.php" method="post" id="signupform">
                <label><i class="fas fa-at babypink"></i></label>
                <input type="email" name="email" placeholder="e-mail"><br>
                <label><i class="fas fa-key blue"></i></label>
                <input type="password" name="password" placeholder="password"><br>
                <P class="pw-rule">*비밀번호의 길이는 8자 이상 18자 이하만 가능합니다.</P>
                <label><i class="fas fa-check-double blue"></i></label>
                <input type="password" name="password_check" placeholder="password double check"><br>
                <p class="pw-check">*비밀번호가 일치하지 않습니다.</p>
                <hr class="hr_bord">
                <input type="submit" class="btn purple fa-2" value="가입하기">
                
            </form>
        </div>
    </div>
  </body>
</html>

<script>
  let pwOldVal = "";

  $('input[name="password"]').on("propertychange change keyup paste input", function() {
    let currentVal = $(this).val();
    if(currentVal == pwOldVal) {
        return;
    }

    if((currentVal.length < 8) || (currentVal.length > 18)) {
      $('.pw-rule').css("display", "block");
    } else {
      $('.pw-rule').css("display", "none");
    }

    if($('input[name="password_check"]').val() != currentVal) {
      $('.pw-check').css("display", "block");
    } else {
      $('.pw-check').css("display", "none");
    }
    
    pwOldVal = currentVal;
  });

  $('input[name="password_check"]').on("propertychange change keyup paste input", function() {
    if($('input[name="password"]').val() != $(this).val()) {
      $('.pw-check').css("display", "block");
    } else {
      $('.pw-check').css("display", "none");
    }
  })
</script>