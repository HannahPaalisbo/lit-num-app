<?php
header('Content-Type: application/json');

require 'connection.php';

try {
    $data = array();
    
    $tableName = "tbl_teacher";
    $query = "SELECT * FROM " . $tableName;
    $result = mysqli_query($db_con, $query);

    $teacherId = "";
    $firstName = "";
    $lastName = "";

    $item = array(
        "teacherId" => $teacherId,
        "firstName" => $firstName,
        "lastName" => $lastName
    );

    while($row = mysqli_fetch_assoc($result)) {
        $item["teacherId"] = $row['teacher_id'];
        $item["firstName"] = $row['teacher_first_name'];
        $item["lastName"] = $row['teacher_last_name'];
        $data[] = $item;
    }                     

    $jsonData = json_encode($data);
    echo $jsonData;
} catch (Exception $e) {
    $response = "$e";
    echo json_encode($response);
}
mysqli_close($db_con)
?>
