<?php

namespace Database\Seeders;

use App\Models\Residency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residencies = [
            [
                'title_en' => 'Exceptional Competence Residency',
                'title_ar' => 'إقامة الكفاءة الاستثنائية',

                'description_en' => 'This residency targets scientific, administrative, and research talents with exceptional capabilities and expertise that contribute to strengthening local competencies and exchanging knowledge. It allows beneficiaries and their families to reside in Saudi Arabia while enjoying a wide range of privileges and long-term stability.',

                'description_ar' => 'يستهدف هذا المنتج الكفاءات العلمية والإدارية والبحثية ممن لديهم قدرات وخبرات متميزة تسهم في تعزيز القدرات المحلية وتبادل الخبرات. يتيح للمستفيدين وأسرهم الإقامة في المملكة العربية السعودية والاستفادة من مجموعة واسعة من المزايا والاستقرار طويل المدى.',

                'slug_en' => 'exceptional-competence-residency',
                'slug_ar' => 'اقامة-الكفاءة-الاستثنائية',

                'published' => true,

                'meta_title_en' => 'Exceptional Competence Residency in Saudi Arabia',
                'meta_title_ar' => 'إقامة الكفاءة الاستثنائية في السعودية',

                'meta_description_en' => 'Premium residency for scientific, healthcare, research, and executive talents in Saudi Arabia.',
                'meta_description_ar' => 'إقامة مميزة للكفاءات العلمية والصحية والبحثية والتنفيذية في المملكة العربية السعودية.',

                'country_id' => 2,
            ],

            [
                'title_en' => 'Talent Residency',
                'title_ar' => 'إقامة الموهبة',

                'description_en' => 'A premium residency designed for talented individuals in cultural, sports, and creative fields who have achieved recognized accomplishments and can contribute to the development of Saudi Arabia.',

                'description_ar' => 'إقامة مميزة مخصصة للمواهب في المجالات الثقافية والرياضية والإبداعية ممن حققوا إنجازات معترف بها ويمكنهم الإسهام في تنمية المملكة العربية السعودية.',

                'slug_en' => 'talent-residency',
                'slug_ar' => 'اقامة-الموهبة',

                'published' => true,

                'meta_title_en' => 'Talent Residency in Saudi Arabia',
                'meta_title_ar' => 'إقامة الموهبة في السعودية',

                'meta_description_en' => 'Premium residency for talented individuals in creative, cultural, and sports sectors.',
                'meta_description_ar' => 'إقامة مميزة للمواهب في القطاعات الإبداعية والثقافية والرياضية.',

                'country_id' => 2,
            ],

            [
                'title_en' => 'Business Investor Residency',
                'title_ar' => 'إقامة مستثمر أعمال',

                'description_en' => 'A residency program for investors seeking to establish, expand, and manage businesses in Saudi Arabia while benefiting from investment opportunities and business-friendly regulations.',

                'description_ar' => 'برنامج إقامة مخصص للمستثمرين الراغبين في تأسيس الأعمال وتوسعتها وإدارتها داخل المملكة العربية السعودية والاستفادة من الفرص الاستثمارية والبيئة الداعمة للأعمال.',

                'slug_en' => 'business-investor-residency',
                'slug_ar' => 'اقامة-مستثمر-اعمال',

                'published' => true,

                'meta_title_en' => 'Business Investor Residency',
                'meta_title_ar' => 'إقامة مستثمر أعمال',

                'meta_description_en' => 'Saudi premium residency for business investors and entrepreneurs.',
                'meta_description_ar' => 'الإقامة المميزة للمستثمرين ورواد الأعمال في المملكة العربية السعودية.',

                'country_id' => 2,
            ],

            [
                'title_en' => 'Entrepreneur Residency',
                'title_ar' => 'إقامة رائد أعمال',

                'description_en' => 'A residency product for entrepreneurs who own innovative startups or high-growth projects and wish to expand their ventures in the Saudi market.',

                'description_ar' => 'منتج إقامة مخصص لرواد الأعمال الذين يمتلكون شركات ناشئة مبتكرة أو مشاريع ذات نمو مرتفع ويرغبون في التوسع داخل السوق السعودي.',

                'slug_en' => 'entrepreneur-residency',
                'slug_ar' => 'اقامة-رائد-اعمال',

                'published' => true,

                'meta_title_en' => 'Entrepreneur Residency in Saudi Arabia',
                'meta_title_ar' => 'إقامة رائد أعمال في السعودية',

                'meta_description_en' => 'Premium residency for startup founders and entrepreneurs.',
                'meta_description_ar' => 'إقامة مميزة لمؤسسي الشركات الناشئة ورواد الأعمال.',

                'country_id' => 2,
            ],

            [
                'title_en' => 'Property Owner Residency',
                'title_ar' => 'إقامة مالك عقار',

                'description_en' => 'A residency pathway for foreign property owners who meet the eligibility requirements and wish to reside in Saudi Arabia through real estate ownership.',

                'description_ar' => 'مسار إقامة مخصص لمالكي العقارات من الأجانب ممن يستوفون شروط الأهلية ويرغبون في الإقامة داخل المملكة من خلال تملك العقارات.',

                'slug_en' => 'property-owner-residency',
                'slug_ar' => 'اقامة-مالك-عقار',

                'published' => true,

                'meta_title_en' => 'Property Owner Residency',
                'meta_title_ar' => 'إقامة مالك عقار',

                'meta_description_en' => 'Saudi residency for qualified foreign property owners.',
                'meta_description_ar' => 'إقامة في السعودية لمالكي العقارات المؤهلين من الأجانب.',

                'country_id' => 2,
            ],

            [
                'title_en' => 'Family Member Residency',
                'title_ar' => 'إقامة فرد من الأسرة',

                'description_en' => 'A residency option that allows eligible family members of premium residency holders to benefit from living and settling in Saudi Arabia.',

                'description_ar' => 'خيار إقامة يتيح لأفراد أسرة حاملي الإقامة المميزة المؤهلين الاستفادة من العيش والاستقرار داخل المملكة العربية السعودية.',

                'slug_en' => 'family-member-residency',
                'slug_ar' => 'اقامة-فرد-من-الاسرة',

                'published' => false,

                'meta_title_en' => 'Family Member Residency',
                'meta_title_ar' => 'إقامة فرد من الأسرة',

                'meta_description_en' => 'Residency option for eligible family members of premium residency holders.',
                'meta_description_ar' => 'خيار إقامة لأفراد الأسرة المؤهلين من حاملي الإقامة المميزة.',

                'country_id' => 2,
            ],
        ];
        Residency::insert($residencies);
    }
}
