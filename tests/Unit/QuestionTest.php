<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class QuestionTest extends TestCase
{
    /**
     * Test question without auth
     *
     * @return void
     */
    public function testQuestion()
    {
        $response = $this->get('/question');

        $response->assertStatus(302);
    }
    
    /**
     * Test question with fake auth
     *
     * @return void
     */
    public function testQuestionAuth()
    {
        //user logged in success.
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                         ->get('/question');

        $response->assertStatus(200);
    }
    /**
     * Testing question structure.
     *
     * @return void
     */
    public function testFetchQuestions()
    {
        //user logged in success.
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                         ->json('GET', '/fetchQuestions');

        $response->assertStatus(200)->assertJson([
            [
                'question' => true,
                'id' => true,
                'answers' => [
                    [
                        'id' => true,
                        'answer' => true
                    ]
                ]
            ]
        ]);
    }
    
    /**
     * Testing answer question post success
     *
     * @return void
     */
    public function testAnswerQuestionSuccess()
    {
        //user logged in success.
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                         ->json('POST', '/answerQuestions', [
                             'question' => 1,
                             'answer' => 2,
                         ]);

        $response->assertStatus(200)->assertExactJson([
            'success' => true,
        ]);
    }
    
    /**
     * Testing answer question post failure
     *
     * @return void
     */
    public function testAnswerQuestionFail()
    {
        //user logged in success.
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                         ->json('POST', '/answerQuestions', [
                             'question' => 1,
                             'answer' => 'lol',
                         ]);

        $response->assertStatus(200)->assertExactJson([
            'success' => false,
            'message' => 'Form is invalid, please try again'
        ]);
    }
}
