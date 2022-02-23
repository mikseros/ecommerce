<?php
namespace App\Controllers;

use Controller;

class UsersController extends Controller{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    // Processing form data when form is submitted
    public function register() {
        require_once '../config/config.php';
        require_once "../config/verification.php";

        // Define variables and initialize with empty values
        $mail = $password = $confirm_password = "";
        $mail_err = $password_err = $confirm_password_err = "";

        // Validate mail
        if(empty(trim($_POST["mail"]))){
            $mail_err = "Please enter your e-mail.";
        } elseif(check_email($_POST["mail"]) !== $_POST["mail"]){
            $mail_err = "Please type in correct email address.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM users WHERE mail = :mail";
            
            if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":mail", $param_mail, PDO::PARAM_STR);
                
                // Set parameters
                $param_mail = trim($_POST["mail"]);
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $mail_err = "This email has been already taken.";
                    } else{
                        $mail = trim($_POST["mail"]);
                        alert("New User successfully created!");
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again.";
                }

                // Close statement
                unset($stmt);
            }
        }

        // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter correct password.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Password must have at least 6 characters.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }

        // Check input errors before inserting in database
        if(empty($mail_err) && empty($password_err) && empty($confirm_password_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO users (mail, password) VALUES (:mail, :password)";
            
            if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":mail", $param_mail, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                
                // Set parameters
                $param_mail = $mail;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Redirect to login page
                    header("location: login.php");
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }
        // Close connection
        unset($pdo);
    }

    public function login() {
        require_once '../config/config.php';
        
        // Define variables and initialize with empty values
        $mail = $password = "";
        $mail_err = $password_err = $login_err = "";

        // Processing form data when form is submitted
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if mail is empty
            if(empty(trim($_POST["mail"]))){
                $mail_err = "Please enter mail.";
            } else{
                $mail = trim($_POST["mail"]);
            }
            
            // Check if password is empty
            if(empty(trim($_POST["password"]))){
                $password_err = "Please enter your password.";
            } else{
                $password = trim($_POST["password"]);
            }

            // Validate credentials
            if(empty($mail_err) && empty($password_err)) {
                // Prepare a select statement
                $sql = "SELECT id, mail, password FROM users WHERE mail = :mail";

                if($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":mail", $param_mail, PDO::PARAM_STR);
                    
                    // Set parameters
                    $param_mail = trim($_POST["mail"]);

                    // Attempt to execute the prepared statement
                    if($stmt->execute()) {
                        if($stmt->rowCount() == 1) {
                            if($row = $stmt->fetch()){
                                $id = $row["id"];
                                $mail = $row["mail"];
                                $hashed_password = $row["password"];
                                if(password_verify($password, $hashed_password)){
                                    // Password is correct, so start a new session
                                    session_start();
                                    
                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["mail"] = $mail;                            
                                    
                                    // Redirect user to welcome page
                                    header("location: welcome.php");
                                } else{
                                    // Password is not valid, display a generic error message
                                    $login_err = "Invalid mail or password.";
                                }
                            }
                        } else{
                            // mail doesn't exist, display a generic error message
                            $login_err = "Invalid mail or password.";
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    // Close statement
                    unset($stmt);
                }
            }
            // Close connection
            unset($pdo);
        }
    }

    public function logout() {
        // Initialize the session
        session_start();
        
        // Unset all of the session variables
        $_SESSION = array();
        
        // Destroy the session.
        session_destroy();
        
        // Redirect to login page
        header("location: login.php");
        exit;
    }

    public function reset_password() {
        // Include config file
        require_once "config.php";

        require_once "verification.php";
        
        // Define variables and initialize with empty values
        $new_password = $confirm_password = "";
        $new_password_err = $confirm_password_err = "";

        // Processing form data when form is submitted
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate new password
            if(empty(trim($_POST["new_password"]))){
                $new_password_err = "Please enter the new password.";     
            } elseif(strlen(trim($_POST["new_password"])) < 8){
                $new_password_err = "Password must have atleast 8 characters.";
            } else{
                $new_password = trim($_POST["new_password"]);
            }

            // Validate confirm password
            if(empty(trim($_POST["confirm_password"]))){
                $confirm_password_err = "Please confirm the password.";
            } else{
                $confirm_password = trim($_POST["confirm_password"]);
                if(empty($new_password_err) && ($new_password != $confirm_password)){
                    $confirm_password_err = "Password did not match.";
                }
            }

            // Check input errors before updating the database
            if(empty($new_password_err) && empty($confirm_password_err)) {
                // Prepare an update statement
                $sql = "UPDATE users SET password = :password WHERE id = :id";

                if($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
                    
                    // Set parameters
                    $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $param_id = $_SESSION["id"];

                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Password updated successfully. Destroy the session, and redirect to login page
                        session_destroy();
                        header("location: login.php");
                        //return alert('Password updated successfully!');
                        exit();
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    unset($stmt);
                }
            }

            // Close connection
            unset($pdo);
        }
    }

    
        
}