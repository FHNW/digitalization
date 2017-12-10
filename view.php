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

    echo '
<table>
<thead>
<th><p style="text-align:left;">'. get_string('header_field_name', 'digitalization') .'</p></th>
<th><p style="text-align:left;">'. get_string('header_field_value', 'digitalization') .'</p></th>
</thead>
<tbody>
<tr>
<td><p>'. get_string('status', 'digitalization') .'</p></td>
<td><p>'. $digitalization->status .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('timecreated', 'digitalization') .'</p></td>
<td><p>'. date("d.m.Y H:i:s", $digitalization->timecreated) .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('ordered_by', 'digitalization') .'</p></td>
<td><p>'. $user_object->firstname . " " . $user_object->lastname .'</p></td>
</tr>
<tr>
<td><p>'. get_string('course', 'digitalization') .'</p></td>
<td><p>'. $course->fullname .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('digitalization_name', 'digitalization') .'</p></td>
<td><p>'. $digitalization->name .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('author', 'digitalization') .'</p></td>
<td><p>'. $digitalization->author .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('article_title', 'digitalization') .'</p></td>
<td><p>'. $digitalization->atitle .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('media_title', 'digitalization') .'</p></td>
<td><p>'. $digitalization->title .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('volume_issue', 'digitalization') .'</p></td>
<td><p>'. $digitalization->volume . ' (' . $digitalization->issue . ')</p></td>
</tr>
<tr>
<td><p>'. get_string('publication_date', 'digitalization') .'</p></td>
<td><p>'. $digitalization->pub_date .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('pages', 'digitalization') .'</p></td>
<td><p>'. $digitalization->pages .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('issn', 'digitalization') .'</p></td>
<td><p>'. $digitalization->issn .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('isbn', 'digitalization') .'</p></td>
<td><p>'. $digitalization->isbn .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('publisher', 'digitalization') .'</p></td>
<td><p>'. $digitalization->publisher .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('pagecount', 'digitalization') .'</p></td>
<td><p>'. $digitalization->pagecount .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('sign', 'digitalization') .'</p></td>
<td><p>'. $digitalization->sign .'</p></p></td>
</tr>
<tr>
<td><p>'. get_string('comment', 'digitalization') .'</p></td>
<td><p>'. $digitalization->dig_comment .'</p></p></td>
</tr>
</tbody>
</table>';


    // Finish the page
    echo $OUTPUT->footer();


}

?>
