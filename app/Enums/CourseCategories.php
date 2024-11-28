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
            self::ArchitectureBuildingPlanning => __('Architecture, Building and Planning'),
            self::ArtAndDesign => __('Art and Design'),
            self::BusinessAndManagement => __('Business and Management'),
            self::Commerce => __('Commerce'),
            self::ComputerScienceAndIT => __('Computer Science and IT'),
            self::CulinaryArts => __('Culinary Arts'),
            self::EducationAndTraining => __('Education and Training'),
            self::Engineering => __('Engineering'),
            self::HairBeautyAndPersonalCare => __('Hair, Beauty and Personal Care'),
            self::HealthSciences => __('Health Sciences'),
            self::HealthCareAndMedicine => __('Healthcare and Medicine'),
            self::Humanities => __('Humanities'),
            self::InformationScienceAndMathematics => __('Information Science and Mathematics'),
            self::LandAndEnvironment => __('Land and Environment'),
            self::LanguageProgrammes => __('Language Programmes'),
            self::Law => __('Law'),
            self::MediaJournalismCommunication => __('Media/Journalism/Communication'),
            self::MilitaryStudies => __('Military Studies'),
            self::Music => __('Music'),
            self::Nursing => __('Nursing'),
            self::ScienceAndMathematics => __('Science and Mathematics'),
            self::SocialStudies => __('Social Studies and Communication'),
            self::Sports => __('Sports'),
            self::TravelAndTourismHospitality => __('Travel, Tourism and Hospitality'),
            self::VocationalCourses => __('Vocational Courses'),
            self::AccountingAndMarketing => __('Accounting and Marketing'),
            self::Agriculture => __('Agriculture'),
        };
    }


}
