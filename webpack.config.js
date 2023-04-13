const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const WebpackAssetsManifest = require('webpack-assets-manifest');
const FileManagerPlugin = require('filemanager-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const { ProvidePlugin } = require('webpack');

const {
  wwwDir,
  projectname,
  sassLoader,
  imageLoader,
  fontLoader,
  jsLoader,
  cssLoader,
  aliasData,
} = require('./webpack.common');

require('dotenv').config();

module.exports = (env, argv) => {
  if (env != undefined && env.deploy) {
    process.env = {
      wwwDir: wwwDir,
    };
  }

  var pluginPath = process.env.wwwDir;

  var config = {
    entry: './assets/index.js',

    plugins: [
      new ProvidePlugin({
        process: 'process/browser',
      }),

      new HtmlWebpackPlugin({
        inject: false,
        filename: pluginPath + '/wp-content/plugins/' + projectname + '/includes/settings.php',
        template: './wp-content/plugins/' + projectname + '/includes/settings.php',
        minify: false,
      }),

      new FileManagerPlugin({
        events: {
          onEnd: {
            copy: [
              {
                source: path.resolve(
                  __dirname,
                  './wp-content/plugins/' + projectname + '/aesirx-bi.php'
                ),
                destination: pluginPath + '/wp-content/plugins/' + projectname + '/aesirx-bi.php',
              },
              {
                source: path.resolve(
                  __dirname,
                  './wp-content/plugins/' + projectname + '/includes/dashboard.php'
                ),
                destination:
                  pluginPath + '/wp-content/plugins/' + projectname + '/includes/dashboard.php',
              },
              {
                source: path.resolve(
                  __dirname,
                  './node_modules/aesirx-bi-app/public/assets/images/'
                ),
                destination: pluginPath + '/wp-content/plugins/' + projectname + '/assets/images',
              },
              {
                source: path.resolve(
                  __dirname,
                  './node_modules/aesirx-bi-app/public/assets/data/'
                ),
                destination: pluginPath + '/wp-content/plugins/' + projectname + '/assets/data',
              },
            ],
          },
        },
      }),

      new WebpackAssetsManifest({
        entrypoints: true,
        publicPath: '/wp-content/plugins/' + projectname + '/',
      }),
    ],
    output: {
      path: pluginPath + '/wp-content/plugins/' + projectname + '/',
      publicPath: '/wp-content/plugins/' + projectname + '/',
      clean: true,
    },

    module: {
      rules: [sassLoader, cssLoader, jsLoader, imageLoader, fontLoader],
    },
    optimization: {
      splitChunks: {
        chunks: 'all',
      },
    },
    resolve: {
      alias: aliasData,
      fallback: { 'process/browser': require.resolve('process/browser') },
    },
  };

  let name = '[name]';

  if (argv.mode === 'development') {
    config.devtool = 'source-map';

    if (env != undefined && env.deploy) {
      name = '[name].[contenthash]';
    }

    config.plugins.push(
      new BrowserSyncPlugin(
        // BrowserSync options
        {
          proxy: process.env.proxy,
          notify: true,
        }
      ),
      new MiniCssExtractPlugin({
        filename: 'css/' + name + '.css',
      })
    );
  }

  if (argv.mode === 'production') {
    name = '[name].[contenthash]';

    config.optimization.minimize = true;
    config.optimization.minimizer = [
      new TerserPlugin({
        terserOptions: {
          compress: {
            drop_console: true,
          },
        },
      }),
    ];

    config.plugins.push(
      new MiniCssExtractPlugin({
        filename: 'css/' + name + '.css',
      })
    );

    config.plugins.push(
      new FileManagerPlugin({
        events: {
          onEnd: {
            archive: [
              {
                source: './dist/wp-content/plugins/' + projectname + '/',
                destination: './dist/' + projectname + '.zip',
              },
            ],
          },
        },
      })
    );
  }

  config.output.filename = 'js/' + name + '.js';
  config.output.chunkFilename = 'js/' + name + '.js';

  return config;
};
