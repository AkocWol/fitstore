<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // --- SUPPLEMENTS (15) ---
            ['name'=>'Whey Protein Isolate 1kg','category'=>'Supplements','price'=>29.99,'description'=>'High-quality whey isolate for lean muscle support.'],
            ['name'=>'Plant Protein 1kg','category'=>'Supplements','price'=>26.90,'description'=>'Vegan protein blend for daily recovery.'],
            ['name'=>'BCAA 2:1:1 300g','category'=>'Supplements','price'=>17.50,'description'=>'Branched-chain amino acids for intra-workout support.'],
            ['name'=>'Creatine Monohydrate 300g','category'=>'Supplements','price'=>14.95,'description'=>'Pure Creapure® creatine for strength and power.'],
            ['name'=>'Pre-Workout Clean Energy 300g','category'=>'Supplements','price'=>21.90,'description'=>'Caffeine + beta-alanine for focus and endurance.'],
            ['name'=>'Multivitamin Daily (90 tabs)','category'=>'Supplements','price'=>12.99,'description'=>'Essential vitamins and minerals for daily health.'],
            ['name'=>'Vitamin D3 + K2 (60 caps)','category'=>'Supplements','price'=>11.50,'description'=>'Bone and immune support combo.'],
            ['name'=>'Magnesium Glycinate (120 caps)','category'=>'Supplements','price'=>16.40,'description'=>'Highly bioavailable magnesium for relaxation.'],
            ['name'=>'Zinc 15mg (120 tabs)','category'=>'Supplements','price'=>8.90,'description'=>'Zinc for immunity and recovery.'],
            ['name'=>'Probiotic 30bn (60 caps)','category'=>'Supplements','price'=>19.99,'description'=>'Gut health with multi-strain probiotics.'],
            ['name'=>'Collagen Peptides 400g','category'=>'Supplements','price'=>22.50,'description'=>'Type I & III collagen for skin and joints.'],
            ['name'=>'Omega-3 Fish Oil (120 softgels)','category'=>'Supplements','price'=>13.99,'description'=>'EPA/DHA to support heart and brain.'],
            ['name'=>'Electrolyte Tablets (90)','category'=>'Supplements','price'=>9.99,'description'=>'Hydration support for training days.'],
            ['name'=>'Iron Bisglycinate (60 caps)','category'=>'Supplements','price'=>10.50,'description'=>'Gentle iron for energy and oxygen transport.'],
            ['name'=>'Ashwagandha KSM-66 (60 caps)','category'=>'Supplements','price'=>15.95,'description'=>'Adaptogen for stress and performance.'],

            // --- HYDRATION (8) ---
            ['name'=>'Isotonic Drink Mix (20 sachets)','category'=>'Hydration','price'=>12.49,'description'=>'Fast-absorbing carbs & electrolytes.'],
            ['name'=>'Hydration Tablets Citrus (20)','category'=>'Hydration','price'=>7.90,'description'=>'Effervescent hydration boost on the go.'],
            ['name'=>'Stainless Steel Water Bottle 750ml','category'=>'Hydration','price'=>15.99,'description'=>'Insulated bottle for hot & cold drinks.'],
            ['name'=>'Electrolyte Powder Berry 400g','category'=>'Hydration','price'=>13.50,'description'=>'Sugar-free electrolyte replenishment.'],
            ['name'=>'Coconut Water Pack (6×330ml)','category'=>'Hydration','price'=>9.99,'description'=>'Natural hydration, no added sugar.'],
            ['name'=>'Reusable Straw Set (4 + brush)','category'=>'Hydration','price'=>5.99,'description'=>'Eco-friendly stainless steel straws.'],
            ['name'=>'Infuser Bottle 1L','category'=>'Hydration','price'=>12.99,'description'=>'Fruit infuser bottle for flavored water.'],
            ['name'=>'Energy Gel Pack (12)','category'=>'Hydration','price'=>18.90,'description'=>'Quick carbs for endurance sessions.'],

            // --- RECOVERY (9) ---
            ['name'=>'Foam Roller 33cm','category'=>'Recovery','price'=>16.99,'description'=>'Relieve tight muscles and improve mobility.'],
            ['name'=>'Massage Ball Set (2pcs)','category'=>'Recovery','price'=>9.50,'description'=>'Trigger point release kit.'],
            ['name'=>'Resistance Bands Set (5)','category'=>'Recovery','price'=>14.99,'description'=>'Strength & mobility mini bands.'],
            ['name'=>'Knee Sleeves (pair)','category'=>'Recovery','price'=>24.90,'description'=>'Compression and joint support.'],
            ['name'=>'Lifting Straps (pair)','category'=>'Recovery','price'=>11.99,'description'=>'Secure grip for heavy lifts.'],
            ['name'=>'Sleep Gummies (60)','category'=>'Recovery','price'=>13.50,'description'=>'Melatonin + botanicals for better sleep.'],
            ['name'=>'Magnesium Oil Spray 200ml','category'=>'Recovery','price'=>10.99,'description'=>'Topical magnesium for relaxation.'],
            ['name'=>'Arnica Recovery Cream 100ml','category'=>'Recovery','price'=>8.99,'description'=>'Soothe sore areas post-workout.'],
            ['name'=>'Cold/Hot Pack Reusable','category'=>'Recovery','price'=>6.99,'description'=>'Flexible gel pack for hot or cold therapy.'],

            // --- SNACKS (8) ---
            ['name'=>'Protein Bar Chocolate (12-pack)','category'=>'Snacks','price'=>18.99,'description'=>'20g protein per bar, low sugar.'],
            ['name'=>'Protein Cookies (6-pack)','category'=>'Snacks','price'=>7.99,'description'=>'Soft-baked cookies with protein.'],
            ['name'=>'Almond Butter 350g','category'=>'Snacks','price'=>5.99,'description'=>'Roasted almonds, smooth spread.'],
            ['name'=>'Rice Cakes 200g','category'=>'Snacks','price'=>1.99,'description'=>'Light crunch, perfect with spreads.'],
            ['name'=>'Trail Mix 500g','category'=>'Snacks','price'=>6.50,'description'=>'Nuts & dried fruit energy blend.'],
            ['name'=>'Instant Oatmeal 1kg','category'=>'Snacks','price'=>3.99,'description'=>'Wholegrain quick oats.'],
            ['name'=>'Peanut Butter 1kg','category'=>'Snacks','price'=>6.99,'description'=>'100% peanuts, no palm oil.'],
            ['name'=>'Protein Chips (6-pack)','category'=>'Snacks','price'=>9.49,'description'=>'Crispy high-protein snack.'],

            // --- ACCESSORIES (10) ---
            ['name'=>'Yoga Mat 6mm','category'=>'Accessories','price'=>19.99,'description'=>'Non-slip mat for home & studio.'],
            ['name'=>'Speed Jump Rope','category'=>'Accessories','price'=>9.99,'description'=>'Lightweight rope for cardio.'],
            ['name'=>'Microfiber Gym Towel','category'=>'Accessories','price'=>6.50,'description'=>'Quick-dry, soft feel.'],
            ['name'=>'Shaker Bottle 700ml','category'=>'Accessories','price'=>7.99,'description'=>'Leakproof shaker with mixer ball.'],
            ['name'=>'Meal Prep Containers (set of 5)','category'=>'Accessories','price'=>12.99,'description'=>'BPA-free, microwave safe.'],
            ['name'=>'Smart Scale Bluetooth','category'=>'Accessories','price'=>24.99,'description'=>'Body metrics sync to your phone.'],
            ['name'=>'Wrist Wraps (pair)','category'=>'Accessories','price'=>8.99,'description'=>'Stability for pressing movements.'],
            ['name'=>'Compression Socks (pair)','category'=>'Accessories','price'=>11.50,'description'=>'Support for long days & runs.'],
            ['name'=>'Kinesiology Sports Tape','category'=>'Accessories','price'=>7.99,'description'=>'Supportive tape for activity.'],
            ['name'=>'Phone Armband','category'=>'Accessories','price'=>8.50,'description'=>'Secure fit for workouts.'],
        ];

        foreach ($items as $i => $it) {
            $slug = Str::slug($it['name']);
            if (Product::where('slug', $slug)->exists()) {
                $slug .= '-'.($i+1); // fallback bij eventuele dubbele slug
            }

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'        => $it['name'],
                    'category'    => $it['category'],
                    'description' => $it['description'],
                    'price'       => $it['price'],
                ]
            );
        }
    }
}
