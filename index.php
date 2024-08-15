<?php
    session_start();

    if (!isset($_SESSION['user_logged_in'])){
        header('Location: login');
        exit();
    }

    $pageTitle = "Westy Transporter";
    require 'components/header.php';
    require 'components/db.php';
    
    // Get logged in user details
    $email = $_SESSION['user'];
    $query = "SELECT * FROM user WHERE userEmail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $userID = null;
    while ($row = $result->fetch_assoc()) {
        $userID = $row['userID'];
        $userFname = $row['userFname'];
        $userLname = $row['userLname'];
        $userType = $row['userType'];
    }
    $_SESSION['userType'] = $userType;

    include 'components/navbar.php';
    include 'components/sidebar.php';
?>

<div class="main-content">
</div>
