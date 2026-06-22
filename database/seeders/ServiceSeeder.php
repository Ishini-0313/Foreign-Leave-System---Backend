<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1
        Service::create([
            'name'=> 'ශ්‍රී ලංකා පරිපාලන සේවය'
        ]);

        //2
        Service::create([
            'name'=> 'ශ්‍රී ලංකා ගණකාධිකරණ සේවය'
        ]);

        //3
        Service::create([
            'name'=> 'ශ්‍රී ලංකා ක්‍රමසම්පාදන සේවය'
        ]);

        //4
        Service::create([
            'name'=> 'ශ්‍රී ලංකා අධ්‍යාපන පරිපාලන සේවය'
        ]);

        //5
        Service::create([
            'name'=> 'ශ්‍රී ලංකා ඉංජිනේරු සේවය'
        ]);

        //6
        Service::create([
            'name'=> 'ශ්‍රී ලංකා වෛද්‍ය සේවය'
        ]);

        //7
        Service::create([
            'name'=> 'ශ්‍රී ලංකා විද්‍යාත්මක සේවය'
        ]);

        //8
        Service::create([
            'name'=> 'ශ්‍රී ලංකා ගුරු සේවය'
        ]);


        //9
        Service::create([
            'name'=> 'ශ්‍රී ලංකා කෘෂිකර්ම සේවය'
        ]);

        //10
        Service::create([
            'name'=> 'පළාත් භාෂා පරිවර්තක සේවය'
        ]);

        //11
        Service::create([
            'name'=> 'සංවර්ධන නිලධාරී සේවය'
        ]);

        //12
        Service::create([
            'name'=> 'කළමනාකරණ සේවා නිලධාරී සේවය'
        ]);

        //13
        Service::create([
            'name'=> 'ශ්‍රී ලංකා සත්ත්ව නිෂ්පාදන හා සෞඛ්‍ය සේවය'
        ]);

        //14
        Service::create([
            'name'=> 'ශ්‍රී ලංකා ආයුර්වෙද වෛද්‍ය සේවය'
        ]);

        //15
        Service::create([
            'name'=> 'ශ්‍රී ලංකා වාස්තු විද්‍යා සේවය'
        ]);

        //16
        Service::create([
            'name'=> 'ශ්‍රී ලංකා තාක්ෂණ සේවය'
        ]);

        //17
        Service::create([
            'name'=> 'රියදුරු'
        ]);

        //18
        Service::create([
            'name'=> 'කාර්යාල කාර්ය සහායක'
        ]);

        //19
        Service::create([
            'name'=> 'දෙපාර්තමේන්තුගත'
        ]);

        //20
        Service::create([
            'name'=> 'තොරතුරු හා සන්නිවේදන තාක්ෂණ නිළධාරී සේවය'
        ]);

        //21
        Service::create([
            'name'=> 'ශ්‍රී ලංකා පුස්තකාලාධිපති සේවය'
        ]);

        //22
        Service::create([
            'name'=> 'ශ්‍රී ලංකා මිනින්දෝරු සේවය'
        ]);
    }
}
