<?php

include_once __DIR__ . "/utils.php";

class Rofi
{
    private $options;
    private $clipboard;
    private $selected;

    function __construct($value, $options=[])
    {
        $this->setOptions($value);

        if($options && $options["open"]) {
            $this->openMenu();
        }
    }

    public function setOptions($value) {
        if(gettype($value) == 'array') {
            $this->options = $value;
        } elseif (is_string($value)) {
            $this->options = explode("\n", $value);
        } else {
            $type = gettype($value);
            throw new Exception("Only String and Arrays are supported. Received: $type", 1);
        }
    }

    public function prompt(){
        return `xclip -o -selection clipboard | rofi -dmenu -p "" -i -format s -markup-rows -columns 1 -lines 10 -width 40`;
    }

    public function copyPaste($value) {
        $this->clipboard = `xclip -o -selection clipboard`;
        _setClipboard($value);
        `xdotool key ctrl+v`;
        _setClipboard($this->clipboard);
    }

    public function openMenu() {
        _setClipboard(implode("\n", $this->options));

        $selected = trim($this->prompt());
        $this->selected = $selected;

        return $selected;
    }

    public function getSelected(){
        return $this->selected;
    }
}