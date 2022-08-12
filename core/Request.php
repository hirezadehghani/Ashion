<?php

namespace app\core;

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

                // Count # of uploaded files in array
                $total = count($_FILES['pictures']['name']);

                // Loop through each file
                for ($i = 0; $i < $total; $i++) {

                    //Get the temp file path
                    $tmpFilePath = $_FILES['pictures']['tmp_name'][$i];

                    //Make sure we have a file path
                    if ($tmpFilePath != "") {
                        //Setup our new file path
                        $newFilePath = "../public/upload/" . $_FILES['pictures']['name'][$i];

                        move_uploaded_file($tmpFilePath, $newFilePath);
                    }
                }
                $body['pictures'] = [];
                $arrayToJson = [];
                foreach($_FILES['pictures']['name'] as $key => $value){
                    array_push($arrayToJson, $value);
                }
                $body['pictures'] = json_encode($arrayToJson);

            }
        }
            return $body;
        }
    }
