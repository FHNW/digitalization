<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * This file keeps track of upgrades to the digitalization module
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package   mod_digitalization
 * @copyright 2011 Patrick Meyer, Tobias Niedl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * xmldb_newmodule_upgrade
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_digitalization_upgrade($oldversion)
{

    global $DB;

    $dbman = $DB->get_manager(); // loads ddl manager and xmldb classes

/// And upgrade begins here. For each one, you'll need one
/// block of code similar to the next one. Please, delete
/// this comment lines once this file start handling proper
/// upgrade code.

/// if ($oldversion < YYYYMMDD00) { //New version in version.php
///
/// }

/// Lines below (this included)  MUST BE DELETED once you get the first version
/// of your module ready to be installed. They are here only
/// for demonstrative purposes and to show how the newmodule
/// iself has been upgraded.

/// For each upgrade block, the file newmodule/version.php
/// needs to be updated . Such change allows Moodle to know
/// that this file has to be processed.

/// To know more about how to write correct DB upgrade scripts it's
/// highly recommended to read information available at:
///   http://docs.moodle.org/en/Development:XMLDB_Documentation
/// and to play with the XMLDB Editor (in the admin menu) and its
/// PHP generation posibilities.

    if ($oldversion < 2011082400) {
        // nothing to do
    }

    if ($oldversion < 2017072700) {
        $table = new xmldb_table('digitalization');
        $publisher = new xmldb_field('publisher', XMLDB_TYPE_CHAR, '255', null, null, null, null, 'pages');
        $pagecount = new xmldb_field('pagecount', XMLDB_TYPE_CHAR, '16', null, null, null, null, 'publisher');
        if (!$dbman->field_exists($table, $publisher)) {
            $dbman->add_field($table, $publisher);
        }
        if (!$dbman->field_exists($table, $pagecount)) {
            $dbman->add_field($table, $pagecount);
        }
        upgrade_mod_savepoint(true, 2017072702, 'digitalization');
    }

    if ($oldversion < 2018012802) {
        $table = new xmldb_table('digitalization');
        $atitle = new xmldb_field('atitle', XMLDB_TYPE_TEXT, '1024', null, null, null, null);
        $title = new xmldb_field('title', XMLDB_TYPE_TEXT, '1024', null, null, null, null);
        $author = new xmldb_field('author', XMLDB_TYPE_TEXT, '1024', null, null, null, null);
        $publisher = new xmldb_field('publisher', XMLDB_TYPE_TEXT, '1024', null, null, null, null);
        $dbman->change_field_type($table, $atitle);
        $dbman->change_field_type($table, $title);
        $dbman->change_field_type($table, $author);
        $dbman->change_field_type($table, $publisher);

        upgrade_mod_savepoint(true, 2018012802, 'digitalization');
    }

    if ($oldversion < 2018012806) {
        $table = new xmldb_table('digitalization');
        $library_url = new xmldb_field('library_url', XMLDB_TYPE_TEXT, '1024', null, null, null, null);
        if (!$dbman->field_exists($table, $library_url)) {
            $dbman->add_field($table, $library_url);
        }
        upgrade_mod_savepoint(true, 2018012806, 'digitalization');
    }

    if ($oldversion < 2018041703) {
        $table = new xmldb_table('digitalization');
        $description = new xmldb_field('description', XMLDB_TYPE_TEXT, '1024', null, null, null, null, 'dig_comment');
        if (!$dbman->field_exists($table, $description)) {
            $dbman->add_field($table, $description);
        }
        upgrade_mod_savepoint(true, 2018041703, 'digitalization');
    }

    if ($oldversion < 2018041704) {
        $table = new xmldb_table('digitalization');
        $library = new xmldb_field('library', XMLDB_TYPE_TEXT, '1024', null, null, null, null, null);

        $dbman->change_field_type($table, $library);
        upgrade_mod_savepoint(true, 2018041704, 'digitalization');
    }

    if ($oldversion < 2018041705) {
        $table = new xmldb_table('digitalization');
        $identifier = new xmldb_field('identifier', XMLDB_TYPE_CHAR, '50', null, null, null, null, null);

        if (!$dbman->field_exists($table, $identifier)) {
            $dbman->add_field($table, $identifier);
        }
        upgrade_mod_savepoint(true, 2018041705, 'digitalization');
    }

    if ($oldversion < 2018051600) {
        $table = new xmldb_table('digitalization');
        $library_url = new xmldb_field('library_url', XMLDB_TYPE_TEXT, '1024', null, null, null, null);
        $dbman->change_field_type($table, $library_url);

        upgrade_mod_savepoint(true, 2018051600, 'digitalization');
    }

    return true;
}

?>
