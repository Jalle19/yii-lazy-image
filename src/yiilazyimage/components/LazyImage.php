<?php

namespace yiilazyimage\components;

/**
 * Handles rendering of lazy images (i.e. images that are loaded only once 
 * they're within the view port
 *
 * @author Sam Stenvall <sam@supportersplace.com>
 * @license http://opensource.org/licenses/MIT MIT License
 */
class LazyImage
{

	/**
	 * @var string the URL to the published assets
	 */
	private static $_assetsUrl;

	/**
	 * Wrapper for CHtml::image() which loads the image lazily
	 * @param string $url the image URL
	 * @param string $alt the alt attribute
	 * @param array $htmlOptions the htmlOptions for the image tag
	 * @return string the HTML
	 */
	public static function image($url, $alt = '', $htmlOptions = array())
	{
		// Load assets
		if (!self::$_assetsUrl)
			self::loadAssets();

		// Add the data-src attribute
		if (!isset($htmlOptions['data-src']))
			$htmlOptions['data-src'] = $url;

		// Add the CSS class
		if (isset($htmlOptions['class']))
		{
			$cssClasses = explode(' ', $htmlOptions['class']);

			if (!in_array('lazy', $cssClasses))
				$cssClasses[] = 'lazy';

			$htmlOptions['class'] = implode(' ', $cssClasses);
		}
		else
			$htmlOptions['class'] = 'lazy';

		return \CHtml::image(self::$_assetsUrl.'/images/loader.gif', $alt, $htmlOptions);
	}

	/**
	 * Publishes the required assets
	 */
	private static function loadAssets()
	{
		$am = \Yii::app()->assetManager;
		$cs = \Yii::app()->clientScript;

		// Publish all assets
		self::$_assetsUrl = $am->publish(realpath(__DIR__.'/../assets'));

		// Register jquery-unveil
		$script = YII_DEBUG ? 'jquery.unveil.js' : 'jquery.unveil.min.js';

		$cs->registerScriptFile(self::$_assetsUrl
				.'/js/'.$script, \CClientScript::POS_END);

		$cs->registerScript(__CLASS__.'_unveil', '
			$(".lazy").unveil(50);
		', \CClientScript::POS_READY);
	}

}
