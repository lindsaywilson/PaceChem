<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
 global $user;
 global $language;
 $lang = $language->language;
?>
<div id="top"></div>
<div id="page">
  
  
  <div id="header-bar" class="width">
  <div class="inner clearfix">
  	<div id="nav_toggle" class="mobile_toggle"><a class="icon menu open" href="#"><?php print t('Menu'); ?></a></div>
    <div id="search_toggle" class="mobile_toggle"><a class="icon search open" href="#"><?php print t('Search'); ?></a></div>
    <div id="login_toggle">
		<?php if (!user_is_logged_in()): ?>
        <a class="icon login open" href="#"><?php print t('Login'); ?></a>
        <?php endif; ?>
        <?php if (user_is_logged_in()): ?>
        <a class="icon account" href="<?php print ($lang == 'es'?'/es':''); ?>/user/<?php print $user->uid ?>/edit"><?php print t('My Account'); ?></a>
        <a class="icon logout" href="/user/logout"><?php print t('Logout'); ?></a>
        <?php endif; ?>
    </div>
    <div id="language_toggle">
    <?php
		$block = module_invoke('locale', 'block_view', 'language');
		print render($block['content']); 
	?>
    </div>
  </div>
  </div>
  
  
  <div id="utility-bar" class="width">
  <div class="inner">

    <div id="login" class="transition login">
    	<a class="icon closex"></a>
        <h2><?php print t('Client Area Access'); ?></h2>
    	<p><?php print t('Returning users can login to the Client Area to access documentation, news, and videos. New user?'); ?>
        <a href="<?php print ($lang == 'es'?'/es':''); ?>/user/register"><?php print t('Create a new account.'); ?></a></p>
        <h2><?php print t('Returning User Login'); ?></h2>
		<?php
            $block = module_invoke('user', 'block_view', 'login');
            print render($block);
        ?>
    </div>
    <div id="forgot-password" class="transition login">
    	<a class="icon closex"></a>
    	<h2><?php print t('Forgot Password'); ?></h2>
        <p><?php print t('Enter your username or email address and your new password will be sent to you.'); ?></p>
        <div class="load loading"></div>
    </div>
  
  </div>
  </div>
  
  
  <div id="slides" class="width nav_toggle mobile_ui">
  <div class="inner clearfix">
  
    <div id="header-nav" class="nav clearfix">
        <nav id="nav" role="navigation" class="transition">
		<?php
			$block = module_invoke('menu_block', 'block_view', 1);
			print render($block['content']);
		?>
        <div class="legal-menu">
        <?php
			$block = module_invoke('menu_block', 'block_view', 7);
			print render($block['content']);
		?>
        </div>
		</nav>
    </div>

  </div>
  
  <?php
  global $user;
  $roles = array('authenticated user');
  if (array_intersect($roles, $user->roles)): ?>
      <div id="logged-in-nav" class="width nav clearfix">
      <div class="inner clearfix">
        <?php
        $block = module_invoke('menu_block', 'block_view', 4);
        print render($block['content']);
        ?>
      </div>  
      </div>
  <?php endif; ?>

  </div>
  
  <div id="search-bar" class="width">
  <div class="inner clearfix">
      <div id="search" class="search_toggle mobile_ui">
      <?php
        $block = module_invoke('search', 'block_view', 'form');
        print render($block);
      ?>
      </div>
      </div>
  </div>


  <header class="header width clearfix" id="header" role="banner">
  <div class="inner clearfix">

    <div id="branding">
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="/<?php print path_to_theme().'/images/logo.png' ?>" alt="<?php print t('Home'); ?>" /></a>
        <div id="badge"><img src="/<?php print path_to_theme().'/images/badge_header.png' ?>" alt="Pace 30th Anniversary 1983-2013" /></div>
        <div id="bottles"></div>
        
        <div class="contact-details">
        <?php
            $block = module_invoke('block', 'block_view', 1);
            print render($block['content']);
        ?>
        </div>
    </div>

  </div>
  </header>
  
  
  <?php
  		if(isset($node) && $node->type == 'career'){ $node = node_load(16); }
		if(isset($node) && $node->type == 'news'){ $node = node_load(9); }
		if(isset($node) && $node->type == 'testimonial'){ $node = node_load(12); }
		if(isset($node) && $node->type == 'staff_member'){ $node = node_load(36); }
		if(isset($node) && $node->type == 'link'){ $node = node_load(12); }
		if(isset($node) && $node->type == 'client_area_video'){ $node = node_load(29); } 
		if(strpos(request_uri(), '/procedures') !== FALSE || strpos(request_uri(), '/procedimientos') !== FALSE){
			$node = node_load(18); }
		if(strpos(request_uri(), '/technical-bulletins') !== FALSE || strpos(request_uri(), '/bulletins-techniques') !== FALSE){
			$node = node_load(21);}
		if((strpos(request_uri(), '/search') !== FALSE)){
			$node = node_load(4);
			$node->title = 'Search';}
		if(isset($node->field_header_image['und'])){
			$header_image = file_create_url($node->field_header_image['und'][0]['uri']);
		} else{
			$aboutNode = node_load(4);
			$header_image = file_create_url($aboutNode->field_header_image['und'][0]['uri']);
		}
  ?>
  <div id="header-image" class="width" style="background-image:url(<?php print $header_image; ?>)">
  <div class="inner clearfix">

    <?php if($is_front): ?>
    	<h1><?php print $site_name; ?></h1>
        <h2><?php print $site_slogan; ?></h2>
    <?php else: ?>
    	<?php if (isset($node) && $node->title != ''): ?>
        	<h1 id="page-title"><?php print $node->title; ?></h1>
		<?php elseif ($title): ?>
            <h1 id="page-title"><?php print $title; ?></h1>
        <?php endif; ?>  
    <?php endif; ?>  
  
  </div>
  </div>


  <div id="main" class="width">
  <div class="inner clearfix">

    <div id="content" class="column" role="main">
      <a id="main-content"></a>
      <?php print $messages; ?>
      <?php print render($tabs); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <!--<?php if(isset($node) && !isset($node->field_header_image['und']) && $node->title != ''): ?>
      	<h1 id="page-title"><?php print $node->title; ?></h1>
	  <?php endif; ?>-->
	  <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </div>

    <?php
      // Render the sidebars to see if there's anything in them.
      $sidebar_first  = render($page['sidebar_first']);
      $sidebar_second = render($page['sidebar_second']);
    ?>

    <?php if ($sidebar_first || $sidebar_second): ?>
      <aside class="sidebars">
        <?php print $sidebar_first; ?>
        <?php print $sidebar_second; ?>
      </aside>
    <?php endif; ?>

  </div>
  </div> <!-- /#main -->
  
  <?php
	// Render the content areas to see if there's anything in them
	$content_two  = render($page['content_two']);
	$content_three = render($page['content_three']);
	$content_four = render($page['content_four']);
  ?>
  <?php if($content_two): ?>
  <div id="content_two" class="width">
  <div class="inner clearfix">
	<?php print render($page['content_two']); ?>
  </div>
  </div>
  <?php endif; ?>
  
  <?php if($content_three): ?>
  <div id="content_three" class="width">
  <div class="inner clearfix">
  	<?php print render($page['content_three']); ?>
  </div>
  </div>
  <?php endif; ?>
  
  <?php if($content_four): ?>
  <div id="content_four" class="width">
  <div class="inner clearfix">
  	<?php print render($page['content_four']); ?>
  </div>
  </div>
  <?php endif; ?>
  
  
  <footer id="footer" class="width blue-bg">
  <div class="inner clearfix">
  	
    <div id="footer-nav" class="nav clearfix">
    <?php
		$block = module_invoke('menu_block', 'block_view', 2);
		print render($block['content']);
	?>
    </div>
    
	<div class="address-details">
    <?php
		$block = module_invoke('block', 'block_view', 2);
		print render($block['content']);
	?>
    	<div class="legal-menu">
    	<?php
			$block = module_invoke('menu_block', 'block_view', 7);
			print render($block['content']);
		?>
        </div>
    </div>
    
    <div class="contact-details">
    <?php
		$block = module_invoke('block', 'block_view', 1);
		print render($block['content']);
	?>
    </div>
  
  	<?php print render($page['footer']); ?>
    
  </div>
  </footer>
  
  <a id="back-to-top" href="#top"><span><?php print t('Back to top'); ?></span></a>


</div>

