<?php
session_start();
if(!isset($_SESSION['userid']))
{
	header ('Location: ./index.php');
  exit();
}

$mysqli=mysqli_connect("localhost","root","dominic","coupon");

$query="SELECT `group`, count(*) FROM code GROUP BY `group`";
$groups=$mysqli->query($query);
?>
<!DOCTYPE htm>
<html>
<head>
	<meta charset="utf-8">
	<title>코멘토 - 현직자가 도와주는 취업사이트</title>
	<link rel="shortcut icon" href="https://comento.kr/favicon/16x16.ico">
  <link rel="apple-touch-icon-precomposed" href="https://comento.kr/favicon/148x148.png">
	<link rel="icon" href="https://comento.kr/favicon/16x16.ico" sizes="16x16">
  <link rel="icon" href="https://comento.kr/favicon/32x32.ico" sizes="32x32">
  <link rel="icon" href="https://comento.kr/favicon/48x48.ico" sizes="48x48">
  <link rel="icon" href="https://comento.kr/favicon/64x64.ico" sizes="64x64">
  <link rel="icon" href="https://comento.kr/favicon/96x96.ico" sizes="96x96">

  <meta name="msapplication-TileColor" content="#FFFFFF">
  <meta name="msapplication-TileImage" content="https://comento.kr/favicon/ms-icon-144x144.png">
	<style>
    table {
      width: 50%;
    }
    table, th, td {
      border: 1px solid #bcbcbc;
    }
  </style>
</head>
<body>

<div class="container">
	<button type="button" name="logout" onclick="location.href='logout.php'">로그아웃</button>
<?php if ($_SESSION['admin']=="Y") { ?>
	<button type="button" name="admin" onclick="location.href='admin.php'">코드 발행</button>
	<button type="button" name="list" onclick="location.href='list.php'">코드 리스트</button>
<?php } else { ?>
	<button type="button" name="use" onclick="location.href='use.php'">코드 사용</button>
<?php } ?>
	<center>
  	<h1>쿠폰 코드 통계 페이지</h1>
  	<br />
<?php while($row = mysqli_fetch_array($groups)) {
	$group = $row["group"];
 	$query="SELECT `user`, count(*) as cnt FROM code WHERE `group` = '$group' GROUP BY `user`";
	$result=$mysqli->query($query);
?>
		맨 앞 3자리 : <?=$group ?>
		<table>
			<thead>
				<tr>
					<th>유저</th>
					<th>사용량</th>
				</tr>
			</thead>
			<tbody>
<?php while($row = mysqli_fetch_array($result)) { ?>
				<tr>
					<td><?php if ($row["user"] == NULL) { echo "미사용"; } else { echo $row["user"]; }  ?></td>
					<td><?=$row["cnt"] ?></td>
				</tr>
<?php } ?>
			</tbody>
		</table>
<br />
<br />
<?php } ?>
  </center>
</div>

</body>
</html>
