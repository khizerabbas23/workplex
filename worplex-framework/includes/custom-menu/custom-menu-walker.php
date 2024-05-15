<?php

defined('ABSPATH') || exit;

class worplex_theme_menu_walker extends Walker_Nav_Menu
{
    private $CurrentItem;
    public $parent_menu_item_id = 0;
    function start_lvl(&$output, $depth = 0, $args = array(), $id = 0)
    {

        $parent_id = $this->CurrentItem->menu_item_parent;
        $parent_nav_mega = get_post_meta($parent_id, '_menu_item_megamenu', true);
        $this_nav_mega = get_post_meta($this->parent_menu_item_id, '_menu_item_megamenu', true);

        $output .= '<ul class="sub-menu nav-dropdown nav-submenu">';
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $parent_id = $this->CurrentItem->menu_item_parent;
        $parent_nav_mega = get_post_meta($parent_id, '_menu_item_megamenu', true);
        $this_nav_mega = get_post_meta($this->parent_menu_item_id, '_menu_item_megamenu', true);

        $output .= '</ul>';
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0)
    {
        global $wp_query;
        $this->CurrentItem = $item;
        if ($depth == 0) {
            $this->parent_menu_item_id = $item->ID;
        }
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        if (empty($args)) {
            $args = new stdClass();
        }

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
        $class_names = ' class="' . esc_attr($class_names) . '"';

        $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';

        $menu_icon_tag  = !empty($item->menu_icon) ? '<i class="' . esc_attr($item->menu_icon) . '"></i>' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $menu_icon_tag . $args->link_before . apply_filters('the_title', $item->title, $item->ID);
        $item_output .= $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args = '', &$output = '')
    {
        $id_field = $this->db_fields['id'];
        if (is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        }
        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}
