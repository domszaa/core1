<?php
session_start();

if (isset($_SESSION["user_id"])) {
    // Already logged in → go to checkin
    header("Location: checkin.php");
    exit();
} else {
    // Not logged in → redirect to login and remember destination
    $_SESSION["redirect_after_login"] = "checkin.php";
    header("Location: login.php");
    exit();
}
