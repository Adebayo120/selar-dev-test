<?php

use App\Constants\Plan\PlanId;
use App\Constants\Readables\Plan\ReadablePlanType;
use Illuminate\Support\Facades\Http;

if( ! class_exists('SelarDevTestCore') ) {

    class SelarDevTestCore {

        /**
         * A_YEAR_IN_MINUTES
         */
        const A_YEAR_IN_MINUTES = 525600;

        /**
         * readablePlan
         *
         * @param [type] $planId
         * @return string
         */
        public static function readablePlan( $planId ){
            $planReadableName = "";
            switch ( $planId ) {
                case PlanId::STARTER:
                    $planReadableName = ReadablePlanType::STARTER;
                    break;
                case PlanId::PRO:
                    $planReadableName = ReadablePlanType::PRO;
                    break;
                case PlanId::TURBO:
                    $planReadableName = ReadablePlanType::TURBO;
                    break;
                default:
                    # code...
                    break;
            }
            return $planReadableName;
        }

        /**
         * cookieTimezone
         *
         * @return null|string
         */
        public static function cookieTimezone ()
        {
            $ip_api_response = Http::get( "http://ip-api.com/json" );
                
            $timezone = ( $ip_api_response && $ip_api_response[ "status" ] == "success" ) ? $ip_api_response[ 'timezone' ] : null;

            if ( $timezone )
            {
                cookie()->queue( cookie( config( 'app.timezone_index' ), $timezone, self::A_YEAR_IN_MINUTES ) );
            }

            return $timezone;
        }

        /**
         * convertCurrency
         *
         * @param string $amount
         * @param string $from_currency
         * @param string $to_currency
         * @return string
         */
        public static function convertCurrency( $amount, $from_currency, $to_currency ){
            $apikey = config( 'app.currency_converter_api_key' );
            
            $from_Currency = urlencode( $from_currency );
            $to_Currency = urlencode($to_currency);
            $query =  "{$from_Currency}_{$to_Currency}";

            $json = Http::get( "https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}" );
          
            $val = floatval($json->json()[$query]);
          
            $total = $val * $amount;
            return number_format($total, 2, '.', '');
        }
    }
}