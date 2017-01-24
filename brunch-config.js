module.exports = {
  paths: {
    watched: ['app/javascripts', 'app/stylesheets', 'app/assets', 'vendor']
  },
  files: {
    javascripts: {
      joinTo: {
        'js/vendor.js': /^(?!app)/,
        'js/app.js': /^(app\/javascripts)/
      }
    },
    stylesheets: {
      joinTo: {
        'css/vendor.css': /^(vendor\/stylesheets)/,
        'css/app.css': /^(app\/stylesheets)/,
      }
    }
  },
  plugins: {
    postcss: {
      processors: [
        require('postcss-import'),
        require('autoprefixer')(['last 2 versions', 'iOS 8'])
      ]
    },
    sass: {
      debug: 'comments',
      mode: 'native'
    }
  },
  modules: {
    wrapper: false
  }
};
