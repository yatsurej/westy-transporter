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
    .custom-nav-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 1rem; 
        min-width: 120px; 
        height: 60px; 
    }
</style>
<div class="container w-75">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <ul class="navbar-nav mx-auto d-flex flex-wrap justify-content-center">
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
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 1 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled custom-nav-btn" href="#">
                        Step 1<br>Basic Information
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 2 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled custom-nav-btn" href="#">
                        Step 2<br>Select Waste
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 3 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled custom-nav-btn" href="#">
                        Step 3<br>Choose a Transporter
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 4 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled custom-nav-btn" href="#">
                        Step 4<br>Choose a TSD Facility
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link p-3 <?php echo $currentStep === 5 ? 'bg-white text-success border border-success' : 'bg-success text-white'; ?> disabled custom-nav-btn" href="#">
                        Step 5<br>Upload Required Documents
                    </a>
                </li>
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
                            <input class="form-control" type="text" name="managingHead" placeholder="Managing Head" disabled>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="managingHeadMobNum" class="form-label fw-bold">Mobile Number</label>
                            <input class="form-control" type="text" name="managingHeadMobNum" placeholder="Mobile Number" disabled>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="managingHeadTelNum" class="form-label fw-bold">Telephone Number</label>
                            <input class="form-control" type="text" name="managingHeadTelNum" placeholder="Telephone Number" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="natureBusiness" class="form-label fw-bold">Nature of Business</label>
                            <input class="form-control" type="text" name="natureBusiness" placeholder="Nature of Business" disabled>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="psicNum" class="form-label fw-bold">PSIC Number</label>
                            <input class="form-control" type="text" name="psicNum" placeholder="PSIC Number" disabled>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <label for="psicDesc" class="form-label fw-bold">PSIC Description</label>
                            <input class="form-control" type="text" name="psicDesc" placeholder="PSIC Description" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="natureBusiness" class="form-label fw-bold">Date of Establishment</label>
                            <input class="form-control" type="date" name="natureBusiness" placeholder="Nature of Business" disabled>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="psicNum" class="form-label fw-bold">No. of Employees</label>
                            <input class="form-control" type="text" name="psicNum" placeholder="PSIC Number" disabled>
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
                            <input class="form-control" type="text" name="pcoName" placeholder="Name of Pollution Control Officer" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="managingHead" class="form-label fw-bold">PCO Mobile Number</label>
                            <input class="form-control" type="text" name="pcoMobNum" placeholder="Mobile Number of Pollution Control Officer" disabled>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="managingHeadMobNum" class="form-label fw-bold">PCO Telephone Number</label>
                            <input class="form-control" type="text" name="pcoTelNum" placeholder="Telephone Number of Pollution Control Officer" disabled>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="managingHeadTelNum" class="form-label fw-bold">PCO E-mail Address</label>
                            <input class="form-control" type="email" name="pcoEmail" placeholder="E-mail Address of Pollution Control Officer" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="natureBusiness" class="form-label fw-bold">PCO Accreditation No.</label>
                            <input class="form-control" type="text" name="pcoAccredNo" placeholder="Accreditation No. of Pollution Control Officer" disabled>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="psicNum" class="form-label fw-bold">PCO Date of Accreditation</label>
                            <input class="form-control" type="date" name="pcoAccredDate" placeholder="Date of Accreditation of Pollution Control Officer" disabled>
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
                            <select class="form-control" id="region" name="region" disabled>
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
                            <select class="form-control" id="province" name="province" disabled>
                                <option value="">Select Province</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="city" class="form-label fw-bold">City/Municipality</label>
                            <select class="form-control" id="city" name="city" disabled>
                                <option value="">Select City/Municipality</option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="barangay" class="form-label fw-bold">Barangay</label>
                            <select class="form-control" id="barangay" name="barangay" disabled>
                                <option value="">Select Barangay</option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="zipCode" class="form-label fw-bold">Zip Code</label>
                            <input class="form-control" type="text" name="zipCode" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                  <?php
    session_start();

    if (!isset($_SESSION['user_logged_in'])){
        header('Location: login');
        exit();
    }

    require 'components/header.php';
    require 'components/db.php';
    include 'components/navbar.php';

    $userQuery = "SELECT * FROM user ORDER BY userID DESC";
    $userResult = mysqli_query($conn, $userQuery);

    $users = [];
    
    while($row = mysqli_fetch_assoc($userResult)){
        $userID       = $row['userID'];
        $userFname    = $row['userFname'];
        $userLname    = $row['userLname'];
    
        $userType = isset($row['userType']) && !is_null($row['userType']) ? $row['userType'] : "N/A";
    
        switch ($row['userStatus']) {
            case 0:
                $userStatus = "In Progress";
                break;
            case 1:
                $userStatus = "Approved";
                break;
            case 2:
                $userStatus = "Rejected";
                break;
            default:
                $userStatus = "Unknown"; 
        }
    
        $users[] = [
            'userID' => $userID,
            'userFname' => $userFname,
            'userLname' => $userLname,
            'userType' => $userType,
            'userStatus' => $userStatus
        ];
    }
