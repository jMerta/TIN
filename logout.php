<?php

include 'connect.php';
include 'header.php';

session_start();
session_destroy();
echo "<h3>Zostałeś wylogowany</h3>";