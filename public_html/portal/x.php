<?php
$str = "\x8F!!!";

// Outputs an empty string
echo $str;
echo "\n";
echo htmlentities($str, ENT_QUOTES, "UTF-8");
echo "\n";
// Outputs "!!!"
echo htmlentities($str, ENT_QUOTES | ENT_IGNORE, "UTF-8");
echo "\n";
echo htmlspecialchars('حسن', ENT_HTML5, "UTF-8");
?>