<?php
/**
 * Utility extensions to CHtml.
 *
 * @since 1.0
 * @package Components
 * @author Konstantinos Filios <konfilios@gmail.com>
 */
class CBHtml extends CHtml
{
	static public $yesNo = array('1'=>'Yes', '0'=>'No');

	/**
	 * Return percentage format of $a/$b
	 *
	 * @param int $nominator
	 * @param int $denominator
	 * @param int $precisionDigits
	 * @return string
	 */
	static public function percentage($nominator, $denominator, $precisionDigits = 1)
	{
		if (!empty($denominator)) {
			return Yii::app()->format->number((100.0 * $nominator) / $denominator, $precisionDigits)."%";
		} else {
			return 'N/A';
		}
	}

	/**
	 * Return string Ratio $a/$b or N/A
	 *
	 * @param int $nominator
	 * @param int $denonimator
	 * @param int $precisionDigits
	 * @return string
	 */
	static public function ratio($nominator, $denonimator, $precisionDigits = 1)
	{
		if (!empty($denonimator)) {
			return number_format($nominator / $denonimator, $precisionDigits);
		} else {
			return 'N/A';
		}
	}

	/**
	 * Range in [$from, $to] inclusive.
	 *
	 * @param integer $from
	 * @param integer $to
	 * @param integer $step
	 * @return integer[]
	 */
	static public function range($from, $to, $step = 1)
	{
		$range = array();
		for ($i = $from; $i <= $to; $i++) {
			$range[$i] = $i;
		}
		return $range;
	}
}