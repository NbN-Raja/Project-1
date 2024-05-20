<div class="row my-3">
    <div class="col-4 shadow-sm p-4">
        <h4>Add New Election</h4>
        <?php
        // Validate form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate Election Topic
            if (empty($_POST["election_topic"])) {
                $election_topic_err = "Election topic is required";
            } else {
                $election_topic = test_input($_POST["election_topic"]);
            }

            // Validate Number of Candidates
            if (empty($_POST["number_of_candidates"])) {
                $number_of_candidates_err = "Number of candidates is required";
            } else {
                $number_of_candidates = test_input($_POST["number_of_candidates"]);
            }

            // Validate Starting Date
            if (empty($_POST["starting_date"])) {
                $starting_date_err = "Starting date is required";
            }

            // Validate Ending Date
            if (empty($_POST["ending_date"])) {
                $ending_date_err = "Ending date is required";
            }
        }

        // Function to sanitize input data
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>

        <form method="POST">
            <div>
                <label for="election_topic">Election Topic</label>
                <input type="text" name="election_topic" id="election_topic" placeholder="Election Topic"
                    class="form-control" />
                <span class="text-danger"><?php echo isset($election_topic_err) ? $election_topic_err : ''; ?></span>
            </div>
            <div>
                <label for="number_of_candidates">Number of Candidates</label>
                <input type="number" name="number_of_candidates" id="number_of_candidates"
                    placeholder="No of Candidates" class="form-control" />
                <span
                    class="text-danger"><?php echo isset($number_of_candidates_err) ? $number_of_candidates_err : ''; ?></span>
            </div>
            <div>
                <label for="starting_date">Starting Date</label>
                <input type="date" name="starting_date" id="starting_date" class="form-control" />
                <span class="text-danger"><?php echo isset($starting_date_err) ? $starting_date_err : ''; ?></span>
            </div>
            <div>
                <label for="ending_date">Ending Date</label>
                <input type="date" name="ending_date" id="ending_date" class="form-control" />
                <span class="text-danger"><?php echo isset($ending_date_err) ? $ending_date_err : ''; ?></span>
            </div>
            <input type="submit" value="Add Election" name="addElectionBtn" class="btn btn-success" /><br>
        </form>

    </div>


    <?php
    include 'config.php';

    if (isset($_POST['addElectionBtn'])) {
        $election_topic = $_POST['election_topic'];
        $number_of_candidates = $_POST['number_of_candidates'];
        $starting_date = $_POST['starting_date'];
        $ending_date = $_POST['ending_date'];
        $inserted_on = date("Y-m-d");

        // Create date objects
        $date1 = date_create($inserted_on);
        $date2 = date_create($starting_date);
        $date3 = date_create($ending_date);

        // Calculate difference
        $diff = date_diff($date1, $date2);

        // Check if the starting date is in the past
        if ($starting_date < $inserted_on) {
            echo "Error: Past date can't be selected/added.";
            exit;
        }

        // Determine status
        if ($inserted_on < $starting_date) {
            $status = "Coming";
        } elseif ($inserted_on >= $starting_date && $inserted_on <= $ending_date) {
            $status = "Active";
        } else {
            $status = "Expired";
        }



        mysqli_query($db, "INSERT INTO elections(election_topic, no_of_candidates, starting_date, ending_date, status,  inserted_on) VALUES('" . $election_topic . "', '" . $number_of_candidates . "', '" . $starting_date . "', '" . $ending_date . "', '" . $status . "', '" . $inserted_on . "')") or die(mysqli_error($db));
    } ?>

    <div class="col-8">
        <h3>Upcoming Elections</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Election Name</th>
                    <th scope="col"># Candidates</th>
                    <th scope="col">Starting Date</th>
                    <th scope="col">Ending Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include 'config.php';
                $query = "SELECT * FROM elections";
                $result = mysqli_query($db, $query);
                if (mysqli_num_rows($result) > 0) {
                    $sno = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo  "<tr>";
                        echo "<td>" . $sno++ . "</td>";
                        echo "<td>" . $row['election_topic'] . "</td>";
                        echo "<td>" . $row['no_of_candidates'] . "</td>";
                        echo "<td>" . $row['starting_date'] . "</td>";
                        echo "<td>" . $row['ending_date'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        // Add your action buttons or links here
                        echo "<td><a href='/project/admin/inc/edit_elections.php?id=" . $row['id'] . "'>Edit</a> | ";
                        echo "<a href='/project/admin/inc/delete_elections.php?id=" . $row['id'] . "' onclick='return confirmDelete()'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No upcoming elections found.</td></tr>";
                }
                ?>

                <style>
                label {
                    font-weight: 500;
                }
                </style>

                <script>
                // Get current date
                var today = new Date().toISOString().split('T')[0];
                // Set minimum date for starting_date input
                document.getElementById('starting_date').min = today;
                // Set minimum date for ending_date input
                document.getElementById('ending_date').min = today;

                function confirmDelete() {
                    return confirm('Are you sure you want to delete?');
                }
                </script>