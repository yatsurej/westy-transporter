<?php
    session_start();

    if (!isset($_SESSION['user_logged_in'])){
        header('Location: login');
        exit();
    }

    require '../components/header.php';
    require '../components/db.php';
    include '../components/navbar.php';

    $currentStep = isset($_GET['step']) ? (int)$_GET['step'] : 1;

    if ($currentStep < 1) $currentStep = 1;
    if ($currentStep > 5) $currentStep = 5;

    $fileTypes = array();
    if (isset($_SESSION['files']) && is_array($_SESSION['files'])) {
        foreach ($_SESSION['files'] as $file) {
            if (isset($file['fileType'])) {
                $fileTypes[] = $file['fileType'];
            }
        }
    }
?>

<style>
    .custom-nav-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 1rem;
        min-width: 120px;
        height: 60px;
        white-space: nowrap;     }

    .navbar-nav {
        flex-wrap: nowrap; 
        margin-left: -15px; 
    }

    .navbar {
        margin-left: -15px; 
    }

    .container {
        padding-left: 0;  
        padding-right: 20; 
    }
</style>

<div class="container w-75">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <ul class="navbar-nav mx-auto d-flex">
                <li class="nav-item text-center">
                    <?php if ($currentStep > 1): ?>
                        <a class="nav-link p-3 bg-success text-white custom-nav-btn" href="?step=<?php echo $currentStep - 1; ?>">
                            Previous<br>
                        </a>
                    <?php else: ?>
                        <span class="nav-link p-3 bg-secondary text-white disabled custom-nav-btn">
                            Previous<br>
                        </span>
                    <?php endif; ?>
                </li>
                <?php 
                $steps = [
                    ['Step 1', 'Basic Information'],
                    ['Step 2', 'Environmental Compliance Permits'],
                    ['Step 3', 'Product and Service Information'],
                    ['Step 4', 'Hazardous Waste Profile'],
                    ['Step 5', 'Upload Required Documents']
                ];

                foreach ($steps as $index => $step): 
                    $stepNumber = $index + 1;
                ?>
                    <li class="nav-item text-center">
                        <a class="nav-link p-3 <?php echo $currentStep === $stepNumber ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled custom-nav-btn" href="#">
                            <?php echo $step[0]; ?><br><?php echo $step[1]; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item text-center">
                    <?php if ($currentStep < 5): ?>
                        <a class="nav-link p-3 bg-success text-white custom-nav-btn" href="?step=<?php echo $currentStep + 1; ?>">
                            Next<br>
                        </a>
                    <?php else: ?>
                        <span class="nav-link p-3 bg-secondary text-white disabled custom-nav-btn">
                            Next<br>
                        </span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
</div>

