<?php
error_reporting(0);

if (isset($_GET['added'])) {
?>
<div class="alert alert-success my-3" role="alert">
    Candidate has been added successfully.
</div>
<?php
} else if (isset($_GET['largeFile'])) {
?>
<div class="alert alert-danger my-3" role="alert">
    Candidate image is too large, please upload small file (you can upload any image upto 2mbs.).
</div>
<?php
} else if (isset($_GET['invalidFile'])) {
?>
<div class="alert alert-danger my-3" role="alert">
    Invalid image type (Only .jpg, .png files are allowed) .
</div>
<?php
} else if (isset($_GET['failed'])) {
?>
<div class="alert alert-danger my-3" role="alert">
    Image uploading failed, please try again.
</div>
<?php
}

?>

<div class="row my-3">
    <div class="col-4 col-4 shadow-sm p-4">
        <h4>Add New Candidates</h4>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <select class="form-control" name="election_topic" required>
                    <option value="">Select Election</option>
                    <?php
                    include 'config.php';

                    $queryElections = "SELECT * FROM elections WHERE status = 'active'";
                    $resultElections = mysqli_query($db, $queryElections) or die(mysqli_error($db));

                    if (mysqli_num_rows($resultElections) > 0) {
                        while ($election = mysqli_fetch_assoc($resultElections)) {

                            $election_topic = $election['election_topic'];
                            $election_name = $election['election_topic'];


                    ?>
                    <option value="<?php echo ($election_topic); ?>"><?php echo ($election_name); ?></option>
                    <?php
                        }
                    } else
                    ?>
                    <option value="">Please add an election first</option>
                </select>

            </div>

            <div class="form-group">
                <label for=""> Candidate Name </label>
                <input type="text" name="candidate_name" placeholder="Candidate Name" class="form-control" required />
            </div>
            <div class="form-group">
                <label for=""> Registration Number</label>
                <input type="text" name="Registration_No" placeholder="Registration_No" class="form-control" required />
            </div>
            <div class="form-group">
                <label for=""> Candidate Photo</label>
                <input type="file" name="candidate_photo" class="form-control" required />
            </div>
            <div class="form-group">
                <label for=""> Candidate Details</label>
                <input type="text" name="candidate_details" placeholder="Candidate Details" class="form-control"
                    required />
            </div>
            <input type="submit" value="Add Candidate" name="addCandidateBtn" class="btn btn-success" />
        </form>
    </div>
    <?php
$db = mysqli_connect("localhost", "root", "", "project") or die("Connectivity Failed");




if (isset($_POST['addCandidateBtn'])) {


    $candidate_name = $_POST['candidate_name'];
    $Registration_No = $_POST['Registration_No'];
    $candidate_details = $_POST['candidate_details'];
    $election_topic = $_POST['election_topic'];
    $inserted_on = date("Y-m-d");
    $traggetted_folder = "../assets/images/candidate_photos/";
    $candidate_photo = $traggetted_folder . $_FILES['candidate_photo']['name'];
    $candidate_photo_tmp_name = $_FILES['candidate_photo']['name'];
    $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
    $allowed_types = array("jpg", "png", "jpeg",);
    $image_size = $_FILES['candidate_photo']['size'];


    $query = "SELECT * FROM candidate_details";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0) {
        $sno = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // $alreadyp="notpresent";
            //  echo $row['Registration_No'];
            if ($_POST['Registration_No'] == $row['Registration_No']) {
                // echo $row['Registration_No'];
                $alreadyp = "present";
                // echo $alreadyp;
            }
        }
        if ($alreadyp == "present") {
            echo "";
        } else {
            $result = mysqli_query($db, "INSERT INTO candidate_details(candidate_name, Registration_No, candidate_photo, candidate_details,election_topic) VALUES('" . $candidate_name . "','" . $Registration_No . "','" . $candidate_photo . "', '" . $candidate_details . "','" . $election_topic . "')") or die(mysqli_error($db));


            // if($result>0)
            // {
            //    header('Location: /project/admin/adminhome.php?addCandidatePage=1'); 

            // }

        }
    }
}

    ?>


    <div class="col-8">
        <h3>Candidate Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Registration_No</th>
                    <th scope="col">Details</th>
                    <th scope="col">Election</th>
                    <th scope="col">Action </th>

                </tr>
            </thead>
            <tbody>

                <?php

                $query = "SELECT * FROM candidate_details";
                $result = mysqli_query($db, $query);
                if (mysqli_num_rows($result) > 0) {
                    $sno = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $election_name = $row['election_topic'];
                        $candidate_photo = $row['candidate_photo'];


                        echo "<tr>";
                        echo "<td>" . $sno++ . "</td>";

                        echo "<td><img src='" . $candidate_photo . "'class=candidate_photo></td>";

                        echo "<td>" . $row['candidate_name'] . "</td>";

                        echo "<td>" . $row['Registration_No'] . "</td>";

                        echo "<td>" . $row['candidate_details'] . "</td>";

                        echo "<td>" . $row['election_topic'] . "</td>";



                        echo "<td><a href='/project/admin/inc/edit_candidate.php?id=" . $row['id'] . "'>Edit</a> | <a name ='delcandidatebtn' href='/project/admin/inc/delete_candidate.php?id=" . $row['id'] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                }
                ?>

                <style>
                label {
                    font-weight: 500;
                }
                </style>