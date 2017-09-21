# COMMANDS

**Copy assets files to public**

cp -R packages/lab1353/monkyz/assets/* public/vendor/monkyz/

**Generate monkyz.min.js**

cat packages/lab1353/monkyz/resources/assets/js/*.js > packages/lab1353/monkyz/assets/js/monkyz.min.js && cp packages/lab1353/monkyz/assets/js/monkyz.min.js public/vendor/monkyz/js/monkyz.min.js

**Generate login.min.js**

cat packages/lab1353/monkyz/resources/assets/js/pages/login.js > packages/lab1353/monkyz/assets/js/login.min.js && cp packages/lab1353/monkyz/assets/js/login.min.js public/vendor/monkyz/js/login.min.js

**Force publish assets**

php artisan vendor:publish --provider="Lab1353\Monkyz\Providers\MonkyzServiceProvider" --force && rm -rf resources/views/vendor/monkyz

# HELP

**Minify il JS**

https://jscompress.com/

**Google Analytics**

https://github.com/spatie/laravel-analytics

**Auth**

https://github.com/LaravelRUS/SleepingOwlAdmin

# TOOLS

**Quality of code**

https://scrutinizer-ci.com/g/lab1353/monkyz/
