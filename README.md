# EarlyCart Sold

**EarlyCart Sold** is a lightweight WordPress plugin that enhances WooCommerce product displays with dynamic sales indicators.  
It shows the **real number of sold units** for products outside the selected category, while products in the **chosen category** are highlighted with a **custom label** (default: *BESTSELLER*) and an **adjusted sales count** calculated using a configurable multiplier.

The label text, styling, and multiplier logic are fully customizable via the WordPress admin panel with safe HTML and CSS.  
By default, the target category is **Uncategorized**, but it can be set to any existing product category. This makes the plugin a flexible solution for developers who want precise control over frontend output.

## Features

- Shows the actual **sold product count** for all WooCommerce products outside the selected category (including `0` for unsold items).
- For products in the **selected category**, it additionally displays:
  - A **custom label** (default: BESTSELLER)
  - An **adjusted sales count**, calculated by multiplying the product ID with the defined multiplier (default: 2)
- Simple and intuitive admin interface:
  - Select the target product category (default: Uncategorized)
  - Enter label text with safe HTML
  - Apply custom CSS styles
  - Define a multiplier for bestseller counts
- Automatic frontend output on:
  - **Shop pages** (product listings)
  - **Single product pages**
- Clean, dependency-free codebase
- Secure and performant — **JavaScript input is disabled**

## Installation

1. Upload the plugin folder to `/wp-content/plugins/`.
2. Activate the plugin from the **Plugins** menu in WordPress.
3. Open the plugin settings page in the WordPress admin.
4. Configure the following:
   - Target category for bestseller highlighting (default: Uncategorized)
   - Label content (optional HTML)
   - CSS styling for the label and count
   - Multiplier for bestseller sales counts
5. Once saved, the output will automatically appear:
   - On **Shop pages** for products in the selected category, showing the *BESTSELLER* label and adjusted sales count
   - On **Product pages** for products in the selected category  
   - Products outside the selected category show their actual sales count with a *New arrival* label

## FAQ

**Does this plugin require WooCommerce?**  
Yes. EarlyCart Sold integrates with WooCommerce to retrieve and display sales data.

**Can I customize the styles and labels?**  
Yes. You can use safe HTML tags like `<span>`, `<strong>`, etc., and add custom CSS for full styling control.

**Is the label text translatable?**  
The default label (*BESTSELLER*) can be changed in the admin panel. Plugin setting fields are localizable via standard WordPress translation tools.

**Where are the settings stored?**  
All configuration — label, CSS, multiplier, and selected category — is securely stored in the WordPress database.

**Can I extend or modify this plugin?**  
Absolutely. EarlyCart Sold follows WordPress coding standards and is open-source under GPLv2 or later.

## Screenshots

1. Plugin admin interface: category selector, label editor, multiplier input, and CSS styling field.  
2. Example frontend display of a product in the selected category with label and adjusted sales count.  
3. Example frontend display of a product outside the selected category with *New arrival* label and real sales count.  

## Changelog

**1.0.0**  
* Initial public release with dual-label logic and sales indicators:  
  * *BESTSELLER* label with adjusted sales count for products in the selected category  
  * *New arrival* label with real sales count for other products  

## License

This plugin is licensed under the GNU General Public License v2.0 or later.  
See [`license.txt`](license.txt) for details.

## Author

[Drago Katić](https://dragokatic.github.io/)

---

**EarlyCart Sold** is designed for developers and store owners who need flexible, customizable **sales indicators and product highlights**, without relying on bulky visual builders or theme constraints.