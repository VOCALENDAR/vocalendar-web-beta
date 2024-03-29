<?php

/**
 * Embedded Google Calendar customization wrapper script
 *
 * Applies a custom color scheme to an embedded Google Calendar.
 *
 * Usage:
 *
 *     Replace standard Google Calendar embedding code, e.g.:
 *
 * <iframe src="http://www.google.com/calendar/embed?src=..."></iframe>
 *
 *     with a reference to this script:
 *
 * <iframe src="gcalendar-wrapper.php?src=..."></iframe>
 *
 * @author      Chris Dornfeld <dornfeld (at) unitz.com>
 * @version     $Id: gcalendar-wrapper.php 1571 2010-11-15 07:08:05Z dornfeld $
 * @link        http://www.unitz.com/gcalendar-wrapper/
 */

/**
 * Set your color scheme below
 */
$calColorBgDark      = '#ffffff';	// dark background color
$calColorTextOnDark  = '#000000';	// text appearing on top of dark bg color
$calColorBgLight     = '#eeeeee';	// light background color
$calColorTextOnLight = '#000000';	// text appearing on top of light bg color
$calColorBgToday     = '#ffffcc';	// background color for "today" box


define('GOOGLE_CALENDAR_BASE', 'https://www.google.com/');
define('GOOGLE_CALENDAR_EMBED_URL', GOOGLE_CALENDAR_BASE . 'calendar/embed');

/**
 * Prepare stylesheet customizations
 */

$calCustomStyle =<<<EOT

/* misc interface */
.cc-titlebar {
	background-color: white !important;
}
.date-picker-arrow-on,
.drag-lasso,
.agenda-scrollboxBoundary {
	background-color: {$calColorBgDark} !important;
}
td#timezone {
	color: {$calColorTextOnDark} !important;
}

/* tabs */
td#calendarTabs1 div.ui-rtsr-selected,
div.view-cap,
div.view-container-border {
	background-color: {$calColorBgDark} !important;
}
td#calendarTabs1 div.ui-rtsr-selected {
	color: {$calColorTextOnDark} !important;
}
td#calendarTabs1 div.ui-rtsr-unselected {
	background-color: {$calColorBgLight} !important;
	color: {$calColorTextOnLight} !important;
}

/* 月表示 */
.mv-daynames-table {
	background-color: none;
	background: none;
}
table.mv-daynames-table {
	background-color: none !important;
	/* days of the week */
	color: #666 !important;
}
td.st-bg,
td.st-dtitle {
	/* cell borders */
	border-left: none !important;
	font-weight: bold !important;
	font-size: 1.5em;
	/* days of the month */
	background-color: white !important;
	color: #333;
	/* cell borders */
	border-top: none !important;
}
td.st-dtitle span {
	font-weight: bold !important;
	color: #666;
}
td.st-bg-today {
	background-color: white !important;
	border: none;
}
.st-dtitle-today {
	background-color: #ccc !important;
	border: none;
	color: red !important;
}
td.st-bg, td.st-dtitle {
	background-color: none;
}
.st-c .st-ad-mpad,
.rb-n {
	background-color: #10a3a8 !important;
}

/* 週表示 */
table.wk-weektop,
th.wk-dummyth {
	/* days of the week */
	background-color: {$calColorBgDark} !important;
}
div.wk-dayname {
	text-size: 1rem;
	color: #666 !important;
}
div.wk-dayname span {
	font-weight: bold !important;
}
div.wk-today {
	background-color: {$calColorBgLight} !important;
	border: 1px solid #EEEEEE !important;
	color: {$calColorTextOnLight} !important;
}
td.wk-allday {
	background-color: #EEEEEE !important;
}
td.tg-times {
	background-color: {$calColorBgLight} !important;
	color: {$calColorTextOnLight} !important;
}
div.tg-today {
	background-color: {$calColorBgToday} !important;
}
.wk-scrolltimedevents {border:none;}
.tg-timedevents {border:none;}
.tg-times-pri, .tg-times-sec {
	background-color: #eee;
}
.wk-allday {
	border: none;
}
.chip dl {
	border: 1px solid white !important;
	background-color: #10a3a8 !important;
}
.cbrd dt {
	padding: 3px 3px;
	font-size: 1em;
	background-color: #005759 !important;
}
.chip dd {
	padding: 5px 3px;
}

/* agenda view */
div.scrollbox {
	border-top: 1px solid {$calColorBgDark} !important;
	border-left: 1px solid {$calColorBgDark} !important;
}
div.underflow-top {
	border-bottom: 1px solid {$calColorBgDark} !important;
}
div.date-label {
	background-color: {$calColorBgLight} !important;
	color: {$calColorTextOnLight} !important;
}
div.event {
	border-top: 1px solid {$calColorBgDark} !important;
}
div.day {
	border-bottom: 1px solid {$calColorBgDark} !important;
}


/* ボディ */
body { background-color:transparent !important; }
div.view-container-border {
	padding: 0;
}

