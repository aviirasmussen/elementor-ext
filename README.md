# Elementor Extension Plugin
A plugin that add widgets in page edit for the Elementor plugin. 
## Requirements
 - PHP >= 7.3
 - Elementor plugin activated
 - Elementor version >= 3.0.14
 - Bootstrap (if bootstrap.css not found when frontend styles is queued, this plugin enqueues the CDN for bootstrap.min.css) - required for use of gallery grid, modal and carousel.
## Widgets
### Dropdown Gallery
 Adds a grid of pictures with a dropdown button below the two first rows of the gallery. When button is clicked the gallery expands to show all picture in the gallery. 
 - Dropdown Text
 Button Text
 - Image Width
 Number of pixels to display one image in the gallery. Valid values is from 100-500 pixels.
 - Grid Columns
 Number of columns in the gallery grid. Defaults to show three columns for each row. Valid values is 1,3,4, and 6.
#### Styles
 - Show shadow
 Adds a shadow to each image in the gallery
 - Zoom image
 Zooms images when hoover above an image
 - Use image carousel
 Opens a modal carousel to display each image in the gallery.w
 - Gallery ID
 An unique ID, which is needed if you want several galleries on one page.
#### Media Control
 - Attach a youtube Video URL to an image in the gallery, and gallery will show an embed youtube video.
## Utility
Open and edit the file elementor-ext.php:
### Turn on logging
If you want to turn on the possibility for logging

 - Set EEP_DEBUG to true
 - Set EEP_DEBUG_FILE name if you want another name for your logfile. The logfile is created in the plugin directory
 - Set EEP_DEBUG_MAX_FILE_SIZE (in bytes) for file size limit before the logfile gets truncated
 
Now you can call the `function debug_log(<object|string>)` to add log statements into this plugin.