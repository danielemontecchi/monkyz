**Generare il CSS minificato da LESS**
lessc --clean-css packages/lab1353/monkyz/resources/assets/less/monkyz.less packages/lab1353/monkyz/assets/css/monkyz.min.css && cp packages/lab1353/monkyz/assets/css/monkyz.min.css public/vendor/monkyz/css/monkyz.min.css

**Minificare il JS**
https://jscompress.com/

**Copiare il file js**
cp packages/lab1353/monkyz/resources/assets/js/monkyz.js packages/lab1353/monkyz/assets/js/monkyz.min.js && cp packages/lab1353/monkyz/assets/js/monkyz.min.js public/vendor/monkyz/js/monkyz.min.js

**Forzare la pubblicazione degli assets**
php artisan vendor:publish --provider="Lab1353\Monkyz\Providers\MonkyzServiceProvider" --force

**auth**
https://github.com/LaravelRUS/SleepingOwlAdmin