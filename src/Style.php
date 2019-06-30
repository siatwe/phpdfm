<?php
class Style
{
    // Bash color codes
    private static $red = 31;
    private static $green = 32;
    private static $yellow = 33;
    private static $blue = 34;
    private static $magenta = 35;
    // Bash font style
    private static $bold = 1;
    public static function color($color, $string)
    {
        switch ($color) {
        case 'red': return "\e[".self::$red.'m'.$string."\e[0m";
        case 'green': return "\e[".self::$green.'m'.$string."\e[0m";
        case 'yellow': return "\e[".self::$yellow.'m'.$string."\e[0m";
        case 'blue': return "\e[".self::$blue.'m'.$string."\e[0m";
        case 'magenta': return "\e[".self::$magenta.'m'.$string."\e[0m";
        default: return $string; break;
        }
    }
    public static function font($style, $string)
    {
        switch ($style) {
        case 'bold': return "\e[".self::$bold.'m'.$string."\e[0m";
        default: return $string; break;
        }
    }
}
