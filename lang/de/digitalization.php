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
 * German strings for digitalization
 *
 *
 * @package   mod_digitalization
 * @copyright 2011 Patrick Meyer, Tobias Niedl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

//Common module fields
$string['modulename'] = 'Digit. Semesterapparat';
$string['modulenameplural'] = 'Digit. Semesterapparate';
$string['modulename_help'] = 'Bestellen Sie Digitalisate von Zeitschriftenaufsätzen oder Buchkapiteln aus dem Bestand der Universitätsbibliothek. <br>Recherchieren Sie komfortabel im Online-Katalog (OPAC) die Literaturangaben. 
Dort finden Sie unter \'Bestellen\' den digitalen Semesterapparat und werden via SFX zurück zu Ihrem Moodlekurs geleitet. <br>
Nach dem Speichern der Literaturangaben scannt die Universitätsbibliothek das Material für Sie. Die PDF-Datei wird automatisch nach wenigen Tagen in Moodle bereitgestellt. <br>
Weitere Hilfe finden Sie unter <a href="http://www.ub.tum.de/digisem" target="_blank">http://www.ub.tum.de/digisem</a>.';
$string['Digitalization'] = 'Digitalisierung';
$string['pluginadministration'] = 'Administration dig. Sem.Apparat';
$string['pluginname'] = 'Digitaler Semesterapparat';

//New digitalization activity
$string['name'] = 'Name';
$string['name_help'] = 'Geben Sie einen Namen für Ihre Bestellung ein. Für Studenten wird dieser Name als Dateiname des PDFs angezeigt. ';
$string['book_specifiers'] = 'Literaturangaben';

$string['import_from_opac'] = 'Daten aus dem OPAC importieren...';
$string['import_from_opac_help'] = 'Recherchieren Sie komfortabel im Online-Katalog (OPAC) die Literaturangaben. Dort finden Sie unter \'Bestellen\' den digitalen Semesterapparat und werden via SFX zurück zu Ihrem Moodlekurs geleitet.<br> 
Nach dem Speichern der Literaturangaben scannt die Universitätsbibliothek das Material für Sie. <br>
Die PDF-Datei wird automatisch nach wenigen Tagen in Moodle bereitgestellt. <br>
<a href="http://mediatum.ub.tum.de/node?id=1126134">eTutorial zum Digitalen Semesterapparat</a>. <br>
Weitere Hilfe finden Sie unter <a href="http://www.ub.tum.de/digisem" target="_blank">http://www.ub.tum.de/digisem</a>.';

$string['sign'] = 'Signatur';
$string['article_title'] = 'Titel des Kapitels/Aufsatzes';
$string['author'] = 'Autor';
$string['media_title'] = 'Titel des Buchs/der Zeitschrift';
$string['date'] = 'Erscheinungsjahr';
$string['volume'] = 'Band';
$string['issue'] = 'Heft';
$string['pages'] = 'Seiten';
$string['publisher'] = 'Verlag';
$string['pagecount'] = 'Seitenzahl';
$string['pages_help'] = 'Bitte beachten Sie, dass gemäß Par.52a UrhG nur kleinere Teile eines Werkes oder einzelne Aufsätze aus Zeitschriften bereitgestellt werden dürfen. <br>
Weitere Hilfe finden Sie unter <a href="http://www.ub.tum.de/digisem" target="_blank">http://www.ub.tum.de/digisem</a>.';
$string['comment'] = 'Kommentar';
$string['comment_help'] = 'Geben Sie zusätzliche Informationen zu Ihrer Bestellung ein, die für das Bibliothekspersonal bestimmt sind. ';

$string['header_field_name'] = 'Name';
$string['header_field_value'] = 'Wert';
$string['ordered_by'] = 'Besteller';
$string['course'] = 'Kurs';
$string['timecreated'] = 'Bestelldatum';
$string['status'] = 'Bestellstatus';
$string['isbn'] = 'ISBN';
$string['issn'] = 'ISSN';
$string['volume_issue'] = 'Band (Heft)';
$string['publication_date'] = 'Erscheinungsjahr';
$string['digitalization_name'] = 'Name';

$string['form_error'] = 'Sie müssen ein Medium aus dem Bibliothekskatalog importieren, aus dem Sie digitalisierte Auszüge bestellen möchten. Bitte klicken Sie im Browser auf \'Zurück\' und importieren Sie Medien-Daten aus dem OPAC der Bibliothek. ';

//View
$string['permission_error'] = 'Sie haben keine Zugriffsberechtigung für diese Seite! ';
$string['file_not_found_error'] = 'Die zur Digitalisierung gehörende Datei wurde nicht im Moodle-Dateisystem gefunden! ';

//Bridge
$string['bridge_title'] = 'Neuer Digitalisierungsauftrag';

$string['bridge_select_text'] = 'Bitte wählen Sie einen Kurs aus, zu dem Sie das bestellte Dokument hinzufügen möchten. ';
$string['bridge_submit'] = ' Weiter ';

$string['bridge_error_course_permission'] = 'Sie besitzten für keinen Kurs die nötigen Rechte zum editieren. ';

