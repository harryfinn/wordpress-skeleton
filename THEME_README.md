# WordPress theme, powered by Brunch!

This repository is powered by the [Brunch](http://brunch.io) build tool and
is built upon the [WordPress Skeleton](https://github.com/harryfinn/wordpress-skeleton)
starter framework.

Before getting started with this theme, please ensure you have completed the steps
in the `Prerequisites` section in the [WordPress Skeleton](https://github.com/harryfinn/wordpress-skeleton)
`README` before following the setup steps below.

## Step Up

The following commands will install WordPress into a folder, remove the default themes,
pull down this theme repository then install the package dependencies, ready to use!

```txt
mkdir your-wordpress-folder && cd your-wordpress-folder
wp core download --locale=en_GB
cd wp-content/themes && rm -rf twenty*
git clone git@github.com:username/repo.git
cd repo_name
yarn
```

To start the mysql server use `mysql.server start` and `mysql.server stop`
to stop.

Use the mysql settings to make a new database for the project and complete the
WordPress install at `http://localhost:8080`.

## Initialise CMB2 within project

This project uses the [CMB2](https://github.com/CMB2/CMB2) library
to help generate and manage custom metaboxes within the WP admin. It is
included within the skeleton framework repo as a submodule.

However, as this is a new theme, based off of the skeleton framework, the
submodule link will have been removed during setup (`rm -rf .git`), therefore
the submodule needs to be added and initialised within this repo:

```TXT
cd includes/
`it submodule add git@github.com:CMB2/CMB2.git
yarn git-update
```

You do not need to manually update this submodule as this is handled within the
`git-update` command noted above.

The CMB2 files are not committed directly within this repo as there should
be no reason to change the library code once development has started. An
exception to this would be if a security patch or bugfix was required.

It is generally preferred that major updates to `CMB2` are not applied during development, unless new functionality is required, but rather left for the next project or new feature implementation as defined within the `WordPress Skeleton` framework.

## Running & Building the project

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

Otherwise, if a package affects the way in which the code is written, it should
sit under the `dependencies` section. For example, the `auto-reload-brunch`
offers local reloading of pages to show instant styling and js changes, which
would not be suitable for a live server environment, therefore should have
the `--dev` flag used to add it.

## Device Testing

The server will allow for devices connected on the same wifi to access the
site. On your device go to the IP address + `xip.io:8080`.
To find your IP address hold `ALT` and click on the wifi icon in your toolbar.

To ensure local assets are correctly parsed when testing locally, ensure the
`BRUNCH_LOCAL_ASSETS` constant is set to `true`.
