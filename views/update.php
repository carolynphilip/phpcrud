<?php
 
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $url = "http://localhost:8080/api/get.php/?id=";
    $url.=$_GET["id"];
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
 
    $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE); // this results 0 every time
    $response = curl_exec($ch);
 
    if ($response === false)
        $response = curl_error($ch);
 
    $obj = json_decode($response,true);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
 
// Define variables and initialize with empty values
$name = $email = $age = $designation = "";
$name_err = $email_err = $salary_err = $designation_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_GET["id"];
 
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
 
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the age.";
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $age = $input_salary;
    }
 
    // Validate designation
    $input_designation = trim($_POST["designation"]);
    if(empty($input_designation)){
        $designation_err = "Please enter a designation.";
    } else{
        $designation = $input_designation;
    }
 
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($salary_err) && empty($designation_err)){
 
        include_once '../configs/database.php';
        include_once '../classes/employees.php';
 
        $database = new Database();
        $db = $database->getConnection();
 
        $item = new Employee($db);
 
        $item->id = $id;
 
        // employee values
        $item->name = $name;
        $item->email = $email;
        $item->age = $age;
        $item->designation = $designation;
        $item->created = date('Y-m-d H:i:s');
 
        if($item->updateEmployee()){
            echo '<div class="alert alert-success">'.json_encode("Employee data updated.").'</div>';
            echo '<p><a href="../index.php" class="btn btn-primary">Back</a></p>';
        } else{
            echo json_encode("Data could not be updated");
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                <h2 class="mt-5 mb-3">View Record</h2>
                <div class="form-group">
                    <label>Name</label>
                    <p><b><?php echo $obj["name"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <p><b><?php echo $obj["email"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <p><b><?php echo $obj["age"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Designation</label>
                    <p><b><?php echo $obj["designation"]; ?></b></p>
                </div>
            </div>
        </div>
    </div>
</div>
 
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Update Record</h2>
                <p>Please edit the input values and submit to update the employee record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                        <span class="invalid-feedback"><?php echo $name_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                        <span class="invalid-feedback"><?php echo $salary_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Designation</label>
                        <input type="text" name="designation" class="form-control <?php echo (!empty($designation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $designation; ?>">
                        <span class="invalid-feedback"><?php echo $designation_err;?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
