<?php 

/**
 * Undocumented function
 *
 * @param [type] $func
 * @return void
 */
function _map_functions($func)
{
    $refFunc = new ReflectionFunction($func);
    $doc = $refFunc->getDocComment();

    // find function description
    preg_match_all('/\/\*\*\n\s\*\s(.*)/', $doc, $match);
    
    // find @color attribute
    preg_match_all('/@color\s(.*)/', $doc, $color);

    // set default color
    $color = ($color[1] && $color[1][0]) ? $color[1][0] : '#1877f2';

    if ($match[1] && $match[1][0]) {
        $description = $match[1][0];
        return "<span lang='$func' foreground='$color'>$description</span> $func";
    }

    return  "<span lang='$func'></span>$func";
}

/**
 * Exclude functions starting with _
 *
 * @param [type] $func
 * @return void
 */
function _filter_functions($func)
{
    return $func[0] !== '_';
}

/**
 * Set clipboard
 *
 * @param string $new
 * @return boolean
 */
function _setClipboard(string $new): bool
{
    if (PHP_OS_FAMILY === 'Windows') {
        $clip = popen('clip', 'wb');
    } elseif (PHP_OS_FAMILY === 'Linux') {
        $clip = popen('xclip -selection clipboard', 'wb');
    } elseif (PHP_OS_FAMILY === 'Darwin') {
        $clip = popen('pbcopy', 'wb');
    } else {
        throw new \Exception(
            'running on unsupported OS: ' .
                PHP_OS_FAMILY .
                ' - only Windows, Linux, and MacOS supported.'
        );
    }
    $written = fwrite($clip, $new);
    return pclose($clip) === 0 && strlen($new) === $written;
}