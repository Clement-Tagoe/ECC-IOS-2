<?php

namespace Database\Seeders;

use App\Models\Suspect;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Suspect::create([
            'date' => '2025-01-15',
            'name' => 'James Osei Mensah',
            'officer_in_charge' => 'Sgt. Kofi Asante',
            'personal_items' => 'Black wallet, Nokia phone, leather belt, silver watch',
            'time_in' => '08:30:00',
            'time_out' => '11:45:00',
            'notes' => 'Brought in for questioning regarding a robbery incident on Ring Road. Cooperative during interrogation.',
        ]);

        Suspect::create([
            'date' => '2025-01-22',
            'name' => 'Kwame Boateng',
            'officer_in_charge' => 'Insp. Abena Owusu',
            'personal_items' => null,
            'time_in' => '14:00:00',
            'time_out' => '16:30:00',
            'notes' => 'Suspect linked to a series of pickpocketing cases at Makola Market. Denies involvement.',
        ]);

        Suspect::create([
            'date' => '2025-02-03',
            'name' => 'Ama Serwaa Darko',
            'officer_in_charge' => 'Sgt. Kofi Asante',
            'personal_items' => 'Red handbag, national ID card, two mobile phones (Tecno and Samsung)',
            'time_in' => '09:15:00',
            'time_out' => null,
            'notes' => 'Detained pending further investigation into a fraud complaint filed by a local business owner.',
        ]);

        Suspect::create([
            'date' => '2025-02-18',
            'name' => 'Emmanuel Tetteh Laryea',
            'officer_in_charge' => 'D/Sgt. Yaw Frimpong',
            'personal_items' => 'Blue backpack, charger, pair of earphones, GHS 120 cash',
            'time_in' => '11:00:00',
            'time_out' => '13:20:00',
            'notes' => 'Apprehended near Tema Station following a tip-off. No concrete evidence found; released after questioning.',
        ]);

        Suspect::create([
            'date' => '2025-03-07',
            'name' => 'Akosua Pokuaa Nimako',
            'officer_in_charge' => 'Insp. Abena Owusu',
            'personal_items' => 'White envelope containing documents, wristband, pair of slippers',
            'time_in' => '15:45:00',
            'time_out' => '18:00:00',
            'notes' => 'Involved in a domestic dispute that escalated. Referred to social welfare after release.',
        ]);
    }
}
