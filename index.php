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
 *
 * @package   mod_digitalization
 * @copyright 2011 Patrick Meyer, Tobias Niedl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

/// Replace digitalization with the name of your module and remove this line

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = required_param('id', PARAM_INT);   // course

if (! $course = $DB->get_record('course', array('id' => $id))) {
    error('Course ID is incorrect');
}

require_course_login($course);

$event = \mod_digitalization\event\course_module_instance_list_viewed::create(array(
    'context' => context_course::instance($course->id)
));
$event->trigger();

/// Print the header

$PAGE->set_url('/mod/digitalization/view.php', array('id' => $id));
$PAGE->set_title($course->fullname);
$PAGE->set_heading($course->shortname);

echo $OUTPUT->header();

/// Get all the appropriate data

if (! $digitalizations = get_all_instances_in_course('digitalization', $course)) {
    echo $OUTPUT->heading(get_string('no_digitalization', 'digitalization'), 2);
    echo $OUTPUT->continue_button("view.php?id=$course->id");
    echo $OUTPUT->footer();
    die();
}

/// Print the list of instances (your module will probably extend this)

$timenow  = time();
$strname  = get_string('name');
$strweek  = get_string('week');
$strtopic = get_string('topic');

if ($course->format == 'weeks') {
    $table->head  = array ($strweek, $strname);
    $table->align = array ('center', 'left');
} else if ($course->format == 'topics') {
    $table->head  = array ($strtopic, $strname);
    $table->align = array ('center', 'left', 'left', 'left');
} else {
    $table->head  = array ($strname);
    $table->align = array ('left', 'left', 'left');
}

foreach ($digitalizations as $digitalization) {
    if (!$digitalization->visible) {
        //Show dimmed if the mod is hidden
        $link = '<a class="dimmed" href="view.php?id='.$digitalization->coursemodule.'">'.format_string($digitalization->name).'</a>';
    } else {
        //Show normal if the mod is visible
        $link = '<a href="view.php?id='.$digitalization->coursemodule.'">'.format_string($digitalization->name).'</a>';
    }

    if ($course->format == 'weeks' or $course->format == 'topics') {
        $table->data[] = array ($digitalization->section, $link);
    } else {
        $table->data[] = array ($link);
    }
}

echo $OUTPUT->heading(get_string('modulenameplural', 'digitalization'), 2);
print_table($table);

/// Finish the page

echo $OUTPUT->footer();
