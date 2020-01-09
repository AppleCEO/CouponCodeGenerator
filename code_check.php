<?php
session_start();
$code=$_POST['code'];
$mysqli=mysqli_connect("localhost","root","dominic","coupon");

$check="SELECT * FROM code WHERE code='$code'";
$result=$mysqli->query($check);
if($result->num_rows==1) {
  $rows = $result->fetch_array(MYSQLI_ASSOC);

  if($rows['user']==NULL) {
    $id = $_SESSION['userid'];
    $query="UPDATE code SET `user` = '$id', `use_date` = NOW() WHERE `code`='$code'";
    $result=$mysqli->query($query);
    if($result) {
      echo '<script>alert("쿠폰이 사용되었습니다.");</script>';
    } else {
      echo '<script>alert("문제가 생겨 쿠폰이 사용되지 않았습니다. 관리자에게 문의해주세요.");</script>';
    }
  } else {
    echo '<script>alert("이미 사용된 쿠폰입니다.");</script>';
  }
} else {
  echo '<script>alert("해당하는 쿠폰 코드가 존재하지 않습니다.");</script>';
}

echo("<script>location.href='/use.php';</script>");
?>
