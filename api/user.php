<?php
//Testing the commits
require_once '../config/common.php';
//Another test
//sample commit

$module = @$_REQUEST['module'];
$action = @$_REQUEST['action'];
$id = @$_REQUEST['id'];

echo "Printing POST <br>";
var_dump($_POST); // Element 'bar' is string(1) "b"

switch ($module) {
    
//-----------------Category Module----------------------------------------------
    case 'category':
        switch ($action) {
            case 'list':
                //Get Categorys
                $result = $objMain->getCategorys();
                if ($result) {
                    $res['error'] = false;
                    $res['data'] = $result;
                } else {
                    $res['error'] = true;
                    $res['message'] = "No category found";
                }
                response_json($res);
                break;
        }
        break;
//-----------------User Module---------------------------------------------------
    case 'user':
        switch ($action) {
            case 'create':
                /*For creating the User we need the mandaotry field
                 * Username - Username for the UserProfile
                 * Mobileno/mailID - For login purpose use ths mobileId/MailID
                 * devicetoken -For evry session device token should be received from the mobileapp
                 * password - Password field for login
                 */
                $name = isset($_POST['name']) ? $_POST['name'] : "";
                $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : "";
                $to_email = isset($_POST['email']) ? $_POST['email'] : "";
                $device_token = isset($_POST['device_token']) ? $_POST['device_token'] : "";
                $password = isset($_POST['password']) ? $_POST['password'] : "";
                
                echo "<br><br>Name : $name<br>";
                echo "mobile $mobile<br>";
                echo "to_email $to_email<br>";
                echo "device_token $device_token<br>";
                echo "password:: $password<br>";
              
                if(($name != "" && $device_token != "" && $password != "") && ($mobile != "" || $to_email != ""))
                {
                    $res['error'] = false;
                    $res['message'] = "All given iput value is correct<br>";
                    echo " All value is  prper:;<br>";
                    response_json($res);
                }
                else {
                    
                    $res['error'] = true;
                    $res['message'] = "Please,Check the input parameter....<br>";
                    echo " All value is not prper:;<br>";
                    response_json($res);
                    exit();
                }
                $app_id =0;
                $user = $objMain->isUserExit($to_email,$app_id,$to_email);
                echo "After iuserExit". $user['id'];
                
                if ($user['id'] <= 0) {
                    $result = $objMain->createUser($name, $to_email, $mobile,$app_id, $device_token , $password);
                    //$result = $objMain->createUser($name, $to_email, $mobile,$app_id,$stripe_status, $device_token,$pay_token);
                    if ($result['status'] > 0) {
                        $res['error'] = false;
                        $res['id'] = $result['user_id'];
                        $res['status'] = 0;
                        $res['message'] = "Your verification code has been sent into your mobile number!";
                    } else {
                        $res['error'] = true;
                        $res['message'] =$result['status'];
                    }
                } else {
                    $res['error'] = true;
                    $res['id'] = $user['id'];
                    $res['status'] = $user['status'];
                    $res['message'] = $user['name'].", we missed you. Welcome back!!";
                }
                response_json($res);
                break;
            case 'verify':
                $result = $objMain->verifyUser();
                if ($result > 0) {
                    $res['error'] = false;
                    $res['status'] = 1;
                    $res['message'] = "Code verified successfully";
                } else {
                    $res['error'] = true;
                    $res['message'] = "Code miss match!Try again";
                }
                response_json($res);
                break;
            case 'resend':
                $result = $objMain->resendCode();
                if ($result > 0) {
                    $res['error'] = false;
                    $res['message'] = "Verification code has been sent into your mobile";
                } else {
                    $res['error'] = true;
                    $res['message'] = "Email and mobile number miss match!Try again";
                }
                response_json($res);
                break;
            
        }
        break;



//-----------------All Module End---------------------------------------------------
}

function response_json($res) {

    header('Content-Type: application/json');

    echo json_encode($res);
}
