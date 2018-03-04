<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        $data = [
            [
                'question' => 'What did you have for breakfast?',
                'answers' => ['Egg','Toast','Cereal']
            ],
            [
                'question' => 'What did you have for lunch?',
                'answers' => ['Chicken','Beef','Turkey']
            ],
            [
                'question' => 'What did you have for dinner?',
                'answers' => ['Salmon','Tuna','Flounder']
            ],
            [
                'question' => 'How was your day?',
                'answers' => ['Good','Okay','Bad']
            ],
            [
                'question' => 'What\'s your favorite color?',
                'answers' => ['Orange','Blue','Green']
            ],
            [
                'question' => 'What\'s your favorite animal?',
                'answers' => ['Dog','Cat','Turtle']
            ],
            [
                'question' => 'What\'s your favorite month?',
                'answers' => ['January','February','March','April','May','June','July','August','September','October','November','December']
            ],
            [
                'question' => 'What\'s your favorite car?',
                'answers' => ['Sedan','SUV','Truck']
            ]
        ];
        
        foreach($data as $qaPair) {
            
            $questionId = DB::table('questions')->insertGetId(['question' => $qaPair['question'], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            
            $answersArray = [];
            foreach($qaPair['answers'] as $answer) {
                $answersArray[] = ['questions_id' => $questionId, 'answer' => $answer, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            }
            
            DB::table('answers')->insert($answersArray);
        }
    }
}
