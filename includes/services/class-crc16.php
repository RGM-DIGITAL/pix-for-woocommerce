<?php


class WP_ICPFW_CRC16
{
  
    public function byte($texto, $ordem)
    {
        return ord(substr($texto, $ordem, 1));
    }

    public function calculate($texto)
    {

        $response   = 0xFFFF;
        $polynomial = 0x1021;

        if (($length = strlen($texto)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $response ^= (ord($texto[$offset]) << 8);

                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($response <<= 1) & 0x10000) {
                        $response ^= $polynomial;
                    }

                    $response &= 0xFFFF;
                }
            }
        }
        return strtoupper( dechex( $response ) );
    }
}
