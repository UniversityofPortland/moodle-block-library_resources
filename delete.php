<?php

require_once '../../config.php';

require_login();

$_s = function($key, $a = null) {
    return get_string($key, 'block_library_resources', $a);
};

$id = required_param('id', PARAM_INT);

if (!$link = $DB->get_record('block_library_resources', array('id' => $id))) {
    print_error('no_link', 'block_library_resources', '', $id);
}

$confirm = optional_param('confirm', 0, PARAM_INT);

$blockname= $_s('pluginname');
$header = get_string('delete');

$PAGE->set_context(context_system::instance());
$PAGE->set_heading($blockname . ': ' . $header);
$PAGE->navbar->add($blockname);
$PAGE->navbar->add($header);
$PAGE->set_title($header);
$PAGE->set_url('/blocks/library_resources/delete.php');

if ($confirm) {
    $success = $DB->delete_records('block_library_resources', array('id' => $id));

    if ($success) {
        $param = array('flash' => 1);
        $url = new moodle_url('/blocks/library_resources/manage.php', $param);
        redirect($url);
    }

    print_error('no_delete', 'block_library_resources', '', $id);
}

echo $OUTPUT->header();
echo $OUTPUT->heading($header);

$confirm_url = new moodle_url('delete.php', array('id' => $id, 'confirm' => 1));

$cancel_url = new moodle_url('manage.php');

echo $OUTPUT->confirm($_s('are_you_sure', $link), $confirm_url, $cancel_url);

echo $OUTPUT->footer();
