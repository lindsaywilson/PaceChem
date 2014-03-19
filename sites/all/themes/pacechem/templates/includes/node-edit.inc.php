<?php
// Roles that can edit
global $user;
$roles = array('administrator','Client Admin');

// If current user has edit role
if (array_intersect($roles, $user->roles)): ?>

	<div class="views-field-edit-node"><a class="edit-node" href="/node/<?php print $nid ?>/edit">Edit <?php print node_type_get_name($node) ?></a></div>
    
<?php endif; ?>

