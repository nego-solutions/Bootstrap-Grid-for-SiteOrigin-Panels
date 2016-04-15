# Bootstrap-Grid-for-SiteOrigin-Panels

This project is in preAlpha.

To try it out just use the "Download zip" button on the right hand side and upload the zip file as a WordPress Plugin.


*As with SiteOrigin Panels the plugin won't work out of the box with any theme! We recommend using a bootstrap style for your theme.

A simple but efficient page template to use with this plugin is:


```
<?php
/**
 * Template Name: SO Panels Bootstrap
 */

get_header();
?>
<div class="container">
    <h1 id="page-title"><?php the_title();?></h1>
</div>
<?php

the_content();


get_footer();
```

this way you'll make sure the full width of the page is used for your content and you can then just play with container vs container-fluid options.

Have fun for now!
