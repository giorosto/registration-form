<!DOCTYPE html> 
<?php
    include 'connection.php';
    if (isset($_POST['signup_btn'])) {
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $c_password = mysqli_real_escape_string($conn,$_POST['c_password']);
    
    if (empty($username)) {
        $error = "username field is required!";
    }
    elseif (empty($email)) {
        $error = "email field is required!";
    }
    elseif (empty($password)) {
        $error = "password field is required!";
    }
    elseif ($password != $c_password) {
        $error = "passwords doesn't match!";
    }
    elseif (strlen($username) <3 || strlen($username) >15) {
        $error = "username must be between 3 to 15 characters!";
    }
    elseif (strlen($password) <6) {
        $error = "password must be more than 6 characters!";
    }
    else {
        $check_email = "SELECT * FROM user_registration WHERE email='$email'";
        $result = $conn->query($check_email);
        if($result->num_rows>0) {
            $error = "email already exists";
        }
        else {
            $pass = sha1($password);
            $insert = "INSERT INTO user_registration (username,email,password) Values ('$username','$email','$pass')";
            if ($conn->query($insert) === TRUE) {
                $success = "New record created successfully";
              } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
              }
        }
    }
}
?>

<html>
    <head>
        <title>
            user registration
        </title>
        <link rel="stylesheet" href="css/signup.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="signup">
            <form action="" method="post">
                <p style="color:red">
                    <?php
                        if(isset($error)){
                            echo $error;
                        }
                    ?>
                </p>
                <p>
                <p style="color:green">
                    <?php
                        if(isset($success)){
                            echo $success;
                        }
                    ?>  
                </p>
                <h3>Create account</h3>
                    <input type="text" name="username" placeholder="username" value="<?php if(isset($error)) {echo $username;} ?>">
                    <input type="email" name="email" placeholder="email">
                    <input type="password" name="password" placeholder="password">
                    <input type="password" name="c_password" placeholder="re enter password">
                    <input type="submit" name="signup_btn" value="signup">
                </form>
        </div>
    </body>
</html>