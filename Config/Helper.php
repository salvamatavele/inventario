<?php
//_token
function _token():string
{
    # rondom token;
    return bin2hex(random_bytes(64));
}

/**
 * make hash password
 *
 * @param string $passwd
 * @param [type] $hashType
 * @return void
 */
function passwordHash(string $passwd, $hashType = PASSWORD_DEFAULT)
{
    return password_hash($passwd, $hashType);
}

#Pegar o ip do usuário
function getUserIp()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

//avatar
/**
 * gerar avatares com primeira letra
 */

function make_avatar(string $character)
{
    $char = strtoupper($character[0]);
    $path = "Public/avatar/".$character.time().".png";
    $image = imagecreate(200, 200);
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);
    imagecolorallocate($image, $red, $green, $blue);
    $textcolor = imagecolorallocate($image, 255, 255, 255);

    imagettftext($image, 100, 0, 55, 150, $textcolor, 'Public/fonts/arial.ttf', $char);
    //header("Content-type: image/png");  
    imagepng($image, $path);
    imagedestroy($image);
    return $path;
}
