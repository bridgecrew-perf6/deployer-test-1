<?php
/**
 * Template for entry meta
 *
 * @package awps
 */

use Awps\Models\Post;

?>

<div class="entry-meta">
	<?php Post::posted_on(); ?>
	<?php Post::posted_by(); ?>
</div>
