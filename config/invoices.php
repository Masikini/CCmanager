<?php

return [
    'date' => [
        /**
         * Carbon date format
         */
        'format'         => 'd-m-Y',
        /**
         * Due date for payment since invoice's date.
         */
        'pay_until_days' => 7,
    ],

    'serial_number' => [
        'series'           => 'CC',
        'sequence'         => 1,
        /**
         * Sequence will be padded accordingly, for ex. 00001
         */
        'sequence_padding' => 5,
        'delimiter'        => '-',
        /**
         * Supported tags {SERIES}, {DELIMITER}, {SEQUENCE}
         * Example: AA.00001
         */
        // 'format'           => '{SERIES}{DELIMITER}{SEQUENCE}',
        'format'           => '{SERIES}',
    ],

    'currency' => [
        'code'                => 'Kwacha',
        /**
         * Usually cents
         * Used when spelling out the amount and if your currency has decimals.
         *
         * Example: Amount in words: Eight hundred fifty thousand sixty-eight EUR and fifteen ct.
         */
        'fraction'            => 'Tambala',
        'symbol'              => 'MWK',
        /**
         * Example: 19.00
         */
        'decimals'            => 2,
        /**
         * Example: 1.99
         */
        'decimal_point'       => '.',
        /**
         * By default empty.
         * Example: 1,999.00
         */
        'thousands_separator' => '',
        /**
         * Supported tags {VALUE}, {SYMBOL}, {CODE}
         * Example: 1.99 €
         */
        'format'              => '{SYMBOL} {VALUE}',
    ],

    'paper' => [
        // A4 = 210 mm x 297 mm = 595 pt x 842 pt
        'size'        => 'a4',
        'orientation' => 'portrait',
    ],

    'disk' => 'local',

    'seller' => [
        /**
         * Class used in templates via $invoice->seller
         *
         * Must implement LaravelDaily\Invoices\Contracts\PartyContract
         *      or extend LaravelDaily\Invoices\Classes\Party
         */
        'class' => \LaravelDaily\Invoices\Classes\Seller::class,

        /**
         * Default attributes for Seller::class
         */
        'attributes' => [
            'name'          => 'COMPUTER CLINIC MW',
            'address'       => 'Area 47 Sector 1, Near Word Alive International Church',
            'phone'         => '+(265) 99 3636 677 / 88 888 3070',
            'acct_number' => '1008526946',
            'bank'=> 'National Bank of Malawi',
            'acct_name' => 'COMPUTER CLINIC',
            'acct_branch'=> 'Capital City'

           
        ],
    ],
];
