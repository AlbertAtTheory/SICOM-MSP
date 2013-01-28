<?php
?>


  <div id="wrapper">
    <div id="container" class="clearfix">

      <div id="header">
        <div id="logo-floater">
        <?php if ($logo || $site_title): ?>
          <?php if ($title): ?>
            <div id="branding"><strong><a href="<?php print $front_page ?>">
            <?php if ($logo): ?>
              <img src="<?php print $logo ?>" alt="<?php print $site_name_and_slogan ?>" title="<?php print $site_name_and_slogan ?>" id="logo" />
            <?php endif; ?>
            <?php print $site_html ?>
            </a></strong></div>
          <?php else: /* Use h1 when the content title is empty */ ?>
            <h1 id="branding"><a href="<?php print $front_page ?>">
            <?php if ($logo): ?>
              <img src="<?php print $logo ?>" alt="<?php print $site_name_and_slogan ?>" title="<?php print $site_name_and_slogan ?>" id="logo" />
            <?php endif; ?>
            <?php print $site_html ?>
            </a></h1>
        <?php endif; ?>
        <?php endif; ?>
        </div>
			<div class="header-right"><?php print render($page['header']); ?><?php if ($primary_nav && 1==0): print $primary_nav; endif; ?></div>
		
        
        
      </div> <!-- /#header -->
      
      
            <div id="content-mid-wrapper">
      
      
      <div class="clearfix"><?php print $messages; ?>
            <?php print render($page['content']); ?>
          </div>
          </div><!-- End of #content-mid-wrapper -->
      
      
      

 <div id="footer-content">
          	<div class="footer-block">
		 		 <?php print render($page['footer']); ?>
         	 </div>
          </div> <!-- End of #footer-content --> <!-- /.left-corner, /.right-corner, /#squeeze, /#center -->

      <?php if ($page['sidebar_second']): ?>
        <div id="sidebar-second" class="sidebar">
          <?php print render($page['sidebar_second']); ?>
        </div>
      <?php endif; ?>

    </div> <!-- /#container -->
  </div> <!-- /#wrapper -->
