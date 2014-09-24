<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */
 global $language;
 $lang = $language->language;
 $uri = explode('/', request_uri());
 $id = str_replace(' ', '-', $node->title);

 // Get youtube video id
 if (!function_exists('getYTVideoId')) {
    function getYTVideoId($url){
		$url = $url.'&';
		$pattern = '/v=(.+?)&+/';
		preg_match($pattern, $url, $matches);
		return ($matches[1]);
	}
  } 

?>
<article id="<?php print $id; ?>" class="node-<?php print $node->nid; ?> <?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  
  <?php 
  if($node->type=='news' ||  
	 $node->type=='client_area_download' || 
	 $node->type=='link' || 
	 $node->type=='staff_member' || 
	 $node->type=='industry_partner' || 
	 $node->type=='location' || 
	($node->type=='career' && $view_mode == 'teaser')
	){
  	include path_to_theme().'/templates/includes/node-edit.inc.php';
  }
  ?>  
  
  <?php if ($unpublished || isset($uri[2]) && $uri[1] != 'client-area' && $uri[2] != 'client-area' && $node->type != 'news' && $node->type != 'link' && $node->type != 'career' && $node->type != 'industry_partner' && $node->type != 'client_area_download' ): ?>
    <header>
      
      <?php if( (isset($uri[2]) && $uri[1] != 'fr') || (isset($uri[3]) && $uri[1] == 'fr') || isset($uri[4]) || $node->type == 'client_area_video'): ?>
      	<h2><?php print $node->title; ?></h2>
      <?php endif; ?>

      <?php if ($unpublished): ?>
        <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <?php 
	
	// NEWS
	if($node->type == 'news') :
		
		if($view_mode == 'full'):
			print render($content['title_field']); ?>
			<p class="posted"><?php print t('Posted ') . date('F jS, Y', $node->created) ?></p>
            <?php print render($content['body']) ?>
            <?php print render($content['field_downloads']) ?>
            
        <?php else: ?>
        	<h2><a href="/news#<?php print $id; ?>"><?php print $node->title; ?></a></h2>
            <div class="field field-name-body">
				<?php print substr($body[0]['safe_value'],0,130).'...'; ?>
            </div>
        	<p class="btn"><a class="btn" href="/news#<?php print $id; ?>"><?php print t('Read More'); ?></a></p>
        <?php endif ;
	
	// CAREER
	elseif($node->type == 'career' && $view_mode == 'full') : ?>
    	<a class="btn top" href="/careers">Back to Listings</a>
    <?php print render($content);
	
	// INDUSTRY PARTNERS
	elseif($node->type == 'industry_partner'):?>
    <a rel="external" class="industry-partner-logo" href="<?php print $node->field_website_url['und'][0]['safe_value']; ?>"><img src="<?php print image_style_url('industry_partners', $node->field_image['und'][0]['uri']) ?>" /></a>
    <h3><a rel="external" href="<?php print $node->field_website_url['und'][0]['safe_value']; ?>"><?php print $node->title; ?></a></h3>
	<?php print render($content);
	
	// LINK
	elseif($node->type == 'link'): ?>
    <h3><?php print $node->field_heading[$lang][0]['safe_value']; ?></h3>
    <h3><a rel="external" href="<?php print $node->field_website_url['und'][0]['safe_value']; ?>"><?php print $node->title; ?></a></h3>
	<?php print render($content);
	
	// VIDEO
	elseif($node->type == 'client_area_video'): 
	drupal_add_js(path_to_theme().'/js/jquery.fitvids.js');
	$id = getYTVideoId($node->field_video_url['und'][0]['safe_value']);?>
    <div class="fitvids"><iframe width="640" height="360" src="//www.youtube.com/embed/<?php print $id; ?>?feature=player_detailpage" frameborder="0" allowfullscreen></iframe></div>
	
    <?php
	// DEFAULT
    else:
    	print render($content);
	endif;	
	
	// CAREER
	if($node->type == 'career' && $view_mode == 'full') : ?>
    	<p style="margin-top:30px"><a class="btn" href="/careers">Back to Listings</a></p>
    <?php endif;
	if($node->type == 'career' && $view_mode == 'teaser') : ?>
    	<p class="btn"><a class="btn" href="<?php print $node_url ?>">Read More</a></p>
    <?php endif;?>

</article>
