<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ErrorReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_custom_404_page_renders_with_correct_headers()
    {
        $response = $this->get('/this-page-does-not-exist');

        $response->assertStatus(404);
        $response->assertHeader('X-Error-Code', '404');
        $response->assertSee('Опишите, что вы делали:');
    }

    public function test_guest_can_submit_error_report()
    {
        $response = $this->post('/error-report', [
            'user_comment' => 'Кнопка не нажимается',
            'error_message' => 'Test Error',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('error_reports', [
            'user_comment' => 'Кнопка не нажимается'
        ]);
    }
}