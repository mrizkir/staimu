<?php

namespace App\Helpers;
class HelperAkademik {      
    /**
     * daftar semester matakuliah
     * @var type 
     */
    public static $SemesterMatakuliah = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8];
    /**
     * daftar semester matakuliah bentuk romawi
     * @var type 
     */
    public static $SemesterMatakuliahRomawi = [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII'];
    /**
     * daftar sks matakuliah
     * @var type 
     */
    public static $sks = [0=>'0',1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12'];   
}