//Configuration
$string['ftp_config'] = 'FTP- und Dateikonfiguration';
$string['ftp_config_desc'] = 'Das Modul lädt fertige Digitalisierungen von einem FTP-Server herunter. Die Einstellungen für den FTP-Server können in den folgenden Feldern vorgenommen werden. ';
$string['delete_files'] = 'Dateien vom FTP-Server löschen';
$string['delete_files_desc'] = 'Nach dem Herunterladen der Dateien vom FTP-Server in das Moodle-Dateisystem können die Dateien auf dem FTP-Server gelöscht werden. ';
$string['ftps_config'] = 'FTPs nutzen';
$string['ftps_config_desc'] = 'Ist diese Option ausgewählt, wird eine sichere SSL-Verbindung mit dem Server aufgebaut. ';
$string['ftp_host'] = 'FTP Host';
$string['ftp_host_desc'] = '';
$string['ftp_user'] = 'FTP Benuzter';
$string['ftp_user_desc'] = '';
$string['ftp_pwd'] = 'FTP Passwort';
$string['ftp_pwd_desc'] = '';
$string['ftp_dir'] = 'FTP Verzeichnis';
$string['ftp_dir_desc'] = 'Insert the name of the directory from the root node of your login. E.g. when you login with the ftp credentials provided above you will possibly have a choice of directories to save into. Provide the desired path with a slash (/) at the end. Leave this field empty, if the base directory is used. ';
$string['ftp_dir_desc'] = 'Geben Sie das Root-Verzeichnis für den angegebenen Login-Namen auf dem FTP-Server ein. Pfadangaben müssen mit einem / enden. Lassen Sie das Feld leer, wenn das Basisverzeichnis auf dem FTP-Server genutzt werden soll. ';
$string['filearea'] = 'Verzeichnisbereich';
$string['filearea_desc'] = 'Moodle nutzt in seinem Dateisystem sog. Verzeichnisbereiche (engl. \'fileareas\'). Wenn Sie mit diesem Konzept vertraut sind, erzeugen Sie ein Verzeichnis modledata/temp im dem Moodle die heruntergeladenen Dateien temporär speichern kann. Lassen Sie das Feld im Zweifelsfall leer oder geben Sie \'content\' ein. ';

$string['mail_config'] = 'E-Mail- Bestelleinstellungen';
$string['mail_config_desc'] = 'Wenn ein Trainer einen Digitalisierungsauftrag für einen seiner Kurse erstellt, muss ein entsprechender Auftrag per E-Mail an die Bibliothek geschickt werden. ';
$string['order_mail'] = 'E-Mail-Adresse für Bestellungen';
$string['order_mail_desc'] = 'Geben Sie die Bibliotheks-Email-Adresse ein, an die die Bestellungen geschickt werden sollen. ';
$string['sender_sign'] = 'Absender der Bestell-E-Mails';
$string['sender_sign_desc'] = 'Dieser Name erscheint als Absender für Bestellungen aus dem Moodle-System. ';
$string['mail_subject'] = 'E-Mail Betreff';
$string['mail_subject_desc'] = 'Der eingegebene Text erscheint als Betreff in den Bestellungen aus dem Moodle-System. ';

$string['opac_url'] = 'OPAC URL';
$string['opac_url_desc'] = 'Trainer werden zu dieser URL weitergeleitet, wenn Sie Medien im Bibliotheksbestand recherchieren möchten. ';

$string['delivery_config'] = 'Medienlieferung';
$string['delivery_config_desc'] = '';
$string['delivery_send_mail'] = 'E-Mail an Benutzer senden';
$string['delivery_send_mail_desc'] = 'Benutzer per E-Mail benachrichtigen, wenn bestellte Medien geliefert wurden. ';
$string['delivery_email_sender'] = 'Absender der E-Mail';
$string['delivery_email_sender_desc'] = '';
$string['delivery_email_attach_details'] = 'Bestelldetails mitsenden';
$string['delivery_email_attach_details_desc'] = 'Details der Bestellung wie Name, Titel, Autor, etc. in der Benachrichtigung mitsenden.';

$string['delivery_email_subject'] = 'TUM/MOODLE: Digitalisierung abgeschlossen';
$string['delivery_email_body'] = 'Ihr Digitalisierungsauftrag wurde abgeschlossen und das bestellte Medium in Moodle eingebunden. ';

$string['view_error'] = "Dieses Dokument steht im Moment nicht zur Verf&uuml;gung. ";
$string['library_url'] = 'Bibliothek-URL';
$string['library_url_help'] = 'Vollständige URL des bestellten Werkes. Die Suchadresse: http://recherche.nebis.ch/primo_library/libweb/action/search.do?mode=Basic';
$string['load_order_info'] = 'Die Informationen laden';
$string['load_order_info_help'] = 'Die Informationen über das bestellte Werk laden';
$string['get_deliveries'] = 'Die DigiSem-Bestellungen überprüfen';
$string['library_search'] = 'Bibliothek durchsuchen';
$string['libraries_select'] = 'Wählen Sie Ihre Bibliothek';
$string['library'] = 'Bibliothek';
$string['failed_to_load_url'] = 'Kann die URL nicht laden {$a->url} (Status {$a->status}).';
?>
