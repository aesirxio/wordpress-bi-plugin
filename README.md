# AesirX BI for Wordpress

AesirX BI is our Open Source Business Intelligence as a Service (BIaaS) Solution

It allows you to successfully gain legal 1st-party data insights for your business across multiple platforms and devices.

Safeguard your data and your customers' privacy with our Web Analytics solution (a Google Analytics alternative) that’s fully GDPR compliant and built on privacy by design; AesirX BI enables data-driven marketing in a privacy-first world.

Designed for easy integration, all data is collected through the AesirX JS Data Collector which is installed 1st-party on your website or application.

Find out more in [https://bi.aesirx.io](https://bi.aesirx.io)

## Setup instructions

### Setup the 1st party server

Follow the instructions in: [https://github.com/aesirxio/analytics-1stparty/tree/master](https://github.com/aesirxio/analytics-1stparty)

### Setup the Analytics JS Collector

Follow the instructions in: [https://github.com/aesirxio/wordpress-analytics-plugin](https://github.com/aesirxio/wordpress-analytics-plugin)

### Download and install plugin to Wordpress

In WP Admin, go to Settings - AesirX BI and config the settings:
1. Get your `REACT_APP_CLIENT_ID` key from https://bi.aesirx.io by creating an account.
1. Replace the `REACT_APP_CLIENT_SECRET` with the one provided in your profile account.
1. Replace the `REACT_APP_ENDPOINT_URL` with the link to your `1st party server for AesirX Analytics`.
1. Replace the `REACT_APP_LICENSE` with the one provided in your profile account.
1. Replace the `REACT_APP_DATA_STREAM` with the `name` and `domain` to the your data-stream endpoint.

### Development

1. Clone the project
1. Copy `sample.env` to `.env`
1. In `.env` file, update the `wwwDir` to your WP path.
1. Run `yarn install`
1. Watch `yarn watch`, webpack will watch and copy files to WP path(`wwwDir`) when you change the source.


### Release

Run `yarn release` and install `aesirx-bi.zip` file on `dist` folder to WP.
