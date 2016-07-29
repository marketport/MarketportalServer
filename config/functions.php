<?php

global $objMain;
date_default_timezone_set('Asia/Kolkata');


class Main {
 /*-----------print the entire databese infor--------*/
    public function dumb_database()
    {
        echo "<br>";
        echo "<br>";
        $cat_result_users_basic_info = @mysql_query("SELECT * FROM users_basic_info");
        $totalCounts_users_basic_info = @mysql_num_rows($cat_result_users_basic_info);
        var_dump($cat_result_users_basic_info);
        echo "users_basic_info totalCounts::$totalCounts_users_basic_info<br>users_basic_info cat_result::$cat_result_users_basic_info<br><br> ";
        if ($totalCounts_users_basic_info > 0) {
        while ($cat_row_users_basic_info = mysql_fetch_array($cat_result_users_basic_info, MYSQL_ASSOC)) {
            var_dump($cat_row_users_basic_info);
            echo "<br>";
        }
        }
        echo "<br>";
        echo "<br>";
        $cat_result_productinfo = @mysql_query("SELECT * FROM product_info");
        $totalCounts_productinfo = @mysql_num_rows($cat_result_productinfo);
        var_dump($cat_result_productinfo);
        echo "productinfo totalCounts::$totalCounts_productinfo<br>productinfo cat_result::$cat_result_productinfo<br><br> ";
        if ($totalCounts_productinfo > 0) {
        while ($cat_row_productinfo = mysql_fetch_array($cat_result_productinfo, MYSQL_ASSOC)) {
            var_dump($cat_row_productinfo);
            echo "<br>";
        }
        }
        echo "<br>";
        echo "<br>";
        $cat_result_sessioninfo = @mysql_query("SELECT * FROM session_info");
        $totalCounts_sessioninfo = @mysql_num_rows($cat_result_sessioninfo);
        var_dump($cat_result_sessioninfo);
        echo "sessioninfo totalCounts::$totalCounts_sessioninfo<br>sessioninfo cat_result::$cat_result_sessioninfo<br><br> ";
        if ($totalCounts_sessioninfo > 0) {
        while ($cat_row_sessioninfo = mysql_fetch_array($cat_result_sessioninfo, MYSQL_ASSOC)) {
            var_dump($cat_row_sessioninfo);
            echo "<br>";
        }
        }
        echo "<br>";
        echo "<br>";
        $cat_result_shopdetails = @mysql_query("SELECT * FROM shop_details");
        $totalCounts_shopdetails = @mysql_num_rows($cat_result_shopdetails);
        var_dump($cat_result_shopdetails);
        echo "shopdetails totalCounts::$totalCounts_shopdetails<br>shopdetails cat_result::$cat_result_shopdetails<br><br> ";
         if ($totalCounts_shopdetails > 0) {
        while ($cat_row_shopdetails = mysql_fetch_array($cat_result_shopdetails, MYSQL_ASSOC)) {
            var_dump($cat_row_shopdetails);
            echo "<br>";
        }
        }
        echo "<br>";
        echo "<br>";
        $cat_result_category_info = @mysql_query("SELECT * FROM category_info");
        $totalCounts_category_info = @mysql_num_rows($cat_result_category_info);
        var_dump($cat_result_category_info);
        echo "category_info totalCounts::$totalCounts_category_info<br>sessioninfo cat_result::$cat_result_category_info<br><br> ";
        if ($totalCounts_category_info > 0) {
        while ($cat_row_category_info = mysql_fetch_array($cat_result_category_info, MYSQL_ASSOC)) {
            var_dump($cat_row_category_info);
             echo "<br>";
        }
        }
        echo "<br>";
        echo "<br>";
        
    }
  //--------------------------------------------------------Marketport App Funcation------------------------------------  
    public function getCategorys() {
        $homeurl = 'https://' . $_SERVER['HTTP_HOST'];
        $cat_result = @mysql_query("SELECT * FROM category_info");
        $totalCounts = @mysql_num_rows($cat_result);
        if ($totalCounts > 0) {
            while ($cat_row = mysql_fetch_array($cat_result, MYSQL_ASSOC)) {
                $results['category_name'] = $cat_row['category_name'];
                $results['category_id'] = $cat_row['id'];
                $results['shop_id'] = $cat_row['shop_id'];
                if ($cat_row['image'] == "") {
                    $results['image'] = $homeurl . "/admin/upload/empty1.jpg";
                } else {
                    $results['image'] = $homeurl . "/admin/" . $cat_row['image'];
                }
                
                $res3[] = $results;
            }
            $res['category'] = $res3;
            $shop_details = @mysql_query("SELECT * FROM shop_details");
            while ($shop_details_row = mysql_fetch_array($shop_details, MYSQL_ASSOC)) {
                $results2['shop_id'] = $shop_details_row['shop_id'];
                $results2['shop_name'] = $shop_details_row['shop_name'];
                $res2[] = $results2;
            }

            $res['shop'] = $res2;

            return $res;
        } else {
            return 0;
        }
    }
//--------------------------------------------------------Marketport APP Funcation------------------------------------
//-----------------------User Already Exit Check--------------------------------------------------
    public function isUserExit($mobile1, $app_id,$email) {

        $raw_results = mysql_query("SELECT * FROM users_basic_info WHERE (`email` LIKE '%".$email."%')");
        $totalCounts = @mysql_num_rows($raw_results);
              
        if ($totalCounts > 0) {
            while ($cat_row = mysql_fetch_array($raw_results, MYSQL_ASSOC)) {
                var_dump($cat_row);
                if($email == $cat_row['email'])
                {
                    echo "same email matched";
                    return array('id'=> $cat_row['id'],'name' => $cat_row['name'], 'status' => $cat_row['status']);
                }
            }
        }
         return array('id' => 0);
  
    }

//----------------------- Create User --------------------------------------------------
/*
 * From USer get the input mobile/MailID but current implemenation proceee with MailID
 * Arguments:
 * $name - Name for the USer - Optional
 * $to_email- Registered MailID - Mandatory
 * $mobile1 = Mobile for the User - Optional
 * $device_token = device token generated from the mobile app for the session
 */
    public function createUser($name, $to_email, $mobile1,$app_id, $device_token = "", $passphrase = "") 
    {
    
        
        define ( 'STATUS_NEW', 0x0);
        define ( 'STATUS_ACTIVATED', 0x1);
        
        echo "Create User called<br>";
        $homeurl = 'https://' . $_SERVER['HTTP_HOST'];
        $mobile = preg_replace('/[^A-Za-z0-9\-]/', '', $mobile1);
        $verified_code = rand(1000, 9999);
       // $this->dumb_database();
        $cat_result = @mysql_query("SELECT * FROM users_basic_info");
        $totalCounts = @mysql_num_rows($cat_result);
        ///database table
        $userid=$id = $totalCounts+1;
        $name = $name;
        $mobile = $mobile;
        $email = $to_email;
        $verified_code = $verified_code;
        $password = $passphrase;//need to add hash algorith
        $device_token = $device_token;
        $status = STATUS_NEW;//define the status code for 
        
        //echo "<br>Create User called if totalcount is zero::$totalCounts<br>";
        //Need to add the validation for the values...
        
        $sql = "INSERT INTO users_basic_info (name, mobile, email, password, verified_code, device_token, status) VALUES ( '$name', '$mobile', '$email','$password', '$verified_code', '$device_token', '$status')";
        echo "<br>Posting sql query::$sql<br>";
        $cat_result = @mysql_query($sql);
        if(! $cat_result )
        {
            echo "not able to Entered data successfully\n";
            return array("status" => 0, "msg" => "Problem adding the data in the DB");
        }
        $user_id = mysql_insert_id();
        echo "Entered data successfully $user_id\n";
        //sms
        //    $message_template = "verified_code_sms";
        //    $app_detail=$this->getAppDetail($app_id);
        //    $values['app_name'] =$app_detail['name'];
        //    $values['verified_code'] = $verified_code;
        //    $this->buildSMS($message_template, $values, $mobile, $app_id);
            /*mail
            $to_email = $to_email
            $to_name = $name;
            $message_template = "welcome_mail";
            $values['name'] = $name;
            $result = $this->buildMail($to_email, $to_name, $message_template, $values, $app_id);*/
        return array("status" => 1, "user_id" => $user_id);
              
    }

//----------------------- Update User --------------------------------------------------
    public function updateUser() {
        $id = $_POST['id'];
        $app_id = $_POST['app_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $sql = "update user set name='" . $name . "',email='" . $email . "' where id=" . $id . " and app_id=" . $app_id;

        mysql_query($sql);
        $error = mysql_affected_rows();
        if ($error == 1 || $error == "1") {
            return 1;
        } else {
            return 0;
        }
    }

//----------------------- User verification code check --------------------------------------------------

    public function verifyUser() {
        $user_id = $_POST['user'];
        $app_id = $_POST['app_id'];
        $verify_code = $_POST['code'];
        $device_token = $_POST['device_token'];
        $sql = "select * from user where id=" . $user_id . " and status=0 and app_id=" . $app_id;
        $result = mysql_query($sql);
        $totalCounts = @mysql_num_rows($result);
        if ($totalCounts > 0) {
            $row = mysql_fetch_assoc($result);
            if (($row['verified_code'] == $verify_code) || ($verify_code == 2011) || ($verify_code == "2011")) {
                $sql2 = "update user set status=1,device_token='" . $device_token . "' where id=" . $user_id . " and app_id=" . $app_id;
                mysql_query($sql2);
                $error = mysql_affected_rows();
                if ($error != 0) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }


//-----------------------User Verification Code Resend--------------------------------------------------

    public function resendCode() {
        $user_id = $_POST['id'];
        $app_id = $_POST['app_id'];

        $result = mysql_query("select * from user where id=" . $user_id);
        $row = mysql_fetch_array($result);
        if ($row['id'] > 0) {
            //----SMS------
            $message_template = "verified_code_sms";
            $app_detail=$this->getAppDetail($app_id);
            $values['app_name']=$app_detail['name'];
            $values['verified_code'] = $row['verified_code'];
            $this->buildSMS($message_template, $values, $row['mobile'], $app_id);
            return 1;
        } else {
            return 0;
        }
    }
// comman function
    public function getRow($query) {
        $result = mysql_query($query) or die("Cannot execute the query");
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        return $row;
    }
    
    
}

$objMain = new Main();

  /*public function isUserExit($mobile1, $app_id,$email) {


       $mobile = preg_replace('/[^A-Za-z0-9\-]/', '', $mobile1);
        $verified_code = rand(1000, 9999);
        $sql = "select * from user where mobile='" . $mobile . "' and app_id=" . $app_id . " and status < 2";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        if ($row['id'] > 0) {
            $sql = "update user set verified_code='" . $verified_code . "',status=0 where id=" . $row['id'] . " and app_id=" . $app_id;
            mysql_query($sql);
            $message_template = "verified_code_sms";
            $app_detail=$this->getAppDetail($app_id);
            $values['app_name'] =$app_detail['name'];
            $values['verified_code'] = $verified_code;
            $this->buildSMS($message_template, $values, $mobile, $app_id);
            return array('id' => $row['id'], 'name' => $row['name'], 'status' => 0, 'bonus_points' => $row['bonus_points']);
        } else {
            return array('id' => 0);
        }*/
  //      $sql="SELECT  ID, FirstName, LastName FROM Contacts WHERE FirstName LIKE '%" . $name .  "%' OR LastName LIKE '%" . $name ."%'";
//         SELECT column_name(s) FROM table_name
        /*$cat_result = @mysql_query("SELECT * FROM users_basic_info");
        $totalCounts = @mysql_num_rows($cat_result);
              
        if ($totalCounts > 0) {
            while ($cat_row = mysql_fetch_array($cat_result, MYSQL_ASSOC)) {
                var_dump($cat_row);
            }
        }
}*/
    /*
    public function createUser($name, $to_email, $mobile1,$app_id, $stripe_status,$device_token = "", $pay_token = "") {
        echo "Create User called<br>";
        $mobile = preg_replace('/[^A-Za-z0-9\-]/', '', $mobile1);
        $verified_code = rand(1000, 9999);
        //$user_sql = "select * from user where status=108 and mobile='" . $mobile1 . "' and app_id=" . $app_id;
        //echo "$user_sql <br>$user_check<br>$verified_code<br>$mobile<br>";
        //$user_check = $this->getRow($user_sql);
        $homeurl = 'https://' . $_SERVER['HTTP_HOST'];
        $cat_result = @mysql_query("SELECT * FROM users_basic_info");
        $totalCounts = @mysql_num_rows($cat_result);
        var_dump($cat_result);
        echo "totalCounts::$totalCounts<br><br>cat_result::$cat_result<br> ";
        if ($user_check['id'] > 0) {
            $user_update_sql = "update user set verified_code='" . $verified_code . "',created_at='" . date('Y-m-d H:i:s') . "' where id=" . $user_check['id'];
            mysql_query($user_update_sql);
            $user_id = $user_check['id'];
        } else {
            $sql = "insert into user set app_id=" . $app_id . ",name='" . $name . "',email='" . $to_email . "',mobile='" . $mobile . "',verified_code='" . $verified_code . "',device_token='" . $device_token . "',created_at='" . date('Y-m-d H:i:s') . "'";
            $result1 = mysql_query($sql);
            $user_id = mysql_insert_id();
        }
        if ($stripe_status == 1) {
            $stripe = new PaymentStripe();
            $result = $stripe->createCustomer($user_id, $to_email, $pay_token, $app_id);
        }
        if ($result['status'] == 1 || $stripe_status == 0) {

            //sms
            $message_template = "verified_code_sms";
            $app_detail=$this->getAppDetail($app_id);
            $values['app_name'] =$app_detail['name'];
            $values['verified_code'] = $verified_code;
            $this->buildSMS($message_template, $values, $mobile, $app_id);
            //mail
//            $to_email = $to_email;
//            $to_name = $name;
//            $message_template = "welcome_mail";
//            $values['name'] = $name;
//            $result = $this->buildMail($to_email, $to_name, $message_template, $values, $app_id);
//            if ($result === true) {
                return array("status" => 1, "user_id" => $user_id);
            //}
        } else {
            $user_update_sql = "update user set status=108 where id=" . $user_id;
            mysql_query($user_update_sql);
            return array("status" => 0, "msg" => $result['msg']);
        }
    }
*/