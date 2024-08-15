<?php
    require './components/db.php';

    if (!class_exists('User')) {
        class User {
            // registration
            public function register($firstName, $lastName, $email, $mobileNumber, $password, $governmentID, $companyID) {
                global $conn;

                $query = "SELECT * FROM user WHERE userEmail = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<script>alert('Email is already taken');window.location.href='./registration';</script>";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $query = "INSERT INTO user (userFname, userLname, userContactNumber, userEmail, userPassword, userGovernmentID, userCompanyID)
                              VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('sssssss', $firstName, $lastName, $mobileNumber, $email, $hashedPassword, $governmentID, $companyID);

                    if ($stmt->execute()) {
                        return true;
                    } else {
                        error_log('Database error: ' . $stmt->error);
                        return false;
                    }
                }
                $stmt->close();
            }

            // login
            public function login($email, $password){
                global $conn;

                $query = "SELECT * FROM user WHERE userEmail = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows > 0){
                    $user = $result->fetch_assoc();

                    if (password_verify($password, $user['userPassword'])) {
                        return true;
                    } else {
                        echo "<script>alert('Wrong password. Please try again.');window.location.href='./login';</script>";
                    }
                } else {
                    return false;
                }
                $stmt->close();
            }
        }
    }
?>
