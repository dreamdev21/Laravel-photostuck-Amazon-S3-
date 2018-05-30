<?php
//file : app/config/constants.php

return [
    'roles' => [
        'CONTRIBUTOR' => 'contributor',
        'ADMIN' => 'admin',
        'CUSTOMER' => 'customer',
     ],
     'contributor_status' => [
         'PENDING' => 0,
         'APPROVED' => 1,
         'REJECTED' => 2,
      ],
      'subscription_status' => [
          'PENDING' => 0,
          'PAID' => 1,
          'CANCELLED' => 2,
          'HOLD' => 3,
       ],
       'artwork_status' => [
           'PENDING' => 0,
           'APPROVED' => 1,
           'REJECTED' => 2,
        ],
];
