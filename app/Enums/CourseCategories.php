<?php

namespace App\Enums;

enum CourseCategories : string
{
    case ArchitectureBuildingPlanning = 'architecture_building_planning';
    case ArtAndDesign = 'art_and_design';
    case BusinessAndManagement = 'business_and_management';
    case Commerce = 'commerce';
    case ComputerScienceAndIT = 'computer_science_and_it';
    case CulinaryArts = 'culinary_arts';
    case EducationAndTraining = 'education_and_training';
    case Engineering = 'engineering';
    case HairBeautyAndPersonalCare = 'hair_beauty_and_personal_care';
    case HealthSciences = 'health_sciences';
    case HealthCareAndMedicine = 'health_care_and_medicine';
    case Humanities = 'humanities';
    case InformationScienceAndMathematics = 'information_science_and_mathematics';
    case LandAndEnvironment = 'land_and_environment';
    case LanguageProgrammes = 'language_programmes';
    case Law = 'law';
    case MediaJournalismCommunication = 'media_journalism';
    case MilitaryStudies = 'military_studies';
    case Music = 'music';
    case Nursing = 'nursing';
    case ScienceAndMathematics = 'science_and_mathematics';
    case SocialStudies = 'social_studies';
    case Sports = 'sports';
    case TravelAndTourismHospitality = 'travel_and_tourism_hospitality';
    case VocationalCourses = 'vocational_courses';
    case AccountingAndMarketing = 'accounting_and_marketing';
    case Agriculture = 'agriculture';




    public function getLabel(): string
    {
        return match ($this) {
            self::ArchitectureBuildingPlanning => 'Architecture, Building and Planning',
            self::ArtAndDesign => 'Art and Design',
            self::BusinessAndManagement => 'Business and Management',
            self::Commerce => 'Commerce',
            self::ComputerScienceAndIT => 'Computer Science and IT',
            self::CulinaryArts => 'Culinary Arts',
            self::EducationAndTraining => 'Education and Training',
            self::Engineering => 'Engineering',
            self::HairBeautyAndPersonalCare => 'Hair, Beauty and Personal Care',
            self::HealthSciences => 'Health Sciences',
            self::HealthCareAndMedicine => 'Healthcare and Medicine',
            self::Humanities => 'Humanities',
            self::InformationScienceAndMathematics => 'Information Science and Mathematics',
            self::LandAndEnvironment => 'Land and Environment',
            self::LanguageProgrammes => 'Language Programmes',
            self::Law => 'Law',
            self::MediaJournalismCommunication => 'Media/Journalism/Communication',
            self::MilitaryStudies => 'Military Studies',
            self::Music => 'Music',
            self::Nursing => 'Nursing',
            self::ScienceAndMathematics => 'Science and Mathematics',
            self::SocialStudies => 'Social Studies and Communication',
            self::Sports => 'Sports',
            self::TravelAndTourismHospitality => 'Travel, Tourism and Hospitality',
            self::VocationalCourses => 'Vocational Courses',
            self::AccountingAndMarketing => 'Accounting and Marketing',
            self::Agriculture => 'Agriculture',
        };
    }

}
