<?php
/**
* Plugin Name: HxLoad Player
* Plugin URI: https://wordpress.org/plugins/hxloadplayer/
* Description: Plugin to get direct link to hxload player from google drive, google photos, mp4upload, fembed, clipwatching, vidoza, gounlimited
* Version: 1.4.4
* Author: hxload.to
* Author URI: https://hxload.to
* Requires at least: 4.4
* Tested up to: 5.2
* License: GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
*
* @author HxLoad <hxload.to>
* @copyright Copyright (c) HxLoad
*/
add_action( 'admin_menu', 'hxloadplayer_menu' );
function hxloadplayer_menu() {
	add_menu_page( 
		'HxLoad Player Page',
		'HxLoad Player',
		'manage_options',
		'hxloadplayer.php',
		'hxloadplayer_init'
	);
}

if ( ! defined( 'ABSPATH' ) ) exit;

function hxloadplayer_init(){

if(!current_user_can('manage_options')){
	die('you dont have authorization to view this page');
}	

if(sanitize_text_field($_POST["secretkey"]) != "" && sanitize_text_field($_POST['form_key'] == 'settings')){
	if(check_admin_referer('my_nonce_action', 'my_nonce_field')){
		update_option('hxh_secretkey', sanitize_text_field($_POST["secretkey"]));
		update_option('hxh_tag', sanitize_text_field($_POST["tag"]));
		update_option('hxh_link', str_replace('http://','', esc_url_raw($_POST["link"])));
		update_option('hxh_poster', str_replace('http://','', esc_url_raw($_POST["poster"])));
		update_option('hxh_subtitle', str_replace('http://','', esc_url_raw($_POST["subtitle"])));
		update_option('hxh_cachetime', sanitize_text_field($_POST["ctime"]));
	}else{
		die('<div class="notice notice-info"><p><strong>Notice : </strong>Invalid nonce, redirecting...</p></div><meta http-equiv="refresh" content="1; url='.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'" /><br/>');
	}
	die('<div class="notice notice-info"><p><strong>Notice : </strong>Saved Settings, redirecting...</p></div><meta http-equiv="refresh" content="1; url='.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'" /><br/>');
}
?>
<br/>
<form method="post" action="">
<input type="hidden" name="form_key" value="settings">

<table class="form-table">
<tbody>
<tr>
	<th scope="row"><label for="ap_key">Secret Key [<a href="https://hxload.to/?p=account">Click Here</a>]</label></th>
	<td><input name="secretkey" type="text" value="<?php echo get_option("hxh_secretkey"); ?>" placeholder="Insert Your Secret Key" class="regular-text"></td>
</tr>
</tbody>
</table>
<table class="form-table">
	<tbody>
	<tr>
	<th scope="row"><label>Tag</label></th>
	<td><input name="tag" type="text" value="<?php if(get_option("hxh_tag")==""){echo "gdu"; } else {echo get_option("hxh_tag"); } ?>" placeholder="Insert Tag" class="regular-text"></td>
	</tr>
	<tr>
	<th scope="row"><label>Link</label></th>
	<td><input name="link" type="text" value="<?php if(get_option("hxh_link")==""){echo "link"; } else {echo get_option("hxh_link"); } ?>" class="regular-text"></td>
	</tr>
	<tr>
	<th scope="row"><label>Poster</label></th>
	<td><input name="poster" type="text" value="<?php if(get_option("hxh_poster")==""){echo "poster"; } else {echo get_option("hxh_poster"); } ?>" class="regular-text"></td>
	</tr>
	<tr>
	<th scope="row"><label>Subtitle</label></th>
	<td><input name="subtitle" type="text" value="<?php if(get_option("hxh_subtitle")==""){echo "subtitle"; } else {echo get_option("hxh_subtitle"); } ?>" class="regular-text"></td>
	</tr>
	<tr>
	<th scope="row"><label>Cache Time</label></th>
	<td><input name="ctime" type="text" value="<?php if(get_option("hxh_cachetime")==""){echo "1800"; } else {echo get_option("hxh_cachetime"); } ?>" class="regular-text"> Seconds. Recommendation 1800</td>
	</tr>
	</tbody>
</table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save"></p>
<?php wp_nonce_field('my_nonce_action','my_nonce_field');?>
</form>
Example Shortcode Tag: [gdu link=""] or [gdu link="" subtitle=""] or [gdu link="" poster="" subtitle=""]<br/>
Example Multi Subtitle Tag: [gdu link="" subtitle="http://myweb/sub1.srt=english|http://myweb/sub2.srt=netherlands"] (Last parameter (http://myweb/sub2.srt=netherlands) is default subtitle)
<br/><br/>
* WARNING: FOR TAG "LINK", PLEASE SUBMIT VIDEO PLAYER URL ONLY<br/>
Support from: google drive, google photos, mp4upload, fembed, clipwatching, vidoza, gounlimited
<?php }

function getHxL_PID(){
	global $post;
	$post_id = $post->ID;
	
	if(!$post_id){
		$post_id = get_the_ID();
	}
	if(!$post_id){
		$post_id = intval($_POST['post_id']);
	}	
	return $post_id;
}

function filterString($start, $end, $string){
	$string = explode($start, $string);
	$string = explode($end, $string[1]);
	return trim(preg_replace('/\s+/', ' ', $string[0]));
}

function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        return $dirPath." must be a directory";
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            @unlink($file);
        }
    }
    @rmdir($dirPath);
}

