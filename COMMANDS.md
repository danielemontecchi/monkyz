**Minificare il JS**
https://jscompress.com/

**Copiare il file js**
cat packages/lab1353/monkyz/resources/assets/js/*.js > packages/lab1353/monkyz/assets/js/monkyz.min.js && cp packages/lab1353/monkyz/assets/js/monkyz.min.js public/vendor/monkyz/js/monkyz.min.js
cat packages/lab1353/monkyz/resources/assets/js/pages/login.js > packages/lab1353/monkyz/assets/js/login.min.js && cp packages/lab1353/monkyz/assets/js/login.min.js public/vendor/monkyz/js/login.min.js

**Forzare la pubblicazione degli assets**
php artisan vendor:publish --provider="Lab1353\Monkyz\Providers\MonkyzServiceProvider" --force

**auth**
https://github.com/LaravelRUS/SleepingOwlAdmin