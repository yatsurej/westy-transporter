<?php
session_start();

// Function to handle file upload and permit addition
function handleAddPermit() {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["permitFile"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($fileType != "pdf") {
        echo "Sorry, only PDF files are allowed.";
        return;
    }

    if ($uploadOk && move_uploaded_file($_FILES["permitFile"]["tmp_name"], $targetFile)) {
        $permit = [
            'permitType' => $_POST['permitType'],
            'permitNumber' => $_POST['permitNumber'],
            'dateIssued' => $_POST['dateIssued'],
            'expiryDate' => $_POST['expiryDate'],
            'placeIssuance' => $_POST['placeIssuance'],
            'permitFile' => $_FILES['permitFile']['name']
        ];

        $_SESSION['permits'] = $_SESSION['permits'] ?? [];
        $_SESSION['permits'][] = $permit;

        header("Location: application?step=2");
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Function to handle permit deletion
function handleDeletePermit() {
    $delete_key = $_POST['delete_key'];

    if (isset($_SESSION['permits'][$delete_key])) {
        $filename = $_SESSION['permits'][$delete_key]['permitFile'];
        $filePath = "uploads/" . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        unset($_SESSION['permits'][$delete_key]);
        $_SESSION['permits'] = array_values($_SESSION['permits']);
    }

    header("Location: application?step=2");
    exit();
}

// Function to handle product addition
function handleAddProduct() {
    $productName = isset($_POST['productName']) ? htmlspecialchars($_POST['productName']) : '';

    if (!empty($productName)) {
        $_SESSION['products'] = $_SESSION['products'] ?? [];
        $_SESSION['products'][] = ['productName' => $productName];

        header("Location: application?step=3");
        exit();
    } else {
        echo "Product name cannot be empty.";
    }
}

// Function to handle product deletion
function handleDeleteProduct() {
    $delete_key = $_POST['delete_key'];

    if (isset($_SESSION['products'][$delete_key])) {
        unset($_SESSION['products'][$delete_key]);
        $_SESSION['products'] = array_values($_SESSION['products']);
    }

    header("Location: application?step=3");
    exit();
}

// Function to handle service addition
function handleAddService() {
    $serviceName = isset($_POST['serviceName']) ? htmlspecialchars($_POST['serviceName']) : '';

    if (!empty($serviceName)) {
        $_SESSION['services'] = $_SESSION['services'] ?? [];
        $_SESSION['services'][] = ['serviceName' => $serviceName];

        header("Location: application?step=3");
        exit();
    } else {
        echo "Service name cannot be empty.";
    }
}

// Function to handle service deletion
function handleDeleteService() {
    $delete_key = $_POST['delete_key'];

    if (isset($_SESSION['services'][$delete_key])) {
        unset($_SESSION['services'][$delete_key]);
        $_SESSION['services'] = array_values($_SESSION['services']);
    }

    header("Location: application?step=3");
    exit();
}

// Function to handle hazardous waste profile addition
function handleAddHWP() {
    $wasteType = isset($_POST['wasteType']) ? htmlspecialchars($_POST['wasteType']) : '';
    $wasteNature = isset($_POST['wasteNature']) ? htmlspecialchars($_POST['wasteNature']) : '';
    $wasteCatalogue = isset($_POST['wasteCatalogue']) ? htmlspecialchars($_POST['wasteCatalogue']) : '';
    $wasteDetails = isset($_POST['wasteDetails']) ? htmlspecialchars($_POST['wasteDetails']) : '';
    $wastePractice = isset($_POST['wastePractice']) ? htmlspecialchars($_POST['wastePractice']) : '';

    if (!empty($wasteType) && !empty($wasteNature) && !empty($wasteCatalogue)) {
        $_SESSION['wasteProfiles'] = $_SESSION['wasteProfiles'] ?? [];
        $_SESSION['wasteProfiles'][] = [
            'wasteType' => $wasteType,
            'wasteNature' => $wasteNature,
            'wasteCatalogue' => $wasteCatalogue,
            'wasteDetails' => $wasteDetails,
            'wastePractice' => $wastePractice
        ];

        header("Location: application?step=4");
        exit();
    } else {
        echo "Waste inputs cannot be empty.";
    }
}

// Function to handle hazardous waste profile deletion
function handleDeleteWasteProfile() {
    $delete_key = $_POST['delete_key'];

    if (isset($_SESSION['wasteProfiles'][$delete_key])) {
        unset($_SESSION['wasteProfiles'][$delete_key]);
        $_SESSION['wasteProfiles'] = array_values($_SESSION['wasteProfiles']);
    }

    header("Location: application?step=4");
    exit();
}

// Main switch statement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch (true) {
        case isset($_POST['addPermit']):
            handleAddPermit();
            break;
        case isset($_POST['delete_permit']):
            handleDeletePermit();
            break;
        case isset($_POST['addProduct']):
            handleAddProduct();
            break;
        case isset($_POST['delete_product']):
            handleDeleteProduct();
            break;
        case isset($_POST['addService']):
            handleAddService();
            break;
        case isset($_POST['delete_service']):
            handleDeleteService();
            break;
        case isset($_POST['addHWP']):
            handleAddHWP();
            break;
        case isset($_POST['delete_wasteProfile']):
            handleDeleteWasteProfile();
            break;
        default:
            echo "Invalid action.";
            break;
    }
}
?>
