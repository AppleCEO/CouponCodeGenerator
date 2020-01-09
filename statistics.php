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
