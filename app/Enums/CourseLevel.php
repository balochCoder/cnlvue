<?php

namespace App\Enums;

enum CourseLevel: string
{
    case AdvancedDiploma = 'advanced_diploma';
    case AppliedDegree = 'applied_degree';
    case UG = 'ug';
    case Certificate = 'certificate';
    case Coaching = 'coaching';
    case Diploma = 'diploma';
    case Foundation = 'foundation';
    case GraduateCertificate = 'graduate_certificate';
    case Masters = 'masters';
    case PHD = 'phd';
    case PostDoctorate = 'post_doctorate';
    case SummerSchool = 'summer_school';
    case Others = 'others';



    public function getLabel(): string
    {
        return match ($this) {
            self::AdvancedDiploma => __('Advanced Diploma'),
            self::AppliedDegree => __('Applied Degrees'),
            self::UG => __('Bachelors/UG'),
            self::Certificate => __('Certificate'),
            self::Coaching => __('Coaching/Preparing Courses'),
            self::Diploma => __('Diploma'),
            self::Foundation => __('Foundation'),
            self::GraduateCertificate => __('Graduate Certificate'),
            self::Masters => __('Masters/PG'),
            self::PHD => __('Phd/Doctorate'),
            self::PostDoctorate => __('Post-Doctorate'),
            self::SummerSchool => __('Summer School'),
            self::Others => __('Others'),
        };
    }

    public static function getLabelBlade($value): string
    {
        return match ($value) {
            self::AdvancedDiploma => __('Advanced Diploma'),
            self::AppliedDegree => __('Applied Degrees'),
            self::UG => __('Bachelors/UG'),
            self::Certificate => __('Certificate'),
            self::Coaching => __('Coaching/Preparing Courses'),
            self::Diploma => __('Diploma'),
            self::Foundation => __('Foundation'),
            self::GraduateCertificate => __('Graduate Certificate'),
            self::Masters => __('Masters/PG'),
            self::PHD => __('Phd/Doctorate'),
            self::PostDoctorate => __('Post-Doctorate'),
            self::SummerSchool => __('Summer School'),
            self::Others => __('Others'),
        };
    }
}
