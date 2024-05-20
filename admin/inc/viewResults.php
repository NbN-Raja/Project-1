<?php
include 'config.php';

$election_id = $_GET['viewResult'];

?>

<div class="row my-3">
    <div class="col-12">
        <h3> Election Results </h3>

        <?php
        $queryElections = "SELECT * FROM elections WHERE id = '" . $election_id . "'";
        $resultElections = mysqli_query($db, $queryElections) or die(mysqli_error($db));

        if (mysqli_num_rows($resultElections) > 0) {
            while ($election = mysqli_fetch_assoc($resultElections)) {
                $election_id = $election['id'];
                $election_name = $election['election_topic'];
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="5" class="bg-green text-white">
                        <h5> ELECTION TOPIC: <?php echo strtoupper($election_name); ?></h5>
                    </th>
                </tr>
                <tr>
                    <th> Photo </th>
                    <th> Registration_No </th>
                    <th> Candidate Details </th>
                    <th> No of Votes </th>
                    <th> Voters </th> <!-- New column added for voters -->
                </tr>
            </thead>
            <tbody>
                <?php
                        $query = "SELECT cd.*, COUNT(v.candidate_id) AS total_votes, GROUP_CONCAT(u.Name) AS voter_names
                        FROM candidate_details cd
                        LEFT JOIN votings v ON cd.id = v.candidate_id
                        LEFT JOIN users u ON v.voters_id = u.id
                        WHERE cd.election_topic = '" . $election_name . "'
                        GROUP BY cd.id";

                        $result = mysqli_query($db, $query) or die(mysqli_error($db));

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                <tr>
                    <td> <img src="<?php echo $row['candidate_photo']; ?>" class="candidate_photo"> </td>
                    <td><?php echo $row['Registration_No']; ?></td>
                    <td><?php echo "<b>" . $row['candidate_name'] . "</b><br />" . $row['candidate_details']; ?></td>
                    <td><?php echo $row['total_votes']; ?></td>
                    <td><?php echo isset($row['voter_names']) ? $row['voter_names'] : 'No voters yet'; ?></td>
                    <!-- Display voter name or 'No voters yet' if no votes -->
                </tr>
                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No candidates found</td></tr>";
                        }
                        ?>
            </tbody>
        </table>
        <?php
            }
        } else {
            echo "No active election found.";
        }
        ?>
    </div>
</div>