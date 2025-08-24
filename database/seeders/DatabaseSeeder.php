<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');
        
        try {
            // Call seeders in proper dependency order
            $this->call([
                UserSeeder::class,           // 1. Create users first
                KelasSeeder::class,          // 2. Create kelas
                MataPelajaranSeeder::class,  // 3. Create mata pelajaran
                GradeSettingSeeder::class,   // 4. Create grade settings
                TemplateKurikulumSeeder::class, // 5. Create curriculum templates
                SampleDataSeeder::class,     // 6. Create sample data (depends on all above)
            ]);
            
            $this->command->info('Database seeding completed successfully!');
            
        } catch (\Exception $e) {
            $this->command->error('Database seeding failed: ' . $e->getMessage());
            $this->command->error('Please check the error and run the seeders individually if needed.');
            throw $e;
        }
    }
}
