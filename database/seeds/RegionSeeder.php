<?php

use App\Support\CsvReader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->seedPropinsi();
		$this->seedKabupaten();
		$this->seedKecamatan();
		$this->seedKelurahan();
	}

	public function seedPropinsi()
	{
		$table = 'TBLPropinsi';
		DB::table($table)->truncate();
		CsvReader::read(database_path('data/provinces.csv'), function($values) use ($table) {
			DB::table($table)->insert([
				'KdPropinsi' => $values[0],
				'NmPropinsi' => $values[1],
			]);
		});
	}

	public function seedKabupaten()
	{
		$table = 'TBLKabupaten';
		DB::table($table)->truncate();
		CsvReader::read(database_path('data/regencies.csv'), function($values) use ($table) {
			DB::table($table)->insert([
				'KdKabupaten' => $values[0],
				'KdPropinsi' => $values[1],
				'NmKabupaten' => $values[2],
			]);
		});
	}

	public function seedKecamatan()
	{
		$table = 'TBLKecamatan';
		DB::table($table)->truncate();
		CsvReader::read(database_path('data/districts.csv'), function($values) use ($table) {
			DB::table($table)->insert([
				'KdKecamatan' => $values[0],
				'KdKabupaten' => $values[1],
				'NmKecamatan' => $values[2],
			]);
		});
	}


	public function seedKelurahan()
	{
		$table = 'TBLKelurahan';
		DB::table($table)->truncate();
		CsvReader::read(database_path('data/villages.csv'), function($values) use ($table) {
			DB::table($table)->insert([
				'KdKelurahan' => $values[0],
				'KdKecamatan' => $values[1],
				'NmKelurahan' => $values[2],
			]);
		});
	}
}
