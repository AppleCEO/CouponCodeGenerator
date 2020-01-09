<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['admin']!="Y")
{
	header ('Location: ./index.php');
}
?>
<html>
<head>
	<meta charset="utf-8">
	<title>코멘토 - 현직자가 도와주는 취업사이트</title>
</head>
<body>

<div class="container">
  <button type="button" name="logout" onclick="location.href='logout.php'">로그아웃</button>
	<button type="button" name="list" onclick="location.href='list.php'">코드 리스트</button>
	<button type="button" name="statistics" onclick="location.href='statistics.php'">코드 통계</button>
  <center>
  	<h1>쿠폰 코드 발행 페이지</h1>
  	<br />
  	<form action="/publish.php" method="post" class="custom-form">
  		<p>
        <label>맨 앞 3자리</label>
  			<input type="text" name="prefix" id="prefix" maxlength="3" />
  		</p>
  		<p>
  			<button type="submit" class="button" style="width: 262px;">발행</button>
  		</p>
  	</form>
  </center>
</div>

</body>
</html>
