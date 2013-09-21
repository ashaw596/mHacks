<?php
class ImageFile
{
    public $file; //Array with name,type,size,tmp_name keys. Read from $_FILES["file"]
    
    function __construct($inputFile) //Array with name,type,size,tmp_name keys. Read from $_FILES["file"]
    {
        if(is_array($inputFile))
        {
            if(array_key_exists("name",$inputFile)&&array_key_exists("type",$inputFile)&&array_key_exists("size",$inputFile)&&array_key_exists("tmp_name",$inputFile))
            {
                
                if(is_uploaded_file($inputFile["tmp_name"]))
                {
                    $this -> file = $inputFile;
                }
                else
                
                {
                    throw new Exception('uploaded file not found');
                }
            }
            else
            {
                throw new Exception('$inputFile Variable is not of the correct type');  
            }
        }
        else
        {
            throw new Exception('$inputFile Variable is not of the correct type');  
        }
    }
    
    function toImage() //returns image;
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        
        switch ( strtolower (finfo_file($finfo, $this -> file ["tmp_name"])))
        {
            case "image/jpeg":
            case "image/pjpeg":
                return  imagecreatefromjpeg ($this -> file ["tmp_name"]);
                break;
            case "image/png":
                return  imagecreatefrompng ($this -> file ["tmp_name"]);
                break;
            case: "image/gif":
                return  imagecreatefromgif($this -> file ["tmp_name"]);
                break;
            default:
                throw new Exception('Image Conversion Failure');  
                return false;
                break;
        }
        finfo_close($finfo);
    }
}


?>