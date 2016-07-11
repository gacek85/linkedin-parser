<?php
namespace Gacek85\LinkedInCrawler\Tests\Saver;

use Faker\Factory;
use Gacek85\LinkedInCrawler\Output\DefaultOutput;
use Gacek85\LinkedInCrawler\Parser\LinkedInEntry;
use Gacek85\LinkedInCrawler\Saver\CsvSaver;
use PHPUnit_Framework_TestCase;

/**
 *  Test case for CSV saver
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class CsvSaverTest extends PHPUnit_Framework_TestCase 
{
    
    /**
     *
     * @var CsvSaver
     */
    protected $saver = null;
    
    
    protected function setUp()
    {
        $this->saver = new CsvSaver($this->getOutputPath());
    }
    
    
    public function testCanHandle ()
    {
        $null_output = new DefaultOutput(null);
        $this->assertFalse($this->saver->canHandle($null_output));
        
        $empty_output = new DefaultOutput(array());
        $this->assertFalse($this->saver->canHandle($empty_output));
        
        list($valid_data) = $this->getValidData();
        
        $valid_output = new DefaultOutput($valid_data);
        $this->assertTrue($this->saver->canHandle($valid_output));
    }
    
    
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
            array($record),
            $values
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
    
    
    protected function getOutputPath ()
    {
        return sprintf(
            '%s/../Resources/LinkedIn/csv_output.csv', 
            __DIR__
        );
    }
    
    
    public function shutDown ()
    {
        $path = $this->getOutputPath();
        if (file_exists($path)) {
            unlink($path);
        }
    }
}