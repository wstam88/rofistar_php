<?php

include_once __DIR__ . "/utils.php";

/**
 * RofiStar
 */
class RofiStar
{
    private $list_file = __DIR__. "/.list.txt";
    private $max_scan_depth = 20;
    public $clipboard;

    /**
     * Undocumented function
     */
    function __construct()
    {
        $this->_require_all(__DIR__ . '/../resources/scripts', 0);
        $this->functions = array_filter(
            get_defined_functions()['user'],
            '_filter_functions'
        );
        file_put_contents(__DIR__ . '/.list.txt', $this->getList());
        require_once __DIR__ . '/../vendor/autoload.php';
    }

    /**
     * Undocumented function
     */
    private function _require_all($dir, $depth = 4)
    {
        if ($depth > $this->max_scan_depth) {
            return;
        }

        // require all php files
        $scan = glob("$dir" . DIRECTORY_SEPARATOR . '*');
        foreach ($scan as $path) {
            if (preg_match('/\.php$/', $path)) {
                require_once $path;
            } elseif (is_dir($path)) {
                $this->_require_all($path, $depth + 1);
            }
        }
    }
    /**
     * Undocumented function
     */
    function openMenu()
    {
        $this->clipboard = `xclip -o -selection clipboard`;
        $selected = `cat $this->list_file | rofi -dmenu -p "" -i -format s -markup-rows -columns 1 -lines 10 -width 40`;
        echo $selected;

        preg_match_all("/lang='([a-z0-9_\\\\]+)'[\s|>]/im", $selected, $match);
        print_r($match);
        $output = ($match[1] && $match[1][0]) ? call_user_func(trim($match[1][0]), trim(`xclip -o`)) : '';

        if($output) {
            _setClipboard($output);
            `xdotool key ctrl+v`;
        }

        _setClipboard($this->clipboard);

        die;
    }

    /**
     * Undocumented function
     */
    function getList(): string
    {
        $functions = array_map('_map_functions', $this->functions);
        return implode("\n", $functions);
    }
}

$rofi = new RofiStar();
$rofi->openMenu();