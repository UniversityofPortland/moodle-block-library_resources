<?php

require_once '../../config.php';

require_login();

$_s = function($key, $a = null) {
    return get_string($key, 'block_library_resources', $a);
};

$flash = optional_param('flash', 0, PARAM_INT);

$blockname= $_s('pluginname');
$header = $_s('manage');

$PAGE->set_context(context_system::instance());
$PAGE->set_heading($blockname . ': ' . $header);
$PAGE->navbar->add($blockname);
$PAGE->navbar->add($header);
$PAGE->set_title($header);
$PAGE->set_url('/blocks/library_resources/manage.php');

echo $OUTPUT->header();
echo $OUTPUT->heading($header);

$links = $DB->get_records('block_library_resources', null, 'dept_code ASC');

$url = new moodle_url('/blocks/library_resources/create.php');

if (empty($links)) {
    echo $OUTPUT->notification($_s('no_links'));
    echo $OUTPUT->continue_button($url);
    echo $OUTPUT->footer();
    die();
}

if ($flash) {
    echo $OUTPUT->notification(get_string('changessaved'), 'notifysuccess');
}

$create_link = html_writer::link($url, $_s('new'));

echo '<div class="lr-center-link">';
echo html_writer::tag('div', $create_link, array('class' => 'center_link'));
echo '</div>';

echo '<br />';

$table = new html_table();
$table->head = array(
    $_s('dept_code'),
    $_s('link_name'),
    $_s('url'),
    get_string('action')
);

$data = array();

$edit_icon = $OUTPUT->pix_icon('t/edit', get_string('edit'));
$delete_icon = $OUTPUT->pix_icon('t/delete', get_string('delete'));

foreach ($links as $link) {
    $url = html_writer::link($link->url, $link->url);

    $params = array('id' => $link->id);

    $edit_url = new moodle_url('/blocks/library_resources/create.php', $params);
    $delete_url = new moodle_url('/blocks/library_resources/delete.php', $params);

    $edit = html_writer::link($edit_url, $edit_icon);
    $delete = html_writer::link($delete_url, $delete_icon);

    $actions = implode(' ', array($edit, $delete));

    $line = array($link->dept_code, $link->link_name, $url, $actions);

    $data[] = new html_table_row($line);
}

$table->data = $data;

echo '<div class="lr-center-table">';
echo html_writer::table($table);
echo '</div>';

echo $OUTPUT->footer();
