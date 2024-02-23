<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
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
?>
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
                <p><a href="../index.php" class="btn btn-primary">Back</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