?>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }
</style>
<div class="container w-75">
    <div class="d-flex justify-content-center">
        <h1 class="fw-bold my-3 me-2">Employees</h1> 
    </div>
    <table class="table table-responsive table-hover">
        <thead class="text-center">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Department</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="5" class="text-center">No users found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="text-center"><?php echo $user['userFname'] . " " . $user['userLname']; ?></td>
                        <td class="text-center"><?php echo $user['userType']; ?></td>
                        <td class="text-center"><?php echo $user['userStatus']; ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <!-- View Button -->
                                <div class="text-center me-1">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#viewUserModal<?php echo $user['userID']; ?>">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-solid fa-eye"></i>
                                        </div>
                                    </button>
                                </div>
                                <!-- Edit Button -->
                                <div class="text-center">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $user['userID']; ?>">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editUserModal<?php echo $user['userID']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="functions.php" method="post">
                                        <div class="row align-items-center my-2">
                                            <div class="col-xl-3 col-lg-3 col-md-3">
                                                <label for="clientName" class="form-label">Status</label>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-9">
                                                <select class="input-group form-control" id="inputGroupSelect01">
                                                    <option selected>Select option</option>
                                                    <option value="1">Approve</option>
                                                    <option value="2">Reject</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row align-items-center my-2">
                                            <div class="col-xl-3 col-lg-3 col-md-3">
                                                <label for="clientName" class="form-label">Department</label>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-9">
                                                <select class="input-group form-control" id="inputGroupSelect01">
                                                    <option selected >Select option</option>
                                                    <option value="ASD">ASD</option>
                                                    <option value="LSD">LSD</option>
                                                    <option value="Database">Database</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" name="editUser" class="btn btn-success w-25">Edit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>         <h1 class="fw-bold my-3 me-2">Geolocation</h1>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="latitude" class="form-label fw-bold">Latitude</label>
                            <input class="form-control" type="text" name="latitude" placeholder="Latitude coordinates" disabled>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="longitude" class="form-label fw-bold">Longitude</label>
                            <input class="form-control" type="text" name="longitude" placeholder="Longitude coordinates" disabled>
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
                        <button class="btn text-white" style="background-color:#253E23" data-bs-toggle="modal" data-bs-target="#addClientModal" role="button">
                        <i class="fa-solid fa-plus me-1"></i>Add Waste
                        </button>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <table class="table table-responsive table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Waste Code</th>
                                        <th scope="col">Quantity in metric tonnes(MT)</th>
                                        <th scope="col">Actions</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
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
                            <h1 class="fw-bold my-3 me-2">Generator Information</h1>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 text-end">
                        <button class="btn text-white" style="background-color:#253E23" data-bs-toggle="modal" data-bs-target="#addClientModal" role="button">
                        <i class="fa-solid fa-plus me-1"></i>Add More
                        </button>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <table class="table table-responsive table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Order Sequence</th>
                                        <th scope="col">Transporter ID</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Expiry Date</th>
                                        <th scope="col">Actions</th>
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
    <?php elseif ($currentStep === 4): ?>
        <div class="container w-75">
            <div class="card my-3">
                <div class="card-body">
                    <h1 class="fw-bold my-3 me-2">TSD Facility</h1>
                    <div class="row align-items-center my-2">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                        <label for="clientName" class="form-label fw-bold">TSD Facility</label>
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
                                Notarized Memorandum of Agreement/Affidavit of Undertaking/Service Agreement between HW Generator, TSD Facility and HW Transporter *
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                Result of Laboratory Analysis
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Transport Management Plan *
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                Schedule of Hauling/Transport of wastes *
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                Route of Transport *
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                Last 2 previous Self Monitoring Report *
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