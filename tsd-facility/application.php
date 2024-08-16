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
?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<div class="container w-75">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <ul class="navbar-nav mx-auto d-flex flex-wrap justify-content-center">
                <li class="nav-item text-center">
                    <?php if ($currentStep > 1): ?>
                        <a class="nav-link p-3 bg-success text-white" href="?step=<?php echo $currentStep - 1; ?>">
                            Previous<br>
                        </a>
                    <?php else: ?>
                        <span class="nav-link p-3 bg-secondary text-white disabled">
                            Previous<br>
                        </span>
                    <?php endif; ?>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 1 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled" href="#">
                        Step 1<br><small>Basic Information</small>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 2 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled" href="#">
                        Step 2<br><small>Environmental Compliance Permits</small>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 3 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled" href="#">
                        Step 3<br><small>Product and Service Information</small>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 4 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled" href="#">
                        Step 4<br><small>Hazardous Waste Profile</small>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 5 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled" href="#">
                        Step 5<br><small>Upload Required Documents</small>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <?php if ($currentStep < 5): ?>
                        <a class="nav-link p-3 bg-success text-white" href="?step=<?php echo $currentStep + 1; ?>">
                            Next<br>
                        </a>
                    <?php else: ?>
                        <span class="nav-link p-3 bg-secondary text-white disabled">
                            Next<br>
                        </span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
</div>
<form action="./functions.php" method="POST">
    <?php if ($currentStep === 1): ?>
        <div class="container w-75">
            <div class="card my-3">
                <div class="card-body">
                    <h1 class="fw-bold my-3 me-2">General Information</h1>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                        <label for="clientName" class="form-label fw-bold">Company</label>
                        <select class="form-control">
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
                            <label for="natureBusiness" class="form-label fw-bold">Date of Establishment</label>
                            <input class="form-control" type="date" name="natureBusiness" placeholder="Nature of Business" required>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="psicNum" class="form-label fw-bold">No. of Employees</label>
                            <input class="form-control" type="text" name="psicNum" placeholder="PSIC Number" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <h1 class="fw-bold my-3 me-2">Pollution Control Officer Information</h1>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <label for="clientName" class="form-label fw-bold">PCO Name</label>
                            <input class="form-control" type="text" name="pcoName" placeholder="Name of Pollution Control Officer" required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="managingHead" class="form-label fw-bold">PCO Mobile Number</label>
                            <input class="form-control" type="text" name="pcoMobNum" placeholder="Mobile Number of Pollution Control Officer" required>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="managingHeadMobNum" class="form-label fw-bold">PCO Telephone Number</label>
                            <input class="form-control" type="text" name="pcoTelNum" placeholder="Telephone Number of Pollution Control Officer" required>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="managingHeadTelNum" class="form-label fw-bold">PCO E-mail Address</label>
                            <input class="form-control" type="email" name="pcoEmail" placeholder="E-mail Address of Pollution Control Officer" required>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="natureBusiness" class="form-label fw-bold">PCO Accreditation No.</label>
                            <input class="form-control" type="text" name="pcoAccredNo" placeholder="Accreditation No. of Pollution Control Officer" required>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="psicNum" class="form-label fw-bold">PCO Date of Accreditation</label>
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
                            <select class="form-control" id="region" name="region" required>
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
                            <select class="form-control" id="province" name="province" required>
                                <option value="">Select Province</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="city" class="form-label fw-bold">City/Municipality</label>
                            <select class="form-control" id="city" name="city" required>
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
    <?php elseif ($currentStep === 2): ?>
        <div class="container w-75 my-5">
            <div class="card my-3">
                <div class="card-body">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <h1 class="fw-bold my-3 me-2">Permits</h1>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 text-end">
                            <button class="btn text-white" style="background-color:#253E23"  href="#" data-bs-toggle="modal" data-bs-target="#addClientModal" role="button">
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
                                    <tr>
                                        <td class="text-center">Hello</td>
                                        <td class="text-center">Hello</td>
                                        <td class="text-center">Hello</td>
                                        <td class="text-center">Hello</td>
                                        <td class="text-center">Hello</td>
                                        <td class="text-center">Hello</td>
                                        <td class="text-center">
                                            <div class="text-center me-1">
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#viewClientModal<?php echo $clientID; ?>">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </div>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
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
                            <button class="btn text-white" style="background-color:#253E23"  href="#" data-bs-toggle="modal" data-bs-target="#addClientModal" role="button">
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
                                    <tr>
                                        <td class="text-start">Hello</td>
                                        <td class="text-start">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#viewClientModal<?php echo $clientID; ?>">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-trash"></i>
                                                </div>
                                            </button>
                                        </td>
                                    </tr>
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
                            <button class="btn text-white" style="background-color:#253E23"  href="#" data-bs-toggle="modal" data-bs-target="#addClientModal" role="button">
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
                                    <tr>
                                        <td class="text-start">Hello</td>
                                        <td class="text-start">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#viewClientModal<?php echo $clientID; ?>">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-trash"></i>
                                                </div>
                                            </button>
                                        </td>
                                    </tr>
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
                            <button class="btn text-white" style="background-color:#253E23"  href="#" data-bs-toggle="modal" data-bs-target="#addClientModal" role="button">
                                <i class="fa-solid fa-plus me-1"></i>Add Profile
                            </button>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <table class="table table-responsive table-hover">
                                <thead class="text-start">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Nature</th>
                                        <th scope="col">Catalogue</th>
                                        <th scope="col">Waste Details</th>
                                        <th scope="col">Current Waste Management Practice</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start">Hello</td>
                                        <td class="text-start">Hello</td>
                                        <td class="text-start">Hello</td>
                                        <td class="text-start">Hello</td>
                                        <td class="text-start">Hello</td>
                                        <td class="text-start">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#viewClientModal<?php echo $clientID; ?>">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-trash"></i>
                                                </div>
                                            </button>
                                        </td>
                                    </tr>
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
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Duly notarized affidavit attesting to the truth, accuracy, and genuineness of all information, documents, and records contained and attached in the application.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Mass balance of manufacturing process
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Description of existing waste management plan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Analysis of waste(s)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Other relevant information e.g. planned changes in production process or output, comparison with relation operation.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Copy of Environmental Compliance Certificate (ECC) / Certificate of Non-Coverage (CNC)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Copy of Valid Permit to Operate (PTO)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Copy of Valid Discharge Permit (DP)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Pollution Control Officer accreditations certificate
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Contingency and Emergency Plan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Photographs of the hazardous waste storage area
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Official letter of request
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    List of individual tenants/establishments
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Information on the individual member establishment per approved cluster
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Letter from the EMB Cetral Office on the approved clustering
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Affidavit of Joint Understanding among individual member establishments, the cluster Managing Head, and the cluster PCO
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Map of clustered individual establishments including geotagged photos of the facade of the establishments
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <button class="btn text-white w-100" style="background-color:#586854"  href="#" data-bs-toggle="modal" data-bs-target="#addClientModal" role="button">
                                <i class="fa-solid fa-plus me-1"></i>Add Files
                            </button>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <button class="btn text-white w-100" style="background-color:#253E23"  href="#" data-bs-toggle="modal" data-bs-target="#addClientModal" role="button">
                                <i class="fa-solid fa-check-to-slot"></i>Finalize Application
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>