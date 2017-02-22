#!/bin/bash

# Cleanup dirs
rm -rf tmp/public.building tmp/public.old
mkdir -p tmp/public.building

# Recursively copy files build final web dir
cp -R vendor/WordPress/WordPress/* tmp/public.building
cp -R public/* tmp/public.building

# CUSTOM: Copy theme into themes folder...
mkdir -p tmp/public.building/wp-content/themes/bizone
mkdir -p tmp/public.building/wp-content/plugins/js_composer
mkdir -p tmp/public.building/wp-content/plugins/envato-market
mkdir -p tmp/public.building/wp-content/plugins/masterslider
mkdir -p tmp/public.building/wp-content/plugins/mortgageware
mkdir -p tmp/public.building/wp-content/plugins/amazon-s3-and-cloudfront
cp -R theme/* tmp/public.building/wp-content/themes/bizone
cp -R js_composer/* tmp/public.building/wp-content/plugins/js_composer
cp -R envato-market/* tmp/public.building/wp-content/plugins/envato-market
cp -R masterslider/* tmp/public.building/wp-content/plugins/masterslider
cp -R mortgageware/* tmp/public.building/wp-content/plugins/mortgageware
cp -R amazon-s3-and-cloudfront/* tmp/public.building/wp-content/plugins/amazon-s3-and-cloudfront

# Move built web dir into place
mkdir -p public.built
mv public.built tmp/public.old && mv tmp/public.building public.built
rm -rf tmp/public.old

# Remove files to slim down slug if we're on Heroku
if [ ! -e .sluglocal ]
then
	rm -rf vendor/WordPress
	rm -rf public
fi

# Write some info about our slug
NOW=$( date )
cat <<EOT > public.built/.heroku-wp
Powered by HerokuWP
https://github.com/xyu/heroku-wp
=============================================

Slug Compiled : $NOW
EOT
