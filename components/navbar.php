<?php
    if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
        header("Location: index.php");
        exit();
    }

    if (!isset($_SESSION)) {
        session_start();
    }
?>
<nav class="navbar navbar-expand-lg" style="background-color:#586854">
    <div class="container-fluid w-75 d-flex justify-content-between align-items-center">
        <a class="navbar-brand text-light" href="index">Westy</a>
        <?php if (isset($_SESSION['user_logged_in'])): ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-end">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="logout">Logout</a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>
