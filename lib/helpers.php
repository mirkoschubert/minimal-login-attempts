<?php
defined('ABSPATH') || die();

class MLA_Helpers {

  public static function ip_in_range( $ip, $list ) {

    foreach ( $list as $range ) {
			$range = array_map('trim', explode('-', $range));
			if (count($range) == 1) {
			  // CIDR
			  if (strpos($range[0], '/') !== false && $this::check_ip_cidr($ip, $range[0])) {
			    return true;
				}
			  // Single IP
			  else if ((string)$ip === (string)$range[0]) {
					return true;
				}
			} else {
				$low = ip2long($range[0]);
				$high = ip2long($range[1]);
				$needle = ip2long($ip);
				if ($low === false || $high === false || $needle === false)
					continue;

				$low = (float)sprintf("%u",$low);
				$high = (float)sprintf("%u",$high);
				$needle = (float)sprintf("%u",$needle);

				if ( $needle >= $low && $needle <= $high )
					return true;
			}
		}
		return false;
	}

  public static function check_ip_cidr($ip, $cidr) {

		if (!$ip || !$cidr) return false;
    return $this->match( $ip, $cidr );
	}

  private function match($ip, $cidr) {

		if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			return false;
		}
		$c = explode('/', $cidr);
		$subnet = isset($c[0]) ? $c[0] : NULL;
		$mask = isset($c[1]) ? $c[1] : NULL;
		if ($mask === null) {
			$mask = 32;
		}
		return $this->IPv4Match($ip, $subnet, $mask);
	}

	private function IPv4Match($address, $subnetAddress, $subnetMask) {

		if (!filter_var($subnetAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) || $subnetMask === NULL || $subnetMask === "" || $subnetMask < 0 || $subnetMask > 32) {
			return false;
		}
		$address = ip2long($address);
		$subnetAddress = ip2long($subnetAddress);
		$mask = -1 << (32 - $subnetMask);
		$subnetAddress &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
		return ($address & $mask) == $subnetAddress;
	}

}