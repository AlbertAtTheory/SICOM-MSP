<?php
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print $user_picture; ?>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php if ($display_submitted): ?>
    <span class="submitted"><?php print $submitted ?></span>
  <?php endif; ?>

<div id="blog-post-wrapper">

  <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
	  print theme('breadcrumb', array('breadcrumb' => drupal_get_breadcrumb()));
	  ?>
      
      <div class="view-header"> <h2>
	  <?php
      print render($node->title);
	  ?></h2></div>
      <?php print views_embed_view('views_blogs','block_1', $node->nid); ?>
      <?php print render($content);
    ?>
    <?php print views_embed_view('views_blogs','block_2'); ?>
    
    
  </div>
  </div>

  <div class="clearfix blog-post-comments">
    <!--<?php if (!empty($content['links'])): ?>
      <div class="links"><?php print render($content['links']); ?></div>
    <?php endif; ?>-->

    <?php print render($content['comments']); ?>
    
    <?php print views_embed_view('views_blogs','block_3'); ?>
    
    <?php $block = module_invoke('taxonomy_block', 'block_view', 'taxonomy_block');
	?>
    <div class = "blog-post-category">
	   <div class="view-header"> <h2>
	  <?php
      print "CATEGORIES";
	  ?></h2></div>
      	<?php print render($block['content']); ?>
</div>
  </div>

</div>
