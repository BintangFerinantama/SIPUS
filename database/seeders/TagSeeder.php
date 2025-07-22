<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Dokumen Resmi',
            'Laporan Keuangan',
            'Surat Menyurat',
            'Foto Kegiatan',
            'Presentasi',
            'Manual Panduan',
            'Kontrak',
            'Invoice',
            'Sertifikat',
            'Data Backup',
            'Proposal',
            'Notulen Rapat',
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(['name' => $tagName]);
        }
    }
}
