<?php
session_start();
if(!isset($_SESSION['userid']))
{
	header ('Location: ./index.php');
  exit();
}
?>
<!DOCTYPE htm>
<html>
<head>
	<meta charset="utf-8">
	<title>코멘토 - 현직자가 도와주는 취업사이트</title>
</head>
<body>

<div class="container">
	<button type="button" name="logout" onclick="location.href='logout.php'">로그아웃</button>
	<button type="button" name="list" onclick="location.href='statistics.php'">코드 통계</button>
  <center>
  	<h1>쿠폰 코드 사용 페이지</h1>
  	<br />
  	<form action="/code_check.php" method="post" class="custom-form">
  		<p>
        <label>쿠폰 코드</label>
  			<input type="text" name="code" id="code" maxlength="16" />
  		</p>
  		<p>
  			<button type="submit" class="button" style="width: 250px;">사용</button>
  		</p>
  	</form>
  </center>
</div>

</body>
</html>
