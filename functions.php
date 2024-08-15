<?php
    require './class/class_user.php';
    $classUser = new User;
    session_start();

    if(isset($_POST['register'])){
        $firstName      = $_POST['firstName'];
        $lastName       = $_POST['lastName'];
        $email          = $_POST['email'];
        $mobileNumber   = $_POST['mobileNumber'];
        $password       = $_POST['password'];
        $governmentID   = $_FILES['governmentID'];
        $companyID      = $_FILES['companyID'];

        if(empty($firstName) || empty($lastName) || empty($email) || empty($mobileNumber) || empty($password) || empty($governmentID['name']) || empty($companyID['name'])){
            echo "<script>alert('Please fill in all fields.');window.location.href='registration';</script>";
            exit();
        }

        $governmentIDDir = 'government_id/';
        $companyIDDir = 'company_id/';

        if (!is_dir($governmentIDDir)) {
            mkdir($governmentIDDir, 0777, true);
        }
        if (!is_dir($companyIDDir)) {
            mkdir($companyIDDir, 0777, true);
        }

        $governmentIDPath = $governmentIDDir . basename($governmentID['name']);
        if (!move_uploaded_file($governmentID['tmp_name'], $governmentIDPath)) {
            echo "<script>alert('Failed to upload government ID.');window.location.href='registration';</script>";
            exit();
        }

        $companyIDPath = $companyIDDir . basename($companyID['name']);
        if (!move_uploaded_file($companyID['tmp_name'], $companyIDPath)) {
            echo "<script>alert('Failed to upload company ID.');window.location.href='registration';</script>";
            exit();
        }

        $result = $classUser->register($firstName, $lastName, $email, $mobileNumber, $password, $governmentIDPath, $companyIDPath);
        if($result) {
            $_SESSION['registration_success'] = true;
            header("Location: thanks");
        }else {
            echo "<script>alert('Registration failed. Please try again.');window.location.href='registration';</script>";
        }
    } elseif(isset($_POST['login'])){
        if(isset($_POST['email']) && isset ($_POST['password'])){
            $email      = $_POST['email'];
            $password   = $_POST['password'];

            $result = $classUser->login($email, $password);

            if($result){
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user'] = $email;
                header("Location: index");
            } else{
                echo "<script>alert('Invalid login details. Please try again.');window.location.href='./login';</script>";
            }
        }
    }
?>
