<?php
/**
* Template name: Form-validation
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package finbubs
*/

get_header();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <style>
        .error {
            color: red;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#registrationForm').validate({
                rules: {
                    username: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    number: {
                        required: true,
                        digits: true
                    },
                    age: {
                        required: true,
                        digits: true
                    },
                    date: {
                        required: true
                    },
                    Image: {
                        required: true,
                        accept: "png,jpg,jpeg"
                    },
                    'hobbies[]': {
                        required: true,
                        minlength: 1 // At least one checkbox must be checked
                    }
                },
                messages: {
                    username: "Please enter your name",
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    number: {
                        required: "Please enter your phone number",
                        digits: "Please enter only digits"
                    },
                    age: {
                        required: "Please enter your age",
                        digits: "Please enter only digits"
                    },
                    date: "Please enter your date of birth",
                    Image: {
                        required: "Please select an image",
                        accept: "Please select a valid image format (png, jpg, jpeg)"
                    },
                    'hobbies[]': {
                        required: "Please select at least one hobby",
                        minlength: "Please select at least one hobby"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "hobbies[]") {
                        error.insertAfter($(element).closest(".d-flex"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
</head>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    global $wpdb;

    $name = sanitize_text_field($_POST["username"]);
    $email = sanitize_email($_POST["email"]);
    $number = sanitize_text_field($_POST["number"]);
    $age = sanitize_text_field($_POST["age"]);
    $dob = sanitize_text_field($_POST["date"]);

    
    if (empty($name) || empty($email) || empty($number) || empty($age) || empty($dob)) {
        $response = array(
            'success' => false,
            'message' => 'Please fill out all fields.'
        );
    } elseif (!is_email($email)) {
        $response = array(
            'success' => false,
            'message' => 'Invalid email address.'
        );
    } else {
        $existing_email = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}contact_submission WHERE email = %s", $email));

        if ($existing_email > 0) {
            $response = array(
                'success' => false,
                'message' => 'Email address is already registered.'
            );
        } else {
       
            $table_name = $wpdb->prefix . 'contact_submission';
       
            $data = array(
                'username' => $name,
                'email' => $email,
                'number' => $number,
                'age' => $age,
                'dob' => $dob,
            );

            $insert_result = $wpdb->insert($table_name , $data);
            if ($insert_result === false) {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to store data in the database.'
                );
            } else {
                $response = array(
                    'success' => true,
                    'message' => 'Data stored in the database successfully.'
                );
            }
        }
    }
    echo json_encode($response);
    exit;
}
?>
<body>
    <div class="container mt-3">
        <h2 class="text-center">Registration Form</h2>
        <form id="registrationForm" action="#" method="post">
            <div class="mb-3 mt-3">
                <label for="name">Name*</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Your Name" name="username">
            </div>
            <div class="mb-3">
                <label for="email">Email*</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Your Email" name="email">
            </div>
            <div class="mb-3 mt-3">
                <label for="number">Phone Number*</label>
                <input type="number" class="form-control" id="number" placeholder="Enter Phone Number" name="number">
            </div>
            <div class="mb-3">
                <label for="age">Age*</label>
                <input type="number" class="form-control" id="age" placeholder="Enter Your Age" name="age">
            </div>
            <div class="mb-3 mt-3">
                <label for="date">DOB*</label>
                <input type="date" class="form-control" id="date" placeholder="Enter Your Date" name="date">
            </div>
            <!-- <div class="mb-3">
                <label for="Image">Image</label>
                <input type="file" class="form-control" id="Image" placeholder="Enter Your Image" name="uploadfile" accept="image/jpeg">
            </div>
            
            <div class="mb-3 mt-3 row">
                <label for="hobbies" class="col-sm-2 col-form-label">Hobbies:</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="checkbox" id="music" name="hobbies[]" value="Music" style="margin-right: 10px;">
                    <label for="music" class="mr-3">Music</label>
                    <input type="checkbox" id="games" name="hobbies[]" value="Games" style="margin-right: 10px;">
                    <label for="games" class="mr-3">Games</label>
                    <input type="checkbox" id="traveling" name="hobbies[]" value="Traveling" style="margin-right: 10px;">
                    <label for="traveling" class="mr-3">Traveling</label>
                </div>
            </div> -->
            <button type="submit" class="btn btn-primary text-center">Submit</button>
        </form>
    </div>
</body>
</html>
