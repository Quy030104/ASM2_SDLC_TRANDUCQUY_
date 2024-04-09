<?php

 require 'model/LoginModel.php'; // import model
// m = ten cua ham nam trong file controller trong thu muc controller
$m = trim($_GET['m'] ?? 'index'); // ham mac dinh trong controller ten la index 
$m = strtolower($m); // viet thuong tat ca ten ham 

switch($m){
    case 'index':
        index();
        break;
    case 'handle':
        handleLogin();
        break;
    case 'logout':
        handleLogout();
        break;
    default:
        index();
         break;
}

 function handleLogout(){
    if(isset($_POST['btnLogout'])){
        // huy cac session
        session_destroy();
        // quay ve trang dang nhap
        header("Location:index.php");
    }
 }
 
 function handleLogin(){
    // kiem tra nguoi dung bam submit login chua?
    if(isset($_POST['btnLogin'])){
        $username = trim($_POST['username'] ?? null);
        $username = strip_tags($username); //strip tag xoa cac the html trong chuoi 
        $password = trim($_POST['password'] ?? null);
        $password = strip_tags($password);

        $userInfo = checkUserLogin($username, $password);
        if(!empty($userInfo)){
            // tai khoan co ton tai
            // luu thong tin nguoi dung vao session
            $_SESSION['username'] = $userInfo['username'] ;
            $_SESSION['fullname'] = $userInfo['full_name'];
            $_SESSION['email'] = $userInfo['email'];
            $_SESSION['roleId'] = $userInfo['role_id'];
            $_SESSION['idUser'] = $userInfo['role_id'];
            $_SESSION['idAccount'] = $userInfo['id'];
            // cho vao trang quan tri
            header("Location:index.php?c=dashboard");
        }
        else{
            // tai khoan k ton tai
            // quay lai trang dang nhap va thong bao loi
            header("Location:index.php?state=error");
        }
    }
 }

function index(){
    if(isLoginUser()){
        header("Location:index.php?c=dashboard");
        exit();
    }
    require "view/login/index_view.php";
}