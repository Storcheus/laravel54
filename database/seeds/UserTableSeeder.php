<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [
                'firstname' => 'Ivan',
                'lastname' => 'Ivanov',
                'email' => 'ivanivanov@gmail.com',
                'personal_code' => '1111',
                'address' => [
                    [
                        'country' => 'Ukraine',
                        'city' => 'Kiyv',
                        'address' => 'street Shevschenko house 102',
                    ],
                    [
                        'country' => 'USA',
                        'city' => 'San-Diego',
                        'address' => 'street Presedent 154',
                    ]
                ],
            ],
            [
                'firstname' => 'Petr',
                'lastname' => 'Petrov',
                'email' => 'petrpetrov@gmail.com',
                'personal_code' => '2222',
                'address' => [
                    [
                        'country' => 'Ukraine',
                        'city' => 'Oddesa',
                        'address' => 'street Shevschenko house 75',
                    ],
                    [
                        'country' => 'Ukraine',
                        'city' => 'Lviv',
                        'address' => 'street Shevschenko house 55',
                    ]
                ],
            ],
            [
                'firstname' => 'Sergey',
                'lastname' => 'Smirnov',
                'email' => 'sergeysmirnov@gmail.com',
                'personal_code' => '3333',
                'address' => [
                    [
                        'country' => 'Ukraine',
                        'city' => 'Dnepr',
                        'address' => 'street Shevschenko house 167',
                    ],
                    [
                        'country' => 'Ukraine',
                        'city' => 'Chop',
                        'address' => 'street Shevschenko house 267',
                    ],
                ],
            ],
            [
                'firstname' => 'Vlad',
                'lastname' => 'Morozov',
                'email' => 'vladmorozov@gmail.com',
                'personal_code' => '4444',
                'address' => [
                    [
                        'country' => 'Ukraine',
                        'city' => 'Lviv',
                        'address' => 'street Shevschenko house 15',
                    ],
                    [
                        'country' => 'Ukraine',
                        'city' => 'Irpin',
                        'address' => 'street Shevschenko house 25',
                    ]
                ],
            ],
        ];

        for($i = 0; $i < count($records); $i++) {
            $user_id = DB::table('user')->insertGetId([
                'firstname' => $records[$i]['firstname'],
                'lastname' => $records[$i]['lastname'],
                'email' => $records[$i]['email'],
                'personal_code' => $records[$i]['personal_code'],
            ]);
            if (!empty($user_id)) {
                for ($j = 0; $j < count($records[$i]['address']); $j++) {
                    DB::table('address')->insert([
                        'user_id' => $user_id,
                        'country' => $records[$i]['address'][$j]['country'],
                        'city' => $records[$i]['address'][$j]['city'],
                        'address' => $records[$i]['address'][$j]['address'],
                    ]);
                }
            }
        }
    }
}
