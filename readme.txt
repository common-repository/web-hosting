=== Web Hosting Plugin ===
Contributors: (davidgennoe)
Donate link: https://www.web-uk.co.uk/
Tags: web, hosting, domain names
Requires at least: 3.0.1
Tested up to: 5.4.1
Stable tag: 5.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 7.1


== Description ==

Web Hosting Plugin for WordPress.
Requires WooCommerce, Resellerclub Account, and access to WHM
Register and transfer domain names through resellerclub, customers can manage their domains and hosting from their my-account area.
create hosting accounts through WHM


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Web Hosting screen to configure the plugin
4. Use the Settings->Web Hosting->Domains screen to configure the domains
5. (This plugin requires woocommerce a Resellerclub account and access to WHM)
6. Go to Woocommerce->Settings and click on Accounts & Privacy tab, In Account Creation Section
check the two following items.  
When creating an account, automatically generate an account username for the customer based on their name, surname or email 
When creating an account, automatically generate an account password
then
Save changes.
7. Go to Web Hosting->Hosting and fill in all the required fields.
8. Go to Web Hosting->Domains and fill in domain fields. if you are selling 20 TLD's type 20 into the Number of TLD to sell: box and click 
save changes this will create 20 TLD input fields.
9. Create a page to display the check domain form shortcode [check_domain]
10. Create a page to display the domain check results shortcode [domain_checker]
the 2 pages above need to be defined in the admin Web Hosting->Hosting page so the plugin knows where the shortcodes are.

I recommend that you create a Resellerclub demo account while you are setting up the plugin.
if you have access to root on your server I recommend that you create a WHM reseller account and use that

View the pdf file Web-Hosting-Instructions.pdf for full instructions.
Software is used at your own risk.
== Frequently Asked Questions ==

= Does you plugin support Resellerclub Demo for testing purposes =

Yes you will find the check box in Web Hosting settings page.



== Screenshots ==

1. /assets/screenshot01.png


== Changelog ==

== 1.5.4 ==

This plugin has been rewritten.

can now register/create multiple domains and hosting packages from within a single order
cron will remove any unregistered domain products every 24 hours
subscription has been removed this will be released at a later date
many bug fixes
removed deprecated php functions


== 1.4.6 ==

fix display currency symbol correctly

fix added Text Domain: to index.php for language translation

== 1.4.5 ==

fix error when inputting postcode/zipcode

fix error so orders placed using version 1.3.8 or eariler which have been processed don't get processed again.

added language translation 

moved resellerclub functions into seperate file wh_resellerclub.php

all outputted text is defined within web-hosting/language/language-UK.php for easy changing of displayed text and messages.
e.g. search_domain_names =  (__("Search Domain Name",'web-hosting'));



 

== 1.4.4 ==

Domain product are now updated to private after domain is registered

WHM access is now done using token instead of hash key

fixed foreach error on Admin->Account page.

== 1.4.3 ==

fixed error which on certain servers caused a white screen when completing orders

removed 4 more php warnings


== 1.4.2 ==

fix error when completing order

==1.4.1 ==

updated web-hosting-instructions.pdf

==1.4.0 ==

This is a major update. please contact me if you find any bugs support@web-uk.co.uk

Most of this plugin has been re-written.

all calls to customers orders is now using woocommerce CRUD 

fixed items not been invoiced when due, each order item is now processed individually instead of the entire order. 

Products which are not variable can have within the product meta fields have a 
field added called number_of_years with a figure, any order with this product 
added will not create an invoice until the number of years have passed.

This version only allows maximum of 1 domain 1 hosting package and 1 SSL Certification
to be added to the cart, this will change in a future version.

Domain forms are now stored within a new file wh_domain_forms.php for those who 
wish to change the look and layout just put any modified file in your child theme/web-hosting/ folder

Domain name information is now taken from resellerclub instead of product meta fields.

Fixed all php warnings

fixed 2 foreach errors.


==1.3.8 ==

Fixed PHP Warning:  Missing argument 4 for check_hosting_in_cart()

== 1.3.7 ==

Fixed bug when number of years is not selected in domain form. 

== 1.3.6 ==

Fixed logo not being displayed within pdf invoice.

== 1.3.5 ==

made changes to invoice pdf file for invoices your logo now needs to go in wp-content/web-hosting-uploads folder 
this was within the plugin folder and was being over written when the plugin was updated.
if the web-hosting-uploads folder does not exist then just create the folder and place your logo.png within it, size of logo needs
to be 50px x 50px.

Fixed a few errors within domain name renew in subscriptions function and within sending emails function.

== 1.3.4 ==

Removed PHPMailer and now using WordPress PHPMailer Class

== 1.3.3 ==

fixed small error in sending out invoices

== 1.3.2 ==

Removed all <th> classes from domain forms.
Domain forms now scale down correctly in small viewports.
Fixed error in account number field within admin area.
Fixed error in check domain name form if Number of Years is not selected. 
Now able to send_domain renew emails 21days, 14days and 7days before domain is due to expire.


== 1.3.1 ==

Changed resellerclub account number field within admin area to accept upto 8 digits.
Reduced some of the css in forms.

= 1.3.0 =

added accounts area in admin to view all hosting accounts on the server you can now see
details about each account domain, email address, disk space used etc. admin can also 
suspend, unsuspend and delete accounts

= 1.2.5 =

fixed bug when an order is cancelled it cannot now be invoiced when it is due for renewal

= 1.2.4 =

fixed small bug in orders number of days before invoices are sent out

= 1.2.3 =

added wp-cron for scheduling jobs such as sending out due invoices

you can now copy plugin files into your child theme to prevent file being over written when updating
just create a folder called web-hosting within the root of your theme folder e.g. twentysixteen/web-hosting/

= 1.2.2 =

fixed bug in domain expiry date

= 1.2.1 =

made small changes to widgets.

= 1.2.0 = 

added 2 widgets one for search domain name form and one for transfer domain name form.

= 1.1.9 =

made small changes to transfer domain form.

= 1.1.8 =

made changes to forms as not displaying correctly in widgets within some themes.

= 1.1.7 =

added extra css to transfer/search domain name form to improve looks and enable search domain name form to view correctly in widgets.

= 1.1.6 =

fixed bug where shortcode for domain forms always displayed at top of page.

= 1.1.5 =

added number of years form field to both search domain form and
transfer domain form. tidied up the search domain form.

= 1.1.4 =

fixed domain search form url when WordPress Address URL is 
different to Site Address preventing 404 errors.

= 1.1.1 =

Fixed a couple of bugs and appears to be stable

= 1.1.0 =

see https://www.web-uk.co.uk/wordpress/plugins/web-hosting/releases/version-1-1-0/

= 1.0 =

v1.0 first release

== Upgrade Notice ==

v1.1.0 small changes to my-account area to be compatible with WooCommerce v2.6.0 +
       added orders page to admin area.put domain search form within a table

v1.0 first release
