# Divi Post Carousel Troubleshooting Guide

If you're experiencing issues with the Divi Post Carousel module, please follow these troubleshooting steps to resolve common problems.

## Common Issues and Solutions

### 1. Critical Error After Installation

If you see a "There has been a critical error on this website" message:

1. **Deactivate the plugin**: Log into your site via FTP or your hosting file manager and rename the `divi-post-carousel` folder to `divi-post-carousel-disabled` to deactivate it.

2. **Check Divi compatibility**: Make sure you're using Divi 4.0 or higher. This plugin is not compatible with older versions of Divi.

3. **Check PHP version**: The plugin requires PHP 7.0 or higher. Check your server's PHP version in your hosting control panel.

4. **Enable error reporting**: Add the following code to your wp-config.php file (before the line that says "That's all, stop editing"):
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   define('WP_DEBUG_DISPLAY', false);
   ```
   Then check the debug.log file in the wp-content folder for specific error messages.

### 2. Module Not Showing in Divi Builder

If the Post Carousel module isn't appearing in the Divi Builder:

1. **Deactivate and reactivate the plugin**: Sometimes simply deactivating and reactivating the plugin can fix loading issues.

2. **Clear Divi cache**: Go to Divi → Theme Options → Builder → Advanced → "Clear all Divi cache" and then try "Regenerate Divi roles".

3. **Try searching for "carousel"**: In some cases, the module might be loaded but not visible in the initial list. Try searching for "carousel" in the module search box.

4. **Check for conflicting plugins**: Disable other custom Divi modules temporarily to check for conflicts.

5. **Fix permission issues**: Make sure all plugin files have the correct permissions (folders: 755, files: 644).

6. **Check WordPress version**: Ensure you're running WordPress 5.0 or higher.

7. **Refresh the Visual Builder**: If using the Visual Builder, try refreshing the page or switching to the Backend Builder and back.

### 3. Carousel Not Working Properly

If the carousel is visible but not functioning correctly:

1. **Check for JavaScript conflicts**: Temporarily disable other plugins to identify potential conflicts.

2. **Update jQuery**: Make sure your site is using a current version of jQuery.

3. **Inspect browser console**: Check your browser's developer console for JavaScript errors.

### 4. Posts Not Displaying

If the carousel appears but no posts are shown:

1. **Check post type**: Make sure you've selected the correct post type in the module settings.

2. **Check post status**: Only published posts will be displayed.

3. **Verify post count**: Make sure you have at least one published post of the selected type.

## Advanced Troubleshooting

If the solutions above don't resolve your issue:

1. **Check server error logs**: Ask your hosting provider for access to server error logs.

2. **Increase memory limit**: Add the following to your wp-config.php file:
   ```php
   define('WP_MEMORY_LIMIT', '256M');
   ```

3. **Check file integrity**: Re-download and reinstall the plugin to ensure all files are complete and uncorrupted.

## Still Having Issues?

If you continue to experience problems after trying these steps, please contact your site administrator or the plugin developer with the following information:

1. WordPress version
2. Divi theme version
3. PHP version
4. Any error messages from the debug.log
5. List of active plugins

This information will help diagnose and resolve your specific issue more quickly. 