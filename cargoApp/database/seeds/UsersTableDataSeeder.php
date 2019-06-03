<?php

use Illuminate\Database\Seeder;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' =>'faten',
            'email' =>'faten@yahoo.com',
            'password' => bcrypt('12345678'),
        ]);
        for ($i=1; $i < 6; $i++) {

	    	User::create([

	            'name' => str_random(8),

	            'email' => str_random(12).'@mail.com',

	            'password' => bcrypt('123456')

	        ]);

    	}
    }
}
