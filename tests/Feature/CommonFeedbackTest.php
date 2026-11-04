<?php

namespace Tests\Feature;

use App\Models\Counter;
use App\Models\ServiceQuality;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommonFeedbackTest extends TestCase
{
    public function test_common_feedback_page_can_be_rendered()
    {
        $response = $this->get(route('feedback.common'));

        $response->assertStatus(200);
        $response->assertSee('Counter');
        $response->assertSee('Select Counter');
        $response->assertSessionHas('feedback_token');
        $response->assertSessionHas('rating_access', true);
    }

    public function test_specific_counter_feedback_page_displays_counter_pill()
    {
        $counter = Counter::first();
        if (!$counter) {
            $counter = Counter::create([
                'district' => 'Jaffna',
                'division_name' => 'Jaffna',
                'counter_name' => 'A',
            ]);
        }

        $response = $this->get(route('feedback.show', [
            'division' => $counter->division_name,
            'counter' => $counter->counter_name,
        ]));

        $response->assertStatus(200);
        $response->assertSee($counter->division_name . ' – ' . $counter->counter_name);
    }

    public function test_feedback_can_be_submitted_via_common_route()
    {
        $counter = Counter::first();
        $quality = ServiceQuality::where('type', 'good')->first();

        // 1. Visit common page to establish session token
        $pageResponse = $this->get(route('feedback.common'));
        $pageResponse->assertStatus(200);
        $token = session('feedback_token');

        // 2. Submit form
        $postResponse = $this->post(route('feedback.store'), [
            'counter_id' => $counter->id,
            'feedback_token' => $token,
            'rating' => 5,
            'service_quality_id' => $quality ? $quality->id : null,
            'has_complaint' => 'no',
        ]);

        $postResponse->assertRedirect(route('feedback.thankyou'));
        $this->assertDatabaseHas('feedbacks', [
            'counter_id' => $counter->id,
            'rating' => 5,
            'has_complaint' => 'no',
        ]);
    }

    public function test_common_qr_pdf_can_be_downloaded_by_authenticated_user()
    {
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        $response = $this->actingAs($user)->get(route('ds-divisions.commonQrPdf'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_online_tax_counter_is_shown_in_common_feedback_dropdown()
    {
        $onlineTaxCounter = Counter::firstOrCreate(
            [
                'division_name' => 'Online Services',
                'counter_name' => 'Online Tax',
            ],
            [
                'district' => 'Northern Province',
            ]
        );

        $response = $this->get(route('feedback.common'));

        $response->assertStatus(200);
        $response->assertSee('Online Tax');
        $response->assertSee('value="' . $onlineTaxCounter->id . '"', false);
    }

    public function test_feedback_can_be_submitted_for_online_tax_counter()
    {
        $onlineTaxCounter = Counter::firstOrCreate(
            [
                'division_name' => 'Online Services',
                'counter_name' => 'Online Tax',
            ],
            [
                'district' => 'Northern Province',
            ]
        );

        $quality = ServiceQuality::firstOrCreate(
            ['name' => 'Fast Service', 'type' => 'good'],
            ['description' => 'Fast service delivery']
        );

        $pageResponse = $this->get(route('feedback.common'));
        $pageResponse->assertStatus(200);
        $token = session('feedback_token');

        $postResponse = $this->post(route('feedback.store'), [
            'counter_id' => $onlineTaxCounter->id,
            'feedback_token' => $token,
            'rating' => 5,
            'service_quality_id' => $quality->id,
            'has_complaint' => 'no',
        ]);

        $postResponse->assertRedirect(route('feedback.thankyou'));
        $this->assertDatabaseHas('feedbacks', [
            'counter_id' => $onlineTaxCounter->id,
            'rating' => 5,
            'has_complaint' => 'no',
        ]);
    }

    public function test_online_tax_counter_does_not_need_qr_code_on_ds_divisions_page()
    {
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        $onlineTaxCounter = Counter::firstOrCreate(
            [
                'division_name' => 'Online Services',
                'counter_name' => 'Online Tax',
            ],
            [
                'district' => 'Northern Province',
            ]
        );

        // In ds-divisions page, check it shows No QR Needed badge
        $response = $this->actingAs($user)->get(route('ds-divisions.index', ['district' => 'Northern Province']));
        $response->assertStatus(200);
        $response->assertSee('No QR Needed');

        // And posting to generateQr returns an error
        $generateResponse = $this->actingAs($user)->post(route('generateQr'), [
            'counter_id' => $onlineTaxCounter->id,
        ]);
        $generateResponse->assertSessionHas('error');
    }
}
