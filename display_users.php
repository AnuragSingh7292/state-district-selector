<?php
$conn = new mysqli('localhost','root','','registration_db');

// Fetch users with their state and district names

$query = "
    SELECT u.first_name, u.last_name, u.email, s.state_name, d.district_name
    FROM users u
    JOIN states s ON u.state_id = s.state_id
    JOIN districts d ON u.district_id = d.district_id ";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link rel="stylesheet" href="display_users.css">
</head>
<body>
    <div class="box">

        <table border="1">
            <caption><b>Registered Users</b></caption>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>State</th>
                    <th>District</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc())
                { ?>
                    <tr>
                        <td><?= $row['first_name'] ?></td>
                        <td><?= $row['last_name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['state_name'] ?></td>
                        <td><?= $row['district_name'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>                
    </div>
    
</body>
</html>