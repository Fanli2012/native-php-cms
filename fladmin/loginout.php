<?php
require '../common/config.php';

session_start();
session_unset();
session_destroy();

redirect("/");
?>