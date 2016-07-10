<?php
namespace Gacek85\LinkedInCrawler\Tests\Parser;

use Gacek85\LinkedInCrawler\Parser\LinkedInDocumentParser;
use Gacek85\LinkedInCrawler\Parser\LinkedInEntry;

/**
 *  Test case for LinkedInDocumentParser
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class LinkedInDocumentParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var LinkedInDocumentParser
     */
    protected $parser = null;
    
    
    protected function setUp()
    {
        $this->parser = new LinkedInDocumentParser();
    }
    
    
    /**
     * Test case for the parse method
     */
    public function testParse ()
    {
        $html = $this->getSampleHtml();
        $entry = $this
                    ->parser
                    ->parse($html)
        ;
        
        $this->assertInstanceOf(get_class(new LinkedInEntry()), $entry);
        $this->assertFields($entry);
    }
    
    
    protected function getSampleHtml ()
    {
        $html = file_get_contents($this->getSampleHtmlPath());
        return $html;
    }
    
    
    protected function getSampleHtmlPath ()
    {
        return sprintf('%s/../Resources/LinkedIn/sample.html', __DIR__);
    }
    
    
    protected function assertFields (LinkedInEntry $entry = null)
    {
        if ($entry === null) {
            return;
        }
        
        $this->assertEquals('Sample User', $entry->getName());
        $this->assertEquals('Sample', $entry->getFirstName());
        $this->assertEquals('User', $entry->getLastLame());
        $this->assertEquals('Frontend Developer', $entry->getTitle());
        $this->assertEquals('Warsaw', $entry->getLocation());
        $this->assertEquals('Poland', $entry->getCountry());
        $this->assertEquals('Marketing and Advertising', $entry->getIndustry());
        $this->assertEquals('Test summary', $entry->getSummary());
        $this->assertEquals('https://media.licdn.com/mpr/mpr/shrinknp_400_400/test.jpg', $entry->getPicture());
        
        $skills = array(
            'Flash',
            'Web Design',
            'User Experience',
            'Art Direction',
            'Interaction Design',
            'Graphic Design',
            'JavaScript',
            'jQuery',
            'HTML 5',
            'HTML',
            'CSS3',
            'Advanced CSS',
            'Cross-browser Compatibility',
            'Creative Problem Solving',
            'Organization & prioritization skills',
            'Multi Tasking',
            'Intuition',
            'Deductive Reasoning',
            'Patience',
            'Highly motivated self-starter',
            'Communication Skills',
        );
        
        $this->assertEquals($skills, $entry->getSkills());
        
        $past_companies = array(
            array(
                'name' => 'Juice.pl',
                'description' => 'PSD to HTML slicing, Webpage/app frontend user experience building (javascript/jquery/html5/css3), Maintaining projects cross-platform consistency, Coordinating with backend team, Creating Flash project with AS3.',
                'date' => 'listopad 2012 - styczeń 2014',
                'location' => 'Wroclaw, Lower Silesian District, Polska',
            ),
            array(
                'name' => 'MediaMind',
                'description' => 'Troubleshooting and fixing Javascript and HTML5 issues on upcoming and live media campaign ads. Dedicated support for MediaArtLab for their campaigns across Europe and Asia, tight cooperation with development, creative and management team. Creating HTML5 ads templates. As part of Special Project team: fixing, maintaining and creating new scripts for use by support team. Pure javascript coding, heavy cross-platform/browser, working to tight schedules.',
                'date' => 'marzec 2011 - październik 2012',
                'location' => 'Dublin, Ireland',
            ),
            array(
                'name' => '83 Degrees South',
                'description' => 'Key roles: Development lead on creating web portals. Creating/adjusting requirement documents and wireframes. Developing html/css/jquery templates for master-pages. Coordination of the workflow with backend development team. PSD to HTML slicing. Skills: HTML, CSS, javascript - AJAX (jQuery), Java, PhotoShop, Illustrator',
                'date' => 'listopad 2010 - marzec 2011',
                'location' => 'Dublin',
            ),
            array(
                'name' => 'Gravitate Interactive',
                'description' => 'Key roles: Design and development of dynamic internet portals and Flash websites with Wordpress, jQuery and ActionScript 3. Using jQuery to modify existing plugins, and creating jQuery elements. Developing xml driven flash websites. Coding and recoding xhtml/css websites to meet cross-browser requirements (PC/MAC) Creating Wordpress Themes. Skills: ActionScript, PhotoShop, Dreamweaver, Javascript/JQuery, wordpress, HTML, CSS',
                'date' => 'wrzesień 2010 - listopad 2010',
                'location' => 'Dublin',
            ),
            array(
                'name' => 'Orange/GOA Games Services',
                'description' => 'Key roles: Work on WARHAMMER ONLINE project for Europe [portal, forum, mailing]. Portal elements integrity control, designing forum layouts, designing and coding of portal and mailing elements. Lead role on the new Goa.com portal project. Sketch and developement of subpages and main graphic elements of new portal. Design and developement of new informational minisite. Work on different aspects of games promotions. Skills: PhotoShop, Illustrator, Flash, HTML, javascript - AJAX (jQuery), ActionScript',
                'date' => 'wrzesień 2008 - wrzesień 2009',
                'location' => 'Dublin, Ireland',
            ),
            array(
                'name' => 'eircom',
                'description' => 'Key roles: Project of new EIRCOM.NET portal. Tight cooperation of 3 people team of web developers as a leader. Design and development according to regorious styleguide and tight deadlines. Skills: PhotoShop, HTML, javascript - AJAX (jQuery), PHP/MySQL',
                'date' => 'czerwiec 2008 - wrzesień 2008',
                'location' => 'Dublin',
            ),
            array(
                'name' => 'Interactive Services',
                'description' => 'Key roles: Design and developement of interactive e-learning applications for PricewaterhouseCoopers. Skills: Photoshop, Illustrator, Flash, ActionScript',
                'date' => 'styczeń 2008 - maj 2008',
                'location' => 'Dublin',
            ),
            array(
                'name' => 'Aarado.ie',
                'description' => 'Key roles: Design and developement of internet wesites for small and middle enterprises. Print designs for small and medium size. Skills: HTML, javascript - AJAX (jQuery), CMS, Flash, ActionScript, PhotoShop, Illustrator',
                'date' => 'czerwiec 2007 - grudzień 2007',
                'location' => 'Dublin',
            ),
            array(
                'name' => 'Selfemployed',
                'description' => 'Key roles: Design and developement of websites, logotypes and illustrations for individual clients. Skills: \\ PhotoShop, Illustrator, Flash, ActionScript, HTML',
                'date' => 'sierpień 2006 - kwiecień 2007',
                'location' => 'Barcelona',
            ),
            array(
                'name' => 'Community',
                'description' => 'Key roles: Design of internet banners, prints and branding materials. Skills: PhotoShop, Illustrator, Flash, ActionScript, HTML',
                'date' => 'luty 2006 - lipiec 2006',
                'location' => 'Wroclaw, Lower Silesian District, Polska',
            ),
            array(
                'name' => 'PPR',
                'description' => 'Key roles: Design and developement of internet wesites for small and middle enterprises. Skills: Flash, PhotoShop, Illustrator, ActionScript, HTML',
                'date' => 'czerwiec 2004 - grudzień 2005',
                'location' => 'Wroclaw, Lower Silesian District, Polska',
            ),
        );
        $this->assertEquals($past_companies, $entry->getPastCompanies());
        
        
        $current_companies = array (
            array (
                'name' => 'PZU',
                'description' => $this->fixString(''),
                'date' => 'czerwiec 2014',
                'location' => 'Warsaw, Masovian District, Poland',
            ),
        );
        
        $this->assertEquals($current_companies, $entry->getCurrentCompanies());
        
        $education = array(
            array (
              'name' => 'Higher School of information Technology and Management "COPERNICUS" in Wroclaw',
              'description' => 'Bachelor of Engineering (B.E.), Information Technology',
              'date' => '2009 – 2012',
            ),
            array (
              'name' => 'Uniwersytet Wrocławski',
              'description' => 'Master of Science (M.S.), Biology/Biological Sciences, General',
              'date' => '2000 – 2005',
            ),
            array (
              'name' => 'LO Wieluń',
              'description' => '',
              'date' => '',
            ),
        );
        
        $this->assertEquals($education, $entry->getEducation());
        
        
        $websites = array();
        
        $this->assertEquals($websites, $entry->getWebsites());
        
        $languages = array(
            array (
              'language' => 'English',
              'proficiency' => 'Fluent business knowledge',
            ),
            array (
              'language' => 'Polish',
              'proficiency' => 'Native',
            ),    
        );
        
        $this->assertEquals($languages, $entry->getLanguages());
        
        $certifications = array();
        
        $this->assertEquals($certifications, $entry->getCertifications());
        
    }
    
    
    protected function fixString ($input_str) 
    {
        return trim(preg_replace('/\s+/', ' ', $input_str));
    }
}