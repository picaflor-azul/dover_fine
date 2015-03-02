<?php

function zen_get_categories_li($categories_ul_li = '', $parent_id = '0', $cpath = '') {
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
	      $categories_ul_li = zen_get_categories_li($categories_ul_li, $categories->fields['categories_id'], $dpath.= "_");
	    }
	  }
	  $categories_ul_li .= "</li>";
	  $categories->MoveNext();
        }
        $categories_ul_li .= "</ul>";
        return $categories_ul_li;
  }


  $content = "";
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">' . "\n";
  $content .=  zen_get_categories_li();

  if (SHOW_CATEGORIES_BOX_SPECIALS == 'true' or SHOW_CATEGORIES_BOX_PRODUCTS_NEW == 'true' or SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS == 'true' or SHOW_CATEGORIES_BOX_PRODUCTS_ALL == 'true') {
// display a separator between categories and links
    if (SHOW_CATEGORIES_SEPARATOR_LINK == '1') {
      $content .= '<hr id="catBoxDivider" />' . "\n";
    }
    if (SHOW_CATEGORIES_BOX_SPECIALS == 'true') {
      $show_this = $db->Execute("select s.products_id from " . TABLE_SPECIALS . " s where s.status= 1 limit 1");
      if ($show_this->RecordCount() > 0) {
        $content .= '<a class="category-links" href="' . zen_href_link(FILENAME_SPECIALS) . '">' . CATEGORIES_BOX_HEADING_SPECIALS . '</a>' . "\n";
      }
    }
    if (SHOW_CATEGORIES_BOX_PRODUCTS_NEW == 'true') {
      // display limits
//      $display_limit = zen_get_products_new_timelimit();
      $display_limit = zen_get_new_date_range();

      $show_this = $db->Execute("select p.products_id
                                 from " . TABLE_PRODUCTS . " p
                                 where p.products_status = 1 " . $display_limit . " limit 1");
      if ($show_this->RecordCount() > 0) {
        $content .= '<a class="category-links" href="' . zen_href_link(FILENAME_PRODUCTS_NEW) . '">' . CATEGORIES_BOX_HEADING_WHATS_NEW . '</a>' . "\n";
      }
    }
    if (SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS == 'true') {
      $show_this = $db->Execute("select products_id from " . TABLE_FEATURED . " where status= 1 limit 1");
      if ($show_this->RecordCount() > 0) {
        $content .= '<a class="category-links" href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS) . '">' . CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS . '</a>' . "\n";
      }
    }
    if (SHOW_CATEGORIES_BOX_PRODUCTS_ALL == 'true') {
      $content .= '<a class="category-links" href="' . zen_href_link(FILENAME_PRODUCTS_ALL) . '">' . CATEGORIES_BOX_HEADING_PRODUCTS_ALL . '</a>' . "\n";
    }
  }
  $content .= '</div>';

