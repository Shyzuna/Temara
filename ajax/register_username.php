<?php
error_reporting(0);
session_start();

if (isset($_POST['username'])) {
  $_SESSION['username'] = $_POST['username'];
} else {
	unset($_SESSION['username']);
}
?>