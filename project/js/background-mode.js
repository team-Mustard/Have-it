var setCookie = function(name, value, exp) {
var date = new Date();
date.setTime(date.getTime() + exp*24*60*60*1000);
document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
};

var getCookie = function(name) {
var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
return value? value[2] : null;
};

var deleteCookie = function(name) {
document.cookie = name + '=; expires=Thu, 01 Jan 1999 00:00:10 GMT;';
}

function bg_check() {
    mode = getCookie("bg-mode");
    get = document.getElementById("bg_mode");
    if(mode == null) {
        alert("mode 기본값을 light로 설정");
        setCookie("bg-mode","light",7);
    } else if (mode == "dark") {
        get.innerHTML = '[라이트모드]';
        $( document ).ready(function() {
            $('body').addClass('dark');
        });
    }
}

function bg_mode_change() {
    mode = getCookie("bg-mode");
    get = document.getElementById("bg_mode");
    if(mode == "light") {
        deleteCookie("bg-mode");
        setCookie("bg-mode","dark",7);
        get.innerHTML = '[라이트모드]';
        $( document ).ready(function() {
            $('body').addClass('dark');
        });
    }
    else if(mode == null || mode == "dark") {
        deleteCookie("bg-mode");
        setCookie("bg-mode","light",7);
        get.innerHTML = '[다크모드]';
        $( document ).ready(function() {
            $('body').removeClass('dark');
        });
    }
}
