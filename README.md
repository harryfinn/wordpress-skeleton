# Skeleton WordPress Theme

This repository contains a skeleton WordPress theme powered by brunch.
It uses yarn to compile and process packages and assets.

## Prerequisites

Before you clone this repository, please ensure the following have been
installed (first-time setup only). Please also ensure that you have `php`
installed (`php -v`), version `7.0.8` or higher. We are also using Yarn
to manage our project dependencies, however, you can still use `npm`
commands if you are unsure of the matching `yarn` command. Checkout the
Yarn docs here = [https://yarnpkg.com/en/docs/cli/](https://yarnpkg.com/en/docs/cli/)

```TXT
brew install mysql
brew install node
brew install yarn
```

If you do not have a version of `php` installed or is below version `7.x.x`,
please upgrade it. `php 7` is recommended due to the performance improvements,
view an upgrade guide [here](https://developerjack.com/blog/2015/12/11/Installing-PHP7-with-homebrew/)

## To create a new WordPress project:

```TXT
mkdir your-wordpress-folder && cd your-wordpress-folder
wp core download --locale=en_GB
```

## Clone this repo into a new theme in your WordPress folder:

```TXT
cd wp-content/themes && rm -rf twenty*
mkdir your-theme && cd your-theme
git clone git@github.com:harryfinn/wordpress-skeleton.git .
yarn
```

Note: the `rm -rf twenty*` simply removes the default WordPress themes as they
are not required. The `yarn` command installs all the dependancies for this
skeleton.

You can now branch from master to make changes in this repo.

To create a new WordPress theme repo from this skeleton run the following
command to delete the current git files.

```TXT
rm -rf .git
```

You can now create your new WordPress theme repository, following the repository
setup instructions on github.

Once setup please ensure you amend the values in the `includes/constants.php`
file to suit your theme, i.e. `_theme_cmb2_` would contain the name of the theme
as the prefix, rather than `_theme_cmb2` you could use `_hf_cmb2_` etc.

## Running the project

To start the mysql server use `mysql.server start` and `mysql.server stop`
to stop. The default settings for a mysql connection are:

```TXT
host: 127.0.0.1
user: root
password: (empty)
port: 3306
```

Use the mysql settings to make a new database for the project and complete the
WordPress install at `http://localhost:8080`.

There are several commands available within this repo which are run as yarn
scripts (recommend running in separate tabs in order to monitor output):

-   `yarn server` - will start the PHP built-in web server allowing for
access to the site via `http://localhost:8080`

-   `yarn watch` - will start the Brunch watcher task, compiling `scss`,
`js` and asset management

-   `yarn build` - will compile a production (live) ready version of
stylesheets, javascripts and assets, therefore only required when deploying
to a live environment

-   `yarn git-update` - will update any submodules associated with the
project

-   `yarn pre-deploy` - will run the `git-update` command and then
compile package dependencies before calling the `build` command

-   `yarn deploy` - will pull down the latest changes from the develop
branch (by default) then run the `pre-deploy` command

-   `yarn deploy:production` - will pull down the latest changes from
the master branch then run the `pre-deploy` command - for Live/Production

-   `yarn caniuse` - will check the compiled `app.css` file against the
`CanIUse` API - For informational purposes only

When adding node packages (via [Yarn](https://yarnpkg.com/en/) to this repo, 
the `--dev` option should be used for any packages that are required to run 
the development environment, prior to the build/compilation of the app. 

Otherwise, if a package affects the way in which the code is written, it 
should sit under the `dependencies` section. For example, the 
`auto-reload-brunch` offers local reloading of pages to show instant styling 
and js changes, which would not be suitable for a live server environment, 
therefore should have the `--dev` flag used to add it.

## Install/Update CMB2 within project

This project uses the [CMB2](https://github.com/WebDevStudios/CMB2) library
to help generate and manage custom metaboxes within the WP admin. It is
included within this project via submodule.

Should you ever need add CMB2 library to the project (this is not required when 
using this repo as a starter framework), run the following command within the 
relevant theme directory you wish to add the CMB2 library into:

`git submodule add git@github.com:WebDevStudios/CMB2.git`

When setting up the project for the first time (or installing CMB2 for the
first time), checkout the develop branch and run the following command
`git submodule update --init`. This will pull the CMB2 library into the
correct folder within the project's theme.

If you need to update the CMB2 library (following and update to the library
repo), run the following command: `git submodule update`.

NB: The CMB2 files are not committed directly within this repo as there should
be no reason to change the library code unless updating the CMB2 library after 
a new release.

## Testing

The server will allow for devices connected on the same wifi to access the
site. On your device go to the IP address + `xip.io:8080`.
To find your IP address hold `ALT` and click on the wifi icon in your toolbar.

To ensure local assets are correctly parsed when testing locally, ensure the 
`BRUNCH_LOCAL_ASSETS` constant is set to true.

## Additional Skeleton file notes

There are several files within this skeleton which contain examples of
functionality for your WordPress theme.

For example:
-   `includes/class.custom-post-types.php`
-   `includes/class.theme-admin.php`
-   `includes/custom-metaboxes/cmb2-post-fields.php`
-   `app/javascripts/web-font-loader.js`

When viewing these files please note additional instructions in the comments.

A basic set of common styles has been included in this skeleton to be built upon.
