<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectDetail;
use App\Models\ProjectGallery;
use App\Models\StudyProgram;
use App\Models\User;
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
        $totalProjects = 100; // Reduced for better performance
        $projectsPerCategory = (int) ceil($totalProjects / $projectCategories->count());

        $dosens = User::where('role', 'dosen_pembimbing')->get();
        if ($dosens->isEmpty()) {
            return;
        }

        $faker = \Faker\Factory::create('id_ID'); // Faker Bahasa Indonesia

        // Path gambar lokal
        $localThumbnail = 'assets/images/projects/dummy_datas/thumbnails/sample.png';
        $localPoster = 'assets/images/projects/dummy_datas/posters/sample.png';
        $localGallery = 'assets/images/projects/dummy_datas/galleries/sample.png';

        // Mapping kategori ke konten Bahasa Indonesia dan ID gambar Unsplash
        $categoryData = [
            'Aplikasi Web' => [
                'keywords' => ['E-Commerce', 'Sistem Informasi', 'Blog', 'Portal Berita', 'Dashboard'],
                'tech' => ['Laravel', 'React', 'Vue.js', 'Node.js', 'Django'],
                'videos' => ['k1BneeJTDcU', 'PkZNo7MFNFg', 'DLX62G4lc44'],
                'imageId' => '1498050108023-c5249f4df085'
            ],
            'Aplikasi Mobile' => [
                'keywords' => ['Tracking', 'Social Media', 'Task Manager', 'Health App', 'Education'],
                'tech' => ['Flutter', 'React Native', 'Kotlin', 'Swift', 'Ionic'],
                'videos' => ['-p2Nn6A2Vio', 'PkZNo7MFNFg', 'DLX62G4lc44'],
                'imageId' => '1512941937669-90bcdf591782'
            ],
            'Keamanan Siber' => [
                'keywords' => ['Penetration Testing', 'Network Security', 'Cryptography', 'Audit', 'Forensic'],
                'tech' => ['Python', 'Kali Linux', 'Wireshark', 'Metasploit', 'Nmap'],
                'videos' => ['_0_S3y-QeG0', 'PkZNo7MFNFg', 'DLX62G4lc44'],
                'imageId' => '1550751827-4bd374c3f58b'
            ],
            '3D Aset' => [
                'keywords' => ['Character', 'Environment', 'Weapon', 'Vehicle', 'Architecture'],
                'tech' => ['Blender', 'ZBrush', 'Maya', 'Substance Painter', 'Unity'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1616469829581-73993eb86b02'
            ],
            'Animasi 2D 3D' => [
                'keywords' => ['Short Film', 'Commercial', 'Education', 'Tutorial', 'Music Video'],
                'tech' => ['Toon Boom', 'After Effects', 'Blender', 'Cinema 4D'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1550745165-9bc0b252726f'
            ],
            'Motion Graphic' => [
                'keywords' => ['Title Sequence', 'Infographic', 'Explainer', 'Branding', 'Social Media'],
                'tech' => ['After Effects', 'Cinema 4D', 'Illustrator', 'Premiere Pro'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1558655146-d09347e92766'
            ],
            'Augmented Reality' => [
                'keywords' => ['Education', 'Tourism', 'Marketing', 'Instructional', 'Game'],
                'tech' => ['Unity', 'Vuforia', 'ARCore', 'ARKit', 'WebAR'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1478416272538-5f7e51dc5400'
            ],
            'Virtual Reality' => [
                'keywords' => ['Simulation', 'Training', 'Therapy', 'Tourism', 'Education'],
                'tech' => ['Unity', 'Unreal Engine', 'Oculus SDK', 'OpenXR'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1592477342004-bd7ba780f2b3'
            ],
            'Game' => [
                'keywords' => ['Platformer', 'RPG', 'Puzzle', 'Strategy', 'Shooter'],
                'tech' => ['Unity', 'Unreal Engine', 'Godot', 'Construct 3', 'C#'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1493711662062-fa541adb3fc8'
            ],
            'ERP & Pengembangan Aplikasi' => [
                'keywords' => ['Enterprise Resource Planning', 'Business Intelligence', 'HRM', 'Inventory'],
                'tech' => ['Odoo', 'SAP', 'Python', 'PostgreSQL', 'Java'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1460925895917-afdab827c52f'
            ],
            'Data Mining' => [
                'keywords' => ['Sentiment Analysis', 'Prediction', 'Classification', 'Clustering', 'Scraping'],
                'tech' => ['Python', 'R', 'Scikit-Learn', 'TensorFlow', 'Pandas'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1551288049-bbda48336202'
            ],
            'Desain Grafis' => [
                'keywords' => ['Visual Identity', 'Packaging', 'Poster', 'Layout', 'Typeface'],
                'tech' => ['Photoshop', 'Illustrator', 'InDesign', 'Figma', 'Canva'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1626785774573-4b799315f30d'
            ],
            'Ilustrasi' => [
                'keywords' => ['Digital Painting', 'Vector Art', 'Children Book', 'Comic', 'Storyboard'],
                'tech' => ['Clip Studio Paint', 'Procreate', 'Photoshop', 'Illustrator'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1618005182384-a83a8bd57fbe'
            ],
            'Video Live-Action' => [
                'keywords' => ['Documentary', 'Short Movie', 'Commercial', 'Music Video', 'Profile'],
                'tech' => ['Premiere Pro', 'DaVinci Resolve', 'Final Cut Pro', 'After Effects'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1492724441997-5dc865305da7'
            ],
            'Concept Art' => [
                'keywords' => ['Environment Design', 'Character Design', 'Prop Design', 'Visual Storytelling'],
                'tech' => ['Photoshop', 'Corel Painter', 'Krita', 'Wacom'],
                'videos' => ['PkZNo7MFNFg', 'DLX62G4lc44', 'k1BneeJTDcU'],
                'imageId' => '1605301091855-d60dec69e8bb'
            ],
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

                // Random Status and Assignment
                $status = $faker->randomElement([
                    Project::STATUS_PENDING,
                    Project::STATUS_VERIFIED_DOSEN,
                    Project::STATUS_APPROVED,
                    Project::STATUS_REJECTED_DOSEN,
                    Project::STATUS_REJECTED_KAPRODI
                ]);

                $rejectionReason = null;
                if ($status === Project::STATUS_REJECTED_DOSEN || $status === Project::STATUS_REJECTED_KAPRODI) {
                    $rejectionReason = $faker->sentence(10);
                }

                // Generate valid image URL
                $imageId = $categoryInfo['imageId'];
                $imageUrl = "https://images.unsplash.com/photo-{$imageId}?auto=format&fit=crop&w=800&q=80";

                // Buat project dengan gambar Unsplash
                $project = Project::create([
                    'project_category_id' => $category->id,
                    'dosen_pembimbing_id' => $dosens->random()->id,
                    'project_title' => $projectTitle,
                    'school_year' => "$startYear/$endYear",
                    'semester' => $faker->randomElement(['Ganjil', 'Genap']),
                    'thumbnail' => $imageUrl,
                    'status' => $status,
                    'rejection_reason' => $rejectionReason,
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

                // Buat project detail dengan poster (menggunakan Unsplash dengan seed berbeda)
                $posterUrl = "https://images.unsplash.com/photo-{$imageId}?auto=format&fit=crop&w=1200&q=80&sig=" . $faker->numberBetween(1, 1000);
                
                $projectDetail = ProjectDetail::create([
                    'project_id' => $project->id,
                    'members' => json_encode($members),
                    'description' => $description,
                    'video_trailer_url' => 'https://www.youtube.com/watch?v=' . $trailerVideoId,
                    'presentation_video_url' => 'https://www.youtube.com/watch?v=' . $presentationVideoId,
                    'poster_path' => $posterUrl,
                ]);

                // Buat galeri dengan gambar Unsplash (3-5 gambar)
                foreach (range(1, $faker->numberBetween(3, 5)) as $galleryItem) {
                    $galleryUrl = "https://images.unsplash.com/photo-{$imageId}?auto=format&fit=crop&w=600&q=80&sig=" . $faker->numberBetween(1001, 2000) . $galleryItem;
                    ProjectGallery::create([
                        'project_detail_id' => $projectDetail->id,
                        'image_path' => $galleryUrl,
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
