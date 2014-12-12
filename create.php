<?php

require_once '../../config.php';
require_once 'manage_form.php';

require_login();

$id = optional_param('id', null, PARAM_INT);

$_s = function($key, $a = null) {
    return get_string($key, 'block_library_resources', $a);
};

$blockname= $_s('pluginname');
$header = $_s('create');

$PAGE->set_context(context_system::instance());
$PAGE->set_heading($blockname . ': ' . $header);
$PAGE->navbar->add($blockname);
$PAGE->navbar->add($header);
$PAGE->set_title($header);
$PAGE->set_url('/blocks/library_resources/create.php');

$form = new library_resource_manage_form(null, array('id' => $id));

if ($form->is_cancelled()) {
    redirect(new moodle_url('/my'));
} else if ($link = $form->get_data()) {

    if (empty($link->id)) {
        $id = $DB->insert_record('block_library_resources', $link, true);
    } else {
        $DB->update_record('block_library_resources', $link);
        $id = $link->id;
    }

    $params = array('flash' => 1);
    $url = new moodle_url('/blocks/library_resources/manage.php', $params);

    redirect($url);
}

if (!empty($id)) {
    $link = $DB->get_record('block_library_resources', array('id' => $id));
    $form->set_data($link);
}

echo $OUTPUT->header();
echo $OUTPUT->heading($header);

$form->display();

echo $OUTPUT->footer();
