<?php
namespace Gacek85\LinkedInCrawler\Parser;

use DOMAttr;
use DOMDocument;
use DOMNode;
use DOMXPath;
use Gacek85\LinkedInCrawler\Parser\LinkedInEntry;
use Symfony\Component\CssSelector\CssSelector as CSS;

/**
 *  Parses LinkedIn HTML code to fetch dataset
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class LinkedInDocumentParser 
{
    
    private $html = null;
    
    private $dom = null;
    
    private $parts = array();




    /**
     * Parses the HTML returning a POPO object
     * 
     * @param       string          $html
     * @return      LinkedInEntry
     */
    public function parse ($html)
    {
        libxml_use_internal_errors(true);
        $this->html = $html;
        $this->dom = null;
        $this->parts = array();
        
        $entry = new LinkedInEntry();
        $this->populate($entry);
        libxml_use_internal_errors(false);
        
        return $entry;
    }
    
    
    protected function populate (LinkedInEntry $entry)
    {
        $name = $this->findName();
        $first_name = $this->findFirstName();
        $last_name = $this->findLastName();
        $title = $this->findTitle();
        $location = $this->findLocation();
        $country = $this->findCountry();
        $industry = $this->findIndustry();
        $summary = $this->findSummary();
        $picture = $this->findPicture();
        $skills = $this->findSkills();
        $past_companies = $this->findPastCompanies();
        $current_companies = $this->findCurrentCompanies();
        $education = $this->findEducation();
        $websites = $this->findWebsites();
        $languages = $this->findLanguages();
        $certifications = $this->findCertifications();
        
        $entry
                ->setName($name)
                ->setFirstName($first_name)
                ->setLastName($last_name)
                ->setTitle($title)
                ->setLocation($location)
                ->setCountry($country)
                ->setIndustry($industry)
                ->setSummary($summary)
                ->setPicture($picture)
                ->setSkills($skills)
                ->setPastCompanies($past_companies)
                ->setCurrentCompanies($current_companies)
                ->setEducation($education)
                ->setWebsites($websites)
                ->setLanguages($languages)
                ->setCertifications($certifications)
        ;
    }
    
    
    protected function findEducation ()
    {
        $results = array();
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('.background-education .education'));
        
        for ($i = 0; $i < $elements->length; $i++) {
            $element = $elements->item($i);
            $results[] = array(
                'name' => $this->getValuePart($element, 'h4'),
                'description' => $this->fixDescription($this->getValuePart($element, 'h5')),
                'date' => $this->getValuePart($element, '.education-date')
            );
        }
        
        return $results;
    }
    
    
    protected function findCertifications ()
    {
        $results = array();
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('.background-certifications'));
        
        for ($i = 0; $i < $elements->length; $i++) {
            $element = $elements->item($i);
            $results[] = array(
                'name' => $this->getValuePart($element, 'h4'),
                'authority' => $this->getValuePart($element, 'h5'),
                'license' => $this->getValuePart($element, '.specifics, .licence-number'),
                'date' => $this->getValuePart($element, '.certification-date'),
            );
        }
        
        return $results;
    }




    protected function findLanguages ()
    {
        $results = array();
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('#languages ol li'));
        for ($i = 0; $i < $elements->length; $i++) {
            $element = $elements->item($i);
            $results[] = array(
                'language' => $this->getValuePart($element, 'h4'),
                'proficiency' => $this->getValuePart($element, 'div.languages-proficiency'),
            );
        }
       
        return $results;
    }
    
    
    protected function getValuePart (DOMNode $element, $part_selector)
    {
        $xpath = new DOMXPath($this->dom);
        $name_node_xpath = $this->toXpath($part_selector);
        $name_nodes = $xpath->query($name_node_xpath, $element);
        if (!$name_nodes->length) {
            return '';
        }
        $name_node = $name_nodes->item(0);
        
        return trim($name_node->nodeValue);
    }
    
    
    
    
    protected function findPastCompanies ()
    {
        return $this->findCompanies('past');
    }
    
    
    protected function findCurrentCompanies ()
    {
        return $this->findCompanies('current');
    }
    
    
    protected function findWebsites ()
    {
        // @todo: implement
        return array();
    }
    
    
    protected function findCompanies ($type)
    {
        $results = array();
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath(sprintf('.background-experience .%s-position', $type)));
        
        for ($i = 0; $i < $elements->length; $i++) {
            /* @var $name_element DOMNode */
            /* @var $description_element DOMNode */
            /* @var $date_element DOMNode */
            
            $element = $elements->item($i);
            
           
            $results[] = array(
                'name' => $this->getCompanyName($element),
                'description' => $this->getDescriptionText($element),
                'date' => $this->getDatePart($element),
                'location' => $this->getLocationPart($element)
            ); 
        }
        
        return $results;
    }
    
    
    protected function getCompanyName (DOMNode $element)
    {
        return $this->getValuePart($element, 'h5:not(.experience-logo)');
    }
    
    
    protected function getDescriptionText (DOMNode $element)
    {
        $xpath = new DOMXPath($this->dom);
        $descr_xpath = $this->toXpath('.description');
        $descr_nodes = $xpath->query($descr_xpath, $element);
        if ($descr_nodes->length) {
            $description_node = $descr_nodes->item(0);
            return $this->fixDescription($description_node->nodeValue);
        } else {
            return '';
        }
    }
    
    
    protected function fixDescription ($description_text)
    {
        return trim(preg_replace('/\s+/', ' ', $description_text));
    }
    
    
    protected function getDatePart (DOMNode $element)
    {
        $xpath = new DOMXPath($this->dom);
        $date_nodes_xpath = $this->toXpath('.experience-date-locale');
        $date_elements = $xpath->query($date_nodes_xpath, $element);
        if (!$date_elements->length) {
            return null;
        }
        $date_element = $date_elements->item(0);
        
        $results = array();
        $child_nodes = $date_element->childNodes;
        for ($i = 0; $i < $child_nodes->length; $i++) {
            /* @var $child DOMNode */
            $child = $child_nodes->item($i);
            if ($child->nodeName === 'time') {
                $results[] = $child->nodeValue;
            }
        }
        
        return count($results) ? join(' - ', $results) : null;
    }
    
    
    protected function getLocationPart (DOMNode $element)
    {
        $xpath = new DOMXPath($this->dom);
        $date_nodes_xpath = $this->toXpath('.experience-date-locale');
        $date_elements = $xpath->query($date_nodes_xpath, $element);
        if (!$date_elements->length) {
            return null;
        }
        $date_element = $date_elements->item(0);
        
        $child_nodes = $date_element->childNodes;
        for ($i = 0; $i < $child_nodes->length; $i++) {
            /* @var $child DOMNode */
            $child = $child_nodes->item($i);
            if ($child->nodeName === 'span') {
                return trim($child->nodeValue);
            }
        }
        
        return null;
    }


    
    protected function findSkills ()
    {
        $results = array();
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('#profile-skills [data-endorsed-item-name]'));

        for ($i = 0; $i < $elements->length; $i++) {
            /* @var $element DOMNode */
            $element = $elements->item($i);
            $attributes = $element->attributes;
            for ($j = 0; $j < $attributes->length; $j++) {
                /* @var $attr DOMAttr */
                $attr = $attributes->item($j);
                if ($attr->nodeName === 'data-endorsed-item-name') {
                    $results[] = trim($attr->nodeValue);
                }
            }
        }
        
        return $results;
    }
    
    
    
    protected function findPicture ()
    {
        if (!array_key_exists('picture', $this->parts)) {
            $this->parts['picture'] = $this->doFindPicture();
        }
        
        return $this->parts['picture'];
    }
    
    
    protected function doFindPicture ()
    {
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('.profile-picture img'));
        /* @var $element DOMNode */
        $element = $elements->item(0);
        if (!$element) {
            return '';
        }
        $attributes = $element->attributes;
        
        for ($i = 0; $i < $attributes->length; $i++) {
            /* @var $attr DOMAttr */
            $attr = $attributes->item($i);
            if ($attr->nodeName === 'src') {
                return $attr->nodeValue;
            }
        }
        
        return '';
    }
    
    
    protected function findSummary ()
    {
        if (!array_key_exists('summary', $this->parts)) {
            $this->parts['summary'] = $this->doFindSummary();
        }
        
        return $this->parts['summary'];
    }
    
    
    protected function doFindSummary ()
    {
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('.summary .description'));
        /* @var $element DOMNode */
        $element = $elements->item(0);
        if (!$element) {
            return '';
        }
        $text = $element->nodeValue;
        
        return $this->fixDescription($text);
    }
    
    
    protected function findTitle ()
    {
        if (!array_key_exists('title', $this->parts)) {
            $this->parts['title'] = $this->doFindTitle();
        }
        
        return $this->parts['title'];
    }
    
    
    protected function doFindTitle ()
    {
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('.title'));
        /* @var $element DOMNode */
        $element = $elements->item(0);
        if (!$element) {
            return '';
        }
        $text = $element->nodeValue;
        
        return trim($text);
    }
    
    protected function findIndustry ()
    {
        if (!array_key_exists('industry', $this->parts)) {
            $this->parts['industry'] = $this->doFindIndustry();
        }
        
        return $this->parts['industry'];
    }
    
    
    protected function doFindIndustry ()
    {
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('.industry'));
        /* @var $element DOMNode */
        $element = $elements->item(0);
        if (!$element) {
            return '';
        }
        $text = $element->nodeValue;
        
        return trim($text);
    }
    
    
    protected function findLocation ()
    {
        if (!array_key_exists('location', $this->parts)) {
            $this->parts['location'] = $this->doFindLocation();
        }
        $exploded = explode(',', $this->parts['location']);
        
        return trim($exploded[0]);
    }
    
    
    protected function findCountry ()
    {
        if (!array_key_exists('location', $this->parts)) {
            $this->parts['location'] = $this->doFindLocation();
        }
        $exploded = explode(',', $this->parts['location']);
        
        return trim(end($exploded));
    }




    protected function doFindLocation ()
    {
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('#location .locality'));
        /* @var $element DOMNode */
        $element = $elements->item(0);
        if (!$element) {
            return '';
        }
        $text = $element->nodeValue;
        
        return trim($text);
    }
    
    
    protected function doFindName ()
    {
        $dom = $this->getDom();
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($this->toXpath('title'));
        /* @var $element DOMNode */
        $element = $elements->item(0);
        if (!$element) {
            return '';
        }
        $text = $element->nodeValue;
        $exploded = explode('|', $text);
        
        return trim($exploded[0]);
    }
    
    
    protected function findFirstName ()
    {
        $name = $this->findName();
        $exploded = explode(' ', $name);
        
        if (count($exploded) === 2) {
            return $exploded[0];
        } elseif (count($exploded) === 3) {
            return sprintf('%s %s', $exploded[0], $exploded[1]);
        }
    }


    protected function findLastName ()
    {
        $name = $this->findName();
        $exploded = explode(' ', $name);
        
        return end($exploded);
    }
    

    protected function findName ()
    {
        if (!array_key_exists('name', $this->parts)) {
            $this->parts['name'] = $this->doFindName();
        }
        
        return $this->parts['name'];
    }
    
    
    protected function getDom ()
    {
        if ($this->dom === null) {
            $this->dom = $this->doGetDom();
        }
        
        return $this->dom;
    }
    
    
    protected function doGetDom ()
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->strictErrorChecking = false;
        $dom->loadHTML($this->html);
        
        return $dom;
    }

    
    protected function toXpath ($css_locator)
    {
        return CSS::toXPath($css_locator);
    }
    
}