<form action="functions.php" method="POST">
    <?php if ($currentStep === 1): ?>
        <div class="container w-75">
            <div class="card my-3">
                <div class="card-body">
                    <h1 class="fw-bold my-3 me-2">General Information</h1>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                        <label for="clientID" class="form-label fw-bold">Company</label>
                        <select class="form-control" name="clientID">
                            <option value="">Select option</option>
                            <?php
                                $clientQuery = "SELECT * FROM client WHERE isActive = 1 AND clientStatus = 'Approved'";
                                $clientResult = mysqli_query($conn, $clientQuery);
                                
                                while($row = mysqli_fetch_assoc($clientResult)) {
                                    $clientID   = $row['clientID'];
                                    $clientName = $row['clientName'];

                                    echo "<option value=\"$clientID\">$clientName</option>";
                                }
                            ?>
                        </select>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="managingHead" class="form-label fw-bold">Managing Head</label>
                            <input class="form-control" type="text" name="managingHead" placeholder="Managing Head" required>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="managingHeadMobNum" class="form-label fw-bold">Mobile Number</label>
                            <input class="form-control" type="text" name="managingHeadMobNum" placeholder="Mobile Number" required>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="managingHeadTelNum" class="form-label fw-bold">Telephone Number</label>
                            <input class="form-control" type="text" name="managingHeadTelNum" placeholder="Telephone Number" required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="natureBusiness" class="form-label fw-bold">Nature of Business</label>
                            <input class="form-control" type="text" name="natureBusiness" placeholder="Nature of Business" required>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="psicNum" class="form-label fw-bold">PSIC Number</label>
                            <input class="form-control" type="text" name="psicNum" placeholder="PSIC Number" required>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="psicDesc" class="form-label fw-bold">PSIC Description</label>
                            <input class="form-control" type="text" name="psicDesc" placeholder="PSIC Description" required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="dateEstablishment" class="form-label fw-bold">Date of Establishment</label>
                            <input class="form-control" type="date" name="dateEstablishment" placeholder="Nature of Business" required>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="numEmployees" class="form-label fw-bold">No. of Employees</label>
                            <input class="form-control" type="text" name="numEmployees" placeholder="PSIC Number" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <h1 class="fw-bold my-3 me-2">Pollution Control Officer Information</h1>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <label for="pcoName" class="form-label fw-bold">PCO Name</label>
                            <input class="form-control" type="text" name="pcoName" placeholder="Name of Pollution Control Officer" required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="pcoMobNum" class="form-label fw-bold">PCO Mobile Number</label>
                            <input class="form-control" type="text" name="pcoMobNum" placeholder="Mobile Number of Pollution Control Officer" required>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="pcoTelNum" class="form-label fw-bold">PCO Telephone Number</label>
                            <input class="form-control" type="text" name="pcoTelNum" placeholder="Telephone Number of Pollution Control Officer" required>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="pcoEmail" class="form-label fw-bold">PCO E-mail Address</label>
                            <input class="form-control" type="email" name="pcoEmail" placeholder="E-mail Address of Pollution Control Officer" required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="pcoAccredNo" class="form-label fw-bold">PCO Accreditation No.</label>
                            <input class="form-control" type="text" name="pcoAccredNo" placeholder="Accreditation No. of Pollution Control Officer" required>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="pcoAccredDate" class="form-label fw-bold">PCO Date of Accreditation</label>
                            <input class="form-control" type="date" name="pcoAccredDate" placeholder="Date of Accreditation of Pollution Control Officer" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <h1 class="fw-bold my-3 me-2">Facility Address</h1>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="region" class="form-label fw-bold">Region</label>
                            <select class="form-control" id="region" name="region" onchange="fetchProvinces(this.value)" required>
                                <option value="">Select Region</option>
                                <?php
                                    $regionQuery = "SELECT * FROM refregion";
                                    $regionResult = mysqli_query($conn, $regionQuery);
                                    while($row = mysqli_fetch_assoc($regionResult)) {
                                        echo "<option value=\"".$row['regCode']."\">".$row['regDesc']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="province" class="form-label fw-bold">Province</label>
                                <select class="form-control" id="province" name="province" onchange="fetchCities(this.value)" required>
                                    <option value="">Select Province</option>
                                </select>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="city" class="form-label fw-bold">City/Municipality</label>
                            <select class="form-control" id="city" name="city" onchange="fetchBarangays(this.value)" required>
                                <option value="">Select City/Municipality</option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="barangay" class="form-label fw-bold">Barangay</label>
                            <select class="form-control" id="barangay" name="barangay" required>
                                <option value="">Select Barangay</option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="zipCode" class="form-label fw-bold">Zip Code</label>
                            <input class="form-control" type="text" name="zipCode" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <h1 class="fw-bold my-3 me-2">Geolocation</h1>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 text-end">
                            <a href="https://www.google.com/maps" target="_blank" class="btn text-white" style="background-color:#253E23">
                                <i class="fa-regular fa-map me-2"></i>Open Map
                            </a>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="latitude" class="form-label fw-bold">Latitude</label>
                            <input class="form-control" type="text" name="latitude" placeholder="Latitude coordinates" required>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="longitude" class="form-label fw-bold">Longitude</label>
                            <input class="form-control" type="text" name="longitude" placeholder="Longitude coordinates" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn text-white w-100" style="background-color:#253E23" name="finalizeApplication" role="button">
            <i class="fa-solid fa-check-to-slot"></i>Finalize Application
        </button>
    <?php elseif ($currentStep === 2): ?>
        <div class="container w-75 my-5">
            <div class="card my-3">
                <div class="card-body">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <h1 class="fw-bold my-3 me-2">Permits</h1>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 text-end">
                            <button type="button" class="btn text-white" style="background-color:#253E23" data-bs-toggle="modal" data-bs-target="#addPermitModal" role="button">
                                <i class="fa-solid fa-plus me-1"></i>Add Permit
                            </button>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <table class="table table-responsive table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">Permit</th>
                                        <th scope="col">Latest Permit No. / ID No.</th>
                                        <th scope="col">Date Issued</th>
                                        <th scope="col">Expiry Date</th>
                                        <th scope="col">Place of Insurance</th>
                                        <th scope="col">File</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($_SESSION['permits'])) {
                                            foreach ($_SESSION['permits'] as $key => $permit) {?>
                                                <tr>
                                                    <td class='text-center'><?php echo htmlspecialchars($permit['permitType']); ?></td>
                                                    <td class='text-center'><?php echo htmlspecialchars($permit['permitNumber']); ?></td>
                                                    <td class='text-center'><?php echo htmlspecialchars($permit['dateIssued']); ?></td>
                                                    <td class='text-center'><?php echo htmlspecialchars($permit['expiryDate']); ?></td>
                                                    <td class='text-center'><?php echo htmlspecialchars($permit['placeIssuance']); ?></td>
                                                    <td class='text-center'><?php echo htmlspecialchars($permit['permitFile']); ?></td>
                                                    <td class='text-center'>
                                                        <form action="functions.php" method="post">
                                                            <input type="hidden" name="delete_key" value="<?php echo $key; ?>">
                                                            <button type="submit" name="delete_permit" class="btn btn-outline-danger">
                                                                <i class='fa-solid fa-trash'></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($currentStep === 3): ?>
        <div class="container w-75 my-5">
            <div class="card my-3">
                <div class="card-body">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <h1 class="fw-bold my-3 me-2">Product</h1>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 text-end">
                            <button type="button" class="btn text-white" style="background-color:#253E23"  href="#" data-bs-toggle="modal" data-bs-target="#addProductModal" role="button">
                                <i class="fa-solid fa-plus me-1"></i>Add Product
                            </button>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <table class="table table-responsive table-hover">
                                <thead class="text-start">
                                    <tr>
                                        <th scope="col" class="col-9">Product Name</th>
                                        <th scope="col" class="col-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($_SESSION['products'])) {
                                            foreach ($_SESSION['products'] as $key => $product) {?>
                                                <tr>
                                                    <td class='text-start'><?php echo htmlspecialchars($product['productName']); ?></td>
                                                    <td class='text-start'>
                                                        <form action="functions.php" method="post">
                                                            <input type="hidden" name="delete_key" value="<?php echo $key; ?>">
                                                            <button type="submit" name="delete_product" class="btn btn-outline-danger">
                                                                <i class='fa-solid fa-trash'></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <h1 class="fw-bold my-3 me-2">Service</h1>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 text-end">
                            <button type="button" class="btn text-white" style="background-color:#253E23"  href="#" data-bs-toggle="modal" data-bs-target="#addServiceModal" role="button">
                                <i class="fa-solid fa-plus me-1"></i>Add Service
                            </button>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <table class="table table-responsive table-hover">
                                <thead class="text-start">
                                    <tr>
                                        <th scope="col" class="col-9">Service Name</th>
                                        <th scope="col" class="col-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($_SESSION['services'])) {
                                            foreach ($_SESSION['services'] as $key => $service) {?>
                                                <tr>
                                                    <td class='text-start'><?php echo htmlspecialchars($service['serviceName']); ?></td>
                                                    <td class='text-start'>
                                                        <form action="functions.php" method="post">
                                                            <input type="hidden" name="delete_key" value="<?php echo $key; ?>">
                                                            <button type="submit" name="delete_service" class="btn btn-outline-danger">
                                                                <i class='fa-solid fa-trash'></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($currentStep === 4): ?>
        <div class="container w-75 my-5">
            <div class="card my-3">
                <div class="card-body">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <h1 class="fw-bold my-3 me-2">Hazardous Waste Profiles</h1>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 text-end">
                            <button type="button" class="btn text-white" style="background-color:#253E23"  href="#" data-bs-toggle="modal" data-bs-target="#addHWPModal" role="button">
                                <i class="fa-solid fa-plus me-1"></i>Add Profile
                            </button>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <table class="table table-responsive table-hover">
                                <thead class="text-start">
                                    <tr>
                                        <th scope="col">Type</th>
                                        <th scope="col">Nature</th>
                                        <th scope="col">Catalogue</th>
                                        <th scope="col">Waste Details</th>
                                        <th scope="col">Current Waste Management Practice</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($_SESSION['wasteProfiles'])) {
                                            foreach ($_SESSION['wasteProfiles'] as $key => $wasteProfile) {?>
                                                <tr>
                                                    <td class='text-start'><?php echo htmlspecialchars($wasteProfile['wasteType']); ?></td>
                                                    <td class='text-start'><?php echo htmlspecialchars($wasteProfile['wasteNature']); ?></td>
                                                    <td class='text-start'><?php echo htmlspecialchars($wasteProfile['wasteCatalogue']); ?></td>
                                                    <td class='text-start'><?php echo htmlspecialchars($wasteProfile['wasteDetails']); ?></td>
                                                    <td class='text-start'><?php echo htmlspecialchars($wasteProfile['wastePractice']); ?></td>
                                                    <td class='text-start'>
                                                        <form action="functions.php" method="post">
                                                            <input type="hidden" name="delete_key" value="<?php echo $key; ?>">
                                                            <button type="submit" name="delete_wasteProfile" class="btn btn-outline-danger">
                                                                <i class='fa-solid fa-trash'></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($currentStep === 5): ?>
        <div class="container w-75 my-5">
            <div class="card my-3">
                <div class="card-body">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <h1 class="fw-bold my-3 me-2">Upload Attachments</h1>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckNotarizedAffidavit" disabled
                                    <?php if (in_array('notarizedAffidavit', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckNotarizedAffidavit">
                                    Duly notarized affidavit attesting to the truth, accuracy, and genuineness of all information, documents, and records contained and attached in the application.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckMassBalance" disabled
                                    <?php if (in_array('massBalance', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckMassBalance">
                                    Mass balance of manufacturing process
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckWasteManagementPlan" disabled
                                    <?php if (in_array('wasteManagementPlan', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckWasteManagementPlan">
                                    Description of existing waste management plan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckWasteAnalysis" disabled
                                    <?php if (in_array('wasteAnalysis', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckWasteAnalysis">
                                    Analysis of waste(s)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckOtherInfo" disabled
                                    <?php if (in_array('otherInfo', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckOtherInfo">
                                    Other relevant information e.g. planned changes in production process or output, comparison with relation operation.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckEccCnc" disabled
                                    <?php if (in_array('eccCnc', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckEccCnc">
                                    Copy of Environmental Compliance Certificate (ECC) / Certificate of Non-Coverage (CNC)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckPto" disabled
                                    <?php if (in_array('pto', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckPto">
                                    Copy of Valid Permit to Operate (PTO)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDischargePermit" disabled
                                    <?php if (in_array('dischargePermit', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckDischargePermit">
                                    Copy of Valid Discharge Permit (DP)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckPcoAccreditation" disabled
                                    <?php if (in_array('pcoAccreditation', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckPcoAccreditation">
                                    Pollution Control Officer accreditations certificate
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckEmergencyPlan" disabled
                                    <?php if (in_array('emergencyPlan', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckEmergencyPlan">
                                    Contingency and Emergency Plan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckStorageAreaPhotos" disabled
                                    <?php if (in_array('storageAreaPhotos', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckStorageAreaPhotos">
                                    Photographs of the hazardous waste storage area
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckRequestLetter" disabled
                                    <?php if (in_array('requestLetter', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckRequestLetter">
                                    Official letter of request
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckTenantsList" disabled
                                    <?php if (in_array('tenantsList', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckTenantsList">
                                    List of individual tenants/establishments
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckMemberInfo" disabled
                                    <?php if (in_array('memberInfo', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckMemberInfo">
                                    Information on the individual member establishment per approved cluster
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckEmbClusteringLetter" disabled
                                    <?php if (in_array('embClusteringLetter', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckEmbClusteringLetter">
                                    Letter from the EMB Central Office on the approved clustering
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckJointUnderstandingAffidavit" disabled
                                    <?php if (in_array('jointUnderstandingAffidavit', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckJointUnderstandingAffidavit">
                                    Affidavit of Joint Understanding among individual member establishments, the cluster Managing Head, and the cluster PCO
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckClusterMap" disabled
                                    <?php if (in_array('clusterMap', $fileTypes)) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckClusterMap">
                                    Map of clustered individual establishments including geotagged photos of the facade of the establishments
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <button type="button" class="btn text-white w-100" style="background-color:#586854" href="#" role="button" onclick="showFileTable()">
                                <i class="fa-solid fa-plus me-1"></i>Add Files
                            </button>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <button type="submit" class="btn text-white w-100" style="background-color:#253E23" name="finalizeApplication" role="button">
                                <i class="fa-solid fa-check-to-slot"></i>Finalize Application
                            </button>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <table class="table table-responsive table-hover">
                            <thead class="text-start">
                                <tr>
                                    <th scope="col" class="col-3">File Name</th>
                                    <th scope="col" class="col-1"></th>
                                    <th scope="col" class="col-5">File type</th>
                                    <th scope="col" class="col-3">
                                        <button type="button" class="btn text-white w-100" style="background-color:#253E23"  href="#" data-bs-toggle="modal" data-bs-target="#addFileModal" role="button">
                                            <i class="fa-solid fa-check-to-slot"></i>Upload File
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($_SESSION['files'])) {
                                        $fileTypeDescriptions = [
                                            "notarizedAffidavit" => "Duly notarized affidavit attesting to the truth, accuracy, and genuineness of all information, documents, and records contained and attached in the application.",
                                            "massBalance" => "Mass balance of manufacturing process",
                                            "wasteManagementPlan" => "Description of existing waste management plan",
                                            "wasteAnalysis" => "Analysis of waste(s)",
                                            "otherInfo" => "Other relevant information e.g. planned changes in production process or output, comparison with relation operation.",
                                            "eccCnc" => "Copy of Environmental Compliance Certificate (ECC) / Certificate of Non-Coverage (CNC)",
                                            "pto" => "Copy of Valid Permit to Operate (PTO)",
                                            "dischargePermit" => "Copy of Valid Discharge Permit (DP)",
                                            "pcoAccreditation" => "Pollution Control Officer accreditations certificate",
                                            "emergencyPlan" => "Contingency and Emergency Plan",
                                            "storageAreaPhotos" => "Photographs of the hazardous waste storage area",
                                            "requestLetter" => "Official letter of request",
                                            "tenantsList" => "List of individual tenants/establishments",
                                            "memberInfo" => "Information on the individual member establishment per approved cluster",
                                            "embClusteringLetter" => "Letter from the EMB Central Office on the approved clustering",
                                            "jointUnderstandingAffidavit" => "Affidavit of Joint Understanding among individual member establishments, the cluster Managing Head, and the cluster PCO",
                                            "clusterMap" => "Map of clustered individual establishments including geotagged photos of the facade of the establishments"
                                        ];
                                        foreach ($_SESSION['files'] as $key => $file) {?>
                                            <tr>
                                                <td class='text-start'><?php echo htmlspecialchars($file['fileName']); ?></td>
                                                <td class='text-start'><?php echo htmlspecialchars($file['fileSize']); ?></td>
                                                <td class='text-start'><?php echo htmlspecialchars($fileTypeDescriptions[$file['fileType']] ?? 'Unknown File Type'); ?></td>
                                                <td class='text-start'>
                                                    <form action="functions.php" method="post">
                                                        <input type="hidden" name="delete_key" value="<?php echo $key; ?>">
                                                        <button type="submit" name="delete_file" class="btn btn-outline-danger">
                                                            <i class='fa-solid fa-trash'></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>

<!-- Add Permit -->
<div class="modal fade" id="addPermitModal" tabindex="-1" aria-labelledby="addPermitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPermitModalLabel">Add Permit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post" enctype="multipart/form-data">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="permitType" class="form-label">Permit Type:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                           <select class="form-control" name="permitType">
                                <option value="">Please select a permit type</option>
                                <option value="ECC">Environmental Compliance Certificate (ECC)</option>
                                <option value="CNC">Certificate of Non Coverage (CNC)</option>
                                <option value="PTO">Permit to Operate (PTO)</option>
                                <option value="DP">Discharge Permit (DP)</option>
                                <option value="GRC">HW Generator Registration Certificate (GRC)</option>
                                <option value="PCO">Pollution Control Officer Accreditation Certificate (PCO)</option>
                                <option value="CCO">Chemical Control Order (CCO)</option>
                           </select>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="permitNumber" class="form-label">Latest Permit No. / ID No.:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <input type="text" class="form-control" id="permitNumber" name="permitNumber" placeholder="Latest Permit No. / ID No." required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="dateIssued" class="form-label">Date Issued:</label>
                            <input type="date" class="form-control" id="dateIssued" name="dateIssued" required>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="expiryDate" class="form-label">Expiry Date:</label>
                            <input type="date" class="form-control" id="expiryDate" name="expiryDate" required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="placeIssuance" class="form-label">Place of Issuance:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <input type="text" class="form-control" id="placeIssuance" name="placeIssuance" placeholder="Place of Issuance" required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="permitFile" class="form-label">Attach Permit / Certificate (.pdf):</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <input type="file" class="form-control" id="permitFile" name="permitFile" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="addPermit" class="btn btn-success w-25">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Product -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post" enctype="multipart/form-data">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="productName" class="form-label">Product Name:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Product Name" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="addProduct" class="btn btn-success w-25">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Service -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Add Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post" enctype="multipart/form-data">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="serviceName" class="form-label">Service Name:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <input type="text" class="form-control" id="serviceName" name="serviceName" placeholder="Service Name" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="addService" class="btn btn-success w-25">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add HWP -->
<div class="modal fade" id="addHWPModal" tabindex="-1" aria-labelledby="addHWPModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHWPModalLabel">Add Waste Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post" enctype="multipart/form-data">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="wasteType" class="form-label">Waste:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <select class="form-control" name="wasteType">
                                <option value="">Please select a waste</option>
                                <option value="A101">A101 - Wastes with Cyanide</option>
                                <option value="B201">B201 - Sulfuric Acid</option>
                                <option value="B202">B202 - Hydrochloric Acid</option>
                                <option value="B203">B203 - Nitric Acid</option>
                                <option value="B204">B204 - Phosphoric Acid</option>
                                <option value="B205">B205 - Hydrofluoric Acid</option>
                                <option value="B206">B206 - Mixture of Sulfuric and Hydrochloric Acid</option>
                                <option value="B207">B207 - Other Inorganic Acid</option>
                                <option value="B208">B208 - Organic Acid</option>
                                <option value="B299">B299 - Other Acid Waste</option>
                                <option value="C301">C301 - Caustic Soda</option>
                                <option value="C302">C302 - Potash</option>
                                <option value="C303">C303 - Alkaline Cleaners</option>
                                <option value="C304">C304 - Ammonium Hydroxide</option>
                                <option value="C305">C305 - Lime Slurries</option>
                                <option value="C399">C399 - Other Alkali Wastes</option>
                                <option value="D401">D401 - Selenium and its Compounds</option>
                                <option value="D403">D403 - Barium and its Compounds</option>
                                <option value="D404">D404 - Cadmium and its Compounds</option>
                                <option value="D405">D405 - Chromium Compounds</option>
                                <option value="D406">D406 - Lead Compounds</option>
                                <option value="D407">D407 - Mercury and Mercury Compounds</option>
                                <option value="D408">D408 - Fluoride and its Compounds</option>
                                <option value="D499">D499 - Other Wastes with Inorganic Chemicals</option>
                                <option value="E501">E501 - Oxidizing Agents</option>
                                <option value="E502">E502 - Reducing Agents</option>
                                <option value="E503">E503 - Explosive and Unstable Chemicals</option>
                                <option value="E599">E599 - Highly Reactive Chemicals</option>
                                <option value="F601">F601 - Solvent Based</option>
                                <option value="F602">F602 - Inorganic Pigments</option>
                                <option value="F603">F603 - Ink Formulation</option>
                                <option value="F604">F604 - Resinous Materials</option>
                                <option value="F699">F699 - Other Mixed</option>
                                <option value="G703">G703 - Halogenated Organic Solvent</option>
                                <option value="G704">G704 - Non-Halogenated Organic Solvents</option>
                                <option value="H802">H802 - Grease Wastes</option>
                                <option value="I101">I101 - Used Industrial Oil Including Sludge</option>
                                <option value="I102">I102 - Vegetable Oil Including Sludge</option>
                                <option value="I103">I103 - Tallow</option>
                                <option value="I104">I104 - Oil-Contaminated Materials</option>
                                <option value="J201">J201 - Containers Previously Containing Toxic Chemical Substances</option>
                                <option value="K301">K301 - Solidified Wastes</option>
                                <option value="K302">K302 - Chemically Fixed and Polymerized Wastes</option>
                                <option value="K303">K303 - Encapsulated Wastes</option>
                                <option value="L401">L401 - Wastes with Specific Halogenated Toxic Organic Chemicals</option>
                                <option value="L402">L402 - Wastes with Specific Non-Halogenated Toxic Organic Chemicals</option>
                                <option value="M501">M501 - Pathological or Infectious Wastes</option>
                                <option value="M503">M503 - Pharmaceuticals and Drugs</option>
                                <option value="M504">M504 - Pesticides</option>
                                <option value="M505">M505 - Persistent Organic Pollutants (POPs) Waste</option>
                                <option value="M506">M506 - Waste Electrical and Electronic Equipment (WEEE)</option>
                                <option value="M507">M507 - Special Wastes</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="wasteNature" class="form-label">Nature:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <select class="form-control" name="wasteNature">
                                <option value="">Please select a nature</option>
                                <option value="solid">Solid</option>
                                <option value="liquid">Liquid</option>
                                <option value="gas">Gas</option>
                                <option value="sludge">Sludge</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="wasteCatalogue" class="form-label">Catalogue:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <select class="form-control" name="wasteCatalogue">
                                <option value="">Please select a waste</option>
                                <option value="toxic">Toxic</option>
                                <option value="corrosive">Corrosive</option>
                                <option value="reactive">Reactive</option>
                                <option value="ignitable">Ignitable</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="wasteDetails" class="form-label">Waste Details:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <input type="text" class="form-control" id="wasteDetails" name="wasteDetails" placeholder="Waste details" required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="wastePractice" class="form-label">Current Waste Management Practice:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <textarea class="form-control" rows="3" style="resize:none;"name="wastePractice" required></textarea>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="addHWP" class="btn btn-success w-25">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add File -->
<div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="addFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFileModalLabel">Add File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post" enctype="multipart/form-data">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="fileType" class="form-label">File Type:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <select class="form-select" name="fileType" id="documentSelect">
                                <option value="">Select file type</option>
                                <option value="notarizedAffidavit">Duly notarized affidavit attesting to the truth, accuracy, and genuineness of all information, documents, and records contained and attached in the application.</option>
                                <option value="massBalance">Mass balance of manufacturing process</option>
                                <option value="wasteManagementPlan">Description of existing waste management plan</option>
                                <option value="wasteAnalysis">Analysis of waste(s)</option>
                                <option value="otherInfo">Other relevant information e.g. planned changes in production process or output, comparison with relation operation.</option>
                                <option value="eccCnc">Copy of Environmental Compliance Certificate (ECC) / Certificate of Non-Coverage (CNC)</option>
                                <option value="pto">Copy of Valid Permit to Operate (PTO)</option>
                                <option value="dischargePermit">Copy of Valid Discharge Permit (DP)</option>
                                <option value="pcoAccreditation">Pollution Control Officer accreditations certificate</option>
                                <option value="emergencyPlan">Contingency and Emergency Plan</option>
                                <option value="storageAreaPhotos">Photographs of the hazardous waste storage area</option>
                                <option value="requestLetter">Official letter of request</option>
                                <option value="tenantsList">List of individual tenants/establishments</option>
                                <option value="memberInfo">Information on the individual member establishment per approved cluster</option>
                                <option value="embClusteringLetter">Letter from the EMB Central Office on the approved clustering</option>
                                <option value="jointUnderstandingAffidavit">Affidavit of Joint Understanding among individual member establishments, the cluster Managing Head, and the cluster PCO</option>
                                <option value="clusterMap">Map of clustered individual establishments including geotagged photos of the facade of the establishments</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="fileName" class="form-label">File Name:</label>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <input type="file" class="form-control" id="fileName" name="fileName" placeholder="File Name" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="addFile" class="btn btn-success w-25">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function fetchProvinces(regionCode) {
        if (regionCode === "") {
            document.getElementById('province').innerHTML = '<option value="">Select Province</option>';
            document.getElementById('city').innerHTML = '<option value="">Select City/Municipality</option>';
            document.getElementById('barangay').innerHTML = '<option value="">Select Barangay</option>';
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_location.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (this.status === 200) {
                document.getElementById('province').innerHTML = this.responseText;
            }
        };
        xhr.send('regionCode=' + encodeURIComponent(regionCode));
    }

    function fetchCities(provCode) {
        if (provCode === "") {
            document.getElementById('city').innerHTML = '<option value="">Select City/Municipality</option>';
            document.getElementById('barangay').innerHTML = '<option value="">Select Barangay</option>';
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_location.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (this.status === 200) {
                document.getElementById('city').innerHTML = this.responseText;
            }
        };
        xhr.send('provCode=' + encodeURIComponent(provCode));
    }

    function fetchBarangays(cityCode) {
        if (cityCode === "") {
            document.getElementById('barangay').innerHTML = '<option value="">Select Barangay</option>';
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_location.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (this.status === 200) {
                document.getElementById('barangay').innerHTML = this.responseText;
            }
        };
        xhr.send('cityCode=' + encodeURIComponent(cityCode));
    }
</script>
