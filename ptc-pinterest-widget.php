<?php
/*
Plugin Name: PTC Pinterest Widget
Plugin URI: https://wordpress.org/plugins/ptc-pinterest-widget/
Description: PTC Pinterest Widget - Quick, small and easy Pinterest widget for wordpress..
Version: 1.0
Author: vivan jakes
Author URI: https://wordpress.org/support/profile/personaltrainercertification
*/
class ptcpinwgt_PinterestWidgets{
    
    public $options;
    
    public function __construct() {
        //you can run delete_option method to reset all data
        //delete_option('ptcpinwgt_pinterest_widget_options');
        $this->options = get_option('ptcpinwgt_pinterest_widget_options');
        $this->ptcpinwgt_pinterest_widget_register_settings_and_fields();
    }
    
    public static function add_ptcpinwgt_pinterest_widget_tools_options_page(){
        add_options_page('PTC Pinterest Widget', 'PTC Pinterest Widget ', 'administrator', __FILE__, array('ptcpinwgt_PinterestWidgets','ptcpinwgt_pinterest_widget_tools_options'));
    }
    
    public static function ptcpinwgt_pinterest_widget_tools_options(){
?>

<div class="pinterst_box_modal">
  
  <h2 class="top-style">PTC Pinterest Widget Customization</h2>
  <form method="post" action="options.php" enctype="multipart/form-data">
    <?php settings_fields('ptcpinwgt_pinterest_widget_options'); ?>
    <?php do_settings_sections(__FILE__); ?>
    <p class="submit">
      <input name="submit" type="submit" class="button-info" value="Save Changes"/>
    </p>
  </form>
</div>
<?php
    }
    public function ptcpinwgt_pinterest_widget_register_settings_and_fields(){
        register_setting('ptcpinwgt_pinterest_widget_options', 'ptcpinwgt_pinterest_widget_options',array($this,'ptcpinwgt_pinterest_widget_validate_settings'));
        add_settings_section('ptcpinwgt_pinterest_widget_main_section', 'Settings', array($this,'ptcpinwgt_pinterest_widget_main_section_cb'), __FILE__);
        //Start Creating Fields and Options
        //pageURL
        add_settings_field('pageURL', 'Pinterest Username', array($this,'pinterest_pageURL_settings'), __FILE__,'ptcpinwgt_pinterest_widget_main_section');
        //marginTop
        add_settings_field('marginTop', 'Margin Top', array($this,'pinterest_marginTop_settings'), __FILE__,'ptcpinwgt_pinterest_widget_main_section');
       //alignment option
         add_settings_field('alignment', 'Alignment Position', array($this,'pinterest_position_settings'),__FILE__,'ptcpinwgt_pinterest_widget_main_section');
        //width
        add_settings_field('width', 'Width', array($this,'pinterest_width_settings'), __FILE__,'ptcpinwgt_pinterest_widget_main_section');
        //height
        add_settings_field('height', 'Height', array($this,'pinterest_height_settings'), __FILE__,'ptcpinwgt_pinterest_widget_main_section');
        //streams options
        add_settings_field('scale', 'Image Width', array($this,'pinterest_scale_settings'),__FILE__,'ptcpinwgt_pinterest_widget_main_section');
        
        //jQuery options
    
    }
    public function ptcpinwgt_pinterest_widget_validate_settings($plugin_options){
        return($plugin_options);
    }
    public function ptcpinwgt_pinterest_widget_main_section_cb(){
        //optional
    }
  
    
    
