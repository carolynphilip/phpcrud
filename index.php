<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
  
        table tr td:last-child{
            width: 240px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-100">
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Employees Details</h2>
                    <a href="views/create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Employee</a>
                </div>
                <?php
 
                $url = "http://localhost:8080/api/getall.php";
 
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
 
                $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE); // this results 0 every time
                $response = curl_exec($ch);
 
                if ($response === false)
                    $response = curl_error($ch);
 
                $obj = json_decode($response);
 
                      if($obj->body > 0){
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Name</th>";
                        echo "<th>Email</th>";
                        echo "<th>Age</th>";
                        echo "<th>Designation</th>";
                        echo "<th>Created</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        //while($row = mysqli_fetch_array($result)){
                          for ($x = 0; $x < $obj->itemCount; $x++) {
                            echo "<tr>";
                            echo "<td>" . $obj->body[$x]->id . "</td>";
                            echo "<td>" . $obj->body[$x]->name . "</td>";
                            echo "<td>" . $obj->body[$x]->email . "</td>";
                            echo "<td>" . $obj->body[$x]->age . "</td>";
                            echo "<td>" . $obj->body[$x]->designation . "</td>";
                            echo "<td>" . $obj->body[$x]->created . "</td>";
                            echo "<td>";
                            echo '<a href="views/get.php?id='. $obj->body[$x]->id .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                            echo '<a href="views/update.php?id='. $obj->body[$x]->id .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo '<a href="views/delete.php?id='. $obj->body[$x]->id .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else{
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
