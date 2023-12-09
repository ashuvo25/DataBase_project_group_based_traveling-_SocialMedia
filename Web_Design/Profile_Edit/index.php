<!DOCTYPE html>


<!DOCTYPE html>

<?php

include(__DIR__ . "/../DBconnection.php");

if (!isset($_SESSION['username'])) {
    header('location: Home_index.php');
    exit();
}
$username = $_SESSION['username'];

$user = $username;

$userInfo = select_profile_edit($username);

if ($userInfo) {
    $Name = $userInfo["name"];
    $passwords = $userInfo["passwords"];
    $Email = $userInfo["email"];
    $Age = $userInfo["age"];
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


$userInfo = select_profile_edit($username);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $postData = array(
        'name' => isset($_POST['name']) && $_POST['name'] !== '' ? test_input($_POST['name']) : $Name,
        'email' => isset($_POST['email']) ? test_input($_POST['email']) : $Email,
        'company' => isset($_POST['company']) ? test_input($_POST['company']) : $Company,
        'number' => isset($_POST['phone']) ? test_input($_POST['phone']) : $Number,
        'website' => isset($_POST['website']) ? test_input($_POST['website']) : $Website,
        'currentPassword' => isset($_POST['current_password']) ? test_input($_POST['current_password']) : null,
        'newPassword' => isset($_POST['new_password']) ? test_input($_POST['new_password']) : null,
        'repeatNewPassword' => isset($_POST['repeat_new_password']) ? test_input($_POST['repeat_new_password']) : null,
        // 'prof_text' =>  isset($updt) ? $updt : null,// Update this line to include the full URL
    );

    // Check and update password if necessary
    if (!empty($postData['currentPassword']) && !empty($postData['newPassword']) && !empty($postData['repeatNewPassword'])) {
        if ($postData['currentPassword'] == $passwords) {
            if ($postData['newPassword'] == $postData['repeatNewPassword']) {
                if (preg_match('/[0-9]/', $postData['newPassword']) && preg_match('/[a-zA-Z]/', $postData['newPassword'])) {
                    updatePassword($user, $postData['newPassword']);
                    echo "Password updated successfully";
                } else {
                    echo "Password must contain at least one number and one letter";
                }
            } else {
                echo "New password and repeat password do not match";
            }
        } else {
            echo "Invalid old password";
        }
    } else {
        // Update profile if password fields are empty
        updateProfile($username, $postData);
    }


    // Close the database connection
    $conn->close();
}
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social-links">Social links</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-connections">Connections</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-notifications">Notifications</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <form method="post">
                        <div class="tab-content">

                            <!--   --------------------------- general account start ------------------------------------->



                            <div class="tab-pane fade active show" id="account-general">
                               
                                <hr class="border-light m-0">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo $Name ?>">

                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="email">E-mail</label>
                                        <input type="text" class="form-control mb-1" id="email" name="email" placeholder="<?php echo $Email === null ? 'Enter your email' : $Email; ?>">
                                        <div class="alert alert-warning mt-3">
                                            Your email is not confirmed. Please check your inbox.<br>
                                            <a href="javascript:void(0)">Resend confirmation</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="company">Company</label>
                                        <input type="text" class="form-control" id="company" name="company" placeholder="Company">

                                    </div>
                                </div>



                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Contacts</h6>
                                    <div class="form-group">
                                        <label class="form-label" for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="website">Website</label>
                                        <input type="text" class="form-control" id="website" name="website" placeholder="Website">
                                    </div>
                                </div>

                            </div>






                            <!--   --------------------------- general account end ------------------------------------->

                            <div class="tab-pane fade" id="account-change-password">

                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label for="current-password" class="form-label">Current password</label>
                                        <input type="password" class="form-control" id="current-password" name="current_password" placeholder="Inpu Current password">
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password" class="form-label">New password</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="At least one character and one number">
                                    </div>
                                    <div class="form-group">
                                        <label for="Repeat_new_password" class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control" id="Repeat_new_password" name="repeat_new_password" placeholder="Repeat password">
                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane fade" id="account-info">

                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label" for="bio">Bio</label>
                                        <textarea class="form-control" id="bio" rows="5" placeholder="Enter your bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nunc arcu, dignissim sit amet sollicitudin iaculis, vehicula id urna. Sed luctus urna nunc. Donec fermentum, magna sit amet rutrum pretium, turpis dolor molestie diam, ut lacinia diam risus eleifend sapien. Curabitur ac nibh nulla. Maecenas nec augue placerat, viverra tellus non, pulvinar risus.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="birthday">Birthday</label>
                                        <input type="text" class="form-control" id="birthday" placeholder="Enter your birthday" value="May 3, 1995">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="country">Country</label>
                                        <select class="custom-select" id="country">
                                            <option>USA</option>
                                            <option selected>Canada</option>
                                            <option>UK</option>
                                            <option>Germany</option>
                                            <option>France</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-social-links">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label" for="twitter">Twitter</label>
                                        <input type="text" class="form-control" id="twitter" placeholder="Enter your Twitter profile URL" value="https://twitter.com/user">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="facebook">Facebook</label>
                                        <input type="text" class="form-control" id="facebook" placeholder="Enter your Facebook profile URL" value="https://www.facebook.com/user">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="googleplus">Google+</label>
                                        <input type="text" class="form-control" id="googleplus" placeholder="Enter your Google+ profile URL" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="linkedin">LinkedIn</label>
                                        <input type="text" class="form-control" id="linkedin" placeholder="Enter your LinkedIn profile URL" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="instagram">Instagram</label>
                                        <input type="text" class="form-control" id="instagram" placeholder="Enter your Instagram profile URL" value="https://www.instagram.com/user">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="account-connections">
                                <div class="card-body">
                                    <button type="button" class="btn btn-twitter">Connect to
                                        <strong>Twitter</strong></button>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <h5 class="mb-2">
                                        <a href="javascript:void(0)" class="float-right text-muted text-tiny"><i class="ion ion-md-close"></i> Remove</a>
                                        <i class="ion ion-logo-google text-google"></i>
                                        You are connected to Google:
                                    </h5>
                                    <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <button type="button" class="btn btn-facebook">Connect to
                                        <strong>Facebook</strong></button>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <button type="button" class="btn btn-instagram">Connect to
                                        <strong>Instagram</strong></button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-notifications">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Activity</h6>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone comments on my
                                                article</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone answers on my forum
                                                thread</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input">
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone follows me</span>
                                        </label>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Application</h6>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">News and announcements</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input">
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Weekly product updates</span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Weekly blog digest</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-3">

                                <input type="submit" name="submit" class="btn btn-primary" value="Save changes" required>&nbsp;
                                <input type="submit" name="submit" class="btn btn-default" value="Cancel" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>