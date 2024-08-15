<?php
    if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
        header("Location: index.php");
        exit();
    }

    if (!isset($_SESSION)) {
        session_start();
    }
?>
<style>
    .sidebar {
        height: 100%;
        width: 250px;
        position: fixed;
        top: 70px; /* Adjust this based on your navbar height */
        left: 0;
        background-color: #586854;
        padding-top: 20px;
        transition: 0.3s;
        z-index: 999; /* Ensure it appears above the main content */
    }

    .sidebar a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 18px;
        color: #ffffff;
        display: block;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background-color: #4a5a43;
    }

    .sidebar .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    .openbtn {
        font-size: 20px;
        cursor: pointer;
        background-color: #586854;
        color: white;
        padding: 10px 15px;
        border: none;
    }

    .openbtn:hover {
        background-color: #4a5a43;
    }

    .main-content {
        margin-left: 260px; /* Same as the width of the sidebar */
        padding: 16px;
        transition: margin-left 0.3s;
    }
</style>

<div class="sidebar" id="mySidebar">
    <?php if (isset($_SESSION['user_logged_in'])): ?>
        <?php if ($_SESSION['userType'] == 'Admin'): ?>
            <a href="dashboard">Inventory</a>
            <a href="feedback">Feedback</a>
            <a href="staff">Staff</a>
            <a href="profile">Profile</a>
        <?php endif; ?>
        <a href="logout">Logout</a>
    <?php endif; ?>
</div>
<script>
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        document.querySelector(".main-content").style.marginLeft = "260px";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.querySelector(".main-content").style.marginLeft = "0";
    }
</script>
