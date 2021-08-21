<?php
	header("Content-Type: Text/html; charset=utf-8");
	session_start();
	/*
		Error 0 : 아이디와 일치하는 사용자 정보를 불러올 수 없음
		Error 1 : 
	*/
	if(!preg_match("/".getenv("HTTP_HOST")."/",getenv("HTTP_REFERER"))) {
		echo "<script>alert('비정상적인 접근입니다.');history.go(-1);</script>";
		exit;
	} else {
		require_once("../_common/mysql_db.php");
		$db_connect = mysql_connect($mysql_host, $mysql_user, $mysql_password) or die("데이터베이스 접속 오류입니다.");
		$db_select = mysql_select_db("db_xml", $db_connect) or die("데이터베이스 선택 오류입니다.");
		@mysql_query(" set names utf8 ");
		
		if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"]) && isset($_POST["user_pw"])) {
			$user_id = $_POST["user_id"];
			$user_pw = $_POST["user_pw"];
			
			$get_user_id_query = "SELECT `uid` FROM `xusers` WHERE `uid`='$user_id';";
			$get_user_id = mysql_query($get_user_id_query, $db_connect) or die("Error 0");
			$get_user_id_num = mysql_num_rows($get_user_id);
			
			if($get_user_id_num == 1) {
				$get_user_pw_query = "SELECT `uid` FROM `xusers` WHERE (`uid`='$user_id' AND `upw`=password('$user_pw'));";
				$get_user_pw = mysql_query($get_user_pw_query, $db_connect) or die("Error 0");
				$get_user_pw_num = mysql_num_rows($get_user_pw);
				$row = @mysql_fetch_assoc($get_user_pw);
				
				if($get_user_pw_num == 1) {
					$get_user_info = @mysql_query("SELECT * FROM `xusers` WHERE (`uid`='$user_id' AND `upw`=password('$user_pw'));");
					$row = @mysql_fetch_assoc($get_user_info);
					
					if($row["ufail"] >= 10) { // 로그인 실패 제한 횟수 초과
						echo "<script>alert('로그인 실패 횟수가 10회를 초과하였습니다. 관리자에게 문의하세요.'); history.go(-1);</script>";
						exit;
					}
					if($row["ulevel"] == 0) {
						echo "<script>alert('본 계정은 사용 권한이 해제되었습니다. 관리자에게 문의하세요.'); history.go(-1);</script>";
						exit;
					}
					if($row["ulevel"] < 2) {
						echo "<script>alert('본 계정은 사용 권한이 없습니다. 관리자에게 문의하세요.'); history.go(-1);</script>";
						exit;
					}
					
					@mysql_query("UPDATE `xusers` SET `ufail`=0, `ulogin`=now(), `uip`='".$_SERVER["REMOTE_ADDR"]."' WHERE `uid`='$user_id';");
					
					$_SESSION["user_name"] = $row["uname"];
					$_SESSION["user_level"] = $row["ulevel"];
					
					echo "<script>alert('".$_SESSION["user_name"]."님 환영합니다!'); location.href = './mtx_form.php'</script>";
				} else {
					@mysql_query("UPDATE `xusers` SET `ufail`=ufail+1, `ulogin`=now(), `uip`='".$_SERVER["REMOTE_ADDR"]."' WHERE `uid`='$user_id';");
					$get_user_fail = @mysql_query("SELECT `ufail` FROM `xusers` WHERE `uid`='$user_id';");
					$row = @mysql_fetch_assoc($get_user_fail);
					echo "<script>alert('비밀번호가 일치하지 않습니다.로그인 ".$row["ufail"]."회 실패 / 10회 이상 계정 잠김'); history.go(-1);</script>";
					exit;
				}
			} else {
				echo "<script>alert('존재하지 않는 아이디 입니다.'); history.go(-1);</script>";
				exit;
			}
		}
	}
?>