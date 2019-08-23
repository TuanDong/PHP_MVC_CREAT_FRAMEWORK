<?php
function asset($url='')
{
    $urlString = '';
    if (!empty($url)) {
        $urlArr = explode('/',$url);
        $urlString = implode(DS,$urlArr);
    }
    return ('/public'.DS.$urlString);
}

function url($url='',$params=[])
{
    
    $urlString = '';
    if (! empty($url) && $url !='/') {
        $url = trim($url,'/');
        $urlArr = explode('/',$url);
        if(count($urlArr) == 1) {
            array_push($urlArr,'index');
        } 
        $urlString = implode(DS,$urlArr);
        if (! empty($params)) {
            foreach ($params as $value) {
                $urlString .= DS.$value;
            }
        }
    }else {
        if (! empty($params)) {
            $urlString = 'home'.DS.'index';
            foreach ($params as $value) {
                $urlString .= DS.$value;
            }
        }
    }
    return ('/'.$urlString);
}
