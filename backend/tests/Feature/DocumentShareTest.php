<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentShare;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentShareTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_share_document_with_collaborator()
    {
        $owner = User::factory()->create();

        $collaborator = User::factory()->create();

        $document = Document::create([
            'title' => 'Project Plan',
            'content' => '<p>Hello World</p>',
            'owner_id' => $owner->id,
        ]);

        DocumentShare::create([
            'document_id' => $document->id,
            'user_id' => $collaborator->id,
        ]);

        $sharedDocuments = Document::whereIn(
            'id',
            DocumentShare::where(
                'user_id',
                $collaborator->id
            )->pluck('document_id')
        )->get();

        $this->assertCount(1, $sharedDocuments);

        $this->assertEquals(
            'Project Plan',
            $sharedDocuments->first()->title
        );
    }
}