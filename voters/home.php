<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<?php
session_start(); // Ensure session is started
require_once("inc/header.php");
require_once("inc/navigation.php");

// Ensure user is logged in or redirect
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

?>
<?php
require_once("inc/header.php");
require_once("inc/navigation.php");

?>

<div class="row my-3">
    <div class="col-12">
        <?php

        $queryElections = "SELECT * FROM elections WHERE status = 'active'";
        $resultElections = mysqli_query($db, $queryElections) or die(mysqli_error($db));

        if (mysqli_num_rows($resultElections) > 0) {
            while ($election = mysqli_fetch_assoc($resultElections)) {

                $election_id = $election['id'];
                $election_name = $election['election_topic'];
            }  ?>
        <h3> Voters Panel </h3>


        <table class="table">
            <thead>
                <tr>
                    <th colspan="4" class="bg-green text-white">
                        <h5> ELECTION TOPIC: <?php echo strtoupper($election_name); ?></h5>
                    </th>
                </tr>
                <tr>
                    <th> Photo </th>
                    <th> Registration_No </th>
                    <th> Candidate Details </th>
                    <th> No of Votes </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>

                <?php

                    $query = ("SELECT * FROM candidate_details WHERE election_topic= '" . $election_name . "'");
                    $result = mysqli_query($db, $query) or die(mysqli_error($db));
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            $candidate_id = $row['id'];
                            $candidate_photo = $row['candidate_photo'];
                            $Registration_No = $row['Registration_No'];

                            // Fetching Candidate Votes 
                            $fetchingVotes = mysqli_query($db, "SELECT * FROM votings WHERE candidate_id = '" . $candidate_id . "'") or die(mysqli_error($db));
                            $totalVotes = mysqli_num_rows($fetchingVotes);
                    ?>
                <tr>
                    <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo"> </td>

                    <td><?php echo $Registration_No ?></td>
                    <td><?php echo "<b>" . $row['candidate_name'] . "</b><br />" . $row['candidate_details']; ?></td>
                    <td><?php echo $totalVotes; ?></td>
                    <td>
                        <?php
                                    $checkIfVoteCasted = mysqli_query($db, "SELECT * FROM votings WHERE voters_id = '" . $_SESSION['user_id'] . "' AND election_id = '" . $election_id . "'") or die(mysqli_error($db));
                                    $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                                    if ($isVoteCasted > 0) {
                                        $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                                        $voteCastedToCandidate = $voteCastedData['candidate_id'];

                                        if ($voteCastedToCandidate == $candidate_id) {
                                    ?>

                        <img src="../assets/images/vote.png" width="100px;">
                        <?php
                                        }
                                    } else {
                                        ?>
                        <button class="btn btn-md btn-success"
                            onclick="CastVote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['user_id']; ?>)">
                            Vote </button>
                        <?php
                                    }


                                    ?>


                    </td>
                </tr>
                <?php
                        }
                        ?>
            </tbody>

        </table>
        <?php

                    }
                } else {
                    echo "No any active election.";
                }
    ?>


    </div>
</div>


<script>
const CastVote = (election_id, customer_id, voters_id) => {
    $.ajax({
        type: "POST",
        url: "inc/ajaxCalls.php",
        data: "e_id=" + election_id + "&c_id=" + customer_id + "&v_id=" + voters_id,
        success: function(response) {

            if (response == "Success") {
                location.assign("home.php?voteCasted=1");
            } else {
                location.assign("home.php?voteNotCasted=1");
            }
        }
    });
}
</script>



<?php
require_once("inc/footer.php");

?>