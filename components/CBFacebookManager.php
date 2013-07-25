<?php
/**
 * Facebook-related utility functions.
 *
 * @since 1.0
 * @package Components
 * @author Konstantinos Filios <konfilios@gmail.com>
 */
class CBFacebookManager extends CApplicationComponent
{
	/**
	 * Facebook Application Id.
	 * @var integer
	 */
	public $appId;

	/**
	 * Facebook application namespace.
	 * @var string
	 */
	public $appNamespace;

	/**
	 * Facebook application token.
	 * @var string
	 */
	public $appToken;

	/**
	 * IPv4 address ranges of FB Cralwer/Scraper
	 *
	 * Facebook Crawler IP ranges:
	 * https://developers.facebook.com/docs/ApplicationSecurity/#facebook_scraper
	 * @var string[]
	 */
	static private $fbScraperIpv4Ranges = array(
		'31.13.24.0/21',
		'31.13.64.0/18',
		'66.220.144.0/20',
		'69.63.176.0/20',
		'69.171.224.0/19',
		'74.119.76.0/22',
		'103.4.96.0/22',
		'173.252.64.0/18',
		'204.15.20.0/22',
	);

	/**
	 * IPv6 address ranges of FB Cralwer/Scraper
	 *
	 * Facebook Crawler IP ranges:
	 * https://developers.facebook.com/docs/ApplicationSecurity/#facebook_scraper
	 * @var string[]
	 */
	static private $fbScraperIpv6Ranges = array(
		'2401:db00::/32',
		'2620:0:1c00::/40',
		'2a03:2880::/32',
	);


	/**
	 * Test if an IP belongs to the facebook crawler/scraper.
	 *
	 * Facebook Crawler IP ranges:
	 * https://developers.facebook.com/docs/ApplicationSecurity/#facebook_scraper
	 *
	 * @param string $testIp
	 * @return boolean
	 */
	public function isFbScraperIp($testIp)
	{
		// Test IPv4 CIDR ranges first
		foreach (self::$fbScraperIpv4Ranges as $ipv4Range) {
			if (CBInet::matchesCidrIp4($testIp, $ipv4Range)) {
				// Match, it's facebook
				return true;
			}
		}

		// Test IPv6 CIDR ranges last
		foreach (self::$fbScraperIpv6Ranges as $ipv6Range) {
			if (CBInet::matchesCidrIp4($testIp, $ipv6Range)) {
				// Match, it's facebook
				return true;
			}
		}

		// No range matched, it's not fb
		return false;
	}

	/**
	 * Create an object array representation.
	 *
	 * @param string $objectType Object type.
	 * @param string $objectTitle Object and page title.
	 * @param array $objectParams More object params.
	 * @return array
	 */
	public function createOgObject($objectType, $objectTitle, array $objectParams = array())
	{
		$finalParams = array(
			'fb:app_id' => $this->appId,
			'og:title' => $objectTitle,
			'og:url' => 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
			'og:type' => str_replace('_:', $this->appNamespace.':', $objectType),
		);

		// Append custom params by prefixing param names with app namespace
		foreach ($objectParams as $paramName=>$paramValue) {
			$paramName = str_replace('_:', $this->appNamespace.':', $paramName);

			$finalParams[$paramName] = $paramValue;
		}

		return array(
			'title' => $objectTitle,
			'prefixes' => array(
				'og' => 'http://ogp.me/ns#',
				'fb' => 'http://ogp.me/ns/fb#',
				$this->appNamespace => 'http://ogp.me/ns/fb/'.$this->appNamespace.'#',
			),
			'params'=> $finalParams
		);
	}
}