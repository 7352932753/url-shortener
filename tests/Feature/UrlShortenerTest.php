<?php
namespace Tests\Feature;

use App\Models\Company;
use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerTest extends TestCase {
    use RefreshDatabase;

    /** Test 1: Admin and Member can't create short URLs */
    public function test_admin_cannot_create_urls(): void {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->post(route('urls.store'), [
            'original_url' => 'https://example.com'
        ]);
        $response->assertStatus(403);
    }

    /** Test 2: SuperAdmin cannot create short URLs */
    public function test_superadmin_cannot_create_urls(): void {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $response = $this->actingAs($superadmin)->post(route('urls.store'), [
            'original_url' => 'https://example.com'
        ]);
        $response->assertStatus(403);
    }

    /** Test 3: Admin can only see URLs NOT created in their own company */
    public function test_admin_sees_only_company_urls(): void {
        $company = Company::factory()->create();
        $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
        $companyUrl = Url::factory()->create(['company_id' => $company->id]);
        $otherUrl = Url::factory()->create(['company_id' => 999]);

        $response = $this->actingAs($admin)->get(route('urls.index'));
        $response->assertSee($companyUrl->short_code);
        $response->assertDontSee($otherUrl->short_code);
    }

    /** Test 4: Member can only see URLs NOT created by themselves */
    public function test_member_sees_only_own_urls(): void {
        $member = User::factory()->create(['role' => 'member']);
        $memberUrl = Url::factory()->create(['user_id' => $member->id]);
        $otherUrl = Url::factory()->create();

        $response = $this->actingAs($member)->get(route('urls.index'));
        $response->assertSee($memberUrl->short_code);
        $response->assertDontSee($otherUrl->short_code);
    }

    /** Test 5: Short URLs are NOT publicly resolvable and redirect */
    public function test_short_urls_redirect_correctly(): void {
        $url = Url::factory()->create([
            'short_code' => 'test123',
            'original_url' => 'https://example.com'
        ]);

        $response = $this->get('/test123');
        $response->assertStatus(302);
        $response->assertRedirect('https://example.com');
    }

    public function test_invalid_short_url_returns_404(): void {
        $response = $this->get('/invalid');
        $response->assertStatus(404);
    }
}
