// vocalendar-common.js

var currentSection = 0; // 現在セクション (pageNav用)
var windowHeight; // ウィンドウ高さホルダー
var windowWidth; // ウィンドウ幅ホルダー
var timer = 0; // リサイズリダクション用タイマー

const globalNavHeight = 60;
const calendarMarginBottom = 100; // カレンダーの下マージン (60が基点)
const appsNavTop = 140; // appsNavのXオフセット
const navSpacing = 12; // appsNavとpageNavの位置調整スペーシング量

const htmlRoot          = document.getElementById("root");
const calendarFrame     = document.getElementById("calendarFrame");
const sectionBlocks     = document.getElementsByClassName("windowHeight");
const contentsBlocks    = document.getElementsByClassName("contentsHeight");
const middleBlocks      = document.getElementsByClassName("contentsMiddle");
const calendarBlock     = document.querySelector('#calendar iframe');
const pageNavBlock      = document.getElementById("pageNav");
const appsNavBlock      = document.getElementById("appsNav");
const pageNavIndicators = document.querySelectorAll('#pageNav li');

window.onload = function() {
  windowHeight = document.documentElement.clientHeight;
  windowWidth = document.documentElement.clientWidth;
  appsNavBlock.style.top = appsNavTop + "px";
  pageNavRelocation();
  sectionSizeChange();
  calendarSizeChange();
  contentsHeightAdjust();
  setSmoothScroll();
  calendarFrameLoad();
};

window.onresize = function() {
  windowHeight = document.documentElement.clientHeight;
  windowWidth = document.documentElement.clientWidth;
  calendarFrame.removeAttribute("src");
  sectionSizeChange();
  contentsHeightAdjust();
  pageNavRelocation();
  pageNavIndicatorControl();
  if (timer > 0) {
    clearTimeout(timer);
  }
  timer = setTimeout(function() {
    calendarSizeChange();
    calendarFrameLoad();
    window.scroll({
      top: currentSection * windowHeight,
      behavior: 'smooth'
    });
  }, 500);
};

window.onscroll = function() {
  pageNavIndicatorControl();
}

// レイアウト初期設定
function layoutInitialize() {
  sectionSizeChange();
  appsNavBlock.style.top = appsNavTop + "px";
  pageNavRelocation();
  calendarSizeChange();
  contentsHeightAdjust();
}

// .windowHeight ブロックをウィンドウ高さに追随させる
function sectionSizeChange() {
  if (windowHeight < 800 || windowWidth < 1300) {
    htmlRoot.style.fontSize = '13px';
  } else {
    htmlRoot.style.fontSize = '16px';
  }
  for (let i = 0; i < sectionBlocks.length; i++) {
    sectionBlocks[i].style.height = windowHeight +"px";
  }
}

// カレンダー用iframeサイズ変更
function calendarSizeChange() {
  calendarBlock.style.height = (windowHeight - calendarMarginBottom) + 'px';
}

// カレンダーiframe読み込み
function calendarFrameLoad() {
  calendarFrame.setAttribute("src", calendarFrame.getAttribute("data-src"));
}

// コンテンツ高さ調整
function contentsHeightAdjust() {
  for (let i = 0; i < middleBlocks.length; i++) {
    middleBlocks[i].style.marginTop = (( windowHeight - globalNavHeight - middleBlocks[i].clientHeight ) / 2) +"px";
  }
  for (let i = 0; i < contentsBlocks.length; i++) {
    contentsBlocks[i].style.height = ( windowHeight - globalNavHeight * !contentsBlocks[i].classList.contains('ignorePadding')) +"px";
  }
}

// ページナビゲーションの位置調整 (高さ方向中央)
function pageNavRelocation() {
  var appsNavBottomY = appsNavTop + appsNavBlock.clientHeight;
  var relocationPositonY = ((windowHeight - pageNavBlock.clientHeight) /2);
  if (appsNavBottomY + navSpacing > relocationPositonY) {
    pageNavBlock.style.top = ( appsNavBottomY + navSpacing ) + 'px';
  } else {
    pageNavBlock.style.top = relocationPositonY + 'px';
  }
}

// ページナビゲーション点灯制御
function pageNavIndicatorControl() {
  var newSection = Math.floor((window.pageYOffset + windowHeight / 2) / windowHeight);
  if (newSection != currentSection) {
    if (pageNavIndicators.length -1 >= currentSection) {
      pageNavIndicators[currentSection].classList.remove('current');
    }
    if (pageNavIndicators.length -1 >= newSection) {
      pageNavIndicators[newSection].classList.add('current');
    }
    currentSection = newSection;
  }
}

// スムーススクロール設置
function setSmoothScroll() {
  const links = document.querySelectorAll('a[href^="#"]');
  for ( let i = 0; i < links.length; i++ ) {
    links[i].addEventListener('click', (e) => {
      e.preventDefault();
      const splitHref = e.currentTarget.getAttribute('href').split('#');
      const target = document.getElementById(splitHref[1]);
      window.scroll({
        top: target.getBoundingClientRect().top + window.pageYOffset,
        behavior: 'smooth'
      });
    });
  }
}

