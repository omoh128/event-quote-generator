Event Quote Generator
The Event Quote Generator is a WordPress plugin that allows users to generate event quotes directly from your website. It features a customizable frontend form, admin settings, and integration with WordPress and WooCommerce for seamless functionality.

Features
Dynamic Quote Generation: Calculate event costs based on user input.
Customizable Forms: Easily adjust form fields and layouts.
WooCommerce Integration: Create WooCommerce customers automatically.
Responsive Design: Fully mobile-friendly for all users.
Localization Ready: Translation support using .pot files.
Spam Protection: Includes a honeypot mechanism to prevent spam.
Admin-Friendly: Intuitive settings page for configuring the plugin.
Installation
Download the Plugin:
Clone the repository or download the ZIP file from the WordPress plugin directory.

Upload to WordPress:
Upload the event-quote-generator folder to the /wp-content/plugins/ directory.

Activate the Plugin:
Go to the WordPress admin dashboard, navigate to Plugins, and activate Event Quote Generator.

Configure Settings:
Navigate to Settings > Event Quote Generator to customize options.

Usage
Adding the Quote Generator Form
Use the [event_quote_form] shortcode to display the quote generator form on any page or post.
Example:
html
Copy code
[event_quote_form]
Customizing the Form
Adjust settings via the admin dashboard under Event Quote Generator Settings.
Requirements
PHP 7.4 or higher.
WordPress 5.8 or higher.
WooCommerce (optional, for customer creation).
Development
File Structure
The plugin uses the following file structure for easy maintenance:

css
Copy code
event-quote-generator/
├── assets/
│   ├── css/
│   ├── js/
├── src/
│   ├── Admin/
│   ├── Frontend/
│   ├── Common/
├── templates/
├── languages/
├── event-quote-generator.php
└── uninstall.php
Contributing
Fork the repository.
Create a new branch for your feature or bugfix.
Submit a pull request.
Support
If you encounter issues or have questions, please contact support@example.com.

License
This plugin is licensed under the GPL-2.0-or-later license. See the LICENSE file for details.

