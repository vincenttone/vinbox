<?php
/*
 * Plugin Name: Vinbox
 * Plugin URI: http://www.reai.us
 * Description: vincent's lightbox plugin
 * Version: 0.9 Alpha1 
 * Author: Vincent.Tone
 * Author URI: http://www.reai.us
 *
 * Copyright 2011 vincent tonewensong@gmail.com
 *
 */

function vinbox_show_options()
{
    $box_array = array(
        'prettyphoto'   => 'Pretty Photo',
        'pirobox'       => 'Pirobox',
        'shadowbox'     => 'Shadowbox',
    );

    $box_type_saved = get_option('vinbox_box_type');

    if($_POST['box_type']){
        $box_type = $_POST['box_type'];

        if($box_type_saved == $box_type){
            echo '<span>选项没有改变</span>';
        }else{
            if(!$box_type_saved){
                add_option('vinbox_box_type', $box_type);
            }else{
                $update_box_type = update_option('vinbox_box_type', $box_type);
                if($update_box_type){
                    echo '<span>灯箱程序已经更换为'.$box_array[$box_type].'</span>';
                }else{
                    echo '<span>更新失败</span>';
                }

            }
        }
    }

    // output begin 
    $output = '<div class = "wrap">';
    $output .= '<form method = "post" action = "">';
    $output .= '<table>';
    $output .= '<tbody>';
    $output .= '<tr>';
    $output .= '<td>灯箱程序选择</td>';
    $output .= '<td>';
    $output .= '<select name = "box_type">';
    foreach($box_array as $val => $display ){
        if( $val == $box_type_saved){
            $output .= '<option value = "'.$val.'" selected = "selected">'.$display.'</option>';
        }else{
            $output .= '<option value = "'.$val.'">'.$display.'</option>';
        }
    }
    $output .= '</select>';
    $output .= '</td>';
    $output .= '</tr>';
    $output .= '<tr>';
    $output .= '<td></td>';
    $output .= '<td><input type = "submit" value = "提交"></td>';
    $output .= '</tr>';
    $output .= '</tbody>';
    $output .= '</table>';
    $output .= '</form>';
    $output .= '</div>';
    // output end 

    echo $output;
}

function vinbox_set_admin()
{
    add_options_page('Vinbox设置', 'Vinbox设置', 8, __FILE__, 'vinbox_show_options');
}

function vinbox_add_js()
{
    $box_type = get_option('vinbox_box_type');
    switch($box_type){
        case 'prettyphoto':
            wp_register_script('vin_prettyphoto_js', WP_PLUGIN_URL.'/vinbox/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'), '3.1.2' );
            wp_enqueue_script('vin_prettyphoto_js');
            break;
        case 'shadowbox':
            wp_register_script('vin_shadowbox_js', WP_PLUGIN_URL.'/vinbox/shadowbox/shadowbox.js', array('jquery'), '3.0.3' );
            wp_enqueue_script('vin_shadowbox_js');
            break;
        case 'pirobox':
            wp_register_script('vin_pirobox_js', WP_PLUGIN_URL.'/vinbox/pirobox/js/pirobox_extended_min.js', array('jquery'), '1.0' );
            wp_register_script('vin_jquery_ui_js', WP_PLUGIN_URL.'/vinbox/pirobox/js/jquery-ui-1.8.2.custom.min.js', array('jquery'), '1.8.2' );
            wp_enqueue_script('vin_pirobox_js');
            wp_enqueue_script('vin_jquery_ui_js');
            break;
        default:
            wp_register_script('vin_pirobox_js', WP_PLUGIN_URL.'/vinbox/pirobox/js/pirobox_extended_min.js', array('jquery'), '1.0' );
            wp_register_script('vin_jquery_ui_js', WP_PLUGIN_URL.'/vinbox/pirobox/js/jquery-ui-1.8.2.custom.min.js', array('jquery'), '1.8.2' );
            wp_enqueue_script('vin_pirobox_js');
            wp_enqueue_script('vin_jquery_ui_js');
            break;

    }
     
}
function vinbox_add_css()
{
    $box_type = get_option('vinbox_box_type');
    switch($box_type){
        case 'prettyphoto':
            wp_register_style('vin_prettyphoto_css', WP_PLUGIN_URL.'/vinbox/prettyphoto/css/prettyPhoto.css');
            wp_enqueue_style('vin_prettyphoto_css');
            break;
        case 'shadowbox':
            wp_register_style('vin_shadowbox_css', WP_PLUGIN_URL.'/vinbox/shadowbox/shadowbox.css');
            wp_enqueue_style('vin_shadowbox_css');
            break;

        case 'pirobox':
            wp_register_style('vin_pirobox_css', WP_PLUGIN_URL.'/vinbox/pirobox/css_pirobox/style_2/style.css');
            wp_enqueue_style('vin_pirobox_css');
            break;
        default:
            wp_register_style('vin_pirobox_css', WP_PLUGIN_URL.'/vinbox/pirobox/css_pirobox/style_2/style.css');
            wp_enqueue_style('vin_pirobox_css');
            break;

    }

}

function vinbox_header_set()
{
    $box_type = get_option('vinbox_box_type');
    $output = '<script type = "text/javascript" charset = "utf-8">';
    $output .= 'jQuery(document).ready(function(){';
    $output .= 'jQuery("a:has(img)").attr("title", "" );';
    switch($box_type){
        case 'prettyphoto':
            $output .= '    jQuery("a:has(img)").attr("rel", "prettyPhoto");';
            $output .= '    jQuery("a[rel^=\'prettyPhoto\']").prettyPhoto({"social_tools": "",});';
            break;
        case 'shadowbox':
            $output .= '    jQuery("a:has(img)").attr("rel", "shadowbox");';
            $output .= '    Shadowbox.init({handleOverSize: "drag", modal: true});';
            break;
        case 'pirobox':
            $output .= '    jQuery("a:has(img)").addClass("pirobox").attr("rel", "gallery");';
            $output .= '    jQuery().piroBox_ext({';
            $output .= '        piro_speed  : 600,';
            $output .= '        bg_alpha    : 0.1,';
            $output .= '        piro_scroll : true,';
            $output .= '    });';
            break;
        default:
            $output .= '    jQuery("a:has(img)").addClass("pirobox").attr("rel", "gallery");';
            $output .= '    jQuery().piroBox_ext({';
            $output .= '        piro_speed  : 900,';
            $output .= '        bg_alpha    : 0.5,';
            $output .= '        piro_scroll : true,';
            $output .= '    });';
            break;

    }

    $output .= '});';
    $output .= '</script>';

    echo $output;
}

add_action('admin_menu', 'vinbox_set_admin');
add_action('wp_print_scripts', 'vinbox_add_js');
add_action('wp_print_styles', 'vinbox_add_css');
add_action('wp_head', 'vinbox_header_set');
