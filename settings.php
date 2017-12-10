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
 * Library of interface functions and constants for module digitalization
 *
 * All the core Moodle functions, neeeded to allow the module to work
 * integrated in Moodle should be placed here.
 * All the digitalization specific functions, needed to implement all the module
 * logic, should go to locallib.php. This will help to save some memory when
 * Moodle is performing actions across all modules.
 *
 * @package   mod_digitalization
 * @copyright 2011 Patrick Meyer, Tobias Niedl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once($CFG->dirroot.'/mod/digitalization/lib.php');

    // FTP and storage settings
    $settings->add(new admin_setting_heading('digitalization_ftp_config', get_string('ftp_config', 'digitalization'), get_string('ftp_config_desc', 'digitalization')));

    $settings->add(new admin_setting_configcheckbox('digitalization_delete_files', get_string('delete_files', 'digitalization'),
			get_string('delete_files_desc', 'digitalization'), 1));

    $settings->add(new admin_setting_configselect('digitalization_use_ftp', get_string('ftps_config', 'digitalization'), get_string('ftps_config_desc',
            'digitalization'), 'ftp', array('ftp'=>'FTP', 'ftps'=>'FTPs', 'sftp'=>'PHP internal SFTP', 'sftplib' => 'SFTP with third party lib')));

    $settings->add(new admin_setting_configtext('digitalization_ftp_host', get_string('ftp_host', 'digitalization'),
			get_string('ftp_host_desc', 'digitalization'), 'localhost'));

    $settings->add(new admin_setting_configtext('digitalization_ftp_user', get_string('ftp_user', 'digitalization'),
			get_string('ftp_user_desc', 'digitalization'), 'user'));

    $settings->add(new admin_setting_configpasswordunmask('digitalization_ftp_pwd', get_string('ftp_pwd', 'digitalization'),
			get_string('ftp_pwd_desc', 'digitalization'), 'abc123'));

    $settings->add(new admin_setting_configtext('digitalization_ftp_dir', get_string('ftp_dir', 'digitalization'),
			get_string('ftp_dir_desc', 'digitalization'), 'mdocs/'));

    $settings->add(new admin_setting_configtext('digitalization_filearea', get_string('filearea', 'digitalization'),
			get_string('filearea_desc', 'digitalization'), 'content'));

    // Order mgmt and mail settings
    $settings->add(new admin_setting_heading('digitalization_mail_config', get_string('mail_config', 'digitalization'), get_string('mail_config_desc', 'digitalization')));

    $settings->add(new admin_setting_configtext('digitalization_opac_url', get_string('opac_url', 'digitalization'),
			get_string('opac_url_desc', 'digitalization'), 'http://recherche.nebis.ch/primo_library/libweb/action/search.do?mode=Basic&vid=NEBIS&tab=default_tab'));

    $settings->add(new admin_setting_configtext('digitalization_order_mail', get_string('order_mail', 'digitalization'),
			get_string('order_mail_desc', 'digitalization'), 'subito-test@dev.moodle.tum.de'));

    $settings->add(new admin_setting_configtext('digitalization_sender_sign', get_string('sender_sign', 'digitalization'),
			get_string('sender_sign_desc', 'digitalization'), 'TUM/MOODLE <noreply@moodle.tum.de>'));

    $settings->add(new admin_setting_configtext('digitalization_mail_subject', get_string('mail_subject', 'digitalization'),
			get_string('mail_subject_desc', 'digitalization'), 'Digitalization Order (TUM/MOODLE)'));


    // Information to user about delivered files
    $settings->add(new admin_setting_heading('digitalization_delivery_config', get_string('delivery_config', 'digitalization'), get_string('delivery_config_desc', 'digitalization')));

    $settings->add(new admin_setting_configcheckbox('digitalization_delivery_sendmail', get_string('delivery_send_mail', 'digitalization'),
			get_string('delivery_send_mail_desc', 'digitalization'), 1));

    $settings->add(new admin_setting_configcheckbox('digitalization_delivery_attach_details', get_string('delivery_email_attach_details', 'digitalization'),
			get_string('delivery_email_attach_details_desc', 'digitalization'), 1));

    $settings->add(new admin_setting_configtext('digitalization_delivery_sender_sign', get_string('delivery_email_sender', 'digitalization'),
			get_string('delivery_email_sender_desc', 'digitalization'), 'TUM/MOODLE <noreply@moodle.tum.de>'));


}
