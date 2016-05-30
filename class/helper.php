<?php
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
 * @copyright       The XOOPS Project (http://xoops.org)
 * @license         GPL 2.0 or later
 * @package         wgteams
 * @since           1.0
 * @min_xoops       2.5.7
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<http://wedega.com>
 * @version         $Id: 1.0 helper.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
* Class WgteamsHelper
*/
class WgteamsHelper
{
    /**
     * @var string
     */
    private $dirname = null;
    /**
     * @var string
     */
    private $module = null;
    /**
     * @var string
     */
    private $handler = null;
    /**
     * @var string
     */
    private $config = null;
    /**
     * @var string
     */
    private $debug = null;
    /**
     * @var array
     */
    private $debugArray = array();

    /*
    *  @protected function constructor class
    *  @param mixed $debug
    */
    /**
    * WgteamsHelper constructor.
    * @param $debug
    */
    public function __construct($debug)
    {
        $this->debug   = $debug;
        $this->dirname = basename(dirname(__DIR__));
    }

    /*
    * @static function &getInstance
    * @param bool $debug
    * @return bool|WgteamsHelper
    */
    public static function &getInstance($debug = false)
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self($debug);
        }

        return $instance;
    }

    /*
    * @static function getModule
    * @param null
    * @return string
    */
    public function &getModule()
    {
        if ($this->module == null) {
            $this->initModule();
        }

        return $this->module;
    }

    /*
    * @static function getConfig
    * @param null $name
    * @param int  $index
    * @return null|string
    */
    public function getConfig($name = null, $index = -1)
    {
        if ($this->config == null) {
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
        if (is_array($this->config[$name])) {
            if ($index > -1) {
                $this->addLog("Getting config '{$name}' : " . $this->config[$name][$index]);

                return $this->config[$name][$index];
            } else {
                $this->addLog("Getting config '{$name}' : array " . $name);

                return $this->config[$name];
            }

        } else {
            return $this->config[$name];
            $this->addLog("Getting config '{$name}' : " . $this->config[$name]);
        }

        return $this->config[$name];
    }

    /*
    * @static function setConfig
    * @param null $name
    * @param null $value
    * @return mixed
    */
    public function setConfig($name = null, $value = null)
    {
        if ($this->config == null) {
            $this->initConfig();
        }
        $this->config[$name] = $value;
        $this->addLog("Setting config '{$name}' : " . $this->config[$name]);

        return $this->config[$name];
    }

    /*
    * @static function getHandler
    * @param $name
    * @return mixed
    */
    public function &getHandler($name)
    {
        if (!isset($this->handler[$name . '_handler'])) {
            $this->initHandler($name);
        }
        $this->addLog("Getting handler '{$name}'");

        return $this->handler[$name . '_handler'];
    }

    /*
    *  @static function initModule
    *  @param null
    */
    public function initModule()
    {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->dirname) {
            $this->module = $xoopsModule;
        } else {
            $hModule      = xoops_getHandler('module');
            $this->module = $hModule->getByDirname($this->dirname);
        }
        $this->addLog('INIT MODULE');
    }

    /*
    *  @static function initConfig
    *  @param null
    */
    public function initConfig()
    {
        $this->addLog('INIT CONFIG');
        $hModConfig   = xoops_getHandler('config');
        $this->config = $hModConfig->getConfigsByCat(0, $this->getModule()->getVar('mid'));
    }

    /*
    *  @static function initHandler
    *  @param string $name
    */
    public function initHandler($name)
    {
        $this->addLog('INIT ' . $name . ' HANDLER');
        $this->handler[$name . '_handler'] = xoops_getModuleHandler($name, $this->dirname);
    }

    /*
    *  @static function addLog
    *  @param $log
    */
    public function addLog($log)
    {
        if ($this->debug && is_object($GLOBALS['xoopsLogger'])) {
            $GLOBALS['xoopsLogger']->addExtra($this->module->name(), $log);
        }
    }
}
