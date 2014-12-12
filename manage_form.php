<?php

require_once $CFG->libdir . '/formslib.php';

class library_resource_manage_form extends moodleform {
    function definition() {
        $m =& $this->_form;

        $_s = function($key, $a = null) {
            return get_string($key, 'block_library_resources', $a);
        };

        $m->addElement('text', 'dept_code', $_s('dept_code'));
        $m->setType('dept_code', PARAM_RAW);
        $m->addElement('text', 'link_name', $_s('link_name'));
        $m->setType('link_name', PARAM_RAW);
        $m->addElement('text', 'url', $_s('url'));
        $m->setType('url', PARAM_RAW);

        $m->addElement('hidden', 'id', $this->_customdata['id']);
        $m->setType('id', PARAM_RAW);

        $buttons = array(
            $m->createElement('submit', 'save', get_string('savechanges')),
            $m->createElement('cancel')
        );

        $m->addGroup($buttons, 'buttons', '', array(' '), false);
    }
}
