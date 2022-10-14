<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\risk_matrix;
use Illuminate\Database\Seeder;

class RiskMatrixTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $greenCode = '#00FF00';
        $redCode = '#FF0000';
        $yellowCode = '#FFFF00';
        $orangeCode = '#FFA500';
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $riskMatrixItems = [
            [
                'code'        => 'A1',
                'hex_code'	  => $greenCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'A2',
                'hex_code'	  => $greenCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'A3',
                'hex_code'	  => $greenCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'A4',
                'hex_code'	  => $greenCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'A5',
                'hex_code'	  => $yellowCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'B1',
                'hex_code'	  => $greenCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'B2',
                'hex_code'	  => $greenCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'B3',
                'hex_code'	  => $greenCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'B4',
                'hex_code'	  => $yellowCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'B5',
                'hex_code'	  => $orangeCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'C1',
                'hex_code'	  => $greenCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'C2',
                'hex_code'	  => $greenCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'C3',
                'hex_code'	  => $yellowCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'C4',
                'hex_code'	  => $orangeCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'C5',
                'hex_code'	  => $orangeCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'D1',
                'hex_code'	  => $yellowCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'D2',
                'hex_code'	  => $yellowCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'D3',
                'hex_code'	  => $orangeCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'D4',
                'hex_code'	  => $orangeCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'D5',
                'hex_code'	  => $redCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'E1',
                'hex_code'	  => $yellowCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'E2',
                'hex_code'	  => $orangeCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'E3',
                'hex_code'	  => $orangeCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'E4',
                'hex_code'	  => $redCode,
                'created_at' => $now,
    			'updated_at' => $now
            ],
            [
                'code'        => 'E5',
                'hex_code'	  => $redCode,
                'created_at' => $now,
    			'updated_at' => $now
            ]
        ];

        /*
         * Add Risk Matrix Items
         *
         */
        risk_matrix::insert($riskMatrixItems);
    }
}
