<?php

/**
 * Asset manager
 *
 * directly echo script and link tag, based on env/live
 *
 * live environment will echo the concat file
 * dev will create the concat file and echo each script
 *
 *
 *
 *
 *
 * DEMO
 *
 *
 * // add css or js
 * Asset::css(array('a','b','module/c'));
 *
 *
 * // for temporary page loading one or 2 scripts
 * Asset::addCss(array('a','b'));
 */
class Asset { 

    protected static $assetPath = ___ASSETPATH;

    /**
     * minify or load all css
     *
     * return String
     */
    public static function css($ar) {
        if ( ___ENV == 'live' ) {
            self::source('css', self::$assetPath . 'css/' . 'all.css');
        } else {
            self::getFile('css', $ar);
        }
    }

    /**
     * minify or load all js
     *
     * return String
     */
    public static function js($ar) {
        if ( ___ENV == 'live' ) {
            self::source('js', self::$assetPath . 'js/' . 'all.js');
        } else {
            self::getFile('js', $ar);
        }
    }

    /**
     * add css just for that page
     *
     * return String
     */
    public static function addCss($ar) {
        foreach($ar as $file) {
            self::source('css', $file . '.css');
        }
    }

    /**
     * add js just for that page
     *
     * return String
     */
    public static function addjs($ar) {
        foreach($ar as $file) {
            self::source('js', $file . '.js');
        }
    }

    // =========================== 
    //      PRIVATE
    // =========================== 

    private static function source($type, $file) {
        if ( $type == 'js' ) {
            echo '<script type="text/javascript" src="' . $file . '"></script>';
        } else {
            echo '<link rel="stylesheet" href="' . $file . '" />';
        }
    }

    private static function getFile($type, $ar){

        // create store
        $build = '';
        $cssCount = 0;
        
        foreach($ar as $file) {
            // build all file
            if (file_exists(self::$assetPath . '/' . $type . '/' . $file . '.' . $type)) {
                $build .= file_get_contents(self::$assetPath . '/' . $type . '/' . $file . '.' . $type);
            }

            // echo each
            if ($type != 'css') {
                echo self::source($type, self::$assetPath . '/' . $type . '/' . $file . '.' . $type);
            } else {
                // @todo use @import and break on 30, within <style> to prevent ie 30 sheet limits
                echo self::source($type, self::$assetPath . '/' . $type . '/' . $file . '.' . $type);
            }
        }

        // remove line space
        $build = self::compress($build);

        // write file
        file_put_contents(self::$assetPath . '/all.' . $type, $build);
    }

    private static function compress($buffer) {
        /* remove comments */
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        /* remove tabs, spaces, newlines, etc. */
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
        return $buffer;
    }
}
