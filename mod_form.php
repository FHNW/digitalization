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

    function definition()
    {

        global $PAGE, $COURSE;
        $mform =& $this->_form;

        //If user is coming back from selecting a media in InfoGuide,
        //store the media information in an seperate object ($media_data)
        $this->set_media_data();

        //Adding the "general" fieldset, where all the common settings are displayed
        $mform->addElement('header', 'general', get_string('general', 'form'));


        //Adding the standard "name" field
        $name_attributes = array('size' => '45');
        if (isset($_SESSION['dig_name']) && $_SESSION['dig_name'] != '') {
            $name_attributes['value'] = $_SESSION['dig_name'];
        } else {
            $name_attributes['value'] = '';
        }

        $mform->addElement('text', 'name', get_string('name', 'digitalization'), $name_attributes);


        $mform->setType('name', PARAM_TEXT);

        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'name', 'digitalization');

        //Frame for fields
        $mform->addElement('header', 'book_specifiers', get_string('book_specifiers', 'digitalization'));

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
            $PAGE->requires->js_call_amd('mod_digitalization/digitalization_form', 'init');
            $mform->addElement('text', 'library_url', get_string('library_url', 'digitalization'));
            $mform->addHelpButton('library_url', 'library_url', 'digitalization');
//            $mform->addRule('library_url', null, 'required', null, 'client');
            $mform->setType('library_url', PARAM_URL);

            $elementsArray = array();
            array_push($elementsArray, $mform->createElement('submit', 'load_order_info', get_string('load_order_info', 'digitalization')));
            $mform->addGroup($elementsArray, 'import_from_opac_group', '', array(' '), false);
            $mform->addHelpButton('import_from_opac_group', 'load_order_info', 'digitalization');

            $mform->addElement('submit', 'enter_manually', get_string('enter_manually', 'digitalization'));


        } else {


            /*
                 * If user was relocated to the form after selecting a book/journal in
             * InfoGuide, show the meta data of the ordered media (as static text).
             */

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

            // cleanup after rendering
            // digitalization_helper_clear_session();
        }

        //Add standard elements, common to all modules
        $this->standard_coursemodule_elements();

        /*
        $features = new stdClass;
        $features->groups = false;
        $features->groupings = true;
        $features->groupmembersonly = true;
        $this->standard_coursemodule_elements($features);
        */


        //Add standard buttons, common to all modules
        //$this->add_action_buttons(true, false, null);
        $this->add_action_buttons();

    }

    function validation($data, $files) {
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
        if (isset($_SESSION['dig_title']) || isset($_SESSION['dig_manually'])) {

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
        }
    }
}

?>
