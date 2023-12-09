<!DOCTYPE html>

<?php

include(__DIR__."/../../../Web_Design/DBconnection.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Output the $_POST data
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // Extracting data
    //if (isset($_POST['submit'])) {
    // Extracting data from the first form


    // Extracting data from the second form
    $form_2 = array(
        'Boarding_1' => isset($_POST["Boarding_1"]) ? $_POST["Boarding_1"] : "",
        'Destination_1' => isset($_POST["Destination_1"]) ? $_POST["Destination_1"] : "",
        'Transport_1' => isset($_POST["Transport_1"]) ? $_POST["Transport_1"] : "",
        'Transport_2' => isset($_POST["Transport_2"]) ? $_POST["Transport_2"] : "",
        'Fare_1' => isset($_POST["Fare_1"]) ? $_POST["Fare_1"] : "",
        'Fare_2' => isset($_POST["Fare_2"]) ? $_POST["Fare_2"] : "",
        'Boarding_2' => isset($_POST["Boarding_2"]) ? $_POST["Boarding_2"] : "",
        'Destination_2' => isset($_POST["Destination_2"]) ? $_POST["Destination_2"] : "",
        'Hotel' => isset($_POST["Hotel"]) ? $_POST["Hotel"] : "",
        'Room_Type' => isset($_POST["Room_type"]) ? $_POST["Room_type"] : "",
        'Day' => isset($_POST["Day"]) ? $_POST["Day"] : "",
        'Rent' => isset($_POST["Rent"]) ? $_POST["Rent"] : "",
        'Food_Expenditure' => isset($_POST["Food_Expenditure"]) ? $_POST["Food_Expenditure"] : "",
        'Other_Cost_Description' => isset($_POST["Other_Cost_Description"]) ? $_POST["Other_Cost_Description"] : "",
        'Other_Cost' => isset($_POST["Other_Cost"]) ? $_POST["Other_Cost"] : "",
        'Meetup_Point' => isset($_POST["Meetup_Point"]) ? $_POST["Meetup_Point"] : "",
        'Time' => isset($_POST["Time"]) ? $_POST["Time"] : "",
        'About_Tour' => isset($_POST["About_Tour"]) ? $_POST["About_Tour"] : ""
    );

    // Combine data from both forms
    $form_1 = isset($_SESSION["form_1"]) ? $_SESSION["form_1"] : array();
  
    $combinedForm = array_merge($form_1, $form_2);
    // Home_pages\home.php
    insertGroup($combinedForm);
    header("Location:Home_page/home.php");
    $conn->close();
    // }


    // Access data using array keys
    // echo "Check In: " . $formData['checkIn'] . "<br>";
    // echo "Check Out: " . $formData['checkOut'] . "<br>";
    // echo "Transport: " . $formData['transport'] . "<br>";
    // ... (access other fields similarly)
}


?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style_2.css">


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Back button click event
            $(".backBtn").on("click", function() {
                // Navigate to the previous page
                window.location.href = 'index.php';
            });
        });
    </script>

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <title> Regisration Form </title>
</head>

<body>

    <div class="container">
        <header>Create Group</header>

        <form action="index_2.php" method="post">

            <div class="form second">
                <div class="details address">
                    <span class="title">Budget</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Boarding</label>
                            <input type="text" name="Boarding_1" placeholder="Station name">
                        </div>

                        <div class="input-field">
                            <label>Destination</label>
                            <input type="text" name="Destination_1" placeholder="Station name">
                        </div>

                        <div class="input-field">
                            <label>Transport</label>
                            <select name="Transport_1" requireed>
                                <option disabled selected>Select vehicle</option>
                                <option>Bus</option>
                                <option>Train</option>
                                <option>Launce</option>
                                <option>Flight</option>

                            </select>
                        </div>

                        <div class="input-field">
                            <label>Fare</label>
                            <input type="text" name="Fare_1" placeholder="Taka">
                        </div>

                        <div class="input-field">
                            <label>Boarding</label>
                            <input type="text" name="Boarding_2" placeholder="Station">
                        </div>

                        <div class="input-field">
                            <label>Destination</label>
                            <input type="text" name="Destination_2" placeholder="Station">
                        </div>

                        <div class="input-field">
                            <label>Transport</label>
                            <select name="Transport_2">
                                <option disabled selected>Select vehicle</option>
                                <option>Bus</option>
                                <option>Train</option>
                                <option>Ship</option>
                                <option>Flight</option>

                            </select>
                        </div>

                        <div class="input-field">
                            <label>Fare</label>
                            <input type="number" name="Fare_2" placeholder="Taka">
                        </div>
                        <div class="input-field">
                            <label>Hotel</label>
                            <input type="text" name="Hotel" placeholder="Name">
                        </div>


                        <div class="input-field">
                            <label>Room type</label>
                            <select name="Room_type">
                                <option disabled selected>Select Room type</option>
                                <option>Non_AC</option>
                                <option> AC</option>
                                <option>VIP</option>
                                <option>Luxurious</option>

                            </select>
                        </div>
                        <div class="input-field">
                            <label>Day</label>
                            <input type="number" name="Day" placeholder="How many day">
                        </div>


                        <div class="input-field">
                            <label>Rent</label>
                            <input type="number" name="Rent" placeholder="Rent per day">
                        </div>

                        <div class="input-field">
                            <label>Food Expenditure </label>
                            <input type="number" name="Food_Expenditure" placeholder="Avarage">
                        </div>


                        <div class="input-field">
                            <label> Other cost </label>
                            <input type="text" name="Other_Cost_Description" placeholder="Descrive">
                        </div>

                        <div class="input-field">
                            <label>Taka</label>
                            <input type="number" name="Other_Cost" placeholder="Other cost">
                        </div>



                    </div>
                </div>

                <div class="details family">
                    <span class="title">Extra</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Metup point</label>
                            <input type="text" name="Metup_point" placeholder="Location" required>
                        </div>

                        <div class="input-field">
                            <label>Time</label>
                            <input type="time" name="Time" placeholder="HH:MM" required>
                        </div>

                        <div class="input-field_large">
                            <label>About Tour</label>
                            <textarea name="About Tour" placeholder="It will show top of the group" rows="4" cols="50" required></textarea>
                        </div>


                    </div>

                    <div class="buttons">
                        <div class="backBtn">
                            <i class="uil uil-navigator"></i>
                            <span class="btnText">Back</span>
                        </div>

                        <button class="sumbit">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>

</html>