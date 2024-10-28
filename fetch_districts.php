<?php
$conn = new mysqli('localhost', 'root', '', 'registration_db');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $state_id = $_POST['state_id'];

    // Validate state_id to avoid SQL injection
    $state_id = intval($state_id); 

    $district_result = $conn->query("SELECT * FROM districts WHERE state_id = $state_id");

    echo "<option value=''>Select District</option>";
    while ($row = $district_result->fetch_assoc()) {
        echo "<option value='{$row['district_id']}'>{$row['district_name']}</option>";
    }
}
?>
