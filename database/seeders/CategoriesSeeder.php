<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $parentCategories = [
            [
                'name' => 'Electronics',
                'description' => 'Explore the latest and greatest in electronic devices and technology.',
                'subcategories' => [
                    [
                        'name' => 'Mobile Phones',
                        'description' => 'Latest smartphones with cutting-edge features and designs.',
                        'children' => [
                            [
                                'name' => 'Smartphones',
                                'description' => 'Latest and most advanced smartphones.',
                            ],
                            [
                                'name' => 'Feature Phones',
                                'description' => 'Basic phones with essential features.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Laptops',
                        'description' => 'Portable computers for work, study, and entertainment.',
                        'children' => [
                            [
                                'name' => 'Gaming Laptops',
                                'description' => 'High-performance laptops for gaming enthusiasts.',
                            ],
                            [
                                'name' => 'Business Laptops',
                                'description' => 'Reliable laptops for business and productivity.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Televisions',
                        'description' => 'High-definition TVs with smart features and stunning displays.',
                        'children' => [
                            [
                                'name' => '4K TVs',
                                'description' => 'Ultra high-definition TVs with superior picture quality.',
                            ],
                            [
                                'name' => 'Smart TVs',
                                'description' => 'Televisions with built-in internet connectivity and apps.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Cameras',
                        'description' => 'Capture life\'s moments with professional and consumer cameras.',
                    ],
                    [
                        'name' => 'Wearable Technology',
                        'description' => 'Smartwatches, fitness trackers, and other wearable tech.',
                        'children' => [
                            [
                                'name' => 'Smartwatches',
                                'description' => 'Watches with advanced features and connectivity.',
                            ],
                            [
                                'name' => 'Fitness Trackers',
                                'description' => 'Devices to monitor and track physical activity.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Audio Equipment',
                        'description' => 'Headphones, speakers, and other audio devices for the best sound.',
                        'children' => [
                            [
                                'name' => 'Headphones',
                                'description' => 'Various types of headphones for different needs.',
                            ],
                            [
                                'name' => 'Speakers',
                                'description' => 'High-quality speakers for superior sound.',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Fashion',
                'description' => 'Stay stylish with the latest trends in men\'s and women\'s fashion.',
                'subcategories' => [
                    [
                        'name' => 'Men\'s Clothing',
                        'description' => 'A wide range of clothing options for men, from casual to formal.',
                        'children' => [
                            [
                                'name' => 'Casual Wear',
                                'description' => 'Comfortable and stylish casual clothing for men.',
                            ],
                            [
                                'name' => 'Formal Wear',
                                'description' => 'Elegant clothing options for formal occasions.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Women\'s Clothing',
                        'description' => 'Fashionable and trendy outfits for women of all ages.',
                        'children' => [
                            [
                                'name' => 'Dresses',
                                'description' => 'Beautiful dresses for all occasions.',
                            ],
                            [
                                'name' => 'Tops',
                                'description' => 'Stylish tops and blouses for women.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Footwear',
                        'description' => 'Shoes for every occasion, from sneakers to high heels.',
                        'children' => [
                            [
                                'name' => 'Sneakers',
                                'description' => 'Comfortable and versatile sneakers for everyday wear.',
                            ],
                            [
                                'name' => 'Formal Shoes',
                                'description' => 'Elegant shoes for formal occasions.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Accessories',
                        'description' => 'Complete your outfit with belts, hats, scarves, and more.',
                    ],
                    [
                        'name' => 'Jewelry',
                        'description' => 'Elegant and stylish jewelry pieces for any occasion.',
                        'children' => [
                            [
                                'name' => 'Necklaces',
                                'description' => 'Beautiful necklaces for every occasion.',
                            ],
                            [
                                'name' => 'Bracelets',
                                'description' => 'Stylish bracelets to accessorize your look.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Bags & Purses',
                        'description' => 'Fashionable bags and purses for every style and need.',
                    ],
                ],
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Enhance your living space with our home and garden products.',
                'subcategories' => [
                    [
                        'name' => 'Furniture',
                        'description' => 'Comfortable and stylish furniture for every room in your home.',
                        'children' => [
                            [
                                'name' => 'Living Room Furniture',
                                'description' => 'Furniture for your living room, including sofas and coffee tables.',
                            ],
                            [
                                'name' => 'Bedroom Furniture',
                                'description' => 'Furniture for the bedroom, including beds and dressers.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Home Decor',
                        'description' => 'Decorative items to personalize and beautify your home.',
                        'children' => [
                            [
                                'name' => 'Wall Art',
                                'description' => 'Artworks and decorations for your walls.',
                            ],
                            [
                                'name' => 'Rugs & Carpets',
                                'description' => 'Stylish rugs and carpets for your floors.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Garden Tools',
                        'description' => 'Everything you need to maintain a beautiful garden.',
                    ],
                    [
                        'name' => 'Kitchen Appliances',
                        'description' => 'Essential appliances to make your kitchen more efficient.',
                    ],
                    [
                        'name' => 'Bedding',
                        'description' => 'Cozy and comfortable bedding for a good night\'s sleep.',
                    ],
                    [
                        'name' => 'Lighting',
                        'description' => 'Illuminate your home with our wide selection of lighting options.',
                    ],
                ],
            ],
            [
                'name' => 'Health & Beauty',
                'description' => 'Look and feel your best with our health and beauty products.',
                'subcategories' => [
                    [
                        'name' => 'Skincare',
                        'description' => 'Products to keep your skin healthy and glowing.',
                    ],
                    [
                        'name' => 'Haircare',
                        'description' => 'Shampoos, conditioners, and styling products for all hair types.',
                    ],
                    [
                        'name' => 'Makeup',
                        'description' => 'Cosmetics to enhance your natural beauty.',
                        'children' => [
                            [
                                'name' => 'Foundations',
                                'description' => 'Foundations for a flawless base.',
                            ],
                            [
                                'name' => 'Lipsticks',
                                'description' => 'Lipsticks in various colors and finishes.',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Personal Care',
                        'description' => 'Everyday essentials for personal hygiene and care.',
                    ],
                    [
                        'name' => 'Vitamins & Supplements',
                        'description' => 'Nutritional supplements to support your overall health.',
                    ],
                    [
                        'name' => 'Fitness Equipment',
                        'description' => 'Gear and equipment to help you stay fit and active.',
                    ],
                ],
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Gear up for your next adventure with our sports and outdoor products.',
                'subcategories' => [
                    [
                        'name' => 'Exercise Equipment',
                        'description' => 'Fitness machines and tools for your home workout.',
                    ],
                    [
                        'name' => 'Outdoor Gear',
                        'description' => 'Equipment and apparel for outdoor activities and adventures.',
                    ],
                    [
                        'name' => 'Team Sports',
                        'description' => 'Everything you need for soccer, basketball, and other team sports.',
                    ],
                    [
                        'name' => 'Cycling',
                        'description' => 'Bikes, helmets, and accessories for cyclists of all levels.',
                    ],
                    [
                        'name' => 'Camping & Hiking',
                        'description' => 'Gear and supplies for camping and hiking trips.',
                    ],
                    [
                        'name' => 'Water Sports',
                        'description' => 'Equipment for kayaking, swimming, and other water activities.',
                    ],
                ],
            ],
            [
                'name' => 'Automotive',
                'description' => 'Find everything you need to keep your vehicle in top condition.',
                'subcategories' => [
                    [
                        'name' => 'Car Parts',
                        'description' => 'Replacement parts for all makes and models of vehicles.',
                    ],
                    [
                        'name' => 'Motorcycle Parts',
                        'description' => 'Parts and accessories for motorcycles of all types.',
                    ],
                    [
                        'name' => 'Car Electronics',
                        'description' => 'GPS systems, audio systems, and other electronic devices for cars.',
                    ],
                    [
                        'name' => 'Tires & Wheels',
                        'description' => 'A wide selection of tires and wheels for your vehicle.',
                    ],
                    [
                        'name' => 'Car Accessories',
                        'description' => 'Interior and exterior accessories to customize your car.',
                    ],
                    [
                        'name' => 'Car Care',
                        'description' => 'Products to clean, protect, and maintain your vehicle.',
                    ],
                ],
            ],
        ];

        DB::table('categories')->truncate();

        foreach ($parentCategories as $index => $categoryData) {
            $parentCategory = Category::create([
                'name' => $categoryData['name'],
//                'slug' => Str::slug($categoryData['name']),
                'ordering' => $index + 1,
                'is_active' => true,
                'parent_id' => null,
                'description' => $categoryData['description'],
            ]);

            // Add the image to the parent category
//            $parentCategory->addMedia(public_path($categoryData['image']))->toMediaCollection('image');

            foreach ($categoryData['subcategories'] as $i => $subcategoryData) {
                $subcategory = Category::create([
                    'name' => $subcategoryData['name'],
//                    'slug' => Str::slug($subcategoryData['name']),
                    'ordering' => ($index + 1) * 100 + $i,
                    'is_active' => true,
                    'parent_id' => $parentCategory->id,
                    'description' => $subcategoryData['description'],
                ]);
                if (isset($subcategoryData['children'])) {
                    foreach ($subcategoryData['children'] as $j => $childData) {
                        Category::create([
                            'name' => $childData['name'],
                            'ordering' => ($index + 1) * 10000 + $i * 100 + $j,
                            'is_active' => true,
                            'parent_id' => $parentCategory->id,
                            'is_child_of' => $subcategory->id,
                            'description' => $childData['description'],
                        ]);
                    }
                }
            }
        }
    }
}
