<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixServicesTableSeeder extends Seeder
{
    /**
     * Run the seeder to fix the services table after removing the price column.
     */
    public function run(): void
    {
        // Check if price column exists - if it does, we need to migrate data
        if (Schema::hasColumn('services', 'price')) {
            $this->command->info('Found price column in services table. Migrating data to contract_durations table...');
            
            // Get all services with prices
            $services = DB::table('services')->whereNotNull('price')->get();
            
            // Get the default duration (usually 12 months)
            $defaultDuration = DB::table('durations')->where('months', 12)->first();
            
            if (!$defaultDuration) {
                // If no 12-month duration exists, get the first duration
                $defaultDuration = DB::table('durations')->first();
                
                if (!$defaultDuration) {
                    // Create a default duration if none exists
                    $defaultDurationId = DB::table('durations')->insertGetId([
                        'label' => '1 năm',
                        'months' => 12,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $defaultDuration = DB::table('durations')->find($defaultDurationId);
                }
            }
            
            $this->command->info("Using duration: {$defaultDuration->label} ({$defaultDuration->months} months) as default");
            
            // Migrate prices to contract_durations
            foreach ($services as $service) {
                // Check if this service already has a contract duration entry for the default duration
                $existingDuration = DB::table('contract_durations')
                    ->where('service_id', $service->id)
                    ->where('duration_id', $defaultDuration->id)
                    ->first();
                
                if (!$existingDuration && $service->price > 0) {
                    DB::table('contract_durations')->insert([
                        'service_id' => $service->id,
                        'duration_id' => $defaultDuration->id,
                        'price' => $service->price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $this->command->info("Migrated price {$service->price} for service ID {$service->id}");
                } else {
                    $this->command->info("Skipped service ID {$service->id}: already has duration or price is 0");
                }
            }
        } else {
            $this->command->info('Price column not found in services table. No migration needed.');
        }
    }
} 