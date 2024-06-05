<?php 
include("../../../conn.php");

$res = array(); // Initialize response array

extract($_POST);

// Validate gender, course, and year level
if($gender == "0") {
    $res = array("res" => "noGender");
} elseif($course == "0") {
    $res = array("res" => "noCourse");
} elseif($year_level == "0") {
    $res = array("res" => "noLevel");
}

// Validate email format
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $res = array("res" => "invalidEmailFormat");
}

// Check if the fullname already exists
$selExamineeFullname = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_fullname='$fullname' ");
if($selExamineeFullname->rowCount() > 0) {
    $res = array("res" => "fullnameExist", "msg" => $fullname);
}

// Check if the email already exists
$selExamineeEmail = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_email='$email' ");
if($selExamineeEmail->rowCount() > 0) {
    $res = array("res" => "emailExist", "msg" => $email);
}

// If any validation fails, return the error messages
if (!empty($res)) {
    echo json_encode($res);
    exit; // Stop execution if validation fails
}

// If all validations pass, proceed with data insertion
$insData = $conn->query("INSERT INTO examinee_tbl(exmne_fullname,exmne_course,exmne_gender,exmne_birthdate,exmne_year_level,exmne_email,exmne_password) VALUES('$fullname','$course','$gender','$bdate','$year_level','$email','$password')  ");
if($insData) {
    $res = array("res" => "success", "msg" => $email);
} else {
    $res = array("res" => "failed");
}

echo json_encode($res);
?>
