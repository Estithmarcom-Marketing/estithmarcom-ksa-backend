<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const SERVICES = [
        1 => [
            'slug_en' => 'establishing-companies',
            'target_type' => 'category',
            'target_id' => 'company-formation',
        ],
        2 => [
            'slug_en' => 'marketing-feasibility-study-services',
            'target_type' => 'category',
            'target_id' => 'marketing-feasibility',
        ],
        3 => [
            'slug_en' => 'government-procedures-follow-up',
            'target_type' => 'category',
            'target_id' => 'government-procedures',
        ],
        4 => [
            'slug_en' => 'premium-residency-golden',
            'target_type' => 'category',
            'target_id' => 'premium-residency',
        ],
        5 => [
            'slug_en' => 'ready-workspaces-co-working-spaces',
            'target_type' => 'category',
            'target_id' => 'ready-workspaces',
        ],
        7 => [
            'slug_en' => 'entrepreneurial-licensing-project-incubation',
            'target_type' => 'category',
            'target_id' => 'entrepreneurial-licenses',
        ],
        8 => [
            'slug_en' => 'legal-services',
            'target_type' => 'category',
            'target_id' => 'legal-services',
        ],
        9 => [
            'slug_en' => 'financial-services',
            'target_type' => 'category',
            'target_id' => 'financial-services',
        ],
    ];

    public function up(): void
    {
        DB::transaction(function (): void {
            /*
             * Validate every production row before changing any mapping.
             * Both ID and English slug must match the audited production data.
             */
            foreach (self::SERVICES as $id => $service) {
                $row = DB::table('services')
                    ->where('id', $id)
                    ->where('slug_en', $service['slug_en'])
                    ->lockForUpdate()
                    ->first([
                        'id',
                        'chat_target_type',
                        'chat_target_id',
                    ]);

                if (! $row) {
                    throw new \RuntimeException(
                        "Service {$id} / {$service['slug_en']} was not found. Migration aborted."
                    );
                }

                $hasExistingTarget =
                    $row->chat_target_type !== null ||
                    $row->chat_target_id !== null;

                $alreadyCorrect =
                    $row->chat_target_type === $service['target_type'] &&
                    $row->chat_target_id === $service['target_id'];

                if ($hasExistingTarget && ! $alreadyCorrect) {
                    throw new \RuntimeException(
                        "Service {$id} already has a different chat target. Migration aborted."
                    );
                }
            }

            foreach (self::SERVICES as $id => $service) {
                DB::table('services')
                    ->where('id', $id)
                    ->where('slug_en', $service['slug_en'])
                    ->update([
                        'chat_target_type' => $service['target_type'],
                        'chat_target_id' => $service['target_id'],
                    ]);
            }
        });
    }

    public function down(): void
    {
        DB::transaction(function (): void {
            foreach (self::SERVICES as $id => $service) {
                DB::table('services')
                    ->where('id', $id)
                    ->where('slug_en', $service['slug_en'])
                    ->where('chat_target_type', $service['target_type'])
                    ->where('chat_target_id', $service['target_id'])
                    ->update([
                        'chat_target_type' => null,
                        'chat_target_id' => null,
                    ]);
            }
        });
    }
};
