<?php
/*
 *
 * OGP - Open Game Panel
 * Copyright (C) Copyright (C) 2008 - 2013 The OGP Development Team
 *
 * http://www.opengamepanel.org/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

function exec_ogp_module()
{
    global $db;

    print "<h2>".get_lang('modules')."</h2>";
    print '<a href="?m=modulemanager&amp;p=update">'.get_lang('update_modules').'</a>';

    $modules = $db->getInstalledModules();

    if ( $modules === FALSE )
    {
        print_failure(get_lang('no_installed_modules'));
        return;
    }

    print "<p class='note'>".get_lang("not_complete")."</p>";

    print "<table class='center'><tr class='first_row'><td>".get_lang('module_id')."</td>
        <td>".get_lang('module_name')."</td><td>".get_lang('module_folder')."</td>
        <td>".get_lang('module_version')."</td><td>".get_lang('db_version')."</td>
        <td></td></tr>";

    require_once('modules/modulemanager/module_handling.php');

    $installed_modules = array();

    $i = 0;
    foreach ( $modules as $row )
    {
        print "<tr class='tr".($i++%2)."'><td>".$row['id']."</td>";
        print "<td>".$row['title']."</td><td>".$row['folder']."</td><td>".$row['version']."</td><td>".$row['db_version']."</td>";
        print "<td><a href='?m=modulemanager&amp;p=del&amp;id=".$row['id']."&amp;module=".$row['folder']."'>";
        print get_lang('delete')."</a></td></tr>\n";
        array_push( $installed_modules, $row['folder'] );
    }
    print "</table>";

    $not_installed = array_diff( list_available_modules(), $installed_modules );

    if ( empty($not_installed) )
        return;

    print "<h3>".get_lang('modules_available_for_install')."</h3>";

    echo "<table class='center'><tr class='first_row'><td>".get_lang('module_folder')."</td><td></td></tr>";
    foreach ( $not_installed as $available_module )
    {
        echo "<tr><td>".$available_module."</td><td>";
        echo "<a href='?m=modulemanager&amp;p=add&amp;module=".$available_module."'>";
        echo get_lang('install')."</a></td></tr>";
    }
    echo "</table>";
}
?>