    //pageURL_settings
    public function pinterest_pageURL_settings() {
        if(empty($this->options['pinterest_username'])) $this->options['pinterest_username'] = "pinterest";
        echo "<input name='ptcpinwgt_pinterest_widget_options[pinterest_username]' type='text' value='{$this->options['pinterest_username']}' />";
    }
    //marginTop_settings
    public function pinterest_marginTop_settings() {
        if(empty($this->options['marginTop'])) $this->options['marginTop'] = "100";
        echo "<input name='ptcpinwgt_pinterest_widget_options[marginTop]' type='text' value='{$this->options['marginTop']}' />";
    }
    //alignment_settings
    public function pinterest_position_settings(){
        if(empty($this->options['alignment'])) $this->options['alignment'] = "left";
        $items = array('left','right');
        echo "<select name='ptcpinwgt_pinterest_widget_options[alignment]'>";
        foreach($items as $item){
            $selected = ($this->options['alignment'] === $item) ? 'selected = "selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }
    //connection_settings
    public function pinterest_connection_settings() {
        if(empty($this->options['connection'])) $this->options['connection'] = "10";
        echo "<input name='ptcpinwgt_pinterest_widget_options[connection]' type='text' value='{$this->options['connection']}' />";
    }
    //width_settings
    public function pinterest_width_settings() {
        if(empty($this->options['width'])) $this->options['width'] = "350";
        echo "<input name='ptcpinwgt_pinterest_widget_options[width]' type='text' value='{$this->options['width']}' />";
    }
    //height_settings
    public function pinterest_height_settings() {
        if(empty($this->options['height'])) $this->options['height'] = "400";
        echo "<input name='ptcpinwgt_pinterest_widget_options[height]' type='text' value='{$this->options['height']}' />";
    }
    //image_scale_settings
     public function pinterest_scale_settings() {
        if(empty($this->options['scale'])) $this->options['scale'] = "80";
        echo "<input name='ptcpinwgt_pinterest_widget_options[scale]' type='text' value='{$this->options['scale']}' />";
    }
    
   
    

    // put jQuery settings before here
}
add_action('admin_menu', 'ptcpinwgt_pinterest_widget_trigger_options_function');

function ptcpinwgt_pinterest_widget_trigger_options_function(){
    ptcpinwgt_PinterestWidgets::add_ptcpinwgt_pinterest_widget_tools_options_page();
}

add_action('admin_init','ptcpinwgt_pinterest_widget_trigger_create_object');
function ptcpinwgt_pinterest_widget_trigger_create_object(){
    new ptcpinwgt_PinterestWidgets();
}
add_action('wp_footer','ptcpinwgt_pinterest_widget_add_content_in_footer');
function ptcpinwgt_pinterest_widget_add_content_in_footer(){
    
    $o = get_option('ptcpinwgt_pinterest_widget_options');
    extract($o);
$total_height=$height-110;
$total_width=$width+40;
$print_pinterest = '';
$print_pinterest .= '<a data-pin-do="embedUser" href="http://pinterest.com/'.$pinterest_username.'/"
data-pin-scale-width="'.$scale.'" data-pin-scale-height="'.$total_height.'" 
data-pin-board-width="'.$total_width.'"></a>';
$imgURL = plugins_url( 'assets/pinterest_main.png', __FILE__ );
?>
<script type="text/javascript">
(function(d){
  var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
  p.type = 'text/javascript';
  p.async = true;
  p.src = '//assets.pinterest.com/js/pinit.js';
  f.parentNode.insertBefore(p, f);
}(document));
</script> 
<script type="text/javascript">
jQuery(document).ready(function()
{
jQuery('#pinterest_widget_outer').click(function(){
	 jQuery(this).parent().toggleClass('showdiv_p');
});
});
</script>
<?php if($alignment=='left'){?>
<style>
#pinterest_widget_outer{
transition: all 0.5s ease-in-out 0s;
left: -<?php echo trim($width+10);?>px;
top: <?php echo $marginTop;?>px;
z-index: 10000;
height:<?php echo trim($height+30);?>px;	
}
#pinterest_widget_outer2{
text-align: left;
width:<?php echo trim($width);?>px;
height:<?php echo trim($height);?>px;	
}
.showdiv_p #pinterest_widget_outer{
	left:0px;
}
#pinterest_widget_outer2 img{
top: 0px;
right:-35px;	
}
</style>
<div id="pw_pinterest_widget_display">
  <div id="pinterest_widget_outer">
  <div id="pinterest_widget_outer2">
  <a class="open" id="plink" href="#"></a>
  <img src="<?php echo $imgURL;?>" alt=""> <?php echo $print_pinterest; ?>
   </div>
   <div style="font-size: 9px; color: #808080; font-weight: normal; font-family: tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: left; direction: ltr;padding:3px 0px 0px; position:absolute;bottom:0px;left:0px;"><a href="https://www.nationalcprassociation.com/faqs/" target="_blank" style="color: #808080;">Read more</a></div> 
    
  </div>
</div>

<?php } else { ?>
<style>
#pinterest_widget_outer{
transition: all 0.5s ease-in-out 0s;
right: -<?php echo trim($width+10);?>px;
top: <?php echo $marginTop;?>px;
z-index: 10000;
height:<?php echo trim($height+30);?>px;	
}
#pinterest_widget_outer2 {
text-align: left;
width:<?php echo trim($width);?>px;
height:<?php echo trim($height);?>px;	
}
.showdiv_p #pinterest_widget_outer{
	right:0px;
}
#pinterest_widget_outer2 img{
	top: 0px;
	left:-35px;
}
</style>
<div id="pw_pinterest_widget_display">
  <div id="pinterest_widget_outer">
    <div id="pinterest_widget_outer2">
     <a class="open" id="plink" href="#"></a>
     <img src="<?php echo $imgURL;?>" alt=""> <?php echo $print_pinterest; ?> 
    
    </div>
     <div style="font-size: 9px; color: #808080; font-weight: normal; font-family: tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;padding:3px 3px 0px; position:absolute;bottom:0px;right:0px;"><a href="https://www.nationalcprassociation.com/faqs/" target="_blank" style="color: #808080;">Read more</a></div>
     
   </div>
</div>

<?php } ?>
<?php
}
add_action( 'wp_enqueue_scripts', 'register_ptcpinwgt_pinterest_widget_styles' );
add_action( 'admin_enqueue_scripts', 'register_ptcpinwgt_pinterest_widget_styles' );
 function register_ptcpinwgt_pinterest_widget_styles() {
    wp_register_style( 'register_ptcpinwgt_and_pinterest_widget_styles', plugins_url( 'assets/main.css' , __FILE__ ) );
    wp_enqueue_style( 'register_ptcpinwgt_and_pinterest_widget_styles' );
    wp_enqueue_script('jquery');
 }
$ptcpinwgt_pinterest_widget_default_values = array(
     'sidebarImage' => 'pinterest_main.png',
     'marginTop' => 100,
     'pinterest_username' => 'pinterest',
     'width' => '350',
     'height' => '400',
     'scale' => '80',
     'alignment' => 'left'

 );
add_option('ptcpinwgt_pinterest_widget_options', $ptcpinwgt_pinterest_widget_default_values);





