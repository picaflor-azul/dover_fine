<?php
/**Single Listing Template mod v1.8
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_product_listing.php 3241 2006-03-22 04:27:27Z ajeh $
 * UPDATED TO WORK WITH COLUMNAR PRODUCT LISTING 04/04/2006
 * Modified by Anne (Picaflor-Azul.com) Dover Fine v1.0
 */
?>
 <div class="centerColumn" id="featuredDefault">
<h1 id="featuredDefaultHeading"><?php echo HEADING_TITLE; ?></h1>
<?php
if (TEMPLATE_DEBUG == 'True') echo '\includes\templates\TEMPLATES\templates\tpl_featured_products_default.php<br />then requires tpl_modules_listing_display_order.php<br />then tpl_modules_product_listing.php<br /><br />';//SLT debug
require($template->get_template_dir('/tpl_modules_listing_display_order.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_display_order.php');
require($template->get_template_dir('tpl_modules_product_listing.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_product_listing.php');
?>
</div>