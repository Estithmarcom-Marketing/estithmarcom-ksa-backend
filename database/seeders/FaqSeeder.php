<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $faqs = [
            [
                'question_ar' => 'ما الذي يميز حاضنة أعمال إستثماركم عن غيرها من الشركات؟',
                'question_en' => 'What distinguishes Istithmarkom Business Incubator from other companies?',
                'answer_ar' => 'تتميز حاضنة الأعمال إستثماركم بسرعة إنهاء جميع الإجراءات الحكومية، وبأقل تكلفة عن غيرها من الشركات الأخرى. كما يوجد أيضًا فريق عمل على أعلى مستوى من الكفاءة والخبرة، حيث إن حاضنة الأعمال إستثماركم تمتلك منفذين ومندوبين لخدمة عملاء للرد على جميع استفساراتكم، فهدفنا راحة العميل وتوفير الوقت والجهد له.',
                'answer_en' => 'Istithmarkom Business Incubator is distinguished by quickly completing all governmental procedures at lower cost compared to other companies. We also have a highly qualified and experienced team, including representatives dedicated to answering all client inquiries. Our goal is customer comfort while saving time and effort.',
                'published' => true,
                'faqable_id' => null,
                'faqable_type' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'question_ar' => 'كم المدة التي تستغرقها حاضنة أعمال إستثماركم لإنهاء الخدمة؟',
                'question_en' => 'How long does Istithmarkom Business Incubator take to complete the service?',
                'answer_ar' => 'تختلف مدة إنجاز الخدمة حسب نوع الطلب والإجراءات المطلوبة، ولكننا نحرص دائمًا على إنهائها في أسرع وقت ممكن وبأعلى جودة.',
                'answer_en' => 'The service completion time varies depending on the type of request and required procedures, but we always strive to finish it as quickly as possible with the highest quality.',
                'published' => true,
                'faqable_id' => null,
                'faqable_type' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'question_ar' => 'هل يلزم تواجد العميل بالمصالح الحكومية لإنهاء الخدمة؟',
                'question_en' => 'Is the client required to visit government offices to complete the service?',
                'answer_ar' => 'لا، نقوم بإنهاء معظم الإجراءات نيابةً عن العميل من خلال مندوبينا المعتمدين لتوفير الوقت والجهد.',
                'answer_en' => 'No, most procedures are completed on behalf of the client through our authorized representatives to save time and effort.',
                'published' => true,
                'faqable_id' => null,
                'faqable_type' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];
        DB::table('faqs')->insert($faqs);
    }
}
