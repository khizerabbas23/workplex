<?php

namespace WorplexElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if (!defined('ABSPATH')) exit;


/**
 * @since 1.1.0
 */
class SectionHeading extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'section-heading';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Section Heading', 'worplex-frame');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fa fa-heading';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['worplex'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function register_controls()
    {

        global $rand_num;
        $rand_num = rand(10000000, 99909999);
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Section Heading Settings', 'worplex-frame'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'view',
            [
                'label' => __('Style', 'worplex-frame'),
                'type' => Controls_Manager::SELECT2,
                'default' => 'view1',
                'options' => [
                    'view1' => __('Style 1', 'worplex-frame'),
                    'view2' => __('Style 2', 'worplex-frame'),
                    'view3' => __('Style 3', 'worplex-frame'),
                    'view4' => __('Style 4', 'worplex-frame'),
                    'view5' => __('Style 5', 'worplex-frame'),
                    'view6' => __('Style 6', 'worplex-frame'),
                    'view7' => __('Style 7', 'worplex-frame'),
                    'view8' => __('Style 8', 'worplex-frame'),
                    'view9' => __('Style 9', 'worplex-frame'),
                    'view10' => __('Style 10', 'worplex-frame'),
                    'view11' => __('Style 11', 'worplex-frame'),
                    'view12' => __('Style 12', 'worplex-frame'),
                    'view13' => __('Style 13', 'worplex-frame'),
                    'view14' => __('Style 14', 'worplex-frame'),
                    'view15' => __('Style 15', 'worplex-frame'),
                    'view16' => __('Style 16', 'worplex-frame'),
                    'view17' => __('Style 17', 'worplex-frame'),
                    'view18' => __('Style 18', 'worplex-frame'),
                ],
            ]
        );
        $this->add_control(
            's_title',
            [
                'label' => __('Small Title', 'worplex-frame'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'view' => ['view6','view18']
                ],
            ]
        );
        $this->add_control(
            'heading_img',
            [
                'label' => __('Image', 'worplex-frame'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'view' => array('view8', 'view15')
                ],
            ]
        );
        $this->add_control(
            'h_title',
            [
                'label' => __('Title', 'worplex-frame'),
                'type' => Controls_Manager::TEXT,

            ]
        );
        $this->add_control(
            'num_title',
            [
                'label' => __('Title Number', 'worplex-frame'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'view' => 'view6'
                ],
            ]
        );
        $this->add_control(
            'h_fancy_title',
            [
                'label' => __('Fancy Title', 'worplex-frame'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'view' => array('view1', 'view2', 'view3', 'view4', 'view5')
                ],
            ]
        );

        $this->add_control(
            'hc_icon',
            [
                'label' => __('Icon', 'worplex-frame'),
                'type' => Controls_Manager::ICONS,
                'description' => __("This will apply to heading style 3 only.", "worplex-frame"),
                'condition' => [
                    'view' => array('view1', 'view2', 'view3', 'view4', 'view5')
                ],
            ]
        );
        $this->add_control(
            'h_desc',
            [
                'label' => __('Description', 'worplex-frame'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label' => __('Text Align', 'worplex-frame'),
                'type' => Controls_Manager::SELECT2,
                'default' => 'center',
                'options' => [
                    'center' => __('Center', 'worplex-frame'),
                    'left' => __('Left', 'worplex-frame'),

                ],
                'condition' => [
                    'view' => array('view7', 'view8', 'view17','view18')
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Heading Style', 'worplex-frame'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'hc_title',
            [
                'label' => __('Color Title', 'worplex-frame'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'view' => array('view1', 'view2', 'view3', 'view4', 'view5')
                ],
            ]
        );
        $this->add_control(
            's_title_clr',
            [
                'label' => __('Choose Small Title Color', 'worplex-frame'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'view' => ['view6','view18']
                ],
            ]
        );
        $this->add_control(
            'hc_title_clr',
            [
                'label' => __('Choose Title Color', 'worplex-frame'),
                'type' => Controls_Manager::COLOR,
                'description' => __("This Color will apply to 'Color Title'.", "worplex-frame"),

            ]
        );
        $this->add_control(
            'desc_clr',
            [
                'label' => __('Choose Description Color', 'worplex-frame'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'view' => 'view6'
                ],
            ]
        );
        $this->add_control(
            'proc_num_clr',
            [
                'label' => __('Choose Process Number Color', 'worplex-frame'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'view' => 'view6'
                ],
            ]
        );
        $this->add_control(
            'hc_dcolor',
            [
                'label' => __('Description Color', 'worplex-frame'),
                'type' => Controls_Manager::COLOR,
                'description' => __("This will apply to the description only.", "worplex-frame"),

            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {
        global $random_id;
        $atts = $this->get_settings_for_display();
        extract(shortcode_atts(array(
            'view' => '',
            'h_fancy_title' => '',
            'h_title' => '',
            'hc_title' => '',
            'hc_title_clr' => '',
            'hc_icon' => '',
            'h_desc' => '',
            'hc_dcolor' => '',
            's_title' => '',
            'num_title' => '',
            's_title_clr' => '',
            'desc_clr' => '',
            'proc_num_clr' => '',
            'css' => '',
            'heading_img' => '',
            'text_align' => '',
        ), $atts));


        $text_align = $atts['text_align'];
        ob_start();

        $design_css_class = '';

        $title_colr_style = '';
        if ($hc_title_clr != '') {
            $title_colr_style = ' style="color: ' . $hc_title_clr . ';"';
        }
        $random_id = rand();
        $desc_colr_style = '';
        if ($hc_dcolor != '') {
            $desc_colr_style = ' style="color: ' . $hc_dcolor . ';"';
        }

        $hdng_con = 'section';
        $hdng_class = 'worplex-fancy-title';
        if ($view == 'view2') {
            $hdng_class = 'worplex-fancy-title worplex-fancy-title-two';
            $hdng_con = 'div';
        } else if ($view == 'view3') {
            $hdng_class = 'worplex-fancy-title worplex-fancy-title-three';
            $hdng_con = 'div';
        } else if ($view == 'view4') {
            $hdng_class = 'worplex-fancy-title worplex-fancy-title-four';
            $hdng_con = 'div';
        } else if ($view == 'view5') {
            $hdng_class = 'worplex-fancy-title worplex-fancy-title-six';
            $hdng_con = 'div';
        } else if ($view == 'view6') {
            $hdng_class = 'worplex-fancy-title-nine';
            $s_title_clr = $s_title_clr != "" ? $s_title_clr : '';
            $num_title = $num_title != "" ? $num_title : '';
            $h_title = $h_title != "" ? $h_title : '';
            $h_desc = $h_desc != "" ? $h_desc : '';
            $s_title = $s_title != "" ? $s_title : '';
            $proc_num_clr = $proc_num_clr != "" ? $proc_num_clr : '';
            $hc_title_clr = $hc_title_clr != "" ? 'style="color: ' . $hc_title_clr . '"' : '';
            $desc_clr = $desc_clr != "" ? 'style="color: ' . $desc_clr . '"' : '';

        } else if ($view == 'view7') {
            $hdng_class = 'worplex-fancy-title-ten';
            $hdng_con = 'div';
            $text_align = $text_align != "" ? $text_align : "center";
            $content_align = "";
            if ($text_align == "left") {
                $content_align = 'worplex-fancy-title-ten-left';
            }
        } else if ($view == 'view8') {
            $hdng_class = 'worplex-fancy-title-eleven';
            $hdng_con = 'div';
            $text_align = $text_align != "" ? $text_align : "center";
            $content_align = "";
            if ($text_align == "left") {
                $content_align = 'worplex-fancy-title-eleven-left';
            }
            $heading_img = $heading_img != "" ? '<img src="' . $heading_img['url'] . '">' : "";
        } else if ($view == 'view9') {
            $hdng_class = 'worplex-fancy-title-twelve';
        } else if ($view == 'view10') {
            $hdng_class = 'worplex-fancy-title-thirteen';
        } else if ($view == 'view11') {
            $hdng_class = 'worplex-fancy-title-fourteen';
        } else if ($view == 'view12') {
            $hdng_class = 'worplex-fancy-title-fifteen';
        } else if ($view == 'view13') {
            $hdng_class = 'worplex-fancy-title-sixteen';
        } else if ($view == 'view14') {
            $hdng_class = 'worplex-fancy-title-seventeen';
        } else if ($view == 'view15') {
            $hdng_class = 'worplex-fancy-title-eighteen';
            $heading_img = $heading_img != "" ? '<img src="' . $heading_img['url'] . '">' : "";
        } else if ($view == 'view16') {
            $desc_clr = $desc_clr != "" ? 'style="color: ' . $desc_clr . '"' : '';
            $hdng_class = 'worplex-fancy-title-nineteen';
        } else if ($view == 'view17') {
            $hdng_class = 'worplex-fancy-title-twenty';
            $align_heading_class = $text_align != '' && $text_align == 'left' ? 'text-align-left' : '';
        } else if ($view == 'view18') {
            $hdng_class = 'worplex-fancy-title-twentyone';
            $align_heading_class = $text_align != '' && $text_align == 'left' ? 'text-align-left' : '';
            $s_title_clr = $s_title_clr != "" ? 'style="color: ' . $s_title_clr . '"' : '';
        }
        if ($view == 'view18') { ?>
            <div class="<?php echo $hdng_class ?> <?php echo $align_heading_class ?>">
                <small <?php echo $s_title_clr ?>><?php echo $s_title ?></small>
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
            </div>
        <?php } else if ($view == 'view17') { ?>

            <div class="<?php echo $hdng_class ?> <?php echo $align_heading_class ?>">
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
            </div>
        <?php } else if ($view == 'view16') { ?>
            <style>
                .worplex-fancy-title-nineteen h2:before {
                    background-color: <?php echo $hc_title_clr ?>;
                }
            </style>
            <div class="<?php echo $hdng_class ?>">
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
            </div>
        <?php } else if ($view == 'view15') { ?>
            <div class="<?php echo $hdng_class ?>">
                <?php echo $heading_img ?>
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
            </div>
        <?php } else if ($view == 'view14') { ?>
            <div class="<?php echo $hdng_class ?>">
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
                <small class="active"></small>
                <small></small>
            </div>
        <?php } else if ($view == 'view13') { ?>
            <div class="<?php echo $hdng_class ?>">
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
            </div>
        <?php } else if ($view == 'view12') { ?>
            <div class="<?php echo $hdng_class ?> style-heading-<?php echo $random_id ?>">
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
            </div>
            <style>
                .style-heading-<?php echo $random_id ?>::before {
                    background-color: #5dce7d;
                }
            </style>
        <?php } else if ($view == 'view11') { ?>
            <div class="<?php echo $hdng_class ?>">
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
            </div>

        <?php } else if ($view == 'view10') { ?>
            <div class="<?php echo $hdng_class ?>">
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
            </div>
        <?php } else if ($view == 'view9') { ?>
            <!-- Fancy Title -->
            <div class="<?php echo $hdng_class ?>">
                <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
                <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
            </div>

        <?php } else if ($view == 'view8') { ?>
            <!-- Fancy Title -->
            <<?php echo $hdng_con ?> class="<?php echo $hdng_class ?><?php echo $content_align ?>">
            <?php echo $heading_img ?>
            <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
            <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
            </div>

        <?php } else if ($view == 'view7') { ?>
            <!-- Fancy Title Ten -->
            <<?php echo $hdng_con ?> class="<?php echo($hdng_class) ?><?php echo $content_align ?>">
            <h2 <?php echo $title_colr_style ?>><?php echo $h_title ?></h2>
            <span <?php echo $desc_colr_style ?>><?php echo $h_desc ?></span>
            </div>
            <!-- Fancy Title Ten -->
        <?php } else if ($view != 'view6') { ?>
            <<?php echo($hdng_con) ?> class="<?php echo($hdng_class) ?><?php echo($design_css_class) ?>">
            <?php echo($hc_icon != '' && $view == 'view3' ? '<i class="' . $hc_icon['value'] . '"></i>' : '') ?>
            <?php echo($h_fancy_title != '' && $view == 'view5' ? '<span>' . $h_fancy_title . '</span>' : '') ?>

            <h2><?php echo($h_title) ?><?php echo($hc_title != '' ? '<span' . $title_colr_style . '>' . $hc_title . '</span>' : '') ?></h2>
            <?php
            if ($h_desc != '') {
                ?>
                <p<?php echo($desc_colr_style) ?>><?php echo($h_desc) ?></p>
                <?php
            }
            echo($view == 'view4' ? '<span> <i class="fa fa-circle"' . $desc_colr_style . '></i> <i class="fa fa-circle circle-two-size"' . $desc_colr_style . '></i> <i class="fa fa-circle circle-three-size"' . $desc_colr_style . '></i> </span>' : '');
            ?>
            </<?php echo($hdng_con) ?>>

            <?php
        } else { ?>
            <style>
                .worplex-fancy-title-nine .small-<?php echo $random_id ?>::before {
                    background-color: <?php echo $s_title_clr ?>;
                }

                .worplex-fancy-title-nine .small-<?php echo $random_id ?> {
                    color: <?php echo $proc_num_clr ?>;
                }

            </style>
            <div class="<?php echo $hdng_class ?>">
                <small class="small-<?php echo $random_id ?>"><?php echo $num_title ?>. <strong
                            style="color: <?php echo $s_title_clr ?>"><?php echo $s_title ?></strong></small>
                <h2 <?php echo $hc_title_clr ?>><?php echo $h_title ?></h2>
                <p <?php echo $desc_clr ?>><?php echo $h_desc ?></p>
            </div>
        <?php }
        $html = ob_get_clean();
        echo $html;
    }

    protected function content_template()
    {

    }

}