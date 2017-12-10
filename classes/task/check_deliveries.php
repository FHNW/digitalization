<?php

namespace mod_digitalization\task;

global $CFG;
include_once($CFG->dirroot . '/mod/digitalization/lib.php');

class check_deliveries extends \core\task\scheduled_task {
    public function get_name() {
        // Shown in admin screens
        return get_string('get_deliveries', 'digitalization');
    }

    public function execute() {
        digitalization_check_delieveries();
    }
}
