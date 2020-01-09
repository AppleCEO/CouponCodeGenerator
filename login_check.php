<?php
session_start();
$id=$_POST['id'];
$password=$_POST['password'];
$mysqli=mysqli_connect("localhost","root","dominic","coupon");

$check="SELECT * FROM user WHERE id='$id'";
$result=$mysqli->query($check);
if($result->num_rows==1) {
  $rows = $result->fetch_array(MYSQLI_ASSOC);

  if($rows['password']==$password) {
    $_SESSION['userid']=$id;
    $_SESSION['admin']=$rows['admin_yn'];
    if(!isset($_SESSION['userid'])) {
      echo '<script>alert("로그인에 실패했습니다. 관리자에게 문의해주세요.");</script>';
      echo("<script>location.href='/index.php';</script>");
    }
  } else {
    echo '<script>alert("비밀번호를 확인해주세요.");</script>';
    echo("<script>location.href='/index.php';</script>");
  }
} else {
  echo '<script>alert("해당하는 아이디가 존재하지 않습니다.");</script>';
  echo("<script>location.href='/index.php';</script>");
}

echo("<script>location.href='/index.php';</script>");
?>
