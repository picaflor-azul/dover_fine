<?php
/**
 * Module Template - categories_tabs
 *
 * Template stub used to display categories-tabs output
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_categories_tabs.php 3395 2006-04-08 21:13:00Z ajeh $
 */
?>

<?php

function zen_get_categories_li_menu($categories_ul_li = '', $parent_id = '0', $cpath = '') {
  global $db;
        $categories_query = "select c.categories_id, cd.categories_name, c.categories_status
                                                 from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                                 where " . $zc_status . "
                                                 parent_id = '" . (int)$parent_id . "'
                                                 and c.categories_status = TRUE
                                                 and c.categories_id = cd.categories_id
                                                 and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                                 order by sort_order, cd.categories_name";
        $categories = $db->Execute($categories_query);
        $categories_ul_li .= "<ul>";
        while (!$categories->EOF) {
	  $dpath = $cpath.$categories->fields['categories_id'];
	  $catcount = zen_count_products_in_category($categories->fields['categories_id']);
	  if (SHOW_COUNTS == 'true') {
	    if ((CATEGORIES_COUNT_ZERO == '1' and $catcount == 0) or $catcount >= 1) {
	      $result = CATEGORIES_COUNT_PREFIX . $catcount . CATEGORIES_COUNT_SUFFIX;
	    }
	  }
	  $categories_ul_li .= "<li><a href='index.php?main_page=index&amp;cPath=$dpath'>".$categories->fields['categories_name']. $result . '</a>';
	  if ($categories->fields['categories_id'] != $parent_id) {
	    if(zen_has_category_subcategories($categories->fields['categories_id'])){
	      $categories_ul_li = zen_get_categories_li_menu($categories_ul_li, $categories->fields['categories_id'], $dpath.= "_");
	    }
	  }
	  $categories_ul_li .= "</li>";
	  $categories->MoveNext();
        }
        $categories_ul_li .= "</ul>";
        return $categories_ul_li;
  }

?>


<div id="menu" class="hidden">
<ul class="slimmenu">

    <li><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>"><?php echo HEADER_TITLE_CART; ?>&nbsp;&nbsp;(<?php echo $_SESSION['cart']->count_contents();?>  - <?php echo $currencies->format($_SESSION['cart']->show_total());?>)</a></li>
   <?php if ($_SESSION['cart']->count_contents() != 0) { ?>
<?php }?>


 <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><?php echo HEADER_TITLE_CATALOG; ?></a></li>
<?php if ($_SESSION['customer_id']) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
<?php
      } else {
        if (STORE_STATUS == '0') {
?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a></li>
<?php } } ?>

    <li><a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>" class="mshop"><?php echo HEADER_TITLE_CATEGORIES; ?></a>
    <?php 
    $slim_cats = zen_get_categories_li_menu();
    echo "$slim_cats";
?>
</li>



<li><a href="<?php echo zen_href_link(FILENAME_SHIPPING); ?>" class="minfo"><?php echo HEADER_TITLE_INFORMATION; ?></a>
    <ul class="level2">
    <li><a href="<?php echo zen_href_link(FILENAME_SHIPPING); ?>"><?php echo HEADER_TITLE_CUSTOMER_SERVICE; ?></a>
    <ul>
  <?php if (DEFINE_ABOUT_US_STATUS <= 1) { ?>
  <li><a href="<?php echo zen_href_link(FILENAME_ABOUT_US); ?>"><?php echo BOX_INFORMATION_ABOUT_US; ?></a></li>
  <?php } ?>
  <?php if ($_SESSION['customer_id']) { ?>
  <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
   <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGOFF; ?></a></li>
   <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL'); ?>"><?php echo TITLE_NEWSLETTERS; ?></a></li>
    <?php } else { ?>
  <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a></li>
   <li><a href="<?php echo zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_CREATE_ACCOUNT; ?></a></li>
   <?php } ?>
