=== WP Ultimate Post Grid ===
Contributors: BrechtVds
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QG7KZMGFU325Y
Tags: grid, isotope, filter, custom post type
Requires at least: 3.5
Tested up to: 6.5
Stable tag: 3.9.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily create filterable responsive grids for your posts, pages or custom post types

== Description ==

Use WP Ultimate Post Grid to create responsive grids for your posts, pages or any custom post type. Optionally add an isotope filter for any taxonomy associated with those posts.

> <strong>See this plugin in action!</strong><br>
> Check out [demos of our grids](https://bootstrapped.ventures/wp-ultimate-post-grid/) and all of the [plugin documentation](https://help.bootstrapped.ventures/collection/7-wp-ultimate-post-grid) to learn more.

An overview of the WP Ultimate Post Grid features:

*   **Live Preview** while building your grid
*   Use posts, pages or **custom post types** as the source
*   Grids are **responsive** and will look good on any device
*   Ability to set **order by** options
*   Link to the actual **post or featured image**
*   Define **custom links** for posts
*   Define **custom images** for posts
*   Add an **isotope filter** for any taxonomy or custom field
*   **Deeplinking** directly to a filtered grid
*   Grids and filters can be added anywhere with **their own shortcode**
*   Multiple **templates** for your grids
*   Extensive **Template Editor** to create any grid you want
*   Possibility to use **pagination**
*   Compatible with both **Classic Editor and Gutenberg** Block Editor
*   Fully integrated with our WP Recipe Maker plugin for a **recipe  grid**

We also have a [WP Ultimate Post Grid Premium version](https://bootstrapped.ventures/wp-ultimate-post-grid/) which offers the following features:

*   **Limit your posts** by any taxonomy, author, date or post ID
*   Use a **plain text filter** for your grid
*   Have **dropdown filters** for any taxonomy
*   Use a **checkbox filter** for any taxonomy
*   Allow for **multiselect** in the filters
*   Show the **post count** for the filter terms
*   Create a grid of your **categories or tags**
*   A **Load More button** for pagination
*   **Load on filter** pagination
*   **Infinite scroll** pagination
*   Easily **clone your grids**
*   Order grid by **custom field**
*   **Dynamically filter** grids in the shortcode

This plugin is under active development. Any feature requests are welcome!

== Installation ==

1. Upload the `wp-ultimate-post-grid` directory (directory included) to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create a new grid through the 'Grid' menu
1. Add the grid and or filter shortcode where you want them to appear

== Frequently asked questions ==

= Where can I find a demo and some more documentation? =
Check out the [WP Ultimate Post Grid demo site](https://bootstrapped.ventures/wp-ultimate-post-grid/) and [WPUPG documentation](https://help.bootstrapped.ventures/collection/7-wp-ultimate-post-grid) for more information on all of the features!

= Who made this? =

[Bootstrapped Ventures](https://bootstrapped.ventures)

== Screenshots ==

1. Easily create multiple grids with Live Preview
2. Use Gutenberg Blocks to add your grids to any post or page...
3. ...or use the WP Ultimate Post Grid icon in the Classic Editor
4. Customize the look & feel to match your website style
5. Different free templates that are fully responsive and work on desktop, tablet and mobile

== Changelog ==
= 3.9.3 =
* Fix: Search filter not working with some pagination options when all items had been loaded

= 3.9.2 =
* Feature: Fuzzy matching for custom field filter
* Fix: Prevent misuse of tag attribute in shortcodes
* Fix: Prevent API call if all items have already been loaded
* Fix: Shortcodes inside of template conditions
* Fix: Transition CSS missing unit

= 3.9.1 =
* Fix: Some pages not loading correctly when using adaptive pages pagination

= 3.9.0 =
* Feature: Specify WPML language you want to show in a grid
* Feature: RTL Mode
* Feature: Reorder taxonomies for isotope filter
* Improvement: Better limiting of item content
* Improvement: Set Item Image and Item Name link to open in new tab
* Fix: Incorrect number of items on adaptive pages after filtering
* Fix: Field match condition with empty values
* Fix: Sanitization of shortcode attributes
* Fix: Correct label for data source post statusses
* Fix: Permissions to access manage page
* Fix: Prevent PHP deprecation notice
* Fix: Gutenberg deprecations

= 3.8.0 =
* Feature: Side by Side template
* Feature: Show/toggle/hide filters on different devices
* Feature: New layout mode "Items in rows, forcing same height”
* Feature: Use ID placeholder in template to dynamically construct shortcodes
* Feature: Takeover shortcode attribute to use in theme files
* Feature: Optionally set maximum number of buttons for pages pagination
* Feature: Include or exclude password protected posts
* Feature: General blocks for the template editor (text, link, image and icon)
* Feature: Item Link block for the template editor
* Feature: Display modified date in the template editor
* Improvement: Ability to show pending or draft posts
* Improvement: More order by options (modified, author and comment count)
* Improvement: Hook to output something after specific item numbers
* Fix: Grid layout in block based themes
* Fix: Make sure template styling gets loaded with 0 initial posts
* Fix: Prevent error when setting posts per page to 0
* Fix: Prevent filters not loading when taxonomy is removed
* Fix: Prevent deprecated notice related to block editor
* Fix: Prevent deprecation notice related to get_users in WordPress 5.9

= 3.7.1 =
* Fix: Filter problem with pages pagination in some edge cases
* Fix: PHP Notice

= 3.7.0 =
* Feature: Adaptive pages pagination
* Feature: Support for different ACF field types in the Template Editor
* Feature: Set nopin attribute for images in the Template Editor
* Feature: Index template
* Improvement: Option to ignore HTML when using the limit text feature
* Improvement: Setting to prevent lazy image loading
* Improvement: Filter hook for term name output
* Fix: Prevent incorrect query warning

= 3.6.0 =
* Feature: Clear all selections button
* Feature: Output ItemList metadata for grid items
* Feature: Change term order in Template Editor
* Improvement: Trigger global JS event on grid init
* Fix: Filter problem with non-latin characters
* Fix: Sticky hover button color on mobile
* Fix: Wishlist Member compatibility problem

= 3.5.1 =
* Fix: Filters not working correctly in some environments
* Fix: Plugin sidebar problem in Gutenberg after unpinning

= 3.5.0 =
* Feature: New free Ruled template
* Feature: Block display style for item terms
* Feature: Show author image in template editor
* Feature: Link item image in template editor
* Feature: Spacer block for template editor
* Improvement: Major performance boost for filters
* Fix: Prevent PHP notices in WordPress 5.5

= 3.4.0 =
* Feature: Template Editor as part of the free plugin
* Feature: Allow links for terms block in Template Editor
* Improvement: Use i18n date function to make sure the date language is correct
* Fix: Filter problem with multiple multi-select "OR" filters

= 3.3.0 =
* Feature: Filter by custom fields
* Improvement: Better browser compatibility
* Fix: Layout with items in set number of columns not working in some themes
* Fix: Icons on Manage page not showing up on some server configurations
* Fix: Hustle plugin compatibility

= 3.2.1 =
* Fix: Compatibility with Newsletter plugin

= 3.2.0 =
* Improvement: Don't force close on save
* Fix: Better compatibility with JS deferring plugins

= 3.1.0 =
* Feature: Show filters on side of the grid
* Feature: Optional labels for filters
* Feature: Set border-radius for Isotope Filter and Pages Pagination
* Feature: Ability to reorder filters
* Feature: Option to display filters inline
* Improvement: Better grid display before page has fully loaded
* Improvement: Set global $post object for each grid item
* Improvement: Grid post type should not be public
* Improvement: Show grid name when editing
* Improvement: Setting to choose what taxonomies to display the grid fields for
* Fix: Hover color sticking in isotope filter because of keyboard focus

= 3.0.1 =
* Feature: Display private posts in a grid
* Fix: Images not showing correctly in Media post type grid
* Fix: Not saving "Items in Rows" layout mode

= 3.0.0 =
* Feature: Live Preview of grid when editing
* Feature: Gutenberg blocks for grid and filters
* Feature: Disable deeplinking per grid
* Feature: Set different layout for desktop, tablet and mobile
* Feature: Order terms by count
* Feature: Create and combine multiple filters
* Fix: Working pagination when using random order

= 2.8.2 =
* Improvement: Combined and minified JS files
* Improvement: Only load JS files on pages with a grid

= 2.8.1 =
* Fix: ACF Compatibility problem

= 2.8.0 =
* Feature: No cache mode to improve compatibility (WPML)
* Improvement: WordPress 5.0 compatibility
* Improvement: Make sure grid only gets loaded once

= 2.7.1 =
* Improvement: Privacy policy content
* Fix: Isotope filter active color problem when using text search feature

= 2.7.0 =
* Feature: Group different taxonomies on separate lines in isotope filter
* Improvement: Setting to prevent cache issues when using a membership plugin
* Improvement: Hook to filter query arguments when generating grid cache
* Fix: Prevent SERVER_PORT warning when using WPCLI
* Fix: PHP Notice in VafPress vendor

= 2.6.2 =
* Fix: PHP 7.2 deprecated function

= 2.6.1 =
* Fix: Deeplinking not working

= 2.6.0 =
* Improvement: Accessibility for the isotope filter
* Improvement: Performance when saving a grid with many terms
* Improvement: Plugin header for translations
* Fix: Prevent notice when saving grid without terms

= 2.5.0 =
* Feature: Random order picks new random posts every load
* Improvement: WordPress 4.8 compatibility
* Fix: Make sure most recent version of grid is shown when scheduling posts
* Fix: Show empty grid message when empty from the start

= 2.4.0 =
* Improvement: Prevent slowdown in front-end when regenerating
* Improvement: Add taxonomy classes to isotope terms
* Improvement: Update Isotope library to latest version
* Improvement: Prevent isotope conflicts with other plugins or themes
* Fix: Compatibility with events plugin
* Fix: Prevent jump to top in Firefox

= 2.3.1 =
* Feature: Upcoming giveaway surprise
* Improvement: WordPress 4.7 compatibility

= 2.3 =
* Feature: Isotope term order options

= 2.2 =
* Feature: Show empty terms in grid filter
* Improvement: WordPress 4.6 compatibility
* Improvement: Prevent scroll to top in some themes
* Improvement: Setting to hide the meta box for specific post types
* Fix: Scrolling to top issue in Firefox and IE
* Fix: Display non-public post types in a grid

= 2.1 =
* Feature: Show message when no items to display
* Feature: Set custom link behaviour for each grid item
* Improvement: Update Isotope to version 3.0.1
* Improvement: Filter hooks for grid assets
* Fix: Prevent scroll to top when using All filter
* Fix: Image conditions when using attachments as data source
* Fix: Shortcode modal compatibility issues

= 2.0 =
* Feature: Change hide and show animation
* Feature: Animation for grid container
* Improvement: Use better thumbnail image if available
* Improvement: Different character for deep links
* Improvement: Ability to add classes to the grid item links for integration with other plugins
* Improvement: Update Select2 to version 4.0.2
* Fix: Problem with limit terms feature
* Fix: Animation issue when using pagination
* Fix: Custom links and custom images for media attachments

= 1.9 =
* Feature: Ability to order by menu order (usually used by pages)
* Improvement: scroll to grid top on page change
* Fix: Shortcode editor lightbox problem with some themes
* Fix: Reverted Select2 to version 4.0.0 for less CSS problems

= 1.8 =
* Feature: Grid now works with media attachments (images on your website)
* Feature: Use inverse filters, hide items on select
* Feature: Set custom image to use instead of featured image
* Feature: New free "Hover with Date" template
* Improvement: WordPress 4.4 compatibility
* Improvement: Updated Select2 to version 4.0.1

= 1.7.2 =
* Fix: Problem with some PHP versions

= 1.7.1 =
* Fix: Problem with some PHP versions

= 1.7 =
* Feature: Manually define links for grid items
* Feature: Limit terms shown in filter
* Feature: Limit the total number of posts in the grid
* Improvement: Better support for RTL languages
* Improvement: Empty button text hides the All button for the Isotope Filter
* Improvement: Nicer permalinks in grid
* Improvement: Isotope 2.2.2
* Fix: Problem with non-latin characters

= 1.6 =
* Feature: Change the animation speed in the settings
* Feature: Change the “All” button text for the Isotope Filter
* Feature: Choose post or featured image as the link destination when clicking on an item in the grid
* Improvement: Better grid layout before Javascript kicks in
* Improvement: Only include admin assets on grid edit page
* Fix: Problem with sticky posts always showing up
* Fix: PHP notices in certain cases
* Fix: Term slugs with non-latin characters
* Fix: Shortcode editor compatibility problem with some themes

= 1.5 =
* Feature: New “Overlay” template
* Feature: New layout mode option to have items in rows
* Feature: Ability to center the grid in the masonry layout
* Improvement: FAQ page with some more documentation
* Improvement: wpupg_output_grid_html filter hook
* Fix: Deeplinking problem with URL encoded characters

= 1.4 =
* Feature: Link options for the grid (open in new tab, same tab or no link)
* Feature: Shortcode editor to easily add grid and filter in the visual editor
* Fix: Relayout grid after images are loaded
* Fix: Admin JS error

= 1.3 =
* Feature: Pagination

= 1.2 =
* Feature: Set active colors for isotope filter
* Feature: Deeplinking to selected tags with isotope filter
* Feature: New "Simple with Excerpt" template

= 1.1 =
* Fix: Firefox compatibility

= 1.0 =
* Very first version of this plugin

== Upgrade notice ==
= 3.9.3 =
Update when using the search filter

= 3.9.2 =
Prevent potential misuse or shortcodes by logged in users

= 3.9.1 =
Prevent issue with some pages not loading when using the adaptive pages pagination

= 3.9.0 =
Update to ensure WordPress 6.2 compatibility and get some new features and improvements

= 3.8.0 =
Lots of new features and improvements and compatibility with block-based themes

= 3.7.1 =
Prevent issues in some edge cases

= 3.7.0 =
Some great new features and improvements

= 3.6.0 =
Update for better compatibility and some new features

= 3.5.1 =
Update to prevent filter problems

= 3.5.0 =
Update for a major performance improvement and some new template features

= 3.4.0 =
New Template Editor for the free plugin

= 3.3.0 =
Better browser and theme compatibility and a brand new filter feature

= 3.2.1 =
Improves compatibility with other plugins

= 3.2.0 =
Smaller update that ensures better compatibility with other plugins

= 3.1.0 =
A lot of great new features and improvements

= 3.0.1 =
Some immediate fixes for broken features

= 3.0.0 =
WARNING: This is a complete rebuild of the plugin. Please make sure you have time to test things. The update is not irreversible but does require some attention.

= 2.8.2 =
Some important performance improvements for the plugin assets

= 2.8.1 =
Update recommended when using the ACF plugin

= 2.8.0 =
Update for performance improvements and better compatibility

= 2.7.1 =
Added some privacy policy considerations

= 2.7.0 =
Update recommended for improvements and bug fixes

= 2.6.2 =
Update to prevent notices in PHP 7.2+

= 2.6.1 =
Update to fix the deeplinking feature

= 2.6.0 =
Update for improved accessibility and performance

= 2.5.0 =
Update for a few grid fixes and WordPress 4.8 compatibility

= 2.4 =
Update recommend for improvements and bug fixes

= 2.3.1 =
Update for a nice upcoming giveaway surprise

= 2.3 =
Introducting some new Premium features

= 2.2 =
Update to ensure WordPress 4.6 compatibility

= 2.1 =
Update to get the latest and greatest grid plugin

= 2.0 =
Update for some great new features and improvements

= 1.9 =
Update for better dropdowns and a few improvements

= 1.8 =
Update for WordPress 4.4 compatibility and some great new grid features

= 1.7.2 =
Update if you're experiencing issues when editing the grid

= 1.7.1 =
Update if you're experiencing issues when saving the grid

= 1.7 =
Update for some great new WP Ultimate Post Grid features

= 1.6 =
Update recommended. Lots of new features and improvements to the grid

= 1.5 =
Update to get some great new post grid features

= 1.3 =
Update to get the pagination feature

= 1.2 =
Update for a few new features

= 1.1 =
Update to ensure compatibility with Firefox

= 1.0 =
First version, no upgrades needed.