<?php

$conn = mysqli_connect("localhost", "root", "", "epayschool");
$requestPayload = file_get_contents('php://input');

