# wp-site-package

## What Is It?
Wp-site-package is a [Composer](https://getcomposer.org/) package that enables getting a customized [Wordpress](https://github.com/WordPress/WordPress) set up in 5-10 minutes! This Wordpress bootstrap package implements a clear separation between core/vendor files and your project's application logic. 

##### Installed WP Plugins
The package also installs a few (11+) useful WP plugins to start with:

[Wordfence](https://wordpress.org/plugins/wordfence/) | [EWWW Image Optimizer](https://wordpress.org/plugins/ewww-image-optimizer/) | [Autoptimize](https://wordpress.org/plugins/autoptimize/) | [Enhanced Media Library](https://wordpress.org/plugins/enhanced-media-library/) |
[Duplicate Post](https://wordpress.org/plugins/duplicate-post/) | [YOAST Wordpress SEO](https://wordpress.org/plugins/wordpress-seo/) | [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) | [Cookie Notice](https://wordpress.org/plugins/cookie-notice/) |
[Updraftplus](https://wordpress.org/plugins/updraftplus/) | [Akismet](https://wordpress.org/plugins/akismet/) | [Google Pagespeed Insights](https://wordpress.org/plugins/google-pagespeed-insights/)



## Quick Start - How To Use It?
Bootstrapping a new custom WP install…

### 1 - Install Composer *(or skip to step 2…)*
##### Linux Debian/Raspbian
When using **Raspbian / Debian**, install Composer if it's not yet available on your system.
* First, check for an existing debian package for Composer (composer.deb ?) and use `apt-get` if you find one.
* If no debian package is available (which is the case at the time of writing these lines),
	use the shell commands provided in the following gist.

        cd /usr/src
        sudo apt-get install curl php5-cli
        curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
    
  @see: http://www.bravo-kernel.com/2014/08/how-to-install-composer-on-debian/

##### OSX / Linux / WINDOWS
* Official documentation: [How to install Composer on **OSX** / **Linux** / **Unix**](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
* Official documentation: [How to install Composer on **Windows**](https://getcomposer.org/doc/00-intro.md#installation-windows)


### 2 - Prepare Mysql
* Create new SQL **database and db user/password**.
* Save all info for later use.

  	    CREATE DATABASE wordpress;
	      CREATE USER wordpressuser;
	      SET PASSWORD FOR wordpressuser= PASSWORD(“1234”);
	      GRANT ALL PRIVILEGES ON wordpress.* TO wordpressuser IDENTIFIED BY ‘1234’;
	      FLUSH TABLES;


### 3 - Install the Composer Package
* `cd` into the web server's public DocumentRoot folder
* `git clone` the desired package version
* Change folder name to the desired project's name (e.g: example.dev)
* `cd` into the cloned (renamed) package
* run `composer install`
* Maybe, update Composer: `sudo -H composer self-update`
* Maybe, check for outdated packages: `composer outdated` or `composer show --outdated`


### 4 - Pre-configure Wordpress
##### Edit wp-config.php
* Server setup switch (`'local'` or `'live'`) & other intuitive conditional flags
* Database info: DbName, DbUser, DbPassword, DbTablePrefix
* Locale: `WP_LANG`
* Optional subfolder (mostly for dev/staging servers)
* WP secret phrases (auto-generate them using provided link)
* Etc…

##### When/how to use `WP_SITEURL` & `WP_HOME`?
When **using a Raspbian server**, **relocating your site** or **in order to decrease database calls**, you may also use wp-config.php to set `LINUX_DEV_SERVER` and/or `HARDCODE_SITEURL` to `true`. 

      define('LINUX_DEV_SERVER', true);    // When using a Raspbian local development server, or...
      define('HARDCODE_SITEURL', true);    // ...other scenarios.


> *This will cause these `WP_SITEURL` & `WP_HOME` to be defined by the script, later in the config file, enabling you to access the admin and login pages w/o faulty url redirects (or to optimize performance)*.
    

    if (LINUX_DEV_SERVER || HARDCODE_SITEURL) {
			define('WP_SITEURL', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER . PATH_TO_WP);
			define('WP_HOME',    PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER);
		}


### 5 - Install Wordpress
At this point, you're ready to use the WP installation script. It will load by itself when you'll browse to your
site's admin backend ('example.com/wp/wp-admin/').


### 6 - Check Folders/Files Permissions
If you're using **RaspberryPi Server**, make WP files/folders writable:
* `chown -R www-data:www-data exampleProjectFolder/`		
* OR set-up FTP server and user account to be used by WP

> *Whatever your server setup may be, always make sure that all files are chmod:644 and folders are chmod:755.*
