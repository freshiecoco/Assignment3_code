<?php
if(empty($_SESSION)) {
    echo "No session data found.";
} else {
    foreach($_SESSION as $key => $value) {
        print_r($key);
        echo "     :     ";
        print_r($value);
        echo "<br>";
    }
}
