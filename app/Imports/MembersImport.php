<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\Profile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class MembersImport implements
ToModel,
WithStartRow,
WithLimit,
WithColumnLimit,
SkipsEmptyRows,
WithChunkReading,
WithBatchInserts
{
   use Importable;

   public function model(array $row)
   {  // A B C D E F G H I J K   L   M   N   O   P   Q   R   S   T   U
      // 0 1 2 3 4 5 6 7 8 9 10  11  12  13  14  15  16  17  18  19  20
      $member = Member::create([
         'id'=>$row[1], // B the id is the same as member id
         'level'=>$row[2], // C
         'first_name'=>trim($row[3]) . ' ', // D
         'second_name'=>$row[4] ? trim($row[4]) . ' ' : null, // E
         'third_name'=>$row[5] ? trim($row[5]) . ' ' : null, // F
         'fourth_name'=>$row[6] ? trim($row[6]) . ' ' : null, // G
         'family_name'=>trim($row[7]), // H
         'gender'=>$row[8], // I
         'is_alive'=> $row[9] == 0 ? 0 : 1, // J
         'parent_id'=>$row[10], // K
         'mother_id'=>$row[11], // L
         'siblings_order'=>$row[15], // P
         'husband_id' => $row[13], // N
         'is_husband_from_outside' => $row[16], // Q
         'mobile' => $row[19], // T
         'city' => $row[20], // U
      ]);
   }

   public function startRow(): int
   {
      return 2;
   }

   public function endColumn(): string
   {
      return "U";
   }

   public function chunkSize(): int
   {
      return 100;
   }

   public function batchSize(): int
   {
      return 200;
   }

   public function limit(): int
   {
      return 100;
   }
}
