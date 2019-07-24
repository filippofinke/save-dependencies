<?php

/**
 * @author Filippo Finke
 */

 $extensions = ["js","css"];

if(count($argv) < 2)
{
    echo "Usage: php ".$argv[0]." <filename>\n";
    exit;
}

$input = $argv[1];

if(!file_exists("output")) mkdir("output");
$content = file_get_contents($input);
preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $urls);
foreach($urls[0] as $url)
{
    foreach($extensions as $extension)
    {
        if(strpos($url, '.'.$extension) !== false ) {
            if(!file_exists("output/".$extension)) mkdir("output/".$extension);
            echo "[$extension] $url -> Downloading\n";
            $filename = explode('/', $url);
            $path = $extension.'/'.end($filename);
            $content = str_replace($url, $path, $content);
            $path = 'output/'.$path;
            file_put_contents($path, fopen($url, 'r'));
            echo "[$extension] Saved to $path\n";
            continue;
        }
    }
}
file_put_contents('output/'.$input, $content);
echo "[Done] File ".$input." saved to output/$input\n";

?>