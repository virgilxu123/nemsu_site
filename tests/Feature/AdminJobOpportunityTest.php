<?php

use App\Models\JobOpportunity;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->withoutVite();
});

function jobOpportunityAdminUser(): User
{
    return User::factory()->create([
        'account_type' => 'admin',
    ]);
}

function jobOpportunityPayload(array $overrides = []): array
{
    return [
        'name' => 'Information Technology Officer',
        'slug' => 'information-technology-officer',
        'content' => '<p>Build and maintain university systems.</p>',
        'date' => '2026-06-09T09:30',
        'is_hiring' => '1',
        'is_published' => '1',
        ...$overrides,
    ];
}

test('guests are redirected to login from admin job opportunities', function () {
    $this->get(route('admin.job-opportunities.index'))
        ->assertRedirect(route('login'));
});

test('non admin users cannot manage job opportunities', function () {
    $user = User::factory()->create([
        'account_type' => 'contributor',
    ]);

    $this->actingAs($user)
        ->get(route('admin.job-opportunities.index'))
        ->assertForbidden();
});

test('admins can view job opportunity management pages', function () {
    $admin = jobOpportunityAdminUser();
    $opportunity = JobOpportunity::factory()->create([
        'name' => 'Administrative Assistant',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.job-opportunities.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/job-opportunities/Index')
            ->has('opportunities.data', 1)
            ->where('opportunities.data.0.id', $opportunity->id)
        );

    $this->actingAs($admin)
        ->get(route('admin.job-opportunities.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/job-opportunities/Create')
        );

    $this->actingAs($admin)
        ->get(route('admin.job-opportunities.edit', $opportunity))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/job-opportunities/Edit')
            ->where('opportunity.id', $opportunity->id)
        );
});

test('admins can create job opportunities with generated slugs and statuses', function () {
    $admin = jobOpportunityAdminUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.job-opportunities.store'), jobOpportunityPayload([
            'name' => ' University Registrar ',
            'slug' => '',
            'content' => ' <p>Manage university records.</p> ',
        ]));

    $opportunity = JobOpportunity::query()->firstOrFail();

    $response->assertRedirect(route('admin.job-opportunities.edit', $opportunity));

    expect($opportunity->name)->toBe('University Registrar')
        ->and($opportunity->slug)->toBe('university-registrar')
        ->and($opportunity->content)->toBe('<p>Manage university records.</p>')
        ->and($opportunity->is_hiring)->toBeTrue()
        ->and($opportunity->is_published)->toBeTrue();
});

test('job opportunity validation requires content and unique slugs', function () {
    $admin = jobOpportunityAdminUser();
    JobOpportunity::factory()->create(['slug' => 'existing-opportunity']);

    $this->actingAs($admin)
        ->from(route('admin.job-opportunities.create'))
        ->post(route('admin.job-opportunities.store'), jobOpportunityPayload([
            'name' => '',
            'slug' => 'existing-opportunity',
            'content' => '',
            'date' => '',
        ]))
        ->assertRedirect(route('admin.job-opportunities.create'))
        ->assertSessionHasErrors(['name', 'slug', 'content', 'date']);
});

test('admins can update and delete job opportunities', function () {
    $admin = jobOpportunityAdminUser();
    $opportunity = JobOpportunity::factory()->create([
        'name' => 'Old Position',
        'slug' => 'old-position',
        'is_hiring' => true,
        'is_published' => true,
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.job-opportunities.update', $opportunity), jobOpportunityPayload([
            'name' => 'Updated Position',
            'slug' => 'updated-position',
            'is_hiring' => '0',
            'is_published' => '0',
        ]))
        ->assertRedirect(route('admin.job-opportunities.edit', $opportunity));

    expect($opportunity->refresh()->name)->toBe('Updated Position')
        ->and($opportunity->slug)->toBe('updated-position')
        ->and($opportunity->is_hiring)->toBeFalse()
        ->and($opportunity->is_published)->toBeFalse();

    $this->actingAs($admin)
        ->delete(route('admin.job-opportunities.destroy', $opportunity))
        ->assertRedirect(route('admin.job-opportunities.index'));

    $this->assertModelMissing($opportunity);
});

test('admin job opportunity index searches filters and sorts records', function () {
    $admin = jobOpportunityAdminUser();
    $matchingOpportunity = JobOpportunity::factory()->hiring()->published()->create([
        'name' => 'Software Engineer',
        'content' => '<p>Develop university software.</p>',
        'date' => '2026-06-09 09:00:00',
    ]);
    JobOpportunity::factory()->create([
        'name' => 'Closed Accounting Position',
        'is_hiring' => false,
        'is_published' => false,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.job-opportunities.index', [
            'search' => 'software',
            'hiring_status' => 'hiring',
            'publication_status' => 'published',
            'sort_by' => 'name',
            'sort_direction' => 'asc',
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('opportunities.data', 1)
            ->where('opportunities.data.0.id', $matchingOpportunity->id)
            ->where('filters.search', 'software')
            ->where('filters.hiring_status', 'hiring')
            ->where('filters.publication_status', 'published')
        );
});
