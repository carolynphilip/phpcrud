<?php
 
// Define variables and initialize with empty values
$name = $email = $age = $designation = "";
$name_err = $email_err = $age_err = $designation_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
 
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email.";
    } else{
        $email = $input_email;
    }
 
    // Validate age
    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter the age.";
    } elseif(!ctype_digit($input_age)){
        $age_err = "Please enter a positive integer value.";
    } else{
        $age = $input_age;
    }
 
    // Validate designation
    $input_designation = trim($_POST["designation"]);
    if(empty($input_designation)){
        $designation_err = "Please enter a designation.";
    } elseif(!filter_var($input_designation, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $designation_err = "Please enter a valid designation.";
    } else{
        $designation = $input_designation;
    }
 
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($age_err) && empty($designation_err)) {
        include_once '../configs/database.php';
        include_once '../classes/employees.php';
 
        $database = new Database();
        $db = $database->getConnection();
 
        $item = new Employee($db);
 
        // employee values
        $item->name = $name;
        $item->email = $email;
        $item->age = $age;
        $item->designation = $designation;
        $item->created = date('Y-m-d H:i:s');
 
        if ($item->createEmployee()) {
            echo '<div class="alert alert-success">' . json_encode("Employee created successfully.") . '</div>';
            echo '<p><a href="../index.php" class="btn btn-primary">Back</a></p>';
        } else {
            echo json_encode("Employee could not be created");
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Create Record</h2>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                        <span class="invalid-feedback"><?php echo $name_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="text" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                        <span class="invalid-feedback"><?php echo $age_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Designation</label>
                        <input type="text" name="designation" class="form-control <?php echo (!empty($designation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $designation; ?>">
                        <span class="invalid-feedback"><?php echo $designation_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
