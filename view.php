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

/// (Replace digitalization with the name of your module and remove this line)

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$filearea = $CFG->digitalization_filearea;
$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // digitalization instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('digitalization', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $digitalization  = $DB->get_record('digitalization', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $digitalization  = $DB->get_record('digitalization', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $digitalization->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('digitalization', $digitalization->id, $course->id, false, MUST_EXIST);
} else {
    print_error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$context = context_module::instance($cm->id);

$event = \mod_digitalization\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->trigger();

/**
 * Case distinction: Either the DB record status is set to "delivered", then we forward the user to the file. This is done for everyone - group???
 * Otherwise we provide information about the order to managers of the course only.
 */

// Case 1: Record status set to "delivered" - redirect to pluginfile.php
if($digitalization->status === 'delivered')  {

    // Copied from mod/resource/view.php
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'mod_digitalization', $filearea, $digitalization->id, 'sortorder DESC, id ASC', false);
    if (count($files) < 1) {
	// TODO: Error message related to resource_print_filenotfound($resource, $cm, $course)
        print_error(get_string('file_not_found_error', 'digitalization'));
        die();
    } else {
        $file = reset($files);
        unset($files);
    }

    $filearea_slashed = ($filearea) ? $filearea . '/' : '';
    $path = '/'.$context->id.'/mod_digitalization/'.$filearea.$file->get_filepath().$file->get_filename();

    $fullurl = file_encode_url($CFG->wwwroot.'/pluginfile.php', $path, false);
    redirect($fullurl);


} else {

    // Case 2: Show the details of the order
    $PAGE->set_url('/mod/digitalization/view.php', array('id' => $cm->id));
    $PAGE->set_title($digitalization->name);
    $PAGE->set_heading($course->shortname);

    // Check user access priviledges for this level
    if(!has_capability('moodle/course:update', $context))
	print_error(get_string('view_error', 'digitalization'));


    // Output starts here
    echo $OUTPUT->header();

    echo $OUTPUT->heading($digitalization->name);

    $user_object = $DB->get_record('user', array('id' => $digitalization->userid));

    echo digitalization_helper_render_information($digitalization, $course, $user_object);

    // Finish the page
    echo $OUTPUT->footer();


}

?>
