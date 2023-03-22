const MediaQueryPlugin = require('media-query-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const path = require('path');
const wwwDir = path.resolve(__dirname, './dist');
const projectname = 'aesirx-bi';

const sassData = {
  loader: 'sass-loader'
};

const sassLoader = {
  test: /\.(scss)$/,
  use: [
    MiniCssExtractPlugin.loader,
    'css-loader',
    MediaQueryPlugin.loader,
    'postcss-loader',
    sassData,
  ],
};

const jceSassLoader = {
  test: /\.(scss)$/,
  use: [
    {
      loader: MiniCssExtractPlugin.loader,
      options: {
        publicPath: '../',
      },
    },
    'css-loader',
    'postcss-loader',
    sassData,
  ],
};

const imageLoader = {
  test: /\.(gif|png|jpe?g|svg)$/i,
  type: 'asset/resource',
  generator: {
    filename: 'image/[contenthash][ext][query]',
  },
};

const fontLoader = {
  test: /\.(woff|woff2|eot|ttf|otf)$/,
  type: 'asset/resource',
  generator: {
    filename: 'fonts/[contenthash][ext][query]',
  },
};

const jsLoader = {
  test: /\.js$/,
  exclude: /node_modules\/(?!(dom7|ssr-window|swiper)\/).*/,
  use: {
    loader: 'babel-loader',
  },
};

const aliasData = {
  src: path.resolve(__dirname, './src'),
  react$: require.resolve(path.resolve(__dirname, './node_modules/react')),
};

const cssLoader = {
  test: /\.css$/i,
  use: ['style-loader', 'css-loader'],
};

module.exports = {
  wwwDir,
  projectname,
  sassLoader,
  jceSassLoader,
  imageLoader,
  fontLoader,
  jsLoader,
  cssLoader,
  aliasData,
};
