<?php
/*do Update, if fail echo error, then go to index.php
 */
require ('UpdatePageMethods.php');
$method = new UpdatePagrMethods();
$result = $method->doUpdate();
ob_start();
if (!$result) {
    echo "user exist! please enter different user name";
}
$url = 'http://localhost:8081/UserInfoUpdate/app/index.php';
// clear out the output buffer
while (ob_get_status()) 
{
    ob_end_clean();
}

// no redirect
header( "Location: $url" );
exit();

