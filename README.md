# Kosnic WordPress site

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
yarn global add brunch
```

If you do not have a version of `php` installed or is below version `7.x.x`,
please upgrade it. `php 7` is recommended due to the performance improvements,
view an upgrade guide [here](https://developerjack.com/blog/2015/12/11/Installing-PHP7-with-homebrew/)

##Create a new Wordpress project:

```TXT
mkdir kosnic-wp && cd kosnic-wp
wp core download --locale=en_GB
```

##Clone this repo into a new theme in your Wordpress project:

```TXT
cd wp-content/themes && rm -rf twenty*
git clone git@github.com:1minus1limited/kosnic.git
```

Note: the `rm -rf twenty*` simply removes the default WordPress themes as they
are not required.

##Install the project with all dependancies:

```TXT
cd kosnic
yarn
```

To start the mysql server use `mysql.server start` and `mysql.server stop`
to stop. The default settings for a mysql connection are:

```TXT
host: 127.0.0.1
user: root
password: (empty)
port: 3306
```

Use the mysql settings to make a new database for the project and complete the
wordpress install at `http://localhost:3000`.

##Running the project

There are serveral commands available within this repo which are run as yarn scripts
(recommend running in separate tabs in order to monitor output):

-   `yarn run server` - will start the PHP built-in web server allowing for
access to the site via `http://localhost:8080`

-   `yarn run watch` - will start the Brunch watcher task, compiling `scss`,
`js` and asset management

-   `yarn run build` - will compile a production (live) ready version of
stylesheets, javascripts and assets, therefore only required when deploying
to a live environment

-   `yarn run git-update` - will update any submodules associated with the
project

-   `yarn run pre-deploy` - will run the `git-update` command and then
compile package dependencies before calling the `build` command

-   `yarn run deploy` - will pull down the latest changes from the develop
branch (by default) then run the `pre-deploy` command

-   `yarn run deploy:production` - will pull down the latest changes from
the master branch then run the `pre-deploy` command - for Live/Production

-   `yarn run caniuse` - will check the compiled `app.css` file against the
`CanIUse` API - For informational purposes only

Once the PHP server is running, you can setup your WordPress site via the url
noted above. You will need to create a mysql database using the connection
information in the `Prerequisites` section within the `WP With Brunch` repo
(using Sequel Pro or another mysql manager app).

When entering these database details into the WordPress setup screen, ensure
that the host field is set to `127.0.0.1` rather than `localhost` otherwise you
will receive a connection error.

When adding node packages to this repo, the `--save` option should be used unless the
package contents will only ever be used within the dev environment
(`devDependencies`). For example, the `auto-reload-brunch` offers local
reloading of pages to show instant styling changes, which would not be suitable
for a live server environment.

## Install/Update CMB2 within project

This project uses the [CMB2](https://github.com/WebDevStudios/CMB2) library
to help generate and manage custom metaboxes within the WP admin. It is
included within this project via submodule.

To add CMB2 library to the project run the following command within the theme
directory you wish to add the CMB2 library into:

`git submodule add git@github.com:WebDevStudios/CMB2.git`

When setting up the project for the first time (or installing CMB2 for the
first time), checkout the develop branch and run the following command
`git submodule update --init`. This will pull the CMB2 library into the
correct folder within the project's theme.

If you need to update the CMB2 library (following and update to the library
repo), run the following command: `git submodule update`.

NB: The CMB2 files are not commited directly within this repo as there should
be no reason to change the library code.

##Testing

The server will allow for devices connected on the same wifi to access the
site. On your device go to the IP address + `xip.io:8080`.
To find your IP address hold `ALT` and click on the wifi icon in your toolbar.
