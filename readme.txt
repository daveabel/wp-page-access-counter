=== Wp Access Counter ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: 
Tags: comments, spam
Author: Sebastian Weiß | David Abel
Requires at least: 4.5
Tested up to: 5.9.3
Requires PHP: 5.6
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://github.com/daveabel/wp-page-access-counter

== general information ==
The idea behind this plugin was to implement an interactive real-life geocache-quiz. Different QR-Codes are spread out in a city and players can search them.
After scanning the QR-Codes, a question is displayed and the page-accesses, e.g. the number of questions answered, are counted. After a pre-defined number of questions, a part of 
a "secret" message is printed.  

This plugin tracks the number of page-accesses and prints a secret word step-by-step. Opening a page multiple times does only count as one access.
The accesses are only counted, if the site is from the custom-post-type question. Also, with the custom-post-type regions, each question can be linked
to a specific region and each region has its own cookie to count the number of accesses. The secret word can also be set in the custom-post-type region for every region.
Also, the "modulo", e.g. the number of page-accesses until a part of the secret word is printed, can be set there.

As cookies are essential for the working-mechanism of the website, the cookie should be a necessary cookie. The cookie will remain valid for 1 day.

== shortcode ==
This shortcode can be used to display the secret word if enough page accesses are reached

[ordendergsi_secret]
