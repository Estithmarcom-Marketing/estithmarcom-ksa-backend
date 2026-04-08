<?php

namespace Database\Seeders;

use App\Models\FreeZone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FreeZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $freeZones = [
            [
                'title_ar' => 'المناطق الحرة المملكة الأردنية الهاشمية',
                'title_en' => 'Free Zones Jordan',
                'slug_ar' => 'المناطق-الحرة-المملكة-الأردنية-الهاشمية',
                'slug_en' => 'free-zones-jordan',
                'content_ar' => 'الإعفاءات الضريبية: تقدم المناطق الحرة إعفاءات من الضرائب على الأرباح، مما يساعد الشركات على زيادة ربحيتها.
تسهيلات استثمارية: توفر تسهيلات في إجراءات تسجيل الشركات وتأسيسها، مما يسهل دخول المستثمرين الجدد.
الملكية الكاملة: يسمح للمستثمرين بامتلاك 100% من الشركات دون الحاجة إلى شريك محلي، مما يعزز من جاذبية الاستثمار.
البنية التحتية المتطورة: تتوفر في المناطق الحرة بنية تحتية حديثة تشمل المرافق اللوجستية، الموانئ، والمطارات، مما يسهل حركة السلع.
الوصول إلى الأسواق الإقليمية: توفر المناطق الحرة فرص وصول سهلة إلى الأسواق الإقليمية والدولية، مما يعزز من فرص التصدير.
تنوع الأنشطة الاقتصادية: تدعم المناطق الحرة مجموعة متنوعة من الأنشطة، بما في ذلك الصناعة، التجارة، والخدمات.
عدم القيود على تحويل الأموال: يمكن للمستثمرين تحويل الأرباح إلى الخارج دون قيود، مما يعزز من جاذبية الاستثمار.
العمالة: توفر المناطق الحرة مرونة في استقدام العمالة، مما يسهل على الشركات توظيف الكفاءات المطلوبة.
الاستقرار السياسي والاقتصادي: يعتبر الاستقرار السياسي والاقتصادي في الأردن عاملاً إيجابياً لجذب الاستثمارات.',
                'content_en' => 'Tax exemptions: Free zones provide exemptions from taxes on profits, helping companies increase profitability.
Investment facilitation: Simplified procedures for company registration and formation make it easier for new investors to enter.
Full ownership: Investors can own 100% of companies without needing a local partner, enhancing investment appeal.
Advanced infrastructure: Free zones have modern infrastructure including logistics facilities, ports, and airports, facilitating goods movement.
Regional market access: Free zones provide easy access to regional and international markets, boosting export opportunities.
Diverse economic activities: Free zones support various activities, including industry, trade, and services.
Free capital transfer: Investors can transfer profits abroad without restrictions, enhancing investment attractiveness.
Workforce: Free zones offer flexibility in hiring staff, making it easier for companies to employ needed talents.
Political and economic stability: Jordan’s political and economic stability is a positive factor in attracting investments.',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_ar' => 'المناطق الحرة جمهورية مصر العربية',
                'title_en' => 'Free Zones Egypt',
                'slug_ar' => 'المناطق-الحرة-جمهورية-مصر-العربية',
                'slug_en' => 'free-zones-egypt',
                'content_ar' => 'الإعفاءات الضريبية: تقدم المناطق الحرة إعفاءات ضريبية على الأرباح لمدة تصل إلى 10 سنوات، مما يزيد من جاذبية الاستثمار.
الملكية الكاملة: يُسمح للمستثمرين الأجانب بامتلاك 100% من الشركات دون الحاجة إلى شريك محلي، مما يعزز من فرص الاستثمار.
تسهيلات إجرائية: توفر المناطق الحرة إجراءات سريعة ومبسطة لتأسيس الشركات، مما يسهل عملية الدخول إلى السوق.
البنية التحتية المتطورة: تتمتع مصر ببنية تحتية حديثة تشمل الموانئ والمطارات، مما يسهل حركة البضائع والسلع.
الوصول إلى الأسواق الإقليمية والدولية: توفر المواقع الاستراتيجية للمناطق الحرة فرص وصول سهلة إلى الأسواق في منطقة الشرق الأوسط وأفريقيا.
دعم الحكومة: تسعى الحكومة المصرية إلى تعزيز الاستثمارات في المناطق الحرة من خلال تقديم حوافز ودعم للمستثمرين.
تنوع الأنشطة الاقتصادية: تدعم المناطق الحرة مجموعة متنوعة من الأنشطة، مثل الصناعة، التجارة، والخدمات اللوجستية.
عدم القيود على تحويل الأموال: يمكن للمستثمرين تحويل الأرباح إلى الخارج بسهولة، مما يعزز من جاذبية البيئة الاستثمارية.
توفير العمالة: تسهل المناطق الحرة استقدام العمالة، مما يتيح للشركات توظيف الكفاءات المطلوبة.',
                'content_en' => 'Tax exemptions: Free zones offer tax exemptions on profits for up to 10 years, increasing investment attractiveness.
Full ownership: Foreign investors can own 100% of companies without a local partner, enhancing investment opportunities.
Procedural facilitation: Free zones provide fast and simplified company formation procedures, easing market entry.
Advanced infrastructure: Egypt has modern infrastructure including ports and airports, facilitating the movement of goods.
Regional and international market access: Strategic locations of free zones provide easy access to Middle Eastern and African markets.
Government support: The Egyptian government promotes investments in free zones through incentives and support.
Diverse economic activities: Free zones support a variety of sectors, including industry, trade, and logistics services.
Free capital transfer: Investors can easily transfer profits abroad, enhancing the investment environment.
Workforce availability: Free zones facilitate hiring staff, enabling companies to employ the necessary talents.',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_ar' => 'المناطق الحرة سلطنة عمان',
                'title_en' => 'Free Zones Oman',
                'slug_ar' => 'المناطق-الحرة-سلطنة-عمان',
                'slug_en' => 'free-zones-oman',
                'content_ar' => 'الإعفاءات الضريبية: تقدم المناطق الحرة إعفاءات من الضرائب على الأرباح لفترات معينة، مما يساعد في زيادة ربحية الشركات.
الملكية الكاملة: يسمح للمستثمرين الأجانب بامتلاك 100% من الشركات في المناطق الحرة ، مما يعزز من جاذبية الاستثمار.
تسهيلات في الإجراءات: توفر المناطق الحرة إجراءات سريعة ومبسطة لتأسيس الشركات، مما يسهل دخول المستثمرين في السوق.
البنية التحتية المتطورة: تتمتع سلطنة عمان ببنية تحتية حديثة تشمل الموانئ والمطارات والطرق، مما يسهل حركة التجارة.
الوصول إلى الأسواق الإقليمية والدولية: توفر المناطق الحرة فرص وصول سهلة إلى الأسواق في منطقة الخليج والأسواق العالمية.
تنوع الأنشطة الاقتصادية: تدعم المناطق الحرة مجموعة متنوعة من الأنشطة مثل التصنيع، التجارة، والخدمات اللوجستية.
عدم القيود على تحويل الأموال: يمكن للمستثمرين تحويل الأرباح إلى الخارج بدون قيود، مما يعزز من جاذبية الاستثمار.
توفير العمالة: تسهل المناطق الحرة استقدام العمالة، مما يتيح للشركات توظيف الكفاءات المطلوبة بشكل مرن.
الاستقرار السياسي والاقتصادي: تعتبر سلطنة عمان وجهة مستقرة سياسيًا واقتصاديًا، مما يعزز من ثقة المستثمرين.',
                'content_en' => 'Tax exemptions: Free zones offer tax exemptions on profits for certain periods, enhancing company profitability.
Full ownership: Foreign investors can fully own companies in free zones, improving investment appeal.
Procedural facilitation: Free zones provide fast and simplified company formation procedures, easing market entry.
Advanced infrastructure: Oman has modern infrastructure including ports, airports, and roads, facilitating trade.
Regional and international market access: Free zones provide easy access to Gulf and global markets.
Diverse economic activities: Free zones support various activities like manufacturing, trade, and logistics services.
Free capital transfer: Investors can transfer profits abroad without restrictions, boosting investment attractiveness.
Workforce availability: Free zones facilitate hiring staff, allowing flexible employment.
Political and economic stability: Oman is a politically and economically stable destination, increasing investor confidence.',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_ar' => 'المناطق الحرة الإمارات العربية المتحدة',
                'title_en' => 'Free Zones UAE',
                'slug_ar' => 'المناطق-الحرة-الإمارات-العربية-المتحدة',
                'slug_en' => 'free-zones-uae',
                'content_ar' => 'الإعفاءات الضريبية: تقدم المناطق الحرة إعفاءات من ضريبة الشركات وضريبة الدخل لفترات طويلة، مما يعزز الربحية.
الملكية الكاملة: يسمح للمستثمرين بامتلاك 100% من شركاتهم دون الحاجة إلى شريك محلي، وهو ما يعد ميزة كبيرة.
سهولة تأسيس الأعمال: تتمتع المناطق الحرة بإجراءات مرنة وسريعة لتسجيل الشركات، مما يسهل عملية الدخول إلى السوق.
البنية التحتية المتطورة: توفر الإمارات بنية تحتية متقدمة تشمل المرافق اللوجستية، الموانئ، والمطارات، مما يسهل حركة البضائع.
التنوع الاقتصادي: تدعم المناطق الحرة مجموعة واسعة من الأنشطة الاقتصادية، مثل التجارة، التصنيع، والخدمات.
الوصول إلى الأسواق العالمية: تتيح المواقع الاستراتيجية للمناطق الحرة الوصول السريع إلى الأسواق الإقليمية والدولية.
عدم القيود على تحويل الأموال: يمكن للمستثمرين تحويل الأرباح إلى بلدانهم بدون قيود، مما يعزز من جاذبية الاستثمار.
العمالة المرنة: تسهل المناطق الحرة إجراءات استقدام العمالة، مما يتيح للشركات توظيف الكفاءات اللازمة.
الابتكار والتكنولوجيا: تشجع بعض المناطق الحرة على الابتكار وتستضيف شركات التكنولوجيا الناشئة، مما يعزز من بيئة الأعمال.',
                'content_en' => 'Tax exemptions: Free zones offer exemptions from corporate and income taxes for long periods, enhancing profitability.
Full ownership: Investors can fully own their companies without a local partner, which is a major advantage.
Easy business setup: Free zones have flexible and fast procedures for company registration, easing market entry.
Advanced infrastructure: UAE provides advanced infrastructure including logistics facilities, ports, and airports, facilitating goods movement.
Economic diversity: Free zones support a wide range of economic activities, such as trade, manufacturing, and services.
Global market access: Strategic locations allow rapid access to regional and international markets.
Free capital transfer: Investors can transfer profits abroad without restrictions, increasing attractiveness.
Flexible workforce: Free zones facilitate hiring staff, enabling companies to employ the necessary talents.
Innovation and technology: Some free zones encourage innovation and host tech startups, improving the business environment.',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_ar' => 'المناطق الحرة السعودية',
                'title_en' => 'Free Zones Saudi Arabia',
                'slug_ar' => 'المناطق-الحرة-السعودية',
                'slug_en' => 'free-zones-saudi-arabia',
                'content_ar' => 'الإعفاءات الضريبية: توفر المناطق الحرة إعفاءات ضريبية على الأرباح، مما يساعد الشركات على زيادة عائداتها.
سهولة الإجراءات: تتمتع المناطق الحرة بإجراءات سريعة ومبسطة لتأسيس الأعمال، مما يسهل دخول المستثمرين.
البنية التحتية المتطورة: توفر المناطق الحرة بنية تحتية متقدمة تشمل المواصلات، المرافق اللوجستية، والمخازن.
الوصول إلى الأسواق العالمية: تقع العديد من المناطق الحرة بالقرب من الموانئ والمطارات، مما يسهل الوصول إلى الأسواق الدولية.
تنوع الأنشطة الاقتصادية: تدعم المناطق الحرة مجموعة متنوعة من الأنشطة، مثل التصنيع، التجارة، والخدمات اللوجستية.
العمالة: غالبًا ما تكون هناك مرونة في استقدام العمالة، مما يتيح للشركات توظيف الكفاءات المطلوبة بسهولة.
التعاون مع الحكومة: تسعى الحكومة السعودية إلى تعزيز التنمية في هذه المناطق، مما يؤدي إلى دعم أفضل للمستثمرين.',
                'content_en' => 'Tax exemptions: Free zones provide tax exemptions on profits, helping companies increase returns.
Easy procedures: Free zones offer fast and simplified procedures for business formation, easing investor entry.
Advanced infrastructure: Free zones have advanced infrastructure including transportation, logistics, and warehouses.
Global market access: Many free zones are near ports and airports, facilitating access to international markets.
Diverse economic activities: Free zones support various activities, including manufacturing, trade, and logistics services.
Workforce: There is usually flexibility in hiring staff, enabling companies to employ the required talents easily.
Government support: The Saudi government seeks to promote development in these zones, providing better investor support.',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('free_zones')->insert($freeZones);
    }
}
