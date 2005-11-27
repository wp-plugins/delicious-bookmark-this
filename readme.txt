=== del.icio.us - Bookmark this! ===

Tags: wordpress, plugin, delicious, bookmark
Contributors: Arne

This plugin will allow you to add an “Bookmark this page on del.icio.us” link on you sidebar / posts / wherever.

== Installation ==

1. Upload the full directory into your wp-content/plugins directory
2. Activate it in the Plugin options
3. Put the following code in your template where you want to place the bookmark link: <?php dbt_getLinkTag(”Bookmark on del.icio.us”); ?> This will bookmark the CURRENT PAGE
4. If you want to bookmark the CURRENT POST, use <?php dbt_the_LinkTag(”Bookmark on del.icio.us”); ?> inside the loop.

== Frequently Asked Questions == 

= Can I use an image as the link? =
Yes you can! Just use the image tag as the text. Example: <?php dbt_getLinkTag(”<img src='book.gif' border='0' />”); ?>

= Can i specify a CSS class for the link? =
Yes you can! Just supply a second parameter to the function. Example: <?php dbt_getLinkTag(”Bookmark on del.icio.us”,"class='link'"); ?>
