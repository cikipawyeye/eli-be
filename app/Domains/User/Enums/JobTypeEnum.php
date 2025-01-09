<?php

declare(strict_types=1);

namespace App\Domains\User\Enums;

use App\Support\Traits\EnumTrait;

enum JobTypeEnum: string
{
    use EnumTrait;

    case Other = '0';
    case Student = '1'; // Pelajar
    case CollegeStudent = '2'; // Mahasiswa
    case GovernmentEmployee = '3'; // Pegawai Negeri (ASN)
    case PrivateEmployee = '4'; // Pegawai Swasta/Karyawan Swasta
    case Professional = '5'; // Profesional/Ahli
    case Housewife = '6'; // Ibu Rumah Tangga
    case Entrepreneur = '7'; // Wiraswasta/Pengusaha
    case Unemployed = '8'; // Tidak Bekerja

    public function translated(): string
    {
        return match ($this->value) {
            self::Other->value => __('app.other'),
            self::Student->value => __('app.student'),
            self::CollegeStudent->value => __('app.college_student'),
            self::GovernmentEmployee->value => __('app.government_employee'),
            self::PrivateEmployee->value => __('app.private_employee'),
            self::Professional->value => __('app.professional'),
            self::Housewife->value => __('app.housewife'),
            self::Entrepreneur->value => __('app.entrepreneur'),
            self::Unemployed->value => __('app.unemployed'),
            default => $this->name,
        };
    }
}