<?php if (DEFINE_SHIPPINGINFO_STATUS <= 1) { ?>
  <li><a href="<?php echo zen_href_link(FILENAME_SHIPPING); ?>"><?php echo BOX_INFORMATION_SHIPPING; ?></a></li>
  <?php } ?>
  <?php if (DEFINE_PRIVACY_STATUS <= 1)  { ?>
  <li><a href="<?php echo zen_href_link(FILENAME_PRIVACY); ?>"><?php echo BOX_INFORMATION_PRIVACY; ?></a></li>
<?php } ?>
<?php if (DEFINE_CONDITIONS_STATUS <= 1) { ?>
  <li><a href="<?php echo zen_href_link(FILENAME_CONDITIONS); ?>"><?php echo BOX_INFORMATION_CONDITIONS; ?></a></li>
     <?php } ?>
    </ul>
    </li>
    <li><a href="<?php echo BOX_INFORMATION_SITE_MAP; ?>">General Info</a>
    <ul>
  <?php if (DEFINE_SITE_MAP_STATUS <= 1) { ?>
   <li><a href="<?php echo zen_href_link(FILENAME_SITE_MAP); ?>"><?php echo BOX_INFORMATION_SITE_MAP; ?></a></li>
   <?php } ?>
   <?php if (MODULE_ORDER_TOTAL_GV_STATUS == 'true') { ?>
  <li><a href="<?php echo zen_href_link(FILENAME_GV_FAQ, '', 'NONSSL'); ?>"><?php echo BOX_INFORMATION_GV; ?></a></li>
<?php } ?>
<?php if (MODULE_ORDER_TOTAL_COUPON_STATUS == 'true') { ?>
  <li><a href="<?php echo zen_href_link(FILENAME_DISCOUNT_COUPON, '', 'NONSSL'); ?>"><?php echo BOX_INFORMATION_DISCOUNT_COUPONS; ?></a></li>
    <?php } ?>
       <?php if (SHOW_NEWSLETTER_UNSUBSCRIBE_LINK == 'true') { ?>
  <li><a href="<?php echo zen_href_link(FILENAME_UNSUBSCRIBE, '', 'NONSSL'); ?>"><?php echo BOX_INFORMATION_UNSUBSCRIBE; ?></a></li>
      <?php } ?>
    </ul>
    </li>
    <li><a href="<?php echo BOX_INFORMATION_SITE_MAP; ?>"><?php echo TITLE_EZ_PAGES; ?></a>
    <ul>
  <?php require(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/' . 'ezpages_drop_menu.php'); ?>
    </ul>
    </li>
    </ul>
    </li>
    <li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US, '', 'NONSSL'); ?>" class="mcontact"><?php echo BOX_INFORMATION_CONTACT; ?></a></li>

<li><a href="<?php echo zen_href_link(FILENAME_ADVANCED_SEARCH); ?>"><?php echo BOX_SEARCH_ADVANCED_SEARCH; ?></a></li>
<li class="menu-social"><div id="header-icons"><a href="https://www.facebook.com/Custom.Zen.Cart.Design" target="_blank"><i class="fa fa-facebook"></i></a><a href="https://twitter.com/picaflorazul" target="_blank"><i class="fa fa-twitter"></i></a><a href="http://www.pinterest.com/picaflorazul" target="_blank"><i class="fa fa-pinterest"></i></a><a href="https://www.youtube.com/user/ZenCartEasyHelp" target="_blank"><i class="fa fa-youtube"></i></a><a href="" target="_blank"><i class="fa fa-instagram"></i></a></div></li>

</ul>


</div>

<script src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/jquery.slimmenu.min.js' ?>" type="text/javascript"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" type="text/javascript"></script> 

  <?php if ($detect->isMobile() && !$detect->isTablet() or $detect->isMobile() && !$detect->isTablet() && $_SESSION['display_mode']=='isMobile' or $detect->isTablet() && $_SESSION['display_mode']=='isMobile' or $_SESSION['display_mode']=='isMobile') { ?>

<script type="text/javascript">
																															    $('ul.slimmenu').slimmenu(
    {
    resizeWidth: '800',
	collapserTitle: '',
	animSpeed: 'medium',
	easingEffect: null,
	indentChildren: false,
	childrenIndenter: '&nbsp;'
	});
</script>

																															    <?php } else if ($detect->isTablet() or $detect->isMobile() && $_SESSION['display_mode']=='isTablet' or $detect->isTablet() && $_SESSION['display_mode']=='isTablet' or $_SESSION['display_mode']=='isTablet'){ ?>

<script type="text/javascript">
    $('ul.slimmenu').slimmenu(
			      {
			      resizeWidth: '800',
				  collapserTitle: '',
				  animSpeed: 'medium',
				  easingEffect: null,
				  indentChildren: false,
				  childrenIndenter: '&nbsp;'
				  });
</script>

    <?php } else if ($detect->isMobile() && !$detect->isTablet() && $_SESSION['display_mode']=='isDesktop' or $detect->isTablet() && $_SESSION['display_mode']=='isDesktop' or $_SESSION['display_mode']=='isNonResponsive'){ ?>

<script type="text/javascript">
    $('ul.slimmenu').slimmenu(
			      {
			      resizeWidth: '0',
				  collapserTitle: '',
				  animSpeed: 'medium',
				  easingEffect: null,
				  indentChildren: false,
				  childrenIndenter: '&nbsp;'
				  });
</script>

    <?php } else { ?>

<script type="text/javascript">
    $('ul.slimmenu').slimmenu(
			      {
			      resizeWidth: '800',
				  collapserTitle: '',
				  animSpeed: 'medium',
				  easingEffect: null,
				  indentChildren: false,
				  childrenIndenter: '&nbsp;'
				  });
</script>

    <?php } ?>

