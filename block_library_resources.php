<?php

class block_library_resources extends block_list {
    function init() {
        $this->title = get_string('pluginname', 'block_library_resources');
    }

    function get_content() {

        if ($this->content !== NULL) {
            return $this->content;
        }

        global $USER, $COURSE, $DB;

        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        if ($COURSE->id !== SITEID) {
            $dept = reset(explode('-', $COURSE->shortname));

            $params = array('dept_code' => $dept);

            $links = $DB->get_records('block_library_resources', $params);

            if ($links) {
                foreach ($links as $link) {
                    $html_link = html_writer::link($link->url, $link->link_name);
                    $this->content->items[] = $html_link;
                }
            } else {
                $default_url = get_string('default_link_url', 'block_library_resources');
                $default_name = get_string('default_link_name', 'block_library_resources');

                $html_link = html_writer::link($default_url, $default_name);
                $this->content->items[] = $html_link;
            }
        }

        $context = context_system::instance();

        if (is_siteadmin($USER->id) or has_capability('blocks/library_resources:manage', $context)) {
            $str = get_string('new', 'block_library_resources');
            $url = new moodle_url('/blocks/library_resources/create.php');

            $this->content->items[] = html_writer::link($url, $str);

            $str = get_string('manage', 'block_library_resources');
            $url = new moodle_url('/blocks/library_resources/manage.php');

            $this->content->items[] = html_writer::link($url, $str);
        }

        return $this->content;
    }
}
