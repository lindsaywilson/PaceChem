<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h2><?php print $title; ?></h2>
<?php endif; ?>
<?php foreach ($rows as $id => $row): 

	switch($view->name){
  	case 'news':
		if($view->current_display == 'home'){
			$classes_array[$id] .= ' grid';
		}
		break;
	case 'links':
	case 'contact':
	case 'industry_partners':
		$classes_array[$id] .= ' grid';
	break;
  }
  $classes_array[$id] .= ' clearfix';

?>


  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
    <div class="inner">
	<?php print $row; ?>
    </div>
  </div>
<?php endforeach; ?>