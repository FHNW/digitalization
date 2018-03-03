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
 * The main digitalization configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package   mod_digitalization
 * @copyright 2011 Patrick Meyer, Tobias Niedl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

//Moodle uses HTML_QuickForm, see http://www.midnighthax.com/quickform.php

//error_reporting(E_ALL);
//ini_set('display_errors','On');

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->dirroot . '/mod/digitalization/lib.php');

class mod_digitalization_mod_form extends moodleform_mod
{

    private $media_data = null;

    // inidicates than the order data was already parsed
    private $done = false;

    private function render_name_field() {
        $mform =& $this->_form;

        //Adding the standard "name" field
        $name_attributes = array('size' => '45');
        if (isset($_SESSION['dig_name']) && $_SESSION['dig_name'] != '') {
            $name_attributes['value'] = $_SESSION['dig_name'];
        } else {
            $name_attributes['value'] = '';
        }
        $mform->addElement('text', 'name', get_string('name', 'digitalization'), $name_attributes);
        $mform->setType('name', PARAM_TEXT);
    }

    function definition()
    {

        global $PAGE, $DB, $USER;
        $mform =& $this->_form;

        // if the module is already created don't allow any editing
        if ($this->get_coursemodule() != null) {

            $this->render_name_field();
            $cm = $this->get_coursemodule();
            $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
            $digitalization = $DB->get_record('digitalization', array('id' => $cm->instance), '*', MUST_EXIST);
            $user_object = $DB->get_record('user', array('id' => $USER->id));
            $mform->addElement('header', 'book_specifieers', get_string('book_specifiers', 'digitalization'));
            $mform->addElement('html', digitalization_helper_render_information($digitalization, $course, $user_object));


            //Add standard elements, common to all modules
            $this->standard_coursemodule_elements();

            //Add standard buttons, common to all modules
            $this->add_action_buttons();
        } else {

            $PAGE->requires->js_call_amd('mod_digitalization/digitalization_form', 'init');

            //Adding the "general" fieldset, where all the common settings are displayed
            $mform->addElement('header', 'general', get_string('general', 'form'));

            $this->render_name_field();



            $mform->addRule('name', null, 'required', null, 'client');
            $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
            $mform->addHelpButton('name', 'name', 'digitalization');


            // library
            $mform->addElement('select', 'library', get_string('libraries_select', 'digitalization'), get_libraries());
            $mform->addRule('library', null, 'required', null, 'client');
            if (isset($_SESSION['dig_library']) && ($_SESSION['dig_library'] != null)) {
                $mform->setDefault('library', $_SESSION['dig_library']);
            }


            $this->set_media_data();
            if ($this->media_data == null) {

                /*
                     * If the has not imported any media data, we display the import button.
                 */


                //As the SUBMIT-element does not support adding a help button, we pack the button into a element group
                //and add the help button to the group.
                $library_url_field = $mform->createElement('text', 'library_url', get_string('library_url', 'digitalization'));
                if (isset($_SESSION['dig_library_url'])) {
                    $mform->setDefault('library_url', $_SESSION['dig_library_url']);
                }
                $mform->setType('library_url', PARAM_URL);
                if (isset($_SESSION['dig_errors']) && $_SESSION['dig_errors'] != false) {
                    $mform->addElement('html',
                    '<div class="felement ftext error"><span ' . 'class="error" tabindex="0">' . $_SESSION['dig_errors'] .'</span></div>');
                }

                $elementsArray = array();
                array_push($elementsArray, $library_url_field);
                array_push($elementsArray, $mform->createElement('submit', 'load_order_info', get_string('load_order_info', 'digitalization')));
                $mform->addGroup($elementsArray, 'import_from_opac_group', '', array(' '), false);
                $mform->addHelpButton('import_from_opac_group', 'import_from_opac_group', 'digitalization');

                $mform->addElement('submit', 'enter_manually', get_string('enter_manually', 'digitalization'));


            } else {

                //Author
                $mform->addElement('text', 'author', get_string('author', 'digitalization'));
                $mform->setDefault('author', $this->media_data->author);
                $mform->addRule('author', null, 'required', null, 'client');
                $mform->setType('author', PARAM_NOTAGS);

                //Title of chapter/article
                $mform->addElement('text', 'atitle', get_string('article_title', 'digitalization'));
                $mform->setDefault('atitle', $this->media_data->atitle);
                $mform->addRule('atitle', null, 'required', null, 'client');
                $mform->setType('atitle', PARAM_NOTAGS);

                //Title of book/journal
                $mform->addElement('text', 'title', get_string('media_title', 'digitalization'));
                $mform->setDefault('title', $this->media_data->title);
                $mform->addRule('title', null, 'required', null, 'client');
                $mform->setType('title', PARAM_NOTAGS);

                //Publication date
                $mform->addElement('text', 'pub_date', get_string('date', 'digitalization'));
                $mform->addRule('pub_date', null, 'required', null, 'client');
                $mform->setDefault('pub_date', $this->media_data->date);
                $mform->setType('pub_date', PARAM_NOTAGS);


                //Pages
                $pages_attributes = array('size' => '45');
                $mform->addElement('text', 'pages', get_string('pages', 'digitalization'), $pages_attributes);

                $mform->addRule('pages', null, 'required', null, 'client');
                $mform->addRule('pages', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
                $mform->addHelpButton('pages', 'pages', 'digitalization');
                $mform->setType('pages', PARAM_NOTAGS);


                $mform->addElement('text', 'identifier', 'ISBN / ISSN', array('size' => 45));
                $mform->setDefault('identifier', $this->media_data->identifier);
                $mform->setType('identifier', PARAM_NOTAGS);

                // Publisher
                $mform->addElement('text', 'publisher', get_string('publisher', 'digitalization'));
                $mform->setDefault('publisher', $this->media_data->publisher);
                $mform->setType('publisher', PARAM_NOTAGS);
                //Comment
                $comment_attributes = array('size' => '45');
                $mform->addElement('text', 'dig_comment', get_string('comment', 'digitalization'), $comment_attributes);

                $mform->addRule('dig_comment', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
                $mform->addHelpButton('dig_comment', 'comment', 'digitalization');
                $mform->setType('dig_comment', PARAM_TEXT);

                $mform->addElement('submit', 'back_to_automatic', get_string('back_to_automatic', 'digitalization'));
            }

            //Add standard elements, common to all modules
            $this->standard_coursemodule_elements();

            //Add standard buttons, common to all modules
            $this->add_action_buttons(true, false, get_string('send_order', 'digitalization'));
        }


    }

    function validation($data, $files)
    {
        $errors = array();
        if (array_key_exists('library_url', $data) && ($data['library_url'] == "") && !array_key_exists('enter_manually', $data)) {
            $errors['library_url'] = get_string('library_url_or_manually', 'digitalization');
        }
        return $errors;
    }

    function is_cancelled()
    {
        $isCanceled = parent::is_cancelled();
        if ($isCanceled) {
            digitalization_helper_clear_session();
        }
        return $isCanceled;
    }


    private function set_media_data()
    {

        //If user is coming back from selecting a media in InfoGuide, create an
        //object holding all the information of the selected media
        if (isset($_SESSION['dig_title']) || (isset($_SESSION['dig_manually']) && $_SESSION['dig_manually'] == 1)) {

            $this->media_data = new stdClass();

            // library
            if (isset($_SESSION['dig_library']) && ($_SESSION['dig_library'] != '')) {
                $this->media_data->library = $_SESSION['dig_library'];
            } else {
                $this->media_data->library = '';
            }
            //Signature
            if (isset($_SESSION['dig_sign']) && $_SESSION['dig_sign'] != '') {
                $this->media_data->sign = $_SESSION['dig_sign'];
            } else {
                $this->media_data->sign = '';
            }

            //Title of book/journal
            if (isset($_SESSION['dig_title']) && $_SESSION['dig_title'] != '') {
                $this->media_data->title = $_SESSION['dig_title'];
            } else {
                $this->media_data->title = '';
            }

            //Title of chapter/article
            if (isset($_SESSION['dig_atitle']) && $_SESSION['dig_atitle'] != '') {
                $this->media_data->atitle = $_SESSION['dig_atitle'];
            } else {
                $this->media_data->atitle = '';
            }
            if (isset($_SESSION['dig_author'])) {
                $this->media_data->author = $_SESSION['dig_author'];
            } else {
                $this->media_data->author = '';
            }

            //Publishing date
            if (isset($_SESSION['dig_date']) && $_SESSION['dig_date'] != '') {
                $this->media_data->date = $_SESSION['dig_date'];
            } else {
                $this->media_data->date = '';
            }

            // Publisher
            if (isset($_SESSION['dig_publisher']) && $_SESSION['dig_publisher'] != '') {
                $this->media_data->publisher = $_SESSION['dig_publisher'];
            } else {
                $this->media_data->publisher = '';
            }

            // identifier
            if (isset($_SESSION['dig_identifier']) && $_SESSION['dig_identifier'] != '') {
                $this->media_data->identifier = $_SESSION['dig_identifier'];
            } else {
                $this->media_data->identifier = '';
            }

            // library url
            if (isset($_SESSION['dig_library_url']) && $_SESSION['dig_library_url'] != '') {
                $this->media_data->library_url = $_SESSION['dig_library_url'];
            } else {
                $this->media_data->library_url = '';
            }
        }
    }
}

?>
