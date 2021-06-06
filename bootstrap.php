<?php
// Database config
define('DATABASE_HOST', 'sql310.epizy.com');
define('DATABASE_USER', 'epiz_28805234');
define('DATABASE_PASS', 'aXzKIvSbg3ClbQ');
define('DATABASE_NAME', "epiz_28805234_project2");

session_start();

$conn = new mysqli(
    DATABASE_HOST,
    DATABASE_USER,
    DATABASE_PASS,
    DATABASE_NAME
);

define('UPLOAD_PATH', 'uploads');
