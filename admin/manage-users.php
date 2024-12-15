<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Dhaka');
    $currentTime = date('d-m-Y h:i:s A', time());

    function sms_send($number) {
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "bk4zIF6t8Fr9XQJxqtrx";
        $senderid = "8809617619970";
        $otp = rand(100000, 999999);
        $message = "Your 'The Fashion Hub' OTP is: " . $otp;

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return ["status" => "error", "message" => "cURL Error: $error_msg", "otp" => $otp];
        } else {
            curl_close($ch);
            return ["status" => "success", "message" => $response, "otp" => $otp];
        }
    }

    unset($_SESSION['otp_sent']);

    if(isset($_POST['send'])) {
        if (!isset($_SESSION['otp_sent'])) {
            $id = $_POST['id'];
            $query = mysqli_query($con, "SELECT contactno FROM users WHERE id = '$id'");
            $row = mysqli_fetch_assoc($query);
            $number = $row['contactno'];

            $sms_result = sms_send($number);
            $sms_response = $sms_result['message'];
            $otp = $sms_result['otp'];

            $_SESSION['last_sent_otp'] = $otp;
            $_SESSION['last_sent_number'] = $number;
            $_SESSION['success_message'] = "OTP Sent! Number: $number, OTP: $otp, Response: $sms_response";

            $_SESSION['otp_sent'] = true;

            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }

    if(isset($_POST['remove'])) {
        $id = $_POST['id'];
        $query = mysqli_query($con, "DELETE FROM users WHERE id='$id'");
        if($query) {
            $_SESSION['delmsg'] = "User removed successfully.";
        } else {
            $_SESSION['delmsg'] = "Error removing user.";
        }

        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    $query = mysqli_query($con, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Users</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
</head>
<body>
<?php include('include/header.php'); ?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <?php include('include/sidebar.php'); ?>                
            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Manage Users</h3>
                        </div>
                        <div class="module-body table">
                            <?php
                            if(isset($_SESSION['success_message'])) {
                                echo "<div class='alert alert-success'>".$_SESSION['success_message']."</div>";
                                unset($_SESSION['success_message']);
                            }
                            if(isset($_SESSION['delmsg'])) {
                                echo "<div class='alert alert-danger'>".$_SESSION['delmsg']."</div>";
                                unset($_SESSION['delmsg']);
                            }
                            ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>Sent OTP</th>
                                        <th>Actions</th> <!-- Updated to "Actions" to accommodate both buttons -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $cnt=1;
                                    while($row = mysqli_fetch_array($query)) {
                                        // Ensure session variables are set
                                        $last_sent_number = isset($_SESSION['last_sent_number']) ? $_SESSION['last_sent_number'] : '';
                                        $last_sent_otp = isset($_SESSION['last_sent_otp']) ? $_SESSION['last_sent_otp'] : 'N/A';
                                        $last_sent_otp_display = ($last_sent_number === $row['contactno']) ? $last_sent_otp : 'N/A';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($row['name']); ?></td>
                                        <td><?php echo htmlentities($row['email']); ?></td>
                                        <td><?php echo htmlentities($row['contactno']); ?></td>
                                        <td><?php echo htmlentities($last_sent_otp_display); ?></td>
                                        <td>
                                            <!-- Send OTP Button -->
                                            <form method="post" action="" style="display:inline;">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="send" class="btn btn-danger" onclick="return confirm('Are you sure you want to send an OTP to this user?');">Send OTP</button>
                                            </form>

                                            <!-- Remove User Button -->
                                            <form method="post" action="" style="display:inline;">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="remove" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this user?');">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php 
                                    $cnt++;
                                    } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>

<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
