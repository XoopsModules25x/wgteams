<?php

namespace XoopsModules\Wgteams;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Goffy - XOOPS Development Team
 */
//\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Modulemenu
 */
class Modulemenu
{

    /** function to create an array for XOOPS main menu
     *
     * @param bool $includeUrl
     * @return array
     */
    public function getMenuitemsDefault($includeUrl = false)
    {

        $moduleDirName = \basename(\dirname(__DIR__));
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';

        $urlModule = '';
        if ($includeUrl) {
            $urlModule = \XOOPS_URL . '/modules/' . $moduleDirName . '/';
        }

        require_once $pathname . 'include/common.php';

        // start creation of link list as array
        $items = [];
        //    $teamsHandler =  $helper->getHandler('TeamsHandler');
        $db           = \XoopsDatabaseFactory::getDatabaseConnection();
        $teamsHandler = new \XoopsModules\Wgteams\TeamsHandler($db);

        $crit_teams = new \CriteriaCompo();
        $crit_teams->add(new \Criteria('team_online', '1'));
        $crit_teams->setSort('team_weight');
        $crit_teams->setOrder('ASC');

        $teamsAll = $teamsHandler->getAll($crit_teams);
        foreach (\array_keys($teamsAll) as $i) {
            $items[] = [
                'name' => $teamsAll[$i]->getVar('team_name'),
                'url'  => $urlModule . 'index.php?team_id=' . $teamsAll[$i]->getVar('team_id'),
            ];
        }
        // end creation of link list as array

        return $items;
    }

    /** function to create a list of nested sublinks
     *
     * @return array
     */
    public function getMenuitemsSbadmin5()
    {
        return $this->getMenuitemsDefault(true);
    }


}
