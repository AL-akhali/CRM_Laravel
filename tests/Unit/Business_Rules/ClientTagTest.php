<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ClientTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tag_name_must_be_unique()
    {
        ClientTag::create([
            'name' => 'Important',
            'slug' => 'important',
            'color' => 'red',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        // محاولة إنشاء tag بنفس الاسم (ويفترض أن الـ slug يتولد تلقائياً بنفس الاسم)
        ClientTag::create([
            'name' => 'Important',
            'slug' => 'important', // slug مكرر
            'color' => 'blue',
        ]);
    }

    /** @test */
    public function slug_is_auto_generated_from_name()
    {
        $tag = ClientTag::create([
            'name' => 'New Tag',
            // لا نعطي slug يدوياً
        ]);

        $this->assertEquals('new-tag', $tag->slug);
    }
}
