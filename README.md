yii-lazy-image
==============

Lazy image loader for the Yii framework. It is implemented as a static class which leverages [jQuery Unveil](http://luis-almeida.github.io/unveil/) to load images lazily. The interface is the same as `CHtml::image()` so existing code can easily be adapted to use it.

## Usage

Require the project in your `composer.json`, then use it like this:

```php
echo \yiilazyimage\components\LazyImage::image($url, $alt, $htmlOptions);

```

## License

This project is licensed under the MIT license
