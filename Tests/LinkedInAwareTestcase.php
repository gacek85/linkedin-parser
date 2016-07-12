<?php
namespace Gacek85\LinkedInCrawler\Tests;

use Faker\Factory;
use Gacek85\LinkedInCrawler\Output\DefaultOutput;
use Gacek85\LinkedInCrawler\Parser\LinkedInEntry;
use PHPUnit_Framework_TestCase;

/**
 *  Testcase abstraction for LinkedIn aware entries
 *
 *  @author Maciej Garycki <maciej@neverbland.com>
 *  @company Neverbland
 *  @copyrights Neverbland 2015
 */
abstract class LinkedInAwareTestcase extends PHPUnit_Framework_TestCase
{
    protected function getValidData ()
    {
        $record = new LinkedInEntry();
        $values = $this->getValues();
        $record
                ->setName($values['name'])
                ->setFirstName($values['first_name'])
                ->setLastName($values['last_name'])
                ->setTitle($values['title'])
                ->setSummary($values['summary'])
                ->setLocation($values['location'])
                ->setCountry($values['country'])
                ->setIndustry($values['industry'])
                ->setPicture($values['picture'])
                ->setSkills($values['skills'])
                ->setPastCompanies($values['past_companies'])
                ->setCurrentCompanies($values['current_companies'])
                ->setOrganizations($values['organizations'])
                ->setEducation($values['education'])
                ->setWebsites($values['websites'])
                ->setGroups($values['groups'])
                ->setLanguages($values['languages'])
                ->setCertifications($values['certifications'])
        ;
        
        return array(
            new DefaultOutput(array($record)),
            $values,
            $record
        );
    }
    
    
    protected function getValues ()
    {
        $faker = Factory::create();
        return array(
            'name' => $faker->name,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'title' => $faker->title,
            'summary' => $faker->text,
            'location' => $faker->city,
            'country' => $faker->country,
            'industry' => $faker->sentence(3),
            'picture' => $faker->imageUrl(200, 200),
            'skills' => $faker->words(5),
            'past_companies' => array(
                array(
                    'name' => $faker->company,
                    'description' => $faker->sentence(5),
                    'date' => $faker->date(),
                    'location' => $faker->city
                )
            ),
            'current_companies' => array(
                array(
                    'name' => $faker->company,
                    'description' => $faker->sentence(5),
                    'date' => $faker->date(),
                    'location' => $faker->city
                )
            ),
            'organizations' => array(),
            'education' => array(
                array(
                    'name' => $faker->company,
                    'description' => $faker->sentence(10),
                    'date' => $faker->date()
                )
            ),
            'websites' => array(),
            'groups' => array(),
            'languages' => array(
                array(
                    'language' => $faker->country,
                    'proficiency' => $faker->word,
                )
            ),
            'certifications' => array(
                array(
                    'name' => $faker->company,
                    'authority' => $faker->company,
                    'license' => $faker->sentence(5),
                    'date' => $faker->date()
                )
            ),
        );
    }
}