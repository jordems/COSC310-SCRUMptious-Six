<?php
/*This Document is to establish the conneciton with the database*/
include_once 'psl-config.php';   // As functions.php is not included
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
