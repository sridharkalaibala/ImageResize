<?php
include __DIR__ .'/Library/ImageResize.php';

$path = read_stdin('Please enter your file path: ');
if (!file_exists($path)) {
    exit_message('Sorry. File is not exist');
}else if (!strstr(mime_content_type($path), "image/")){
    exit_message('Sorry. File is not image');
}
$width = read_stdin('Please enter new width: (Press Enter if you dont want give)');
check_numeric($width);
$height = read_stdin('Please enter new height: (Press Enter if you dont want give)');
check_numeric($height);
$ext = pathinfo($path, PATHINFO_EXTENSION);
$image = new ImageResize($path);
$filename = time().'.'.$ext;
if(strlen($width) == 0 && strlen($height) > 0){
  $image->resizeToHeight($height, true);
  $image->save($filename);
  exit_message('Image Successfully resized with given height. File name '.$filename);
} else if(strlen($width) >0  && strlen($height) == 0){
  $image->resizeToWidth($width, true);
  $image->save($filename);
  exit_message('Image Successfully resized with given width. File name '.$filename);
}else if (strlen($width) >0  && strlen($height) > 0){
  $image->resize($width, $height, true);
  $image->save($filename);
  exit_message('Image Successfully resized with given width and height. File name '.$filename);
}else {
  exit_message('No change in image.');
}


// our function to read from the command line
function read_stdin($message = '')
{
        echo $message . PHP_EOL;
        $fr=fopen("php://stdin","r");   // open our file pointer to read from stdin
        $input = fgets($fr,128);        // read a maximum of 128 characters
        $input = rtrim($input);         // trim any trailing spaces.
        fclose ($fr);                   // close the file handle
        return $input;                  // return the text entered
}

function exit_message($message)
{
  echo  $message . PHP_EOL;
  exit;
}

function check_numeric($value)
{
  if (!is_numeric($value) && strlen($value) > 0)
    exit_message($value.' is not numeric');
}

?>
