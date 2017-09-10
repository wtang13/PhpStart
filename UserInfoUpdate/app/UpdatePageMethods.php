<?php

class UpdatePagrMethods{

    /** other variables */
    protected $userNameIsUnique = true;			
    protected $userIsEmpty = false;					
    protected $passwordIsEmpty = false;	
    
    /*init user data with filter, then update in DB
     * return true if input is a new user and finish insert insert else return false
     *      */
    function doUpdate() 
    {
        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(-1);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $gender = trim($_POST['gender']);
            $age = trim($_POST['age']);
            $occupation = trim($_POST['occupation']);
            if (!empty($name) && !empty($gender) && !empty($age) 
                    && !empty($occupation)) { 
                /** Create database connection */

                $con = mysqli_connect("localhost", "root", "root");
                if (!$con) {
                    exit('Connect Error (' . mysqli_connect_errno() . ') '
                            . mysqli_connect_error());
                }
            //set the default client character set 
                mysqli_set_charset($con, 'utf-8');
            /** Check whether a user whose name matches the "user" field already exists */

                mysqli_select_db($con, "userInfo");
                $user = mysqli_real_escape_string($con, $_POST["name"]);
                $isUser = mysqli_query($con, 
                        "SELECT id FROM users WHERE name='".$user."'");
                $userIDnum=mysqli_num_rows($isUser);
                if ($userIDnum) {
                    $userNameIsUnique = false;
                    return false;
                }
                $gender = mysqli_real_escape_string($con, $_POST['gender']);
                $age = mysqli_real_escape_string($con, $_POST['age']);
                $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
                mysqli_select_db($con, "userInfo");
                mysqli_query($con, "INSERT users (name, age,gender,occupation) "
                        . "VALUES ('" . $name . "', '" . $age . "', '" 
                        . $gender ."', '" . $occupation ."')");
                mysqli_free_result($isUser);
                mysqli_close($con);
                return true;
            } else {
                return false;
                
            }
        } 
    }
        /*Print to PDF*/
    function printToPDF() 
    {
        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(-1);
        require('../TCPDF-master/tcpdf.php');
        // Instanciation of inherited class
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // based on POST name, get data from db
            $name = trim($_GET['name']);
            $con = mysqli_connect("localhost", "root", "root");
            if (!$con) {
                exit('Connect Error (' . mysqli_connect_errno() . ') '
                        . mysqli_connect_error());
            }
        //set the default client character set 
            mysqli_set_charset($con, 'utf-8');
        /** Check whether a user whose name matches the "user" field already exists */

            mysqli_select_db($con, "userInfo");
            $getinfo = "select name, age, gender, occupation from users "
                    . "where name ='$name'";
            $query = mysqli_query($con, $getinfo);
            $row = mysqli_fetch_array($query);
            
            $gender = $row['gender'];
            $age = $row['age'];
            $occupation = $row['occupation'];
            if (!empty($name) && !empty($gender) && !empty($age) && !empty($occupation)) { 
                // create new PDF document
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                
                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                // set some language-dependent strings (optional)
                if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                    require_once(dirname(__FILE__).'/lang/eng.php');
                    $pdf->setLanguageArray($l);
                }

                // ---------------------------------------------------------

                // set default font subsetting mode
                $pdf->setFontSubsetting(true);

                // Set font
                // dejavusans is a UTF-8 Unicode font, if you only need to
                // print standard ASCII chars, you can use core fonts like
                // helvetica or times to reduce file size.
                $pdf->SetFont('dejavusans', '', 14, '', true);

                // Add a page
                // This method has several options, check the source code documentation for more information.
                $pdf->AddPage();

                // set text shadow effect
                $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

                $pdf->Cell(0, 0, 'Name: '.$name, 1, 1, 'C', 0, '', 0);
                $pdf->Cell(0, 0, 'Gender: '.$gender, 1, 1, 'C', 0, '', 0);
                $pdf->Cell(0, 0, 'Age: '.$age, 1, 1, 'C', 0, '', 0);
                $pdf->Cell(0, 0, 'Occupation: '.$occupation, 1, 1, 'C', 0, '', 0);
                // ---------------------------------------------------------

                // Close and output PDF document
                // This method has several options, check the source code documentation for more information.
                $pdf->Output('example_001.pdf', 'I');
                
            }
        }
    }
}