function hxloadplayerTag_load($data){
	$post_id = getHxL_PID();
	$CurDomain = 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].'/';
	
	$att_link = get_option("hxh_link");
	
	$att_poster = get_option("hxh_poster");
	if($att_poster && substr($att_poster, 0, 4) === "http" && substr($att_poster, 0, 5) === "https"){
		$att_poster = $CurDomain . $att_poster;
	}
	
	$att_subtitle = get_option("hxh_subtitle");
	if($att_subtitle && substr($att_subtitle, 0, 4) === "http" && substr($att_subtitle, 0, 5) === "https"){
		$att_subtitle = $CurDomain . $att_subtitle;
	}
	
	$data = array(
		"title" => get_the_title($post_id),
		"link" => urlencode($data[$att_link]),
		"poster" => urlencode($data[$att_poster]),
		"subtitle" => urlencode($data[$att_subtitle])
	);
	
	return HxL_UpdateData($data);
}

function HxL_UpdateData($data){
	$post_id = getHxL_PID();
	$ctag = get_option("hxh_tag");
	$hcachetime = get_option("hxh_cachetime");	

	$dLink = urldecode($data['link']);
	$dPoster = urldecode($data['poster']);
	$dSub = urldecode($data['subtitle']);

	$cacheDir = get_template_directory().'/hxcache';
	
	if((fileatime($cacheDir) + 86400) < time()){
		deleteDir($cacheDir);
	}
			
	if(!is_dir($cacheDir)){
		@mkdir($cacheDir);
	}

	if(!file_exists($cacheDir)){
		return '<center><font color="red">Please create hxload cache foler at '.$cacheDir.', with CHMOD 0775.</font></center>';
	}
	
	$cacheFile = $cacheDir.'/'.md5($dLink . $dSub . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]).'.cache';
	$cacheLoad = @file_get_contents($cacheFile);

	$lcache = get_post_meta($post_id, "hxh_".$ctag."_lcache", $single = true);	
	if(!is_numeric($lcache)){
		$lcache = 0;
	}
	$lcache = $lcache + $hcachetime;	
	if(file_exists($cacheFile) && time() > $lcache || !file_exists($cacheFile)){
		$params = array(
		 'timeout' => 15,
		 'redirection' => 5,
		 'httpversion' => '1.0',
		 'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ),
		 'blocking' => true,
		 'headers' => array(),
		 'cookies' => array(),
		 'body' => null,
		 'compress' => false,
		 'decompress' => true,
		 'sslverify' => true,
		 'stream' => false,
		 'filename' => null
		);
		$dHxLoad = wp_remote_get("https://hxload.to/api/getlink/?secretkey=".get_option("hxh_secretkey")."&link=".urlencode($dLink)."&poster=".urlencode($dPoster)."&subtitle=".urlencode($dSub), $params);
		$dataResp = wp_remote_retrieve_body($dHxLoad);

		$json = json_decode($dataResp,true);
		$iframe = urldecode(isset($json['result']['iframe']) ? $json['result']['iframe'] : '');
		
		if(strpos(strtolower($dataResp),'firewall') !== false && strpos(strtolower($dataResp),'<div>') !== false){			
			return '<center><font color="red">Error, blocked by firewall. '.filterString("<title>","</title>",$dataResp).'</font></center>';			
		}else if(strpos(strtolower($dataResp),'captcha') !== false && strpos(strtolower($dataResp),'<div>') !== false){			
			return '<center><font color="red">Error, filter by cloudflare captcha. '.filterString("<title>","</title>",$dataResp).'</font></center>';			
		}else if(!$iframe && $cacheLoad){			
			return $cacheLoad;			
		}else if(strpos(strtolower($dataResp),'iframe') !== false){			
			if(!add_post_meta($post_id, 'hxh_'.$ctag.'_lcache', time(), true)){ 			
				update_post_meta($post_id, 'hxh_'.$ctag.'_lcache', time());				
			}			
			@file_put_contents($cacheFile,$iframe);			
			return $iframe;							
		}else{
			if(strpos($dataResp,'message') !== false){
				return '<center><font color="red">'.$dataResp.'</font></center><br/>';				
			}else{
				return '<center><font color="red">Error, unknown data response.</font></center><br/>';				
			}
		}
	}else{
		return $cacheLoad;
	}
}

add_shortcode(get_option("hxh_tag"), 'hxloadplayerTag_load');
?>