=== EarlyCart Sold ===
Contributors: dragokatic
Tags: woocommerce, bestseller, sales counter, product highlight, new arrival
Requires at least: 6.8
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Plugin URI: https://github.com/DragoKatic/earlycart-sold
Author URI: https://dragokatic.github.io/

Boost your WooCommerce store with bestseller badges and sales counters that build trust and highlight product activity.

== Description ==

**EarlyCart Sold** is a lightweight WooCommerce plugin that enhances product visibility with clear, data-driven sales indicators. It helps new and growing stores build trust by highlighting product activity while providing flexibility for strategic promotion.

- Products in the **selected category** are marked as *BESTSELLERS*. Their displayed “Units Sold” value is calculated using a **custom multiplier** set by the store admin.  
- Products in **all other categories** are shown as *New arrivals*, with the **real number of units sold** retrieved directly from WooCommerce orders.

This dual-display method allows merchants to emphasize selected products while maintaining authenticity across the catalog.

== Features ==

* Display a *BESTSELLER* badge with an adjusted "Units Sold" count for a chosen category.  
* Show a *New arrival* label with real WooCommerce sales data for all other products.  
* Configurable multiplier for calculated bestseller counts.  
* Category selection and multiplier input available in the admin settings.  
* Clean, responsive frontend template (override-ready in the `templates/` folder).  
* Custom CSS support via plugin settings.  
* Lightweight, performance-focused, and translation-ready.  

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`.  
2. Activate the plugin from the **Plugins** menu in WordPress.  
3. Go to plugin settings to:  
   - Select one product category for bestseller highlighting.  
   - Define a multiplier for bestseller sales counts.  
   - Optionally add custom CSS for styling labels.  

== Frequently Asked Questions ==

= Does this plugin work without WooCommerce? =  
No. WooCommerce must be active for the plugin to function.  

= How are bestseller sales numbers calculated? =  
For products in the selected category, the sales count is multiplied by the custom multiplier defined in the settings. All other products display their real sales count from WooCommerce orders.  

= Can I change the labels or styles? =  
Yes. Template files are located in the plugin’s `templates/` folder and can be overridden. Additional styling can be applied via custom CSS in the plugin settings.  

= Is this plugin safe for live stores? =  
Yes. It follows WordPress coding standards, retrieves data safely, and does not alter product records.  

== Screenshots ==

1. A *BESTSELLER* product with adjusted sales count.  
2. A *New arrival* product with real sales count.  
3. The plugin settings page (category selection, multiplier, custom CSS).  

== Changelog ==

= 1.0.0 =  
* Initial public release with bestseller highlighting and dual-label logic.  

== License ==

This plugin is licensed under the GNU General Public License v2.0 or later.  
See `license.txt` for details or visit: https://www.gnu.org/licenses/gpl-2.0.html