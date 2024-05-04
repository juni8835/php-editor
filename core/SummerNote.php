<?php

// https://www.w3schools.com/php/func_string_htmlentities.asp

class SummerNote {
    static function save($html_content){
        if(!$html_content) return; 
        $content = html_entity_decode(DB::unesc($html_content));
        
        $doc = new DOMDocument();
        $doc->loadHTML($content);
        $images = $doc->getElementsByTagName('img');
        
        if(count($images) > 0){

            for ($i = 0; $i < count($images); $i++){
                $img = $images->item($i);
                $src = $img->getAttribute('src');
                
                if(!file_exists(ROOT.trim($src, '/'))){
                    list($info, $data) = explode(';', $src);
                    list(, $ext) = explode('/', $info);
                    list(, $base64_data) = explode(',', $data);
                    
                    $filename = Helper::generateRandomId(8).'_'.uniqid().'.'.$ext; 
                    file_put_contents(UPLOAD_DIR.'/'.$filename, base64_decode($base64_data));
                    $img->setAttribute('src', UPLOAD_BASE_DIR.'/'.$filename);
                }
            }

            return $doc->saveHTML();
        }

        return $html_content; 
    }

    static function delete($html_content){
        if(!$html_content) return; 
        $content = html_entity_decode(DB::unesc($html_content));
        
        $doc = new DOMDocument();
        $doc->loadHTML($content);
        $images = $doc->getElementsByTagName('img');
        
        if(count($images) === 0){
            return;
        }

        for ($i = 0; $i < count($images); $i++){
            $img = $images->item($i);
            $src = $img->getAttribute('src');
            $filename = ROOT.trim($src, '/');

            if(file_exists($filename)){
               unlink($filename);
            }
        }
    }
}