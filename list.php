<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['admin']!="Y")
{
	header ('Location: ./index.php');
  exit();
}

$mysqli=mysqli_connect("localhost","root","dominic","coupon");
$page_size = 100;
$page_list_size = 10;

$no = $_GET["no"];
if(!$no || $no < 0 ) {
  $no = 0;
}

$group = $_GET["group"];
if ($group == NULL) {
  $query="SELECT * FROM code ORDER BY `index` ASC LIMIT $no,$page_size";
} else {
  $query="SELECT * FROM code WHERE `group`='$group' ORDER BY `index` ASC LIMIT $no,$page_size";
}

$result=$mysqli->query($query);

$query="SELECT `group` FROM code GROUP BY `group`";
$groups=$mysqli->query($query);

if ($group == NULL) {
  $result_count=$mysqli->query("SELECT count(*) FROM code");
} else {
  $result_count=$mysqli->query("SELECT count(*) FROM code WHERE `group`='$group'");
}
$result_row=mysqli_fetch_row($result_count);
$total_row = $result_row[0];

if($total_row <= 0) $total_row = 0;
$total_page = floor(($total_row - 1) / $page_size);
$current_page = floor($no/$page_size);
$start_page = (int)($current_page / $page_list_size) * $page_list_size;
$end_page = $start_page + $page_list_size - 1;
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
    <script language="javascript" type="text/javascript">
    function doReload(group){
      if (group == '') {
        document.location = 'list.php';
      } else {
        document.location = 'list.php?group=' + group;
      }
    }
</script>
</head>
<body>
  <button type="button" name="logout" onclick="location.href='logout.php'">로그아웃</button>
	<button type="button" name="admin" onclick="location.href='admin.php'">코드 발행</button>
  <button type="button" name="statistics" onclick="location.href='statistics.php'">코드 통계</button>
  <center>
  	<h1>쿠폰 코드 리스트 페이지</h1>
      맨 앞 3자리 :
      <select name="group" onChange="doReload(this.value);">
        <option value="" <?php if ($group == NULL) echo 'selected="selected"' ?>>전체</option>
<?php     while($row = mysqli_fetch_array($groups)) { ?>
        <option value="<?=$row["group"] ?>" <?php if ($group == $row["group"]) echo 'selected="selected"' ?>><?=$row["group"] ?></option>
<?php } ?>
        </tr>
      </select>
      <table>
        <thead>
          <tr>
            <th>코드</th>
            <th>사용 일시</th>
            <th>사용 유저</th>
          </tr>
        </thead>
        <tbody>
<?php     while($row = mysqli_fetch_array($result)) { ?>
          <tr>
            <td><?=$row["code"] ?></td>
            <td><?=$row["use_date"] ?></td>
            <td><?=$row["user"] ?></td>
          </tr>
<?php } ?>
        </tbody>
      </table>
      <br>
      <div>
<?php
      if($total_page<$end_page) $end_page = $total_page;
      if($start_page>=$page_list_size) {
        $prev_list=($start_page-1)*$page_size;
        if ($group == NULL) {
          echo "<a href=\"$PHP_SELF?no=$prev_list\"prev</a>\n";
        } else {
          echo "<a href=\"$PHP_SELF?group=$group&no=$prev_list\"prev</a>\n";
        }
      }

      for($i=$start_page;$i<=$end_page;$i++) {
        $page=$page_size*$i;
        $page_num = $i+1;

        if($no!=$page) {
          if ($group == NULL) {
            echo "<a href=\"$PHP_SELF?no=$page\">";
          } else {
            echo "<a href=\"$PHP_SELF?group=$group&no=$page\">";
          }
        }

        echo "$page_num";

        if($no!=$page) {
          echo "</a>";
        }

        echo "  ";
      }

      if($total_page > $end_page) {
        $next_list = ($end_page + 1) * $page_size;
        if ($group == NULL) {
          echo "<a href=$PHP_SELF?no=$next_list>next</a></p>";
        } else {
          echo "<a href=$PHP_SELF?group=$group&no=$next_list>next</a></p>";
        }
      }
?>
</div>
    </center>
  </body>
</html>
