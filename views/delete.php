<?php

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    //View Logic
    $id = $_GET["id"];
    $urlView = "http://localhost:8080/api/get.php/?id=";
    $urlView.=$_GET["id"];
    //echo $url;

    $chView = curl_init();
    curl_setopt($chView, CURLOPT_URL, $urlView);
    curl_setopt($chView, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chView, CURLOPT_HEADER, false);
    curl_setopt($chView, CURLOPT_FOLLOWLOCATION, false);

    $httpCodeView = curl_getinfo($chView , CURLINFO_HTTP_CODE); // this results 0 every time
    $responseView = curl_exec($chView);

    if ($responseView === false)
        $responseView = curl_error($chView);

    $objView = json_decode($responseView,true);
}
else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}


// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])) {
// Check existence of id parameter before processing further
    // Get hidden input value
    $url = "http://localhost:8080/api/deleteUI.php/?id=";
    $url .= $_POST["id"];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // this results 0 every time
    $response = curl_exec($ch);

    if ($response === false) {
        $response = curl_error($ch);
    }
    else{
        echo '<div class="alert alert-success">'.json_encode("Employee deleted successfully.").'</div>';
        echo '<p><a href="../index.php" class="btn btn-primary">Back</a></p>';
    }

    $obj = json_decode($response, true);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
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
                    <p><b><?php echo $objView["name"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <p><b><?php echo $objView["email"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <p><b><?php echo $objView["age"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Designation</label>
                    <p><b><?php echo $objView["designation"]; ?></b></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5 mb-3">Delete Record</h2>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="alert alert-danger">
                        <p>Are you sure you want to delete this employee record?</p>
                        <p>
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <input type="submit" class="btn btn-danger" value="Yes">
                            <a href="../index.php" class="btn btn-secondary ml-2">No</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
