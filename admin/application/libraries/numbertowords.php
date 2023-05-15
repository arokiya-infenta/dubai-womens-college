<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Numbertowords {
function convert_number($figure) {
if (($figure < 0) || ($figure > 999999999)) {
            throw new Exception("Your Number is out of range");
        }
        $giga = floor($figure / 1000000);
        // Millions (giga)
        $figure -= $giga * 1000000;
        $kilo = floor($figure / 1000);
        // Thousands (kilo)
        $figure -= $kilo * 1000;
        $hecto = floor($figure / 100);
        // Hundreds (hecto)
        $figure -= $hecto * 100;
        $deca = floor($figure / 10);
        // Tens (deca)
        $n = $figure % 10;
        // Ones
        $result = "";
        if ($giga) {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
        }
        if ($hecto) {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) {
                $result .= " and ";
            }
            if ($deca < 2) {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result)) {
            $result = "zero";
        }
        return $result;
}
}
?>