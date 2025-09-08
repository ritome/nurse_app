<?php

namespace Database\Seeders;

use App\Models\ProgramItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // 栄養ケア
            [
                'category' => '栄養ケア',
                'name' => '経管栄養の管理と観察',
                'description' => '経管栄養中の患者の観察とケア',
                'order' => 1,
            ],
            [
                'category' => '栄養ケア',
                'name' => '食事介助',
                'description' => '患者の状態に応じた適切な食事介助',
                'order' => 2,
            ],

            // 清潔ケア
            [
                'category' => '清潔ケア',
                'name' => '入浴介助',
                'description' => '患者の状態に応じた安全な入浴介助',
                'order' => 1,
            ],
            [
                'category' => '清潔ケア',
                'name' => '口腔ケア',
                'description' => '適切な口腔ケアの実施',
                'order' => 2,
            ],

            // 排泄ケア
            [
                'category' => '排泄ケア',
                'name' => '導尿の実施',
                'description' => '無菌操作による導尿の実施',
                'order' => 1,
            ],
            [
                'category' => '排泄ケア',
                'name' => 'ストーマケア',
                'description' => 'ストーマの観察とケア',
                'order' => 2,
            ],

            // ADL
            [
                'category' => 'ADL',
                'name' => '移乗介助',
                'description' => '安全な移乗介助の実施',
                'order' => 1,
            ],
            [
                'category' => 'ADL',
                'name' => '歩行介助',
                'description' => '患者の状態に応じた歩行介助',
                'order' => 2,
            ],

            // フィジカルアセスメント
            [
                'category' => 'フィジカルアセスメント',
                'name' => 'バイタルサイン測定',
                'description' => '正確なバイタルサイン測定と記録',
                'order' => 1,
            ],
            [
                'category' => 'フィジカルアセスメント',
                'name' => '呼吸音の聴取',
                'description' => '呼吸音の聴取と異常の判断',
                'order' => 2,
            ],
        ];

        foreach ($items as $item) {
            ProgramItem::create($item);
        }
    }
}
