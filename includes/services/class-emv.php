<?php


class WP_ICPFW_EMV
{
   
    private $fields;

    public function __construct()
    {
        $this->fields = array();
    }

 
    public function set($key, $value)
    {
        $this->fields[$key] = $value;
        return $this;
    }

   
    public function exists($key)
    {
        return isset($this->fields[$key]);
    }

 
    public function get($key)
    {
        return $this->fields[$key];
    }

   
    public function __toString()
    {
        ksort($this->fields);
        $stream = '';
        foreach ($this->fields as $key => $value) {
            $key = str_pad("{$key}", 2, '0', STR_PAD_LEFT);
            $value = "{$value}";
            $length = mb_strlen($value);
            $length = str_pad("{$length}", 2, '0', STR_PAD_LEFT);
            $stream .= "{$key}{$length}{$value}";
        }
        if (isset($this->fields[ICPFW_CRC16])) {
            $stream = mb_substr($stream, 0, -4);
            $crcCalculator = new WP_ICPFW_CRC16();
            $WP_ICPFW_CRC16 = $crcCalculator->calculate($stream);
            $stream .= $WP_ICPFW_CRC16;
        }
        return $stream;
    }
}
