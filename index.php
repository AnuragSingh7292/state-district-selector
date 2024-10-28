<?php
$conn = new mysqli('localhost','root','','registration_db');

//fetch the states for dropdown
$state_result = $conn->query("SELECT * FROM states");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $state_id = $_POST['state'];
    $district_id = $_POST['district'];

    // validate from fields
    if($first_name && $last_name && filter_var($email ,FILTER_VALIDATE_EMAIL) && $password && $password == $confirm_password)
    {
        // hash password 
        $hashed_password = password_hash($password , PASSWORD_DEFAULT);

        // INSERT USER DATABASE
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, state_id, district_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii",$first_name, $last_name, $email, $hashed_password, $state_id, $district_id);
        $stmt->execute();

       header("Location: display_users.php");
    }
    else
    {
        echo " Please fill all fields correctly. ";
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="registration.css">
    <script>
        // AJAX to fetch districts based on selected state
    function fetchDistricts(stateId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_districts.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("district").innerHTML = xhr.responseText;
            }
        };
        xhr.send("state_id=" + stateId);
    }

    </script>
</head>

<body>
    <div id="box">
    <form action="" method="post">
        <a href="https://vignan.ac.in" target="main"><img src="https://www.vignan.ac.in/images/LOGO_change.jpg"
                width="100%"> </a>
        <label for="FirstName">First Name:</label>
        <input type="text" id="FirstName" name="first_name" required>
        
        <label for="LastName">Last Name:</label>
        <input type="text" id="LastName" name="last_name" required>
        
        <label for="Email">Email:</label>
        <input type="email" id="Email"name="email" required>

        <label for="Password">Password:</label>
        <input type="password" id="Password" name="password" required>

        <label for="ConfirmPassword"> Confirm Password: </label>
        <input type="password" id="ConfirmPassword" name="confirm_password" required>

        <label for="State">State:</label><br>
            <select name="state" id="State" onchange="fetchDistricts(this.value)" required>
                <option value="">select state</option>
                <?php 
                    while($row = $state_result->fetch_assoc()) { ?>
                    <option value="<?= $row['state_id']?>"><?= $row['state_name'] ?></option>
                <?php } ?>
            </select><br>
       

        <label for="District">District:</label><br>
            <select name="district" id="district" required>
                <option value="">select District</option>
            </select> <br>
        <button type="submit">submit</button>
    </form>
</div>
</body>

</html>