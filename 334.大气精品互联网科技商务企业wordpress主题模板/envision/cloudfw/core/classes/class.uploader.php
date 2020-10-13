<?php

/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        
        $temp = @tmpfile();
        if ( !$temp )
            $temp = fopen("php://temp", "wb");

        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSize()){            
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 8388608;
    private $file;
    private $documents_dir;

    function __construct(array $allowedExtensions = array(), $documents_dir = NULL, $sizeLimit = NULL){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        if ( $sizeLimit )
            $this->sizeLimit = $sizeLimit;

        $this->documents_dir = $documents_dir;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        if (!is_writable($uploadDirectory)){
            return array('error' => __("Server error. Upload directory isn't writable.",'cloudfw'));
        }
        
        if (!$this->file){
            return array('error' => __('No files were uploaded.','cloudfw'));
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('error' => __('File is empty','cloudfw'));
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => __('File is too large','cloudfw'));
        }

        $pathinfo = pathinfo($this->file->getName());
        $filename = sanitize_file_name($pathinfo['filename']);
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => sprintf(__('File has an invalid extension, it should be one of %s','cloudfw'), $these));
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            $i = 0; $o_filename = $filename; 
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $i++;
                $filename = $o_filename . '-' . $i;
            }
        }
        
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
            $documents_dir = $this->documents_dir;
            return array('success'=>true, 'filepath' => ($documents_dir.$filename . '.' . $ext), 'fileRelpath' => ($uploadDirectory . $filename . '.' . $ext));
        } else {
            return array('error'=> __('Could not save uploaded file.','cloudfw') .
                __('The upload was cancelled, or server error encountered','cloudfw'));
        }
        
    }    
}