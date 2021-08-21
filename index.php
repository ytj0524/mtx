<?php
	header("Content-Type: Text/html; charset=utf-8");
	session_start();
	/*
	만든사람 : 윤태준
	전자우편 : ytj0524@naver.com
	개발날짜 : 2016-04-01
	최종수정 : 2016-04-01
	개발도구 : Notepad++
	사용언어 : HTML5, PHP 5.4.45, jQuery 1.12.0
	컨테이너 : APMSETUP(Apache 2.0)
	설　　명 : 브라우저에서 입력받은 값을 PHP DOMDocument를 이용하여 JATS 규격 XML 문서를 생성하는 툴
	*/
	if(isset($_SESSION["user_name"]) && isset($_SESSION["user_level"])) {
		echo "<script>alert('".$_SESSION["user_name"]."님 환영합니다!'); location.href = './mtx_form.php';</script>";
	} else {
?>
<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="UTF-8" />
		<meta name="description" content="브라우저에서 입력받은 값을 PHP DOMDocument를 이용하여 JATS 규격 XML 문서를 생성하는 툴">
		<meta name="Author" content="윤태준">
		<meta name="Author-Date" content="20160325">
		<meta name="Email" content="ytj0524@naver.com">
		<meta name="Generator" content="Notepad++">
		<meta name="Robots" content="noindex, nofollow">
		<title>META TO XML &ndash; 로그인</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css" />
		<script type="text/javascript" src="./js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src="./js/javascript.js"></script>
	</head>
	<body>
		<div id="wrap">
			<header>
				<h1 title="도구 이름">META TO XML &ndash; 로그인</h1>
				<p title="도구 설명">논문의 정보를 입력 받아 JATS 규격 논문으로 변환시켜주는 도구입니다. <span id="spn_version" title="도구 버전"></span></p>
			</header>
			<div id="container" class="align_center">
				<form id="frm_login" method="POST" action="./mtx_login_proc.php">
					<input type="text" id="user_id" name="user_id" class="inp_default" maxlength="12" placeholder="아이디" autofocus required />
					<input type="password" name="user_pw" class="inp_default" maxlength="12" placeholder="비밀번호" required />
					<button id="btn_submit" name="btn_submit" class="btn_default">로그인</button>
					<button type="button" id="btn_register" class="btn_default" onClick="location.href = '../__xmltool/regist.php';">사용자 등록</button>
				</form>
				<div id="section_login_message"></div>
			</div>
			<footer>
				<img src="./image/img_logo.gif" />
				<p class="p_copyright">By <a href="mailto:ytj0524@naver.com">ytj0524@naver.com</a><br />Copyright 2016 <a href="http://www.nurimedia.co.kr" target="_blank">(주)누리미디어</a> 담당 : <a href="mailto:blueship9@nate.com">콘텐츠제작사업부</a></p>
			</footer>
		</div>
	</body>
</html>
<?
	}
?>