/*カレンダー*/
.mv-event-container {
	border-top: none;
	border-bottom: none }
td.st-bg-today { background-color:inherit; }
.t2-embed { margin: 0px; }
.t1-embed { margin: 0px; }
.rb-n {
	border: none !important;
	-webkit-border-radius: 0px;
} /*終日イベント*/
.view-container { overflow:visible !important; }

/*ボタン*/
.bubble-closebutton,
.cc-close,
.navForward,
.navBack { background-image: url(//vocalendar.jp/images/combined_v22.png); }
.navbutton { padding: 0px; }
.today-button {
	border: none;
	color: #ffffff;
	cursor: pointer;
	margin: 0;
	padding: 0px 5px;
	background-color: #10a3a8;
	padding: 12px 10px 10px;
	font-size: 13px;
	font-weight: bold !important;
}

/*タブ
.nav-table tr {

}
#calendarTabs1 {
	display: block;
	position: absolute;
	right: 121px; top: -2px;
	padding-left: 10px; }
#calendarTabs1 tr td {
	height: 28px;}
.header { padding: 0px; }
td#calendarTabs1 div.ui-rtsr-unselected,
td#calendarTabs1 div.ui-rtsr-selected {
	height: 20px; }
.t1-embed, .t2-embed {
	height: 1px !important; }
*/
.ui-rtsr { padding-left: 1px; }
#tab-controller-container-week:after,
#tab-controller-container-month:after {
	content: '表示';
}

/*ポップアップカレンダー*/
.date-picker-on { border: 1px solid #999;}
.dp-weekend-selected { background-color: #C3EEE4; }
.dp-weekday-selected { background-color: #C3EEE4; }
.dp-popup {
	background: none;
	border: none;
	box-shadow: 0px 0px 0px #666666;
}
.dp-monthtablediv {
	padding: 10px;
	background-color: white;
	border-radius: 5px;
	border: 1px solid #999;
}
.dp-weekday-selected,
.dp-weekend-selected {
	background-color: inherit;
}
.dp-offmonth-selected,
.dp-offmonth {
	color: #eee;
}
.dp-cell {
	font-size: 14px;
}
.dp-cur {
	font-size: 16px;
	font-weight: bold !important;
}
.dp-cur, .dp-prev, .dp-next {
	color: #999 !important;
}

/*ポップアップイベントリスト*/
.cc {
	margin-left: -8px;
	box-shadow: 0px 0px 0px #666666;
	border: 1px solid #999;
	padding:1em;
	border-radius: 5px;
}
.cc-title { font-size: 1.5em; font-weight:bold !important; color: #666; }

/*ポップアップイベント*/
.bubble { border-raduis: 5px; }
.bubble-sprite { background-image: none }
.bubble-table { box-shadow: 0px 0px 0px #333; background-color: white; border-radius: 5px; border: 1px solid #999; }
.bubble-top,
.bubble-mid,
.bubble-bottom { border: none; }


/*テキスト*/
.te-s,
.bubble .details .title {
	color: #008185 !important;
}
.rb-n,
.te-s {
	font-size: 12px;
	letter-spacing: -1px;
}
th.mv-dayname { color: #666666; }
.dp-cur, .dp-prev, .dp-next { color:#10a3a8; }

/* リンク */
.agenda-more,
.st-more {
	color: #999;
	line-height: 1em;
	text-decoration: underline;
}

.header {
	padding: 10px 2px;
}
.navbutton {
	padding: 0;
	width: 48px;
	height: 40px;
}
.navBack {
	background-image: url('//vocalendar.jp/images/calendar-arrow-back.svg');
	background-position: center center;
}
.navForward {
	background-image: url('//vocalendar.jp/images/calendar-arrow-forward.svg');
	background-position: center center;
}
.ui-rtsr-name {
	cursor: pointer;
	padding: 10px 10px 8px;
}
td#calendarTabs1 div.ui-rtsr-selected {
	color: white !important;
	background-color: #666 !important;
	font-weight: bold !important;
}
.date-top {
	padding: 0 1em;
	font-size: 1rem;
	font-weight: bold !important;
	color: #666 !important;
}
.date-picker-off {
	background-color: #eee;
}
.date-picker-on {
	background-color: #ddd;
	border: 1px solid #ddd;
}
.date-picker-arrow-on {
	background-color: #ddd !important;
	border: 1px solid #ddd;
}

/* カレンダーセレクタ */
.calendar-nav {
	display: block;
	position: absolute;
	right: 140px; top: 0px;
	padding-top: 5px;
	text-align: right; }
.calendar-list {
	box-shadow: 0px 0px 20px #666666;
	border: 1px solid #ababab;
	padding: 10px; }
.calendar-row {
	padding: 2px 0px; }
.calendar-list input {
	margin-right: 1em; }
#calendarListButton1 {
	margin-top: -3px; }
/*
.calendar-nav:before {
	font-size: 12px;
	color: black;
	content: "表示切り替え";
	margin-right: 5px; }
*/

*:focus {
	outline:0;
}

EOT;


$calCustomScript =<<<EOT

<script src="//www.google.com/jsapi"></script>

<script type="text/javascript">
<!-- Google Analytics //-->
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-28637999-1']);
_gaq.push(['_setDomainName', 'vocalendar.jp']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>


EOT;


$calCustomStyle = '<style type="text/css">'.$calCustomStyle.'</style>';
$calCustomStyle .= $calCustomScript;

/**
 * Construct calendar URL
 */

$calQuery = '';
if (isset($_SERVER['QUERY_STRING'])) {
	$calQuery = $_SERVER['QUERY_STRING'];
} else if (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {
	$calQuery = $HTTP_SERVER_VARS['QUERY_STRING'];
}
$calUrl = GOOGLE_CALENDAR_EMBED_URL.'?'.$calQuery;

/**
 * Retrieve calendar embedding code
 */

$calRaw = '';
if (in_array('curl', get_loaded_extensions())) {
	$curlObj = curl_init();
	curl_setopt($curlObj, CURLOPT_URL, $calUrl);
	curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
	// trust any SSL certificate (we're only retrieving public data)
	curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curlObj, CURLOPT_SSL_VERIFYHOST, FALSE);
	if (function_exists('curl_version')) {
		$curlVer = curl_version();
		if (is_array($curlVer)) {
			if (!in_array('https', $curlVer['protocols'])) {
				trigger_error("Can't use https protocol with cURL to retrieve Google Calendar", E_USER_ERROR);
			}
			if (!empty($curlVer['version']) &&
				version_compare($curlVer['version'], '7.15.2', '>=') &&
				!ini_get('open_basedir') && !ini_get('safe_mode')) {
				// enable HTTP redirect following for cURL:
				// - CURLOPT_FOLLOWLOCATION is disabled when PHP is in safe mode
				// - cURL versions before 7.15.2 had a bug that lumped
				//   redirected page content with HTTP headers
				// http://simplepie.org/support/viewtopic.php?id=1004
				curl_setopt($curlObj, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($curlObj, CURLOPT_MAXREDIRS, 5);
			}
		}
	}
	$calRaw = curl_exec($curlObj);
	curl_close($curlObj);
} else if (ini_get('allow_url_fopen')) {
	if (function_exists('stream_get_wrappers')) {
		if (!in_array('https', stream_get_wrappers())) {
			trigger_error("Can't use https protocol with fopen to retrieve Google Calendar", E_USER_ERROR);
		}
	} else if (!in_array('openssl', get_loaded_extensions())) {
		trigger_error("Can't use https protocol with fopen to retrieve Google Calendar", E_USER_ERROR);
	}
	// fopen should follow HTTP redirects in recent versions
	$fp = fopen($calUrl, 'r');
	while (!feof($fp)) {
		$calRaw .= fread($fp, 8192);
	}
	fclose($fp);
} else {
	trigger_error("Can't use cURL or fopen to retrieve Google Calendar", E_USER_ERROR);
}

/**
 * Insert BASE tag to accommodate relative paths
 */

$titleTag = '<title>';
$baseTag = '<base href="'.GOOGLE_CALENDAR_EMBED_URL.'">';
$calCustomized = preg_replace("/".preg_quote($titleTag,'/')."/i", $baseTag.$titleTag, $calRaw);

/**
 * Insert custom styles
 */

$headEndTag = '</head>';
$calCustomized = preg_replace("/".preg_quote($headEndTag,'/')."/i", $calCustomStyle.$headEndTag, $calCustomized);

/**
 * Extract and modify calendar setup data
 */

$calSettingsPattern = "(\{\s*window\._init\(\s*)(\{.+\})(\s*\)\;\s*\})";

if (preg_match("/$calSettingsPattern/", $calCustomized, $matches)) {
	$calSettingsJson = $matches[2];

	$pearJson = null;
	if (!function_exists('json_encode')) {
		// no built-in JSON support, attempt to use PEAR::Services_JSON library
		if (!class_exists('Services_JSON')) {
			require_once('Services/JSON.php');
		}
		$pearJson = new Services_JSON();
	}

	if (function_exists('json_decode')) {
		$calSettings = json_decode($calSettingsJson);
	} else {
		$calSettings = $pearJson->decode($calSettingsJson);
	}

	// set base URL to accommodate relative paths
	$calSettings->baseUrl = GOOGLE_CALENDAR_BASE;

	// splice in updated calendar setup data
	if (function_exists('json_encode')) {
		$calSettingsJson = json_encode($calSettings);
	} else {
		$calSettingsJson = $pearJson->encode($calSettings);
	}
	// prevent unwanted variable substitutions within JSON data
	// preg_quote() results in excessive escaping
	$calSettingsJson = str_replace('$', '\\$', $calSettingsJson);
	$calCustomized = preg_replace("/$calSettingsPattern/", "\\1$calSettingsJson\\3", $calCustomized);
}

/**
 * Show output
 */

header('Content-type: text/html');
print $calCustomized;
