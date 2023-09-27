$(document).ready(function() {
  // 배너 이벤트 시작
  mainBanner();
});

// 자동 넘김 시간 설정
var rollingTime = 4000;
// 자동 넘김 설정(영상)
var rollingTimeSet;

// Main Banner
function mainBanner() {
  // 자동 넘김 시간 초기화 변수
  var rollingBanner;
  var navBox = $(".main_banner .mbanner_nav");
  // 하단 메뉴 개수 표시 구하기(전체)
  var totalNum = navBox.find("li").length;
  // 선택된 메뉴 index 값
  var currentNum = 0;

  // 하단 메뉴 개수 표시 값 HTML 넣기(전체)
  navBox.find(".mbanner_num span").html(totalNum);

  // Nav button box click
  // 하단 메뉴 클릭 이벤트
  navBox.find("li").on("click", function() {
    var $this = $(this);
    // 클릭한 영역 data-mov-num 값 저장 
    var movNum = $this.data("movNum");
    // 클릭한 영역 mov-id 값 저장
    var movId = $this.data("movId");
    // 클릭한 영역 banner-num 값 저장
    currentNum = $this.data("bannerNum");
    // 하단 메뉴 개수 표시 값 HTML 넣기(선택된)
    navBox.find(".mbanner_num strong").html(currentNum);
    // 선택되지 않은 영역 스타일
    if($this.hasClass("on") === false) {
      navBox.find("li").removeClass("on");
      $this.addClass("on");
      // 배너 영역 애니메이션 실행
      $(".mbanner_box").fadeOut().eq(currentNum - 1).fadeIn().find(".mbanner_char").css({marginLeft: -238}).stop().animate({marginLeft: -338}, 1000, "easeInOutCubic");
    }
    // Youtube control
    var movBox = $(".mbanner_wrap [data-mov-num]");
    // 영상이 있을 경우 iframe 주소 초기화
    if(movBox.length > 0) {
      // console.log("clear iframe");
      movBox.find("iframe").attr("src", "");
    }
    // 선택된 배너에 영상이 있을 경우 이벤트 처리
    if($this.find(".btn_mbanner_box.mov").length !== 0) {
      $(".mbanner_wrap").find("[data-mov-num='"+ movNum +"'] iframe").attr("src", "https://www.youtube.com/embed/"+ movId +"?rel=0&amp;controls=0&amp;showinfo=0&amp;mute=1&amp;autoplay=1&amp;loop=1&amp;playlist="+ movId);
      // 자동 넘김 시간 (n)배 설정
      rollingTimeSet = rollingTime * 3;
    } else {
      rollingTimeSet = rollingTime;
    }

    // Auto rolling control
    // 자동 넘김 설정
    // 자동으로 넘어갈때 마다 시간 초기화
    clearInterval(rollingBanner);
    if(navBox.hasClass("stop") === false) {
      // 자동 넘김일때
      // console.log("loop time " + (rollingTimeSet / 1000) + "s");
      loopInterval();
      pregerssBar();
    } else {
      // 클릭을 하였거나 자동 넘김이 아닐떄
      progressBarFull();
    }
  });

  // Nav button arrow click
  // 메뉴 버튼 클릭 이벤트
  navBox.find(".btn_mbanner_nav").on("click", function() {
    var currentIdx = navBox.find("li.on").index();
    var prevIdx = currentIdx - 1;
    var nextIdx = currentIdx + 1;
    if($(this).hasClass("prev")) {
      if(currentIdx === 0) {
        prevIdx = 4;
        for(var i = 0; i < 5; i++) {
          navBox.find("li").last().prependTo(".main_banner .mbanner_nav ul");
        }
      }
      navBox.find("li").eq(prevIdx).trigger("click");
    }
    if($(this).hasClass("next")) {
      if(currentIdx === 4) {
        nextIdx = 0;
        for(var j = 0; j < 5; j++) {
          navBox.find("li").eq(0).appendTo(".main_banner .mbanner_nav ul");
        }
      }
      navBox.find("li").eq(nextIdx).trigger("click");
    }
  });

  // Auto rolling
  function pregerssBar() {
    navBox.find("li .progress_bar").hide();
    navBox.find("li.on .progress_bar").css({width: 0}).show().stop().animate({
      width: 232
    }, rollingTimeSet);
  }

  function progressBarFull() {
    navBox.find("li .progress_bar").hide();
    navBox.find("li.on .progress_bar").css({width: 232}).show().stop();
  }

  function loopInterval() {
    rollingBanner = setInterval(function() {
      navBox.find(".btn_mbanner_nav.next").trigger("click");
    }, rollingTimeSet);
  }

  // Navigation click event
  navBox.find("li .btn_mbanner_box").on("click", function() {
    var $this = $(this);
    if($this.hasClass("mov")) {
      navBox.addClass("stop");
    }
    if($this.hasClass("img")) {
      navBox.removeClass("stop");
    }
  });

  // first load trigger click
  // 처음 로딩시 첫번째 메뉴 클릭
  navBox.find("li").eq(0).trigger("click");
}