<?php
include "config/db_conn.php";

// function to fetch data
if ($_GET["action"] === "fetchData") {
  $sql = "SELECT * FROM contdata";
  $result = mysqli_query($conn, $sql);
  $data = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
  mysqli_close($conn);
  header('Content-Type: application/json');
  echo json_encode([
    "data" => $data
  ]);
}



// insert data to database
if ($_GET["action"] === "insertData") {
  if (!empty($_POST["contract"]) && !empty($_POST["client"]) && !empty($_POST["contdate"]) && !empty($_POST["contenddate"]) && !empty($_POST["kamia"]) && !empty($_POST["qist"]) && !empty($_POST["conttotal"])  && !empty($_POST["wayofpay"])  && !empty($_POST["status"]) ) {
    $contract = mysqli_real_escape_string($conn, $_POST["contract"]);
    $client = mysqli_real_escape_string($conn, $_POST["client"]);
    $contdate = mysqli_real_escape_string($conn, $_POST["contdate"]);
    $contenddate = mysqli_real_escape_string($conn, $_POST["contenddate"]);
    $kamia = mysqli_real_escape_string($conn, $_POST["kamia"]);
    $qist = mysqli_real_escape_string($conn, $_POST["qist"]);
    $conttotal = mysqli_real_escape_string($conn, $_POST["conttotal"]);
    $wayofpay = mysqli_real_escape_string($conn, $_POST["wayofpay"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);


    $sql = "INSERT INTO `contdata`(`id`, `contract`, `client`, `contdate`, `contenddate`, `kamia`, `qist`, `conttotal`, `wayofpay`, `status`) VALUES (NULL,'$contract','$client','$contdate','$contenddate','$kamia','$qist','$conttotal','$wayofpay','$status')";
    

    if (mysqli_query($conn, $sql)) {
      echo json_encode([
        "statusCode" => 200,
        "message" => "Data inserted successfully 😀"
        
      ]);
    } else {
      echo json_encode([
        "statusCode" => 500,
        "message" => "Failed to insert data 😓"
      ]);
    }
  } else {
    echo json_encode([
      "statusCode" => 400,
      "message" => "Please fill all the required fields 🙏"
    ]);
  }
}



// fetch data of individual user for edit form
if ($_GET["action"] === "fetchSingle") {
  $id = $_POST["id"];
  $sql = "SELECT * FROM contdata WHERE `id`=$id";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    header("Content-Type: application/json");
    echo json_encode([
      "statusCode" => 200,
      "data" => $data
    ]);
  } else {
    echo json_encode([
      "statusCode" => 404,
      "message" => "No user found with this id 😓"
    ]);
  }
  mysqli_close($conn);
}



// function to update data
if ($_GET["action"] === "updateData") {
  
  if (!empty($_POST["contract"]) && !empty($_POST["client"]) && !empty($_POST["contdate"]) && !empty($_POST["contenddate"]) && !empty($_POST["kamia"]) && !empty($_POST["qist"]) && !empty($_POST["conttotal"]) && !empty($_POST["wayofpay"]) && !empty($_POST["status"]))
  {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $contract = mysqli_real_escape_string($conn, $_POST["contract"]);
    $client = mysqli_real_escape_string($conn, $_POST["client"]);
    $contdate = mysqli_real_escape_string($conn, $_POST["contdate"]);
    $contenddate = mysqli_real_escape_string($conn, $_POST["contenddate"]);
    $kamia = mysqli_real_escape_string($conn, $_POST["kamia"]);
    $qist = mysqli_real_escape_string($conn, $_POST["qist"]);
    $conttotal = mysqli_real_escape_string($conn, $_POST["conttotal"]);
    $wayofpay = mysqli_real_escape_string($conn, $_POST["wayofpay"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    $sql = "UPDATE `contdata` SET `contract`='$contract',`client`='$client',`contdate`='$contdate',`contenddate`='$contenddate',`kamia`='$kamia',`qist`='$qist',`conttotal`='$conttotal',`wayofpay`='$wayofpay',`status`='$status' WHERE `id`=$id";

    if (mysqli_query($conn, $sql)) {
      echo json_encode([
        "statusCode" => 200,
        "message" => "Data updated successfully 😀"
      ]);
    } else {
      echo json_encode([
        "statusCode" => 500,
        "message" => "Failed to update data 😓"
      ]);
    }
    mysqli_close($conn);
  } else {
    echo json_encode([
      "statusCode" => 400,
      "message" => "Please fill all the required fields 🙏"
    ]);
  }
}



// function to delete data
if ($_GET["action"] === "deleteData") {
  $id = $_POST["id"];
  
  $sql = "DELETE FROM contdata WHERE `id`=$id";

  if (mysqli_query($conn, $sql)) {
    // remove the image

    echo json_encode([
      "statusCode" => 200,
      "message" => "Data deleted successfully 😀"
    ]);
  } else {
    echo json_encode([
      "statusCode" => 500,
      "message" => "Failed to delete data 😓"
    ]);
  }
}
