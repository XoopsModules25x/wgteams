<?php

namespace XoopsModules\Wgteams;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 * wgTeams module for xoops
 *
 * @copyright       The XOOPS Project (https://xoops.org)
 * @license         GPL 2.0 or later
 * @package         wgteams
 * @since           1.0
 * @min_xoops       2.5.7
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version         $Id: 1.0 helper.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class Helper
 */
class Helper extends \Xmf\Module\Helper
{
    /**
     * @var string
     */
    protected $dirname = null;
    /**
     * @var string
     */
    protected $module = null;
    /**
     * @var string
     */
    protected $handler = null;
    /**
     * @var string
     */
    protected $config = null;
    /**
     * @var string
     */
    protected $debug = null;
    /**
     * @var array
     */
    protected $debugArray = [];

    /**
     * @protected function constructor class
     * @param mixed $debug
     */
    public function __construct($debug)
    {
        $this->debug   = $debug;
        $this->dirname = \basename(\dirname(__DIR__));
    }

    /**
     * @static   function getInstance
     * @param bool $debug
     * @return static
     * @internal param $null
     */
    public static function getInstance($debug = false)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($debug);
        }

        return $instance;
    }

    /**
     * @static function getModule
     * @param null
     * @return string
     */
    public function &getModule()
    {
        if (null === $this->module) {
            $this->initModule();
        }

        return $this->module;
    }

    /**
     * @static function getConfig
     * @param string $name
     * @param int    $index
     * @return mixed
     */
    public function getConfig($name = null, $index = -1)
    {
        if (null === $this->config) {
            $this->initConfig();
        }
        if (!$name) {
            $this->addLog('Getting all config');

            return $this->config;
        }
        if (!isset($this->config[$name])) {
            $this->addLog("ERROR :: CONFIG '{$name}' does not exist");

            return null;
        }
        if (\is_array($this->config[$name])) {
            if ($index > -1) {
                $this->addLog("Getting config '{$name}' : " . $this->config[$name][$index]);

                return $this->config[$name][$index];
            }
            $this->addLog("Getting config '{$name}' : array " . $name);

            return $this->config[$name];
        }

        $this->addLog("Getting config '{$name}' : " . $this->config[$name]);

        return $this->config[$name];
    }

    /**
     * @static function setConfig
     * @param string $name
     * @param mixed  $value
     * @return mixed
     */
    public function setConfig($name = null, $value = null)
    {
        if (null === $this->config) {
            $this->initConfig();
        }
        $this->config[$name] = $value;
        $this->addLog("Setting config '{$name}' : " . $this->config[$name]);

        return $this->config[$name];
    }

    /**
     * @static function getHandler
     * @param string $name
     * @return mixed
     */
    public function getHandler($name)
    {
        $class = '\\XoopsModules\\' . \ucfirst(\mb_strtolower(\basename(\dirname(__DIR__)))) . '\\' . $name . 'Handler';

        if (!\class_exists($class)) {
            throw new \RuntimeException("Class '$class' not found");
        }

        $db  = \XoopsDatabaseFactory::getDatabaseConnection();
        $ret = new $class($db);

        $this->addLog("Getting handler '{$name}'");
        return $ret;
    }

    /**
     * @static function initModule
     * @param null
     */
    public function initModule()
    {
        global $xoopsModule;
        if (isset($xoopsModule) && \is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->dirname) {
            $this->module = $xoopsModule;
        } else {
            $hModule      = \xoops_getHandler('module');
            $this->module = $hModule->getByDirname($this->dirname);
        }
        $this->addLog('INIT MODULE');
    }

    /**
     * @static function initConfig
     * @param null
     */
    public function initConfig()
    {
        $this->addLog('INIT CONFIG');
        $hModConfig   = \xoops_getHandler('config');
        $this->config = $hModConfig->getConfigsByCat(0, $this->getModule()->getVar('mid'));
    }

    /**
     * @static function initHandler
     * @param string $name
     */
    public function initHandler($name)
    {
        $this->addLog('INIT ' . $name . ' HANDLER');
        $this->handler[$name . '_handler'] = xoops_getModuleHandler($name, $this->dirname);
    }

    /**
     * @static function addLog
     * @param string $log
     */
    public function addLog($log)
    {
        if ($this->debug) {
            if (\is_object($GLOBALS['xoopsLogger'])) {
                $GLOBALS['xoopsLogger']->addExtra($this->module->name(), $log);
            }
        }
    }

    /**
     * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
     * www.gsdesign.ro/blog/cut-html-string-without-breaking-the-tags
     * www.cakephp.org
     *
     * @param string $text         String to truncate.
     * @param int    $length       Length of returned string, including ellipsis.
     * @param string $ending       Ending to be appended to the trimmed string.
     * @param bool   $exact        If false, $text will not be cut mid-word
     * @param bool   $considerHtml If true, HTML tags would be handled correctly
     *
     * @return string Trimmed string.
     */
    public static function truncateHtml($text, $length = 200, $ending = '...', $exact = false, $considerHtml = true)
    {
        if (!$considerHtml) {
            return self::truncateText($text, $length, $ending, $exact);
        }

        // Check if $text is null
        if ($text === null) {
            return '';
        }

        // If the plain text is shorter than the maximum length, return the whole text
        $plainText = strip_tags($text);
        if (mb_strlen($plainText) <= $length) {
            return $text;
        }

        // Split the HTML content into tags and text
        $tags = [];
        $result = '';
        $totalLength = 0;

        preg_match_all('/<[^>]*>([^<]*)/', $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $tag = $match[0];
            $content = $match[1];

            // Add the tag to the result
            $result .= $tag;

            // Handle opening and closing tags
            if (preg_match('/<(\w+)[^>]*>/', $tag, $tagMatches)) {
                $openingTag = $tagMatches[1];
                $tags[]     = $openingTag;
            } elseif (preg_match('/<\/(\w+)>/', $tag, $tagMatches)) {
                $closingTag = $tagMatches[1];
                $index = array_search($closingTag, $tags);
                if ($index !== false) {
                    array_splice($tags, $index, 1);
                }
            }

            // Truncate the text if the maximum length is reached
            if ($totalLength + mb_strlen($content) > $length) {
                $remainingLength = $length - $totalLength;
                $result .= mb_substr($content, 0, $remainingLength);
                break;
            }

            $result .= $content;
            $totalLength += mb_strlen($content);
        }

        // Close any remaining open tags
        while (!empty($tags)) {
            $openTag = array_pop($tags);
            $result .= "</$openTag>";
        }

        // Add the ending if the text was truncated
        if ($totalLength >= $length) {
            $result .= $ending;
        }

        return $result;
    }

    private static function truncateText($text, $length, $ending, $exact)
    {
        // Check if $text is null
        if ($text === null) {
            return '';
        }

        if (mb_strlen($text) <= $length) {
            return $text;
        }

        $truncate = mb_substr($text, 0, $length - mb_strlen($ending));

        if (!$exact) {
            $spacepos = mb_strrpos($truncate, ' ');
            if ($spacepos !== false) {
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }

        return $truncate . $ending;
    }
}
