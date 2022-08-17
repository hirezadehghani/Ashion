<?php

namespace app\core;

use DateTime;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        return $this->method() === 'get';
    }


    public function isPost()
    {
        return $this->method() === 'post';
    }

    public function getBody()
    {

        $body = [];
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if ($_FILES) {
                // $files = array_filter($_FILES['pictures']['name']); //something like that to be used before processing files.
                $date = Date("YmdHis");
                // GET DATE OF TODAY
                // Count # of uploaded files in array
                $total = count($_FILES['pictures']['name']);
                //for store pictures name in database
                $body['pictures'] = [];
                $arrayToJson = [];

                // Loop through each file
                for ($i = 0; $i < $total; $i++) {
                    $oldName = $_FILES['pictures']['name'][$i];
                    //SET NEW NAME FOR BECAUSE DUPLICATE FILES NAMES
                    $random = strval(random_int(1, 100));
                    $newName = ($date . $random . $oldName);

                    //Get the temp file path
                    $tmpFilePath = $_FILES['pictures']['tmp_name'][$i];

                    //Make sure we have a file path
                    if ($tmpFilePath != "") {
                        //Setup our new file path
                        $newFilePath = "../public/upload/" . $newName;

                        move_uploaded_file($tmpFilePath, $newFilePath);
                        array_push($arrayToJson, $newName);
                    }
                }
                //convert to json and store in database
                $body['pictures'] = json_encode($arrayToJson);
            }
        }
        return $body;
    }
}
