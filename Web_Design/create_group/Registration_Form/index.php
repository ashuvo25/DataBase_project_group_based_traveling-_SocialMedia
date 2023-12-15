<!DOCTYPE html>

<?php


include(__DIR__."/../../../Web_Design/DBconnection.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Debugging: Output the $_POST data
    //     echo '<pre>';
    //     print_r($_POST);
    //     echo '</pre>';


       // if (isset($_POST['submit'])) {
            // Check if the key is set before accessing it
    $form_1 = array(
        'Title' => isset($_POST["Group_title"]) ? $_POST["Group_title"] : "",
        'FromLocation' => isset($_POST["From"]) ? $_POST["From"] : "",
        'ToLocation' => isset($_POST["To"]) ? $_POST["To"] : "",
        'Start_date' => isset($_POST["Start_date"]) ? $_POST["Start_date"] : "",
        'End_date' => isset($_POST["End_date"]) ? $_POST["End_date"] : "",
        'Gender' => isset($_POST["Gender"]) ? $_POST["Gender"] : "",
        'Type_of_journey' => isset($_POST["Type_of_journey"]) ? $_POST["Type_of_journey"] : "",
        'Itinerary' => isset($_POST["Itinerary"]) ? $_POST["Itinerary"] : "",
        'Mobile_number' => isset($_POST["Mobile_number"]) ? $_POST["Mobile_number"] : "",
        'Privacie' => isset($_POST["Privacies"]) ? $_POST["Privacies"] : "",
        'Member' => isset($_POST["Member"]) ? $_POST["Member"] : "",
    );
   

  

    $_SESSION["form_1"] = $form_1;
    header("Location: index_2.php");
    exit();
}

$conn->close();
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <title> Regisration Form </title>
</head>

<body>
    <div class="container">
        <header><a href="/Web_Design/view_group/Group-page-design/index.php" style=' text-decoration: none; margin-right: 20px; '><img src="/Home_pages//image/icons/previous.png" alt="" width="25px" ></a>Create Group</header>

        <form method="post">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Group Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Group Title</label>
                            <input type="text" name="Group_title" placeholder="Group Title" required>
                        </div>

                        <div class="input-field">
                            <label>Start Date</label>
                            <input type="date" name="Start_date" placeholder="Departure time" required>
                        </div>

                        <div class="input-field">
                            <label>End Date</label>
                            <input type="date" name="End_date" placeholder="Date of return" required>
                        </div>
                        <div class="input-field">
                            <label>From</label>
                            <input type="text" name="From" placeholder="Zilla" required>
                        </div>

                        <div class="input-field">
                            <label>To</label>
                            <input type="text" name="To" placeholder="Destination" required>
                        </div>
                        <div class="input-field">
                            <label>Gender</label>
                            <select name="Gender" required>
                                <option disabled selected>Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Anyone</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="details ID">
                    <span class="title">More Details</span>

                    <div class="fields">


                        <div class="input-field">
                            <label>Type of journey</label>
                            <select name="Type_of_journey" aria-placeholder="Select" required>
                                <option disabled selected>Select</option>
                                <option>Road trip</option>
                                <option>Beach</option>
                                <option>Explore City</option>
                                <option>Forest</option>
                                <option>Mountain</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Itinerary</label>
                            <select name="Itinerary" aria-placeholder="Select" required>
                                <option disabled selected>Select</option>
                                <option>Flexible</option>
                                <option>Fixed</option>
                                <option>None</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" name="Mobile_number" placeholder="Enter mobile number">
                        </div>




                        <div class="input-field">
                            <label>Privacie</label>
                            <select name="Privacies" required>
                                <option disabled selected>Select privacies</option>
                                <option>Public</option>
                                <option>Private</option>
                                <option>None</option>
                            </select>
                        </div>


                        <div class="input-field">
                            <label>Member</label>
                            <input type="number" name="Member" placeholder="Group member" required>
                        </div>



                    </div>
                    <button class="nextBtn">
                        <span class="btnText">Next</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div>
            </div>


        </form>
    </div>


</body>

</html>