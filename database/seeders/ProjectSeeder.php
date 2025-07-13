<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectDetail;
use App\Models\ProjectGallery;
use App\Models\StudyProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    // public function run()
    // {
    //     $projectCategories = ProjectCategory::all();
    //     $totalProjects = 3200;
    //     $categoryCount = $projectCategories->count();
    //     $projectsPerCategory = (int) ceil($totalProjects / $categoryCount);

    //     $faker = fake();

    //     foreach ($projectCategories as $category) {
    //         for ($i = 0; $i < $projectsPerCategory; $i++) {
    //             $startYear = $faker->numberBetween(2020, 2024);
    //             $endYear = $startYear + 1;

    //             $project = Project::create([
    //                 'project_category_id' => $category->id,
    //                 'project_title' => $faker->sentence(4),
    //                 'school_year' => "$startYear/$endYear",
    //                 'semester' => $faker->randomElement(['Ganjil', 'Genap']),
    //                 'thumbnail' => 'assets/images/projects/dummy_datas/thumbnails/sample.png',
    //             ]);

    //             // Generate 2–5 anggota
    //             $memberCount = $faker->numberBetween(5, 10);
    //             $members = [];

    //             for ($j = 0; $j < $memberCount; $j++) {
    //                 $members[] = [
    //                     'student_id_number' => $faker->unique()->numerify('20######'),
    //                     'student_name' => $faker->name(),
    //                 ];
    //             }

    //             // Deskripsi panjang (2–5 paragraf)
    //             $description = $faker->paragraphs($faker->numberBetween(5, 8), true);

    //             $projectDetail = ProjectDetail::create([
    //                 'project_id' => $project->id,
    //                 'members' => json_encode($members),
    //                 'description' => $description,
    //                 'video_trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    //                 'presentation_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    //                 'poster_path' => 'assets/images/projects/dummy_datas/posters/sample.png',
    //             ]);

    //             // Galeri dummy: generate 3–6 gambar
    //             $galleryCount = $faker->numberBetween(5, 10);
    //             for ($k = 0; $k < $galleryCount; $k++) {
    //                 ProjectGallery::create([
    //                     'project_detail_id' => $projectDetail->id,
    //                     'image_path' => 'assets/images/projects/dummy_datas/galleries/sample.png',
    //                 ]);
    //             }
    //         }
    //     }
    // }

    public function run()
    {
        $projectCategories = ProjectCategory::all();
        $totalProjects = 1000; // Jumlah total proyek
        $projectsPerCategory = (int) ceil($totalProjects / $projectCategories->count());

        $faker = \Faker\Factory::create('id_ID'); // Faker Bahasa Indonesia

        // Path gambar lokal
        $localThumbnail = 'assets/images/projects/dummy_datas/thumbnails/sample.png';
        $localPoster = 'assets/images/projects/dummy_datas/posters/sample.png';
        $localGallery = 'assets/images/projects/dummy_datas/galleries/sample.png';

        // Mapping kategori ke konten Bahasa Indonesia
        $categoryData = [
            'Aplikasi Web' => [
                'keywords' => ['E-Commerce', 'Sistem Informasi', 'Blog', 'Portal Berita', 'Dashboard'],
                'tech' => ['Laravel', 'React', 'Vue.js', 'Node.js', 'Django'],
                'videos' => ['k1BneeJTDcU', 'PkZNo7MFNFg', 'DLX62G4lc44']
            ],
            // Data kategori lainnya tetap sama...
            // (tambahkan mapping untuk semua kategori yang ada)
        ];

        $projectIdCounter = 1000;

        foreach ($projectCategories as $category) {
            $categoryName = $category->project_category_name;
            $categoryInfo = $categoryData[$categoryName] ?? $categoryData['Aplikasi Web'];

            for ($i = 0; $i < $projectsPerCategory; $i++) {
                $projectIdCounter++;
                $startYear = $faker->numberBetween(2020, 2024);
                $endYear = $startYear + 1;

                // Generate judul proyek
                $projectTitle = $faker->randomElement($categoryInfo['keywords']) . ' ' .
                    $faker->randomElement(['Proyek', 'Sistem', 'Aplikasi', 'Platform']) . ' ' .
                    'Menggunakan ' . $faker->randomElement($categoryInfo['tech']);

                // Buat project dengan gambar lokal
                $project = Project::create([
                    'project_category_id' => $category->id,
                    'project_title' => $projectTitle,
                    'school_year' => "$startYear/$endYear",
                    'semester' => $faker->randomElement(['Ganjil', 'Genap']),
                    'thumbnail' => $localThumbnail,
                ]);

                // Generate anggota tim (3-5 orang)
                $members = array_map(function () use ($faker) {
                    return [
                        'student_id_number' => $faker->unique()->numerify('20######'),
                        'student_name' => $faker->name(),
                    ];
                }, range(1, $faker->numberBetween(3, 5)));

                // Deskripsi panjang dalam Bahasa Indonesia
                $description = $this->generateIndonesianDescription($categoryName, $faker);

                // Video
                $trailerVideoId = $faker->randomElement($categoryInfo['videos']);
                $presentationVideoId = $faker->randomElement(
                    array_values(array_diff($categoryInfo['videos'], [$trailerVideoId]))
                );

                // Buat project detail dengan poster lokal
                $projectDetail = ProjectDetail::create([
                    'project_id' => $project->id,
                    'members' => json_encode($members),
                    'description' => $description,
                    'video_trailer_url' => 'https://www.youtube.com/watch?v=' . $trailerVideoId,
                    'presentation_video_url' => 'https://www.youtube.com/watch?v=' . $presentationVideoId,
                    'poster_path' => $localPoster,
                ]);

                // Buat galeri dengan gambar lokal (3-5 gambar)
                foreach (range(1, $faker->numberBetween(3, 5)) as $galleryItem) {
                    ProjectGallery::create([
                        'project_detail_id' => $projectDetail->id,
                        'image_path' => $localGallery,
                    ]);
                }
            }
        }
    }

    protected function generateIndonesianDescription($categoryName, $faker)
    {
        $templates = [
            'Aplikasi Web' => [
                "Aplikasi web ini dikembangkan sebagai bagian dari proyek mata kuliah Pemrograman Web Lanjut. ",
                "Sistem ini dibangun menggunakan framework {tech} dengan tujuan menyediakan solusi untuk {purpose}. ",
                "Fitur utama yang kami implementasikan meliputi: {features}. ",
                "Proyek ini dikerjakan selama {duration} dengan menerapkan metodologi {methodology}. ",
                "Hasil pengujian menunjukkan bahwa sistem telah memenuhi {requirements}. "
            ],
            'Aplikasi Mobile' => [
                "Aplikasi mobile ini dirancang untuk platform {platform} dengan fokus pada penyelesaian masalah {problem}. ",
                "Kami menggunakan {tech} sebagai teknologi utama dalam pengembangan aplikasi ini. ",
                "Proses pengembangan dilakukan secara {methodology} dengan tahapan yang jelas. ",
                "Aplikasi ini telah diuji pada berbagai perangkat mobile dengan hasil yang memuaskan. ",
                "Kedepannya, aplikasi ini dapat dikembangkan lebih lanjut dengan menambahkan {improvements}. "
            ],
            // Template untuk kategori lainnya...
            'default' => [
                "Proyek ini merupakan hasil karya kami selama satu semester penuh. ",
                "Kami mengimplementasikan berbagai konsep {concepts} yang telah dipelajari di perkuliahan. ",
                "Proyek dikembangkan menggunakan {tech} sebagai teknologi utama. ",
                "Selama pengembangan, kami menghadapi beberapa tantangan seperti {challenges}. ",
                "Solusi yang kami terapkan untuk mengatasi masalah tersebut adalah {solutions}. ",
                "Proyek ini telah melalui tahap pengujian yang mencakup {testing}. ",
                "Hasil evaluasi menunjukkan bahwa proyek ini telah memenuhi {requirements}. ",
                "Kami berharap proyek ini dapat bermanfaat untuk {benefits}. "
            ]
        ];

        $placeholders = [
            'tech' => ['Laravel', 'React Native', 'Flutter', 'Node.js', 'Django'],
            'purpose' => ['manajemen data akademik', 'sistem informasi perusahaan', 'e-commerce', 'platform pembelajaran online'],
            'features' => ['autentikasi pengguna', 'manajemen konten', 'pencarian canggih', 'analitik data'],
            'duration' => ['3 bulan', '6 bulan', 'satu semester penuh', 'dua bulan intensif'],
            'methodology' => ['Agile', 'Scrum', 'Waterfall', 'Prototyping'],
            'requirements' => ['90% kebutuhan pengguna', 'spesifikasi teknis', 'standar kualitas'],
            'platform' => ['Android', 'iOS', 'Cross-platform'],
            'problem' => ['manajemen waktu', 'produktivitas kerja', 'pembelajaran jarak jauh'],
            'concepts' => ['pemrograman berorientasi objek', 'basis data', 'arsitektur perangkat lunak'],
            'challenges' => ['keterbatasan waktu', 'kompatibilitas perangkat', 'optimasi performa'],
            'solutions' => ['penggunaan library tambahan', 'optimasi kode', 'pengujian intensif'],
            'testing' => ['unit testing', 'integration testing', 'user acceptance testing'],
            'benefits' => ['masyarakat umum', 'institusi pendidikan', 'perusahaan lokal'],
            'improvements' => ['fitur notifikasi', 'integrasi pembayaran', 'analitik pengguna']
        ];

        // Pilih template berdasarkan kategori atau gunakan default
        $template = $templates[$categoryName] ?? $templates['default'];

        // Bangun deskripsi dengan mengganti placeholder
        $description = '';
        foreach ($template as $sentence) {
            $filledSentence = preg_replace_callback(
                '/\{(\w+)\}/',
                function ($matches) use ($placeholders, $faker) {
                    return $faker->randomElement($placeholders[$matches[1]]);
                },
                $sentence
            );
            $description .= $filledSentence;
        }

        // Tambahkan 5-8 paragraf acak dalam Bahasa Indonesia
        $description .= "\n\n" . $faker->paragraphs($faker->numberBetween(5, 8), true);

        return $description;
    }
}
