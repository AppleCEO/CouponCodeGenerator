<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['admin']!="Y")
{
	header ('Location: ./index.php');
}

$prefix=$_POST['prefix'];
if (strlen($prefix) != 3) {
	echo '<script>alert("3글자를 입력해주세요.");</script>';
	echo("<script>location.href='/admin.php';</script>");
	exit();
}
preg_match('/[0-9a-zA-Z]+/',$prefix,$matches);

if (strlen($matches[0]) != 3) {
	echo '<script>alert("맨 앞 3자리는 알파벳 소문자, 대문자 그리고 숫자만 가능합니다.");</script>';
	echo("<script>location.href='/admin.php';</script>");
	exit();
}
$mysqli=mysqli_connect("localhost","root","dominic","coupon");

function generate_random_character()
{
  $random_number = mt_rand(0, 61);
  if ($random_number < 10) {
    return strval($random_number);
  }
  if ($random_number < 36) {
    $ascii_number = $random_number+87;
    return chr($ascii_number);
  }
  $ascii_number = $random_number+29;
  return chr($ascii_number);
}


for ($i=0; $i<100000; $i++) {
	$random_number = mt_rand(1, 1000);

	$query="SELECT id FROM user WHERE `index`='$random_number'";
	$result=$mysqli->query($query);
	$followingdata = $result->fetch_assoc();
	$use_id = $followingdata["id"];

  $code = $prefix;

  while (strlen($code) < 16) {
    $random_character = generate_random_character();
    $code = $code.$random_character;
  }

if ($use_id != null) {
	$query="INSERT INTO code(`code`, `group`, `user`, `use_date`) VALUES ('$code', '$prefix', '$use_id', NOW())";
} else {
	$query="INSERT INTO code(`code`, `group`, `user`) VALUES ('$code', '$prefix', null)";
}
  $result=$mysqli->query($query);
  if(!$result) {
    $i--;
  }
}

$publishCodeCount = number_format($i);
echo "<script>alert('{$prefix}(으)로 시작하는 쿠폰 {$publishCodeCount}개의 발행이 완료됬습니다.');</script>";
echo("<script>location.href='/admin.php';</script>");

?>
