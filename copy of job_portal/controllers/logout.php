<?php
session_start();
session_destroy();
session_start();
$_SESSION['Flash'] = "Logged out successfully";
header("Location: /login");