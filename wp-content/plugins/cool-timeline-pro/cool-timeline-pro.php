<?php 
/*
  Plugin Name:Cool Timeline Pro
  Plugin URI:http://coolplugins.net/
  Description:Use Cool Timeline pro wordpress plugin to showcase your life or your company story in a vertical timeline format. Cool Timeline Pro is an advanced timeline plugin that creates responsive vertical storyline automatically in chronological order based on the year and date of your posts.
  Version:2.7.3
  Author:CoolPlugins
  Author URI:http://coolplugins.net/
  License:GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Domain Path: /languages 
  Text Domain:cool-timeline
 */
/** Configuration * */

if (!defined('CTLPV')){
    define('CTLPV', '2.7.3');

}

/*
    Defined constant for later use
 */
define('CTP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CTP_PLUGIN_DIR', plugin_dir_path(__FILE__));
defined( 'CTP_FA_DIR' ) or define( 'CTP_FA_DIR', CTP_PLUGIN_DIR.'/fa-icons/' );
defined( 'CTP_FA_URL' ) or define( 'CTP_FA_URL', CTP_PLUGIN_URL.'/fa-icons/'  );

if (!class_exists('CoolTimelinePro')) {

    class CoolTimelinePro {

        /**
         * Construct the plugin objects
         */
        public function __construct() {

            //set plugin path for later use
            $this->plugin_path = plugin_dir_path(__FILE__);
            // Installation and uninstallation hooks
            register_activation_hook(__FILE__ , array($this,'ctp_activation_before'));
            //included all files
            add_action('plugins_loaded', array($this, 'clt_include_files'));
          
            if(is_admin()){
             //Adding plugin settings link  
            $plugin = plugin_basename(__FILE__);
            add_filter("plugin_action_links_$plugin", array($this, 'plugin_settings_link'));   
             //Fixed bridge theme confliction using this action hook
            add_action( 'wp_print_scripts', array($this,'ctl_deregister_javascript'), 100 );
          
            add_action('admin_enqueue_scripts',array($this, 'ctl_custom_order_js'));

            // add a tinymce button that generates our shortcode for the user
            add_action('after_setup_theme', array($this, 'ctl_add_tinymce'));
            add_action( 'admin_notices',array($this,'cool_admin_messages'));
            add_action( 'wp_ajax_ctl_hideRating',array($this,'ctl_pro_HideRating' ));
            }else{
            
             add_action( 'init', array($this,'fa_icons_tp_tags' ) );
            
              }

           // Add image size for Avatar image
            add_image_size('ctl_avatar', 250, 250, true); // Hard crop left top
           //Hooked plugin translation function 
            add_action('plugins_loaded', array($this, 'clt_load_plugin_textdomain'));
       
         }

         function ctl_custom_order_js($hook) {
             $current_page=ctl_get_ctp();
            if($current_page!="cool_timeline" ) 
                return;
             wp_enqueue_script( 'ctl-admin-js',CTP_PLUGIN_URL.'js/ctl_admin.js',array('jquery'));
             wp_localize_script( 'ctl-admin-js', 'ajax_object',
             array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
         }
         
          public function clt_include_files(){

           // Register cooltimeline post type for timeline stories
            require_once CTP_PLUGIN_DIR . 'includes/cool_timeline_posttype.php';
            // contain common function for plugin
            require_once CTP_PLUGIN_DIR . 'includes/ctl-helpers.php';
            require_once CTP_PLUGIN_DIR . 'includes/ctl_load_more.php';


         if(is_admin()){
                //automatic updates 
              require_once(dirname(__FILE__) . "/includes/class.wp-auto-plugin-update.php");

            // including plugin settings panel class
             require_once( CTP_PLUGIN_DIR ."admin-page-class/admin-page-class.php");
            // including timeline stories meta boxes class 
            require_once CTP_PLUGIN_DIR . "meta-box-class/my-meta-box-class.php";
            // Vc addon for timeline shortcode
            require_once CTP_PLUGIN_DIR . "includes/cool_vc_addon.php";
            // included timeline stories icon handler class
            require CTP_PLUGIN_DIR .'fa-icons/fa-icons-class.php';
            require CTP_PLUGIN_DIR .'/includes/ctl-meta-fields.php';
           
            require CTP_PLUGIN_DIR .'/includes/ctl-settings.php';
            /*
             * Options panel
             */
            ctl_option_panel();
            /*
             *  custom meta boxes 
             */
             clt_meta_boxes();
             new CoolVCAddon();
             new Ctl_Fa_Icons();

          } else{

             /*
             * Frontend files
             */
        
            require_once CTP_PLUGIN_DIR . 'includes/cool_timeline_shortcode.php';
            require_once CTP_PLUGIN_DIR . 'includes/ct-shortcode-new.php';
            require_once CTP_PLUGIN_DIR . 'includes/cool_timeline_custom_styles.php';

             new CoolTimelineShortcode();
             new CoolContentTimeline();

          }
            
             $cool_timeline_posttype = new CoolTimelinePosttype();
         }



      /*
        Perform some actions on plugin activation time
       */   
    function ctp_activation_before() {

        if (is_plugin_active( 'cool-timeline/cooltimeline.php' ) ) 
            {
            deactivate_plugins( 'cool-timeline/cooltimeline.php' );
           }
            update_option("cool-timelne-v",CTLPV);
            update_option("cool-timelne-type","PRO");
          
            update_option("cool-timelne-pro-installDate",date('Y-m-d h:i:s') );
            update_option("cool-timelne-pro-ratingDiv","no");

          $ctl_settings=get_option('cool_timeline_options');
          if(is_array($ctl_settings) && !empty($ctl_settings)){
          if(isset($ctl_settings['enable_navigation']) && in_array('enable_navigation', $ctl_settings)){
             update_option("ctl-can-migrate","no");
            }else{
               update_option("ctl-can-migrate","yes");
            }
           }else{
            update_option("ctl-can-migrate","yes");
           }
    }
        
        /*
            Loading translation files of plugin 
         */

        function clt_load_plugin_textdomain() {
         $rs = load_plugin_textdomain('cool-timeline', FALSE, basename(dirname(__FILE__)) . '/languages/');
        }

        // Add the settings link to the plugins page
        function plugin_settings_link($links) {
            $settings_link = '<a href="options-general.php?page=cool_timeline_page">Settings</a>';
            array_unshift($links, $settings_link);
            return $links;
        }
        /**
         * Include other PHP scripts for the plugin
         * @return void
         *
         **/
        public function fa_icons_tp_tags() {
            // Files specific for the front-ned
            if ( ! is_admin() ) {
                // Load template tags (always last)
                include CTP_PLUGIN_DIR .'fa-icons/includes/template-tags.php';
            }
        }

        /*
        * Fixed Bridge theme confliction
        */
        function ctl_deregister_javascript() {

            if(is_admin()) {
                $screen = get_current_screen();
                if ($screen->base == "toplevel_page_cool_timeline_page") {
                    wp_deregister_script('default');
                }
            }
        }

        /*
            Adding shortcode generator in TinyMCE editor
         */
        public function ctl_add_tinymce() {
         global $typenow;
         if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
              return;
        }

        if ( get_user_option('rich_editing') == 'true' ) {
       add_filter('mce_external_plugins', array(&$this, 'ctl_add_tinymce_plugin'));
            add_filter('mce_buttons', array(&$this, 'ctl_add_tinymce_button'));
          }    

        }

        /*
            Creating TinyMCE plugin for shortcode generator
         */
    
        public function ctl_add_tinymce_plugin($plugin_array) {
            $plugin_array['cool_timeline'] =CTP_PLUGIN_URL.'js/shortcode-btn.js';
            return $plugin_array;
        }

        // Add the button key for address via JS
        function ctl_add_tinymce_button($buttons) {
            array_push($buttons, 'cool_timeline_shortcode_button');
            return $buttons;
        }

        // end tinymce button functions           

        /**
         * Activate the plugin
         */
        public function activate() {
     

        }
        // END public static function activate

        /**
         * Deactivate the plugin
         */
        public function deactivate() {

        }

      

        /*
            Integrated Admin noticed for rating
         */

        public function cool_admin_messages() {
      
         if( !current_user_can( 'update_plugins' ) ){
            return;
         }
        $install_date = get_option( 'cool-timelne-pro-installDate' );
        $ratingDiv =get_option( 'cool-timelne-pro-ratingDiv' )!=false?get_option( 'cool-timelne-pro-ratingDiv'):"no";

         $dynamic_msz='<div class="cool_fivestar update-nag" style="box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);">
          <p>Dear Cool Timeline PRO Plugin User, Hopefully you\'re happy with our plugin. <br> May I ask you to give it a <strong>5-star rating</strong> on Wordpress? 
            This will help to spread its popularity and to make this plugin a better one.
            <br><br>Your help is much appreciated.Thank you very much!
            <ul>
                <li class="float:left"><a href="https://codecanyon.net/item/cool-timeline-pro-wordpress-timeline-plugin/reviews/17046256" class="thankyou button button-primary" target="_new" title="I Like Cool Timeline" style="color: #ffffff;-webkit-box-shadow: 0 1px 0 #256e34;box-shadow: 0 1px 0 #256e34;font-weight: normal;float:left;margin-right:10px;">I Like Cool Timeline PRO</a></li>
                <li><a href="javascript:void(0);" class="coolHideRating button" title="I already did" style="">I already rated it</a></li>
                <li><a href="javascript:void(0);" class="coolHideRating" title="No, not good enough" style="">No, not good enough, i do not like to rate it!</a></li>
            </ul>
        </div>
        <script>
        jQuery( document ).ready(function( $ ) {

        jQuery(\'.coolHideRating\').click(function(){
            var data={\'action\':\'ctl_hideRating\'}
                 jQuery.ajax({
            
            url: "' . admin_url( 'admin-ajax.php' ) . '",
            type: "post",
            data: data,
            dataType: "json",
            success: function(e) {
                if (e.success=="true") {
                   jQuery(\'.cool_fivestar\').slideUp(\'fast\');
             
                }
            }
             });
            })
        
        });
        </script>';

                $display_date = date( 'Y-m-d h:i:s' );
                $install_date= new DateTime( $install_date );
                $current_date = new DateTime( $display_date );
                $difference = $install_date->diff($current_date);
              $diff_days= $difference->days;
           if (isset($diff_days) && $diff_days>=7 && $ratingDiv == "no" ) {
                echo $dynamic_msz;
                }
               
           }   
       /*
        Ajax Callback for rating button
        */    

     public function ctl_pro_HideRating() {
        $rs=update_option( 'cool-timelne-pro-ratingDiv','yes' );
         echo  json_encode( array("success"=>"true") );
        exit;
        }
 }
    //end class
}

if(is_admin()){
    foreach (array('post.php','post-new.php','edit-tags.php','term.php') as $hook) {

        add_action("admin_head-$hook", 'ctl_admin_head');
    }

}

/**
 * Localize Script
 */
function ctl_admin_head() {

    $plugin_url = plugins_url('/', __FILE__);
   if(version_compare(get_bloginfo('version'),'4.5.0', '>=') ){
    $terms = get_terms(array(
     'taxonomy' => 'ctl-stories',
    'hide_empty' => false,
     ));
    }else{
            $terms = get_terms('ctl-stories', array('hide_empty' => false,
        ) );
      }

    if (!empty($terms) || !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $ctl_terms_l[$term->slug] =$term->slug;
        }
    }


    if (isset($ctl_terms_l) && array_filter($ctl_terms_l) != null) {
        $category =json_encode($ctl_terms_l);
    } else {
        $category = json_encode(array('0' => 'No category'));
    }
    ?>
    <!-- TinyMCE Shortcode Plugin -->
<script type='text/javascript'>
   var ctl_cat_obj = {
        'category':'<?php echo $category; ?>'
    };
</script>
    <style type="text/css">
	.mce-container[aria-label="Add Cool Timeline Shortcode"],
    .mce-container[aria-label="Add Vertical Content Timeline Shortcode"],
    .mce-container[aria-label="Add Horizontal Content Timeline Shortcode"]
     {margin-top:38px;}
	.mce-container[aria-label="Add Cool Timeline Shortcode"], 
    .mce-container[aria-label="Add Horizontal Content Timeline Shortcode"],
    .mce-container[aria-label="Add Vertical Content Timeline Shortcode"]
     {max-height:100%;}
    .mce-container[aria-label="Add Vertical Content Timeline Shortcode"] .mce-reset,
    .mce-container[aria-label="Add Horizontal Content Timeline Shortcode"] .mce-reset
     {
    max-height: calc(100% - 58px);
    overflow-y: scroll;
    overflow-x: hidden;
	margin-top:50px;
        }
   .mce-container[aria-label="Add Cool Timeline Shortcode"] .mce-reset {
    max-height: calc(100% - 58px);
    overflow-y: scroll;
    overflow-x: hidden;
	margin-top:50px;
        }
	.mce-container[aria-label="Add Cool Timeline Shortcode"] 
    .mce-foot .mce-abs-layout, 
    .mce-container[aria-label="Add Vertical Content Timeline Shortcode"] .mce-foot .mce-abs-layout,
    .mce-container[aria-label="Add Horizontal Content Timeline Shortcode"] .mce-foot .mce-abs-layout {
    position: fixed;
    background: #ddd;
	top:0;
		}
    </style>
    <!-- TinyMCE Shortcode Plugin -->
    <?php
}

// instantiate the plugin class
 new CoolTimelinePro();

