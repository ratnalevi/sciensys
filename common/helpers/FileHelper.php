<?php

namespace common\helpers;

//Set the time out
use common\models\SmsDetail;

set_time_limit(0);

class FileHelper {

//This application is developed by www.webinfopedia.com
//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
    public static function output_file($file, $name, $mime_type='')
    {
        /*
    This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
    */

        //Check the file premission
        if(!is_readable($file)) die('File not found or inaccessible!');

        $size = filesize($file);
        $name = rawurldecode($name);

        /* Figure out the MIME type | Check in array */
        $known_mime_types=array(
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg"=> "image/jpg",
            "jpg" =>  "image/jpg",
            "php" => "text/plain"
        );

        if($mime_type==''){
            $file_extension = strtolower(substr(strrchr($file,"."),1));
            if(array_key_exists($file_extension, $known_mime_types)){
                $mime_type=$known_mime_types[$file_extension];
            } else {
                $mime_type="application/force-download";
            };
        };

        //turn off output buffering to decrease cpu usage
        @ob_end_clean();

        // required for IE, otherwise Content-Disposition may be ignored
        if(ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');

        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');
        header('Content-Type: application/octet-stream');

        /* The three lines below basically make the
       download non-cacheable */
        header("Cache-control: private");
        header('Pragma: private');
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        // multipart-download and download resuming support
        if(isset($_SERVER['HTTP_RANGE']))
        {
            list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
            list($range) = explode(",",$range,2);
            list($range, $range_end) = explode("-", $range);
            $range=intval($range);
            if(!$range_end) {
                $range_end=$size-1;
            } else {
                $range_end=intval($range_end);
            }
            /*
        ------------------------------------------------------------------------------------------------------
        //This application is developed by www.webinfopedia.com
        //visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
        ------------------------------------------------------------------------------------------------------
         */
            $new_length = $range_end-$range+1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length=$size;
            header("Content-Length: ".$size);
        }

        /* Will output the file itself */
        $chunksize = 1*(1024*1024); //you may want to change this
        $bytes_send = 0;
        if ($file = fopen($file, 'r'))
        {
            if(isset($_SERVER['HTTP_RANGE']))
                fseek($file, $range);

            while(!feof($file) &&
                (!connection_aborted()) &&
                ($bytes_send<$new_length)
            )
            {
                $buffer = fread($file, $chunksize);
                print($buffer); //echo($buffer); // can also possible
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
        } else
            //If no permissiion
            die('Error - can not open file.');
        //die
        die();
    }

    public static function sendSMS( $numbers, $message ){

        // Response : {
        //"balance":999,
        //"batch_id":250452041,
        //"cost":1,
        //"num_messages":1,
        //"message":{
            //"num_parts":1,
            //"sender":"TXTLCL",
            //"content":"Hi Levi, Thanks for signing up on our application"},
            //"receipt_url":"",
            //"custom":"",
        //"messages":[{"id":"140356099","recipient":919566018299}],"status":"success"}

        $sms = new SmsDetail();
        $sms->message = $message;
        $sms->send_to = $numbers;
        $username = 'levi@pluggd.co';
        $hash = '1be9c8b470eb085bb20442bacb4ef4b61c09eba3';

        $sender = urlencode('TXTLCL');
        $message = rawurlencode( $message );

        $sms->sender_name = $sender;

        $numbers = implode(',', [$numbers]);

        $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        $ch = curl_init('http://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);
        $sms->batch_id = $response['batch_id'];
        $sms->msg_id = $response['messages'][0]['id'];
        $sms->msg_status = $response['status'];
        if(!$sms->save()){
            die(print_r($sms->errors));
        }
        return $sms;
    }
}

?>